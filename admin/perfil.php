<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();

    session_start();
    $user = $_SESSION['usernameadmin'];
    
    include_once '../est/verticalnav.php';
    $NavVertical = new NavVertical();

    include_once '../est/horizontalnav.php';
    $NavHorizontal = new NavHorizontal($user);

    require_once '../est/head.php';
    $page = new Head('Perfil');

    if(isset($_POST["codcategoria"])) {
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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Mostrar datos...</h6>
                        </div>
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
`<!--                             <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th class="col-1 text-center align-middle">Código</th>
                                        <th class="col-8 text-center align-middle">Categoria</th>
                                        <th class="col-3 text-center align-middle">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($model -> listarCategoria() as $r):
                                            $idcategoria = $r->__get('idcategoria');
                                            $categoria = $r->__get('titulocategoria');
                                        ?>
                                        <tr>
                                            <td class="text-center align-middle"><?php echo $idcategoria; ?></td>
                                            <td class="align-middle"><?php echo $categoria; ?></td>
                                            <td class="text-center align-middle">
                                            <div class="d-flex justify-content-around align-items-stretch">
                                                <form action="editcategoria.php" method="post">
                                                    <input type="hidden" name="codigocategoria" id="codigocategoria" value="<?php echo $idcategoria; ?>">
                                                    <input type="submit" class="btn btn-info flex-fill mx-1" value="Editar">
                                                </form>
                                                <form action="dltcategoria.php" method="post">
                                                    <input type="hidden" name="codigocategoria" id="codigocategoria" value="<?php echo $idcategoria; ?>">
                                                    <input type="submit" class="btn btn-danger flex-fill mx-1" value="Eliminar">
                                                </form>
                                            </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div> -->`
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

    <script src="../icon/jquery/jquery.min.js"></script>
    <script src="../icon/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../icon/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../icon/chart.js/Chart.min.js"></script>
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
</body>
</html>