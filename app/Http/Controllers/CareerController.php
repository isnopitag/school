<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Career;

class CareerController extends ApiController
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
        $career = new Career();
        if($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $career->profile_image = $image->store('careers','public');
        }else{
            $career->profile_image = 'https://picsum.photos/500/500';
        }
        if($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $career->cover_image = $image->store('careers','public');
        }else{
            $career->cover_image = 'https://picsum.photos/500/500';
        }
        $career->career = $request->career;
        $career->save();
        return $this->sendSuccessResponse($career,'Career creada');
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
