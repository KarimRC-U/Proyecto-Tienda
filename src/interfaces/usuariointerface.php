<?php
    interface IUsuario {
        public function agregarAlCarrito($carrito);
        public function quitarDelCarrito($carrito);
        public function obtenerProductos();
        public function obtenerProductosPorBusqueda($busqueda);
        public function obtenerProductosPorCategoria($categoria);
    }
?>
