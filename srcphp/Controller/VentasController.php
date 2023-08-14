<?php

namespace proyecto\Controller;

use proyecto\Models\Table;
use proyecto\Response\Success;


class VentasController
{

    function fecha()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $fechaI = $dataObject->fechaI;
            $fechaF = $dataObject->fechaF;

            $result = $this->ventasTot($fechaI, $fechaF);

            header('Content-Type: application/json');
            echo json_encode($result);
        } catch (\Exception $e) {
            $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($errorResponse);
            http_response_code(500);
        }
    }


    function ventasTot($fechaI, $fechaF)
    {
        $t = table::queryParams("SELECT ventas.fecha, 
            COUNT(ventas.id) AS cantidad
            FROM ventas
            WHERE ventas.fecha BETWEEN :fechaI and :fechaF
            GROUP BY ventas.fecha", ['fechaI' => $fechaI, 'fechaF' => $fechaF]);

        return $t;
    }

    function mostrarVentasRecientes()
    {
        $t = Table::query("CALL ventasActuales()");
        $r = new Success($t);
        $json_response = json_encode($r);

        header('Content-Type: application/json');
        echo $json_response;
    }


    function venta() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $metodo_pago = $dataObject->metodo_pago;
            $productos = $dataObject->productos;
    
            $products = $this->ventaQuery($metodo_pago, $productos);
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
    
    
    function ventaQuery($metodo_pago, $productos) {
        // $productos es un array de arrays donde cada subarray tiene [id_producto, cantidad]
        $r = table::queryParams("call venta_productos(:metodo_pago, :productos)",
            [
                'metodo_pago' => $metodo_pago,
                'productos' => $productos, 
            ]
        );
        return $r;
    }



    function tiket()
    {
        $t = Table::query("call GenerarReporteUltimaVenta()");
        $r = new Success($t);
        $json_response = json_encode($r);

        header('Content-Type: application/json');
        echo $json_response;
    }
    
}
