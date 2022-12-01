<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKeyTrait;
use Carbon\Carbon;
class KeywordSearchCount extends Model
{
    use HasCompositePrimaryKeyTrait;
    
    protected $table="keyword_search_count";
    protected $primaryKey = ['keyword_id', 'article_id', 'service_id'];
    protected $fillable = ['keyword_id', 'article_id', 'service_id'];
    public $timestamps = false;

    public static function updateCount($keyword_id, $info){
        if(isset($info['article_id']) && $info['article_id']){
            $keyword_search_count = KeywordSearchCount::firstOrNew([
                'keyword_id' => $keyword_id,
                'article_id' => $info['article_id'],
                'service_id' => 0
            ]);
            $keyword_search_count->title_content = $info['title'];
            $keyword_search_count->url_content = $info['url'];
            $keyword_search_count->save();
        } else if(isset($info['service_id']) && $info['service_id']){
            $keyword_search_count = KeywordSearchCount::firstOrNew([
                'keyword_id' => $keyword_id,
                'article_id' => 0,
                'service_id' => $info['service_id']
            ]);
            $keyword_search_count->title_content = $info['title'];
            $keyword_search_count->url_content = $info['url'];
            $keyword_search_count->save();
        }
    }
}
