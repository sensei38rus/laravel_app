<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_published' => $this->boolean('is_published')]);
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'min:3', 'max:255'],
            'body'         => ['required', 'string', 'min:10'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['integer', 'exists:tags,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Поле «:attribute» обязательно.',
            'min'      => 'Поле «:attribute» слишком короткое (минимум :min).',
            'max'      => 'Поле «:attribute» слишком длинное (максимум :max).',
            'exists'   => 'Выбрано несуществующее значение в поле «:attribute».',
            'date'     => 'Поле «:attribute» должно быть датой.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Заголовок', 'body' => 'Текст',
            'category_id' => 'Категория', 'published_at' => 'Дата публикации',
            'tags' => 'Теги',
        ];
    }
}