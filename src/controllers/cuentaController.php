<?php
  require BASE_PATH . '/repositories/cuentaRepository.php';
  require BASE_PATH . '/models/usuarioModel.php';

  class CuentaController {
    private $cuentaRepository;

    public function __construct() {
      $this->cuentaRepository = new cuentaRepository();
    }

    public function crearUsuario($data) {
      $usuario = new Usuario();
      $usuario->usr_nombre = $data['nombre'];
      $usuario->usr_apaterno  = $data['apaterno'];
      $usuario->usr_amaterno = $data['amaterno'];
      $usuario->usr_usuario = $data['usuario'];
      $usuario->usr_psword = password_hash($data['password'], PASSWORD_BCRYPT);
      $usuario->usr_correo = $data['correo'];
      $usuario->usr_telefono = $data['telefono'];
      $usuario->usr_direccion = $data['direccion'];
      $usuario->isvendedor = $data['vendedor'];
      return $this->cuentaRepository->crearUsuario($usuario);
    }

    public function iniciarSesion($data) {
        return $this->cuentaRepository->iniciarSesion($data);        
    }
    
    public function cerrarSesion() {
      return $this->cuentaRepository->cerrarSesion();        
    }

    public function actualizarUsuario($data) {
      $usuario = new usuario();
      $usuario->prd_idusuario = $data['idusuario'];
      $usuario->prd_nombre = $data['nombre'];
      $usuario->prd_descripcion = $data['descripcion'];
      $usuario->prd_marca = $data['marca'];
      $usuario->prd_estado = $data['estado'];
      $usuario->prd_categoria = $data['categoria'];
      return $this->cuentaRepository->actualizarusuario($usuario);
    }

    public function borrarUsuario($usuarioid) {
      return $this->cuentaRepository->borrarusuario($usuarioid['id']);
    }

    public function obtenerusuarioPorId($usuarioid) {
      return $this->cuentaRepository->obtenerusuarioPorId($usuarioid['id']);
    }
  }
?>