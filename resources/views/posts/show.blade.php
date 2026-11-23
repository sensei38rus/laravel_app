@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>

    <p>
        <small>
            Категория:
            @if ($post->category)
                <a href="{{ route('categories.show', $post->category) }}">{{ $post->category->name }}</a>
            @else
                —
            @endif
            · {{ $post->published_at?->format('d.m.Y H:i') ?? 'не опубликована' }}
            · просмотров: {{ $post->views }}
        </small>
    </p>

    <div>{!! nl2br(e($post->body)) !!}</div>

    <p>
        @foreach ($post->tags as $tag)
            <a class="badge" href="{{ route('posts.index', ['tag' => $tag->slug]) }}">#{{ $tag->name }}</a>
        @endforeach
    </p>

    <p style="display:flex; gap:12px; align-items:center">
        <a href="{{ route('posts.edit', $post) }}">Редактировать</a>
        <form action="{{ route('posts.destroy', $post) }}" method="POST"
              onsubmit="return confirm('Переместить статью в корзину?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger" style="margin:0">Удалить</button>
        </form>
    </p>

    <hr>
    @include('partials.comments', ['model' => $post, 'action' => route('posts.comments.store', $post)])
@endsection