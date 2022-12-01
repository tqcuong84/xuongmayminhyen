<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDbInsertSettingV4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Text Visibility',
            'setting_key' => 'article-home-page-banner-text-visibility',
            'value' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->where('setting_key', 'article-home-page-banner-text-visibility')->delete();
    }
}
