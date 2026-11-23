@extends('layouts.app')

@section('title', 'Форма обратной связи')

@section('content')
    <h1>Форма обратной связи</h1>

    @if ($errors->any())
        <div class="alert-danger">Форма содержит ошибки. Проверьте введённые данные.</div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" novalidate>
        @csrf

        <label for="name">Имя</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}">
        @error('name') <p class="error">{{ $message }}</p> @enderror

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        @error('email') <p class="error">{{ $message }}</p> @enderror

        <label for="message">Сообщение</label>
        <textarea id="message" name="message" rows="5">{{ old('message') }}</textarea>
        @error('message') <p class="error">{{ $message }}</p> @enderror

        <button type="submit">Отправить</button>
    </form>
@endsection