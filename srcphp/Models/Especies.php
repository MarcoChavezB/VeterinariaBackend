<?php
namespace proyecto\Models;
use PDO;

class Especies extends Models{

    public $especie = "";

    protected $filleable = [
        "especie"
    ];

    protected $table = "especies";

}