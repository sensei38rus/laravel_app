@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <h1>Корзина</h1>

    @if ($posts->isEmpty())
        <p>Корзина пуста.</p>
    @else
        <table>
            <thead>
                <tr><th>Заголовок</th><th>Категория</th><th>Удалена</th><th>Действия</th></tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category?->name ?? '—' }}</td>
                        <td>{{ $post->deleted_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('posts.restore', $post) }}" method="POST" style="display:inline">
                                @csrf @method('PATCH')
                                <button type="submit" style="margin:0">Восстановить</button>
                            </form>
                            <form action="{{ route('posts.force-delete', $post) }}" method="POST" style="display:inline"
                                  onsubmit="return confirm('Удалить навсегда?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger" style="margin:0">Удалить навсегда</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection