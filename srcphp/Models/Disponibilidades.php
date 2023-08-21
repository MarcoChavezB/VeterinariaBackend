<?php
namespace proyecto\Models;
use proyecto\Auth;
use proyecto\Models\Models;
use PDO;


class Disponibilidades extends Models{

    public $fecha = "";
    public $hora_inicio = "";
    public $hora_fin = "";
    public $id_empleado = "";

    protected $filleable = [
        "fecha", "hora_inicio", "hora_fin", "id_empleado"
    ];

    protected $table = "disponibilidades";

}
