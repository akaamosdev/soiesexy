<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Color;
use App\Models\Product;
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
            'products' => Product::withSum('variants', 'quantity')->with('images')->latest()->paginate(10), // Eager load images
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
            'variants' => 'array',
            'variants.*.taille_id' => 'required|exists:tailles,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.quantity' => 'required|integer|min:0',
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

        // Create variants
        foreach ($request->variants as $variantData) {
            $product->variants()->create([
                'taille_id' => $variantData['taille_id'],
                'color_id' => $variantData['color_id'],
                'quantity' => $variantData['quantity'],
            ]);
        }

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
        $product->load('variants.taille', 'variants.color', 'images'); // Eager load images
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
            'images' => 'array', // Expect an array of files for new uploads
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'existing_image_ids' => 'array', // Array of IDs of images to keep
            'existing_image_ids.*' => 'exists:product_images,id',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);
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
        foreach ($product->images as $image) {
            if (!in_array($image->id, $imagesToKeep)) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
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
