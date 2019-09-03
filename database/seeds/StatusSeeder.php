<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create('Inscrito');
        $this->create('No Inscrito');
        $this->create('Activo');
        $this->create('No Activo');

    }

    private function create($status){
        Status::create([
            'status' => $status
        ]);
    }
}
