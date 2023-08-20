<?php

namespace proyecto\Controller;
use proyecto\Models\User;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Animales;
use proyecto\Response\Response;
use proyecto\Models\Table;
use proyecto\Models\Models;
use PDO;

class MascotasController {

    function registrarMascota(){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $animal = new Animales();
            $animal->nombre = $dataObject->nombre_;
            $animal->propietario=$dataObject->propietario_;
            $animal->especie=$dataObject->especie_;
            $animal->raza=$dataObject->raza_;
            $animal->genero=$dataObject->genero_; 
            $animal->save();
    
            $r = new Success($animal);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

function registrarMascotaInsert () {
    try {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        $resultados = Table::query("INSERT INTO animales (nombre, propietario, especie, raza, genero) VALUES ('{$dataObject->nombre_}', '{$dataObject->propietario_}', '{$dataObject->especie_}', 
        '{$dataObject->raza_}',  '{$dataObject->genero_}' ) ");

        $r = new Success($animal);
        return $r->Send();
    } catch (\Exception $e) {
        $r = new Failure(401, $e->getMessage());
    }
}

}