<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'page_name' => 'home',
                'title' => 'Home',
                'slug' => Str::slug('Home'),
                'content' => null,
                'meta_title' => 'Big Times News | Breaking News, Latest Headlines & Updates',
                'meta_description' => 'Stay updated with Big Times News – your source for breaking news, latest headlines, world news, politics, business, technology, health, and entertainment updates.',
                'meta_keywords' => 'breaking news, latest news, world news, Pakistan news, global news, politics news, business news, tech news, health news, entertainment news, Big Times News',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
