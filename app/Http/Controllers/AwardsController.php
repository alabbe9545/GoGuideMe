<?php

namespace GoGuideMe\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use GoGuideMe\Award;
use GoGuideMe\Country;
use GoGuideMe\Zone;
use Response;

class AwardsController extends Controller
{
    public function index(){
    	$awards = Award::with('zone')->with('country')->get();
    	$zones = Zone::all();
    	$countries = Country::all();
    	return view('awards.index',compact('awards', 'zones', 'countries')); //make view
    }

    public function store(Request $request){
    	$award = new Award();

    	$icon = $request->file('icon');
    	$pathI = $icon->store('photos','public');

    	$zone_id = $request->input('zone_id');
    	$country_id = $request->input('country_id');
    	if(!isset($zone_id) && !isset($country_id)) return Response::json(['msg' => 'Llena zone o country'], 500);

    	$award->name = $request->input('name');
    	$award->icon_path = 'storage/' . $pathI;
    	$award->country_id = $country_id ?? null;
    	$award->zone_id = $zone_id ?? null;
    	$award->unlock_criteria = $request->input('unlock_criteria');
    	$award->save();

    	$awards = Award::with('zone')->with('country')->get();
    	return Response::json(['msg' => 'Done!', 'awards' => $awards], 200);
    }

    public function delete($id){
    	$award = Award::find($id);
    	if(!isset($award)) return Response::json(['msg' => 'Zona no encontrado'], 404);

    	$pathI = str_replace('storage/','',$award->icon_path);
    	Storage::disk('public')->delete($pathI);

    	$award->delete();
    	$awards = Award::with('zone')->with('country')->get();
    	return Response::json(['msg' => 'Done!', 'awards' => $awards], 200);
    }
}
