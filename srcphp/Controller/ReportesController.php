<?php

namespace proyecto\Controller;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Table;
use PDO;

class ReportesController {


    function ReporteConsultas()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" CALL ReporteConsultas ('{$dataObject->nomC}','{$dataObject->apellidos}', '{$dataObject->nomM}')");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function historialMedico()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" CALL HistorialMEdico ('{$dataObject->nombreMascota}','{$dataObject->cliente}')");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function historialMedicoCliente () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL HistorialMedicoCliente ('{$dataObject->nombreMascota}','{$dataObject->nombres}','{$dataObject->apellidos}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteConsultasFecha () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL ReporteConsultasFecha ('{$dataObject->Fecha}','{$dataObject->Fecha2}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteConsultasCliente () {
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL ReporteConsultasCliente ('{$dataObject->Nombre}','{$dataObject->Apellido}','{$dataObject->Fecha}','{$dataObject->Fecha2}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function ReporteGeneralOrdenesCompra () {
        try{
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" SELECT * FROM ReporteGeneralOrdenesCompra ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteGeneralOrdenesCompraPagadas () {
        try{
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" SELECT * FROM ReporteGeneralOrdenesCompraPagadas ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteGralVentas () {
        try{
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" SELECT * FROM ReporteGralVentas ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteFechaVentas () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL ReporteFechaVentas ('{$dataObject->Fecha}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function ReporteGralCitasRechazadas (){
        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("SELECT * FROM ReporteGralCitasRechazadas ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteCitasRechazadasCliente () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL ReporteCitasRechazadasCliente ('{$dataObject->Nombre}','{$dataObject->Apellido}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function ReporteCitasRechazadasFecha () {

        try{

            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            
            $resultados = Table::query("CALL ReporteCitasRechazadasFecha ('{$dataObject->Fecha}','{$dataObject->Fecha2}') ");

            $r = new Success($resultados);
            return $r->Send();
        }catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }
}
