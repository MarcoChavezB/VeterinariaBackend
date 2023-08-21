<?php

namespace proyecto\Controller;
use proyecto\Models\Usuarios;
use proyecto\Response\Failure;
use proyecto\Response\Success;
use proyecto\Models\Table;
use proyecto\Conexion;
use proyecto\Models\Models;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientesController{
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion('consultasveterinaria', 'localhost', 'root', '');
    }

    // Método para actualizar un cliente
    function actualizarUsuario()
{
    try {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);

        // Checking if id is provided
        if (!property_exists($dataObject, 'id')) {
            throw new \Exception("Debe proporcionar el ID del cliente para actualizar");
        }

        $id = $dataObject->id;

        $sql = "UPDATE usuarios SET ";
        $values = [];
        
        if (property_exists($dataObject, 'nombre')) {
            $sql .= "nombre = :nombre, ";
            $values[':nombre'] = $dataObject->nombre;
        }
        if (property_exists($dataObject, 'apellido')) {
            $sql .= "apellido = :apellido, ";
            $values[':apellido'] = $dataObject->apellido;
        }
        if (property_exists($dataObject, 'correo')) {
            $sql .= "correo = :correo, ";
            $values[':correo'] = $dataObject->correo;
        }
        if (property_exists($dataObject, 'telefono1')) {
            $sql .= "telefono1 = :telefono1, ";
            $values[':telefono1'] = $dataObject->telefono1;
        }
        if (property_exists($dataObject, 'telefono2')) {
            $sql .= "telefono2 = :telefono2, ";
            $values[':telefono2'] = $dataObject->telefono2;
        }
        if (property_exists($dataObject, 'contra')) {
            $sql .= "contra = :contra, ";
            $values[':contra'] = $dataObject->contra;
        }

        // Remove trailing comma and add WHERE clause
        $sql = rtrim($sql, ', ') . " WHERE id = :id";
        $values[':id'] = $id;

        $stmt = $this->conexion->getPDO()->prepare($sql);
        $stmt->execute($values);

        $rowsAffected = $stmt->rowCount();

        if ($rowsAffected === 0) {
            throw new \Exception("No se encontró el cliente con el ID proporcionado");
        }

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Cliente actualizado exitosamente.']);
        http_response_code(200);

    } catch (\Exception $e) {
        $errorResponse = ['message' => "Error en el servidor: " . $e->getMessage()];
        header('Content-Type: application/json');
        echo json_encode($errorResponse);
        http_response_code(500);
    }
}

    // buscar cliente por correo, por cualquier letra que coincida en el correo
      function buscarPorCorreo() {
        $JSONData = file_get_contents("php://input");
        $dataObject = json_decode($JSONData);
    
        if(isset($dataObject->cadena)) {
            $resultados = Table::queryParams("CALL BuscarPorCampos(:cadena)", ['cadena' => $dataObject->cadena]);
        } else {
            throw new \Exception("Debe proporcionar un correo para buscar.");
        }
    
        $r = new Success($resultados);
        return $r->Send();
    }


    // select all de clientes

    function TablaClientes () {
        try{
            $resultados = Table::query("SELECT * FROM clientes;");
    
            $r = new Success($resultados);
            return $r->Send();
        } catch (\Exception $e) {
            $r = new Failure(401, $e->getMessage());
            return $r->Send();
        }
    }    


    // obtener info del cliente x id
    
    function obtenerClientePorID() {
        try {
            $JSONData = file_get_contents("php://input");
            $dataObject = json_decode($JSONData);
    
            $resultados = Table::queryParams("CALL GetClientePorId(:idd)", ['idd' => $dataObject->id]);
    
            if($resultados) {
                $r = new Success($resultados[0]);
                return $r->send();
            } else {
                $r = new Failure(404, "No se encontró un cliente con el ID proporcionado.");
                return $r->send();
            }
        } catch (\Exception $e) {
            $r = new Failure(500, $e->getMessage());
            return $r->send();
        }
    }    
    
}
