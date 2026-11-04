@extends('layouts.app')

@section('title', 'Полученные данные')

@section('content')
    <h1>Полученные данные</h1>

    @if ($items->isEmpty())
        <p>Пока нет ни одной записи.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Дата</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Сообщение</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['created_at'] ?? '—' }}</td>
                        <td>{{ $item['name'] ?? '' }}</td>
                        <td>{{ $item['email'] ?? '' }}</td>
                        <td>{{ $item['message'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection