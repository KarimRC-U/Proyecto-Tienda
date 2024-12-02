<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/usuariointerface.php';

class usuarioRepository implements IUsuario
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function obtenerProductos()
    {
        $sql = "SELECT * FROM productos";
        $resultado = $this->conn->prepare($sql);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorBusqueda($busqueda)
    {
        $sql = "SELECT * FROM productos WHERE prd_nombre LIKE :busqueda";
        $resultado = $this->conn->prepare($sql);
        $busqueda = "%" . $busqueda . "%";
        $resultado->bindParam(':busqueda', $busqueda);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosPorCategoria($categoria)
    {
        $sql = "SELECT * FROM productos WHERE prd_categoria = :categoria";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':categoria', $categoria);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

     public function agregarAlCarrito($carrito)
    {
        try {

            $usuarioid = $carrito->car_fk_usuario;
            $idproducto = $carrito->car_fk_producto;
            $cantidad = 1;

            $sqlCheck = "SELECT cantidad FROM carrito WHERE car_fk_usuario = :car_fk_usuario AND car_fk_producto = :car_fk_producto";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':car_fk_usuario', $usuarioid);
            $stmtCheck->bindParam(':car_fk_producto', $idproducto);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $sqlUpdate = "UPDATE carrito SET cantidad = cantidad + :cantidad WHERE car_fk_usuario = :car_fk_usuario AND idproducto = :car_fk_producto";
                $stmtUpdate = $this->conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':cantidad', $cantidad);
                $stmtUpdate->bindParam(':car_fk_usuario', $usuarioid);
                $stmtUpdate->bindParam(':car_fk_producto', $idproducto);
                $stmtUpdate->execute();
            } else {
                $sqlInsert = "INSERT INTO carrito (car_fk_usuario, car_fk_producto, cantidad) VALUES (:car_fk_usuario, :car_fk_producto, :cantidad)";
                $stmtInsert = $this->conn->prepare($sqlInsert);
                $stmtInsert->bindParam(':car_fk_usuario', $usuarioid);
                $stmtInsert->bindParam(':car_fk_producto', $idproducto);
                $stmtInsert->bindParam(':cantidad', $cantidad);
                $stmtInsert->execute();
            }
    
            return ['status' => 'success', 'message' => 'Producto agregado o actualizado en el carrito.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al agregar producto al carrito: ' . $e->getMessage()];
        }
    } 

    public function quitarDelCarrito($carrito)
    {
        try {

            $usuarioid = $carrito->car_fk_usuario;
            $idproducto = $carrito->car_fk_producto;
            $cantidad = 1;

            $sqlCheck = "SELECT cantidad FROM carrito WHERE usuarioid = :car_fk_usuario AND car_fk_producto = :car_fk_producto";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':car_fk_usuario', $usuarioid);
            $stmtCheck->bindParam(':car_fk_producto', $idproducto);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $nuevaCantidad = $result['cantidad'] - $cantidad;
    
                if ($nuevaCantidad > 0) {
                    $sqlUpdate = "UPDATE carrito SET cantidad = :cantidad WHERE usuarioid = :car_fk_usuario AND idproducto = :car_fk_producto";
                    $stmtUpdate = $this->conn->prepare($sqlUpdate);
                    $stmtUpdate->bindParam(':cantidad', $nuevaCantidad);
                    $stmtUpdate->bindParam(':car_fk_usuario', $usuarioid);
                    $stmtUpdate->bindParam(':car_fk_producto', $idproducto);
                    $stmtUpdate->execute();
                } else {
                    $sqlDelete = "DELETE FROM carrito WHERE usuarioid = :car_fk_usuario AND idproducto = :car_fk_producto";
                    $stmtDelete = $this->conn->prepare($sqlDelete);
                    $stmtDelete->bindParam(':car_fk_usuario', $usuarioid);
                    $stmtDelete->bindParam(':car_fk_producto', $idproducto);
                    $stmtDelete->execute();
                }
    
                return ['status' => 'success', 'message' => 'Producto actualizado o eliminado del carrito.'];
            } else {
                return ['status' => 'error', 'message' => 'El producto no está en el carrito.'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al quitar producto del carrito: ' . $e->getMessage()];
        }
    }
    
    public function obtenerCarritoPorUsuario($usuarioid)
    {
        $sql = "SELECT p.idproducto AS idproducto, p.prd_nombre, p.prd_precio, c.cantidad AS cardet_cantidad
                FROM productos p
                JOIN carrito c ON p.idproducto = c.car_fk_producto
                WHERE c.car_fk_usuario = :car_fk_usuario";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':car_fk_usuario', $usuarioid);
        $resultado->execute();
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function crearOrden($usuarioid, $vendedorId)
    {
        $this->conn->beginTransaction();

        $sqlOrden = "INSERT INTO ordenes (ord_vendedor, ord_cliente, ord_fecha_pedido, ord_fecha_entrega)
                     VALUES (:vendedorid, :clienteid, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY))";
        $stmtOrden = $this->conn->prepare($sqlOrden);
        $stmtOrden->bindParam(':vendedorid', $vendedorId);
        $stmtOrden->bindParam(':clienteid', $usuarioid);
        $stmtOrden->execute();

        $ordenId = $this->conn->lastInsertId();

        $sqlCarrito = "SELECT c.idproducto, c.cantidad, p.prd_precio
                       FROM carrito c
                       JOIN productos p ON c.idproducto = p.idproducto
                       WHERE c.usuarioid = :car_fk_usuario";
        $stmtCarrito = $this->conn->prepare($sqlCarrito);
        $stmtCarrito->bindParam(':car_fk_usuario', $usuarioid);
        $stmtCarrito->execute();

        while ($producto = $stmtCarrito->fetch(PDO::FETCH_ASSOC)) {
            $sqlOrdenProducto = "INSERT INTO orden_productos (orpd_fk_orden_id, orpd_idproducto, orpd_cantidad)
                                 VALUES (:ordenid, :car_fk_producto, :cantidad)";
            $stmtOrdenProducto = $this->conn->prepare($sqlOrdenProducto);
            $stmtOrdenProducto->bindParam(':ordenid', $ordenId);
            $stmtOrdenProducto->bindParam(':car_fk_producto', $producto['idproducto']);
            $stmtOrdenProducto->bindParam(':cantidad', $producto['cantidad']);
            $stmtOrdenProducto->execute();
        }

        $sqlEliminarCarrito = "DELETE FROM carrito WHERE usuarioid = :car_fk_usuario";
        $stmtEliminarCarrito = $this->conn->prepare($sqlEliminarCarrito);
        $stmtEliminarCarrito->bindParam(':car_fk_usuario', $usuarioid);
        $stmtEliminarCarrito->execute();

        $this->conn->commit();

        return ['status' => 'success', 'message' => 'Orden creada correctamente.'];
    }

}
?>