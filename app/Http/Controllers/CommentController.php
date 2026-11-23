<?php

namespace App\Http\Controllers;

use App\Models\{Category, Post};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function storeForPost(Request $request, Post $post)
    {
        return $this->store($request, $post);
    }

    public function storeForCategory(Request $request, Category $category)
    {
        return $this->store($request, $category);
    }

    private function store(Request $request, Model $commentable)
    {
        $data = $request->validate([
            'author' => ['required', 'string', 'max:100'],
            'body'   => ['required', 'string', 'min:3', 'max:1000'],
        ], [
            'required' => 'Поле «:attribute» обязательно.',
            'min'      => 'Поле «:attribute» слишком короткое.',
            'max'      => 'Поле «:attribute» слишком длинное.',
        ], ['author' => 'Имя', 'body' => 'Комментарий']);

        $commentable->comments()->create($data);

        return back()->with('success', 'Комментарий добавлен.');
    }
}