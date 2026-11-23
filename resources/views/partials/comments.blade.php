<h3>Комментарии ({{ $model->comments->count() }})</h3>

@foreach ($model->comments as $comment)
    <div class="card">
        <strong>{{ $comment->author }}</strong>
        <small>{{ $comment->created_at->format('d.m.Y H:i') }}</small>
        <p>{{ $comment->body }}</p>
    </div>
@endforeach

<form action="{{ $action }}" method="POST" novalidate>
    @csrf
    <label for="author">Имя</label>
    <input type="text" id="author" name="author" value="{{ old('author') }}">
    @error('author') <p class="error">{{ $message }}</p> @enderror

    <label for="body">Комментарий</label>
    <textarea id="body" name="body" rows="3">{{ old('body') }}</textarea>
    @error('body') <p class="error">{{ $message }}</p> @enderror

    <button type="submit">Добавить</button>
</form>