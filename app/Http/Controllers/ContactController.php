<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    // Форма
    public function create()
    {
        return view('pages.contact');
    }

    // Валидация + сохранение в JSON-файл
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'min:2', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'required' => 'Поле «:attribute» обязательно для заполнения.',
            'email'    => 'Введите корректный email.',
            'min'      => 'Поле «:attribute» слишком короткое (минимум :min символов).',
            'max'      => 'Поле «:attribute» слишком длинное (максимум :max символов).',
        ], [
            'name'    => 'Имя',
            'email'   => 'Email',
            'message' => 'Сообщение',
        ]);

        $data['created_at'] = now()->toDateTimeString();

        // Уникальное имя файла
        $filename = 'submissions/' . now()->format('Ymd_His') . '_' . Str::uuid() . '.json';

        Storage::put($filename, json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        ));

        return redirect()
            ->route('contact.create')
            ->with('success', 'Спасибо! Ваше сообщение успешно сохранено.');
    }

    // Таблица всех сохранённых данных
    public function index()
    {
        $items = collect(Storage::files('submissions'))
            ->filter(fn ($path) => str_ends_with($path, '.json'))
            ->map(fn ($path) => json_decode(Storage::get($path), true))
            ->filter()
            ->sortByDesc('created_at')
            ->values();

        return view('pages.submissions', compact('items'));
    }
}