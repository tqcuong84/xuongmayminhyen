<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class StaticHtml extends Model
{
    use HasFactory;

    protected $table = 'static_html';
    public $timestamps = false;

    protected $fillable = ["banner_file","folder"];
    protected $appends = ['main_banner_file'];

    public function getMainBannerFileAttribute()
    {
        $main_banner_file = '';
        if (!empty($this->banner_file)) {
            $main_banner_file = '/storage/'.$this->folder.$this->banner_file;
        } 
        return $main_banner_file;
    }

    public static function lists($language_code) {
        $list = null;
        $query = self::leftJoin('static_html_language', function($join) {
            $join->on('static_html.id', '=', 'static_html_language.static_html_id');
        })->where("static_html_language.language_code", $language_code);
        return $query->get();
    }

    public static function get($language_code, $id){
        $query = self::leftJoin('static_html_language', function($join) {
            $join->on('static_html.id', '=', 'static_html_language.static_html_id');
        })->where("static_html.id", $id)->where("static_html_language.language_code", $language_code);
        return $query->first();
    }

    public static function getByKey($language_code, $html_key){
        $query = self::leftJoin('static_html_language', function($join) {
            $join->on('static_html.id', '=', 'static_html_language.static_html_id');
        })->where("static_html.html_key", $html_key)->where("static_html_language.language_code", $language_code);
        return $query->first();
    }

    public function updateLanguage($language_code, $id, $data){
        DB::table('static_html_language')->where("static_html_id", $id)->where("language_code", $language_code)->update($data);
    }
}
