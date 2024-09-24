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
}
$NavPages = new NavPages();
$NavHorizontal = new NavHorizontal($user);
$page = new Head('Proveedor');
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
                        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
                    </div>


                    <div class="row mt-3">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold" style="color: #002349;">Listar Proveedores</h6>
                            </div>
                            <div class="card-body">

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