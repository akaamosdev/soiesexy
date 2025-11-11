<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'taille_id' => 'required|exists:tailles,id',
            'color_id' => 'required|exists:colors,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $product->variants()->create([
            'taille_id' => $request->taille_id,
            'color_id' => $request->color_id,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Variant added successfully.');
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $variant->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Variant quantity updated successfully.');
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();

        return back()->with('success', 'Variant deleted successfully.');
    }
}