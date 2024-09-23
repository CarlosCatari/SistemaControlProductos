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
    $idpersonal = $r->__get('idpersonal');
    $nombreperso = $r->__get('nombreperso');
    $apellidoperso = $r->__get('apellidoperso');
    $dniperso = $r->__get('dniperso');
    $direccionperso = $r->__get('direccionperso');
    $telefonoperso = $r->__get('telefonoperso');
    $passwordperso = $r->__get('passwordperso');
    $habilitadoperso = $r->__get('habilitadoperso');
}
$NavPages = new NavPages();
$NavHorizontal = new NavHorizontal($nombreperso);
$page = new Head('Administrador');


// Inicializar los tokens si no están establecidos
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tokenedit']) && $_POST['tokenedit'] === $_SESSION['tokenedit']) {
        // Actualizacion de Personal
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
            header(header: 'Location: admadmin.php');
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
        <?php echo $NavPages->renderPagesNav(); ?>
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
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $idadmin; ?>">Modificar Datos</button>


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

                                <div class="container-fluid">
                                    <div class="bg-white p-3 text-secondary ">
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Codigo:</label>
                                                <input class="form-control" type="text" value="<?php echo $idpersonal; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Nombre::</label>
                                                <input class="form-control" type="text" value="<?php echo $nombreperso; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6 ">
                                                <label class="form-label" for="nombre_uno">Apellido:</label>
                                                <input class="form-control" type="text" value="<?php echo $apellidoperso; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">DNI:</label>
                                                <input class="form-control" type="text" value="<?php echo $dniperso; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Contraseña:</label>
                                                <input class="form-control" type="text" value="<?php echo $passwordperso; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Direccion:</label>
                                                <input class="form-control" type="text" value="<?php echo $direccionperso; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="nombre_uno">Telefono:</label>
                                                <input class="form-control" type="text" value="<?php echo $telefonoperso; ?>" readonly>
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

    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/bootstrap/js/sb-admin-2.min.js"></script>
    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/jquery/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>