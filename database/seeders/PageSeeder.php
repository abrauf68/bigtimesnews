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

            [
                'page_name' => 'news',
                'title' => 'Latest News',
                'slug' => 'news',
                'content' => null,
                'meta_title' => 'Latest News & Breaking Headlines | Big Times News',
                'meta_description' => 'Read the latest breaking news and top headlines from around the world. Coverage includes politics, business, technology, sports, health, and entertainment on Big Times News.',
                'meta_keywords' => 'latest news, breaking news, headlines, world news, politics news, business news, sports news, tech news, health news, entertainment news',
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
