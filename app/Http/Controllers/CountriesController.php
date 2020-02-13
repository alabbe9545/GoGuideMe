<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use Response;
use Illuminate\Support\Facades\Storage;

class CountriesController extends Controller
{
    public function index(){
    	$countries = Country::all();
    	return view('countries.index', compact('countries'));
    }

    public function store(Request $request){
    	$country = new Country();

    	$file = $request->file('file');
    	$path = $file->store('photos','public');

    	$country->foto_path = 'storage/' . $path;
    	$country->name = $request->input('name');
    	$country->description = $request->input('description');
    	$country->save();

    	$countries = Country::all();
    	return Response::json(['msg' => 'Done!', 'countries' => $countries], 200);
    }

    public function delete($id){
    	$country = Country::find($id);
    	if(!isset($country)) return Response::json(['msg' => 'Pais no encontrado'], 404);

    	$path = str_replace('storage/','',$country->foto_path);
    	Storage::disk('public')->delete($path);

    	$country->delete();
    	$countries = Country::all();
    	return Response::json(['msg' => 'Done!', 'countries' => $countries], 200);
    }
}
