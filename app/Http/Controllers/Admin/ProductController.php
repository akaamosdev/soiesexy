<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Taille;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage; // Added for file storage

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::query()->with(['tailles','colors'])->with('images')->latest()->simplePaginate(10), // Eager load images
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Categorie::all(),
            'tailles' => Taille::all(),
            'colors' => Color::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'taille_ids' => 'required|exists:tailles,id',
            'color_ids' => 'required|exists:colors,id',
            'images' => 'array', // Expect an array of files
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        $product->tailles()->attach($request->taille_ids);
        $product->colors()->attach($request->color_ids);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public'); // Store in 'storage/app/public/products'
                $product->images()->create([
                    'image_path' => $path,
                    'alt_text' => $request->name,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
        $product->load('tailles', 'colors', 'images'); // Eager load images
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => Categorie::all(),
            'tailles' => Taille::all(),
            'colors' => Color::all(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'images.*' => 'nullable',
            'taille_ids' => 'required|array',
            'color_ids' => 'required|array',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
        $product->tailles()->sync($request->taille_ids);
        $product->colors()->sync($request->color_ids);
        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'alt_text' => $request->name,
                ]);
            }
        }

        // Handle image deletions (if existing_image_ids is provided)
        $imagesToKeep = $request->input('existing_image_ids', []);
        if ($imagesToKeep){
            foreach ($imagesToKeep as $image){
                ProductImage::query()->where('image_path', $imagesToKeep)->delete();
                Storage::disk('public')->delete($image);
            }

        }
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
