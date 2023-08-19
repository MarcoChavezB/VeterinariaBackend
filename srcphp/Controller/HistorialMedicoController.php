<?php

namespace proyecto\Controller;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Models;
use proyecto\Models\Table;
use PDO;

class HistorialMedicoController{

    function HistorialMedicoIDFecha(){
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL HistorialMedicoIDFecha ('{$dataObject->id_animal}','{$dataObject->Fecha}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function HistorialIDMascota(){
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL HistorialIDMascota ('{$dataObject->id_mascota}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }

    }
 
}