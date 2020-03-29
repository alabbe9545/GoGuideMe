<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; 
use App\User; 
use App\Award;
use App\VisitedAttraction;
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Attraction;

class UserController extends Controller {
	public $successStatus = 200;

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            return response()->json(['success' => $success], $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
    }

    public function register(Request $request){ 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
		if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        if(count(User::where('email', $request->input('email'))->get()) > 0){
        	return response()->json(['error'=>'Already existing account'], 401); 
        }
		$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
		return response()->json(['success'=>$success], $this->successStatus); 
    }

    private function assignAwards($user_id, $newAttractionData){
        foreach ($newAttractionData as $datum) {
            $zoneAwards = Award::where('zone_id', $datum['zone'])->get();
            $countryAwards = Award::where('country_id', $datum['country'])->get();

            $zoneCount = VisitedAttraction::where('user_id', $user_id)->where('zone_id', $datum['zone'])->count();
            $countryCount = VisitedAttraction::where('user_id', $user_id)->where('country_id', $datum['country'])->count();

            foreach ($zoneAwards as $award) {
                if($zoneCount >= $award->unlock_criteria && !$award->users->contains($user_id)){
                    $award->users()->attach($user_id);
                }
            }

            foreach ($countryAwards as $award) {
                if($countryCount >= $award->unlock_criteria && !$award->users->contains($user_id)){
                    $award->users()->attach($user_id);
                }
            }
        }
    }

    public function getNearestsAttractions(Request $request){
        $input = $request->all();
        $point = $input['point'];
        $newAttractionsData = [];

        $attractions = Attraction::whereRaw("ST_DWithin(location, 'POINT(".$point.")', 65)")->get();
        $user = Auth::user();
        foreach($attractions as $attraction){
            if(!$user->visited_attractions->contains($attraction->id)){
                $zone = $attraction->zone;
                $country = $zone->country;
                $user->visited_attractions()->attach($attraction->id, ['zone_id' => $zone->id, 'country_id' => $country->id]);
                $newAttractionsData[] = ['country' => $country->id, 'zone' => $zone->id];
            }
        }
        if(count($newAttractionsData) > 0){
            $this->assignAwards($user->id, $newAttractionsData);
        }
        return $attractions;
    }

    public function awards(){
        $user = Auth::user();
        return $user->awards;
    }
} 
