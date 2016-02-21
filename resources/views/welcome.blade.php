<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <link href="css/app.css" rel="stylesheet" type="text/css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular.min.js"></script>

    <script src="js/app.js"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/1.1.0/toaster.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-animate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angularjs-toaster/1.2.0/toaster.min.js"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0 0 60px;
        }

        body {
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {

        }

        .header {
            text-align: center;
            margin: 20px auto;
        }

        .title {
            font-size: 96px;
        }

        .footer {
            height: 40px;
            background-color: #f5f5f5;
            display: inline-flex;
        }

        .counter {
            margin: auto;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container" ng-app="app" ng-controller="InventoryController">


    <div class="header">
        <span class="title">CQRS Inventory</span><br/>
        <small>Proof of Concept</small>
    </div>


    <toaster-container></toaster-container>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Item</h3>
                </div>

                <div class="panel-body">


                    <div class="form-horizontal">

                        <div class="form-group">
                            {!! Form::label('Label', null, array('class'=>'col-md-4 control-label')) !!}
                            <div class="col-md-6">
                                {{Form::text('label', '', [
                                    'class' => 'form-control input-md',
                                    'ng-model' => 'label'
                                ])}}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Type', null, array('class'=>'col-md-4 control-label')) !!}
                            <div class="col-md-6">
                                {{Form::text('type', '', [
                                    'class' => 'form-control input-md',
                                    'ng-model' => 'type'
                                ])}}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('Expire within (seconds)', null, array('class'=>'col-md-4 control-label')) !!}
                            <div class="col-md-6">
                                {{Form::text('expire_at', '', [
                                    'class' => 'form-control input-md ',
                                    'ng-model' => 'expire_at'
                                ])}} </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="button" class="btn btn-primary btn-lg col-md-12" ng-click="addItem()">
                                    Add
                                </button>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Inventory</h3>
                </div>
                <div class="panel-body">
                    <div ng-repeat="(key, item) in inventory track by $index">
                        <%item.label%>
                        <a ng-click="removeItem(key)" class="btn">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--<div class="row">--}}
    {{--<div class="well col-md-6 col-md-offset-3">--}}
    {{--<%inventoryHistory%>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="row">--}}
    {{--<div class="well col-md-6 col-md-offset-3">--}}
    {{--<div ng-repeat="event in inventoryHistory">--}}
    {{--<div ng-repeat="(key, item) in event">--}}
    {{--<%key%> : <%item%>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="row">--}}
    {{--<div class="well col-md-6 col-md-offset-3">--}}
    {{--<%debug%>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <button type="button" class="btn btn-primary btn-lg col-md-4 col-md-offset-4" ng-click="toggle = !toggle">
                Event Logs
            </button>
        </div>
    </div>


    <div class="row" ng-show="toggle">
        <div class="col-md-6 col-md-offset-3">
            <div class="well" ng-repeat="(key, item) in debug track by $index">
                <%item%>
            </div>
        </div>
    </div>

    <div class="footer navbar-fixed-bottom">
        <div class="counter" ng-if="counter > 0">Next item expire in: <%counter%> seconds</div>
    </div>


</div>

</body>
</html>
