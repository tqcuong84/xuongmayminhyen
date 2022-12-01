<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDbInsertSettingV6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            'comment' => 'Xưởng May Cho Mọi Giấc Mơ',
            'setting_key' => 'xuong-may-cho-moi-giac-mo'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->where('setting_key', 'xuong-may-cho-moi-giac-mo')->delete();
    }
}
