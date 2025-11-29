<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::forUser(auth()->user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();

        $expenseCategories = $categories->where('type', 'expense');
        $incomeCategories = $categories->where('type', 'income');

        return view('categories.index', compact('expenseCategories', 'incomeCategories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:7',
        ]);

        $validated['user_id'] = auth()->user()->id;
        $validated['is_default'] = false;

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        if ($category->is_default || $category->user_id !== auth()->user()->id) {
            abort(403, 'You cannot edit this category.');
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if ($category->is_default || $category->user_id !== auth()->user()->id) {
            abort(403, 'You cannot edit this category.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:7',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->is_default || $category->user_id !== auth()->user()->id) {
            abort(403, 'You cannot delete this category.');
        }

        if ($category->transactions()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category with existing transactions.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}