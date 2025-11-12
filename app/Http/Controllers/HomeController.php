<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
   public function home(){
       $products = Product::with(['images', 'tailles', 'colors'])->latest()->paginate(12);
       return Inertia::render('Home', [
           'products' => $products,
       ]);
   }
   public function wishlist(){

       return Inertia::render('Wishlist');
   }
   public function card(){

       return Inertia::render('Card');
   }
    public function show(Product $product){
        $product->load('tailles', 'colors', 'images');
       return Inertia::render('Show', [
           'product' => $product,
       ]);
   }
    public function filter(){

       return Inertia::render('Filter');
   }
    public function adresse(){

       return Inertia::render('Adresse');
   }
   public function checkout(){

       return Inertia::render('Checkout');
   }
   public function dashboard(){

       return Inertia::render('TableauBord');
   }

}
