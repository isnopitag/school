<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//TODO se deben imporatar todos los modelos que se vayan a utilizar  ejemplo
use App\BaseModelForUser;
//TODO O uno con un modelo que si va mas en serio
use App\Blog;

//TODO TODOS Los Controladores deben hacer extend de ApiController para los metodos de JWT y SendSuccesResponse
class BaseExampleController extends ApiController
{

    //TODO Este metodo es toda la seguridad el JWT que se necesita pongo ejemplos reales de BlogController de Agronexo III
    public function __construct() {
        $this->middleware('jwt-auth:superadmin')->only(['destroy']);
        $this->middleware('jwt-auth:superadmin,editor')->only(['store', 'update','indexAll']);

        //TODO: La estrucutura es asi:

        //TODO: Esto quiere decir que el Rol1,Rol2,Rol3 podran acceder al metodo, metodo2,metodo3
        $this->middleware('jwt-auth:Rol1, Rol2, Rol3')->only(['metodo','metodo2','metodo3']);

        //TODO: pero si un determinado rol quiere ingresar a uno o varios metodos solo se deja solo como aqui el ROL 0 solo accede al metodo 0
        $this->middleware('jwt-auth:Rol0')->only(['metodo0']);

        //TODO Si un metodo no se requiere del JWT no se especifica, esto suele ocurrir mucho con los metodos: INDEX y SHOW que por lo regular son mas publicos.
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
}
