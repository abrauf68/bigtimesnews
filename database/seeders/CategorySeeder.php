<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name' => 'US News',
                'title' => 'US News – Latest Breaking News from America',
                'meta_title' => 'US News Today | Breaking America News & Updates',
                'meta_description' => 'Get the latest US news, breaking stories, politics, economy, and live updates from across America. Stay informed with real-time coverage.',
                'meta_keywords' => 'US news, America news today, breaking US news, USA headlines, US updates',
            ],

            [
                'name' => 'World News',
                'title' => 'World News – Global Breaking News & Updates',
                'meta_title' => 'World News Today | International Headlines & Updates',
                'meta_description' => 'Explore global news, international headlines, and breaking stories from around the world. Stay updated with real-time world events.',
                'meta_keywords' => 'world news, international news, global news today, breaking world news, global headlines',
            ],

            [
                'name' => 'Politics',
                'title' => 'Politics News – Latest Political Updates & Analysis',
                'meta_title' => 'Politics News Today | Government, Policy & Updates',
                'meta_description' => 'Get latest political news, government policies, elections, and expert analysis. Stay updated with national and international politics.',
                'meta_keywords' => 'politics news, government news, election updates, political analysis, policy news',
            ],

            [
                'name' => 'Business & Economy',
                'title' => 'Business & Economy – Market Trends & Financial News',
                'meta_title' => 'Business News Today | Economy, Markets & Finance',
                'meta_description' => 'Stay ahead with business news, economic updates, market trends, and financial insights. Get expert analysis on global economy.',
                'meta_keywords' => 'business news, economy news, market trends, financial news, global economy',
            ],

            [
                'name' => 'Entertainment',
                'title' => 'Entertainment News – Celebrities, Movies & Shows',
                'meta_title' => 'Entertainment News Today | Celebs, Movies & TV Updates',
                'meta_description' => 'Catch the latest entertainment news, celebrity gossip, movie releases, and TV shows updates from Hollywood and beyond.',
                'meta_keywords' => 'entertainment news, celebrity news, movie updates, tv shows, hollywood news',
            ],

            [
                'name' => 'Sports',
                'title' => 'Sports News – Live Scores, Matches & Highlights',
                'meta_title' => 'Sports News Today | Live Scores & Match Updates',
                'meta_description' => 'Get live sports news, match updates, scores, and highlights from cricket, football, and more. Stay updated with your favorite teams.',
                'meta_keywords' => 'sports news, live scores, match updates, cricket news, football news',
            ],

            [
                'name' => 'Technology',
                'title' => 'Technology News – Latest Tech Trends & Innovations',
                'meta_title' => 'Tech News Today | Gadgets, AI & Innovation Updates',
                'meta_description' => 'Explore latest technology news, gadgets, AI innovations, startups, and digital trends shaping the future.',
                'meta_keywords' => 'technology news, tech news, AI updates, gadgets, innovation',
            ],

            [
                'name' => 'Finance',
                'title' => 'Finance News – Investment, Banking & Money Tips',
                'meta_title' => 'Finance News Today | Markets, Banking & Investment',
                'meta_description' => 'Stay updated with finance news, stock market trends, banking updates, and smart investment tips.',
                'meta_keywords' => 'finance news, stock market, investment tips, banking news, money management',
            ],

            [
                'name' => 'Health',
                'title' => 'Health News – Wellness, Medical & Fitness Updates',
                'meta_title' => 'Health News Today | Medical, Fitness & Wellness',
                'meta_description' => 'Get the latest health news, medical research, fitness tips, and wellness advice for a healthier lifestyle.',
                'meta_keywords' => 'health news, medical updates, fitness tips, wellness, healthcare news',
            ],

            [
                'name' => 'Trending',
                'title' => 'Trending News – Viral Stories & Latest Buzz',
                'meta_title' => 'Trending News Today | Viral Stories & Hot Topics',
                'meta_description' => 'Discover trending news, viral stories, and the latest buzz from around the world. Stay ahead of what everyone is talking about.',
                'meta_keywords' => 'trending news, viral news, latest trends, hot topics, breaking trends',
            ],

        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'title' => $cat['title'],
                'meta_title' => $cat['meta_title'],
                'meta_description' => $cat['meta_description'],
                'meta_keywords' => $cat['meta_keywords'],
                'author' => 'Big Times News',
            ]);
        }
    }
}
