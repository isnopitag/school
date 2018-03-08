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
        $root=Role::create([
            'name' => 'Root',
            'slug' => 'root',
            'permissions' =>json_encode([
                'web_root' => true,
                'web_admin' => true,
                'web_client' => true,
            ]),
        ]);

        $superadmin=Role::create([
            'name' => 'Superadmin',
            'slug' => 'superadmin',
            'permissions' => json_encode([
                'web_admin' => true,
            ]),
        ]);

        $client=Role::create([
            'name' => 'Client',
            'slug' => 'client',
            'permissions' => json_encode([
                'web_client' => true,
                'mobile_client' => true,
            ]),
        ]);
    }
}
