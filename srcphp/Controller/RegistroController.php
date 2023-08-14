<?php

namespace proyecto\Controller;
use proyecto\Models\Usuarios;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Table;
use proyecto\Models\Models;




class RegistroController {


    public function verificarCorreo()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $correo = $dataObject->correo;

            $resultado = $this->verificarCorreoQuery($correo);

            if ($resultado) {
                
                $response = array(
                    "message" => "no",
                    "data" => $resultado 
                );
                $r = new Success($response);
                return $r->send();

            } else {
                $response = array(
                    "message" => "si",
                    "data" => $resultado 
                );
                $r = new success($response);
                return $r->send();
            }

        } catch (\Exception $e) {
            
            $r = new Failure(500, "Error en el servidor: " . $e->getMessage());
            return $r->Send();
        }
    }

    function verificarCorreoQuery($correo)
    {
        $resultados = Table::queryParams("SELECT * FROM usuarios WHERE correo = :correo", ['correo' => $correo]);
        
        if (count($resultados) > 0) {
            return true;
        }
        return false;
    }



    function registrar() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);;
            $reg = new Usuarios();
            $reg->nombre = $dataObject->nombre;
            $reg->apellido = $dataObject->last;
            $reg->correo = $dataObject->correo;
            $reg->telefono1 = $dataObject->tel1;
            $reg->telefono2 = $dataObject->tel2;
            $reg->contra = $dataObject->contrasena;
            $reg->tipo_usuario = $dataObject->tipo_usuario;

            $reg->save();
            $r = new Success($reg);

            return $r->send();

        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage()); 
            return $r->send();
        }
    }

    function mostrarR() {
        $t = Table::query("select * from clientes");
        $r = new Success($t);
        return $r->send();
    }
}
