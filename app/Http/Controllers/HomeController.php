<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Color;
use App\Models\Product;
use App\Models\Taille;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

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
    public function filtrer(){
        $data['products'] = Product::query()
            ->with(['tailles', 'colors', 'images'])->limit(50)->get();
        $data['categories']=Categorie::all();
        $data['tailles']=Taille::all();
        $data['colors']=Color::all();
       return Inertia::render('Filter',$data);
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
