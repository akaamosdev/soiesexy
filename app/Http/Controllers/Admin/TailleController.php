<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taille;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TailleController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Tailles/Index', [
            'tailles' => Taille::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Tailles/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tailles,name',
        ]);

        Taille::create($request->only('name'));

        return redirect()->route('tailles.index')->with('success', 'Taille created successfully.');
    }

    public function edit(Taille $taille)
    {
        return Inertia::render('Admin/Tailles/Edit', [
            'taille' => $taille,
        ]);
    }

    public function update(Request $request, Taille $taille)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tailles,name,' . $taille->id,
        ]);

        $taille->update($request->only('name'));

        return redirect()->route('tailles.index')->with('success', 'Taille updated successfully.');
    }

    public function destroy(Taille $taille)
    {
        $taille->delete();

        return redirect()->route('tailles.index')->with('success', 'Taille deleted successfully.');
    }
}