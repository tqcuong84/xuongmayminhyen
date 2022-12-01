<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLanguage extends Model
{
    use HasFactory;

    protected $table = 'article_language';

    public static function find($language_code, $id){
        $data = self::where("article_id", $id)->where("language_code", $language_code);
        return $data;
    }
}
