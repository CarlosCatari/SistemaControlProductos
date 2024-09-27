<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
include_once '../est/verticalnav.php';
include_once '../est/horizontalnav.php';
require_once '../est/head.php';
$loc = new local();
$model = new LocalModel();

session_start();
$idadmin = $_SESSION['idadmin'];
foreach ($model->buscarIdAdmin($idadmin) as $r) {
    $user = $r->__get('nombreadmin');
}
$NavVertical = new NavVertical();
$NavHorizontal = new NavHorizontal($user);
$page = new Head('Administrador');


// Inicializar los tokens si no están establecidos
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if (empty($_SESSION['tokendlt'])) {
    $_SESSION['tokendlt'] = bin2hex(random_bytes(32));
}
if (empty($_SESSION['tokenedit'])) {
    $_SESSION['tokenedit'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        //  Agregar un Administrador
        if (isset($_POST['nombreadm'])) {
            $nombreadm = $_POST['nombreadm'];
            $apellidoadm = $_POST['apellidoadm'];
            $dniadm = $_POST['dniadm'];
            $direccionadm = $_POST['direccionadm'];
            $telefonoadm = $_POST['telefonoadm'];
            $contraadm = $_POST['contraadm'];
            $habilitadoadm = $_POST['habilitadoadm'];

            $data = new Local();
            $data->__set('nombreadmin', $nombreadm);
            $data->__set('apellidoadmin', $apellidoadm);
            $data->__set('dniadmin', $dniadm);
            $data->__set('direccionadmin', $direccionadm);
            $data->__set('telefonoadmin', $telefonoadm);
            $data->__set('passwordadmin', $contraadm);
            $data->__set('habilitadoadmin', $habilitadoadm);
            $model->agregarAdministrador($data);

            $newadmin = strtoupper($nombreadm) . " " . strtoupper($apellidoadm);
            $_SESSION['msjaddadmin'] = 'Administrador ' . $newadmin . ' agregado correctamente.';
            header('Location: admadmin.php');
            exit;
        }
    } elseif (isset($_POST['tokendlt']) && $_POST['tokendlt'] === $_SESSION['tokendlt']) {
        // Eliminación de Administrador
        if (isset($_POST['codigoadmin'])) {
            $codigoadmin = $_POST['codigoadmin'];
            $model->eliminarAdministrador($codigoadmin);
            $_SESSION['msjdeleteadm'] = 'Administrador eliminado correctamente.';
            header('Location: admadmin.php');
            exit;
        }
    } elseif (isset($_POST['tokenedit']) && $_POST['tokenedit'] === $_SESSION['tokenedit']) {
        // Actualizacion Administrador
        if (isset($_POST["modcodadmin"])) {
            $idadmin = $_POST['modcodadmin'];
            $nombreadmin = $_POST['nombreadm'];
            $apellidoadmin = $_POST['apellidoadm'];
            $dniadmin = $_POST['dniadm'];
            $direccionadmin = $_POST['direccionadm'];
            $telefonoadmin = $_POST['telefonoadm'];
            $passwordadmin = $_POST['contraadm'];
            $habilitadoadmin = $_POST['habilitadoadm'];

            $data = new Local();
            $data->__set('idadmin', $idadmin);
            $data->__set('nombreadmin', $nombreadmin);
            $data->__set('apellidoadmin', $apellidoadmin);
            $data->__set('dniadmin', $dniadmin);
            $data->__set('direccionadmin', $direccionadmin);
            $data->__set('telefonoadmin', $telefonoadmin);
            $data->__set('passwordadmin', $passwordadmin);
            $data->__set('habilitadoadmin', $habilitadoadmin);

            $model->actualizarAdministrador($data);
            $editadmin = strtoupper($nombreadmin) . " " . strtoupper($apellidoadmin);
            $_SESSION['msjeditcat'] = 'Administrador ' . $editadmin . ' modificado correctamente.';
            header('Location: admadmin.php');
            exit;
        }
    } else {
        die('Token inválido');
    }
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
                        <h1 class="h3 mb-0 text-gray-800">Administradores</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <!---------- Modal Agregar Categoría ---------->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Administrador</button>
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Nuevo Administrador</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="admadmin.php" id="FormAddAdm" method="post" class="p-0">
                                                    <div class="row m-0 p-0">
                                                        <div class="col-md-12 form-group text-left">
                                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
                                                            <label for="nombreadm">Nombre</label>
                                                            <input type="text" name="nombreadm" id="nombreadm" class="form-control border-primary rounded-3" placeholder="Nombre" pattern="[a-zA-Z\s]+" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="apellidoadm">Apelllido</label>
                                                            <input type="text" name="apellidoadm" id="apellidoadm" class="form-control border-primary rounded-3" placeholder="Apellido" pattern="[a-zA-Z\s]+" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <label for="dniadm">DNI</label>
                                                                <input type="text" name="dniadm" id="dniadm" class="form-control border-primary rounded-3" placeholder="DNI" required>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="telefonoadm">Telefono</label>
                                                                <input type="text" name="telefonoadm" id="telefonoadm" class="form-control border-primary rounded-3" placeholder="Telefono" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="direccionadm">Direccion</label>
                                                            <input type="text" name="direccionadm" id="direccionadm" class="form-control border-primary rounded-3" placeholder="Direccion" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <label for="contraadm">Contraseña</label>
                                                                <input type="text" name="contraadm" id="contraadm" class="form-control border-primary rounded-3" placeholder="Contraseña" required>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="habilitadoadm">Habilitado</label>
                                                                <select class="form-control border-primary rounded-3" name="habilitadoadm" id="habilitadoadm" aria-label="Default select example">
                                                                    <option value="" disabled selected>Seleccionar</option>
                                                                    <option value="1">Habilitado</option>
                                                                    <option value="0">Desabilitado</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button form="FormAddAdm" type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                <!--------------------------- Alertas -------------------------->
                                <?php if (!empty($_SESSION['msjaddadmin'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjaddadmin']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjaddadmin']); ?>
                                <?php endif; ?>

                                <?php if (!empty($_SESSION['msjdeleteadm'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjdeleteadm']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjdeleteadm']); ?>
                                <?php endif; ?>

                                <?php if (!empty($_SESSION['msjeditcat'])): ?>
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjeditcat']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjeditcat']); ?>
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

    
                                                        
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $idadmin; ?>">Editar</button>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $idadmin; ?>">Eliminar</button>
                                                            <!---------- Modal Editar Categoría ---------->
                                                            <div class="modal fade" id="editModal<?php echo $idadmin; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $idadmin; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $idadmin; ?>">Editar Administrador</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="admadmin.php" id="FormEditCat<?php echo $idadmin; ?>" method="post" class="p-0">
                                                                                <div class="row">
                                                                                    
                                                                                    <div class="col-md-12 form-group text-left">
                                                                                        <input type="hidden" name="tokenedit" value="<?php echo $_SESSION['tokenedit']; ?>">
                                                                                        <input type="hidden" name="modcodadmin" value="<?php echo $idadmin; ?>">

                                                                                        <label for="nombreadm">Nombre</label>
                                                                                        <input type="text" name="nombreadm" id="nombreadm" class="form-control border-primary rounded-3" value="<?php echo $nombreadmin; ?>" placeholder="Nombre" pattern="[a-zA-Z\s]+" required>
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group text-left">
                                                                                        <label for="apellidoadm">Apelllido</label>
                                                                                        <input type="text" name="apellidoadm" id="apellidoadm" class="form-control border-primary rounded-3" value="<?php echo $apellidoadmin; ?>" placeholder="Apellido" pattern="[a-zA-Z\s]+" required>
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group text-left d-flex">
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <label for="dniadm">DNI</label>
                                                                                            <input type="text" name="dniadm" id="dniadm" class="form-control border-primary rounded-3" value="<?php echo $dniadmin; ?>" placeholder="DNI" required>
                                                                                        </div>
                                                                                        <div class="col-6 m-0 p-0">
                                                                                            <label for="telefonoadm">Telefono</label>
                                                                                            <input type="text" name="telefonoadm" id="telefonoadm" class="form-control border-primary rounded-3" value="<?php echo $telefonoadmin; ?>" placeholder="Telefono" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group text-left">
                                                                                        <label for="direccionadm">Direccion</label>
                                                                                        <input type="text" name="direccionadm" id="direccionadm" class="form-control border-primary rounded-3" value="<?php echo $direccionadmin; ?>" placeholder="Direccion" required>
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group text-left d-flex">
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <label for="contraadm">Contraseña</label>
                                                                                            <input type="text" name="contraadm" id="contraadm" class="form-control border-primary rounded-3" value="<?php echo $passwordadmin; ?>" placeholder="Contraseña" required>
                                                                                        </div>
                                                                                        <div class="col-6 m-0 p-0">
                                                                                            <label for="habilitadoadm">Habilitado</label>
                                                                                            <select class="form-control border-primary rounded-3" name="habilitadoadm" id="habilitadoadm" aria-label="Default select example">
                                                                                                <option value="" disabled <?php echo ($habilitadoadmin === "") ? 'selected' : ''; ?>>Seleccionar</option>
                                                                                                <option value="1" <?php echo ($habilitadoadmin === '1') ? 'selected' : ''; ?>>Habilitado</option>
                                                                                                <option value="0" <?php echo ($habilitadoadmin === '0' || $habilitadoadmin === 0) ? 'selected' : ''; ?>>Deshabilitado</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" form="FormEditCat<?php echo $idadmin; ?>" class="btn btn-primary">Guardar Cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!---------- Modal Eliminar Categoría ---------->
                                                            <div class="modal fade" id="deleteModal<?php echo $idadmin; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $idadmin; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $idadmin; ?>">Confirmar Eliminación</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>¿Estás seguro de que deseas eliminar el administrador:<br><strong><?php echo $nombreadmin . " " . $apellidoadmin; ?></strong>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="admadmin.php" method="post">
                                                                                <input type="hidden" name="tokendlt" value="<?php echo $_SESSION['tokendlt']; ?>">
                                                                                <input type="hidden" name="codigoadmin" value="<?php echo $idadmin; ?>">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

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