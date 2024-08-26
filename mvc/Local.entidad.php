<?php
    class local{
        private $idproducto;
        private $tituloproducto;
        private $categoria;
        private $descripcion;
        private $precio;
        private $stock;
        private $proveedor;

        private $idproveedor;
        private $ruc;
        private $nombre;
        private $tipo;
        private $direccion;
        private $telefono;
        private $correo;
        
        private $idcategoria;
        private $titulocategoria;
        
        public function __get($k){
            return $this->$k;
        }
        public function __set($k, $value){
            $this->$k = $value;
        }
    }
?>
