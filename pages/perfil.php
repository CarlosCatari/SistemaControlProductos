<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
include_once '../est/pagesnavh.php';
include_once '../est/pagesnav.php';
require_once '../est/head.php';
$loc = new local();
$model = new LocalModel();

session_start();
$idpersonal = $_SESSION['idpersonal'];
foreach ($model->buscarIdPersonal($idpersonal) as $r) { 
    $user = $r->__get('nombreperso');
    $apellidoperso = $r->__get('apellidoperso');
    $dniperso = $r->__get('dniperso');
    $direccionperso = $r->__get('direccionperso');
    $telefonoperso = $r->__get('telefonoperso');
    $passwordperso = $r->__get('passwordperso');
    $habilitadoperso = $r->__get('habilitadoperso');
}

$NavPages = new NavPages();
$NavHorizontal = new NavHorizontal($user);
$page = new Head('Perfil');


// Inicializar los tokens si no están establecidos
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        // Actualizacion de Personal
        if (isset($_POST["modcodperso"])) {
            $modcodperso = $_POST['modcodperso'];
            $nombreper = $_POST['nombreper'];
            $apellidoper = $_POST['apellidoper'];
            $dniper = $_POST['dniper'];
            $direccionper = $_POST['direccionper'];
            $telefonoper = $_POST['telefonoper'];
            $passwordper = $_POST['contraper'];
            $habilitadoper = $_POST['habilitadoper'];

            $data = new Local();
            $data->__set('idpersonal', $modcodperso);
            $data->__set('nombreperso', $nombreper);
            $data->__set('apellidoperso', $apellidoper);
            $data->__set('dniperso', $dniper);
            $data->__set('direccionperso', $direccionper);
            $data->__set('telefonoperso', $telefonoper);
            $data->__set('passwordperso', $passwordper);
            $data->__set('habilitadoperso', $habilitadoper);

            $model->actualizarPersonal($data);
            $_SESSION['msjeditper'] = 'Datos modificados correctamente.';
            header('Location: perfil.php');
            exit;
        }
    } else {
        die('Token inválido');
    }
}
?>

<?php echo $page->render();; ?>

<body id="page-top">
    <div id="wrapper">
        <?php echo $NavPages->renderPagesNav(); ?>
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #cecece;">
            <div id="content">
                <?php echo $NavHorizontal->renderNavbar(); ?>
                <div class="container-fluid">
                    <div class="row">
                        <h1 class="m-0 font-weight-bold" style="color: #002349;">Mis Datos</h1>
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
                                                <h5 class="modal-title" id="addModalLabel">Actualizar Datos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="perfil.php" id="FormAddAdm" method="post" class="p-0">
                                                    <div class="row m-0 p-0">
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']); ?>">
                                                                <label for="modcodperso">Codigo:</label>
                                                                <input type="text" name="modcodperso" id="modcodperso" value="<?php echo $idpersonal ;?>" class="form-control border-primary rounded-3" readonly>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="dniper">DNI:</label>
                                                                <input type="text" name="dniper" id="dniper" value="<?php echo $dniperso ;?>" class="form-control border-primary rounded-3" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left d-flex">
                                                            <div class="col-6 m-0 pl-0">
                                                                <label for="nombreper">Nombre:</label>
                                                                <input type="text" name="nombreper" id="nombreper" value="<?php echo $user ;?>" class="form-control border-primary rounded-3" readonly>
                                                            </div>
                                                            <div class="col-6 m-0 p-0">
                                                                <label for="apellidoper">Apelllido:</label>
                                                                <input type="text" name="apellidoper" id="apellidoper" value="<?php echo $apellidoperso ;?>"  class="form-control border-primary rounded-3" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="telefonoper">Telefono:</label>
                                                            <input type="text" name="telefonoper" id="telefonoper" value="<?php echo $telefonoperso ;?>"  class="form-control border-primary rounded-3" placeholder="Telefono" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="direccionper">Direccion:</label>
                                                            <input type="text" name="direccionper" id="direccionper" value="<?php echo $direccionperso ;?>"  class="form-control border-primary rounded-3" placeholder="Direccion" required>
                                                        </div>
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="contraper">Contraseña:</label>
                                                            <input type="text" name="contraper" id="contraper" value="<?php echo $passwordperso ;?>"  class="form-control border-primary rounded-3" placeholder="Contraseña" required>
                                                            <input type="hidden" name="habilitadoper" id="habilitadoper" value="<?php echo $habilitadoperso ;?>">

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
                                <?php if (!empty($_SESSION['msjeditper'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjeditper']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjeditper']); ?>
                                <?php endif; ?>

                                <div class="container-fluid">
                                    <div class="bg-white p-3 text-secondary ">
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="codigo">Codigo:</label>
                                                <input class="form-control" type="text" name="codigo" id="codigo" value="<?php echo $idpersonal; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="usernames">Nombre:</label>
                                                <input class="form-control" type="text" name="usernames" id="usernames" value="<?php echo $user; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6 ">
                                                <label class="form-label" for="surnames">Apellido:</label>
                                                <input class="form-control" type="text" name="surnames" id="surnames" value="<?php echo $apellidoperso; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="dni">DNI:</label>
                                                <input class="form-control" type="text" name="dni" id="dni" value="<?php echo $dniperso; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="contrasenia">Contraseña:</label>
                                                <input class="form-control" type="text" name="contrasenia" id="contrasenia" value="<?php echo $passwordperso; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="address">Direccion:</label>
                                                <input class="form-control" type="text" name="address" id="address" value="<?php echo $direccionperso; ?>" readonly>
                                            </div>
                                            <div class="col col-12 col-md-6">
                                                <label class="form-label" for="phone">Telefono:</label>
                                                <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $telefonoperso; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
                    

            <footer class="sticky-footer" style="background-color: #002349;">
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