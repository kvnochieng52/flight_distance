<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'New Flight Routes to Africa Announced',
                'content' => 'Several airlines have announced new direct flight routes connecting major African cities. This expansion is expected to boost tourism and business travel across the continent.',
                'regions' => 'Africa, Kenya, Nigeria, South Africa',
                'posted_by' => 'Flight News Team',
                'date_posted' => now()->subDays(1),
            ],
            [
                'title' => 'Aviation Industry Shows Strong Recovery',
                'content' => 'The global aviation industry continues its recovery with passenger numbers reaching 85% of pre-pandemic levels. Airlines are optimistic about the coming year.',
                'regions' => 'Global, Europe, Asia, Americas',
                'posted_by' => 'Industry Reporter',
                'date_posted' => now()->subDays(3),
            ],
            [
                'title' => 'Sustainable Aviation Fuel Initiative Launched',
                'content' => 'A new initiative to promote sustainable aviation fuel usage has been launched by major airlines. This effort aims to reduce carbon emissions by 50% by 2030.',
                'regions' => 'Global, Europe, North America',
                'posted_by' => 'Environmental Team',
                'date_posted' => now()->subDays(5),
            ],
            [
                'title' => 'Airport Expansion Projects Underway',
                'content' => 'Multiple airports across East Africa are undergoing major expansion projects to accommodate increasing passenger traffic and improve services.',
                'regions' => 'East Africa, Kenya, Tanzania, Uganda',
                'posted_by' => 'Infrastructure News',
                'date_posted' => now()->subDays(7),
            ],
            [
                'title' => 'New Aircraft Technology Unveiled',
                'content' => 'Leading aircraft manufacturers have unveiled new fuel-efficient aircraft designs that promise to revolutionize air travel with improved performance and reduced environmental impact.',
                'regions' => 'Global, Technology',
                'posted_by' => 'Tech Reporter',
                'date_posted' => now()->subDays(10),
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
