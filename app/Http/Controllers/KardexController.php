<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kardex;

class KardexController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt-auth:student')->only(['store','index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = $this->getAuthenticatedUser();

        $kardex = Kardex::with('user.status','subject','subject.user.status')
            ->whereHas('user' , function($q) use ($student){
                $q->where('users.id',$student->id);
            })->get();
        return $this->sendSuccessResponse($kardex,'Se cargo el kardex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $student = $this->getAuthenticatedUser();

        $kardex = new Kardex();
        $kardex->id_student = $student->id;
        $kardex->id_subject = $id;
        $kardex->save();
        return $this->sendSuccessResponse($kardex, 'La materia se asigno correctamente');

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
}
