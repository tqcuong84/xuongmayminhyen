<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;

use App\Models\Categories;
use App\Models\CategoryLanguage;
use App\Models\Comments;

class ServiceController extends Controller
{
    public function index(){
        Categories::setCategoryType(Categories::IS_SERVICE);
        $services = Categories::lists(config('env.LANGUAGE_DEFAULT'), 20);
        return view('admin.services', [
            "services" => $services,
            "has_pagination" => 1
        ]);
    }

    public function add(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        Categories::setCategoryType(Categories::IS_SERVICE_CATEGORIES);
        $service_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        return view('admin.service-add', [
            'result' => $result,
            'service_categories' => $service_categories
        ]);
    }

    public function postAdd(Request $request){
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required'
                ],
                'parent_id' => 'required'
            ]
        );
        $folder = trim($request->avatar_folder);
        if(empty($folder)){
            $folder = trim($request->main_banner_folder);
        }
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên dịch vụ';
                } else if($error_key == 'parent_id'){
                    $error_msg = 'Vui lòng chọn danh mục dịch vụ';
                }
            }
            $old_input = $request->input();
            if(!empty($request->avatar_file)){
                $old_input['avatar_file_post'] = '/storage/'.$folder.$request->avatar_file;
            }
            if(!empty($request->main_banner_file)){
                $old_input['main_banner_file_post'] = '/storage/'.$folder.$request->main_banner_file;
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($old_input);
        }
        $categories = new Categories();
        $categories->type = Categories::IS_SERVICE;
        $categories->parent_id = $request->parent_id;
        $categories->active = intval($request->active);
        $categories->show_index = intval($request->show_index);
        $categories->image = $request->avatar_file;
        $categories->image2 = $request->main_banner_file;
        $categories->folder = $folder;
        $categories->save();

        $category_language = new CategoryLanguage();
        $category_language->category_id = $categories->id;
        $category_language->language_code = config('env.LANGUAGE_DEFAULT');
        $category_language->name = $request->name;
        $category_language->description = $request->description;
        $category_language->content = $request->content;
        $category_language->name_seo = $request->name_seo;
        $category_language->description_seo = $request->description_seo;
        $category_language->keyword = $request->keyword;
        $category_language->save();


        return view('admin.service-add', [
            'result' => 'success'
        ]);
    }

    public function view(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.services');
        }
        $service = Categories::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($service->id) && $service->id)){
            return redirect()->route('admin.services');
        }
        $result = isset($request->result)?trim($request->result):'';
        Categories::setCategoryType(Categories::IS_SERVICE_CATEGORIES);
        $service_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        return view('admin.service-view',[
            'result' => $result,
            'service' => $service,
            'service_categories' => $service_categories
        ]);
    }

    public function postUpdate(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.services');
        }
        $service = Categories::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($service->id) && $service->id)){
            return redirect()->route('admin.services');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required'
                ],
                'parent_id' => 'required'
            ]
        );
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên dịch vụ';
                    /*if(isset($validator->errors()->unique()[0])){
                        $error_msg = 'Tên dịch vụ đã trùng với thông tin dịch vụ khác';
                    }*/
                } else if($error_key == 'parent_id'){
                    $error_msg = 'Vui lòng chọn danh mục dịch vụ';
                }
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($request->input());
        }

        $folder = trim($request->avatar_folder);
        if(empty($folder)){
            $folder = trim($request->main_banner_folder);
        }
        $categories = Categories::find($id);
        $categories->parent_id = $request->parent_id;
        $categories->active = intval($request->active);
        $categories->show_index = intval($request->show_index);
        $categories->image = $request->avatar_file;
        $categories->image2 = $request->main_banner_file;
        if($folder != $service->folder){
            $categories->folder = $folder;
        }
        $categories->save();

        CategoryLanguage::find(config('env.LANGUAGE_DEFAULT'), $service->id)->update([
            "name" => $request->name,
            "description" => $request->description,
            "content" => $request->content,
            "name_seo" => $request->name_seo,
            "description_seo" => $request->description_seo,
            "keyword" => $request->keyword,
        ]);

        return redirect()->route('admin.service.view', [
            'result' => 'success',
            'id' => $id
        ]);
    }

    public function delete(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.services');
        }
        $service = Categories::find($id);
        if(!(isset($service->id) && $service->id)){
            return redirect()->route('admin.services');
        }

        Categories::remove($id);

        return redirect()->route('admin.services');
    }

    public function review(){
        $comments = Comments::lists(config('env.LANGUAGE_DEFAULT'), 20);
        return view('admin.service-review', [
            "comments" => $comments,
            "has_pagination" => 1
        ]);
    }

    public function comment(Request $request){
        $comment_id = isset($request->comment_id)?intval($request->comment_id):0;
        if(!$comment_id){
            return response()->json([
                "status" => "fail",
                "message" => "Thiếu ID nhận xét"
            ]);
        }
        $comment = Comments::find($comment_id);
        if(!(isset($comment->id) && $comment->id)){
            return response()->json([
                "status" => "fail",
                "message" => "Không tìm thấy thông tin nhận xét"
            ]);
        }
        $reply_content = "";
        if(isset($comment->admin_reply->id)){
            $reply_content = $comment->admin_reply->content;
        }
        return response()->json([
            "status" => "success",
            "content" => $comment->content,
            "reply_content" => $reply_content
        ]);
    }

    public function replyComment(Request $request){
        $comment_id = isset($request->comment_id)?intval($request->comment_id):0;
        if(!$comment_id){
            return response()->json([
                "status" => "fail",
                "message" => "Thiếu ID nhận xét"
            ]);
        }
        $comment = Comments::find($comment_id);
        if(!(isset($comment->id) && $comment->id)){
            return response()->json([
                "status" => "fail",
                "message" => "Không tìm thấy thông tin nhận xét"
            ]);
        }
        $admin_reply_content = isset($request->admin_reply_content)?trim($request->admin_reply_content):'';
        if(empty($admin_reply_content)){
            return response()->json([
                "status" => "fail",
                "message" => "Thiếu nội dung trả lời nhận xét"
            ]);
        }

        $reply_comment = new Comments();
        if(isset($comment->admin_reply->id)){
            $reply_comment = $comment->admin_reply;
        }
        $reply_comment->is_xebagac = 1;
        $reply_comment->service_id = $comment->service_id;
        $reply_comment->reply_id = $comment->id;
        $reply_comment->content = $request->admin_reply_content;
        $reply_comment->save();

        return response()->json([
            "status" => "success"
        ]);
    }

    public function deleteReplyComment(Request $request){
        $comment_id = isset($request->comment_id)?intval($request->comment_id):0;
        if(!$comment_id){
            return response()->json([
                "status" => "fail",
                "message" => "Thiếu ID nhận xét"
            ]);
        }
        $comment = Comments::find($comment_id);
        if(!(isset($comment->id) && $comment->id)){
            return response()->json([
                "status" => "fail",
                "message" => "Không tìm thấy thông tin nhận xét"
            ]);
        }
        if(isset($comment->admin_reply->id)){
            $reply_comment = $comment->admin_reply;
            $reply_comment->delete();
        }

        return response()->json([
            "status" => "success"
        ]);
    }

    public function categories(Request $request){
        Categories::setCategoryType(Categories::IS_SERVICE_CATEGORIES);
        $service_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'), 20);
        return view('admin.service-categories', [
            "service_categories" => $service_categories,
            "has_pagination" => 1
        ]);
    }

    public function addCategory(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.service-category-add', [
            'result' => $result
        ]);
    }

    public function postAddCategory(Request $request){
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required'
                ]
            ]
        );
        $folder = trim($request->avatar_folder);
        if(empty($folder)){
            $folder = trim($request->main_banner_folder);
        }
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên danh mục dịch vụ';
                }
            }
            $old_input = $request->input();
            if(!empty($request->avatar_file)){
                $old_input['avatar_file_post'] = '/storage/'.$folder.$request->avatar_file;
            }
            if(!empty($request->main_banner_file)){
                $old_input['main_banner_file_post'] = '/storage/'.$folder.$request->main_banner_file;
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($old_input);
        }
        $categories = new Categories();
        $categories->type = Categories::IS_SERVICE_CATEGORIES;
        $categories->active = intval($request->active);
        $categories->image = $request->avatar_file;
        $categories->image2 = $request->main_banner_file;
        $categories->folder = $folder;
        $categories->save();

        $category_language = new CategoryLanguage();
        $category_language->category_id = $categories->id;
        $category_language->language_code = config('env.LANGUAGE_DEFAULT');
        $category_language->name = $request->name;
        $category_language->description = $request->description;
        $category_language->name_seo = $request->name_seo;
        $category_language->description_seo = $request->description_seo;
        $category_language->keyword = $request->keyword;
        $category_language->save();


        return view('admin.service-category-add', [
            'result' => 'success'
        ]);
    }

    public function viewCategory(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.services');
        }
        $service_category = Categories::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($service_category->id) && $service_category->id)){
            return redirect()->route('admin.service.categories');
        }
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.service-category-view',[
            'result' => $result,
            'service_category' => $service_category
        ]);
    }

    public function postUpdateCategory(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.service.categories');
        }
        $service = Categories::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($service->id) && $service->id)){
            return redirect()->route('admin.service.categories');
        }
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required'
                ]
            ]
        );
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên danh mục dịch vụ';
                }
            }
            return redirect()->back()
                ->withErrors($error_msg)
                ->withInput($request->input());
        }

        $folder = trim($request->avatar_folder);
        if(empty($folder)){
            $folder = trim($request->main_banner_folder);
        }
        $categories = Categories::find($id);
        $categories->active = intval($request->active);
        $categories->show_index = intval($request->show_index);
        $categories->image = $request->avatar_file;
        $categories->image2 = $request->main_banner_file;
        if($folder != $service->folder){
            $categories->folder = $folder;
        }
        $categories->save();

        CategoryLanguage::find(config('env.LANGUAGE_DEFAULT'), $service->id)->update([
            "name" => $request->name,
            "description" => $request->description,
            "name_seo" => $request->name_seo,
            "description_seo" => $request->description_seo,
            "keyword" => $request->keyword,
        ]);

        return redirect()->route('admin.service.category.view', [
            'result' => 'success',
            'id' => $id
        ]);
    }

    public function deleteCategory(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.service.categories');
        }
        $service_category = Categories::find($id);
        if(!(isset($service_category->id) && $service_category->id)){
            return redirect()->route('admin.service.categories');
        }

        Categories::remove($id);

        return redirect()->route('admin.service.categories');
    }
}
