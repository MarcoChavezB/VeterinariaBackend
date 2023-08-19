<?php

namespace proyecto\Models;
use proyecto\Auth;
use PDO;

class Animales extends Models
{
    public $id;
    public $nombre = "";
    public $propietario = "";
    public $especie = "";
    public $raza = "";
    public $genero = "";

    protected $filleable = [
        "nombre",
        "propietario",
        "especie",
        "raza",
        "genero"
    ];

    protected $table = "animales";
}