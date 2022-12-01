<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDbInsertSettingV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 1 - Number',
            'setting_key' => 'article-home-page-banner-number-block-1'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 1 - Text',
            'setting_key' => 'article-home-page-banner-text-block-1'
        ]);

        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 2 - Number',
            'setting_key' => 'article-home-page-banner-number-block-2'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 2 - Text',
            'setting_key' => 'article-home-page-banner-text-block-2'
        ]);

        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 3 - Number',
            'setting_key' => 'article-home-page-banner-number-block-3'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 3 - Text',
            'setting_key' => 'article-home-page-banner-text-block-3'
        ]);

        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 4 - Number',
            'setting_key' => 'article-home-page-banner-number-block-4'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Kinh Nghiệm Gia Công Banner Block 4 - Text',
            'setting_key' => 'article-home-page-banner-text-block-4'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->where('setting_key', 'article-home-page-banner-number-block-1')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-text-block-1')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-number-block-2')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-text-block-2')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-number-block-3')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-text-block-3')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-number-block-4')->delete();
        DB::table('settings')->where('setting_key', 'article-home-page-banner-text-block-4')->delete();
    }
}
