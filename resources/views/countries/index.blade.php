@extends('layouts.app')

@section('content')
    
@if(\Auth::user()->canAct('admin'))
    <div class="container" ng-app="countryModule" ng-controller="countryModuleController">
        <table class="table">
        	<thead>
        		<td>Name</td>
        		<td>Foto</td>
        		<td>Description</td>
        		<td>Action</td>
        	</thead>
        	<tbody>
        		<tr>
        			<td><input class="form-control" type="text" placeholder="Name" ng-model="country.name"></td>
        			<td>
        				<input type="file" id="file" name="file" onchange="angular.element(this).scope().attachFile(this.files)">
        			</td>
        			<td><textarea class="form-control" placeholder="Description" ng-model="country.description"></textarea></td>
        			<td><button class="btn btn-success" ng-click="store()"><i class="glyphicon glyphicon-plus"></i></button></td>
        		</tr>
        		<tr ng-repeat='country in countries'>
        			<td><% country.name %></td>
        			<td><img class="img-fluid" ng-src="<% country.foto_path %>" style="height: 100px" ></td>
        			<td><% country.description %></td>
        			<td><button class="btn btn-danger" ng-click="remove(country.id)"><i class="glyphicon glyphicon-minus"></i></button></td>
        		</tr>
        	</tbody>
        </table>
    </div>
@endif
@include('countries.angular')
@endsection