@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>

    <h2>Опубликованные статьи</h2>
    @forelse ($posts as $post)
        <div class="card">
            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            <small>· {{ $post->published_at->format('d.m.Y') }}</small>
        </div>
    @empty
        <p>В этой категории пока нет статей.</p>
    @endforelse

    <hr>
    @include('partials.comments', ['model' => $category, 'action' => route('categories.comments.store', $category)])
@endsection