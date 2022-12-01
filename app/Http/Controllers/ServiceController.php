<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;

use App\Models\Categories;
use App\Models\Comments;
use App\Models\Advertisements;

class ServiceController extends Controller
{
    public function index(){
        $top_banner = Advertisements::lists([
            'location' => 2
        ],1);

        return view('services', array_merge([
            "top_banner" => $top_banner,
        ], bindHeaderInfo([
            "meta_title" => settings('service-page-title'),
            "page_title" => settings('service-page-title'),
            "meta_description" => settings('service-meta-description'),
            "meta_keyword" => settings('service-meta-keyword'),
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }
    public function review(Request $request){
        if(!(isset($request->service_id) && $request->service_id)){
            return redirect()->back();
        }
        $service = Categories::get(session('CURRENT_LANGUAGE'), $request->service_id);
        if(!(isset($service->id) && $service->id)){
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), []);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'content' => 'required'
            ]
        );
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên của bạn';
                    break;
                } else if($error_key == 'content'){
                    $error_msg = 'Vui lòng nhập nội dung nhận xét';
                    break;
                }
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($request->input());
        }
        $rate = 0;
        if(isset($request->ratings)){
            $rate = floatval($request->ratings);
        }
        $comments = new Comments();
        $comments->service_id = $request->service_id;
        $comments->name = $request->name;
        $comments->email = $request->email;
        $comments->subject = $request->subject;
        $comments->content = $request->content;
        $comments->rate = $rate;
        $comments->save();

        $total_rate = Comments::totalRate($request->service_id);
        $total_comments = Comments::totalComments($request->service_id);
        $service->total_comments = $total_comments;
        $service->total_rating = $total_rate;
        $rate_value = 0;
        if($total_comments > 0){
            $$rate_value = floatval($total_rate / $total_comments);
        }
        $service->rate_value = $rate_value;
        $service->save();

        return redirect($service->service_url . '#comments');
    }
}
