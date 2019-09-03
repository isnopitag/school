<?php

use Illuminate\Database\Seeder;

use App\Role;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $root=Role::create([
            'name' => 'Root',
            'slug' => 'root',
            'permissions' =>json_encode([
                'web_root' => true,
                'web_admin' => true,
                'web_client' => true,
            ]),
        ]);*/

        Role::create([
            'name' => 'Teacher',
            'slug' => 'teacher',
        ]);

        Role::create([
            'name' => 'Student',
            'slug' => 'student',
        ]);
    }
}
