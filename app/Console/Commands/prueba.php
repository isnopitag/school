<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Status;
class prueba extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:prueba';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[School] Este comando crea status Aleatorios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createStatus();
    }

    private function createStatus(){
        Status::create([
            'status' => 'Status_'.random_int(0,1000)
        ]);
    }
}
