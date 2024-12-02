<?php
  define('BASE_PATH', __DIR__);

 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once BASE_PATH . '/simpleRouter.php';
require_once BASE_PATH . '/controllers/vendedorController.php';
require_once BASE_PATH . '/controllers/usuarioController.php';
require_once BASE_PATH . '/controllers/cuentaController.php';
require_once BASE_PATH . '/middleware/authMiddleware.php';

$router = new SimpleRouter();
$VendedorController = new VendedorController();
$UsuarioController = new UsuarioController();
$CuentaController = new CuentaController();

//*******VENDEDOR CON FUNCIONES PARA PRODUCTOS**********
$router->post('/usuario/vendedor', function() use ($VendedorController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->crearProducto($data));
});

$router->put('/usuario/vendedor', function() use ($VendedorController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->actualizarProducto($data));
});

$router->delete('/usuario/vendedor', function() use ($VendedorController) {
      $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->borrarProducto($id));
});

$router->get('/usuario/vendedor', function() use ($VendedorController) {
    return json_encode($VendedorController->obtenerProductos());
});

$router->get('/usuario/vendedor/categoria', function() use ($VendedorController) {
    return json_encode($VendedorController->obtenerCategorias());
});

$router->POST('/usuario/vendedor/producto', function() use ($VendedorController) {
    $idproducto = json_decode(file_get_contents("php://input"), true);
    return json_encode($VendedorController->obtenerProductoPorId($idproducto));
});


//*******USUARIO**********
$router->get('/usuario/productos', function() use ($UsuarioController) {
    return json_encode($UsuarioController->obtenerProductos());
});

$router->post('/usuario/productos/busqueda', function() use ($UsuarioController) {
    $busqueda = json_decode(file_get_contents("php://input"), true);
    return json_encode($UsuarioController->obtenerProductosPorBusqueda($busqueda));
}); 

$router->POST('/usuario/productos/categoria', function() use ($UsuarioController) {
    $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($UsuarioController->obtenerProductosPorCategoria($id));
});

//CARRITO
$router->put('/usuario/carrito/agregar', function() use ($UsuarioController) {
    $carrito = json_decode(file_get_contents("php://input"), true);
    return json_encode($UsuarioController->agregarAlCarrito($carrito));
});

$router->delete('/usuario/carrito/quitar', function() use ($UsuarioController) {
    return json_encode($UsuarioController->quitarDelCarrito());
});

$router->POST('/usuario/carrito', function() use ($UsuarioController) {
    $usuarioid = json_decode(file_get_contents("php://input"), true);
    return json_encode($UsuarioController->obtenerCarritoPorUsuario($usuarioid));
});

$router->post('/usuario/carrito/orden', function() use ($UsuarioController) {
    return json_encode($UsuarioController->crearOrden());
});

//*******CUENTA**********

$router->post('/cuenta', function() use ($CuentaController) {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log(print_r($data, true)); 
    return json_encode($CuentaController->crearUsuario($data));
});

$router->post('/cuenta/iniciarSesion', function() use ($CuentaController) {
    $data = json_decode(file_get_contents("php://input"), true);
    error_log(print_r($data, true)); 
    return json_encode($CuentaController->iniciarSesion($data));
});

$router->post('/cuenta/cerrarSesion', function() use ($CuentaController) {
    return json_encode($CuentaController->cerrarSesion());
});

$router->put('/cuenta', function() use ($CuentaController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($CuentaController->actualizarUsuario($data));
});

$router->delete('/cuenta', function() use ($CuentaController) {
      $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($CuentaController->borrarUsuario($id));
});

$router->dispatch();
?>
