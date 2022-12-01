<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([
    'middleware' => ['load.services']
],function(){
    Route::get('/', 'HomeController@index')->name('homepage');
    
    Route::get('/lien-he.html', 'HomeController@contact')->name('contact.us');  
    Route::post('/lien-he.html', 'HomeController@postContact')->name('postContactUs');  
    Route::get('/tim-kiem.html', 'HomeController@search')->name('search');

    Route::get('/gioi-thieu.html', 'HomeController@html')->name('about.us');
    Route::get('/chinh-sach-bao-hanh-hang-hoa.html', 'HomeController@html')->name('goods.warranty.policy');
    Route::get('/chinh-sach-thanh-toan.html', 'HomeController@html')->name('payment.policy');
    Route::get('/bao-gia.html', 'HomeController@html')->name('quote');

    Route::get('/san-pham.html', 'ArticleController@products')->name('products');
    Route::get('/kinh-nghiem-gia-cong.html', 'ArticleController@index')->name('machining-experience');
    Route::get('/hinh-anh-san-pham.html', 'ArticleController@productPhotos')->name('product-photos');
    Route::get('/load-more-product-photos.html', 'ArticleController@loadMoreProductPhotos')->name('load-more-product-photos');
    Route::get('/galleries.html', 'ArticleController@galleries')->name('galleries');
    Route::get('/load-more-galleries.html', 'ArticleController@loadMoreGalleries')->name('load-more-galleries');
    
    Route::post('/contact', 'HomeController@postContact')->name('contact.us');
    
    Route::get('/{slug}_{id}.html', 'HomeController@slug');
    Route::post('/review-service', "ServiceController@review")->name('service.review');
});
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['load.main_menu']
], function () {
    Route::get('/login', 'UserController@login')->name('admin.login')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/login', 'UserController@postLogin')->name('admin.postLogin')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
    Route::group(['middleware' => ['auth']], function () {
        Route::post('/logout', 'UserController@logout')->name('admin.logout');
        Route::get('/', "HomeController@index")->name('admin.home');

        Route::get('/districts', "HomeController@getDistricts")->name('admin.get-districts');
        Route::get('/wards', "HomeController@getWards")->name('admin.get-wards');


        Route::get('/settings', "SettingController@index")->name('admin.settings');
        Route::post('/settings', "SettingController@postUpdate")->name('admin.settings.postUpdate');

        Route::get('/users', "UserController@index")->name('admin.users');
        Route::get('/user/add', "UserController@add")->name('admin.user.add');
        Route::post('/user/add', "UserController@postAdd")->name('admin.user.postAdd');
        Route::get('/user/view', "UserController@view")->name('admin.user.view');
        Route::post('/user/view', "UserController@postUpdate")->name('admin.user.postUpdate');
        Route::post('/user/delete', "UserController@delete")->name('admin.user.delete');

        Route::get('/setting', "UserController@index")->name('admin.setting');
        Route::get('/advertisements', "AdvertisementController@index")->name('admin.advertisements');
        Route::get('/advertisement/add', "AdvertisementController@add")->name('admin.advertisement.add');
        Route::post('/advertisement/add', "AdvertisementController@postAdd")->name('admin.advertisement.postAdd');
        Route::get('/advertisement/view', "AdvertisementController@view")->name('admin.advertisement.view');
        Route::post('/advertisement/view', "AdvertisementController@postUpdate")->name('admin.advertisement.postUpdate');
        Route::get('/advertisement/delete', "AdvertisementController@delete")->name('admin.advertisement.delete');
        Route::get('/services', "ServiceController@index")->name('admin.services');
        Route::get('/service/add', "ServiceController@add")->name('admin.service.add');
        Route::post('/service/add', "ServiceController@postAdd")->name('admin.service.postAdd');
        Route::get('/service/view', "ServiceController@view")->name('admin.service.view');
        Route::post('/service/view', "ServiceController@postUpdate")->name('admin.service.postUpdate');
        Route::get('/service/delete', "ServiceController@delete")->name('admin.service.delete');
        Route::get('/service/review', "ServiceController@review")->name('admin.service.review');
        Route::get('/service/comment', "ServiceController@comment")->name('admin.service.comment');
        Route::post('/service/reply-comment', "ServiceController@replyComment")->name('admin.service.replyComment');
        Route::post('/service/delete-reply-comment', "ServiceController@deleteReplyComment")->name('admin.service.deleteReplyComment');

        Route::get('/service/categories', "ServiceController@categories")->name('admin.service.categories');
        Route::get('/service/category/add', "ServiceController@addCategory")->name('admin.service.category.add');
        Route::post('/service/category/add', "ServiceController@postAddCategory")->name('admin.service.category.postAdd');
        Route::get('/service/category/view', "ServiceController@viewCategory")->name('admin.service.category.view');
        Route::post('/service/category/view', "ServiceController@postUpdateCategory")->name('admin.service.category.postUpdate');
        Route::get('/service/category/delete', "ServiceController@deleteCategory")->name('admin.service.category.delete');

        Route::get('/articles', "ArticleController@index")->name('admin.articles');
        Route::get('/article/add', "ArticleController@add")->name('admin.article.add');
        Route::post('/article/add', "ArticleController@postAdd")->name('admin.article.postAdd');
        Route::get('/article/view', "ArticleController@view")->name('admin.article.view');
        Route::post('/article/view', "ArticleController@postUpdate")->name('admin.article.postUpdate');
        Route::get('/article/delete', "ArticleController@delete")->name('admin.article.delete');

        Route::get('/products', "ArticleController@index")->name('admin.products');
        Route::get('/product/add', "ArticleController@add")->name('admin.product.add');
        Route::post('/product/add', "ArticleController@postAdd")->name('admin.product.postAdd');
        Route::get('/product/view', "ArticleController@view")->name('admin.product.view');
        Route::post('/product/view', "ArticleController@postUpdate")->name('admin.product.postUpdate');
        Route::get('/product/delete', "ArticleController@delete")->name('admin.product.delete');

        Route::get('/product/categories', "ArticleController@categories")->name('admin.product.categories');
        Route::get('/product/category/add', "ArticleController@addCategory")->name('admin.product.category.add');
        Route::post('/product/category/add', "ArticleController@postAddCategory")->name('admin.product.category.postAdd');
        Route::get('/product/category/view', "ArticleController@viewCategory")->name('admin.product.category.view');
        Route::post('/product/category/view', "ArticleController@postUpdateCategory")->name('admin.product.category.postUpdate');
        Route::get('/product/category/delete', "ArticleController@deleteCategory")->name('admin.product.category.delete');

        Route::get('/product-photos', "ArticleController@index")->name('admin.product-photos');
        Route::get('/product-photo/add', "ArticleController@add")->name('admin.product-photo.add');
        Route::post('/product-photo/add', "ArticleController@postAdd")->name('admin.product-photo.postAdd');
        Route::get('/product-photo/view', "ArticleController@view")->name('admin.product-photo.view');
        Route::post('/product-photo/view', "ArticleController@postUpdate")->name('admin.product-photo.postUpdate');
        Route::get('/product-photo/delete', "ArticleController@delete")->name('admin.product-photo.delete');

        Route::get('/galleries', "ArticleController@index")->name('admin.galleries');
        Route::get('/gallery/add', "ArticleController@add")->name('admin.gallery.add');
        Route::post('/gallery/add', "ArticleController@postAdd")->name('admin.gallery.postAdd');
        Route::get('/gallery/view', "ArticleController@view")->name('admin.gallery.view');
        Route::post('/gallery/view', "ArticleController@postUpdate")->name('admin.gallery.postUpdate');
        Route::get('/gallery/delete', "ArticleController@delete")->name('admin.gallery.delete');

        Route::get('/brands', "ArticleController@index")->name('admin.brands');
        Route::get('/brand/add', "ArticleController@add")->name('admin.brand.add');
        Route::post('/brand/add', "ArticleController@postAdd")->name('admin.brand.postAdd');
        Route::get('/brand/view', "ArticleController@view")->name('admin.brand.view');
        Route::post('/brand/view', "ArticleController@postUpdate")->name('admin.brand.postUpdate');
        Route::get('/brand/delete', "ArticleController@delete")->name('admin.brand.delete');

        Route::get('/html/{id}', 'HtmlController@index');
        Route::post('/html/{id}', 'HtmlController@postUpdate')->name('admin.html.postUpdate');

        Route::post('/ckeditor/image_upload', 'CKEditorController@upload')->name('upload');

        Route::post('/upload', 'UploadController@upload')->name('admin.upload_file');
    });
});
