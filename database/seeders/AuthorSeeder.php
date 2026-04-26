<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Michael Anderson',
                'email' => 'michael.anderson@example.com',
                'bio' => 'Michael Anderson is an automotive documentation specialist with over 10 years of experience in vehicle registration, title transfer, and compliance processes. He publishes SEO-optimized guides on car ownership, DMV procedures, and legal documentation in the United States.',
                'linkedin' => 'https://linkedin.com/in/michaelanderson',
            ],
            [
                'name' => 'Jessica Williams',
                'email' => 'jessica.williams@example.com',
                'bio' => 'Jessica Williams is a professional SEO content writer specializing in automotive services, vehicle insurance, and car registration processes. She creates high-ranking blog content focused on improving search visibility and user engagement.',
                'linkedin' => 'https://linkedin.com/in/jessicawilliams',
            ],
            [
                'name' => 'David Miller',
                'email' => 'david.miller@example.com',
                'bio' => 'David Miller is an automotive industry expert writing in-depth articles about vehicle title transfers, registration renewals, and state DMV regulations. His content helps users navigate complex legal requirements with ease.',
                'linkedin' => 'https://linkedin.com/in/davidmiller',
            ],
            [
                'name' => 'Emily Johnson',
                'email' => 'emily.johnson@example.com',
                'bio' => 'Emily Johnson is a digital content strategist focused on automotive compliance, vehicle insurance policies, and car ownership documentation. She produces SEO-friendly content designed to rank on Google and provide real value.',
                'linkedin' => 'https://linkedin.com/in/emilyjohnson',
            ],
            [
                'name' => 'Christopher Brown',
                'email' => 'christopher.brown@example.com',
                'bio' => 'Christopher Brown specializes in automotive blogging with expertise in vehicle inspections, emissions testing, and car permit processes. His SEO-driven articles simplify complex topics for everyday readers.',
                'linkedin' => 'https://linkedin.com/in/christopherbrown',
            ],
            [
                'name' => 'Ashley Davis',
                'email' => 'ashley.davis@example.com',
                'bio' => 'Ashley Davis is an experienced SEO writer covering car insurance, registration renewals, and vehicle documentation in the U.S. Her content focuses on clarity, accuracy, and search engine optimization.',
                'linkedin' => 'https://linkedin.com/in/ashleydavis',
            ],
            [
                'name' => 'Daniel Martinez',
                'email' => 'daniel.martinez@example.com',
                'bio' => 'Daniel Martinez is an automotive consultant and writer specializing in vehicle title processing, tax compliance, and DMV-related services. He creates authoritative SEO content to help users understand legal procedures.',
                'linkedin' => 'https://linkedin.com/in/danielmartinez',
            ],
            [
                'name' => 'Sophia Garcia',
                'email' => 'sophia.garcia@example.com',
                'bio' => 'Sophia Garcia is a professional content creator focusing on automotive services, vehicle permits, and compliance documentation. She writes SEO-optimized guides that improve rankings and user experience.',
                'linkedin' => 'https://linkedin.com/in/sophiagarcia',
            ],
            [
                'name' => 'Matthew Wilson',
                'email' => 'matthew.wilson@example.com',
                'bio' => 'Matthew Wilson is a digital writer with expertise in vehicle registration, ownership transfer, and automotive compliance. His SEO-focused articles help users make informed decisions about car documentation.',
                'linkedin' => 'https://linkedin.com/in/matthewwilson',
            ],
            [
                'name' => 'Olivia Taylor',
                'email' => 'olivia.taylor@example.com',
                'bio' => 'Olivia Taylor is an SEO content expert specializing in automotive documentation, car insurance, and registration processes. She creates engaging, search-optimized content that ranks well on Google.',
                'linkedin' => 'https://linkedin.com/in/oliviataylor',
            ],
        ];

        foreach ($authors as $author) {
            Author::create(array_merge([
                'image' => null,
                'facebook' => null,
                'twitter' => null,
                'instagram' => null,
                'threads' => null,
                'is_active' => 'active',
            ], $author));
        }
    }
}
