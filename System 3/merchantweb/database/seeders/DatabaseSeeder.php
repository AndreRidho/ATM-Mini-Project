<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Product;
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

        User::factory()->create([
            'name' => 'a',
            'email' => 'a@a',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);

        User::factory(5)->create();

        Product::factory()->create([
            'name' => 'Lamp',
            'price' => 40
        ]);

        Product::factory()->create([
            'name' => 'Table',
            'price' => 120
        ]);

        Product::factory()->create([
            'name' => 'Chair',
            'price' => 30
        ]);

        Product::factory()->create([
            'name' => 'Couch',
            'price' => 250
        ]);

        Product::factory()->create([
            'name' => 'Bed',
            'price' => 400
        ]);
    }
}
