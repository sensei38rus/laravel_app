<header>
    <a href="{{ route('home') }}" class="logo">
        <span style="font-size:1.5rem">🅻</span> {{ config('app.name') }}
    </a>
    <nav>
        <a href="{{ route('home') }}">Главная</a>
        <a href="{{ route('about') }}">О нас</a>
        <a href="{{ route('contact.create') }}">Форма</a>
        <a href="{{ route('submissions.index') }}">Данные</a>
        <a href="{{ route('posts.index') }}">Статьи</a>
        <a href="{{ route('categories.index') }}">Категории</a>
        <a href="{{ route('posts.trash') }}">Корзина</a>
    </nav>
</header>