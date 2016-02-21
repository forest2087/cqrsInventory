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
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {

        }

        .title {
            font-size: 96px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container" ng-app="app" ng-controller="InventoryController">

    <span class="title">CQRS Inventory </span> <small>Proof of Concept</small>

    <toaster-container></toaster-container>

    <div class="row">
        <div class="well col-md-6 col-md-offset-3">
            <div class="form-group">
                {!! Form::label('Label', null, array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{Form::text('label', '', [
                        'class' => 'form-control input-md',
                        'ng-model' => 'label'
                    ])}}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Type', null, array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{Form::text('type', '', [
                        'class' => 'form-control input-md',
                        'ng-model' => 'type'
                    ])}}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('Expire within (seconds)', null, array('class'=>'col-md-4 control-label')) !!}
                <div class="col-md-8">
                    {{Form::text('expire_at', '', [
                        'class' => 'form-control input-md ',
                        'ng-model' => 'expire_at'
                    ])}} </div>

            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="button" class="btn btn-primary btn-lg col-md-12" ng-click="addItem()">Add</button>
                </div>
            </div>

        </div>
    </div>

    {{--<button type="button" class="btn btn-danger btn-lg" ng-click="removeItem">Remove</button>--}}

    <div class="row">
        <div class="well">
            <div ng-repeat="event in inventoryHistory">
                <div ng-repeat="(key, item) in event">
                    <%key%> : <%item%>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="well">
            <div ng-repeat="(key, item) in inventory track by $index">
                <%item.label%>
                <a ng-click="removeItem(key)" class="btn">
                    <span class="glyphicon glyphicon-trash"></span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="well">
            <%inventoryHistory%>
        </div>
    </div>

    Next item expire in: <%counter%> seconds

</div>
</body>
</html>
