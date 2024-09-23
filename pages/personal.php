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
                        <h1 class="h3 mb-0 text-gray-800">Personal</h1>
                    </div>
                    <div class="row mt-3">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Listar Personal</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="col-1 text-center align-middle">Cod.</th>
                                                <th class="col-2 text-center align-middle">Nombre</th>
                                                <th class="col-2 text-center align-middle">Apellido</th>
                                                <th class="col-1 text-center align-middle">DNI</th>
                                                <th class="col-2 text-center align-middle">Direccion</th>
                                                <th class="col-1 text-center align-middle">Telefono</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->listarPersonal() as $r):
                                                $idpersonal = $r->__get('idpersonal');
                                                $nombreperso = $r->__get('nombreperso');
                                                $apellidoperso = $r->__get('apellidoperso');
                                                $dniperso = $r->__get('dniperso');
                                                $direccionperso = $r->__get('direccionperso');
                                                $telefonoperso = $r->__get('telefonoperso');
                                                $passwordperso = $r->__get('passwordperso');
                                                $habilitadoperso = $r->__get('habilitadoperso');
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?php echo $idpersonal; ?></td>
                                                    <td class="align-middle"><?php echo $nombreperso; ?></td>
                                                    <td class="align-middle"><?php echo $apellidoperso; ?></td>
                                                    <td class="align-middle"><?php echo $dniperso; ?></td>
                                                    <td class="align-middle"><?php echo $direccionperso; ?></td>
                                                    <td class="align-middle text-center"><?php echo $telefonoperso; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
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