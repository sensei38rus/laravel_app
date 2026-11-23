<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'tags'])
            ->withCount('comments')
            ->published()
            ->search($request->query('q'))
            ->when($request->filled('category'), fn ($q) => $q->inCategory($request->category))
            ->when($request->filled('tag'), fn ($q) => $q->withTag($request->tag))
            ->latest('published_at')
            ->paginate(10);

        return PostResource::collection($posts);
    }

    public function show(Post $post)
    {
        return new PostResource($post->load(['category', 'tags', 'comments']));
    }

    public function store(PostRequest $request)
    {
       $post = Post::create($this->data($request) + [
    'slug' => Post::makeSlug($request->input('title')),
]);
        $post->tags()->sync($request->input('tags', []));

        return (new PostResource($post->load(['category', 'tags'])))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->update($this->data($request));
        $post->tags()->sync($request->input('tags', []));

        return new PostResource($post->load(['category', 'tags']));
    }

    public function destroy(Post $post)
    {
        $post->delete();   // soft delete

        return response()->noContent();
    }

    public function restore(Post $post)
    {
        $post->restore();

        return new PostResource($post);
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
