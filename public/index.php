<?php
namespace proyecto;
require("../vendor/autoload.php");
use PDO;
use proyecto\Controller\LoginController;
use proyecto\Controller\RegistroController;
use proyecto\Controller\MostrarProductosController;
use proyecto\Controller\ClientesController;
use proyecto\Controller\ProveedorController;
use proyecto\Response\Success;
use proyecto\Controller\EmpleadosController;
use proyecto\Controller\VentasController;
use proyecto\Controller\Ordenes_comprasController;
use proyecto\Controller\CitasController;
use proyecto\Controller\ProductoController;
use proyecto\Controller\GenerarConsultasController;
use proyecto\Controller\MascotasController;
use proyecto\Controller\ReportesController;
use proyecto\Controller\HistorialMedicoController;
use proyecto\Controller\TiposServiciosController;
use proyecto\Controller\RegisterController;
use proyecto\Models\TiposServicio;
use proyecto\Models\Models;


Router::headers();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// funcion de prueba


Router::get('/prueba',function(){
    try{
        $db =(array) TiposServicio::all()[0];

        $response = new Success($db);
        $response->send();
        echo "Conexion exitosa";
    }catch(\Exception $e){
        echo $e->getMessage();
    }
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

// verificacion de correo
Router::post('/verificarCorreoR', [RegistroController::class, 'verificarCorreo']);

// Ruta de registro de clientes [Pantalla Registro]
Router::post('/registro', [RegistroController::class, 'registrar']);

// Router::post('/registro', [EmpleadosController::class, 'registrar']);

// Consulta para mostrar todos los registros
Router::get('/mostrarR', [RegistroController::class, 'mostrarR']); // funciona

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
Router::post('/clientes/actualizar', [ClientesController::class, 'actualizarUsuario']);

// Para buscar cliente x correo
Router::post('/clientes/infoCorreo', [ClientesController::class, 'buscarPorCorreo']);

// obtener toda info cliente x id
Router::post('/clientes/infoID', [ClientesController::class, 'obtenerClientePorID']);

// mostrar todos los registros de clientes
Router::get('/clientes/All', [ClientesController::class, 'TablaClientes']);

// Realizar detalles de compras x id y json
Router::post('/orden/Detalles', [Ordenes_comprasController::class, 'agregarDetalleCompras']);

// Crear un nuevo servicio
Router::post('/crear-servicio', [TiposServiciosController::class, 'crearServicio']);

Router::post('/publicarono', [TiposServiciosController::class, 'publicarono']);

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
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=consultasveterinaria', "anthony", "2023-qwerty");
        echo "Conexión exitosa!";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
});
Router::get('/productosPublicos', [MostrarProductosController::class, 'mostrarProductsPublic']);
Router::post('/preciosPublicos', [MostrarProductosController::class,'rangoPreciosPublics']);
Router::post('/data', [VentasController::class, 'fecha']);
Router::post('/buscar', [MostrarProductosController::class, 'buscarProducto']);
Router::post('/buscarInterno', [MostrarProductosController::class, 'buscarProductoInterno']);
Router::post('/buscarlimit', [MostrarProductosController::class, 'buscarProductolimite']);
Router::post('/buscarID', [MostrarProductosController::class, 'buscarProductoID']);
Router::post('/orden/compra', [Ordenes_comprasController::class, 'CrearOrdenCompra']);
Router::get('/orden/pendientes', [Ordenes_comprasController::class, 'TablaOrdenesCompras']);
Router::post('/orden/porfecha', [Ordenes_comprasController::class, 'buscarOrdenesPorFecha']);
Router::post('/orden/porestado', [Ordenes_comprasController::class, 'buscarOrdenesPorEstado']);
Router::get('/ventasRecientes', [VentasController::class, 'mostrarVentasRecientes']);
Router::post('/citalocal', [CitasController::class, 'CrearRegistroVeterinario']);
Router::get('/citasPendientes', [CitasController::class, 'mostrarCitasPendientes']);
Router::post('/agendarcita', [CitasController::class, 'agendarcita']);
Router::post('/MascotasUsuario', [CitasController::class, 'MascotasUsuario']);
Router::post('/ServiciosClinicos', [CitasController::class, 'ServiciosClinicos']);
Router::post('/ServiciosEsteticos', [CitasController::class, 'ServiciosEsteticos']);
Router::post('/CitasPendientesCliente', [CitasController::class, 'CitasPendientesCliente']);
Router::post('/ValidacionFechas', [CitasController::class, 'ValidacionFechas']);
Router::post('/NotiCorreo', [CitasController::class, 'NotiCorreo']);
Router::post('/agregarservicioproduct', [TiposServiciosController::class, 'CrearTipoServicioYProductos']);
Router::get('/serviciospublicos', [TiposServiciosController::class, 'serviciospublicos']);
Router::get('/serviciosprivados', [TiposServiciosController::class, 'serviciosprivados']);
Router::get('/serviciospublicosesteticos', [TiposServiciosController::class, 'serviciospublicosesteticos']);
Router::get('/serviciospublicosclinicos', [TiposServiciosController::class, 'serviciospublicosclinicos']);
Router::get('/serviciosprivadossesteticos', [TiposServiciosController::class, 'serviciosprivadossesteticos']);
Router::get('/serviciosprivadosclinicos', [TiposServiciosController::class, 'serviciosprivadosclinicos']);
Router::post('/agregarProducto', [ProductoController::class, 'AgregarProductoPublico']);
Router::post('/alterProduct', [ProductoController::class, 'modificarProducto']);
Router::post('/dataProd', [ProductoController::class, 'modificarDataProducto']);
Router::post('/dataProdInterno', [ProductoController::class, 'AgregarProductoInterno']);
Router::post('/alterProdInterno', [ProductoController::class, 'modificarProductoInterno']);
Router::post('/alterProdInternoExistente', [ProductoController::class, 'modificarDataProductoInterno']);
Router::get('/proveedores', [ProveedorController::class, 'proveedores']);
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
Router::get('/monto_total', [MostrarProductosController::class, 'montoTotal']);
Router::post('/productoxcadena', [MostrarProductosController::class, 'productoporcadena']);
Router::post('/productopublicoporcadena', [MostrarProductosController::class, 'productopublicoporcadena']);
Router::get('/citas_total', [CitasController::class, 'citasTot']);
Router::get('/citas_aceptadas', [CitasController::class, 'citasAceptadas']);
Router::post('/citas_id', [CitasController::class, 'cita_id']);
Router::post('/citasResponse', [CitasController::class, 'rechazar_aceptar_cita']);
Router::post('/citasAceptadasResponse', [CitasController::class, 'rechazar_completar_cita']);
Router::get('/verificacion', [LoginController::class, 'verificacion']);
Router::post('/venta', [VentasController::class, 'venta']);
Router::get('/GenerarTiket', [VentasController::class, 'tiket']);

