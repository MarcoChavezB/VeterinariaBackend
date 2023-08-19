<?php

namespace proyecto\Controller;

use proyecto\Models\Productos;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Table;

class ProductoController
{
    function AgregarProducto()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
            $pro = new productos();

            $pro->nom_producto = $dataObject->nom_producto;
            $pro->descripcion = $dataObject->descripcion;
            $pro->existencias = $dataObject->existencias;
            $pro->precio_venta = $dataObject->precio_venta;
            $pro->id_categoria = $dataObject->id_categoria;
            $pro->id_proveedor = $dataObject->id_proveedor;
            $pro->precio_compra = $dataObject->precio_compra;


            $pro->save();
            $r = new Success($pro);

            return $r->send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage("No se añadio el producto"));
            return $r->Send();
        }
    }



    function AgregarProductoPublico()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $nom_producto = $dataObject->nombre_producto;
            $descripcion = $dataObject->descripcion_producto;
            $tipo_producto = $dataObject->tipo_producto;
            $existencias = $dataObject->cantidad_pructos;
            $precio_venta = $dataObject->precio_venta;
            $precio_compra = $dataObject->precio_compra;
            $categoria = $dataObject->categoria_producto; 
            

            $products = $this->AgregarProductoPublicoQuery($nom_producto, $descripcion, $tipo_producto, $precio_venta, $categoria, $existencias, $precio_compra);
    
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
    
    function AgregarProductoPublicoQuery($nom_producto, $descripcion, $tipo_producto, $precio_venta, $categoria, $existencias, $precio_compra)
    {
        
        $t = table::queryParams("CALL insertar_producto_publico(:nom_producto, :descripcion, :tipo_producto, :existencias, :precio_venta, :categoria, :precio_compra)", [
            'nom_producto' => $nom_producto,
            'descripcion' => $descripcion,
            'tipo_producto' => $tipo_producto,
            'precio_venta' => $precio_venta,
            'categoria' => $categoria,
            'existencias' => $existencias,
            'precio_compra' => $precio_compra
        ]);
    
        return $t;
    }
    

    
    function modificarProducto (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nom_producto = $dataObject->nombre_producto;
            $existencias = $dataObject->cantidad_producto;            

            $products = $this->modificarProductoQuerry($nom_producto, $existencias);
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

    function modificarProductoQuerry($nom_producto, $existencias) {
        $r = table::queryParams("CALL actualizar_existencias_producto(:nom_producto,:existencias)",
            
            [
                'nom_producto' => $nom_producto,
                'existencias' => $existencias,
            ]
        
        );
        return $r;

    }


    function modificarDataProducto (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nom_producto = $dataObject->nombre;
            $descripcion = $dataObject->descripcion;
            $categoria = $dataObject->categoria;
            $precio_venta = $dataObject->precio_venta;
            $precio_compra = $dataObject->precio_compra;

            $products = $this->modificarDataProductoQuerry($nom_producto, $descripcion, $categoria, $precio_venta, $precio_compra );
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

    function modificarDataProductoQuerry($nom_producto, $descripcion, $categoria, $precio_venta, $precio_compra) {
        $r = table::queryParams("call actualizar_producto(:nom_producto, :descripcion, :categoria, :precio_venta, :precio_compra)",
            
            [
                'nom_producto' => $nom_producto,
                'descripcion' => $descripcion,
                'categoria' => $categoria,
                'precio_venta' => $precio_venta,
                'precio_compra' => $precio_compra,
            ]
        
        );
        return $r;

    }


    // AGREGAR PRODUCTO INTERNO


    function AgregarProductoInterno(){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nom_producto = $dataObject->nombre_producto;
            $descripcion = $dataObject->descripcion_producto;
            $precio_venta = $dataObject->precio_venta;
            $categoria = $dataObject->categoria_producto;
            $proveedor = $dataObject->proveedor;
            $existencias = $dataObject->cantidad_pructos;

            
            
            $products = $this->AgregarProductoInternoQuery($nom_producto, $descripcion, $precio_venta, $proveedor, $categoria, $existencias );

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
    function AgregarProductoInternoQuery($nom_producto, $descripcion, $precio_venta, $categoria, $proveedor, $existencias){
        $t = table::queryParams("CALL insertar_producto_interno(:nom_producto, :descripcion, :precio_venta, :categoria, :proveedor, :existencias)", 
            [
                'nom_producto' => $nom_producto,
                'descripcion' => $descripcion,
                'precio_venta' => $precio_venta, 
                'categoria' => $categoria,
                'proveedor' => $proveedor,
                'existencias' => $existencias,
            ]);
    
        return $t;
    }


    // MODIFICAR PRODUCTO INTERNO


    function modificarProductoInterno (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nom_producto = $dataObject->nombre_producto;
            $existencias = $dataObject->cantidad_producto;            
            
            $products = $this->modificarProductoInternoQuerry($nom_producto, $existencias );
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

    function modificarProductoInternoQuerry($nom_producto, $existencias) {
        $r = table::queryParams("CALL actualizar_existencias_producto_interno(:nom_producto,:existencias)",
            
            [
                'nom_producto' => $nom_producto,
                'existencias' => $existencias
            ]
        
        );
        return $r;

    }


    function modificarDataProductoInterno (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nom_producto = $dataObject->nombre;
            $descripcion = $dataObject->descripcion;
            $proveedor = $dataObject->proveedor;
            $categoria = $dataObject->categoria;
            $precioV = $dataObject->precioV;
            
            $products = $this->modificarDataProductoInternoQuerry($nom_producto, $descripcion, $proveedor, $categoria, $precioV );
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

    // MODIFICAR LA DATA DE UN PRODUCTO EXISTENTE

    function modificarDataProductoInternoQuerry($nom_producto, $descripcion, $proveedor, $categoria, $precioV ) {
        $r = table::queryParams("call actualizar_producto_interno(:nom_producto, :descripcion, :precioV, :proveedor, :categoria)",
            
            [
                'nom_producto' => $nom_producto,
                'descripcion' => $descripcion,
                'proveedor' => $proveedor,
                'categoria' => $categoria,
                'precioV' => $precioV,
            ]
        
        );
        return $r;

    }

    function mostrarCategorias (){
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $result = table::query("SELECT * from categorias");
    
            $r = new success($result);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }

    public function verificar_producto()
    {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);

            $nombre = $dataObject->nombre_producto;
            
            $resultado = $this->verificar_existencia($nombre);
            

            if ($resultado) {
                
                $response = array(
                    "message" => "No se encontro un producto",
                    "data" => $resultado 
                );
                $r = new Success($response);
                return $r->send();
            
            } else {
                
                $r = new Failure(401, "El priducto ya existe");
                return $r->send();
            }

        } catch (\Exception $e) {
            
            $r = new Failure(500, "Error en el servidor: " . $e->getMessage());
            return $r->Send();
        }
    }
    
    function verificar_existencia($nombre)
    {
        $resultados = Table::queryParams("SELECT nom_producto FROM productos WHERE nom_producto = :nombre", ['nombre' => $nombre]);
        
        if (count($resultados) > 0) {
            return false;    
        } else{
            return true;
        }
    }
}
