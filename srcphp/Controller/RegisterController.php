<?php

namespace proyecto\Controller;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Consultas;
use proyecto\Response\Response;
use proyecto\Models\Table;
use proyecto\Models\Models;
use proyecto\Models\Detalle_Consultas;
use proyecto\Models\Usuarios;
use PDO;

class RegisterController {

    function auth()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            if (!property_exists($dataObject, "correo") || !property_exists($dataObject, "contra")) {
                throw new \Exception("Faltan datos");
            }
            return Usuarios::auth($dataObject->correo, $dataObject->contra);

        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }


    }
    function test(){
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultado = Table::query("select * from clientes");

            $r = new Success($resultado);
            return $r->Send();
        }catch(\Exception $e){
            $r = new Failure(401, $e->getMessage());
                    return $r->Send();
        }
    }

    function signin() {
        try{
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $c = new Usuarios();

            $c->nombre = $dataObject->nombres;
            $c->apellido = $dataObject->apellidos;
            $c->correo = $dataObject->correo;
            $c->telefono1 = $dataObject->tel1;
            $c->telefono2 = $dataObject->tel2;
            $c->contra = $dataObject->password;
            $c->tipo_usuario = $dataObject->ts;

            $c -> save();
            $r = new Success($c);

            return $r->Send();

        }catch(\Exception $e){
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

}