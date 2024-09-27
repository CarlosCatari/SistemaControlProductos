<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
include_once '../est/pagesnavh.php';
include_once '../est/pagesnav.php';
require_once '../est/head.php';
$loc = new local();
$model = new LocalModel();

session_start();
$idpersonal = $_SESSION['idpersonal'];
foreach ($model->buscarIdPersonal($idpersonal) as $r) {
    $user = $r->__get('nombreperso');
}
$NavPages = new NavPages();
$NavHorizontal = new NavHorizontal($user);
$page = new Head('Consultas');
?>

<?php echo $page->render();; ?>

<body id="page-top">
    <div id="wrapper">
        <?php echo $NavPages->renderPagesNav(); ?>
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #cecece;">
            <div id="content">
                <?php echo $NavHorizontal->renderNavbar(); ?>
                <div class="container-fluid">
                    <div class="row">
                        <h1 class="h3 mb-0 text-gray-800">Consultas</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100 p-0 m-0">


                            <form class="container-fluid p-0 m-0 row" method="GET" action="">
                                <div class="input-group col-12 col-md-4">
                                    <!-- Seleccionar Categoria o Proveedor -->
                                    <select class="form-control border-primary rounded-3" name="consulta" id="consulta" aria-label="Default select example" onchange="this.form.submit()">
                                        <option value="">Consultar por:</option>
                                        <option value="0" <?php if (isset($_GET['consulta']) && $_GET['consulta'] == "0") echo 'selected'; ?>>Categoría</option>
                                        <option value="1" <?php if (isset($_GET['consulta']) && $_GET['consulta'] == "1") echo 'selected'; ?>>Proveedor</option>
                                    </select>
                                </div>


                                <div class="input-group col-12 col-md-4">
                                    <!-- Seleccionar opciones de Categoria o Proveedor -->
                                    <select class="form-control border-primary rounded-3" name="detalle" id="detalle" aria-label="Default select example">
                                        <option value="" disabled selected>Seleccionar:</option>
                                        <?php
                                        if (isset($_GET['consulta'])) {
                                            $consulta = $_GET['consulta'];

                                            if ($consulta == "0") {
                                                // Mostrar opciones de categoría
                                                foreach ($model->listarCategoria() as $r) {
                                                    $idcategoria = $r->__get('idcategoria');
                                                    $categoria = $r->__get('titulocategoria');
                                                    echo "<option value='$idcategoria'>$categoria</option>";
                                                }
                                            } elseif ($consulta == "1") {
                                                // Mostrar opciones de proveedor
                                                foreach ($model->listarProveedor() as $r) {
                                                    $idproveedor = $r->__get('idproveedor');
                                                    $nombreprov = $r->__get('nombre');
                                                    echo "<option value='$idproveedor'>$nombreprov</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="input-group col-12 col-md-4">
                                    <button type="submit" name="buscar" class="btn btn-primary">Buscar</button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- Resultados de la búsqueda -->
                    <div class="row">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Resultado de Búsqueda</h6>
                            </div>
                            <div class="card-body">
                                <!------ Cantidad por categoria o proveedor -------->
                                <?php
                                $contadorcategoria = 0;
                                $contadorproveedor = 0;
                                if (isset($_GET['buscar']) && isset($_GET['detalle'])) {
                                    $detalle = $_GET['detalle'];
                                    $consulta = $_GET['consulta'];
                                    if ($consulta == "0") {
                                        $contadorcategoria = $model->contarProductosPorCategoria($detalle);
                                ?>
                                        <div>
                                            <p class="text-left"><strong>Total de productos en esta categoría: <?php echo $contadorcategoria; ?></strong></p>
                                        </div>
                                    <?php

                                    } elseif ($consulta == "1") {
                                        $contadorproveedor = $model->contarProductosPorProveedor($detalle);
                                    ?>
                                        <div>
                                            <p class="text-left"><strong>Total de productos con este proveedor: <?php echo $contadorproveedor; ?></strong></p>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="col-1 text-center align-middle">Cod.</th>
                                            <th class="col-3 text-center align-middle">Producto</th>
                                            <th class="col-1 text-center align-middle">Categoria</th>
                                            <th class="col-3 text-center align-middle">Descripción</th>
                                            <th class="col-1 text-center align-middle">Precio</th>
                                            <th class="col-1 text-center align-middle">Stock</th>
                                            <th class="col-1 text-center align-middle">Proveedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['buscar']) && isset($_GET['detalle'])) {
                                            $detalle = $_GET['detalle'];
                                            $consulta = $_GET['consulta'];


                                            if ($consulta == "0") {
                                                // Buscar productos por categoría
                                                foreach ($model->buscarProductoPorCategoria($detalle) as $r) :
                                                    $idproducto = $r->__get('idproducto');
                                                    $tituloproducto = $r->__get('tituloproducto');
                                                    $categoria = $r->__get('categoria');
                                                    $descripcion = $r->__get('descripcion');
                                                    $precio = $r->__get('precio');
                                                    $stock = $r->__get('stock');
                                                    $proveedor = $r->__get('proveedor');
                                        ?>
                                                    <tr>
                                                        <td class="text-center align-middle"><?php echo $idproducto; ?></td>
                                                        <td class="align-middle"><?php echo $tituloproducto; ?></td>
                                                        <td class="align-middle"><?php echo $categoria; ?></td>
                                                        <td class="align-middle"><?php echo $descripcion; ?></td>
                                                        <td class="align-middle text-center"><?php echo $precio; ?></td>
                                                        <td class="align-middle text-center"><?php echo $stock; ?></td>
                                                        <td class="align-middle"><?php echo $proveedor; ?></td>
                                                    </tr>
                                                <?php endforeach;
                                            } elseif ($consulta == "1") {
                                                // Buscar productos por proveedor
                                                foreach ($model->buscarProductoPorProveedor($detalle) as $r) :
                                                    $idproducto = $r->__get('idproducto');
                                                    $tituloproducto = $r->__get('tituloproducto');
                                                    $categoria = $r->__get('categoria');
                                                    $descripcion = $r->__get('descripcion');
                                                    $precio = $r->__get('precio');
                                                    $stock = $r->__get('stock');
                                                    $proveedor = $r->__get('proveedor');
                                                ?>
                                                    <tr>
                                                        <td class="text-center align-middle"><?php echo $idproducto; ?></td>
                                                        <td class="align-middle"><?php echo $tituloproducto; ?></td>
                                                        <td class="align-middle"><?php echo $categoria; ?></td>
                                                        <td class="align-middle"><?php echo $descripcion; ?></td>
                                                        <td class="align-middle text-center"><?php echo $precio; ?></td>
                                                        <td class="align-middle text-center"><?php echo $stock; ?></td>
                                                        <td class="align-middle"><?php echo $proveedor; ?></td>
                                                    </tr>
                                        <?php endforeach;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <footer class="sticky-footer" style="background-color: #002349;">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Sistema control productos</span>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/bootstrap/js/sb-admin-2.min.js"></script>
    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/jquery/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>