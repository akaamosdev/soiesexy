<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ColorController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Colors/Index', [
            'colors' => Color::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Colors/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'code' => 'required|string|max:255|unique:colors,code',
        ]);

        Color::create($request->only('name', 'code'));

        return redirect()->route('colors.index')->with('success', 'Color created successfully.');
    }

    public function edit(Color $color)
    {
        return Inertia::render('Admin/Colors/Edit', [
            'color' => $color,
        ]);
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'code' => 'required|string|max:255|unique:colors,code,' . $color->id,
        ]);

        $color->update($request->only('name', 'code'));

        return redirect()->route('colors.index')->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect()->route('colors.index')->with('success', 'Color deleted successfully.');
    }
}