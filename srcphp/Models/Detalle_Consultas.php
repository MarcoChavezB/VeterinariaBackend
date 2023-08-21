<?php

namespace proyecto\Models;
use PDO;

class Detalle_Consultas extends Models
{
    public $consulta_id = "";
    public $tservicios_id = "";

    

    protected $filleable = [
        "id_consulta",
        "id_tservicios",


    ];

    protected $table = "detalle_consultas";
}