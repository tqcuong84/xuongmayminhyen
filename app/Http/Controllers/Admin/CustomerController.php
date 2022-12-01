<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Categories;
use App\Models\CategoryLanguage;

class CustomerController extends Controller
{

    public function index(Request $request){
        $customers = User::listCustomers($request, 20);
        return view('admin.customers', [
            "customers" => $customers,
        ]);
    }

    public function add(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.customer-add', [
            'result' => $result
        ]);
    }

    public function postAdd(Request $request){
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'district' => 'required',
                'customer_type' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->district = $request->district;
        $user->ward = $request->ward;
        $user->customer_type = $request->customer_type;
        $user->is_staff = 0;
        $user->save();


        return view('admin.customer-add', [
            'result' => 'success'
        ]);
    }

    public function view(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.users');
        }
        $staff = User::find($id);
        if(!(isset($staff->id) && $staff->id)){
            return redirect()->route('admin.users');
        }
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.user-view',[
            'result' => $result,
            'staff' => $staff
        ]);
    }

    public function postUpdate(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.users');
        }
        $user = User::find($id);
        if(!(isset($user->id) && $user->id)){
            return redirect()->route('admin.users');
        }
        if(!$user->is_staff){
            return redirect()->route('admin.users');
        }
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'email' => [
                    'required',
                    'email',
                    'unique:users'. ',id,' . $id
                ],
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }
        if(!empty($request->password) && $request->password != $request->password_confirmation){
            return redirect()->back()
                ->withErrors((new MessageBag(['Nhập lại mật khẩu không đúng']))->first())
                ->withInput($request->input());
        }
        
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return view('admin.user-view', [
            'result' => 'success',
            'staff' => $user
        ]);
    }

    public function search(Request $request){
        $keyword = isset($request->term)?trim($request->term):'';
        $lists = [];
        if(!empty($keyword)){
            $customers = User::listCustomers(["keyword" => $keyword], 20);
            if($customers){
                foreach($customers as $customer){
                    $lists[] = [
                        'id' => $customer->id,
                        "text" => $customer->name." - ".$customer->phone,
                        'name' => $customer->name,
                        'phone' => $customer->phone,
                        'address' => $customer->address,
                        'city' => $customer->city,
                        'district' => $customer->district,
                        'ward' => $customer->ward,
                        'customer_type' => $customer->customer_type
                    ];
                }
            }
        }
        return response()->json($lists);
    }

    public function showTypes(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        Categories::setCategoryType(Categories::IS_CUSTOMER_TYPE);
        $customer_types = Categories::lists(config('env.LANGUAGE_DEFAULT'));

        return view('admin.customer-type', [
            "customer_types" => $customer_types,
            "edit_id" => $id
        ]);
    }

    public function postAddType(Request $request){
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'customer_type_name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }

        $categories = new Categories();
        $categories->type = Categories::IS_CUSTOMER_TYPE;
        $categories->save();

        $category_language = new CategoryLanguage();
        $category_language->category_id = $categories->id;
        $category_language->language_code = config('env.LANGUAGE_DEFAULT');
        $category_language->name = $request->customer_type_name;
        $category_language->save();

        return redirect()->route('admin.customer-type');
    }

    public function postUpdateType(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.customer-type');
        }
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'customer_type_name' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }

        CategoryLanguage::find(config('env.LANGUAGE_DEFAULT'), $id)->update([
            "name" => $request->customer_type_name
        ]);

        return redirect()->route('admin.customer-type');
    }

    public function deleteType(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.customer-type');
        }
        $customer_type = Categories::find($id);
        if(!(isset($customer_type->id) && $customer_type->id)){
            return redirect()->route('admin.customer-type');
        }

        Categories::remove($id);

        return redirect()->route('admin.customer-type');
    }
}
