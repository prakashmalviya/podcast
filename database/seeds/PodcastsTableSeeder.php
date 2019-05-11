<?php
    use Illuminate\Database\Seeder;
    use Faker\Factory as Faker;
    use App\Podcast;

    /**
     * Class PodcastsTableSeeder
     */
    class PodcastsTableSeeder extends Seeder
    {

        /**
         * Run the database seeds.
         * @return void
         */
        public function run()
        {
            $faker = Faker::create();
            // For quick pagination testing lets add some seeds
            for ($i = 0; $i < 25; $i++) {
                Podcast::create([
                    'name'          => $faker->realText(20),
                    'description'   => $faker->text,
                    'marketing_url' => $faker->url,
                    'feed_url'      => $faker->url,
                    'status'        => 'published',
                ]);
            }
        }
    }
