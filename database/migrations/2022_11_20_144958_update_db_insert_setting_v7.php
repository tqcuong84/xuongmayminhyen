<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDbInsertSettingV7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            'comment' => 'Đối Tác Của Chúng Tôi',
            'setting_key' => 'doi-tac-cua-chung-toi'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->where('setting_key', 'doi-tac-cua-chung-toi')->delete();
    }
}
