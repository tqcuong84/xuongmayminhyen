<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;

use App\Models\Articles;
use App\Models\Advertisements;
use App\Models\Categories;
use App\Models\CategoryLanguage;

class ArticleController extends Controller
{

    public function index(){
        $top_banner = Advertisements::lists([
            'location' => 3
        ],1);
        $articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_ARTICLE, 5);
        $hot_articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_ARTICLE, 5, [], ['hotnews' => 1], true);
        
        return view('articles', array_merge([
            "top_banner" => $top_banner,
            "articles" => $articles,
            "hot_articles" => $hot_articles,
            "page_name" => 'articles'
        ], bindHeaderInfo([
            "meta_title" => settings('article-page-title'),
            "page_title" => settings('article-page-title'),
            "meta_description" => settings('article-meta-description'),
            "meta_keyword" => settings('article-meta-keyword'),
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }

    public function products(){
        $top_banner = Advertisements::lists([
            'location' => 6
        ],1);
        $articles = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_PRODUCT, 5);
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
            "meta_title" => settings('product-page-title'),
            "page_title" => settings('product-page-title'),
            "meta_description" => settings('product-meta-description'),
            "meta_keyword" => settings('product-meta-keyword'),
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }

    public function galleries(){
        $top_banner = Advertisements::lists([
            'location' => 4
        ],1);
        $galleries = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_GALLERY, 5);
        return view('galleries', array_merge([
            "top_banner" => $top_banner,
            "galleries" => $galleries,
            "total_page" => $galleries->lastPage(),
            "page_name" => 'galleries'
        ], bindHeaderInfo([
            "meta_title" => settings('galleries-page-title'),
            "page_title" => settings('galleries-page-title'),
            "meta_description" => settings('galleries-meta-description'),
            "meta_keyword" => settings('galleries-meta-keyword'),
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }

    public function loadMoreGalleries(){
        $galleries = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_GALLERY, 5);
        
        return response()->json([
            'code' => 1,
            'galleries' => $galleries
        ]);
    }

    public function productPhotos(){
        $top_banner = Advertisements::lists([
            'location' => 5
        ],1);
        $product_photos = Articles::lists(session('CURRENT_LANGUAGE'), Articles::IS_PRODUCT_PHOTO, 5, [], [], false, "hotnews");
        return view('product-photos', array_merge([
            "top_banner" => $top_banner,
            "product_photos" => $product_photos,
            "page_name" => 'product_photos'
        ], bindHeaderInfo([
            "meta_title" => settings('product-photos-page-title'),
            "page_title" => settings('product-photos-page-title'),
            "meta_description" => settings('product-photos-meta-description'),
            "meta_keyword" => settings('product-photos-meta-keyword'),
            "meta_image" => (isset($top_banner->banner_file) && !empty($top_banner->banner_file))?$top_banner->banner_file:'',
        ])));
    }
}
