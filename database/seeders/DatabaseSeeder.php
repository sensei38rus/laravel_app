<?php

namespace Database\Seeders;
use App\Models\{Category, Post, Tag};
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $categories = collect(['Новости', 'Технологии', 'Обучение'])
    ->map(fn ($name) => Category::create([
        'name' => $name,
        'slug' => Str::slug($name),
    ]));

$tags = collect(['laravel', 'php', 'sql', 'eloquent'])
    ->map(fn ($name) => Tag::create([
        'name' => $name,
        'slug' => Str::slug($name),
    ]));

        foreach (range(1, 12) as $i) {
            $post = Post::create([
                'slug' => Post::makeSlug("Тестовая статья {$i}"),
                'category_id'  => $categories->random()->id,
                'title'        => "Тестовая статья №{$i}",
                'body'         => str_repeat("Текст статьи {$i}. Lorem ipsum dolor sit amet. ", 8),
                'is_published' => $i % 3 !== 0,
                'published_at' => $i % 3 !== 0 ? now()->subDays($i) : null,
            ]);
            $post->tags()->attach($tags->random(2)->pluck('id'));
            $post->comments()->create(['author' => 'Гость', 'body' => "Комментарий к статье {$i}"]);
        }

        $categories->first()->comments()->create(['author' => 'Админ', 'body' => 'Комментарий к категории']);
    }
}
