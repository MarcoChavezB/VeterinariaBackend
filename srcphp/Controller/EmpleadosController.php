<?php

namespace proyecto\Controller;
use proyecto\Models\User;
use proyecto\Models\Empleados;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Models;
use proyecto\Models\Table;
use PDO;


class EmpleadosController{
    function registrar(){
        try{
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $reg = new empleados();
            $reg->nombre = $dataObject->nombre;
            $reg->apellido = $dataObject->apellido;
            $reg->correo = $dataObject->correo;
            $reg->contrasena = $dataObject->contrasena;
            
            $reg->save();
            $r = new Success($reg);
            
            return $r->send();
        }catch (\Exception $e){
            $r = new Failure(401,$e->getMessage("No se realizo el registro"));
            return $r->Send();
        }
    }

    function mostrarR(){
        $t=Table::query("select * from empleados");
        $r= new Success($t);
        return $r->Send();
    }
}