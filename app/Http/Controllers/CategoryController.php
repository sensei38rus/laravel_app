<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::ordered()->withCount('posts')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $posts = $category->posts()->published()->latest('published_at')->get();   // HasMany + scope
        $category->load('comments');                                                // morphMany

        return view('categories.show', compact('category', 'posts'));
    }
}