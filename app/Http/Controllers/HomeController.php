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
       $products = Product::with(['images', 'tailles', 'colors'])->inRandomOrder()
           ->simplePaginate(50);
       $categories = Categorie::query()->has('products')
           ->withCount('products')
           ->orderBy('products_count', 'DESC')
           ->get();
       return Inertia::render('Home', [
           'products' => $products,
           'categories' => $categories
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
    public function shop(Request $request){
//       dd($request->all());
        $data['products'] = Product::query()
            ->with(['tailles', 'colors', 'images'])
            ->when($request->params, function($query, $datas){
                $query->when($datas['search'], function($query, $search){
                    $query->where('name', 'like', '%'.$search.'%');
                })->when($datas['category_id'], function($query, $category){
                    $query->where('category_id', $category);
                })->when($datas['min_price'], function($query, $price_min){
                    $query->where('price','>=', $price_min);
                })->when($datas['max_price'], function($query, $price_max){
                    $query->where('price','<=', $price_max);
                })->when($datas['taille_id'], function($query, $taille){
                    $query->whereHas('tailles', function($query) use ($taille){
                        $query->where('taille_id', $taille);
                    });
                })->when($datas['orderBy'], function($query, $orderBy){
                    //dd($orderBy);
                    $query->orderBy('price', $orderBy);
                });

            })->when($request->category, function($query, $category){
                $query->where('category_id', $category);
            })
            ->limit(50)->get();
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
   public function about()
   {
       return Inertia::render('About');
   }

}
