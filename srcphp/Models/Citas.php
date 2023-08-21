<?php

namespace proyecto\Models;
use proyecto\Auth;
use PDO;

class Citas extends Models
{
    public $id;
    public $user_regis = "";
    public $fecha_registro = "";
    public $fecha_cita = "";
    public $id_mascota = "";
    public $estatus = "";
    public $motivo = "";

    protected $filleable = [

        "id",
        "user_regis",
        "fecha_registro",
        "fecha_cita",
        "id_mascota",
        "estatus",
        "motivo",
    ];

    protected $table = "citas";
}