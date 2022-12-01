<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
class KeywordSearch extends Model
{
    use HasFactory;

    protected $table="keyword_search";
    public $timestamps = false;
}
