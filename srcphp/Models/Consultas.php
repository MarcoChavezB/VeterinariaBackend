<?php

namespace proyecto\Models;
use PDO;

class Consultas extends Models
{
    public $id;
    public $id_cita = "";
    public $observaciones = "";
    public $peso_kg = "";
    public $altura_mts = "";
    public $edad_meses = "";
    
    

   
    protected $filleable = [
        "id",
        "id_cita",
        "observaciones",
        "peso_kg",
        "altura_mts",
        "edad_meses",
    ];

    protected $table = "consultas";
}
