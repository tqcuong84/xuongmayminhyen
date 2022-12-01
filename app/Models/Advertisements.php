<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Advertisements extends Model
{
    use HasFactory;
    
    protected $appends = ['banner_file','created_time','start_date_time','end_date_time','banner_location'];

    protected static $category_type = 0;

    public function getCreatedTimeAttribute()
    {
        $created_time = null;
        if (!empty($this->created_at)) {
            $created_time = Carbon::parse($this->created_at);
        } 
        return parseDateFormat($created_time, true);
    }

    public function getBannerFileAttribute()
    {
        $avatar_file = '';
        if (!empty($this->image)) {
            $avatar_file = '/storage/'.$this->folder.$this->image;
        } 
        return $avatar_file;
    }

    public function getStartDateTimeAttribute()
    {
        $start_date_time = '';
        if (!empty($this->start_date)) {
            $start_date_time = convertMysqlDate($this->start_date);
        } 
        return $start_date_time;
    }

    public function getEndDateTimeAttribute()
    {
        $end_date_time = '';
        if (!empty($this->end_date)) {
            $end_date_time = convertMysqlDate($this->end_date);
        } 
        return $end_date_time;
    }

    public function getBannerLocationAttribute()
    {
        $advertisement_location = config("adminmenu.advertisement_location");
        $banner_location = '';
        if (!empty($this->location)) {
            $banner_location = $advertisement_location[$this->location];
        } 
        return $banner_location;
    }

    public static function lists($param_search = [], $limit = 0) {
        $list = null;
        $query = self::where("deleted", 0);
        if(isset($param_search['location']) && !empty($param_search['location'])){
            $query->where("location", $param_search['location']);
        }
        if(isset($param_search['name']) && !empty($param_search['name'])){
            $query->where("name",'LIKE',"%".$param_search['name']."%");
        }
        $query->orderBy('created_at', 'DESC');
        if($limit > 0){
            if($limit == 1){
                $list = $query->take(1)->first();
            } else {
                $list = $query->paginate($limit)->withQueryString();
            }
        } else {
            $list = $query->get();
        }
        return $list;
    }

    public static function remove($id) {
        self::where("id", $id)->update(['deleted' => 1]);
    }
}
