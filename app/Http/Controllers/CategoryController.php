<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories()->withCount('tasks')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'required|string|size:7',
        ]);

        auth()->user()->categories()->create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created!');
    }

    public function edit(Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'required|string|size:7',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated!');
    }

    public function destroy(Category $category)
    {
        abort_if($category->user_id !== auth()->id(), 403);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
