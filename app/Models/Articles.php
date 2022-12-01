<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
class Articles extends Model
{
    use HasFactory;

    const IS_ARTICLE = 1;
    const IS_PRODUCT = 2;
    const IS_PRODUCT_PHOTO = 3;
    const IS_GALLERY = 4;
    const IS_BRAND = 5;
    
    protected $appends = ['avatar_file','main_banner_file','created_time','publish_time','url_details','slug','publish_time_part'];

    public function getCreatedTimeAttribute()
    {
        $created_time = null;
        if (!empty($this->created_at)) {
            $created_time = Carbon::parse($this->created_at);
        } 
        return parseDateFormat($created_time, true);
    }

    public function getPublishTimeAttribute()
    {
        $publish_time = '';
        if (!empty($this->publish_date)) {
            $publish_time = convertMysqlDate($this->publish_date);
        } 
        return $publish_time;
    }

    public function getPublishTimePartAttribute()
    {
        $publish_time_part = [
            'month' => '',
            'day' => '',
            'year' => ''
        ];
        if (!empty($this->publish_date)) {
            $publish_time_array = explode("-",$this->publish_date);
            $publish_time_part = [
                'month' => 'Tháng '.intval($publish_time_array[1]),
                'day' => $publish_time_array[2],
                'year' => $publish_time_array[0]
            ];
        } 
        return $publish_time_part;
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
        $url = config('app.url')."/".Str::slug($this->title, '-')."_".$this->id.".html";
        return $url;
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->title, '-');
    }

    public function category($language_code)
    {
        return Categories::get($language_code, $this->category_id);
    }

    public static function lists($language_code, $article_type, $limit = 0, $skip_id = [], $search_param = [], $not_paginate = false, $order_by = "") {
        $list = null;
        $query = self::where("articles.deleted", 0)->leftJoin('article_language', function($join) {
            $join->on('articles.id', '=', 'article_language.article_id');
        })->where("article_language.language_code", $language_code);
        if($article_type){
            $query->where("articles.article_type",$article_type);
        }
        if(is_array($skip_id) && count($skip_id)){
            $query->whereNotIn("articles.id",$skip_id);
        }
        if(isset($search_param['title']) && !empty($search_param['title'])){
            $query->where("article_language.title", "LIKE", "%".addslashes($search_param ['title'])."%");
        }
        if(isset($search_param['hotnews']) && $search_param['hotnews']){
            $query->where("articles.hotnews", 1);
        }
        if(isset($search_param['is_homepage']) && $search_param['is_homepage']){
            $query->where("articles.is_homepage", 1);
        }
        if(isset($search_param['category_id']) && $search_param['category_id']){
            $query->where("articles.category_id", $search_param['category_id']);
        }
        if(!empty($order_by)){
            if($order_by == 'hotnews'){
                $query->orderBy('articles.hotnews_time', 'DESC');
            }
        }
        $query->orderBy('articles.publish_date', 'DESC')->orderBy('articles.id', 'DESC');
        
        if($limit > 0){
            if($not_paginate === true){
                $list = $query->limit($limit)->get();
            } else{
                $list = $query->paginate($limit)->withQueryString();
            }
        } else {
            $list = $query->get();
        }
        return $list;
    }

    public static function get($language_code, $id){
        $data = self::where("articles.deleted", 0)->where("articles.id", $id)->leftJoin('article_language', function($join) {
            $join->on('articles.id', '=', 'article_language.article_id');
        })->where("article_language.language_code", $language_code)->first();
        return $data;
    }

    public static function remove($id) {
        self::where("id", $id)->update(['deleted' => 1]);
    }
}
