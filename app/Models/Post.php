<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'slug', 'body', 'is_published', 'published_at',
    ];

    // значения по умолчанию для новых моделей
    protected $attributes = [
        'is_published' => false,
        'views' => 0,
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'views'        => 'integer',
        ];
    }

    protected static function booted(): void
    {
       static::creating(function (Post $post) {
        if (blank($post->slug)) {
            $post->slug = Str::slug($post->title) . '-' . Str::lower(Str::random(5));
        }
    });

    static::forceDeleting(function (Post $post) {
        $post->comments()->withTrashed()->forceDelete();
    });
    }
    public static function makeSlug(string $title): string
{
    return (Str::slug($title) ?: 'post') . '-' . Str::lower(Str::random(5));
}

    // ---- Связи ----

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // ---- Accessor ----

    protected function excerpt(): Attribute
    {
        return Attribute::get(fn () => Str::limit(strip_tags($this->body), 120));
    }

    // ---- Query Scopes ----

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('is_published', false);
    }

    public function scopeInCategory(Builder $query, int|string $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeWithTag(Builder $query, string $slug): Builder
    {
        return $query->whereHas('tags', fn ($q) => $q->where('slug', $slug));
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $term
            ? $query->where(fn ($q) => $q->where('title', 'like', "%{$term}%")
                                         ->orWhere('body', 'like', "%{$term}%"))
            : $query;
    }

    public function scopePopular(Builder $query, int $minViews = 100): Builder
    {
        return $query->where('views', '>=', $minViews)->orderByDesc('views');
    }
}