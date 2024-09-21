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
$page = new Head('Proveedores');

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
        //  Agregar una proveedor
        if (isset($_POST["rucprove"])) {
            $rucprove = $_POST["rucprove"];
            $nombreprove = $_POST["nombreprove"];
            $tipoprove = $_POST["tipoprove"];
            $direccionprove = $_POST["direccionprove"];
            $telefonoprove = $_POST["telefonoprove"];
            $correoprove = $_POST["correoprove"];

            $data = new Local();
            $data->__set('ruc', $rucprove);
            $data->__set('nombre', $nombreprove);
            $data->__set('tipo', $tipoprove);
            $data->__set('direccion', $direccionprove);
            $data->__set('telefono', $telefonoprove);
            $data->__set('correo', $correoprove);
            $model->agregarProveedor($data);

            $newproveedor = strtoupper($nombreprove);
            $_SESSION['msjaddprov'] = 'Proveedor ' . $newproveedor . ' agregado correctamente.';
            header(header: 'Location: admproveedor.php');
            exit;
        }   
    } elseif (isset($_POST['tokendlt']) && $_POST['tokendlt'] === $_SESSION['tokendlt']) {
        // Eliminación de una proveedor
        if (isset($_POST['codigoprov'])) {
            $idproveedor = $_POST['codigoprov'];
            $model->eliminarProveedor(idproveedor: $idproveedor);
            $_SESSION['msjdeleteprov'] = 'Proveedor eliminado correctamente.';
            header(header: 'Location: admproveedor.php');
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
        <?php echo $NavVertical->renderNavbar(); ?>
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #400057;">
            <div id="content">
                <?php echo $NavHorizontal->renderNavbar(); ?>
                <div class="container-fluid">
                    <div class="row">
                        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <!---------- Modal Agregar Categoría ---------->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Proveedor</button>
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Nuevo Proveedor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-1">
                                                <form action="admproveedor.php" id="FormAddProv" method="post" class="px-3">
                                                    <div class="row mb-1">
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="rucprove" class="mb-0 mt-1">RUC:</label>
                                                            <input type="text" name="rucprove" id="rucprove" class="form-control border-primary rounded-3" placeholder="RUC" required>
                                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars(string: $_SESSION['token']); ?>">
                                                            <label for="nombreprove" class="mb-0 mt-1">Empresa/Representante:</label>
                                                            <input type="text" name="nombreprove" id="nombreprove" class="form-control border-primary rounded-3" placeholder="Empresa o Representante"  required>
                                                            <label for="tipoprove" class="mb-0 mt-1">Tipo:</label>
                                                            <input type="text" name="tipoprove" id="tipoprove" class="form-control border-primary rounded-3" placeholder="Tipo o rubro" required>
                                                            <label for="direccionprove" class="mb-0 mt-1">Dirección:</label>
                                                            <input type="text" name="direccionprove" id="direccionprove" class="form-control border-primary rounded-3" placeholder="Dirección actual"  required>
                                                            <label for="telefonoprove" class="mb-0 mt-1">Telefono:</label>
                                                            <input type="text" name="telefonoprove" id="telefonoprove" class="form-control border-primary rounded-3" placeholder="Telefono" required>
                                                            <label for="correoprove" class="mb-0 mt-1">Correo:</label>
                                                            <input type="text" name="correoprove" id="correoprove" class="form-control border-primary rounded-3" placeholder="Correo" required>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button form="FormAddProv" type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form class="d-inline-block form-inline ml-auto mw-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" name="searchprovee" class="form-control bg-light border-0 small" placeholder="Buscar proveedor" aria-label="Search" aria-describedby="basic-addon2">
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
                                <h6 class="m-0 font-weight-bold text-primary">Listar Proveedores</h6>
                            </div>
                            <div class="card-body">
                                <!--------------------------- Alertas -------------------------->
                                <?php if (!empty($_SESSION['msjaddprov'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjaddprov']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjaddprov']); ?>
                                <?php endif; ?>

                                <?php if (!empty($_SESSION['msjdeleteprov'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjdeleteprov']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjdeleteprov']); ?>
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
                                                <th class="col-2 text-center align-middle">RUC</th>
                                                <th class="col-3 text-center align-middle">Empresa/Representante</th>
                                                <th class="col-1 text-center align-middle">Tipo</th>
                                                <th class="col-2 text-center align-middle">Dirección</th>
                                                <th class="col-1 text-center align-middle">Telefono</th>
                                                <th class="col-1 text-center align-middle">Correo</th>
                                                <th class="col-1 text-center align-middle">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->listarProveedor() as $r):
                                                $idproveedor = $r->__get('idproveedor');
                                                $ruc = $r->__get('ruc');
                                                $nombre = $r->__get('nombre');
                                                $tipo = $r->__get('tipo');
                                                $direccion = $r->__get('direccion');
                                                $telefono = $r->__get('telefono');
                                                $correo = $r->__get('correo');
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?php echo $idproveedor; ?></td>
                                                    <td class="align-middle"><?php echo $ruc; ?></td>
                                                    <td class="align-middle"><?php echo $nombre; ?></td>
                                                    <td class="align-middle"><?php echo $tipo; ?></td>
                                                    <td class="align-middle text-center"><?php echo $direccion; ?></td>
                                                    <td class="align-middle text-center"><?php echo $telefono; ?></td>
                                                    <td class="align-middle"><?php echo $correo; ?></td>

                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-around align-items-stretch">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $idproveedor; ?>">Editar</button>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $idproveedor; ?>">Eliminar</button>

                                                            <!---------- Modal Editar Proveedor ---------->
                                                            <div class="modal fade" id="editModal<?php echo $idproveedor; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $idproveedor; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $idproveedor; ?>">Editar Proveedor</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <form action="admproveedor.php" id="FormEditCat<?php echo $idproveedor; ?>" method="post" class="p-3">
                                                                                <div class="container-fluid">
                                                                                    <div class="mb-2 form-group text-left d-flex">
                                                                                        <div class="col-6 m-0 pl-0">
                                                                                            <label for="modcodcat">Codigo:</label>
                                                                                            <input type="hidden" name="tokenedit" value="<?php echo $_SESSION['tokenedit']; ?>">
                                                                                            <input type="text" id="modcodcat" name="modcodcat" class="form-control border-primary rounded-3" value="<?php echo $idproveedor; ?>" readonly>
                                                                                        </div>
                                                                                        <div class="col-6 m-0 p-0">
                                                                                            <label for="rucprove">RUC:</label>
                                                                                            <input type="text" name="rucprove" id="rucprove" class="form-control border-primary rounded-3" placeholder="RUC" required>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="nombreprove" class="mb-0 mt-1">Empresa/Representante:</label>
                                                                                        <input type="text" name="nombreprove" id="nombreprove" class="form-control border-primary rounded-3" placeholder="Empresa o Representante"  required>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="tipoprove" class="mb-0 mt-1">Tipo:</label>
                                                                                        <input type="text" name="tipoprove" id="tipoprove" class="form-control border-primary rounded-3" placeholder="Tipo o rubro" required>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="direccionprove" class="mb-0 mt-1">Dirección:</label>
                                                                                        <input type="text" name="direccionprove" id="direccionprove" class="form-control border-primary rounded-3" placeholder="Dirección actual"  required>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="telefonoprove" class="mb-0 mt-1">Telefono:</label>
                                                                                        <input type="text" name="telefonoprove" id="telefonoprove" class="form-control border-primary rounded-3" placeholder="Telefono" required>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">                                                                          
                                                                                        <label for="correoprove" class="mb-0 mt-1">Correo:</label>
                                                                                        <input type="text" name="correoprove" id="correoprove" class="form-control border-primary rounded-3" placeholder="Correo" required>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" form="FormEditCat<?php echo $idproveedor; ?>" class="btn btn-primary">Guardar Cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!---------- Modal Eliminar Categoría ---------->
                                                            <div class="modal fade" id="deleteModal<?php echo $idproveedor; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $idproveedor; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $idproveedor; ?>">Confirmar Eliminación</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>¿Estás seguro de que deseas eliminar este Proveedor:<br><strong><?php echo $nombre; ?></strong>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="admproveedor.php" method="post">
                                                                                <input type="hidden" name="tokendlt" value="<?php echo $_SESSION['tokendlt']; ?>">
                                                                                <input type="hidden" name="codigoprov" value="<?php echo $idproveedor; ?>">
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