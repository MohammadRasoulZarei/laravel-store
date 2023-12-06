<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Notifications\Test;
use Illuminate\Support\Str;
use App\Notifications\OtpSms;
use App\Models\ProductVariation;
use App\Notifications\PaymentSms;
use Ghasedak\Laravel\GhasedakFacade;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Home\CategoryController as HomeCategory;
use App\Http\Controllers\Home\CommentsController as homeCommentController;

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
//===========dashboard and admin panel + =================
Route::get('/admin-panel/dashboard', [AdminController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'verified']);
Route::get('/admin', function () {
    return redirect()->route('dashboard');
});
Route::prefix('admin-panel/management')->middleware(['auth', 'verified'])->name('admin.')->group(function () {


    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('comments', CommentsController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    // Route::resource('users', CouponController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/update/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('coupons/delete/{coupon}', [CouponController::class, 'delete'])->name('coupons.delete');

    Route::get('/comments/{comment}/{action}', [CommentsController::class, 'changeApprove'])->name('comment.changeApprove');

    Route::get('/orders', [AdminController::class, 'orderIndex'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'orderShow'])->name('orders.show');
    Route::get('/transactions', [AdminController::class, 'transactionIndex'])->name('transactions');
    // Get Category Attributes
    Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes']);

    // Edit Product Image
    Route::get('/products/{product}/images-edit', [ProductImageController::class, 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary', [ProductImageController::class, 'setPrimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add', [ProductImageController::class, 'add'])->name('products.images.add');

    // Edit Product Category
    Route::get('/products/{product}/category-edit', [ProductController::class, 'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-update', [ProductController::class, 'updateCategory'])->name('products.category.update');
});
//===========dashboard and admin panel - =================
//=========== + Home and store part ===========

Route::post('/comments/{product}', [homeCommentController::class, 'store'])->name('home.comment.store');
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/categories/{category:slug}', [HomeCategory::class, 'show'])->name('home.category.show');
Route::get('/categories/{category:slug}/parent', [HomeCategory::class, 'showParentCategory'])->name('home.category.showParent');
Route::get('/shop/', [HomeCategory::class, 'index'])->name('home.shop.index');
Route::get('/product/{product:slug}', [HomeController::class, 'showProduct'])->name('home.product.show');
Route::get('/compare/{product}', [CompareController::class, 'add'])->name('product.compare.add');
Route::get('/compare', [CompareController::class, 'index'])->name('product.compare.index');
Route::get('/compare/delete/{product}', [CompareController::class, 'delete'])->name('product.compare.delete');

//=========== - Home and store part ===========
//===========profile user panel + =================

Route::prefix('profile')->name('user.')->group(function () {

    Route::get('/', [UserProfileController::class, 'index'])->name('profile.index');
    Route::get('/comments', [UserProfileController::class, 'comments'])->name('comments');
    Route::get('/addTowish/{product}', [UserProfileController::class, 'addTowish'])->name('addTowish');
    Route::get('/wishList', [UserProfileController::class, 'wishList'])->name('wishList');
    Route::get('/deleteWish/{product}', [UserProfileController::class, 'deleteWish'])->name('dellete.wish');
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/get-cities/{province}', [AddressController::class, 'getCities'])->name('addresses.getCities');
    Route::put('/update-address/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::get('/orders', [UserProfileController::class, 'ordersIndex'])->name('orders');
});
//===========profile user panel - =================
//===========athentication part + ===========

Route::get('/login/{provider}', [AuthController::class, 'redirectToProvider'])->name('provider.login');
Route::get('/login/{provider}/callback', [AuthController::class, 'providerCallback']);


Route::get('/logout', function () {
    auth()->logout();
    return to_route('home.index');
});

Route::any('/phone-login', [AuthController::class, 'phoneLogin'])->name('phone.login');

Route::post('/check-otp', [AuthController::class, 'checkOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

//===========athentication part - ===========
//=========== + cart and coupon-user-side part===========

//Route::get('/add-to-cart' , [CartController::class , 'add'])->name('product.cart.getAdd');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('product.cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('home.cart.index');
Route::put('/cart', [CartController::class, 'update'])->name('home.cart.update');
Route::get('/cart/{delete}', [CartController::class, 'delete'])->name('home.cart.delete');
Route::get('/cart-clear', function () {

    \Cart::clear();
    return redirect()->route('home.index');
});
Route::post('/cart-check-coupon', [CartController::class, 'checkCoupon'])->name('home.cart.checkCoupon');
Route::get('/check-out', [CartController::class, 'checkout'])->name('home.order.checkout');

//=========== - cart and coupon-user-side part===========
//=========== + payment part===========

Route::post('/payment', [PaymentController::class, 'payment'])->middleware(['auth', 'verified'])->name('home.payment');
Route::get('/payment/verify/{gate}', [PaymentController::class, 'verify'])->middleware(['auth', 'verified'])->name('home.payment.verify');

//=========== - payment part===========
//=========== other + ===========

Route::get('/about-us', [HomeController::class, 'aboutUs']);
Route::get('/contact-us', [HomeController::class, 'contactUs']);
Route::post('/contact-us', [HomeController::class, 'contactUs']);
Route::get('/sitemap', [HomeController::class, 'sitemap']);

//=========== other - ===========
//================================================================
//================================================================
//================================================================

Route::any('/test', function () {
        dd(Brand::inRandomOrder()->first());
    //auth()->logout();
 //  $user = User::find(1);
   //auth()->login($user);
   // dd(auth()->user());
 //   $date=Carbon::now();
    //  $time=verta($date)->format('H:i');
    // $date=verta($date)->format('y-n-j');
  //auth()->user()->notify(new PaymentSms('700000','ijifj',$date));
  //  auth()->user()->notify(new OtpSms('50000'));
   // dd(Verta::parse(verta()->subMonth(12)->startMonth())->datetime());
    //dd($date,$date2);


});
