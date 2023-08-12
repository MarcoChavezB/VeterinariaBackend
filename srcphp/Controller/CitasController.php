<?php

namespace proyecto\Controller;

use proyecto\Models\Models;
use proyecto\models\Table;
use proyecto\Response\Success;
use proyecto\Models\Citas;
use proyecto\Models\Animales;
use proyecto\Models\Clientes;
use proyecto\Response\Failure;


class citasController
{
    function mostrarCitasPendientes()
    {
        $t = Table::query("SELECT *
        FROM citas
        WHERE DATE(fecha_cita) >= CURDATE() AND DATE(fecha_cita) <= CURDATE() + INTERVAL 2 DAY
        LIMIT 3;
        ");
        $r = new Success($t);
        $json_response = json_encode($r);

        header('Content-Type: application/json');
        echo $json_response;
    }

    function agendarcita() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $cita = new Citas();
            $cita->fecha_registro = date('Y-m-d H:i:s');
            $cita->fecha_cita = $dataObject->fechaCita;
            $cita->id_mascota = $dataObject->id_mascota;
            $cita->estatus = $dataObject->estatus;
            $cita->motivo = $dataObject->motivo;
            $cita->save();

            $r = new Success($cita);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function MascotasUsuario() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query("CALL MascotasUsuario ('{$dataObject->id_cliente}') ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function CitasPendientesCliente() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" CALL CitasPendientesCliente ('{$dataObject->id_cliente}') ");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }


    function citasAceptadas()
    {
        try {
            $t = Table::query("SELECT 
            citas.id,
            clientes.nombre,
            clientes.telefono1,
            citas.fecha_cita,
            citas.estatus,
            animales.raza
            from citas
                inner join animales on animales.id = citas. id_mascota
                inner join clientes on clientes.id = animales.propietario
                where citas.estatus = 'Aceptada'         
            ");
            $r = new Success($t);
            $json_response = json_encode($r);

            header('Content-Type: application/json');
            echo $json_response;
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function citasTot()
    {
        try {
            $t = Table::query("SELECT 
            citas.id,
            clientes.nombre,
            clientes.telefono1,
            citas.fecha_cita,
            citas.estatus,
            animales.raza
            from citas
                inner join animales on animales.id = citas. id_mascota
                inner join clientes on clientes.id = animales.propietario
                where citas.estatus = 'pendiente'         
            ");
            $r = new Success($t);
            $json_response = json_encode($r);

            header('Content-Type: application/json');
            echo $json_response;
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function cita_id (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $cita_id = $dataObject->cita_id;            

            $cita = $this->cita_id_query($cita_id);
            $response = ['data' => $cita];

            header('Content-Type: application/json');
            echo json_encode(['message' => 'Procedimiento ejecutado correctamente', 'data' => $response]);
            
        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }

    function cita_id_query ($cita_id) {
        $r = table::queryParams("SELECT 
        citas.id,
        citas.motivo,
        clientes.nombre,
        clientes.telefono1,
        citas.fecha_registro,
        citas.fecha_cita,
        citas.estatus,
        animales.raza
        from citas
            inner join animales on animales.id = citas. id_mascota
            inner join clientes on clientes.id = animales.propietario   
        where citas.id = :cita_id",
            
            [
                'cita_id' => $cita_id,
            ]
        
        );
        return $r;

    }
    function rechazar_aceptar_cita (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $id_cita = $dataObject->cita_id;
            $cita_estatus = $dataObject->cita_respuesta;            

            $products = $this->rechazar_aceptar_cita_query($id_cita, $cita_estatus);
            $response = ['data' => $products];


            header('Content-Type: application/json');
            echo json_encode(['message' => 'Procedimiento ejecutado correctamente', 'data' => $response]);
            
        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }

    function rechazar_aceptar_cita_query($id_cita, $cita_estatus) {
        $r = table::queryParams("CALL cambiar_estatus_cita(:id_cita,:cita_estatus)",
            
            [
                'id_cita' => $id_cita,
                'cita_estatus' => $cita_estatus,
            ]
        
        );
        echo 'success', $r;
        return $r;

    }
}
