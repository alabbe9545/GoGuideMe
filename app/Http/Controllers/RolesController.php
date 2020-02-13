<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Response;

class RolesController extends Controller
{
    public function index(){
    	$roles = Role::all();

    	return view('roles.index', compact('roles'));
    }

    public function store(Request $request){
		$role = new Role();
    	$role->name = $request->input('name');

    	$role->save();

		$roles = Role::all();
    	return Response::json(['msg' => 'Done!', 'roles' => $roles], 200);
    }

    public function delete($id){
    	$role = Role::find($id);
    	if(!isset($role)) return Response::json(['msg' => 'Rol no encontrado'], 404);
        $role->users()->detach();
    	$role->delete();
    	$roles = Role::all();
    	return Response::json(['msg' => 'Done!', 'roles' => $roles], 200);
    }
}
