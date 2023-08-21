<?php

namespace proyecto\Models;
use proyecto\Auth;
use proyecto\Response\Failure;
use proyecto\Response\Response;
use proyecto\Response\Success;
use function json_encode;
use PDO;

class Usuarios extends Models{


public $nombre = "";
public $apellido = "";
public $correo = "";
public $telefono1 = "";
public $telefono2 = "";
public $contra = "";

public $tipo_usuario = "";

public $id = "";

protected $filleable = [

"nombre",
"apellido",
"correo",
"telefono1",
"telefono2",
"contra",
"tipo_usuario"

];

protected $table = "usuarios";

    public static function auth($correo, $contra):Response
    {
        $class = get_called_class();
        $c = new $class();
        $stmt = self::$pdo->prepare("select *  from $c->table  where  correo =:correo  and contra=:contra");
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":contra", $contra);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_CLASS,Usuarios::class);

        if ($resultados) {
//            Auth::setUser($resultados[0]);  pendiente
            $r=new Success(["usuario"=>$resultados[0],"_token"=>Auth::generateToken([$resultados[0]->id])]);
            return  $r->Send();
        }
        $r=new Failure(401,"Correo o contraseña incorrectos");
        return $r->Send();

    }
};


