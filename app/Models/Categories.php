<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Categories extends Model
{
    use HasFactory;

    const IS_PRODUCT_CATEGORIES = 1;
    
    protected $appends = ['avatar_file','main_banner_file','created_time','url_details','slug','parent_name'];

    protected static $category_type = 0;

    public function getCreatedTimeAttribute()
    {
        $created_time = null;
        if (!empty($this->created_at)) {
            $created_time = Carbon::parse($this->created_at);
        } 
        return parseDateFormat($created_time, true);
    }

    public function getAvatarFileAttribute()
    {
        $avatar_file = '';
        if (!empty($this->image)) {
            $avatar_file = '/storage/'.$this->folder.$this->image;
        } 
        return $avatar_file;
    }

    public function getMainBannerFileAttribute()
    {
        $main_banner_file = '';
        if (!empty($this->image2)) {
            $main_banner_file = '/storage/'.$this->folder.$this->image2;
        } 
        return $main_banner_file;
    }

    public function getUrlDetailsAttribute()
    {
        $url = config('app.url')."/".Str::slug($this->name, '-')."_".$this->id.".html";
        return $url;
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->name, '-');
    }

    public function getParentNameAttribute()
    {
        $parent_name = "";
        if($this->parent_id){
            $parent_data = self::get(config('env.LANGUAGE_DEFAULT'),$this->parent_id);
            if(isset($parent_data->id) && $parent_data->id){
                $parent_name = $parent_data->name;
            }
        }
        return $parent_name;
    }

    public static function setCategoryType($type){
        self::$category_type = $type;
    }

    public static function lists($language_code, $limit = 0, $search_param = []) {
        $list = null;
        $query = self::where("categories.deleted", 0)->where("categories.type", self::$category_type)->leftJoin('category_language', function($join) {
            $join->on('categories.id', '=', 'category_language.category_id');
        })->where("category_language.language_code", $language_code);
        if(isset($search_param['name']) && !empty($search_param['name'])){
            $query->where("category_language.name", "LIKE", "%".$search_param['name']."%");
        }
        if(isset($search_param['parent_id'])){
            $query->where("categories.parent_id", $search_param['parent_id']);
        }
        $query->orderBy('categories.created_at', 'DESC');
        if($limit > 0){
            $list = $query->paginate($limit)->withQueryString();
        } else {
            $list = $query->get();
        }
        return $list;
    }

    public static function get($language_code, $id){
        $data = self::where("categories.deleted", 0)->where("categories.id", $id)->leftJoin('category_language', function($join) {
            $join->on('categories.id', '=', 'category_language.category_id');
        })->where("category_language.language_code", $language_code)->first();
        return $data;
    }

    public static function remove($id) {
        self::where("id", $id)->update(['deleted' => 1]);
    }
}
