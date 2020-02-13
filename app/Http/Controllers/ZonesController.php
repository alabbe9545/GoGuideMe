<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zone;
use App\Country;
use Response;
use Illuminate\Support\Facades\Storage;

class ZonesController extends Controller
{
    public function index(){
    	$countries = Country::all();
    	$zones = Zone::with('country')->get();
    	return view('zones.index',compact('zones', 'countries'));
    }

    public function store(Request $request){
    	$zone = new Zone();

    	$file = $request->file('file');
    	$path = $file->store('photos','public');

    	$zone->foto_path = 'storage/' . $path;
    	$zone->name = $request->input('name');
    	$zone->polygon = $request->input('polygon');
    	$zone->description = $request->input('description');
    	$zone->country_id = $request->input('country_id');
    	$zone->save();

    	$zones = Zone::all();
    	return Response::json(['msg' => 'Done!', 'zones' => $zones], 200);
    }

    public function delete($id){
    	$zone = Zone::find($id);
    	if(!isset($zone)) return Response::json(['msg' => 'Zona no encontrado'], 404);

    	$path = str_replace('storage/','',$zone->foto_path);
    	Storage::disk('public')->delete($path);

    	$zone->delete();
    	$zones = Zone::all();
    	return Response::json(['msg' => 'Done!', 'zones' => $zones], 200);
    }
}
