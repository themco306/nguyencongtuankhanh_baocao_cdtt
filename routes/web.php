<?php

use App\Http\Controllers\backend\BrandController;
//
use App\Http\Controllers\backend\CategoryController;
//
use App\Http\Controllers\backend\ContactController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\PageController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\TopicController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\SiteController;
use App\Http\Controllers\frontend\SiteContactController;
use App\Http\Controllers\frontend\SiteLoginController;
use App\Http\Controllers\frontend\SiteCartController;
use App\Http\Controllers\frontend\SiteAccountController;
use App\Http\Controllers\frontend\SiteCheckoutController;
use App\View\Components\SiteSearch;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('lien-he', [SiteContactController::class, 'index'])->name('site.lienhe');
Route::post('lien-he', [SiteContactController::class, 'store'])->name('site.postlienhe');
Route::get('san-pham', [SiteController::class, 'all_product'])->name('site.all_product');
Route::get('bai-viet', [SiteController::class, 'all_post'])->name('site.all_post');

Route::post('dang-ky', [SiteLoginController::class, 'register'])->name('site.register');
Route::get('dang-nhap', [SiteLoginController::class, 'getlogin'])->name('site.getlogin');
Route::post('dang-nhap', [SiteLoginController::class, 'postlogin'])->name('site.postlogin');
Route::get('xac-nhan/{id}/{actived_token}', [SiteLoginController::class, 'actived'])->name('site.actived');
Route::get('xac-nhan-lai/{id}', [SiteLoginController::class, 'actived_again'])->name('site.actived_again');

Route::get('lay-lai-mat-khau', [SiteLoginController::class, 'forget_password'])->name('site.forget_password');
Route::post('lay-lai-mat-khau', [SiteLoginController::class, 'postforget_password'])->name('site.postforget_password');
Route::get('dat-lai-mat-khau/{id}/{actived_token}', [SiteLoginController::class, 'get_password'])->name('site.get_password');
Route::post('dat-lai-mat-khau/{id}', [SiteLoginController::class, 'postget_password'])->name('site.postget_password');

Route::get('dang-xuat', [SiteLoginController::class, 'logout'])->name('site.logout');

Route::get('yeu-thich', [SiteAccountController::class, 'temp_wishlist'])->name('temp.wishlist');

Route::get('tai-khoan', [SiteAccountController::class, 'myaccount'])->middleware('sitelogin')->name('site.myaccount');
Route::prefix('tai-khoan')->middleware('sitelogin')->group(function () {
    Route::get('/don-hang', [SiteAccountController::class, 'order'])->name('account.order');
    Route::get('/xem-don-hang', [SiteAccountController::class, 'orderdetail'])->name('account.orderdetail');
    Route::get('/chi-tiet', [SiteAccountController::class, 'edit'])->name('account.edit');
    Route::post('/chi-tiet', [SiteAccountController::class, 'postedit']);
    Route::get('/yeu-thich', [SiteAccountController::class, 'wishlist'])->name('account.wishlist');
    Route::get('/dia-chi', [SiteAccountController::class, 'address'])->name('account.address');
    Route::post('/dia-chi', [SiteAccountController::class, 'postaddress']);
});
// Route::get('tai-khoan', [SiteAccountController::class, 'logout'])->name('site.logout');

Route::post('them-gio-hang', [SiteCartController::class, 'addcart'])->name('site.addcart');
Route::get('gio-hang', [SiteCartController::class, 'showcarts'])->middleware('sitelogin')->name('site.cart');
Route::post('cap-nhat-gio-hang', [SiteCartController::class, 'updatecart'])->name('site.updatecart');

Route::post('xoa-gio-hang', [SiteCartController::class, 'delcart'])->name('site.delcart');

Route::middleware('sitelogin')->group(function () {
    Route::get('thu-tuc-thanh-toan', [SiteCheckoutController::class, 'index'])->name('site.checkout');
    Route::post('dat-hang', [SiteCheckoutController::class, 'placeorder'])->name('site.placeorder');
    Route::get('thong-tin-thanh-toan/{code}', [SiteCheckoutController::class, 'ordercomplete'])->name('site.ordercomplete');
    Route::get('xac-nhan-don-hang/{id}/{accept_token}', [SiteCheckoutController::class, 'orderaccept'])->name('site.orderaccept');
    Route::post('thanh-toan-momo-atm', [SiteCheckoutController::class, 'momo_payment'])->name('site.momo_payment');
    Route::post('thanh-toan-vnpay', [SiteCheckoutController::class, 'vnpay_payment'])->name('site.vnpay_payment');
    Route::get('thanh-toan-thanh-cong/{code}', [SiteCheckoutController::class, 'success_payment'])->name('site.success_payment');
});

Route::get('admin/login', [LoginController::class, 'getlogin'])->name('admin.getlogin');
Route::post('admin/login', [LoginController::class, 'postlogin'])->name('admin.postlogin');
Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::prefix('admin')->middleware('adminlogin')->group(function () {
    //Trang Admin
    //BrandController================================================================================================
    Route::get('brand/trash', [BrandController::class, 'trash'])->name('brand.trash');
    Route::resource('brand', BrandController::class);
    Route::prefix('brand')->group(function () {
        Route::get('status/{brand}', [BrandController::class, 'status'])->name('brand.status');
        Route::get('delete/{brand}', [BrandController::class, 'delete'])->name('brand.delete');
        Route::get('restore/{brand}', [BrandController::class, 'restore'])->name('brand.restore');
        Route::get('destroy/{brand}', [BrandController::class, 'destroy'])->name('brand.destroy');
        Route::post('trash_multi', [BrandController::class, 'trash_multi'])->name('brand.trash_multi');
        Route::post('delete_multi', [BrandController::class, 'delete_multi'])->name('brand.delete_multi');
    });
    //CategoryController================================================================================================
    Route::get('category/trash', [CategoryController::class, 'trash'])->name('category.trash');
    Route::resource('category', CategoryController::class);
    Route::prefix('category')->group(function () {
        Route::get('status/{category}', [CategoryController::class, 'status'])->name('category.status');
        Route::get('delete/{category}', [CategoryController::class, 'delete'])->name('category.delete');
        Route::get('restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
        Route::get('destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::post('trash_multi', [CategoryController::class, 'trash_multi'])->name('category.trash_multi');
        Route::post('delete_multi', [CategoryController::class, 'delete_multi'])->name('category.delete_multi');
    });
    //ContactController================================================================================================
    Route::get('contact/trash', [ContactController::class, 'trash'])->name('contact.trash');
    Route::resource('contact', ContactController::class);

    Route::prefix('contact')->group(function () {
        Route::get('delete/{contact}', [ContactController::class, 'delete'])->name('contact.delete');
        Route::get('restore/{contact}', [ContactController::class, 'restore'])->name('contact.restore');
        Route::get('destroy/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');
        Route::post('trash_multi', [ContactController::class, 'trash_multi'])->name('contact.trash_multi');
        Route::post('delete_multi', [ContactController::class, 'delete_multi'])->name('contact.delete_multi');
    });
    //DashboardController================================================================================================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    //MenuController================================================================================================
    Route::get('menu/trash', [MenuController::class, 'trash'])->name('menu.trash');
    Route::resource('menu', MenuController::class);
    Route::prefix('menu')->group(function () {
        Route::get('status/{menu}', [MenuController::class, 'status'])->name('menu.status');
        Route::get('delete/{menu}', [MenuController::class, 'delete'])->name('menu.delete');
        Route::get('restore/{menu}', [MenuController::class, 'restore'])->name('menu.restore');
        Route::get('destroy/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::post('trash_multi', [MenuController::class, 'trash_multi'])->name('menu.trash_multi');
    });
    //OrderController================================================================================================
    Route::get('order/trash', [OrderController::class, 'trash'])->name('order.trash');
    Route::resource('order', OrderController::class);

    Route::prefix('order')->group(function () {
        Route::get('status/{order}', [OrderController::class, 'status'])->name('order.status');
        Route::get('destroy/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::post('trash_multi', [OrderController::class, 'trash_multi'])->name('order.trash_multi');
    });
    //
    //PostController================================================================================================
    Route::get('post/trash', [PostController::class, 'trash'])->name('post.trash');
    Route::resource('post', PostController::class);

    Route::prefix('post')->group(function () {
        Route::get('status/{post}', [PostController::class, 'status'])->name('post.status');
        Route::get('delete/{post}', [PostController::class, 'delete'])->name('post.delete');
        Route::get('restore/{post}', [PostController::class, 'restore'])->name('post.restore');
        Route::get('destroy/{post}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::post('trash_multi', [PostController::class, 'trash_multi'])->name('post.trash_multi');
        Route::post('delete_multi', [PostController::class, 'delete_multi'])->name('post.delete_multi');
    });
    //PageController================================================================================================
    Route::get('page/trash', [PageController::class, 'trash'])->name('page.trash');
    Route::resource('page', PageController::class);

    Route::prefix('page')->group(function () {
        Route::get('status/{page}', [PageController::class, 'status'])->name('page.status');
        Route::get('delete/{page}', [PageController::class, 'delete'])->name('page.delete');
        Route::get('restore/{page}', [PageController::class, 'restore'])->name('page.restore');
        Route::get('destroy/{page}', [PageController::class, 'destroy'])->name('page.destroy');
        Route::post('trash_multi', [PageController::class, 'trash_multi'])->name('page.trash_multi');
        Route::post('delete_multi', [PageController::class, 'delete_multi'])->name('page.delete_multi');
    });
    //SliderController================================================================================================
    Route::get('slider/trash', [SliderController::class, 'trash'])->name('slider.trash');
    Route::resource('slider', SliderController::class);
    Route::prefix('slider')->group(function () {
        Route::get('status/{slider}', [SliderController::class, 'status'])->name('slider.status');
        Route::get('delete/{slider}', [SliderController::class, 'delete'])->name('slider.delete');
        Route::get('restore/{slider}', [SliderController::class, 'restore'])->name('slider.restore');
        Route::get('destroy/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
        Route::post('trash_multi', [SliderController::class, 'trash_multi'])->name('slider.trash_multi');
        Route::post('delete_multi', [SliderController::class, 'delete_multi'])->name('slider.delete_multi');
    });
    //TopicController================================================================================================
    Route::get('topic/trash', [TopicController::class, 'trash'])->name('topic.trash');
    Route::resource('topic', TopicController::class);

    Route::prefix('topic')->group(function () {
        Route::get('status/{topic}', [TopicController::class, 'status'])->name('topic.status');
        Route::get('delete/{topic}', [TopicController::class, 'delete'])->name('topic.delete');
        Route::get('restore/{topic}', [TopicController::class, 'restore'])->name('topic.restore');
        Route::get('destroy/{topic}', [TopicController::class, 'destroy'])->name('topic.destroy');
        Route::post('trash_multi', [TopicController::class, 'trash_multi'])->name('topic.trash_multi');
        Route::post('delete_multi', [TopicController::class, 'delete_multi'])->name('topic.delete_multi');
    });
    //LoginController================================================================================================

    //UserController================================================================================================
    Route::get('user/trash', [UserController::class, 'trash'])->name('user.trash');
    Route::resource('user', UserController::class);

    Route::prefix('user')->group(function () {
        Route::get('status/{user}', [UserController::class, 'status'])->name('user.status');
        Route::get('delete/{user}', [UserController::class, 'delete'])->name('user.delete');
        Route::get('restore/{user}', [UserController::class, 'restore'])->name('user.restore');
        Route::get('destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::post('trash_multi', [UserController::class, 'trash_multi'])->name('user.trash_multi');
        Route::post('delete_multi', [UserController::class, 'delete_multi'])->name('user.delete_multi');
    });
    //CustomerController================================================================================================
    Route::get('customer/trash', [CustomerController::class, 'trash'])->name('customer.trash');
    Route::resource('customer', CustomerController::class);

    Route::prefix('customer')->group(function () {
        Route::get('status/{customer}', [CustomerController::class, 'status'])->name('customer.status');
        Route::get('delete/{customer}', [CustomerController::class, 'delete'])->name('customer.delete');
        Route::get('restore/{customer}', [CustomerController::class, 'restore'])->name('customer.restore');
        Route::get('destroy/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::post('trash_multi', [CustomerController::class, 'trash_multi'])->name('customer.trash_multi');
        Route::post('delete_multi', [CustomerController::class, 'delete_multi'])->name('customer.delete_multi');
    });
    //ProductController================================================================================================
    Route::get('product/trash', [ProductController::class, 'trash'])->name('product.trash');
    Route::resource('product', ProductController::class);

    Route::prefix('product')->group(function () {
        Route::get('status/{product}', [ProductController::class, 'status'])->name('product.status');
        Route::get('delete/{product}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('restore/{product}', [ProductController::class, 'restore'])->name('product.restore');
        Route::get('destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('trash_multi', [ProductController::class, 'trash_multi'])->name('product.trash_multi');
        Route::post('delete_multi', [ProductController::class, 'delete_multi'])->name('product.delete_multi');
    });
});





Route::get('{slug}', [SiteController::class, 'index'])->name('slug.index');
