<?php

namespace proyecto\Models;

use PDO;
use proyecto\Conexion;
use Dotenv\Dotenv;

class Table
{
    public static $pdo = null;
    public function __construct()
    {

    }
    static  function getDataconexion(){
    }


    static function insertFromJson($query, $json)
    {
        try {
            $cc = new Conexion("consultasveterinaria", "127.0.0.1", "anthony", "2023-qwerty");
            self::$pdo = $cc->getPDO();
    
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(1, $json, PDO::PARAM_STR);
    
            $result = $stmt->execute();
            return $result;
        } catch (\PDOException $e) {
            error_log("Error al insertar datos desde JSON: " . $e->getMessage());
            return false;
        }
    }
    

    static function query($query)
    {
        $cc = new  Conexion("consultasveterinaria","127.0.0.1", "anthony", "2023-qwerty");
        self::$pdo = $cc->getPDO();
        $stmt = self::$pdo->query($query);
        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }

    static function queryParams($query, $params = [])
    {
        $cc = new Conexion("consultasveterinaria", "127.0.0.1", "anthony", "2023-qwerty");
        self::$pdo = $cc->getPDO();

        $stmt = self::$pdo->prepare($query);

        $stmt->execute($params);

        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $resultados;
    }

}
