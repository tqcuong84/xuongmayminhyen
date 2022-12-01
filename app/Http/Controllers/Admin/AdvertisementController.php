<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;

use App\Models\Advertisements;

use  Carbon\Carbon;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $advertisement_location = config("adminmenu.advertisement_location");
            \View::share('advertisement_location', $advertisement_location);
            return $next($request);
        });
    }

    public function index(){
        $advertisements = Advertisements::lists([], 20);
        return view('admin.advertisements', [
            "advertisements" => $advertisements,
            "has_pagination" => 1
        ]);
    }

    public function add(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.advertisement-add', [
            'result' => $result
        ]);
    }

    public function postAdd(Request $request){
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'banner_file' => 'required',
                'location' => 'required',
            ]
        );
        $folder = trim($request->banner_folder);
        if ($validator->fails()) {
            $old_input = $request->input();
            if(!empty($request->banner_file)){
                $old_input['banner_file_post'] = '/storage/'.$folder.$request->banner_file;
            }
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên quảng cáo';
                }
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($old_input);
        }
        $start_date = $end_date = '';
        if(!empty($request->start_date)){
            $start_date = convertToMysqlDate($request->start_date);
        }
        if(!empty($request->end_date)){
            $end_date = convertToMysqlDate($request->end_date);
        }
        $advertisement = new Advertisements();
        $advertisement->name = $request->name;
        $advertisement->location = $request->location;
        $advertisement->link = $request->link;
        $advertisement->image = $request->banner_file;
        $advertisement->folder = $folder;
        if(!empty($start_date)){
            $advertisement->start_date = $start_date;
        }
        if(!empty($end_date)){
            $advertisement->end_date = $end_date;
        }
        $advertisement->note = $request->note;
        $advertisement->active = intval($request->active);
        $advertisement->save();

        return view('admin.advertisement-add', [
            'result' => 'success'
        ]);
    }

    public function view(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.advertisements');
        }
        $advertisement = Advertisements::find($id);
        if(!(isset($advertisement->id) && $advertisement->id)){
            return redirect()->route('admin.advertisements');
        }
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.advertisement-view',[
            'result' => $result,
            'advertisement' => $advertisement
        ]);
    }

    public function postUpdate(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.advertisements');
        }
        $advertisement = Advertisements::find($id);
        if(!(isset($advertisement->id) && $advertisement->id)){
            return redirect()->route('admin.advertisements');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'banner_file' => 'required',
                'location' => 'required',
            ]
        );
        $folder = trim($request->banner_folder);
        if ($validator->fails()) {
            $old_input = $request->input();
            if(!empty($request->banner_file)){
                $old_input['banner_file_post'] = '/storage/'.$folder.$request->banner_file;
            }
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên quảng cáo';
                }
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($old_input);
        }
        $start_date = $end_date = '';
        if(!empty($request->start_date)){
            $start_date = convertToMysqlDate($request->start_date);
        }
        if(!empty($request->end_date)){
            $end_date = convertToMysqlDate($request->end_date);
        }
        
        $advertisement = Advertisements::find($id);
        if($folder != $advertisement->folder){
            $advertisement->folder = $folder;
        }
        $advertisement->name = $request->name;
        $advertisement->location = $request->location;
        $advertisement->link = $request->link;
        $advertisement->image = $request->banner_file;
        if(!empty($start_date)){
            $advertisement->start_date = $start_date;
        }
        if(!empty($end_date)){
            $advertisement->end_date = $end_date;
        }
        $advertisement->note = $request->note;
        $advertisement->active = intval($request->active);
        $advertisement->save();

        return redirect()->route('admin.advertisement.view', [
            'result' => 'success',
            'id' => $id
        ]);
    }

    public function delete(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.advertisements');
        }
        $advertisement = Advertisements::find($id);
        if(!(isset($advertisement->id) && $advertisement->id)){
            return redirect()->route('admin.advertisements');
        }

        Advertisements::remove($id);

        return redirect()->route('admin.advertisements');
    }
}
