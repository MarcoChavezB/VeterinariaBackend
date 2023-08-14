<?php
namespace proyecto\Controller;
use proyecto\Models\Ordenes_compras;
use proyecto\Models\Productos;
use proyecto\Models\ProductosInternos;
use proyecto\Models\DetalleCompras;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\models\Table;
use proyecto\Conexion;
use proyecto\Models\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Ordenes_comprasController {

    function CrearOrdenCompra() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $ordenCompra = new Ordenes_compras();
    
            // Asignar valores a las propiedades
            $ordenCompra->fecha_compra = $dataObject->fecha_compra;
            $ordenCompra->fecha_pago = $dataObject->fecha_pago;
            $ordenCompra->estado_pago = $dataObject->estado;
            $ordenCompra->id_empleado = $dataObject->id_empleado;
            $ordenCompra->estado = $dataObject->estatus;
            $ordenCompra->proveedor = $dataObject->proveedor;
    
            $ordenCompra->save();
    
            if($ordenCompra) {
                $r = new Success("Orden de compra creada exitosamente.", $ordenCompra);
            } else {
                $r = new Failure(400, "Hubo un error al crear la orden de compra.");
            }
            return $r->send();
    
        } catch (\Exception $e) {
            $r = new Failure(500, $e->getMessage());
            return $r->send();
        }
    }

    // obtener todo de ordenes compras pendientes
    function TablaOrdenesCompras () {
        try {
            $resultados = Table::query("SELECT * FROM OrdenesPendientes;");
    
            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    function buscarOrdenesPorFecha() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $params = [
                'columna' => $dataObject->columna,
                'fecha1' => $dataObject->fecha1,
                'fecha2' => $dataObject->fecha2,
            ];
    
            $resultado = Table::queryParams("CALL BuscarOrdenesPorFecha(:columna, :fecha1, :fecha2)", $params);
    
            if($resultado) {
                $r = new Success($resultado);
                return $r->send();
            } else {
                $r = new Failure(404, "No se encontraron ordenes en el rango de fechas proporcionado.");
                return $r->send();
            }
        } catch (\Exception $e) {
            $r = new Failure(500, $e->getMessage());
            return $r->send();
        }
    }

    function buscarOrdenesPorEstado() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $params = [
                'columna' => $dataObject->columna,
            ];
    
            $resultado = Table::queryParams("CALL BuscarOrdenesPorEstado(:columna)", $params);
    
            if($resultado) {
                $r = new Success($resultado);
                return $r->send();
            } else {
                $r = new Failure(404, "No se encontraron ordenes con el estado proporcionado.");
                return $r->send();
            }
        } catch (\Exception $e) {
            $r = new Failure(500, $e->getMessage());
            return $r->send();
        }
    }

    function agregarDetalleCompras() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $orden_compra = $dataObject->orden_compra;
            $detalles_compra = $dataObject->productos;
            foreach ($detalles_compra as $detalle) {
                $params = [
                    'orden_compra' => $orden_compra,
                    'producto' => $detalle->producto,
                    'cantidad' => $detalle->cantidad,
                    'precio_compra' => $detalle->precio_compra,
                ];
    
                $resultado = Table::queryParams("CALL AgregarDetalleCompras(:orden_compra, :producto, :cantidad, :precio_compra)", $params);
            }
    
            $r = new Success($resultado);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }
    
    
    
    
    
    
    
    
}

