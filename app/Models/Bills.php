<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Bills extends Model
{
    use HasFactory;

    const IS_NEW = 1;
    const IS_IN_PROGRESS = 2;
    const IS_DONE = 3;
    const IS_CANCEL = 4;

    const BILL_STATUS_TEXT = [
        "1" => "Vận đơn mới",
        "2" => "Đang vận chuyển",
        "3" => "Đã hoàn thành",
        "3" => "Đã hủy",
    ];
    const BILL_STATUS_COLOR = [
        "1" => "#007bff",
        "2" => "#ffc107",
        "3" => "#28a745",
        "4" => "#dc3545",
    ];

    protected $appends = ['created_time','bill_time','bill_status_text','bill_status_color'];
    public function getCreatedTimeAttribute()
    {
        $created_time = null;
        if (!empty($this->created_at)) {
            $created_time = Carbon::parse($this->created_at);
        } 
        return parseDateFormat($created_time, true);
    }
    public function getBillTimeAttribute()
    {
        $return_time = null;
        if (!empty($this->bill_date)) {
            $return_time = Carbon::parse($this->bill_date);
        } 
        return parseDateFormat($return_time, true);
    }
    public function getBillStatusTextAttribute()
    {
        return self::BILL_STATUS_TEXT[$this->bill_status];
    }
    public function getBillStatusColorAttribute()
    {
        return self::BILL_STATUS_COLOR[$this->bill_status];
    }

    public static function lists($limit = 0, $search_param = []) {
        $list = null;
        $query = self::where("is_deleted", 0);
        if(isset($search_param['bill_code']) && !empty($search_param['bill_code'])){
            $query->where("bill_code", "LIKE", "%".$search_param['bill_code']."%");
        }
        if(isset($search_param['from_bill_date']) && !empty($search_param['from_bill_date'] ) ){
            if(isset($search_param['to_bill_date']) && !empty($search_param['to_bill_date'])){
                $query->whereRaw("DATE_FORMAT(bill_date,'%Y-%m-%d') >= '".$search_param['from_bill_date']."'");
                $query->whereRaw("DATE_FORMAT(bill_date,'%Y-%m-%d') <= '".$search_param['to_bill_date']."'");
            } else{
                $query->whereRaw("DATE_FORMAT(bill_date,'%Y-%m-%d') = '".$search_param['from_bill_date']."'");
            }
        } 
        if(isset($search_param['customer_id']) && $search_param['customer_id']){
            $query->where("customer_id", $search_param['customer_id']);
        }
        if(isset($search_param['customer_phone']) && !empty($search_param['customer_phone'])){
            $query->where("customer_phone", "LIKE", "%".$search_param['customer_phone']."%");
        }
        if(isset($search_param['customer_city']) && $search_param['customer_city']){
            $query->where("customer_city", $search_param['customer_city']);
        }
        if(isset($search_param['customer_district']) && $search_param['customer_district']){
            $query->where("customer_district", $search_param['customer_district']);
        }
        if(isset($search_param['from_kilometers']) && $search_param['from_kilometers']){
            if(isset($search_param['to_kilometers']) && !empty($search_param['to_kilometers'])){
                $query->where("kilometers", '>=', $search_param['from_kilometers']);
                $query->where("kilometers", '<=', $search_param['to_bill_date']);
            } else{
                $query->where("kilometers", $search_param['from_kilometers']);
            }
        }
        $query->orderBy('bill_date', 'DESC');
        if($limit > 0){
            $list = $query->paginate($limit)->withQueryString();
        } else {
            $list = $query->get();
        }
        return $list;
    }

    public static function generateBillCode($id){
        $bill_code_index = $id + 500;
        $bill_code = '';
        for($i = strlen($bill_code_index); $i < 6; $i++){
            $bill_code .= '0';
        }
        $bill_code = "VD".$bill_code.$bill_code_index;
        return $bill_code;
    }
}
