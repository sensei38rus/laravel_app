@extends('layouts.app')

@section('title', 'Редактирование')

@section('content')
    <h1>Редактирование: {{ $post->title }}</h1>
    @include('posts._form', ['action' => route('posts.update', $post), 'method' => 'PUT'])
@endsection