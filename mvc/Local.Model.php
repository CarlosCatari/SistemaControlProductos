<?php
    require_once "conectar.php";
    require_once "Local.entidad.php";
    
    class LocalModel extends Conectar{
        public function listarCategoria(){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Categoria');
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idcategoria', $r->idcategoria);
                    $loc->__Set('titulocategoria', $r->titulocategoria);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function agregarCategoria(Local $data){
            try {
                $stm = "INSERT INTO Categoria (titulocategoria) VALUES (?)";
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('titulocategoria')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function buscarIdCategoria($idcategoria){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Categoria WHERE idcategoria = '.$idcategoria);
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idcategoria', $r->idcategoria);
                    $loc->__Set('titulocategoria', $r->titulocategoria);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }


        public function actualizarCategoria(Local $data){
            try {
                $stm = "UPDATE Categoria SET titulocategoria = ? WHERE idcategoria = ?";
                echo $stm;
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('titulocategoria'),
                    $data->__GET('idcategoria')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function eliminarCategoria($idcategoria){
            try{
                $stm = $this->pdo->prepare("DELETE FROM Categoria WHERE idcategoria = ?");
                $stm->execute(array($idcategoria));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function buscarCategoria($titulocategoria){
            try {
                $result = array();
                $stm = $this->pdo->prepare('SELECT * FROM Categoria WHERE titulocategoria LIKE :titulocategoria');
                $stm->bindValue(':titulocategoria', '%' . $titulocategoria . '%');
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idcategoria', $r->idcategoria);
                    $loc->__Set('titulocategoria', $r->titulocategoria);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        /* 
        public function ActualizarCliente(Local $data){
            try {
                $stm = "UPDATE clientes SET pwd = ?, nombre = ?, apellido = ?, telefono = ?, correo = ?  WHERE dni = ?";
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('pwd'),
                    $data->__GET('nombre'),
                    $data->__GET('apellido'),
                    $data->__GET('telefono'),
                    $data->__GET('correo'),
                    $data->__GET('dni')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }*/

        public function listarProveedor(){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Proveedor');
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idproveedor', $r->idproveedor);
                    $loc->__Set('ruc', $r->ruc);
                    $loc->__Set('nombre', $r->nombre);
                    $loc->__Set('tipo', $r->tipo);
                    $loc->__Set('direccion', $r->direccion);
                    $loc->__Set('telefono', $r->telefono);
                    $loc->__Set('correo', $r->correo);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }


        public function agregarProveedor(Local $data){
            try {
                $stm = "INSERT INTO Proveedor (ruc,nombre,tipo, direccion, telefono, correo) VALUES (?,?,?,?,?,?)";
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('ruc'),
                    $data->__GET('nombre'),
                    $data->__GET('tipo'),
                    $data->__GET('direccion'),
                    $data->__GET('telefono'),
                    $data->__GET('correo'),
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function actualizarProveedor(Local $data){
            try {
                $stm = "UPDATE Proveedor SET ruc = ?, nombre = ?, tipo = ?, direccion = ?, telefono = ?, correo = ? WHERE idproveedor = ?";
                echo $stm;
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('ruc'),
                    $data->__GET('nombre'),
                    $data->__GET('tipo'),
                    $data->__GET('direccion'),
                    $data->__GET('telefono'),
                    $data->__GET('correo'),
                    $data->__GET('idproveedor')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function eliminarProveedor($idproveedor){
            try{
                $stm = $this->pdo->prepare("DELETE FROM Proveedor WHERE idproveedor = ?");
                $stm->execute(array($idproveedor));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        
        public function listarProducto() {
            try {
                $result = array();
                $stm = $this->pdo->prepare(
                    'SELECT 
                        p.idproducto, 
                        p.tituloproducto, 
                        c.titulocategoria AS categoria, 
                        p.descripcion, 
                        p.precio, 
                        p.stock, 
                        pr.nombre AS proveedor
                    FROM 
                        Producto p
                    JOIN 
                        Categoria c ON p.categoria_id = c.idcategoria
                    JOIN 
                        Proveedor pr ON p.proveedor_id = pr.idproveedor'
                );
                $stm->execute();
        
                foreach ($stm->fetchAll(PDO::FETCH_OBJ) as $r) {
                    $loc = new local();
                    $loc->__Set('idproducto', $r->idproducto);
                    $loc->__Set('tituloproducto', $r->tituloproducto);
                    $loc->__Set('categoria', $r->categoria);
                    $loc->__Set('descripcion', $r->descripcion);
                    $loc->__Set('precio', $r->precio);
                    $loc->__Set('stock', $r->stock);
                    $loc->__Set('proveedor', $r->proveedor);
                    $result[] = $loc;
                }
        
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function agregarProducto(Local $data){
            try {
                $stm = "INSERT INTO Producto (tituloproducto, categoria_id, descripcion, precio, stock, proveedor_id) VALUES (?,?,?,?,?,?)";
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('tituloproducto'),
                    $data->__GET('categoria_id'),
                    $data->__GET('descripcion'),
                    $data->__GET('precio'),
                    $data->__GET('stock'),
                    $data->__GET('proveedor_id'),
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function actualizarProducto(Local $data){
            try {
                $stm = "UPDATE Producto SET tituloproducto = ?, categoria_id = ?, descripcion = ?, precio = ?, stock = ?, proveedor_id = ? WHERE idproducto = ?";
                echo $stm;
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('tituloproducto'),
                    $data->__GET('categoria_id'),
                    $data->__GET('descripcion'),
                    $data->__GET('precio'),
                    $data->__GET('stock'),
                    $data->__GET('proveedor_id'),
                    $data->__GET('idproducto')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function eliminarProducto($idproducto){
            try{
                $stm = $this->pdo->prepare("DELETE FROM Producto WHERE idproducto = ?");
                $stm->execute(array($idproducto));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }


        public function listarAdministrador(){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Administrador');
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idadmin', $r->idadmin);
                    $loc->__Set('nombreadmin', $r->nombreadmin);
                    $loc->__Set('apellidoadmin', $r->apellidoadmin);
                    $loc->__Set('dniadmin', $r->dniadmin);
                    $loc->__Set('direccionadmin', $r->direccionadmin);
                    $loc->__Set('telefonoadmin', $r->telefonoadmin);
                    $loc->__Set('passwordadmin', $r->passwordadmin);
                    $loc->__Set('habilitadoadmin', $r->habilitadoadmin);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function buscarUserAdmin($dniadmin){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Administrador WHERE dniadmin = '.$dniadmin);
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('dniadmin', $r->dniadmin);
                    $loc->__Set('passwordadmin', $r->passwordadmin);
                    $loc->__Set('idadmin', $r->idadmin);
                    $loc->__Set('habilitadoadmin', $r->habilitadoadmin);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function buscarIdAdmin($idadmin){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Administrador WHERE idadmin = '.$idadmin);
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idadmin', $r->idadmin);
                    $loc->__Set('nombreadmin', $r->nombreadmin);
                    $loc->__Set('apellidoadmin', $r->apellidoadmin);
                    $loc->__Set('dniadmin', $r->dniadmin);
                    $loc->__Set('direccionadmin', $r->direccionadmin);
                    $loc->__Set('telefonoadmin', $r->telefonoadmin);
                    $loc->__Set('passwordadmin', $r->passwordadmin);
                    $loc->__Set('habilitadoadmin', $r->habilitadoadmin);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function agregarAdministrador(Local $data){
            try {
                $stm = "INSERT INTO Administrador (nombreadmin, apellidoadmin, dniadmin, direccionadmin, telefonoadmin, passwordadmin, habilitadoadmin) VALUES (?,?,?,?,?,?,?)";
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('nombreadmin'),
                    $data->__GET('apellidoadmin'),
                    $data->__GET('dniadmin'),
                    $data->__GET('direccionadmin'),
                    $data->__GET('telefonoadmin'),
                    $data->__GET('passwordadmin'),
                    $data->__GET('habilitadoadmin'),
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function actualizarAdministrador(Local $data){
            try {
                $stm = "UPDATE Administrador SET nombreadmin = ?, apellidoadmin = ?, dniadmin = ?, direccionadmin = ?, telefonoadmin = ?, passwordadmin = ?, habilitadoadmin = ? WHERE idadmin = ?";
                echo $stm;
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('nombreadmin'),
                    $data->__GET('apellidoadmin'),
                    $data->__GET('dniadmin'),
                    $data->__GET('direccionadmin'),
                    $data->__GET('telefonoadmin'),
                    $data->__GET('passwordadmin'),
                    $data->__GET('habilitadoadmin'),
                    $data->__GET('idadmin')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function eliminarAdministrador($idadmin){
            try{
                $stm = $this->pdo->prepare("DELETE FROM Administrador WHERE idadmin = ?");
                $stm->execute(array($idadmin));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        public function listarPersonal(){
            try {
                $result = array();
                $stm = $this->pdo->prepare( 'SELECT * FROM Personal');
                $stm->Execute();
                foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r){
                    $loc = new local();
                    $loc->__Set('idpersonal', $r->idpersonal);
                    $loc->__Set('nombreperso', $r->nombreperso);
                    $loc->__Set('apellidoperso', $r->apellidoperso);
                    $loc->__Set('dniperso', $r->dniperso);
                    $loc->__Set('direccionperso', $r->direccionperso);
                    $loc->__Set('telefonoperso', $r->telefonoperso);
                    $loc->__Set('passwordperso', $r->passwordperso);
                    $loc->__Set('habilitadoperso', $r->habilitadoperso);
                    $result[] = $loc;
                }
                return $result;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function agregarPersonal(Local $data){
            try {
                $stm = "INSERT INTO Personal (nombreperso, apellidoperso, dniperso, direccionperso, telefonoperso, passwordperso, habilitadoperso) VALUES (?,?,?,?,?,?,?)";
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('nombreperso'),
                    $data->__GET('apellidoperso'),
                    $data->__GET('dniperso'),
                    $data->__GET('direccionperso'),
                    $data->__GET('telefonoperso'),
                    $data->__GET('passwordperso'),
                    $data->__GET('habilitadoperso'),
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function actualizarPersonal(Local $data){
            try {
                $stm = "UPDATE Personal SET nombreperso = ?, apellidoperso = ?, dniperso = ?, direccionperso = ?, telefonoperso = ?, passwordperso = ?, habilitadoperso = ? WHERE idpersonal = ?";
                echo $stm;
                $this->pdo->prepare($stm)->execute(array(
                    $data->__GET('nombreperso'),
                    $data->__GET('apellidoperso'),
                    $data->__GET('dniperso'),
                    $data->__GET('direccionperso'),
                    $data->__GET('telefonoperso'),
                    $data->__GET('passwordperso'),
                    $data->__GET('habilitadoperso'),
                    $data->__GET('idpersonal')
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        public function eliminarPersonal($idpersonal){
            try{
                $stm = $this->pdo->prepare("DELETE FROM Personal WHERE idpersonal = ?");
                $stm->execute(array($idpersonal));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
?>