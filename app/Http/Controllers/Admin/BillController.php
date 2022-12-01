<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;

use App\Models\Bills;
use App\Models\User;
use App\Models\Categories;

class BillController extends Controller
{

    public function index(Request $request)
    {
        $bills = Bills::lists(20,[
            'bill_code' => isset($request->bill_code)?trim($request->bill_code):'',
            'from_bill_date' => isset($request->from_bill_date)?trim($request->from_bill_date):'',
            'to_bill_date' => isset($request->to_bill_date)?trim($request->to_bill_date):'',
            'customer_id' => isset($request->customer_id)?intval($request->customer_id):0,
            'customer_phone' => isset($request->customer_phone)?trim($request->customer_phone):'',
            'customer_city' => isset($request->customer_city)?intval($request->customer_city):0,
            'customer_district' => isset($request->customer_district)?intval($request->customer_district):0,
            'from_kilometers' => isset($request->from_kilometers)?floatval($request->from_kilometers):0,
            'to_kilometers' => isset($request->to_kilometers)?floatval($request->to_kilometers):0,
        ]);

        return view('admin.bills',[
            'bills' => $bills
        ]);
    }

    public function add(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        Categories::setCategoryType(Categories::IS_CUSTOMER_TYPE);
        $customer_types = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        return view('admin.bill-add', [
            'result' => $result,
            'customer_types' => $customer_types
        ]);
    }

    public function postAdd(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'sender_name' => 'required',
                'sender_phone' => 'required',
                'sender_address' => 'required',
                'sender_city' => 'required',
                'sender_district' => 'required',
                'sender_ward' => 'required',
                'receiver_name' => 'required',
                'receiver_phone' => 'required',
                'receiver_address' => 'required',
                'receiver_city' => 'required',
                'receiver_district' => 'required',
                'total_amount' => 'required',
                'bill_date' => 'required',
                'customer_type' => 'required'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }
        $sender_phone = detectMobilePhoneNumber($request->sender_phone);
        $receiver_phone = detectMobilePhoneNumber($request->receiver_phone);
        if(empty($sender_phone)){
            return redirect()->back()
                ->withErrors("Số điện thoại người gửi không đúng định dạng")
                ->withInput($request->input());
        }
        if(empty($receiver_phone)){
            return redirect()->back()
                ->withErrors("Số điện thoại người nhận không đúng định dạng")
                ->withInput($request->input());
        }
        $total_amount = doubleval(str_replace(",","",$request->total_amount));
        if(!($total_amount > 0)){
            return redirect()->back()
                ->withErrors("Vui lòng nhập tổng tiền ")
                ->withInput($request->input());
        }
        $bill_date = convertDateTimeToMysql($request->bill_date);
        if(strtotime($bill_date) === false){
            return redirect()->back()
                ->withErrors("Thời gian vận chuyển không đúng")
                ->withInput($request->input());
        }
        $customer_id = isset($request->customer_id)?intval($request->customer_id):0;
        $customer_name = isset($request->customer_name)?trim($request->customer_name):'';
        $kilometers = isset($request->kilometers)?trim($request->kilometers):'';
        if(!empty($kilometers)){
            $kilometers = str_replace("km","",$kilometers);
            $kilometers = str_replace(" ","",$kilometers);
            $kilometers = str_replace(",",".",$kilometers);
            $kilometers = floatval($kilometers);
        }
        $surcharge = isset($request->surcharge)?trim($request->surcharge):'';
        if(!empty($surcharge)){
            $surcharge = doubleval(str_replace(",","",$surcharge));
        }
        $is_urgent = isset($request->is_urgent)?intval($request->is_urgent):0;
        
        if(!$customer_id){
            $customer_info = User::getCustomerByPhone($request->sender_phone);
            if(isset($customer_info->id) && $customer_info->id){
                $customer_id = $customer_info->id;
                $customer_name = $customer_info->name;
            } else {
                $user = new User();
                $user->name = $request->sender_name;
                $user->phone = $request->sender_phone;
                $user->email = $request->sender_phone.'@'.config('env.DOMAIN_NAME');
                $user->password = '';
                $user->address = $request->sender_address;
                $user->city = $request->sender_city;
                $user->district = $request->sender_district;
                $user->ward = $request->sender_ward;
                $user->customer_type = $request->customer_type;
                $user->is_staff = 0;
                $user->save();
                $customer_id = $user->id;
                $customer_name = $request->sender_name;
            }
        }

        $bills = new Bills();
        $bills->sender_name = $request->sender_name;
        $bills->sender_phone = $request->sender_phone;
        $bills->sender_address = $request->sender_address;
        $bills->sender_city = $request->sender_city;
        $bills->sender_district = $request->sender_district;
        $bills->sender_ward = $request->sender_ward;
        $bills->receiver_name = $request->receiver_name;
        $bills->receiver_phone = $request->receiver_phone;
        $bills->receiver_address = $request->receiver_address;
        $bills->receiver_city = $request->receiver_city;
        $bills->receiver_district = $request->receiver_district;
        $bills->receiver_ward = isset($request->receiver_ward)?intval($request->receiver_ward):0;
        $bills->total_amount = $total_amount;
        $bills->surcharge = $surcharge;
        $bills->bill_date = $bill_date;
        $bills->customer_type = $request->customer_type;
        $bills->customer_id = $customer_id;
        $bills->customer_name = $customer_name;
        $bills->kilometers = $kilometers;
        $bills->is_urgent = $is_urgent;
        $bills->save();
        
        return redirect()->route('admin.bill.add', [
            'result' => 'success',
            'id' => $bills->id,
        ]);
    }

    public function view(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.bills');
        }
        $bill = Bills::find($id);
        if(!(isset($bill->id) && $bill->id)){
            return redirect()->route('admin.bills');
        }
        $result = isset($request->result)?trim($request->result):'';
        $customer_info = User::find($bill->customer_id);
        Categories::setCategoryType(Categories::IS_CUSTOMER_TYPE);
        $customer_types = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        return view('admin.bill-view',[
            'result' => $result,
            'bill' => $bill,
            'customer_info' => $customer_info,
            'customer_types' => $customer_types
        ]);
    }

    public function postUpdate(Request $request)
    {
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.bills');
        }
        $bill = Bills::find($id);
        if(!(isset($bill->id) && $bill->id)){
            return redirect()->route('admin.bills');
        }

        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'sender_name' => 'required',
                'sender_phone' => 'required',
                'sender_address' => 'required',
                'sender_city' => 'required',
                'sender_district' => 'required',
                'sender_ward' => 'required',
                'receiver_name' => 'required',
                'receiver_phone' => 'required',
                'receiver_address' => 'required',
                'receiver_city' => 'required',
                'receiver_district' => 'required',
                'total_amount' => 'required',
                'bill_date' => 'required',
                'customer_type' => 'required'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }
        $sender_phone = detectMobilePhoneNumber($request->sender_phone);
        $receiver_phone = detectMobilePhoneNumber($request->receiver_phone);
        if(empty($sender_phone)){
            return redirect()->back()
                ->withErrors("Số điện thoại người gửi không đúng định dạng")
                ->withInput($request->input());
        }
        if(empty($receiver_phone)){
            return redirect()->back()
                ->withErrors("Số điện thoại người nhận không đúng định dạng")
                ->withInput($request->input());
        }
        $total_amount = doubleval(str_replace(",","",$request->total_amount));
        if(!($total_amount > 0)){
            return redirect()->back()
                ->withErrors("Vui lòng nhập tổng tiền ")
                ->withInput($request->input());
        }
        $bill_date = convertDateTimeToMysql($request->bill_date);
        if(strtotime($bill_date) === false){
            return redirect()->back()
                ->withErrors("Thời gian vận chuyển không đúng")
                ->withInput($request->input());
        }
        $customer_id = isset($request->customer_id)?intval($request->customer_id):0;
        $customer_name = isset($request->customer_name)?trim($request->customer_name):'';
        $kilometers = isset($request->kilometers)?trim($request->kilometers):'';
        if(!empty($kilometers)){
            $kilometers = str_replace("km","",$kilometers);
            $kilometers = str_replace(" ","",$kilometers);
            $kilometers = str_replace(",",".",$kilometers);
            $kilometers = floatval($kilometers);
        }
        $surcharge = isset($request->surcharge)?trim($request->surcharge):'';
        if(!empty($surcharge)){
            $surcharge = doubleval(str_replace(",","",$surcharge));
        }
        $is_urgent = isset($request->is_urgent)?intval($request->is_urgent):0;
        
        if(!$customer_id){
            $customer_info = User::getCustomerByPhone($request->sender_phone);
            if(isset($customer_info->id) && $customer_info->id){
                $customer_id = $customer_info->id;
                $customer_name = $customer_info->name;
            } else {
                $user = new User();
                $user->name = $request->sender_name;
                $user->phone = $request->sender_phone;
                $user->email = $request->sender_phone.'@'.config('env.DOMAIN_NAME');
                $user->password = '';
                $user->address = $request->sender_address;
                $user->city = $request->sender_city;
                $user->district = $request->sender_district;
                $user->ward = $request->sender_ward;
                $user->customer_type = $request->customer_type;
                $user->is_staff = 0;
                $user->save();
                $customer_id = $user->id;
                $customer_name = $request->sender_name;
            }
        }

        $bill->sender_name = $request->sender_name;
        $bill->sender_phone = $request->sender_phone;
        $bill->sender_address = $request->sender_address;
        $bill->sender_city = $request->sender_city;
        $bill->sender_district = $request->sender_district;
        $bill->sender_ward = $request->sender_ward;
        $bill->receiver_name = $request->receiver_name;
        $bill->receiver_phone = $request->receiver_phone;
        $bill->receiver_address = $request->receiver_address;
        $bill->receiver_city = $request->receiver_city;
        $bill->receiver_district = $request->receiver_district;
        $bill->receiver_ward = isset($request->receiver_ward)?intval($request->receiver_ward):0;
        $bill->total_amount = $total_amount;
        $bill->surcharge = $surcharge;
        $bill->bill_date = $bill_date;
        $bill->customer_type = $request->customer_type;
        $bill->customer_id = $customer_id;
        $bill->customer_name = $customer_name;
        $bill->kilometers = $kilometers;
        $bill->is_urgent = $is_urgent;
        $bill->save();
        
        return redirect()->route('admin.bill.view', [
            'result' => 'success',
            'id' => $bill->id,
        ]);
    }
}
