@extends('layouts.app')

@section('title', 'Категории')

@section('content')
    <h1>Категории</h1>
    <ul>
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                ({{ $category->posts_count }})
            </li>
        @endforeach
    </ul>
@endsection