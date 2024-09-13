<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
$loc = new local();
$model = new LocalModel();

session_start();
$idadmin = $_SESSION['idadmin'];
foreach ($model->buscarIdAdmin($idadmin) as $r) {
    $idadmin = $r->__get('idadmin');
    $nombreadmin = $r->__get('nombreadmin');
    $apellidoadmin = $r->__get('apellidoadmin');
    $dniadmin = $r->__get('dniadmin');
    $direccionadmin = $r->__get('direccionadmin');
    $telefonoadmin = $r->__get('telefonoadmin');
    $passwordadmin = $r->__get('passwordadmin');
    $habilitadoadmin = $r->__get('habilitadoadmin');
}

include_once '../est/verticalnav.php';
$NavVertical = new NavVertical();

include_once '../est/horizontalnav.php';
$NavHorizontal = new NavHorizontal($nombreadmin);

require_once '../est/head.php';
$page = new Head('Perfil');

if (isset($_POST["codcategoria"])) {
    $idcategoria = $_POST["codcategoria"];
    $titulocategoria = $_POST["nombrecategoria"];

    $data = new Local();
    $data->__set('idcategoria', $idcategoria);
    $data->__set('titulocategoria', $titulocategoria);

    $model->actualizarIdCategoria($data);
    $category = strtoupper($titulocategoria);
    $msjmodificacion = 'Categoria ' . $category . ' modificada correctamente.';
}
if (isset($_POST["cdcategoria"])) {
    $idcategoria = $_POST['cdcategoria'];
    $model->eliminarCategoria($idcategoria);
    $msjeliminacion = 'Categoria eliminada.';
}
?>

<?php echo $page->render(); ?>

<body id="page-top">
    <div id="wrapper">
        <?php echo $NavVertical->renderNavbar(); ?>
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #400057;">
            <div id="content">
                <?php echo $NavHorizontal->renderNavbar(); ?>
                <div class="container-fluid">
                    <div class="row">
                        <h1 class="h3 mb-0 text-gray-800">Mis Datos</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <li class="nav-item btn btn-primary me-auto">
                                    <a href="addcategoria.php" class="text-white text-decoration-none">Modificar Datos</a>
                                </li>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-body">
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

                                <div class="container-fluid">
                                    <div class="bg-white p-3 text-secondary ">
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Codigo:</label>
                                                <input class="form-control" type="text" value="<?php echo $idadmin; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Nombre::</label>
                                                <input class="form-control" type="text" value="<?php echo $nombreadmin; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6 ">
                                                <label class="form-label" for="nombre_uno">Apellido:</label>
                                                <input class="form-control" type="text" value="<?php echo $apellidoadmin; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">DNI:</label>
                                                <input class="form-control" type="text" value="<?php echo $dniadmin; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Contraseña:</label>
                                                <input class="form-control" type="text" value="<?php echo $passwordadmin; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Direccion:</label>
                                                <input class="form-control" type="text" value="<?php echo $direccionadmin; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Telefono:</label>
                                                <input class="form-control" type="text" value="<?php echo $telefonoadmin; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <footer class="sticky-footer" style="background-color: #400057;">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Sistema control productos</span>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/jquery-easing/jquery.easing.min.js"></script>
    <script src="../source/js/sb-admin-2.min.js"></script>
    <script src="../source/chart.js/Chart.min.js"></script>
    <script src="../source/js/demo/chart-area-demo.js"></script>
    <script src="../source/js/demo/chart-pie-demo.js"></script>
</body>

</html>