<?php
namespace proyecto\Models;
use proyecto\Auth;
use proyecto\Models\Models;
use PDO;

class DetallesVenta extends Models{

    public $id_venta = "";
    public $id_producto = "";
    public $cantidad = "";
    public $precio_unitario = "";
    public $subtotal = "";

    protected $filleable = [
       "id_venta","id_producto","cantidad","precio_unitario","subtotal"
    ];

    protected $table = "detalles_venta";

}
