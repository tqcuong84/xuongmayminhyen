<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertStaticHtml extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $id = DB::table('static_html')->insertGetId([
            'title' => 'Hướng dẫn thuê xe',
            'html_key' => 'huong-dan-thue-xe'
        ]);
        DB::table('static_html_language')->insert([
            'static_html_id' => $id,
            'language_code' => 'vn',
            'page_title' => 'Hướng dẫn thuê xe'
        ]);


        $id = DB::table('static_html')->insertGetId([
            'title' => 'Chính sách bảo hành hàng hóa',
            'html_key' => 'chinh-sach-bao-hanh-hang-hoa'
        ]);
        DB::table('static_html_language')->insert([
            'static_html_id' => $id,
            'language_code' => 'vn',
            'page_title' => 'Chính sách bảo hành hàng hóa'
        ]);


        $id = DB::table('static_html')->insertGetId([
            'title' => 'Chính sách thanh toán',
            'html_key' => 'chinh-sach-thanh-toan'
        ]);
        DB::table('static_html_language')->insert([
            'static_html_id' => $id,
            'language_code' => 'vn',
            'page_title' => 'Chính sách thanh toán'
        ]);


        $id = DB::table('static_html')->insertGetId([
            'title' => 'Bảng giá ưu đãi',
            'html_key' => 'bang-gia-uu-dai'
        ]);
        DB::table('static_html_language')->insert([
            'static_html_id' => $id,
            'language_code' => 'vn',
            'page_title' => 'Bảng giá ưu đãi'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('static_html')->where('title', 'Hướng dẫn thuê xe')->delete();
        DB::table('static_html_language')->where('page_title', 'Hướng dẫn thuê xe')->delete();

        DB::table('static_html')->where('title', 'Chính sách bảo hành hàng hóa')->delete();
        DB::table('static_html_language')->where('page_title', 'Chính sách bảo hành hàng hóa')->delete();

        DB::table('static_html')->where('title', 'Chính sách thahnh toán')->delete();
        DB::table('static_html_language')->where('page_title', 'Chính sách thahnh toán')->delete();

        DB::table('static_html')->where('title', 'Bảng giá ưu đãi')->delete();
        DB::table('static_html_language')->where('page_title', 'Bảng giá ưu đãi')->delete();
    }
}
