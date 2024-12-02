<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/cuentainterface.php';

    class cuentaRepository implements ICuenta
    {
        private $conn;

        public function __construct()
        {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function crearUsuario($usuario) {
            $sql = "INSERT INTO usuarios (usr_nombre, usr_apaterno, usr_amaterno, usr_usuario, usr_psword, usr_correo, usr_telefono, usr_direccion)
                    VALUES (:nombre, :apaterno, :amaterno, :usuario, :password, :correo, :telefono, :direccion)";
            
            $resultado = $this->conn->prepare($sql);
            $resultado->bindParam(':nombre', $usuario->usr_nombre);
            $resultado->bindParam(':apaterno', $usuario->usr_apaterno);
            $resultado->bindParam(':amaterno', $usuario->usr_amaterno);
            $resultado->bindParam(':usuario', $usuario->usr_usuario);
            $resultado->bindParam(':password', $usuario->usr_psword);
            $resultado->bindParam(':correo', $usuario->usr_correo);
            $resultado->bindParam(':telefono', $usuario->usr_telefono);
            $resultado->bindParam(':direccion', $usuario->usr_direccion);
        
            if ($resultado->execute()) {
                $usuarioid = $this->conn->lastInsertId();
        
                if ($usuario->isvendedor) {
                    $sqlVendedor = "INSERT INTO vendedor (usr_fk_usuario, usr_ranking, usr_NumVentas) VALUES (:usuarioid, 0, 0)";
                    $prepVendedor = $this->conn->prepare($sqlVendedor);
                    $prepVendedor->bindParam(':usuarioid', $usuarioid);
        
                    if ($prepVendedor->execute()) {
                        $response['status'] = 'success';
                        $response['message'] = '¡Bienvenido! Su cuenta se ha creado correctamente, y se ha registrado como vendedor. Inicie sesión.';
                        $response['redirect'] = './login.html';
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = 'Ocurrió un error al registrar el vendedor.';
                        $response['redirect'] = '../index.html';
                    }
                } else {
                    $response['status'] = 'success';
                    $response['message'] = '¡Bienvenido! Su cuenta se ha creado correctamente. Inicie sesión.';
                    $response['redirect'] = './login.html';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Ocurrió un error al registrar al usuario.';
                $response['redirect'] = '../index.html';
            }
            
            return $response;
        }
        
    public function iniciarSesion($data) {
        
        $usuario = $data['usuario'];
        $password = $data['password'];

        $sql = 'SELECT * FROM usuarios WHERE usr_usuario = :usr_usuario';
        $prep = $this->conn->prepare($sql);
        $prep->bindParam(':usr_usuario', $usuario);
        $prep->execute();
        $resultado = $prep->fetch();
        $response = [];
        
        if (!empty($resultado)) {

            $usuarioid = $resultado['usr_id'];
            $usr_usuario = $resultado['usr_usuario'];
            $usr_psword = $resultado['usr_psword'];
            $usr_nombre = $resultado['usr_nombre'];
            $usr_apaterno = $resultado['usr_apaterno'];
            $usr_amaterno = $resultado['usr_amaterno'];
            $usr_correo = $resultado['usr_correo'];
            
            if (password_verify($password, $usr_psword)) {
        
                session_start();

                $response['status'] = 'success';
                $response['message'] = '¡Bienvenido! Has iniciado sesión correctamente.';
                $response['redirect'] = '../index.html';
                $response['usuarioid'] = $usuarioid;
                $response['usuario'] = $usr_usuario;
                $response['nombre'] = $usr_nombre . " " . $usr_apaterno . " " . $usr_amaterno;
                $response['correo'] = $usr_correo;

                $sql = 'SELECT * FROM vendedor WHERE usr_fk_usuario = :usr_usuario';
                $prep = $this->conn->prepare($sql);
                $prep->bindParam(':usr_usuario', $usuarioid);
                $prep->execute();
                $resultado = $prep->fetch();
                
                if (!empty($resultado)) {
                    $response['vendedor'] = TRUE;
                }

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Contraseña incorrecta';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Usuario no encontrado';
        }

        echo json_encode($response);
        exit;
        return $response;
    }

    public function cerrarSesion() {

        session_unset();
        session_destroy(); 
    
        $response = [
            'status' => 'success',
            'message' => '¡Has cerrado sesión correctamente!',
            'redirect' => './index.html'
        ];
    
        echo json_encode($response);
        exit;
        return $response; 
    }

    public function actualizarUsuario($usuario)
    {
        $sql_usuario = "SELECT * FROM usuarios WHERE usr_usuario = :usuario";
        $stmt_usuario = $this->conn->prepare($sql_usuario);
        $stmt_usuario->bindParam(':usuario', $usuario->usuario);
        $stmt_usuario->execute();
        $result_usuario = $stmt_usuario->fetchAll();
    
        if (count($result_usuario) > 0) {
            return ['mensaje' => 'Error: El usuario ya existe.'];
        }
        
        $sql = "UPDATE usuarios 
                SET usr_nombre = :nombre, 
                    usr_apaterno = :apaterno, 
                    usr_amaterno = :amaterno, 
                    usr_usuario = :usuario, 
                    usr_psword = :password, 
                    usr_correo = :correo, 
                    usr_telefono = :telefono, 
                    usr_direccion = :direccion
                WHERE idusuario = :idusuario";
    
        $resultado = $this->conn->prepare($sql);
    
        $resultado->bindParam(':idusuario', $usuario->idusuario);
        $resultado->bindParam(':nombre', $usuario->nombre);
        $resultado->bindParam(':apaterno', $usuario->apaterno);
        $resultado->bindParam(':amaterno', $usuario->amaterno);
        $resultado->bindParam(':usuario', $usuario->usuario);
        $resultado->bindParam(':password', $usuario->password);
        $resultado->bindParam(':correo', $usuario->correo);
        $resultado->bindParam(':telefono', $usuario->telefono);
        $resultado->bindParam(':direccion', $usuario->direccion);
    
        if ($resultado->execute()) {
            return ['mensaje' => 'Usuario actualizado con éxito'];
        } else {
            return ['mensaje' => 'Error al actualizar el usuario.'];
        }
    }
    
    public function borrarusuario($idusuario)
    {
        $sql = "DELETE FROM usuarios WHERE usuarioid = :idusuario";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idusuario',$idusuario);
       
        if($resultado->execute()){
            return ['mensaje' => 'usuario Borrado'];
        } else{
            return ['mensaje' => 'Error al borrar el usuario.'];
        }
    }

    public function obtenerusuarioPorId($id)
    {
        $sql = "SELECT * FROM usuarios WHERE usuarioid = :id";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':id',$id);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }
}

?>