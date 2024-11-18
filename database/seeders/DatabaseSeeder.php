<?php

namespace Database\Seeders;

use App\Models\department;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin User',
            'email' => 'admin@example.com',
            'is_admin'=>true,
            'password'=> bcrypt('1811995'),
        ]);
            $this->call(CountriesTableSeeder::class);
            $this->call(StatesTableSeeder::class);
            $this->call(CitiesTableSeeder::class);
            // department::create(['name'=>'Laravel']);
    }
}
