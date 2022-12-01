<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        return view('admin.home');
    }

    public function getDistricts(Request $request){
        $districts = [];
        $city = isset($request->city)?intval($request->city):0;
        if($city){
            $districts = districts($city);
        }
        return response()->json([
            'code' => 1,
            'districts' => $districts
        ]);
    }

    public function getWards(Request $request){
        $wards = [];
        $district = isset($request->district)?intval($request->district):0;
        if($district){
            $wards = wards($district);
        }
        return response()->json([
            'code' => 1,
            'wards' => $wards
        ]);
    }
}
