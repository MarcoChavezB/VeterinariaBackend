<?php
namespace proyecto\Models;
use proyecto\Auth;
use proyecto\Models\Models;
use PDO;


class TiposServicio extends Models{

    public $id = "";
    public $nombre_Tservicio = "";
    public $id_servicio = "";
    public $descripcion = "";
    public $precio = "";
    public $estado = "";

    protected $filleable = [
        "id", "nombre_TServicio", "id_servicio", "descripcion", "precio", "estado"
    ];
    protected $table = "tipos_servicios";
}
