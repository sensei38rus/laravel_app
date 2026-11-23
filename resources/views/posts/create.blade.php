<form action="{{ $action }}" method="POST" novalidate>
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <label for="title">Заголовок</label>
    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}">
    @error('title') <p class="error">{{ $message }}</p> @enderror

    <label for="category_id">Категория</label>
    <select id="category_id" name="category_id">
        <option value="">— без категории —</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <p class="error">{{ $message }}</p> @enderror

    <label for="body">Текст</label>
    <textarea id="body" name="body" rows="8">{{ old('body', $post->body) }}</textarea>
    @error('body') <p class="error">{{ $message }}</p> @enderror

    <label>Теги</label>
    @php($selected = old('tags', $post->tags->pluck('id')->all()))
    @foreach ($tags as $tag)
        <label style="display:inline-block; font-weight:normal; margin-right:12px">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" style="width:auto"
                   @checked(in_array($tag->id, $selected))> {{ $tag->name }}
        </label>
    @endforeach
    @error('tags.*') <p class="error">{{ $message }}</p> @enderror

    <label style="font-weight:normal">
        <input type="checkbox" name="is_published" value="1" style="width:auto"
               @checked(old('is_published', $post->is_published))> Опубликовать
    </label>

    <label for="published_at">Дата публикации (необязательно)</label>
    <input type="datetime-local" id="published_at" name="published_at"
           value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
    @error('published_at') <p class="error">{{ $message }}</p> @enderror

    <button type="submit">Сохранить</button>
</form>