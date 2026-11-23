<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\{Category, Post, Tag};
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'tags'])
            ->withCount('comments')
            ->search($request->query('q'))                                              // scope
            ->when($request->filled('category'), fn ($q) => $q->inCategory($request->category))
            ->when($request->filled('tag'), fn ($q) => $q->withTag($request->tag))
            ->when($request->status === 'published', fn ($q) => $q->published())        // scope
            ->when($request->status === 'draft', fn ($q) => $q->draft())                // scope
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', [
            'posts'      => $posts,
            'categories' => Category::ordered()->get(),                                 // scope
        ]);
    }

    public function show(Post $post)
    {
        $post->increment('views');
        $post->load(['category', 'tags', 'comments']);

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', [
            'post'       => new Post(),
            'categories' => Category::ordered()->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(PostRequest $request)
    {
       $post = Post::create($this->data($request) + [
    'slug' => Post::makeSlug($request->input('title')),
]);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('posts.show', $post)->with('success', 'Статья создана.');
    }

    public function edit(Post $post)
    {
        $post->load('tags');

        return view('posts.edit', [
            'post'       => $post,
            'categories' => Category::ordered()->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($this->data($request));
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('posts.show', $post)->with('success', 'Статья обновлена.');
    }

    // мягкое удаление
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Статья перемещена в корзину.');
    }

    public function trash()
    {
        $posts = Post::onlyTrashed()->with('category')->latest('deleted_at')->get();

        return view('posts.trash', compact('posts'));
    }

    public function restore(Post $post)
    {
        $post->restore();

        return redirect()->route('posts.trash')->with('success', 'Статья восстановлена.');
    }

    public function forceDelete(Post $post)
    {
        $post->forceDelete();

        return redirect()->route('posts.trash')->with('success', 'Статья удалена окончательно.');
    }

    private function data(PostRequest $request): array
    {
        $data = $request->safe()->except('tags');

        if ($data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}