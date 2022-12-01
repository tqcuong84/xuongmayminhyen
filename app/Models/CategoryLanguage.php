<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLanguage extends Model
{
    use HasFactory;

    protected $table = 'category_language';

    public static function find($language_code, $id){
        $data = self::where("category_id", $id)->where("language_code", $language_code);
        return $data;
    }
}
