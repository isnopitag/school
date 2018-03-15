<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\User;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Alberto Granados',
            'email'=>'albertogradados@aliomexico.com',
            'password'=>bcrypt('2662')
        ]);

        DB::table('role_users')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
