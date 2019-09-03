<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                RolesSeeder::class,
                StatusSeeder::class,
                CareerSeeder::class,
                UsersSeeder::class
            ]
        );

        factory(App\Career::class, 5)->create();
    }
}
