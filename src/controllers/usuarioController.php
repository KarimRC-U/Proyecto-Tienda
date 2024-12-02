<?php
  require_once BASE_PATH . '/repositories/usuarioRepository.php';
  require_once BASE_PATH . '/models/productoModel.php';
  require_once BASE_PATH . '/models/carritoModel.php';

  class UsuarioController {
    private $usuarioRepository;

    public function __construct() {
      $this->usuarioRepository = new usuarioRepository();
    }

    public function obtenerProductos() {
      return $this->usuarioRepository->obtenerProductos();
    }

    public function obtenerProductosPorBusqueda($busqueda) {
      return $this->usuarioRepository->obtenerProductosPorBusqueda($busqueda['busqueda']);
    }

    public function obtenerProductosPorCategoria($id) {
      return $this->usuarioRepository->obtenerProductosPorCategoria($id['id']);
    }

    public function agregarAlCarrito($carrito){
           $carritos = new Carrito();
           $carritos->car_fk_usuario = $carrito['usuarioid'];
           $carritos->car_fk_producto = $carrito['idproducto'];
           return $this->usuarioRepository->agregarAlCarrito($carritos);
    }
    
    public function quitarDelCarrito($idproducto, $usuarioid){
      return $this->usuarioRepository->quitarDelCarrito($idproducto, $usuarioid);
    }

    public function obtenerCarritoPorUsuario($usuarioid){
      return $this->usuarioRepository->obtenerCarritoPorUsuario($usuarioid["usuarioid"]);
    }

    public function crearOrden($usuarioid, $vendedorId){
      return $this->usuarioRepository->crearOrden($usuarioid, $vendedorId);
    }

  }
?>