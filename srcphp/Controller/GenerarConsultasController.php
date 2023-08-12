<?php

namespace proyecto\Controller;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Consultas;
use proyecto\Response\Response; 
use proyecto\Models\Table;
use proyecto\Models\Models;
use proyecto\Models\Detalle_Consultas;
use PDO;

class GenerarConsultasController{

    function RegistroConsulta (){
        try {
          $JSONData = file_get_contents("php://input");
          $dataObject = json_decode($JSONData);


        
          $Consulta = new Consultas();
          $Consulta->id_cita = $dataObject->id_cita;
          $Consulta->observaciones = $dataObject->observaciones;
          $Consulta->peso_kg = $dataObject->peso; 
          $Consulta->altura_mts = $dataObject->altura;
          $Consulta->edad_meses = $dataObject->edad; 
          $Consulta->save();

          foreach($dataObject->servicios_id as $item){
            $dc =new Detalle_Consultas();
            $dc-> id_consulta = $Consulta -> id;
            $dc-> id_tservicios = $item;
            $dc -> save();
          }
           
          $r = new Success($Consulta);
          return $r->Send();
            } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();

        }
      }
      
    function GenerarConsultasCliente () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL GenerarConsultasCliente ('{$dataObject->Nombre}','{$dataObject->Apellido}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function GenerarConsultasFecha () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL GenerarConsultasFecha ('{$dataObject->Fecha}', '{$dataObject->Fecha2}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function GenerarConsultas (){
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("SELECT * FROM GenerarConsultas ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function TServicios (){
        try {
            
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("SELECT * FROM TServicios ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

}

  