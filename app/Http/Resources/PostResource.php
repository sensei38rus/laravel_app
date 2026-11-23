<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
        'id'           => $this->id,
        'title'        => $this->title,
        'slug'         => $this->slug,
        'excerpt'      => $this->excerpt,
        'body'         => $this->when($request->routeIs('api.posts.show'), $this->body),
        'is_published' => $this->is_published,
        'published_at' => $this->published_at?->toIso8601String(),
        'views'        => $this->views,
        'category'     => new CategoryResource($this->whenLoaded('category')),
        'tags'         => TagResource::collection($this->whenLoaded('tags')),
        'comments'     => CommentResource::collection($this->whenLoaded('comments')),
        'comments_count' => $this->whenCounted('comments'),
        'created_at'   => $this->created_at->toIso8601String(),
        'deleted_at'   => $this->deleted_at?->toIso8601String(),
    ];
    }
}
