<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('/dotest',[\App\Http\Controllers\TestController::class,'index']);


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

////////
Route::get('/',[\App\Http\Controllers\HomeController::class,'home'])->name('home');
Route::get('/wishlist',[\App\Http\Controllers\HomeController::class,'wishlist'])->name('wishlist');
Route::get('/cart',[\App\Http\Controllers\HomeController::class,'card'])->name('card');
Route::get('/produit/{product:slug}',[\App\Http\Controllers\HomeController::class,'show'])->name('show');
Route::get('/trouver-votre-lingerie',[\App\Http\Controllers\HomeController::class,'shop'])->name('shop');
Route::get('/mon-adresse-de-livraison',[\App\Http\Controllers\HomeController::class,'adresse'])
    ->name('adresse.create');
Route::get('/checkout',[\App\Http\Controllers\HomeController::class,'checkout'])->name('checkout');
Route::get('/espace-client',[\App\Http\Controllers\HomeController::class,'dashboard'])->name('dashboard');
Route::get('/a-propos-nous',[\App\Http\Controllers\HomeController::class,'about'])->name('about');
//route orders
Route::prefix("orders")->group(function () {
    Route::get('/',[\App\Http\Controllers\OrderController::class,'index'])->name('orders');
    Route::post('/store',[\App\Http\Controllers\OrderController::class,'store'])->name('orders.store');
    Route::get('/success',function (){
        return Inertia::render('SuccessCommande');
    })->name('orders.success');
});

Route::middleware('auth')->prefix('admin')->group(function (){
   Route::get('/dashboard',[\App\Http\Controllers\AdminController::class,'dashboard'])->name('admin.dashboard');
   Route::get('/article',[\App\Http\Controllers\ArticleController::class,'index'])->name('art.index');
   Route::get('/article/create',[\App\Http\Controllers\ArticleController::class,'create'])->name('art.create');
   Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
   Route::resource('products.variants', \App\Http\Controllers\Admin\ProductVariantController::class)->shallow();
   Route::resource('categories', \App\Http\Controllers\Admin\CategorieController::class);
   Route::resource('tailles', \App\Http\Controllers\Admin\TailleController::class);
   Route::resource('colors', \App\Http\Controllers\Admin\ColorController::class);
   Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
   Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
   Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
});

require __DIR__.'/auth.php';
