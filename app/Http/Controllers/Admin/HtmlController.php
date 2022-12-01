<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;

use App\Models\StaticHtml;

class HtmlController extends Controller
{

    public function index(Request $request)
    {
        $id = (isset($request->id))?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.home');
        }
        $static_html = StaticHtml::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($static_html->id) && $static_html->id)){
            return redirect()->route('admin.home');
        }
        return view('admin.html',[
            'result' => '',
            'static_html' => $static_html
        ]);
    }

    public function postUpdate(Request $request)
    {
        $id = (isset($request->id))?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.home');
        }
        $static_html = StaticHtml::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($static_html->id) && $static_html->id)){
            return redirect()->route('admin.home');
        }
        $static_html->update([
            "banner_file" => isset($request->main_banner_file)?trim($request->main_banner_file):'',
            "folder" => (isset($request->main_banner_folder))?trim($request->main_banner_folder):''
        ]);

        $static_html->updateLanguage(config('env.LANGUAGE_DEFAULT'), $id, [
            "content" => isset($request->content)?trim($request->content):'',
            "page_title" => isset($request->page_title)?trim($request->page_title):'',
            "meta_description" => isset($request->meta_description)?trim($request->meta_description):'',
            "meta_keyword" => isset($request->meta_keyword)?trim($request->meta_keyword):'',
        ]);

        $static_html = StaticHtml::get(config('env.LANGUAGE_DEFAULT'), $id);

        return view('admin.html',[
            'result' => 'success',
            'static_html' => $static_html
        ]);
    }
}
