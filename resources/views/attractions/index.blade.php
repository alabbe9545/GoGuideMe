@extends('layouts.app')

@section('content')

<script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js'></script>
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' type='text/css'/>
    
@if(\Auth::user()->canAct('admin'))
    <div class="container" ng-app="attractionModule" ng-controller="attractionModuleController">
        @include('zones.map')
        <table class="table">
            <thead>
                <td>Name</td>
                <td>Foto</td>
                <td>Audio</td>
                <td>Icon</td>
                <td>Zone</td>
                <td>Point</td>
                <td>Description</td>
                <td>Action</td>
            </thead>
            <tbody>
                <tr>
                    <td><input class="form-control" type="text" placeholder="Name" ng-model="attraction.name"></td>
                    <td>
                        <input type="file" id="fileP" class="form-control" name="file" onchange="angular.element(this).scope().attachFile(this.files, 'photo')">
                    </td>
                    <td>
                        <input type="file" id="fileA" class="form-control" name="file" onchange="angular.element(this).scope().attachFile(this.files, 'audio')">
                    </td>
                    <td>
                        <input type="file" id="fileI" class="form-control" name="file" onchange="angular.element(this).scope().attachFile(this.files, 'icon')">
                    </td>
                    <td><select ng-model="attraction.zone"><option ng-repeat="zone in zones" ng-value="zone"><% zone.name %></option></select></td>
                    <td>
                        <% attraction.location %>
                        <button ng-click="toggleMap(!showMap)" class="btn btn-success">
                            <span ng-show="!showMap">Select Point</span>
                            <span ng-show="showMap">Hide Map</span>
                        </button>   
                    </td>
                    <td><textarea class="form-control" placeholder="Description" ng-model="attraction.description"></textarea></td>
                    <td><button class="btn btn-success" ng-click="store()"><i class="glyphicon glyphicon-plus"></i></button></td>
                </tr>
                <tr ng-repeat='attraction in attractions'>
                    <td><% attraction.name %></td>
                    <td><img class="img-fluid" ng-src="<% attraction.foto_path %>" style="height: 100px" ></td>
                    <td>
                        <audio controls>
                          <source ng-src="<% attraction.audio_path %>" type="audio/mp3">
                          Your browser does not support the audio element.
                        </audio>
                    </td>
                    <td><img class="img-fluid" ng-src="<% attraction.icon_path %>" style="height: 50px"></td>
                    <td><% attraction.zone.name %></td>
                    <td>
                        <% attraction.location.coordinates %>
                        <button class="btn btn-success" ng-click="showPoint(attraction.location.coordinates, attraction.icon_path)">Show Point</button>        
                    </td>
                    <td><% attraction.description %></td>
                    <td><button class="btn btn-danger" ng-click="remove(attraction.id)"><i class="glyphicon glyphicon-minus"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endif
@include('attractions.angular')
@endsection