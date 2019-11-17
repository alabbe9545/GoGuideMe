<?php

namespace GoGuideMe\Http\Controllers;

use Illuminate\Http\Request;
use GoGuideMe\Awards;

class AwardsController extends Controller
{
    public function index(){
    	$awards = Awards::all();
    	return view('attractions.index',compact('awards')); //make view
    }

    public function store(Request $request){
    	/*$attraction = new Attraction();

    	$photo = $request->file('photo');
    	$audio = $request->file('audio');
    	$icon = $request->file('icon');

    	$pathP = $photo->store('photos','public');
    	$pathA = $audio->store('photos','public');
    	$pathI = $icon->store('photos','public');

    	$attraction->foto_path = 'storage/' . $pathP;
    	$attraction->audio_path = 'storage/' . $pathA;
    	$attraction->icon_path = 'storage/' . $pathI;
    	$attraction->name = $request->input('name');
    	$attraction->description = $request->input('description');
    	$attraction->zone_id = $request->input('zone_id');
    	$point = json_decode($request->input('location'));
    	$attraction->location = new Point($point[1], $point[0]);
    	$attraction->save();

    	$attractions = Attraction::all();
    	return Response::json(['msg' => 'Done!', 'attractions' => $attractions], 200);*/
    }

    public function delete($id){
    	/*$attraction = Attraction::find($id);
    	if(!isset($attraction)) return Response::json(['msg' => 'Zona no encontrado'], 404);

    	$pathP = str_replace('storage/','',$attraction->foto_path);
    	$pathA = str_replace('storage/','',$attraction->audio_path);
    	$pathI = str_replace('storage/','',$attraction->icon_path);
    	Storage::disk('public')->delete($pathP);
    	Storage::disk('public')->delete($pathA);
    	Storage::disk('public')->delete($pathI);

    	$attraction->delete();
    	$attractions = Attraction::all();
    	return Response::json(['msg' => 'Done!', 'attractions' => $attractions], 200);**/
    }
}
