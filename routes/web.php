<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GuestController;

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


Route::get("/about_us", [\App\Http\Controllers\WebController::class,"aboutUs"]);



Route::middleware(["auth", "admin"])->prefix(env("ADMIN_PATH"))->group(function (){
    Route::get('/dashboard', [\App\Http\Controllers\WebController::class, "home"]);

    //   --------PRODUCT--------
    Route::prefix("product")->group(function (){
        // link page "list_product"
        Route::get("/list_product", [ProductController::class, "list"]);

//link page "add_product"
        Route::get("/add_product", [ProductController::class, "create"]);

// "add_product" --- method "store"
        Route::post("/add_product" , [ProductController::class, "store"]);

// link page "edit_product"
        Route::get("/edit_product/{product}" , [ProductController::class, "edit"])->name("product_edit");

// "edit_product" --- method "update"
        Route::put("/edit_product/{product}" , [ProductController::class, "update"]);

// delete một product
        Route::delete("/delete/{product}" , [ProductController::class, "delete"])->name("product_delete");

    });


// --------CATEGORY---------
    Route::get("/category/list_category", [CategoryController::class, "list"]);
    Route::get("/category/add_category", [CategoryController::class, "create"]);
    Route::post("/category/add_category", [CategoryController::class, "store"]);
    Route::get("/category/edit_category/{category}", [CategoryController::class, "edit"])->name("category_edit");
    Route::put("/category/edit_category/{category}", [CategoryController::class, "update"]);
    Route::delete("/category/delete/{category}", [CategoryController::class, "delete"])->name("category_delete");

//--ORDER--
    Route::get('/order/list', [OrderController::class, "list"]);
    Route::get('/order/detail/{order}', [OrderController::class, "detail"])->name("detail");
    Route::put('/order/detail/{order}', [OrderController::class, "updateStatus"]);


});

Route::get("/guest", [GuestController::class, "index"]);
Route::get("/guest/detail/{product}", [GuestController::class, "detail"])->name("product_detail");
Route::get("/add_to_cart/{product}", [GuestController::class, "addToCart"])->name("add_to_cart");
Route::get("/cart", [GuestController::class, "cart"]);
Route::get("/remove_item/{product}", [GuestController::class, "removeItem"]);
Route::get("/checkout", [GuestController::class, "createCheckout"]);
Route::post("/checkout",[GuestController::class,"placeOrder"]);
Route::get("/thankyou_card",[GuestController::class,"thankyouCard"]);
Route::get("/order_detail",[GuestController::class,"orderDetail"]);

Route::get("/process_paypal/{order}", [GuestController::class,"processPaypal"])->name("process_paypal");
Route::get("/success_paypal/{order}", [GuestController::class,"successPaypal"])->name("success_paypal");
Route::get("/cancel_paypal/{order}", [GuestController::class,"cancelPaypal"])->name("cancel_paypal");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//
//Route::get("/admin/product/list_product", [\App\Http\Controllers\ProductController::class, "listProduct"]);
//Route::get("/admin/product/add_product", [\App\Http\Controllers\ProductController::class, "addProduct"]);
//Route::post("/admin/product/add_product" , [\App\Http\Controllers\ProductController::class, "store"]);
//Route::get("/admin/product/edit_product/{product}" , [\App\Http\Controllers\ProductController::class, "edit"])->name("product_edit");
//Route::put("/admin/product/edit_product/{product}" , [\App\Http\Controllers\ProductController::class, "update"]);
//Route::delete("/admin/product/edit_product/{product}" , [\App\Http\Controllers\ProductController::class, "delete"])->name("product_delete);



////   --------PRODUCT--------
//// link page "list_product"
//Route::get("/admin/product/list_product", [ProductController::class, "list"]);
//
////link page "add_product"
//Route::get("/admin/product/add_product", [ProductController::class, "create"]);
//
//// "add_product" --- method "store"
//Route::post("/admin/product/add_product" , [ProductController::class, "store"]);
//
//// link page "edit_product"
//Route::get("/admin/product/edit_product/{product}" , [ProductController::class, "edit"])->name("product_edit");
//
//// "edit_product" --- method "update"
//Route::put("/admin/product/edit_product/{product}" , [ProductController::class, "update"]);
//
//// delete một product
//Route::delete("/admin/product/delete/{product}" , [ProductController::class, "delete"])->name("product_delete");
//
//
//// --------CATEGORY---------
//Route::get("/admin/category/list_category", [CategoryController::class, "list"]);
//Route::get("/admin/category/add_category", [CategoryController::class, "create"]);
//Route::post("/admin/category/add_category", [CategoryController::class, "store"]);
//Route::get("/admin/category/edit_category/{category}", [CategoryController::class, "edit"])->name("category_edit");
//Route::put("/admin/category/edit_category/{category}", [CategoryController::class, "update"]);
//Route::delete("/admin/category/delete/{category}", [CategoryController::class, "delete"])->name("category_delete");
//
////--ORDER--
//Route::get('/admin/order/list', [OrderController::class, "list"]);
//Route::get('/admin/order/detail/{order}', [OrderController::class, "detail"])->name("detail");
//Route::put('/admin/order/detail/{order}', [OrderController::class, "updateStatus"]);
//

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
