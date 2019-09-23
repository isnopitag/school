<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends ApiController
{
    public function __construct()
    {
        //$this->middleware('jwt-auth:teacher,student')->only(['show']);
        $this->middleware('jwt-auth:student')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
            $messages= '';
            foreach ($validator->errors()->all() as $message){
                $messages= $messages.' '.$message;
            }
            return $this->sendErrorResponse('Error al registrar: '.$messages);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->password = $request->password;
        if($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $user->profile_picture = $image->store('users','public');
        }
        $user->birth = $request->birth;
        $user->id_career = $request->id_career;
        $user->id_status = $request->id_status;
        $user->id_role = $request->id_role;

        $user->save();

        return $this->sendSuccessResponse($user, 'El usuario se registro correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = $this->getAuthenticatedUser();
        return $this->sendSuccessResponse($user,'Se cargo el usuario: '.$user->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('password')) {
            $user->password = $request->get('password');
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('birth')) {
            $user->birth = $request->birth;
        }

        if ($request->hasFile('profile_picture')) {
            Storage::delete('public/'.$user->imageName());
            $image = $request->file('profile_picture');
            $user->profile_picture = $image->store('users', 'public');
        }

        $user->save();
        return $this->sendSuccessResponse($user, 'El usuario se actualizo correctamente ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Storage::delete('public/'.$user->imageName());
        $user->delete();
        return $this->sendSuccessResponse(['id'=> $id], 'El usuario se Elimino :( ');
    }

    public function indexTeachers(){
        /*
        dd($this->getRoleIdByName('Teacher'));
        $teachers = User::with('status','career')->where('users.id_role',$this->getRoleIdByName('Teacher'))->get();
        return $this->sendCollectionCorrectResponse($teachers,'Teachers');*/

        $id_role = $this->getRoleIdByName('Teacher');
        $teachers = User::with('status','career')->where('users.id_role',$id_role)->get();
        return $this->sendCollectionCorrectResponse($teachers,'Teachers');
    }

    public function indexStudents(){

        $id_role = $this->getRoleIdByName('Student');
        $teachers = User::with('status','career')->where('users.id_role',$id_role)->get();
        return $this->sendCollectionCorrectResponse($teachers,'Teachers');
    }

    private function getRoleIdByName($roleName){
        return Role::whereName($roleName)->firstOrFail()->id;
    }
}
