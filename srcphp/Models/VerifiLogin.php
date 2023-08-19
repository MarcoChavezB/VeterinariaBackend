<?php

namespace proyecto\Models;
use proyecto\Models\Models;
use proyecto\Response\Success;
use PDO;
use proyecto\Response\Failure;


class VerifiLogin extends Models{

    function cosulta($nombre, $contrasena){
        $stmt = self::$pdo->prepare("select clientes.nombre, clientes.contrasena
                                    from clientes
                                    where clientes.nombre = :nombre and clientes.contrasena = :contrasena");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":contrasena", $contrasena);
        $stmt->execute();

        // resultados como objetos

        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);

        // verificacion de resultados
        if ($resultados){
            $r = new Success($resultados);
            return $r->Send();
        }
        else {
            $r = new Failure(404, "El cliente no existe");
            return $r->send();
        }

    }
}

