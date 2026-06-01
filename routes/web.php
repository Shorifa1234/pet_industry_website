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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin;

// Sitemap & SEO
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// News / Articles
Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/news/category/{category}', [ArticleController::class, 'byCategory'])->name('articles.category');
Route::get('/news/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Companies / Directory
Route::get('/directory', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/directory/{company}', [CompanyController::class, 'show'])->name('companies.show');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Auth Routes
Auth::routes();

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('articles', Admin\ArticleController::class);
    Route::resource('products', Admin\ProductController::class);
    Route::resource('companies', Admin\CompanyController::class);
    Route::resource('events', Admin\EventController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('users', Admin\UserController::class);
});
