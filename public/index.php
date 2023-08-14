<?php
namespace proyecto;
require("../vendor/autoload.php");

use proyecto\Controller\LoginController;
use proyecto\Controller\RegistroController;
use proyecto\Controller\MostrarProductosController;
use proyecto\Controller\ClientesController;
use proyecto\Controller\ProveedorController;
use proyecto\Response\Success;
use proyecto\Controller\EmpleadosController;
use proyecto\Controller\VentasController;
use proyecto\Controller\Ordenes_comprasController;
use proyecto\Controller\citasController;
use proyecto\Controller\ProductoController;
use proyecto\Controller\GenerarConsultasController;
use proyecto\Controller\MascotasController;
use proyecto\Controller\ReportesController;
use proyecto\Controller\HistorialMedicoController;
use proyecto\Controller\TiposServiciosController;
use proyecto\Controller\RegisterController;

Router::headers();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// funcion de prueba
Router::get("/pru", function(){
    $r = new Success("funcionando");
    $r->Send();
});


Router::post('/auth', [RegisterController::class, 'auth']);
Router::post('/signin',[RegisterController::class, 'signin']);

Router::post('/HistorialMedicoIDFecha',[HistorialMedicoController::class, 'HistorialMedicoIDFecha']);
Router::post('/HistorialIDMascota',[HistorialMedicoController::class, 'HistorialIDMascota']);

Router::post('/ReporteConsultas', [ReportesController::class, 'ReporteConsultas']);

Router::post('/historialMedico', [ReportesController::class, 'historialMedico']);
Router::post('/historialMedicoCliente',[ReportesController::class, 'historialMedicoCliente']);

Router::post('/ReporteConsultasFecha',[ReportesController::class, 'ReporteConsultasFecha']);
Router::post('/ReporteConsultasCliente',[ReportesController::class, 'ReporteConsultasCliente']);

Router::post('/ReporteGralCitasRechazadas',[ReportesController::class, 'ReporteGralCitasRechazadas']);
Router::post('/ReporteCitasRechazadasCliente',[ReportesController::class, 'ReporteCitasRechazadasCliente']);
Router::post('/ReporteCitasRechazadasFecha',[ReportesController::class, 'ReporteCitasRechazadasFecha']);

Router::post('/ReporteGeneralOrdenesCompra',[ReportesController::class, 'ReporteGeneralOrdenesCompra']);
Router::post('/ReporteGeneralOrdenesCompraPagadas',[ReportesController::class, 'ReporteGeneralOrdenesCompraPagadas']);

Router::post('/ReporteGralVentas',[ReportesController::class, 'ReporteGralVentas']);
Router::post('/ReporteFechaVentas',[ReportesController::class, 'ReporteFechaVentas']);

Router::post('/registrarProveedor',[ProveedorController::class, 'registrarProveedor']);

Router::post('/TablaProveedor',[ProveedorController::class, 'TablaProveedor']);


Router::post('/registrarMascota', [MascotasController::class, 'registrarMascota']);

// Ruta de registro de clientes [Pantalla Registro]
Router::post('/registro', [RegistroController::class, 'registrar']);

Router::post('/registro', [EmpleadosController::class, 'registrar']);

// Consulta para mostrar todos los registros
Router::get('/mostrarR', [RegistroController::class, 'mostrarR']);

// Verificiacion de usuario en login BD -> login
Router::post('/verificacion', [LoginController::class, 'verificar']);

// Mandar Productos
Router::get('/productos', [MostrarProductosController::class, 'mostrarP']);

// mostrar todos prductos de la vista
Router::get('/productos/all', [MostrarProductosController::class, 'TablaProductos']);

// Mandar Productos internos
Router::get('/productosInternos', [MostrarProductosController::class, 'mostrarProductsInter']);

Router::get('/bajaProductos', [MostrarProductosController::class, 'mostrarProductosBajaExistencia']);

// Mandar Rango de precios de productos Internos
Router::post('/precios', [MostrarProductosController::class, 'rangoPrecios']);

// para actualizar un cliente
Router::post('/clientes/actualizar', [ClientesController::class, 'actualizarCliente']);

// Para buscar cliente x correo
Router::post('/clientes/infoCorreo', [ClientesController::class, 'buscarPorCorreo']);

// obtener el id del cliente
Router::post('/clientes/info', [ClientesController::class, 'consultarIDcliente']);

// obtener toda info cliente x id
Router::post('/clientes/infoID', [ClientesController::class, 'obtenerClientePorID']);

// mostrar todos los registros de clientes
Router::get('/clientes/All', [ClientesController::class, 'TablaClientes']);

// obtener nombres e id de los proveedores
Router::get('/Proveedores/NombreID', [ProveedorController::class, 'NombreIDProveedor']);

// Realizar detalles de compras x id y json
Router::post('/orden/Detalles', [Ordenes_comprasController::class, 'agregarDetalleCompras']);

// Crear un nuevo servicio
Router::post('/crear-servicio', [TiposServiciosController::class, 'crearServicio']);

// Mover un servicio a borrador
Router::post('/mover-servicio-a-borrador', [TiposServiciosController::class, 'moverServicioABorrador']);

// Mover un servicio a publico
Router::post('/mover-servicio-a-publico', [TiposServiciosController::class, 'moverServicioAPublico']);

// filtro de busqueda de tipos de servicios borrador x id_servicio
Router::post('/obtenerTiposServiciosBorradorPorIdServicio', [TiposServiciosController::class, 'obtenerTiposServiciosBorradorPorIdServicio']);

// filtro de busqueda de tipos de servicios x id_servicio
Router::post('/obtenerTiposServiciosPublicosPorIdServicio', [TiposServiciosController::class, 'obtenerTiposServiciosPublicosPorIdServicio']);

// obtener todos los tipos servicios borrador
Router::get('/obtenerTodosTiposServiciosBorradorView', [TiposServiciosController::class, 'obtenerTodosTiposServiciosBorradorView']);

// obtener todos los tipos servicios
Router::get('/obtenerTodosTiposServiciosView', [TiposServiciosController::class, 'obtenerTodosTiposServiciosView']);


// funcion de prueba
Router::get("/pru", function(){
    $r = new Success("funcionando");
    $r->Send();
});
// Mandar Productos Publicos
Router::get('/productosPublicos', [MostrarProductosController::class, 'mostrarProductsPublic']);

// Mandar Rango de precios de productos Publicos
Router::post('/preciosPublicos', [MostrarProductosController::class,'rangoPreciosPublics']);

// datos para la grafica
Router::post('/data', [VentasController::class, 'fecha']);

// busqueda de productos
Router::post('/buscar', [MostrarProductosController::class, 'buscarProducto']);

Router::post('/buscarlimit', [MostrarProductosController::class, 'buscarProductolimite']);

// busqueda de productos internos
Router::post('/buscarInterno', [MostrarProductosController::class, 'buscarProductoInterno']);

// Realizar compra 
Router::post('/orden/compra', [Ordenes_comprasController::class, 'CrearOrdenCompra']);

// obtener todos las ordenes de compras pendientes
Router::get('/orden/pendientes', [Ordenes_comprasController::class, 'TablaOrdenesCompras']);

// buscar por rango/o No, de fecha de de compra o pago 
Router::post('/orden/porfecha', [Ordenes_comprasController::class, 'buscarOrdenesPorFecha']);

Router::post('/orden/porestado', [Ordenes_comprasController::class, 'buscarOrdenesPorEstado']);

// Mostrar ventas recientes 
Router::get('/ventasRecientes', [VentasController::class, 'mostrarVentasRecientes']);

// generar cita local, inserccion de cliente, animal y cita
Router::post('/citalocal', [citasController::class, 'CrearRegistroVeterinario']);


// Citas pendientes
Router::get('/citasPendientes', [citasController::class, 'mostrarCitasPendientes']);

Router::post('/agendarcita', [citasController::class, 'agendarcita']);
Router::post('/MascotasUsuario', [citasController::class, 'MascotasUsuario']);
Router::post('/ServiciosClinicos', [citasController::class, 'ServiciosClinicos']);
Router::post('/ServiciosEsteticos', [citasController::class, 'ServiciosEsteticos']);
Router::post('/CitasPendientesCliente', [citasController::class, 'CitasPendientesCliente']);
Router::post('/ValidacionFechas', [citasController::class, 'ValidacionFechas']);
Router::post('/NotiCorreo', [citasController::class, 'NotiCorreo']);


// AGREGAR PRODUCTO 
Router::post('/agregarProducto', [ProductoController::class, 'AgregarProductoPublico']);

// ALTER PRODUCTO
Router::post('/alterProduct', [ProductoController::class, 'modificarProducto']);

// ALTER DATA PRODUCT
Router::post('/dataProd', [ProductoController::class, 'modificarDataProducto']);

// AGREGAR PRODUCTO INTERNO
Router::post('/dataProdInterno', [ProductoController::class, 'AgregarProductoInterno']);

// MODIFICAR PRODUCTO INTERNO
Router::post('/alterProdInterno', [ProductoController::class, 'modificarProductoInterno']);

// MODIFICAR PRODUCTO EXISTENTE
Router::post('/alterProdInternoExistente', [ProductoController::class, 'modificarDataProductoInterno']);

// mostrar proveedore 
Router::get('/proveedores', [ProveedorController::class, 'proveedores']);

// mostrar categorias 
Router::get('/categorias', [ProductoController::class, 'mostrarCategorias']);

Router::post('/GenerarConsultas',[GenerarConsultasController::class, 'GenerarConsultas']);
Router::post('/GenerarConsultasCliente',[GenerarConsultasController::class, 'GenerarConsultasCliente']);
Router::post('/GenerarConsultasFecha',[GenerarConsultasController::class, 'GenerarConsultasFecha']);
Router::post('/BuscarMedicamentos',[GenerarConsultasController::class, 'BuscarMedicamentos']);
Router::post('/RegistroConsulta',[GenerarConsultasController::class, 'RegistroConsulta']);
Router::post('/TServicios',[GenerarConsultasController::class, 'TServicios']);
Router::post('/CostosAfter',[GenerarConsultasController::class, 'CostosAfter']);


Router::get('/total_citas', [MostrarProductosController::class, 'cantidad_citas']);
Router::get('/total_ventas', [MostrarProductosController::class, 'cantidad_ventas']);

Router::get('/citas_total', [citasController::class, 'citasTot']);
Router::get('/citas_aceptadas', [citasController::class, 'citasAceptadas']);

Router::post('/citas_id', [citasController::class, 'cita_id']);
Router::post('/citasResponse', [citasController::class, 'rechazar_aceptar_cita']);











// Router::get('/', function() {
//     // código para generar y enviar la página HTML de inicio
//     echo '
//         <!DOCTYPE html>
//         <html lang="en">
//         <head>
//             <meta charset="UTF-8">
//             <meta name="viewport" content="width=device-width, initial-scale=1.0">
//             <title>Backend</title>
//         </head>
//         <body>
//             <div class="ctn">
//                 <div class="title">
//                     <h1>Backend.</h1><br>
//                 </div>
//             </div>

//             <style>
//                 body{
//                     margin: 0;
//                     padding: 0;
//                 }
//                 .ctn{
//                     background-color: #f3b606;
//                     width: 100%;
//                     height: 100vh;
//                     display: flex;
//                     justify-content: center;
//                     align-items: center;
//                 }

//                 .title{
//                     font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif;
//                     font-size: 2em;
//                 }

//             </style>
//         </body>
//         </html>
//     ';
// });

// 
