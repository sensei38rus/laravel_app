@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1>Статьи</h1>

    <form method="GET" action="{{ route('posts.index') }}" style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:16px">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Поиск..." style="flex:1; min-width:160px">
        <select name="category">
            <option value="">Все категории</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="status">
            <option value="">Любой статус</option>
            <option value="published" @selected(request('status') === 'published')>Опубликованные</option>
            <option value="draft" @selected(request('status') === 'draft')>Черновики</option>
        </select>
        <button type="submit" style="margin:0">Найти</button>
    </form>

    <p><a href="{{ route('posts.create') }}">+ Новая статья</a></p>

    @forelse ($posts as $post)
        <div class="card">
            <h3 style="margin:0 0 6px"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
            <small>
                {{-- BelongsTo --}}
                @if ($post->category)
                    <a href="{{ route('categories.show', $post->category) }}">{{ $post->category->name }}</a> ·
                @endif
                {{ $post->is_published ? 'Опубликована' : 'Черновик' }} ·
                комментариев: {{ $post->comments_count }} · просмотров: {{ $post->views }}
            </small>
            <p>{{ $post->excerpt }}</p>
            {{-- BelongsToMany --}}
            @foreach ($post->tags as $tag)
                <a class="badge" href="{{ route('posts.index', ['tag' => $tag->slug]) }}">#{{ $tag->name }}</a>
            @endforeach
        </div>
    @empty
        <p>Статей не найдено.</p>
    @endforelse

    {{ $posts->links('pagination::default') }}
@endsection