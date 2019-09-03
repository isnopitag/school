<?php

use Illuminate\Database\Seeder;
use App\Career;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create('Sistemas');
        $this->create('Quimica');
        $this->create('Ambiental');
        $this->create('Administracion');
        $this->create('Mecanica');

        factory(App\Career::class, 10)->create();

    }

    private function create($career){
        Career::create([
            'career' => $career,
            'profile_image' => 'https://loremflickr.com/500/500',
            'cover_image' => 'https://loremflickr.com/1000/500'
        ]);
    }
}
