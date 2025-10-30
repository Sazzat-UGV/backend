<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityandStateController extends Controller
{

    public function states()
    {
        $states = State::get();
        return response()->json([
            'status' => true,
            'message' => 'State data retreived successfully.',
            'data' => $states,
        ], 200);
    }
    public function city($id)
    {
        $cities = City::where('state_id',$id)->get();
        return response()->json([
            'status' => true,
            'message' => 'City data retreived successfully.',
            'data' => $cities,
        ], 200);
    }
}
