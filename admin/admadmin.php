<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
$loc = new local();
$model = new LocalModel();


session_start();
$idadmin = $_SESSION['idadmin'];
foreach ($model->buscarIdAdmin($idadmin) as $r) {
    $user = $r->__get('nombreadmin');
}


include_once '../est/verticalnav.php';
$NavVertical = new NavVertical();

include_once '../est/horizontalnav.php';
$NavHorizontal = new NavHorizontal($user);

require_once '../est/head.php';
$page = new Head('Administradores');
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
                        <h1 class="h3 mb-0 text-gray-800">Administradores</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <li class="nav-item btn btn-primary me-auto">
                                    <a href="addcategoria.php" class="text-white text-decoration-none">Agregar Administrador</a>
                                </li>
                                <form class="d-inline-block form-inline ml-auto mw-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" name="searchadmin" class="form-control bg-light border-0 small" placeholder="Buscar Administrador" aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Listar Administradores</h6>
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
                                                <th class="col-1 text-center align-middle">Contraseña</th>
                                                <th class="col-1 text-center align-middle">Habilitado</th>
                                                <th class="col-1 text-center align-middle">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->listarAdministrador() as $r):
                                                $idadmin = $r->__get('idadmin');
                                                $nombreadmin = $r->__get('nombreadmin');
                                                $apellidoadmin = $r->__get('apellidoadmin');
                                                $dniadmin = $r->__get('dniadmin');
                                                $direccionadmin = $r->__get('direccionadmin');
                                                $telefonoadmin = $r->__get('telefonoadmin');
                                                $passwordadmin = $r->__get('passwordadmin');
                                                $habilitadoadmin = $r->__get('habilitadoadmin');
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?php echo $idadmin; ?></td>
                                                    <td class="align-middle"><?php echo $nombreadmin; ?></td>
                                                    <td class="align-middle"><?php echo $apellidoadmin; ?></td>
                                                    <td class="align-middle"><?php echo $dniadmin; ?></td>
                                                    <td class="align-middle text-center"><?php echo $direccionadmin; ?></td>
                                                    <td class="align-middle text-center"><?php echo $telefonoadmin; ?></td>
                                                    <td class="align-middle"><?php echo $passwordadmin; ?></td>
                                                    <td class="align-middle text-center"><?php echo $habilitadoadmin; ?></td>

                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-around align-items-stretch">
                                                            <form action="editcategoria.php" method="post">
                                                                <input type="hidden" name="codigoproveedor" id="codigoproveedor" value="<?php echo $idadmin; ?>">
                                                                <input type="submit" class="btn btn-info flex-fill mx-1" value="Editar">
                                                            </form>
                                                            <form action="dltcategoria.php" method="post">
                                                                <input type="hidden" name="codigoproveedor" id="codigoproveedor" value="<?php echo $idadmin; ?>">
                                                                <input type="submit" class="btn btn-danger flex-fill mx-1" value="Eliminar">
                                                            </form>
                                                        </div>
                                                    </td>
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

    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/bootstrap/js/sb-admin-2.min.js"></script>
    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/jquery/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>