@extends('layouts.app')

@section('content')
    
@if(\Auth::user()->canAct('admin'))
    <div class="container" ng-app="awardModule" ng-controller="awardModuleController">
        <table class="table">
            <thead>
                <td>Name</td>
                <td>Icon</td>
                <td>Zone</td>
                <td>Country</td>
                <td>Unlock</td>
                <td>Action</td>
            </thead>
            <tbody>
                <tr>
                    <td><input class="form-control" type="text" placeholder="Name" ng-model="award.name"></td>
                    <td>
                        <input type="file" id="fileP" class="form-control" name="file" onchange="angular.element(this).scope().attachFile(this.files, 'icon')">
                    </td>
                    <td><select ng-model="award.zone_id"><option ng-repeat="zone in zones" ng-value="zone.id"><% zone.name %></option></select></td>
                    <td><select ng-model="award.country_id"><option ng-repeat="country in countries" ng-value="country.id"><% country.name %></option></select></td>
                    <td><input type="number" ng-model="award.unlock_criteria"></td>
                    <td><button class="btn btn-success" ng-click="store()"><i class="glyphicon glyphicon-plus"></i></button></td>
                </tr>
                <tr ng-repeat='award in awards'>
                    <td><% award.name %></td>
                    <td><img class="img-fluid" ng-src="<% award.icon_path %>" style="height: 50px"></td>
                    <td><% award.zone.name %></td>
                    <td><% award.country.name %></td>
                    <td><% award.unlock_criteria %></td>
                    <td><button class="btn btn-danger" ng-click="remove(award.id)"><i class="glyphicon glyphicon-minus"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
@include('awards.angular')
@endsection