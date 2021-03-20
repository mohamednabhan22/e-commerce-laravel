<?php

use App\Category;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('conversation/{userId}', 'MessageController@index')
    ->name('message.conversation');
Route::post('send-message', 'MessageController@sendMessage')
    ->name('message.send-message');


   
   
    Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {
        Route::match(['get', 'post'], '/', 'AdminController@login');
        Route::match(['get', 'post'], '/update-admin-details', 'AdminController@updateAdminDetails');

        Route::group(['middleware' => 'admin'], function () {
            Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
            Route::get('/setting', 'AdminController@setting')->name('admin.setting');
            Route::get('/logout', 'AdminController@logout')->name('admin.logout');
            Route::post('/check-current-pwd', 'AdminController@checkCurrentPassword');
            Route::post('/update-current-pwd', 'AdminController@updateCurrentPassword')->name('admin.updatePwd');

            //sections

            Route::get('/sections', 'SectionController@sections')->name('admin.sections');
            Route::post('/update-section-status', 'SectionController@updateSectionStatus');

                //brands

                Route::get('/brands', 'BrandController@brands');       
                Route::post('/update-brand-status', 'BrandController@updateBrandStatus');
                Route::match(['get', 'post'], '/add-edit-brand/{id?}', 'BrandController@addEditBrand');
                Route::get('/delete-brand/{id}', 'BrandController@deleteBrand');

     


              //categories
              Route::get('/categories', 'CategoryController@categories')->name('admin.categories');
              Route::post('/update-category-status', 'CategoryController@updateCategoryStatus');
              Route::match(['get', 'post'], '/add-edit-category/{id?}', 'CategoryController@addEditCategory');
              Route::post('/append-categories-level', 'CategoryController@appendCategoryLevel');
              Route::get('/delete-category-image/{id}', 'CategoryController@deleteCategoryImage');
              Route::get('/delete-category/{id}', 'CategoryController@deleteCategory');

              //products
              Route::get('/products', 'ProductsController@products');
              Route::post('/update-product-status','ProductsController@updateProductStatus');
              Route::get('/delete-product/{id}', 'ProductsController@deleteProduct');
              Route::match(['get', 'post'], '/add-edit-product/{id?}', 'ProductsController@addEditProduct');
              Route::get('/delete-product-image/{id}', 'ProductsController@deleteProductImage');
              Route::get('/delete-product-video/{id}', 'ProductsController@deleteProductVideo');


            // Attributes
              Route::match(['get', 'post'], '/add-attributes/{id}', 'ProductsController@addAttributes');
              Route::post('/edit-attributes/{id}', 'ProductsController@editAttributes');
              Route::post('/update-attribute-status','ProductsController@updateAttributeStatus');
              Route::get('/delete-attribute/{id}', 'ProductsController@deleteAttribute');


             // images
             Route::match(['get', 'post'], '/add-images/{id}', 'ProductsController@addImages');
             Route::post('/update-image-status','ProductsController@updateImageStatus');
             Route::get('/delete-image/{id}', 'ProductsController@deleteImage');

          //banners
          Route::get('/banners', 'BannersController@banners');
          Route::match(['get', 'post'], '/add-edit-banner/{id?}', 'BannersController@addEditBanner');

          Route::post('/update-banner-status','BannersController@updateBannerStatus');
          Route::get('/delete-banner/{id}', 'BannersController@deleteBanner');

            //coupons
            Route::get('/coupons','CouponController@coupons');

            Route::post('/update-coupon-status','CouponController@updateCouponStatus');
            Route::match(['get', 'post'], '/add-edit-coupons/{id?}', 'CouponController@addEditCoupon');
            Route::get('/delete-coupons/{id}','CouponController@deleteCoupon');



        });
    });

    Route::group(['namespace'=>'Front'], function () {

      Route::get('/', 'IndexController@index');

      $catUrls=Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
      foreach($catUrls as $url){
//listing /categories Route
Route::get('/'.$url, 'ProductsController@listing');
      }

      //product detail route

Route::get('/product/{id}', 'ProductsController@detail');


// get product attribute price route

Route::post('/get-product-price', 'ProductsController@getProductPrice');

// add to cart route

Route::post('/add-to-cart', 'ProductsController@addtocart');

//shoping cart route
Route::get('cart', 'ProductsController@cart');

//update cart item quantity

Route::post('/update-cart-item-qty', 'ProductsController@updateCartItemQty');



//delete cart item 

Route::post('/delete-cart-item', 'ProductsController@deleteCartItem');

//login /register page 

Route::get('/login-register',['as'=>'login','uses'=>'UsersController@loginRegister'] );

//login user

Route::post('/login', 'UsersController@loginUser');

//register user

Route::post('/register', 'UsersController@registerUser');

//logout user
Route::get('/logout', 'UsersController@logout');


Route::middleware(['auth'])->group(function () {

          //users account
      Route::match(['get', 'post'], '/account', 'UsersController@account');
      Route::post('/update-password', 'UsersController@updateCurrentPassword');

      Route::get('/orders', 'OrdersController@orders');
      Route::get('/orders/{id}', 'OrdersController@orderDetails');


      //apply coupon 
      Route::post('/apply-coupon', 'ProductsController@applyCoupon');

      //checkout
      Route::match(['get', 'post'], '/checkout', 'ProductsController@checkout');


           //add/edit delivery address
      Route::match(['get', 'post'],'/add-edit-delivery-address/{id?}', 'ProductsController@addEditDeliveryAddress');

      //delete  delivery address
      Route::get('/delete-delivery-address/{id}', 'ProductsController@deleteDeliveryAddress');

   //thanks page
   Route::get('/thanks', 'ProductsController@thanks');
      });



    });
