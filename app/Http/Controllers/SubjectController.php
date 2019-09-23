<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subject;

class SubjectController extends ApiController
{

    public function __construct()
    {
        $this->middleware('jwt-auth:teacher')->only(['store']);
        $this->middleware('jwt-auth:teacher,student')->only(['index']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::with('user')->get();
        return  $this->sendSuccessResponse($subjects,'Todas las materias cargadas');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $teacher  = $this->getAuthenticatedUser();
        $subject = new Subject();
        $subject->id_teacher = $teacher->id;
        $subject->name = $request->name;
        $subject->description = $request->description;
        $subject->save();

        return $this->sendSuccessResponse($subject,'Se creo la materia: '.$request->name);
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
