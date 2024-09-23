<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
include_once '../est/pagesnav.php';
include_once '../est/horizontalnav.php';
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

<?php echo $page->render(); ?>

<body id="page-top">
    <div id="wrapper">
        <?php echo $NavPages->renderPagesNav(); ?>
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #0039b4;">
            <div id="content">
                <?php echo $NavHorizontal->renderNavbar(); ?>
                <div class="container-fluid">
                    <div class="row">
                        <h1 class="h3 mb-0 text-gray-800">Consultas</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100 p-0 m-0">
                            <form class="col-md-3 p-0 m-0" method="GET" action="">
                            

    <div class="input-group p-0 m-0">
        <select class="form-control border-primary rounded-3" name="consulta" id="consulta" aria-label="Default select example" onchange="this.form.submit()">
            <option value="">Consultar por:</option>
            <option value="0" <?php if(isset($_GET['consulta']) && $_GET['consulta'] == "0") echo 'selected'; ?>>Categoria</option>
            <option value="1" <?php if(isset($_GET['consulta']) && $_GET['consulta'] == "1") echo 'selected'; ?>>Proveedor</option>
        </select>
    </div>
</form>

<!-- Segunda parte: select que cambia según la primera selección -->
<form method="GET" action="" class="col-md-4 pr-0 m-0">
    <div class="input-group">
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
</form>











                                <div class="input-group col-md-4">
                                    <input type="text" name="searchadmin" class="form-control bg-light border-0 small" placeholder="Buscar Producto" aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="row">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Resultado de Busqueda</h6>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <footer class="sticky-footer" style="background-color: #1738b9;">
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