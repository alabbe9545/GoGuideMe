@extends('layouts.app')

@section('content')

<script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js'></script>
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' type='text/css'/>
    
@if(\Auth::user()->canAct('admin'))
    <div class="container" ng-app="zoneModule" ng-controller="zoneModuleController">
        @include('zones.map')
        <table class="table">
            <thead>
                <td>Name</td>
                <td>Foto</td>
                <td>Polygon</td>
                <td>Description</td>
                <td>Country</td>
                <td>Action</td>
            </thead>
            <tbody>
                <tr>
                    <td><input class="form-control" type="text" placeholder="Name" ng-model="zone.name"></td>
                    <td>
                        <input type="file" id="file" name="file" onchange="angular.element(this).scope().attachFile(this.files)">
                    </td>
                    <td>
                        <% zone.polygon %>
                        <button ng-click="toggleMap()" class="btn btn-success">
                            <span ng-show="!showMap">Select Polygon</span>
                            <span ng-show="showMap">Hide Map</span>
                        </button>   
                    </td>
                    <td><textarea class="form-control" placeholder="Description" ng-model="zone.description"></textarea></td>
                    <td><select ng-model="zone.country"><option ng-repeat="country in countries" ng-value="country.id"><% country.name %></option></select></td>
                    <td><button class="btn btn-success" ng-click="store()"><i class="glyphicon glyphicon-plus"></i></button></td>
                </tr>
                <tr ng-repeat='zone in zones'>
                    <td><% zone.name %></td>
                    <td><img class="img-fluid" ng-src="<% zone.foto_path %>" style="height: 100px" ></td>
                    <td>
                        <% zone.polygon %>
                        <button class="btn btn-success" ng-click="showPolygon(zone.polygon)">Show Polygon</button>        
                    </td>
                    <td><% zone.description %></td>
                    <td><% zone.country.name %></td>
                    <td><button class="btn btn-danger" ng-click="remove(zone.id)"><i class="glyphicon glyphicon-minus"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
@include('zones.angular')
@endsection