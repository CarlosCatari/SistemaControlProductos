<?php
require_once "../mvc/conectar.php";
require_once "../mvc/Local.Model.php";
require_once "../mvc/Local.entidad.php";
$loc = new local();
$model = new LocalModel();

session_start();
$user = $_SESSION['usernameadmin'];

include_once '../est/verticalnav.php';
$NavVertical = new NavVertical();

include_once '../est/horizontalnav.php';
$NavHorizontal = new NavHorizontal($user);

require_once '../est/head.php';
$page = new Head('Categorias');

if (isset($_POST["codcategoria"])) {
    $idcategoria = $_POST["codcategoria"];
    $titulocategoria = $_POST["nombrecategoria"];

    $data = new Local();
    $data->__set('idcategoria', $idcategoria);
    $data->__set('titulocategoria', $titulocategoria);

    $model->actualizarIdCategoria($data);
    $category = strtoupper($titulocategoria);
    $msjmodificacion = 'Categoria ' . $category . ' modificada correctamente.';
}
if (isset($_POST["cdcategoria"])) {
    $idcategoria = $_POST['cdcategoria'];
    $model->eliminarCategoria($idcategoria);
    $msjeliminacion = 'Categoria eliminada.';
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
                        <h1 class="h3 mb-0 text-gray-800">Categorias</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <li class="nav-item btn btn-primary me-auto">
                                    <a href="addcategoria.php" class="text-white text-decoration-none">Agregar Categoria</a>
                                </li>
                                <form class="d-inline-block form-inline ml-auto mw-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar categoria"
                                            aria-label="Search" aria-describedby="basic-addon2">
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
                                <h6 class="m-0 font-weight-bold text-primary">Listar Categorias</h6>
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
                                                <th class="col-8 text-center align-middle">Categoria</th>
                                                <th class="col-3 text-center align-middle">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->listarCategoria() as $r):
                                                $idcategoria = $r->__get('idcategoria');
                                                $categoria = $r->__get('titulocategoria');
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?php echo $idcategoria; ?></td>
                                                    <td class="align-middle"><?php echo $categoria; ?></td>
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-around align-items-stretch">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $idcategoria; ?>">Editar</button>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $idcategoria; ?>">Eliminar</button>

                                                            <!---------- Modal Editar Categoría ---------->
                                                            <div class="modal fade" id="editModal<?php echo $idcategoria; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $idcategoria; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $idcategoria; ?>">Editar Categoria</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="#" method="post" class="p-3">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-12 form-group text-left">
                                                                                        <label for="namecategoria">Categoria</label>
                                                                                        <!-- Input pre-llenado con el nombre de la categoría -->
                                                                                        <input type="text" name="namecategoria" class="form-control border-primary rounded-3" value="<?php echo $categoria; ?>" placeholder="Titulo de categoria" pattern="[a-zA-Z\s]+" required>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="button" class="btn btn-primary">Guardar Cambios</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!---------- Modal Eliminar Categoría ---------->
                                                            <div class="modal fade" id="deleteModal<?php echo $idcategoria; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $idcategoria; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $idcategoria; ?>">Confirmar Eliminación</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>¿Estás seguro de que deseas eliminar la categoría:<br><strong><?php echo $categoria; ?></strong>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="dltcategoria.php" method="post">
                                                                                <input type="hidden" name="codigocategoria" value="<?php echo $idcategoria; ?>">
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

    <script src="../icon/jquery/jquery.min.js"></script>
    <script src="../icon/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../icon/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../icon/chart.js/Chart.min.js"></script>
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>
</body>

</html>