<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDbInnsertSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            'comment' => 'Galleries Page Title',
            'setting_key' => 'galleries-page-title'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Galleries Meta Description',
            'setting_key' => 'galleries-meta-description'
        ]);
        DB::table('settings')->insert([
            'comment' => 'Galleries Meta Keyword',
            'setting_key' => 'galleries-meta-keyword'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->where('setting_key', 'galleries-page-title')->delete();
        DB::table('settings')->where('setting_key', 'galleries-meta-description')->delete();
        DB::table('settings')->where('setting_key', 'galleries-meta-keyword')->delete();
    }
}
