<?php
namespace proyecto\Models;
use PDO;

class Empleados extends Models{

    public $nombre = "";
    public $apellido = "";
    public $correo = "";
    public $contrasena = "";

    protected $filleable = [
        "nombre","apellido","correo","contrasena"
    ];

    protected $table = "empleados";

}