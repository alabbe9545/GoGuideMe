<?php

namespace GoGuideMe\Http\Controllers;

use GoGuideMe\User;
use GoGuideMe\Role;
use Illuminate\Http\Request;
use Response;

class UserController extends Controller
{
    public function index(){
    	$users = User::with('roles')->paginate(15);
    	$roles = Role::all();
    	return view('users.index', compact('users', 'roles'));
    }

    public function edit(Request $request){
    	$user = User::find($request->input('id'));
    	if(!isset($user)) return Response::json(['msg' => 'Usuario no encontrado'], 404);

    	$roles = $request->input('roles');

    	$user->roles()->detach();
    	foreach ($roles as $role) {
    		$user->roles()->attach($role['id']);
    	}
    	$users = User::with('roles')->paginate(15);
    	return Response::json(['msg' => 'Done!', 'users' => $users], 200);
    }

    public function delete($id){
    	$user = User::find($id);
    	if(!isset($user)) return Response::json(['msg' => 'Usuario no encontrado'], 404);
    	$user->delete();
    	$users = User::with('roles')->paginate(15);
    	return Response::json(['msg' => 'Done!', 'users' => $users], 200);
    }
}
