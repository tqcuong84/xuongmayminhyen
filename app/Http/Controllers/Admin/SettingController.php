<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;

use App\Models\Settings;

class SettingController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.settings',[
            'result' => ''
        ]);
    }

    public function postUpdate(Request $request)
    {
        $not_article_home_page_banner_text_visibility = true;
        foreach($request->all()  as $input_name => $input_value){
            Settings::where("setting_key",$input_name)->update([
                "value" => $input_value
            ]);
            if($input_name == 'article-home-page-banner-text-visibility'){
                $not_article_home_page_banner_text_visibility = false;
            }
        }
        if($not_article_home_page_banner_text_visibility === true){
            Settings::where("setting_key",'article-home-page-banner-text-visibility')->update([
                "value" => 0
            ]);
        }

        Cache::forget("settings");


        return view('admin.settings',[
            'result' => 'success'
        ]);
    }
}
