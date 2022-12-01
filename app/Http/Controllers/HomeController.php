<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL; 
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

use App\Models\Advertisements;
use App\Models\Articles;
use App\Models\Testimonials;
use App\Models\Categories;
use App\Models\Comments;
use App\Models\KeywordSearchCount;
use App\Models\StaticHtml;
use App\Models\RentalContact;
use App\Jobs\SendContactUsJob;
use Jenssegers\Agent\Agent;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $agent = new Agent();
        $home_page_banner = Advertisements::lists([
            'location' => 1
        ],($agent->isMobile()?1:2));
        $latest_product_articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_PRODUCT, 3);
        $latest_articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_ARTICLE, 4);
        $product_photos = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_PRODUCT_PHOTO, 6, [], ["is_homepage" => 1], false, "hotnews");
        $galleries = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_GALLERY, 9, [], ["is_homepage" => 1]);
        $brands = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_BRAND, 9, [], ["is_homepage" => 1]);
        
        

        $article_banner = Advertisements::lists([
            'location' => 7
        ],1);

        $product_photo_banner = Advertisements::lists([
            'location' => 8
        ],1);

        $contact_banner = Advertisements::lists([
            'location' => 9
        ],1);

        if($home_page_banner){
            if($agent->isMobile()){
                $home_page_banner['name'] = str_replace("\n","<br />",$home_page_banner['name']);
                $home_page_banner['note'] = str_replace("\n","<br />",$home_page_banner['note']);
            } else{
                foreach($home_page_banner as &$home_page_banner_item){
                    $home_page_banner_item['name'] = str_replace("\n","<br />",$home_page_banner_item['name']);
                    $home_page_banner_item['note'] = str_replace("\n","<br />",$home_page_banner_item['note']);
                }
            }
        }
        
        return view('home', array_merge([
            "home_page_banner" => $home_page_banner,
            "latest_product_articles" => $latest_product_articles,
            "latest_articles" => $latest_articles,
            "product_photos" => $product_photos,
            "galleries" => $galleries,
            "brands" => $brands,
            "article_banner" => $article_banner,
            "product_photo_banner" => $product_photo_banner,
            "contact_banner" => $contact_banner,
            "is_homepage" => 1,
            "page_name" => 'homepage'
        ], bindHeaderInfo([
            "meta_title" => settings('page-title'),
            "page_title" => settings('page-title'),
            "meta_description" => settings('meta-description'),
            "meta_keyword" => settings('meta-keyword'),
            "meta_image" => '',
        ])));
    }

    public function slug(Request $request){
        $slug = (isset($request->slug))?$request->slug:'';
        $id = isset($request->id)?intval($request->id):0;
        if(!$id){
            return redirect()->route('homepage');
        }

        $product_category = Categories::get(session('CURRENT_LANGUAGE'), $id);
        if(isset($product_category->id) && $product_category->id && $slug == $product_category->slug){
            if($product_category->type == Categories::IS_PRODUCT_CATEGORIES){
                $top_banner = Advertisements::lists([
                    'location' => 6
                ],1);
                $articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_PRODUCT, 5, [], ['category_id' => $product_category->id]);
                $hot_articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_PRODUCT, 5, [], ['hotnews' => 1], true);
                Categories::setCategoryType(Categories::IS_PRODUCT_CATEGORIES);
                $product_categories = Categories::lists(config('env.LANGUAGE_DEFAULT'));
                
                return view('articles', array_merge([
                    "top_banner" => $top_banner,
                    "articles" => $articles,
                    "hot_articles" => $hot_articles,
                    "product_categories" => $product_categories,
                    "page_name" => 'products'
                ], bindHeaderInfo([
                    "meta_title" => $product_category->name,
                    "page_title" => $product_category->name,
                    "meta_description" => $product_category->description_seo,
                    "meta_keyword" => $product_category->keyword,
                    "meta_image" => !empty($product_category->avatar_file)?$product_category->avatar_file:'',
                ])));
            }
        }

        $article = Articles::get(session('CURRENT_LANGUAGE'), $id);
        if(isset($article->id) && $article->id && $slug == $article->slug){
            if($article->article_type == Articles::IS_ARTICLE || $article->article_type == Articles::IS_PRODUCT){
                $top_banner = Advertisements::lists([
                    'location' => 3
                ],1);
                $hot_articles = Articles::lists(session('CURRENT_LANGUAGE'), $article->article_type, 5, [], ['hotnews' => 1], true);

                $page_name = 'articles';
                if($article->article_type == Articles::IS_PRODUCT){
                    $page_name = 'products';
                }
                $parse_keyword_array = parseKeyword($article->content);
                $article->content = $parse_keyword_array['content'];
                if(isset($parse_keyword_array['keyword_id']) && count($parse_keyword_array['keyword_id'])){
                    foreach($parse_keyword_array['keyword_id'] as $keyword_id){
                        KeywordSearchCount::updateCount($keyword_id, [
                            'article_id' => $article->id,
                            'title' => $article->title,
                            'url' => $article->url_details
                        ]);
                    }
                }
                return view('article-details', array_merge([
                    "article" => $article,
                    "top_banner" => $top_banner,
                    "hot_articles" => $hot_articles,
                    "page_name" => $page_name
                ], bindHeaderInfo([
                    "meta_title" => (!empty($article->title_seo))?$article->title_seo:$article->title,
                    "page_title" => $article->title,
                    "meta_description" => $article->description_seo,
                    "meta_keyword" => $article->keyword,
                    "meta_image" => !empty($article->avatar_file)?$article->avatar_file:'',
                ])));
            } else if($article->article_type == Articles::IS_PRODUCT_PHOTO){
                $page = isset($request->page)?intval($request->page):1;
                $top_banner = Advertisements::lists([
                    'location' => 5
                ],1);
                $limit = 5;
                $from = ($page - 1) * $limit;
                $total_page = 0;
                $photos = [];
                if(!empty($article->photos)){
                    $photos_array = json_decode($article->photos, true);
                    $count = 0;
                    if(is_array($photos_array)){
                        foreach($photos_array as $photo_key => $photo){
                            if($photo_key >= $from){
                                $photos[] = [
                                    'index' => $photo_key,
                                    'url' => '/storage/'.$article->folder.$photo
                                ];
                                $count++;
                                if($count >= $limit){
                                    break;
                                }
                            }
                        }
                        $total_page = ceil(count($photos_array) / $limit);
                    }
                }

                return view('product-photo-details', array_merge([
                    "article" => $article,
                    "top_banner" => $top_banner,
                    "photos" => $photos,
                    "total_page" => $total_page,
                    "page_name" => 'product-photo-details'
                ], bindHeaderInfo([
                    "meta_title" => $article->title,
                    "page_title" => $article->title,
                    "meta_description" => '',
                    "meta_keyword" => '',
                    "meta_image" => !empty($article->avatar_file)?$article->avatar_file:'',
                ])));
            }
        }
        return redirect()->route('homepage');
    }

    public function contact(Request $request){
        $result = isset($request->result)?$request->result:'';
        $top_banner = Advertisements::lists([
            'location' => 5
        ],1);
        return view('contactus', array_merge([
            'result' => $result,
            'top_banner' => $top_banner,
            "page_name" => 'contact-us'
        ], bindHeaderInfo([
            "meta_title" => settings('contact-page-title'),
            "page_title" => settings('contact-page-title'),
            "meta_description" => settings('contact-meta-description'),
            "meta_keyword" => settings('contact-meta-keyword'),
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }

    public function postContact(Request $request){
        $validator = Validator::make($request->all(), []);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'content' => 'required'
            ]
        );
        if ($validator->fails()) {
            $error_msg = $validator->errors()->first();
            foreach($validator->errors()->keys() as $error_key) {
                if($error_key == 'name'){
                    $error_msg = 'Vui lòng nhập tên của quý khách';
                    break;
                } else if($error_key == 'phone'){
                    $error_msg = 'Vui lòng nhập số điện thoại';
                    break;
                } else if($error_key == 'content'){
                    $error_msg = 'Vui lòng nhập nội dung liên hệ';
                    break;
                }
            }
            return response()->json([
                'code' => 0,
                'error' => $error_msg
            ], 422);
        }
        SendContactUsJob::dispatchNow($request);
        
        return response()->json([
            'code' => 1
        ]);
    }

    public function search(Request $request){
        $keyword = isset($request->keyword)?trim($request->keyword):'';
        $page = isset($request->page)?intval($request->page):1;
        $top_banner = Advertisements::lists([
            'location' => 1
        ],1);
        $search_results = [];
        $has_pagination = $has_result = 0;
        if(!empty($keyword)){
            $results = [];
            Categories::setCategoryType(Categories::IS_SERVICE);
            $services = Categories::lists(session('CURRENT_LANGUAGE'), 0, ["name" => $keyword]);
            if($services){
                foreach($services as $service){
                    $results[] = [
                        "avatar_file" => $service->avatar_file,
                        "title" => $service->name,
                        "description" => $service->description,
                        "url_details" => $service->service_url
                    ];
                }
                $has_result = 1;
            }
            $articles = Articles::lists(session('CURRENT_LANGUAGE'), 50, [], ["title" => $keyword]);
            if($articles){
                foreach($articles as $article){
                    $results[] = [
                        "avatar_file" => $article->avatar_file,
                        "title" => $article->title,
                        "description" => $article->description,
                        "url_details" => $article->url_details,
                        "publish_time_part" => $article->publish_time_part,
                    ];
                }
                $has_result = 1;
            }
            $results_collection = Collection::make($results);;
            $total = count($results);
            $limit = 3;
            $from = ($page - 1) * $limit;
            $search_results = new LengthAwarePaginator($results_collection->forPage($page, $limit), $results_collection->count(), $limit, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]);
            if($total > $limit){
                $has_pagination = 1;
            }
        }

        return view('search', array_merge([
            'search_results' => $search_results,
            'has_pagination' => $has_pagination,
            'has_result' => $has_result,
            'top_banner' => $top_banner
        ], bindHeaderInfo([
            "meta_title" => 'Kết quả tìm kiếm',
            "page_title" => 'Kết quả tìm kiếm',
            "meta_description" => '',
            "meta_keyword" => '',
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }

    public function html(Request $request){
        $currentURL = URL::current();
        $currentURL = str_replace(config('app.url'),"",$currentURL);
        $currentURL =str_replace(".html","",$currentURL);
        $html_key = str_replace("/","",$currentURL);
        if(empty($html_key)){
            abort(404);
        }
        $html = StaticHtml::getByKey(session('CURRENT_LANGUAGE'), $html_key)->toArray();
        $page_name = "";
        if($html['html_key'] == "gioi-thieu"){
            $page_name = "about-us";
        } else if($html['html_key'] == "bao-gia"){
            $page_name = "quote";
        }
        $hot_articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_ARTICLE, 5, [], ['hotnews' => 1], true);
        return view('html', array_merge([
            'html' => $html,
            'hot_articles' => $hot_articles,
            "page_name" => $page_name
        ], bindHeaderInfo([
            "meta_title" => $html['page_title'],
            "page_title" => $html['page_title'],
            "meta_description" => $html['meta_description'],
            "meta_keyword" => $html['meta_keyword'],
            "meta_image" => (!empty($html['main_banner_file']))?$html['main_banner_file']:'',
        ])));
    }   
}
