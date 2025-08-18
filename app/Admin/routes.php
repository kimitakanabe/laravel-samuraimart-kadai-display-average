<?php

// AdminとRouteに "Undefined type" エラーが出たため教材にはないが、use宣言を追記
use Illuminate\Support\Facades\Route;
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Router;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\ProductController;
use App\Admin\Controllers\MajorCategoryController;
use App\Admin\Controllers\UserController;
use App\Admin\Controllers\ShoppingCartController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('categories', CategoryController::class);
    $router->resource('products', ProductController::class);
    $router->resource('major-categories', MajorCategoryController::class);
    $router->resource('users', UserController::class);
    $router->resource('shopping-carts', ShoppingCartController::class);
    $router->post('products/import', [ProductController::class, 'csvImport']);

});
