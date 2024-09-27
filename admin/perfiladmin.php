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
$user = $_SESSION['idadmin'];
foreach ($model->buscarIdAdmin($user) as $r) {
    $idadmin = $r->__get('idadmin');
    $nombreadmin = $r->__get('nombreadmin');
    $apellidoadmin = $r->__get('apellidoadmin');
    $dniadmin = $r->__get('dniadmin');
    $direccionadmin = $r->__get('direccionadmin');
    $telefonoadmin = $r->__get('telefonoadmin');
    $passwordadmin = $r->__get('passwordadmin');
    $habilitadoadmin = $r->__get('habilitadoadmin');
}

$NavVertical = new NavVertical();
$NavHorizontal = new NavHorizontal($nombreadmin);
$page = new Head('Administrador');

// Inicializar los tokens si no están establecidos
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        // Actualizacion de Personal
        if (isset($_POST["modcodadmin"])) {
            $idadm = $_POST['modcodadmin'];
            $nombreadm = $_POST['nombreadm'];
            $apellidoadm = $_POST['apellidoadm'];
            $dniadm = $_POST['dniadm'];
            $direccionadm = $_POST['direccionadm'];
            $telefonoadm = $_POST['telefonoadm'];
            $passwordadm = $_POST['contraadm'];
            $habiladm = $_POST['habilitadoadm'];


            $data = new Local();
            $data->__set('idadmin', $idadm);
            $data->__set('nombreadmin', $nombreadm);
            $data->__set('apellidoadmin', $apellidoadm);
            $data->__set('dniadmin', $dniadm);
            $data->__set('direccionadmin', $direccionadm);
            $data->__set('telefonoadmin', $telefonoadm);
            $data->__set('passwordadmin', $passwordadm);
            $data->__set('habilitadoadmin', $habiladm);

            $model->actualizarAdministrador($data);
            $_SESSION['msjeditperfil'] = 'Datos modificado correctamente.';
            header('Location: perfiladmin.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Mis Datos</h1>
                    </div>
                    
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <!---------- Modal Editar Datos---------->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Modificar Datos</button>
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
                                                <form action="perfiladmin.php" id="FormAddAdm" method="post" class="p-0">
                                                    <div class="row m-0 p-0">
                                                        <div class="col-md-12 form-group text-left">
                                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
                                                            <input type="hidden" name="modcodadmin" value="<?php echo $idadmin; ?>">
                                                            <label for="nombreadm">Nombre</label>
                                                            <input type="text" name="nombreadm" id="nombreadm" value="<?php echo $nombreadmin ;?>" class="form-control border-primary rounded-3" placeholder="Nombre" pattern="[a-zA-Z\s]+" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="apellidoadm">Apelllido</label>
                                                            <input type="text" name="apellidoadm" id="apellidoadm" value="<?php echo $apellidoadmin ;?>"  class="form-control border-primary rounded-3" placeholder="Apellido" pattern="[a-zA-Z\s]+" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <label for="dniadm">DNI</label>
                                                                <input type="text" name="dniadm" id="dniadm" value="<?php echo $dniadmin ;?>" class="form-control border-primary rounded-3" placeholder="DNI" required>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="telefonoadm">Telefono</label>
                                                                <input type="text" name="telefonoadm" id="telefonoadm" value="<?php echo $telefonoadmin ;?>"  class="form-control border-primary rounded-3" placeholder="Telefono" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="direccionadm">Direccion</label>
                                                            <input type="text" name="direccionadm" id="direccionadm" value="<?php echo $direccionadmin ;?>"  class="form-control border-primary rounded-3" placeholder="Direccion" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="contraadm">Contraseña</label>
                                                            <input type="text" name="contraadm" id="contraadm" value="<?php echo $passwordadmin ;?>"  class="form-control border-primary rounded-3" placeholder="Contraseña" required>
                                                            <input type="hidden" name="habilitadoadm" id="habilitadoadm" value="<?php echo $habilitadoadmin ;?>"  >

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
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-body">
                                <!--------------------------- Alertas -------------------------->
                                <?php if (!empty($_SESSION['msjeditperfil'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjeditperfil']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjeditperfil']); ?>
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

    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/bootstrap/js/sb-admin-2.min.js"></script>
    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/jquery/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>