<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDbInsertSettingV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Main Text',
            'setting_key' => 'article-home-page-banner-main-text'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Sub Text',
            'setting_key' => 'article-home-page-banner-sub-text'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->where('setting_key', 'article-home-page-banner-main-text')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-sub-text')->delete();
    }
}
