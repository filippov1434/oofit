<?php

use Illuminate\Support\Facades\Route;

//Admin Controllers CRM
use App\Http\Controllers\Admin\CMS\ApplicationController;
use App\Http\Controllers\Admin\CMS\CommentController;
use App\Http\Controllers\Admin\CMS\PaymentController;
use App\Http\Controllers\Admin\CMS\UserController;

//ADMIN Controllers LMS
use App\Http\Controllers\Admin\LMS\ProductController;
use App\Http\Controllers\Admin\LMS\ProductCategoryController;
use App\Http\Controllers\Admin\LanguageController;

//ADMIN Controllers
use App\Http\Controllers\Admin\AuthAdminController;

//User Controllers
use App\Http\Controllers\User\LMS\AuthUserController;
use App\Http\Controllers\User\LMS\AccessController;

//Common Controllers
use App\Http\Controllers\LogoutController;

// logIN
Route::post('/admin/login_admin_process', [AuthAdminController::class, 'login'])->name('login_admin_process');
Route::post('/user/login_user_process', [AuthUserController::class, 'login'])->name('login_user_process');


// logOUT
Route::middleware("auth:sanctum")->group(function() {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout_process');
});



// LMS

// ADMIN

// PRODUCTS manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/products/{id}', [ProductController::class, 'getProduct'])->name('products.showOne');
    Route::get('/products', [ProductController::class, 'getAllProduct'])->name('products.showAll');
    Route::post('/products', [ProductController::class, 'createProduct'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.destroy');
});


// ProductCategories manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/productCategories', [ProductCategoryController::class, 'getAllProductCategory'])->name('productCategories.showAll');
    Route::get('/productCategories/{id}', [ProductCategoryController::class, 'getProductCategory'])->name('productCategories.showOne');
    Route::post('/productCategories', [ProductCategoryController::class, 'createProductCategory'])->name('productCategories.store');
    Route::put('/productCategories/{id}', [ProductCategoryController::class, 'updateProductCategory'])->name('productCategories.update');
    Route::delete('/productCategories/{id}', [ProductCategoryController::class, 'deleteProductCategory'])->name('productCategories.destroy');
});

// USER 
Route::middleware(['auth:sanctum', 'abilities:user'])->prefix('user')->group(function() {
    Route::post('/products/{id}', [AccessController::class, 'getProducts'])->name('access.products');
});



// CRM 

// ADMIN

// USERS manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/users', [UserController::class, 'getAllUsers'])->name('users.showAll');
    Route::get('/users/{id}', [UserController::class, 'getUser'])->name('users.showOne');
    Route::post('/users', [UserController::class, 'createUser'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('users.destroy');
    Route::post('/users/test', [UserController::class, 'test'])->name('users.test');
});


// Application manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/applications', [ApplicationController::class, 'getAllApplication'])->name('applications.showAll');
    Route::get('/applications/{id}', [ApplicationController::class, 'getApplication'])->name('applications.showOne');
    Route::post('/applications', [ApplicationController::class, 'createApplication'])->name('applications.store');
    Route::put('/applications/{id}', [ApplicationController::class, 'updateApplication'])->name('applications.update');
    Route::delete('/applications/{id}', [ApplicationController::class, 'deleteApplication'])->name('applications.destroy');
});

// Comment manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/comments', [CommentController::class, 'getAllComment'])->name('comments.showAll');
    Route::get('/comments/{id}', [CommentController::class, 'getComment'])->name('comments.showOne');
    Route::post('/comments', [CommentController::class, 'createComment'])->name('comments.store');
    Route::put('/comments/{id}', [CommentController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentController::class, 'deleteComment'])->name('comments.destroy');
});

// Language manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/languages', [LanguageController::class, 'getAllLanguage'])->name('languages.showAll');
    Route::get('/languages/{id}', [LanguageController::class, 'getLanguage'])->name('languages.showOne');
    Route::post('/languages', [LanguageController::class, 'createLanguage'])->name('languages.store');
    Route::put('/languages/{id}', [LanguageController::class, 'updateLanguage'])->name('languages.update');
    Route::delete('/languages/{id}', [LanguageController::class, 'deleteLanguage'])->name('languages.destroy');
});

// Payment manipulation by ADMIN
Route::middleware(['auth:sanctum', 'abilities:admin'])->prefix('admin')->group(function() {
    Route::get('/payments', [PaymentController::class, 'getAllPayment'])->name('payments.showAll');
    Route::get('/payments/{id}', [PaymentController::class, 'getPayment'])->name('payments.showOne');
    Route::post('/payments', [PaymentController::class, 'createPayment'])->name('payments.store');
    Route::put('/payments/{id}', [PaymentController::class, 'updatePayment'])->name('payments.update');
    Route::delete('/payments/{id}', [PaymentController::class, 'deletePayment'])->name('payments.destroy');
});




