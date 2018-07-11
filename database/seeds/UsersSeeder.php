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
        $root=Role::where('name','Root')->first();

        User::create([
            'email'=>'albertogradados@aliomexico.com',
            'password'=>bcrypt('2662'),
            'id_role'=> $root->id
        ]);


    }
}
