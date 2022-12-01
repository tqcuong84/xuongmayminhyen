<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Categories;
class Comments extends Model
{
    use HasFactory;
    
    protected $appends = ['created_time','updated_time','admin_reply','service_name'];

    public function getCreatedTimeAttribute()
    {
        $created_time = null;
        if (!empty($this->created_at)) {
            $created_time = Carbon::parse($this->created_at);
        } 
        return parseDateFormat($created_time, true);
    }

    public function getUpdatedTimeAttribute()
    {
        $updated_time = null;
        if (!empty($this->updated_at)) {
            $updated_time = Carbon::parse($this->updated_at);
        } 
        return parseDateFormat($updated_time, true);
    }

    public function getServiceNameAttribute()
    {
        $service_name = '';
        $service = Categories::get(config('env.LANGUAGE_DEFAULT'), $this->service_id);
        if(isset($service->id) && $service->id){
            $service_name = $service->name;
        }
        return $service_name;
    }

    public function getAdminReplyAttribute()
    {
        return self::adminReplyComment($this->service_id, $this->id);
    }

    public static function lists($param_search = [], $limit = 0) {
        $list = null;
        $query = self::where("deleted", 0)->where("is_xebagac", 0);
        if(isset($param_search['name']) && !empty($param_search['name'])){
            $query->where("name", "LIKE", "%".$param_search['name']."%");
        }
        if(isset($param_search['service_id']) && $param_search['service_id']){
            $query->where("service_id", $param_search['service_id']);
        }
        $query->orderBy('updated_at', 'DESC');
        if($limit > 0){
            $list = $query->paginate($limit)->withQueryString();
        } else {
            $list = $query->get();
        }
        return $list;
    }

    public static function totalRate($service_id){
        $data = self::where("service_id", $service_id)->where("is_xebagac", 0)->sum("rate");
        return $data;
    }

    public static function totalComments($service_id){
        $data = self::where("service_id", $service_id)->where("is_xebagac", 0)->count();
        return $data;
    }

    public static function remove($id) {
        self::where("id", $id)->delete();
    }

    public function adminReplyComment($service_id, $id)
    {
        return self::where("service_id", $service_id)->where("reply_id", $id)->first();
    }
}
