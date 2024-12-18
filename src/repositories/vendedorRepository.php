<?php
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/interfaces/vendedorinterface.php';

class VendedorRepository implements IVendedor
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crearProducto($producto)
     {
        
        $sql = "INSERT INTO productos (prd_nombre, prd_descrip, prd_precio, prd_marca, prd_imagen, prd_estado, prd_categoria) 
        VALUES (:prd_nombre, :prd_descrip, :prd_precio, :prd_marca, :prd_imagen, :prd_estado, :prd_categoria)";

        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':prd_nombre',$producto->prd_nombre);
        $resultado->bindParam(':prd_descrip',$producto->prd_descrip);
        $resultado->bindParam(':prd_precio',$producto->prd_precio);
        $resultado->bindParam(':prd_marca',$producto->prd_marca);
        $resultado->bindParam(':prd_imagen',$producto->prd_imagen);
        $resultado->bindParam(':prd_estado',$producto->prd_estado);
        $resultado->bindParam(':prd_categoria', $producto->prd_categoria);

        if($resultado->execute()){
            return ['mensaje' => 'Producto Creado'];
        } else{
            return ['mensaje' => 'Error al crear el producto.'];
        }
    }

    public function actualizarProducto($producto)
    {
        $sql = "UPDATE productos SET 
        prd_nombre = :prd_nombre, 
        prd_descrip = :prd_descrip, 
        prd_precio = :prd_precio, 
        prd_marca = :prd_marca, 
        prd_imagen = :prd_imagen, 
        prd_estado = :prd_estado, 
        prd_categoria = :prd_categoria
        WHERE idproducto = :idproducto";

        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$producto->idproducto);
        $resultado->bindParam(':prd_nombre',$producto->prd_nombre);
        $resultado->bindParam(':prd_descrip',$producto->prd_descrip);
        $resultado->bindParam(':prd_precio',$producto->prd_precio);
        $resultado->bindParam(':prd_marca',$producto->prd_marca);
        $resultado->bindParam(':prd_imagen',$producto->prd_imagen);
        $resultado->bindParam(':prd_estado',$producto->prd_estado);
        $resultado->bindParam(':prd_categoria', $producto->prd_categoria);

        if($resultado->execute()){
            return ['mensaje' => 'Producto Actualizado'];
        } else{
            return ['mensaje' => 'Error al actualizar el producto.'];
        }
    }

    public function borrarProducto($idproducto)
    {
        $sql = "DELETE FROM productos WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$idproducto);
       
        if($resultado->execute()){
            return ['mensaje' => 'Producto Borrado'];
        } else{
            return ['mensaje' => 'Error al borrar el producto.'];
        }
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
        $sql = "SELECT * FROM productos WHERE prd_nombre LIKE :prd_nombre";
        $resultado->bindParam(':prd_nombre', $busqueda->prd_nombre);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerProductoPorId($idproducto)
    {
        $sql = "SELECT * FROM productos WHERE idproducto = :idproducto";
        $resultado = $this->conn->prepare($sql);
        $resultado->bindParam(':idproducto',$idproducto);
        $resultado->execute();
        return $resultado->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerCategorias()
    {
        try {
            $sql = "SELECT cat_id, cat_nombre FROM categorias";
            $resultado = $this->conn->prepare($sql);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['mensaje' => $e->getMessage()];
        }
    }
    
}

?>