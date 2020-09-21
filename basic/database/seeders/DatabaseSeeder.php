<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        User::create([
            'name' => 'Johan Mosquera',
            'email' => 'johan@admin.com',
            'password' => bcrypt('12345')
        ]);

        Post::factory(24)->create();
    }
}
