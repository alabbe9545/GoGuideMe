@extends('layouts.app')

@section('content')
@if(\Auth::user()->canAct('admin'))
    <div class="container" ng-app="userModule" ng-controller="userModuleController">
        <table class='table text-center'>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Roles</td>
                    <td>Save Roles</td>
                    <td>Remove</td>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="user in users">
                    <td><% user.name %></td>
                    <td><% user.email %></td>
                    <td>
                        <span ng-repeat='role in roles'>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" ng-click="handleRolBox(user, role)" ng-checked='rolChecked(role, user)' id="role<% role.id %>">
                                <label class="form-check-label" for="role<% role.id %>">
                                    <% role.name %>
                                </label>
                            </div>
                        </span>
                    </td>
                    <td><button class="btn btn-success" ng-click="editUser(user)"><i class="glyphicon glyphicon-floppy-disk"></i></button></td>
                    <td><button class="btn btn-danger" ng-click="remove(user)"><i class="glyphicon glyphicon-minus"></i></button></td>
                </tr>
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endif
@include('users.angular')
@endsection
