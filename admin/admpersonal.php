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
$page = new Head('Personal');


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
        //  Agregar Personal
        if (isset($_POST['nombreper'])) {
            $nombreper = $_POST['nombreper'];
            $apellidoper = $_POST['apellidoper'];
            $dniper = $_POST['dniper'];
            $direccionper = $_POST['direccionper'];
            $telefonoper = $_POST['telefonoper'];
            $contraper = $_POST['contraper'];
            $habilitadoper = $_POST['habilitadoper'];

            $data = new Local();
            $data->__set('nombreperso', $nombreper);
            $data->__set('apellidoperso', $apellidoper);
            $data->__set('dniperso', $dniper);
            $data->__set('direccionperso', $direccionper);
            $data->__set('telefonoperso', $telefonoper);
            $data->__set('passwordperso', $contraper);
            $data->__set('habilitadoperso', $habilitadoper);
            $model->agregarPersonal(data: $data);

            $newperso = strtoupper($nombreper) . " " . strtoupper($apellidoper);
            $_SESSION['msjaddperso'] = 'Personal ' . $newperso . ' agregado correctamente.';
            header(header: 'Location: admpersonal.php');
            exit;
        }
    } elseif (isset($_POST['tokendlt']) && $_POST['tokendlt'] === $_SESSION['tokendlt']) {
        // Eliminar Personal
        if (isset($_POST['codigopersonal'])) {
            $idpersonal = $_POST['codigopersonal'];
            $model->eliminarPersonal($idpersonal);
            $_SESSION['msjdeleteper'] = 'Personal eliminado correctamente.';
            header(header: 'Location: admpersonal.php');
            exit;
        }
    } elseif (isset($_POST['tokenedit']) && $_POST['tokenedit'] === $_SESSION['tokenedit']) {
        // Actualizacion de Personal
        if (isset($_POST["modcodperso"])) {
            $idpersonal = $_POST['modcodperso'];
            $nombreper = $_POST['nombreperso'];
            $apellidoper = $_POST['apellidoperso'];
            $dniper = $_POST['dniperso'];
            $direccionper = $_POST['direccionperso'];
            $telefonoper = $_POST['telefonoperso'];
            $passwordper = $_POST['contraperso'];
            $habilitadoper = $_POST['habilitadoperso'];

            $data = new Local();
            $data->__set('idpersonal', $idpersonal);
            $data->__set('nombreperso', $nombreper);
            $data->__set('apellidoperso', $apellidoper);
            $data->__set('dniperso', $dniper);
            $data->__set('direccionperso', $direccionper);
            $data->__set('telefonoperso', $telefonoper);
            $data->__set('passwordperso', $passwordper);
            $data->__set('habilitadoperso', $habilitadoper);

            $model->actualizarPersonal($data);
            $editperso = strtoupper($nombreper) . " " . strtoupper($apellidoper);
            $_SESSION['msjeditper'] = 'Personal ' . $editperso . ' modificado correctamente.';
            header(header: 'Location: admpersonal.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Personal</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">

                                <!---------- Modal Agregar Personal ---------->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Personal</button>
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Nuevo Personal</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="admpersonal.php" id="FormAddPer" method="post" class="p-0">
                                                <div class="row m-0 p-0">
                                                        <div class="col-md-12 form-group text-left">
                                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars(string: $_SESSION['token']); ?>">
                                                            <label for="nombreper">Nombre</label>
                                                            <input type="text" name="nombreper" id="nombreper" class="form-control border-primary rounded-3" placeholder="Nombre" pattern="[a-zA-Z\s]+" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="apellidoper">Apelllido</label>
                                                            <input type="text" name="apellidoper" id="apellidoper" class="form-control border-primary rounded-3" placeholder="Apellido" pattern="[a-zA-Z\s]+" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <label for="dniper">DNI</label>
                                                                <input type="text" name="dniper" id="dniper" class="form-control border-primary rounded-3" placeholder="DNI" required>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="telefonoper">Telefono</label>
                                                                <input type="text" name="telefonoper" id="telefonoper" class="form-control border-primary rounded-3" placeholder="Telefono" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="direccionper">Direccion</label>
                                                            <input type="text" name="direccionper" id="direccionper" class="form-control border-primary rounded-3" placeholder="Direccion" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <label for="contraper">Contraseña</label>
                                                                <input type="text" name="contraper" id="contraper" class="form-control border-primary rounded-3" placeholder="Contraseña" required>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="habilitadoper">Habilitado</label>
                                                                <select class="form-control border-primary rounded-3" name="habilitadoper" id="habilitadoper" aria-label="Default select example">
                                                                    <option value="" disabled selected>Seleccionar</option>
                                                                    <option value="1">Habilitado</option>
                                                                    <option value="2">Desabilitado</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button form="FormAddPer" type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <form class="d-inline-block form-inline ml-auto mw-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" name="searchpersonal" class="form-control bg-light border-0 small" placeholder="Buscar Personal" aria-label="Search" aria-describedby="basic-addon2">
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
                                <h6 class="m-0 font-weight-bold text-primary">Listar Personal</h6>
                            </div>
                            <div class="card-body">
                                <!--------------------------- Alertas -------------------------->
                                <?php if (!empty($_SESSION['msjeditper'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjeditper']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjeditper']); ?>
                                <?php endif; ?>

                                <?php if (!empty($_SESSION['msjdeleteper'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjdeleteper']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjdeleteper']); ?>
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
                                                    <td class="align-middle text-center"><?php echo $direccionperso; ?></td>
                                                    <td class="align-middle text-center"><?php echo $telefonoperso; ?></td>
                                                    <td class="align-middle"><?php echo $passwordperso; ?></td>
                                                    <td class="align-middle text-center"><?php echo $habilitadoperso; ?></td>

                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-around align-items-stretch">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $idpersonal; ?>">Editar</button>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $idpersonal; ?>">Eliminar</button>

                                                            <!---------- Modal Editar Personal ---------->
                                                            <div class="modal fade" id="editModal<?php echo $idpersonal; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $idpersonal; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $idpersonal; ?>">Editar Personal</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                        <form action="admpersonal.php" id="FormEditPer<?php echo $idpersonal; ?>" method="post" class="p-0">
                                                                                <div class="container-fluid">
                                                                                    <div class="mb-2 form-group text-left d-flex">
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <input type="hidden" name="tokenedit" value="<?php echo $_SESSION['tokenedit']; ?>">
                                                                                            <label for="modcodperso">Codigo:</label>
                                                                                            <input type="text" id="modcodperso" name="modcodperso" class="form-control border-primary rounded-3" value="<?php echo $idpersonal; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <label for="nombreperso">Nombre</label>
                                                                                            <input type="text" name="nombreperso" id="nombreperso" class="form-control border-primary rounded-3" value="<?php echo $nombreperso; ?>" placeholder="Nombre" pattern="[a-zA-Z\s]+" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="apellidoperso">Apelllido</label>
                                                                                        <input type="text" name="apellidoperso" id="apellidoperso" class="form-control border-primary rounded-3" value="<?php echo $apellidoperso; ?>" placeholder="Apellido" pattern="[a-zA-Z\s]+" required>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left d-flex">
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <label for="dniperso">DNI</label>
                                                                                            <input type="text" name="dniperso" id="dniperso" class="form-control border-primary rounded-3" value="<?php echo $dniperso; ?>" placeholder="DNI" required>
                                                                                        </div>
                                                                                        <div class="col-6 m-0 p-0">
                                                                                            <label for="telefonoperso">Telefono</label>
                                                                                            <input type="text" name="telefonoperso" id="telefonoperso" class="form-control border-primary rounded-3" value="<?php echo $telefonoperso; ?>" placeholder="Telefono" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="direccionperso">Direccion</label>
                                                                                        <input type="text" name="direccionperso" id="direccionperso" class="form-control border-primary rounded-3" value="<?php echo $direccionperso; ?>" placeholder="Direccion" required>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left d-flex">
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <label for="contraperso">Contraseña</label>
                                                                                            <input type="text" name="contraperso" id="contraperso" class="form-control border-primary rounded-3" value="<?php echo $passwordperso; ?>" placeholder="Contraseña" required>
                                                                                        </div>
                                                                                        <div class="col-6 m-0 p-0">
                                                                                            <label for="habilitadoperso">Habilitado</label>
                                                                                            <select class="form-control border-primary rounded-3" name="habilitadoperso" id="habilitadoperso" aria-label="Default select example">
                                                                                                <option value="" disabled <?php echo ($habilitadoperso === "") ? 'selected' : ''; ?>>Seleccionar</option>
                                                                                                <option value="1" <?php echo ($habilitadoperso === '1') ? 'selected' : ''; ?>>Habilitado</option>
                                                                                                <option value="0" <?php echo ($habilitadoperso === '0' || $habilitadoperso === 0) ? 'selected' : ''; ?>>Deshabilitado</option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" form="FormEditPer<?php echo $idpersonal; ?>" class="btn btn-primary">Guardar Cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!---------- Modal Eliminar Personal---------->
                                                            <div class="modal fade" id="deleteModal<?php echo $idpersonal; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $idpersonal; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $idpersonal; ?>">Confirmar Eliminación</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>¿Estás seguro de que deseas eliminar la categoría:<br><strong><?php echo $nombreperso." ".$apellidoperso ; ?></strong>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="admpersonal.php" method="post">
                                                                                <input type="hidden" name="tokendlt" value="<?php echo $_SESSION['tokendlt']; ?>">
                                                                                <input type="hidden" name="codigopersonal" value="<?php echo $idpersonal; ?>">
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