<?php
    require_once "mvc/conectar.php";
    require_once "mvc/Local.Model.php";
    require_once "mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();

    require_once 'est/head.php';
    $page = new Head('Login');

    session_start();
    if (!isset($_SESSION['contador'])) {
        $_SESSION['contador'] = 0;
    }
    $error = '';

    if(isset($_POST["username"])) {
        /* $verificador = false; */
        $verificadoradmin = false;
        /* foreach ($model->buscarCliente($_REQUEST['username']) as $r) { 
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $dbuser = $r->__get('dni');
            $dbpwd = $r->__get('pwd');
            $dbnombre = $r->__get('nombre');
        
            if ($user === $dbuser && $pass === $dbpwd) {
                $_SESSION['username'] = $dbnombre;
                $_SESSION['dni'] = $dbuser;
                $verificador = true;
                break;
            }
        } */
        foreach ($model->buscarUserAdmin($_REQUEST['username']) as $r) { 
            $useradmin = $_POST['username'];
            $passadmin = $_POST['password'];
            $dbuseradmin = $r->__get('dniadmin');
            $dbpwdadmin = $r->__get('passwordadmin');
            $idadmin = $r->__get('idadmin');
        
            if ($useradmin === $dbuseradmin && $passadmin === $dbpwdadmin) {
                $_SESSION['idadmin'] = $idadmin;
                $verificadoradmin = true;
                break;
            }
        }
        
        if ($verificador) {
            header('Location: personal/personalpanel.php');
        } elseif($verificadoradmin){
            header('Location: admin/adminpanel.php');
        } else {
            $_SESSION['contador']++;
            if ($_SESSION['contador'] < 4) {
                $error = "Usuario o contraseña incorrectos. Te quedan ".(4 - $_SESSION['contador']) ." intentos";
            } else {
                header('Location: error.php');
                $_SESSION['contador'] = 0;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./source/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="./source/css/sb-admin-2.min.css" rel="stylesheet">
</head> 
<body class="d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(80,9,121,1) 54%, rgba(196,0,255,1) 100%);">
    <form action="index.php" method="post">
        <div class="bg-white p-5 rounded text-secondary position-relative">
            <div class="d-flex justify-content-center">
                <i class="fa fa-user fa-6x"></i>
            </div>
            <div class="text-center fs-2 fw-bold">Log in</div>
            <?php
                if (!empty($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            ?>
            <div class="input-group mt-3">
                <div class="input-group-text bg-primary">
                    <i class="fa fa-user"></i>
                </div>
                <input class="form-control" name="username" type="text" placeholder="Nº de documento" pattern="[0-9]{8}" minlength="7" maxlength="8" required>
            </div>
            <div class="input-group mt-1">
                <div class="input-group-text bg-primary">
                    <i class="fa fa-solid fa-lock"></i>
                </div>
                <input class="form-control" name="password" type="password" placeholder="Escribe tu contraseña" pattern="[a-zA-Z0-9]+" required>
            </div>
            <div class="d-flex justify-content-around mt-1">
                <div class="d-flex align-items-center gap-1">
                    <input class="form-check-input" type="checkbox">
                    <div class="pt-1" style="font-size:0.9rem">Recordar</div>
                </div>
                <div class="pt-1">
                    <a class="text-decoration-none text-primary fw-semibold fst-italics" style="font-size:0.9rem" href="#">¿No recuerdas tu contraseña?</a>
                </div>
            </div>
            <button type="submit" class="btn btn-primary text-white w-100 mt-4">Ingresar</button>
            <div class="d-flex gap-1 justify-content-center mt-1">
                <div>¿No tienes usuario y contraseña?</div>
                <a class="text-decoration-none text-primary fw-semibold" href="registro.php">Registrar</a>
            </div>
        </div>
    </form>

    <script src="./source/jquery/jquery.min.js"></script>
    <script src="./source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./source/jquery-easing/jquery.easing.min.js"></script>
    <script src="./source/js/sb-admin-2.min.js"></script>
    <script src="./source/chart.js/Chart.min.js"></script>
    <script src="./source/js/demo/chart-area-demo.js"></script>
    <script src="./source/js/demo/chart-pie-demo.js"></script>
</body>
</html>
