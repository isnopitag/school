<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Status;
use App\Career;
use App\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher=Role::where('name','Teacher')->first();

        $active = Status::where('status','Activo')->first();

        $systems = Career::where('career','Sistemas')->first();

        User::create([
            'name' => 'Alberto Granados',
            'email'=>'albertogradados@aliomexico.com',
            'profile_picture' => 'https://loremflickr.com/500/500',
            'password'=>'2662school',
            'id_career' => $systems->id,
            'id_status' => $active->id,
            'id_role'=> $teacher->id
        ]);

        $student=Role::where('name','Student')->first();

        $roled = Status::where('status','Inscrito')->first();

        $systems = Career::where('career','Sistemas')->first();

        User::create([
            'name' => 'Alumno Generico',
            'email'=>'alumno@school.com',
            'profile_picture' => 'https://loremflickr.com/500/500',
            'password'=>'2662school',
            'id_career' => $systems->id,
            'id_status' => $roled->id,
            'id_role'=> $student->id
        ]);

        $this->createTeachers(5,$active->id,$teacher->id);

        $this->createStudents(7,$roled->id,$student->id);
    }

    private function createTeachers($quantity,$id_status,$id_teacher){
        for($i=1;$i<=$quantity;$i++) {
            factory(App\User::class, 1)->create([
                'id_career' => random_int(DB::table('careers')->min('id'), DB::table('careers')->max('id')),
                'id_status' => $id_status,
                'id_role' => $id_teacher
            ]);
        }
    }

    private function createStudents($quantity,$id_status,$id_student){
        for($i=1;$i<=$quantity;$i++) {
            factory(App\User::class, 1)->create([
                'id_career' => random_int(DB::table('careers')->min('id'), DB::table('careers')->max('id')),
                'id_status' => $id_status,
                'id_role' => $id_student
            ]);
        }
    }
}
