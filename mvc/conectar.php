<?php
    class Conectar{
        protected $pdo;
        public function __construct(){
            try {
                $this->pdo = new PDO("mysql:host=localhost;dbname=dbsistemaproductos", 'root', '');
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo "Fallo de conexion";
            }
        }
    }
?>
