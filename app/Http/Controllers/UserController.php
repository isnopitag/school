<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends ApiController
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

    private function getRoleIdByName($roleName){
        return Role::whereName($roleName)->firstOrFail()->id;
    }
}
