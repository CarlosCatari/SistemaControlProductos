<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();
    include('../est/header.php');

    /* if(isset($_POST["codcategoria"])) {
        $idcategoria = $_POST["codcategoria"];
        $titulocategoria = $_POST["nombrecategoria"];
        
        $data = new Local();
        $data->__set('idcategoria', $idcategoria);
        $data->__set('titulocategoria', $titulocategoria);
        
        $model->actualizarIdCategoria($data);
        $category = strtoupper($titulocategoria);
        $msjmodificacion = 'Categoria '.$category.' modificada correctamente.';
    }
    if(isset($_POST["cdcategoria"])) {
        $idcategoria = $_POST['cdcategoria'];
        $model->eliminarCategoria($idcategoria);
        $msjeliminacion = 'Categoria eliminada.';
    } */
?>
<body>
    <nav class="navbar navbar-expand-lg bg-body">
        <div class="container-fluid">
            <ul class="nav nav-underline me-auto mb-2 mb-lg-0 ">
                <li class="nav-item"><a class="nav-link" href="dashboardadmin.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Administradores</a></li>
                <li class="nav-item"><a class="nav-link active disabled" href="#">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="admproveedor.php">Proveedores</a></li>
                <li class="nav-item"><a class="nav-link" href="admcategoria.php">Categorias</a></li>
            </ul>
            <ul class="nav nav-underline ">
                <li class="nav-item ms-3"><a class="nav-link" href="#">Cerrar Sesion</a></li>
            </ul>
        </div>
    </nav>
    <div class="ms-3 h4">Listado de Productos</div>
    <nav class="navbar navbar-expand-lg bg-body m-2">
        <div class="container-fluid">
            <ul class="nav nav-underline me-auto mb-2 mb-lg-0 ">
                <form action="searchcategoria.php" method="post">
                    <input class="border border-primary rounded p-1" type="text" name="titulocategoria" placeholder="Buscar producto">
                    <input class="btn btn-primary mb-1" type="submit" value="Buscar">
                </form>
            </ul>
            <ul class="nav nav-underline">
                <li class="nav-item ms-3 btn btn-primary">
                    <a href="addcategoria.php" class="text-white text-decoration-none">Agregar Producto</a>
                </li>
            </ul>
        </div>
    </nav>

    <?php if (!empty($msjmodificacion)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $msjmodificacion; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <?php if (!empty($msjeliminacion)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $msjeliminacion; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="container-fluid w-100">
        <table class="table table-bordered text-center">
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Precio(S/.)</th>
                <th>Stock</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($model -> listarProducto() as $r):
                $idproducto = $r->__get('idproducto');
                $tituloproducto = $r->__get('tituloproducto');
                $categoria = $r->__get('categoria');
                $descripcion = $r->__get('descripcion');
                $precio = $r->__get('precio');
                $stock = $r->__get('stock');
                $proveedor = $r->__get('proveedor');
            ?>
            <tr> 
                <td class="align-middle "><?php echo $idproducto ; ?></td>
                <td class="align-middle col-3"><?php echo $tituloproducto ; ?></td>
                <td class="align-middle "><?php echo $categoria ; ?></td>
                <td class="align-middle col-3"><?php echo $descripcion ; ?></td>
                <td class="align-middle "><?php echo $precio ; ?></td>
                <td class="align-middle "><?php echo $stock ; ?></td>
                <td class="align-middle "><?php echo $proveedor ; ?></td>
                <td class="align-middle ">
                    <div class="d-flex justify-content-around align-items-stretch">
                        <form action="editcategoria.php" method="post">
                            <input type="hidden" name="codigoproveedor" id="codigoproveedor" value="<?php echo $idproveedor; ?>">
                            <input type="submit" class="btn btn-info flex-fill mx-1" value="Editar">
                        </form>
                        <form action="dltcategoria.php" method="post">
                            <input type="hidden" name="codigoproveedor" id="codigoproveedor" value="<?php echo $idproveedor; ?>">
                            <input type="submit" class="btn btn-danger flex-fill mx-1" value="Eliminar">
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
<?php include('../est/footer.php'); ?>