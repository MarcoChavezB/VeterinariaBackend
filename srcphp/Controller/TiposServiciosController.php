<?php

namespace proyecto\Controller;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\TiposServicio;
use proyecto\Models\Table;
use proyecto\Conexion;
use proyecto\Models\Models;
use proyecto\Models\Tipos_servicios;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TiposServiciosController{
        function CrearTipoServicioYProductos() {
            try {
                $JSONData = file_get_contents("php://input");
                $dataObject = json_decode($JSONData);

                $tipoServicio = new Tipos_servicios();

                $tipoServicio->nombre_TServicio = $dataObject->nombre_TServicio;
                $tipoServicio->id_servicio = $dataObject->id_servicio;
                $tipoServicio->descripcion = $dataObject->descripcion;
                $tipoServicio->precio = $dataObject->precio;
                $tipoServicio->estado = $dataObject->estado;

                $tipoServicio->save();

                if($tipoServicio) {
                    $productos = $dataObject->productos;
                    foreach ($productos as $producto) {
                        $params = [
                            'in_id_servicio' => $tipoServicio->id,
                            'in_id_producto' => $producto->id,
                            'in_cantidad' => $producto->cantidad
                        ];
                        $resultado = Table::queryParams("CALL InsertarProductoServicio(:in_id_servicio, :in_id_producto, :in_cantidad)", $params);
                    }

                    $r = new Success("Tipo de servicio y productos asociados creados exitosamente.");
                } else {
                    $r = new Failure(400, "Hubo un error al crear el tipo de servicio y productos asociados.");
                }
                return $r->send();

            } catch (\Exception $e) {
                $r = new Failure(500, $e->getMessage());
                return $r->send();
            }
        }
        function serviciospublicos () {
            try {
                $resultados = Table::query("SELECT * FROM vista_servicios_publicos;");

                $r = new Success($resultados);
                return $r->Send();
            } catch (\Exception $e) {
                $r = new Failure(401, $e->getMessage());
                return $r->Send();
            }
        }
        function serviciosprivados () {
            try {
                $resultados = Table::query("SELECT * FROM vista_servicios_nopublicos;");

                $r = new Success($resultados);
                return $r->Send();
            } catch (\Exception $e) {
                $r = new Failure(401, $e->getMessage());
                return $r->Send();
            }
        }
        function serviciospublicosesteticos () {
            try {
                $resultados = Table::query("SELECT * FROM vista_servicios_publicos_esteticos;");

                $r = new Success($resultados);
                return $r->Send();
            } catch (\Exception $e) {
                $r = new Failure(401, $e->getMessage());
                return $r->Send();
            }
        }
        function serviciospublicosclinicos () {
            try {
                $resultados = Table::query("SELECT * FROM vista_servicios_publicos_clinicos;");

                $r = new Success($resultados);
                return $r->Send();
            } catch (\Exception $e) {
                $r = new Failure(401, $e->getMessage());
                return $r->Send();
            }
        }

               function serviciosprivadossesteticos () {
            try {
                $resultados = Table::query("SELECT * FROM vista_servicios_no_publicos_esteticos;");
        
                $r = new Success($resultados);
                return $r->Send();
            } catch (\Exception $e) {
                $r = new Failure(401, $e->getMessage());
                return $r->Send();
            }
        }

        function serviciosprivadosclinicos () {
            try {
                $resultados = Table::query("SELECT * FROM vista_servicios_no_publicos_clinicos;");

                $r = new Success($resultados);
                return $r->Send();
            } catch (\Exception $e) {
                $r = new Failure(401, $e->getMessage());
                return $r->Send();
            }
        }


        function publicarono()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $resultados = Table::query(" CALL TipoServicioEstado ('{$dataObject->id_servicio}')");

            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

}
