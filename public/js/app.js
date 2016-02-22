angular.module('app', ['toaster', 'ngAnimate'], function($interpolateProvider) {
        //change angular default interpolate symbol to '<% %>', allow angular to work with laravel blade engine
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .controller('InventoryController', InventoryController);

InventoryController.$inject = ['$scope', '$http', '$timeout', 'toaster'];

function InventoryController($scope, $http, $timeout, toaster) {

    var vm        = this, //ViewModel
        mytimeout = null; //the current timeoutID

    vm.inventoryHistory = [];
    vm.inventory = [];
    vm.counter = -1;

    vm.loadInventory = loadInventory;
    vm.addItem = addItem;
    vm.removeItem = removeItem;
    vm.startTimer = startTimer;
    vm.onTimeout = onTimeout;
    vm.stopTimer = stopTimer;

    vm.loadInventory();

    function loadInventory() {
        $http.get('/api/v1/item').success(function(data) {
            vm.inventory = data.items;
            getNextExpire(vm.inventory);
        }).error(function(response, status, headers, config) {
            toaster.error("API ERROR")
        });

        $http.get('/api/v1/item/1').success(function(data) {
            vm.debug = data.items;
        }).error(function(response, status, headers, config) {
            toaster.error("API ERROR")
        });

    }

    function getNextExpire(obj) {
        var next     = null,
            nextItem = {};
        angular.forEach(obj, function(item, index) {
            var expire_at   = new Date(item.expire_at),
                diffSeconds = (expire_at - new Date()) / 1000;
            if( next === null ) {
                next = diffSeconds;
            }
            if( diffSeconds < next && diffSeconds > 0 ) {
                next = diffSeconds;
                nextItem = item;
            }
        });
        vm.stopTimer();
        if( next !== null ) {
            vm.counter = Math.round(next);
            vm.nextItem = nextItem;
            vm.startTimer();
        }
    }

    function addItem() {
        $http.post(
            '/api/v1/item',
            {
                'label':     vm.label,
                'type':      vm.type,
                'event':     'add',
                'expire_at': vm.expire_at
            }
        ).success(function(data) {
            toaster.success("Item Added", vm.label);
        });

        loadInventory();

        vm.inventoryHistory.push({ "itemAdded": vm.label });

        vm.label = '';
        vm.type = '';
        vm.expire_at = '';
    }

    function removeItem(key) {
        $http.post(
            '/api/v1/item',
            {
                'itemID':    vm.inventory[key].itemID,
                'label':     vm.inventory[key].label,
                'type':      vm.inventory[key].type,
                'event':     'remove',
                'expire_at': vm.inventory[key].expire_at
            }
        ).success(function(data) {
            toaster.warning("Item Removed", vm.inventory[key].label);
        });

        vm.inventoryHistory.push({ "itemRevmoved": vm.inventory[key] });

        loadInventory();

    }

    // actual timer method, counts down every second, stops on zero
    function onTimeout() {
        if( vm.counter <= 0 ) {
            $scope.$broadcast('timer-stopped', 0);
            $timeout.cancel(mytimeout);
            return;
        }
        vm.counter--;
        mytimeout = $timeout(vm.onTimeout, 1000);
    }

    //start timer
    function startTimer() {
        mytimeout = $timeout(vm.onTimeout, 1000);
    }

    // stops and resets the current timer
    function stopTimer() {
        $timeout.cancel(mytimeout);
        vm.counter = -1;
    }

    // triggered, when the timer stops
    $scope.$on('timer-stopped', function(event, remaining) {
        if( remaining <= 0 ) {
            vm.inventoryHistory.push({ "itemExpired": vm.nextItem });
            toaster.warning("Item Expired", vm.nextItem.label);
            loadInventory();
        }
    });

}

