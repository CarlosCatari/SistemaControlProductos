<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();

    /* session_start();
    if (!isset($_SESSION['contador'])) {
        $_SESSION['contador'] = 0;
    }
    $error = '';

    if(isset($_POST["username"])) {
        $verificador = false;
        $verificadoradmin = false;
        foreach ($model->buscarCliente($_REQUEST['username']) as $r) { 
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
        }
        foreach ($model->buscarAdmin($_REQUEST['username']) as $r) { 
            $useradmin = $_POST['username'];
            $passadmin = $_POST['password'];
            $dbuseradmin = $r->__get('dniadmin');
            $dbpwdadmin = $r->__get('pwdadmin');
            $dbnombreadmin = $r->__get('nombreadmin');
        
            if ($useradmin === $dbuseradmin && $passadmin === $dbpwdadmin) {
                $_SESSION['usernameadmin'] = $dbnombreadmin;
                $_SESSION['dniadmin'] = $dbuser;
                $verificadoradmin = true;
                break;
            }
        }
        
        if ($verificador) {
            header('Location: peliculas.php');
        } elseif($verificadoradmin){
            header('Location: ../admin/dashboardadmin.php');
        } else {
            $_SESSION['contador']++;
            if ($_SESSION['contador'] < 4) {
                $error = "Usuario o contraseña incorrectos. Te quedan ".(4 - $_SESSION['contador']) ." intentos";
            } else {
                header('Location: error.php');
                $_SESSION['contador'] = 0;
            }
        }
    } */
    include('../est/header.php');  
?>

<body class="d-flex justify-content-center align-items-center vh-100" style="background-image: url('../images/fondo1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <form action="loguin.php" method="post">
        <div class="bg-white p-5 rounded-5 text-secondary position-relative" style="width:25rem">
            <a class="text-decoration-none text-primary fw-semibold display-6 position-absolute top-0 end-0 px-4 pt-2" href="../index.php">X</a>
            <div class="d-flex justify-content-center">
                <img class="opacity-50" src="../icons/usuario.png" alt="login" style="height:7rem">
            </div>
            <div class="text-center fs-1 fw-bold">Log in</div>
            <?php
                if (!empty($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            ?>
            <div class="input-group mt-3">
                <div class="input-group-text bg-primary">
                    <img src="../icons/username.png" alt="username" style="height:1rem">
                </div>
                <input class="form-control" name="username" type="text" placeholder="Nº de documento" pattern="[0-9]{8}" minlength="7" maxlength="8" required>
            </div>
            <div class="input-group mt-1">
                <div class="input-group-text bg-primary">
                    <img src="../icons/candado.png" alt="username" style="height:1rem">
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
</body>
<?php include('../est/footer.php'); ?>
