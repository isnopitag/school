<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gate;

class TestRolesController extends Controller
{
    public function homeRoot(){
        if(Gate::allows('web_root')){
            return "Estas en root";
        }
        return $this->getAccessDenied();
    }

    public function HomeSuperAdmin(){
        if(Gate::allows('web_admin')){
            return "Estas en superAdmin";
        }
        return $this->getAccessDenied();
    }

    public function homeClient(){
        if(Gate::allows('web_client')){
            return "Estas en client ";
        }
        return $this->getAccessDenied();
    }

    private function getAccessDenied(){
        return response( 'Acceso Denegado', 401 );
    }


}
