angular.module('app', ['toaster',  'ngAnimate'], function($interpolateProvider) {
        //change angular default interpolate symbol to '<% %>', allow angular to work with laravel blade engine
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    })
    .controller('InventoryController', InventoryController);

InventoryController.$inject = ['$scope', '$http', '$timeout', 'toaster'];

function InventoryController($scope, $http, $timeout, toaster) {

    var vm = this;

    $scope.inventoryHistory = [];
    $scope.inventory = [];


    $scope.loadInventory= loadInventory;
    $scope.addItem = addItem;
    $scope.removeItem = removeItem;


    function addSeconds(date, seconds) {
        date.setSeconds(date.getSeconds() + seconds);
        return date;
    }

    function loadInventory() {
        $http.get('/api/v1/item').
        success(function (data) {
            $scope.inventory = data.items;
            console.log($scope.inventory);

            getNextExpire($scope.inventory);
        });
    }

    function getNextExpire(obj) {
        var next = 99999999;
        var nextItem = {};
        angular.forEach(obj,function(item,index){
//            console.log(index + ' - ' + item.label);
            var expire_at = new Date(item.expire_at);
            var diffSeconds = (expire_at - new Date()) / 1000;
//            console.log(diffSeconds + "s");
            if (diffSeconds < next && diffSeconds>0) {
                next = diffSeconds;
                nextItem = item;
            }
        });
//        console.log("alarm in " + next + " seconds");
        if (next!==99999999) {
            $scope.stopTimer();
            $scope.counter = Math.round(next);
            $scope.nextItem = nextItem;
            $scope.startTimer();
        }
    }

    function addItem() {
        $http.post(
            '/api/v1/item',
            {
                'label': $scope.label,
                'type': $scope.type,
                'event': 'add',
                'expire_at': $scope.expire_at
            }
        ).
        success(function (data) {
            toaster.success("Item Added", $scope.label);
        });

        loadInventory();

        $scope.inventoryHistory.push({"itemAdded": $scope.label});

        $scope.label='';
        $scope.type='';
        $scope.expire_at='';
//        console.log($scope.inventoryHistory);
    }

    function removeItem(key) {
//        toaster.pop('danger', "Item Removed", $scope.inventory[key].label);
//        console.log($scope.inventory[key]);
//        console.log($scope.inventoryHistory);

//        delete $scope.inventory[key];

        $http.post(
            '/api/v1/item',
            {
                'itemID': $scope.inventory[key].itemID,
                'label': $scope.inventory[key].label,
                'type': $scope.inventory[key].type,
                'event': 'remove',
                'expire_at': $scope.inventory[key].expire_at
            }
        ).
        success(function (data) {
            toaster.warning("Item Removed", $scope.inventory[key].label);
        });

        $scope.inventoryHistory.push({"itemRevmoved": $scope.inventory[key]});

        loadInventory();


    }


    $scope.loadInventory();

    $scope.counter = 3;

    var mytimeout = null; // the current timeoutID

    // actual timer method, counts down every second, stops on zero
    $scope.onTimeout = function() {
        if($scope.counter <=  0) {
            $scope.$broadcast('timer-stopped', 0);
            $timeout.cancel(mytimeout);
            return;
        }
        $scope.counter--;
        mytimeout = $timeout($scope.onTimeout, 1000);
    };

    $scope.startTimer = function() {
        mytimeout = $timeout($scope.onTimeout, 1000);
    };

    // stops and resets the current timer
    $scope.stopTimer = function() {
//        $scope.$broadcast('timer-stopped', $scope.counter);
        $timeout.cancel(mytimeout);
    };

    // triggered, when the timer stops, you can do something here, maybe show a visual indicator or vibrate the device
    $scope.$on('timer-stopped', function(event, remaining) {
        if(remaining <= 0) {
            $scope.inventoryHistory.push({"itemExpired": $scope.nextItem});
            toaster.warning("Item Expired", $scope.nextItem.label);
            loadInventory();
        }
    });

}

