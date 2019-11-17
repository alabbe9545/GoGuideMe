@extends('layouts.app')

@section('content')
@if(\Auth::user()->canAct('admin'))
    <div class="container" ng-app="roleModule" ng-controller="roleModuleController">
        <table class='table text-center'>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" class="form-control" placeholder="Name" ng-model="role.name"></td>
                    <td><button class="btn btn-success" ng-click="create()"><i class="glyphicon glyphicon-plus"></i></button></td>
                </tr>
                <tr ng-repeat="role in roles">
                    <td><% role.name %></td>
                    <td><button class="btn btn-danger" ng-click="remove(role.id)"><i class="glyphicon glyphicon-minus"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
@include('roles.angular')
@endsection
