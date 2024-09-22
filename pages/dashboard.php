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
    $page = new Head('Personal');

    function contarElementos($lista) {
        return count($lista);
    }
    $contadorcat = contarElementos($model->listarCategoria());
    $contadoradmin = contarElementos($model->listarAdministrador());
    $contadorprod = contarElementos($model->listarProducto());
    $contadorprovee = contarElementos($model->listarProveedor());
    $contadorperso = contarElementos($model->listarPersonal());
?>

<?php echo $page->render();; ?>
<body id="page-top">
    <div id="wrapper">
        <?php echo $NavPages->renderPagesNav(); ?>
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #400057;">
            <div id="content">
                <?php echo $NavHorizontal->renderNavbar(); ?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Personal</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contadoradmin; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-user-tie fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Almaceneros</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contadorperso; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-address-card fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Proveedores</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contadorprovee; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-truck fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Productos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contadorprod; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-table fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Categorias</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contadorcat; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-solid fa-layer-group fa-2x text-gray-300"></i>
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
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/bootstrap/js/sb-admin-2.min.js"></script>
    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/jquery/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>