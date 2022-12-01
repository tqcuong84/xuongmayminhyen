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
use Illuminate\Support\Facades\Route;

use App\Models\Articles;
use App\Models\ArticleLanguage;
use App\Models\Categories;
use App\Models\CategoryLanguage;

use  Carbon\Carbon;

class ArticleController extends Controller
{
    public function index(){
        $view_name = 'admin.articles';
        $add_url = 'admin.article.add';
        $view_url = 'admin.article.view';
        $delete_url = 'admin.article.delete';
        $article_type = Articles::IS_ARTICLE;
        $page_name = 'articles';
        if(Route::currentRouteName() == 'admin.products'){
            $article_type = Articles::IS_PRODUCT;
            $add_url = 'admin.product.add';
            $view_url = 'admin.product.view';
            $delete_url = 'admin.product.delete';
            $page_name = 'products';
        } else if(Route::currentRouteName() == 'admin.product-photos'){
            $article_type = Articles::IS_PRODUCT_PHOTO;
            $add_url = $view_url = $delete_url = '';
            $view_name = 'admin.product-photos';
            $page_name = 'product-photos';
        } else if(Route::currentRouteName() == 'admin.galleries'){
            $article_type = Articles::IS_GALLERY;
            $add_url = $view_url = $delete_url = '';
            $view_name = 'admin.galleries';
            $page_name = 'galleries';
        } else if(Route::currentRouteName() == 'admin.brands'){
            $article_type = Articles::IS_BRAND;
            $add_url = $view_url = $delete_url = '';
            $view_name = 'admin.brands';
            $page_name = 'brands';
        }
        $articles = Articles::lists(config('env.LANGUAGE_DEFAULT'), $article_type, 20);
        return view($view_name, [
            "articles" => $articles,
            "add_url" => $add_url,
            "view_url" => $view_url,
            "delete_url" => $delete_url,
            "page_name" => $page_name,
            "has_pagination" => 1
        ]);
    }

    public function add(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        $form_action = route('admin.article.postAdd');
        $list_url = route('admin.articles');
        $view_name = 'admin.article-add';
        $page_name = 'articles';
        $product_categories = [];
        if(Route::currentRouteName() == 'admin.product.add'){
            $form_action = route('admin.product.postAdd');
            $list_url = route('admin.products');
            $page_name = 'products';
            Categories::setCategoryType(Categories::IS_PRODUCT_CATEGORIES);
            $product_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        } else if(Route::currentRouteName() == 'admin.product-photo.add'){
            $view_name = 'admin.product-photo-add';
            $form_action = route('admin.product-photo.postAdd');
            $list_url = route('admin.product-photos');
            $page_name = 'product-photos';
        } else if(Route::currentRouteName() == 'admin.gallery.add'){
            $view_name = 'admin.gallery-add';
            $form_action = route('admin.gallery.postAdd');
            $list_url = route('admin.galleries');
            $page_name = 'galleries';
        } else if(Route::currentRouteName() == 'admin.brand.add'){
            $view_name = 'admin.brand-add';
            $form_action = route('admin.brand.postAdd');
            $list_url = route('admin.brands');
            $page_name = 'brands';
        }
        return view($view_name, [
            'result' => $result,
            'form_action' => $form_action,
            'list_url' => $list_url,
            'product_categories' => $product_categories,
            'page_name' => $page_name
        ]);
    }

    public function postAdd(Request $request){
        $view_name = 'admin.article-add';
        $form_action = route('admin.article.postAdd');
        $list_url = route('admin.articles');
        $article_type = Articles::IS_ARTICLE;
        $page_name = 'articles';
        $validator_input = [
            'title' => 'required',
            'content' => 'required',
            'avatar_file' => 'required'
        ];
        $product_categories = [];
        if(Route::currentRouteName() == 'admin.product.postAdd'){
            $form_action = route('admin.product.postAdd');
            $list_url = route('admin.products');
            $article_type = Articles::IS_PRODUCT;
            $page_name = 'products';
            Categories::setCategoryType(Categories::IS_PRODUCT_CATEGORIES);
            $product_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
            $validator_input['category_id'] = 'required';
        } else if(Route::currentRouteName() == 'admin.product-photo.postAdd'){
            $view_name = 'admin.product-photo-add';
            $article_type = Articles::IS_PRODUCT_PHOTO;
            $page_name = 'product-photos';
            $validator_input = [
                'title' => 'required',
                'avatar_file' => 'required'
            ];
        } else if(Route::currentRouteName() == 'admin.gallery.postAdd'){
            $view_name = 'admin.gallery-add';
            $form_action = route('admin.gallery.postAdd');
            $list_url = route('admin.galleries');
            $article_type = Articles::IS_GALLERY;
            $page_name = 'galleries';
            $validator_input = [
                'title' => 'required',
                'avatar_file' => 'required'
            ];
        } else if(Route::currentRouteName() == 'admin.brand.postAdd'){
            $view_name = 'admin.brand-add';
            $form_action = route('admin.brand.postAdd');
            $list_url = route('admin.brands');
            $article_type = Articles::IS_BRAND;
            $page_name = 'brands';
            $validator_input = [
                'title' => 'required',
                'avatar_file' => 'required'
            ];
        }
        $validator = Validator::make($request->all(), []);

        $validator = Validator::make(
            $request->all(),
            $validator_input
        );
        $folder = trim($request->avatar_folder);
        if(empty($folder) && isset($request->main_banner_folder)){
            $folder = trim($request->main_banner_folder);
        }
        if(empty($folder) && isset($request->product_photo_folder)){
            $folder = trim($request->product_photo_folder);
        }
        if ($validator->fails()) {
            $old_input = $request->input();
            if(!empty($request->avatar_file)){
                $old_input['avatar_file_post'] = '/storage/'.$folder.$request->avatar_file;
            }
            if(!empty($request->main_banner_file)){
                $old_input['main_banner_file_post'] = '/storage/'.$folder.$request->main_banner_file;
            }
            if(isset($request->multi_file_name) && is_array($request->multi_file_name) && count($request->multi_file_name)){
                $multi_file_name_post = [];
                foreach($request->multi_file_name as $multi_file_name){
                    $multi_file_name_post[] = [
                        'url' => '/storage/'.$folder.$multi_file_name,
                        'name' => $multi_file_name
                    ];
                }
                $old_input['multi_file_name_post'] = json_encode($multi_file_name_post);
            }
            $old_input['folder'] = trim($request->avatar_folder);
            if(isset($request->main_banner_folder)){
                $old_input['main_banner_folder'] = trim($request->main_banner_folder);
            }
            if(isset($request->product_photo_folder)){
                $old_input['product_photo_folder'] = trim($request->product_photo_folder);
            }
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($old_input);
        }
        $publish_date = '';
        if(!empty($request->publish_date)){
            $publish_date = convertToMysqlDate($request->publish_date);
        }
        $article = new Articles();
        $article->article_type = $article_type;
        $article->category_id =  (isset($request->category_id))?intval($request->category_id):0;
        $article->active = (isset($request->active))?intval($request->active):0;
        $article->is_homepage = (isset($request->is_homepage))?intval($request->is_homepage):0;
        $article->hotnews = (isset($request->hotnews))?intval($request->hotnews):0;
        if($article->hotnews){
            $article->hotnews_time = time();
        }
        $article->image = $request->avatar_file;
        $article->image2 = ($request->main_banner_file !== null)?$request->main_banner_file:'';
        $article->folder = $folder;
        $article->publish_date = (!empty($publish_date))?$publish_date:Carbon::now()->format('Y-m-d');
        if(isset($request->multi_file_name) && is_array($request->multi_file_name) && count($request->multi_file_name)){
            $photos_array = [];
            foreach($request->multi_file_name as $multi_file_name){
                $photos_array[] = $multi_file_name;
            }
            $article->photos = json_encode($photos_array);
        }
        $article->save();

        $article_language = new ArticleLanguage();
        $article_language->article_id = $article->id;
        $article_language->language_code = config('env.LANGUAGE_DEFAULT');
        $article_language->title = $request->title;
        $article_language->description = $request->description;
        $article_language->content = $request->content;
        $article_language->title_seo = $request->title_seo;
        $article_language->description_seo = $request->description_seo;
        $article_language->keyword = $request->keyword;
        $article_language->save();

        return view($view_name, [
            'result' => 'success',
            'product_categories' => $product_categories,
            'page_name' => $page_name,
            'form_action' => $form_action,
            'list_url' => $list_url,
        ]);
    }

    public function view(Request $request){
        $view_name = 'admin.article-view';
        $route_list = 'admin.articles';
        $form_action = route('admin.article.postUpdate');
        $list_url = route('admin.articles');
        $page_name = 'articles';
        $product_categories = [];
        if(Route::currentRouteName() == 'admin.product.view'){
            $route_list = 'admin.products';
            $form_action = route('admin.product.postUpdate');
            $list_url = route('admin.products');
            $page_name = 'products';
            Categories::setCategoryType(Categories::IS_PRODUCT_CATEGORIES);
            $product_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
        } else if(Route::currentRouteName() == 'admin.product-photo.view'){
            $view_name = 'admin.product-photo-view';
            $route_list = 'admin.product-photos';
            $form_action = route('admin.product-photo.postUpdate');
            $list_url = route('admin.product-photos');
            $page_name = 'product-photos';
        } else if(Route::currentRouteName() == 'admin.gallery.view'){
            $view_name = 'admin.gallery-view';
            $route_list = 'admin.galleries';
            $form_action = route('admin.gallery.postUpdate');
            $list_url = route('admin.galleries');
            $page_name = 'galleries';
        } else if(Route::currentRouteName() == 'admin.brand.view'){
            $view_name = 'admin.brand-view';
            $route_list = 'admin.brands';
            $form_action = route('admin.brand.postUpdate');
            $list_url = route('admin.brands');
            $page_name = 'brands';
        }
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route($route_list);
        }
        $article = Articles::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($article->id) && $article->id)){
            return redirect()->route($route_list);
        }
        $article->parse_photos = '';
        if(!empty($article->photos)){
            $parse_photos = [];
            $photos = json_decode($article->photos, true);
            if(is_array($photos) && count($photos)){
                foreach($photos as $photo){
                    $parse_photos[] = [
                        'url' => '/storage/'.$article->folder.$photo,
                        'name' => $photo
                    ];
                }
                $article->parse_photos = json_encode($parse_photos);
            }
        }
        $result = isset($request->result)?trim($request->result):'';
        return view($view_name,[
            'result' => $result,
            'article' => $article,
            'list_url' => $list_url,
            'form_action' => $form_action,
            'product_categories' => $product_categories,
            'page_name' => $page_name
        ]);
    }

    public function postUpdate(Request $request){
        $view_name = 'admin.article.view';
        $route_list = 'admin.articles';
        $validator_input = [
            'title' => 'required',
            'content' => 'required',
            'avatar_file' => 'required'
        ];
        if(Route::currentRouteName() == 'admin.product.postUpdate'){
            $route_list = 'admin.products';
            $view_name = 'admin.product.view';
            $validator_input['category_id'] = 'required';
        } else if(Route::currentRouteName() == 'admin.product-photo.postUpdate'){
            $route_list = 'admin.product-photos';
            $view_name = 'admin.product-photo.view';
            $validator_input = [
                'title' => 'required',
                'avatar_file' => 'required'
            ];
        } else if(Route::currentRouteName() == 'admin.gallery.postUpdate'){
            $route_list = 'admin.galleries';
            $view_name = 'admin.gallery.view';
            $validator_input = [
                'title' => 'required',
                'avatar_file' => 'required'
            ];
        } else if(Route::currentRouteName() == 'admin.brand.postUpdate'){
            $route_list = 'admin.brands';
            $view_name = 'admin.brand.view';
            $validator_input = [
                'title' => 'required',
                'avatar_file' => 'required'
            ];
        }
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route($route_list);
        }
        $article = Articles::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($article->id) && $article->id)){
            return redirect()->route($route_list);
        }
        $validator = Validator::make(
            $request->all(),
            $validator_input
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->first())
                ->withInput($request->input());
        }

        $folder = trim($request->avatar_folder);
        if(empty($folder) && isset($request->main_banner_folder)){
            $folder = trim($request->main_banner_folder);
        }
        if(empty($folder) && isset($request->product_photo_folder)){
            $folder = trim($request->product_photo_folder);
        }
        $publish_date = $article->publish_date;
        if(!empty($request->publish_date)){
            $publish_date = convertToMysqlDate($request->publish_date);
        }
        $article = Articles::find($id);
        $article->category_id =  (isset($request->category_id))?intval($request->category_id):0;
        $article->active = (isset($request->active))?intval($request->active):0;
        $article->is_homepage = (isset($request->is_homepage))?intval($request->is_homepage):0;
        $hotnews = (isset($request->hotnews))?intval($request->hotnews):0;
        if(!$article->hotnews && $hotnews){
            $article->hotnews_time = time();
        }
        $article->hotnews = $hotnews;
        $article->image = $request->avatar_file;
        $article->image2 = ($request->main_banner_file !== null)?$request->main_banner_file:'';
        if($folder != $article->folder){
            $article->folder = $folder;
        }
        $article->publish_date = $publish_date;
        if(isset($request->multi_file_name) && is_array($request->multi_file_name) && count($request->multi_file_name)){
            $photos_array = [];
            foreach($request->multi_file_name as $multi_file_name){
                $photos_array[] = $multi_file_name;
            }
            $article->photos = json_encode($photos_array);
        }
        $article->save();

        ArticleLanguage::find(config('env.LANGUAGE_DEFAULT'), $article->id)->update([
            "title" => $request->title,
            "description" => $request->description,
            "content" => $request->content,
            "title_seo" => $request->title_seo,
            "description_seo" => $request->description_seo,
            "keyword" => $request->keyword,
        ]);

        return redirect()->route($view_name, [
            'result' => 'success',
            'id' => $id
        ]);
    }

    public function delete(Request $request){
        $list_url = 'admin.articles';
        if(Route::currentRouteName() == 'admin.product.delete'){
            $list_url = 'admin.products';
        } else if(Route::currentRouteName() == 'admin.product-photo.delete'){
            $list_url = 'admin.product-photos';
        } else if(Route::currentRouteName() == 'admin.gallery.delete'){
            $list_url = 'admin.galleries';
        } else if(Route::currentRouteName() == 'admin.brand.delete'){
            $list_url = 'admin.brands';
        }
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route($list_url);
        }
        $article = Articles::find($id);
        if(!(isset($article->id) && $article->id)){
            return redirect()->route($list_url);
        }

        Articles::remove($id);

        return redirect()->route($list_url);
    }

    public function categories(Request $request){
        Categories::setCategoryType(Categories::IS_PRODUCT_CATEGORIES);
        $product_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'), 20);
        return view('admin.product-categories', [
            "product_categories" => $product_categories,
            "has_pagination" => 1
        ]);
    }

    public function addCategory(Request $request){
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.product-category-add', [
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
        $categories->type = Categories::IS_PRODUCT_CATEGORIES;
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


        return view('admin.product-category-add', [
            'result' => 'success'
        ]);
    }

    public function viewCategory(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.services');
        }
        $product_category = Categories::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($product_category->id) && $product_category->id)){
            return redirect()->route('admin.service.categories');
        }
        $result = isset($request->result)?trim($request->result):'';
        return view('admin.product-category-view',[
            'result' => $result,
            'product_category' => $product_category
        ]);
    }

    public function postUpdateCategory(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.product.categories');
        }
        $service = Categories::get(config('env.LANGUAGE_DEFAULT'), $id);
        if(!(isset($service->id) && $service->id)){
            return redirect()->route('admin.product.categories');
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

        return redirect()->route('admin.product.category.view', [
            'result' => 'success',
            'id' => $id
        ]);
    }

    public function deleteCategory(Request $request){
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('admin.product.categories');
        }
        $product_category = Categories::find($id);
        if(!(isset($product_category->id) && $product_category->id)){
            return redirect()->route('admin.product.categories');
        }

        Categories::remove($id);

        return redirect()->route('admin.product.categories');
    }
}
