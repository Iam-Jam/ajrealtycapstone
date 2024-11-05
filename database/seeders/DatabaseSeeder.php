<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call the UserSeeder
        $this->call(UserSeeder::class);

        // Call other seeders if needed
        // $this->call(AnotherSeeder::class);
    }
}
