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
$page = new Head('Categorias');

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
        //  Agregar una categoría
        if (isset($_POST['titulocategoria'])) {
            $titulocategoria = $_POST['titulocategoria'];
            $data = new Local();
            $data->__set('titulocategoria', $titulocategoria);
            $model->agregarCategoria(data: $data);
            $newcategoria = strtoupper(string: $titulocategoria);
            $_SESSION['msjcategoria'] = 'Categoría ' . $newcategoria . ' agregada correctamente.';
            header(header: 'Location: admcategoria.php');
            exit;
        }
    } elseif (isset($_POST['tokendlt']) && $_POST['tokendlt'] === $_SESSION['tokendlt']) {
        // Eliminación de una categoría
        if (isset($_POST['codigocategoria'])) {
            $idcategoria = $_POST['codigocategoria'];
            $model->eliminarCategoria(idcategoria: $idcategoria);
            $_SESSION['msjdeletecat'] = 'Categoría eliminada correctamente.';
            header(header: 'Location: admcategoria.php');
            exit;
        }
    } elseif (isset($_POST['tokenedit']) && $_POST['tokenedit'] === $_SESSION['tokenedit']) {
        // Actualizacion de una categoría
        if (isset($_POST["modnamecat"])) {
            $idcategorias = $_POST["modcodcat"];
            $titulocategorias = $_POST["modnamecat"];

            $data = new Local();
            $data->__set('idcategoria', $idcategorias);
            $data->__set('titulocategoria', $titulocategorias);

            $model->actualizarCategoria($data);
            $edcategoria = strtoupper(string: $titulocategorias);
            $_SESSION['msjeditcat'] = 'Categoría ' . $edcategoria . ' modificada correctamente.';
            header(header: 'Location: admcategoria.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Categorias</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">

                                <!---------- Modal Agregar Categoría ---------->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Categoria</button>
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Nueva Categoria</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="admcategoria.php" id="FormAddCat" method="post" class="p-3">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="titulocategoria">Categoria</label>
                                                            <input type="text" name="titulocategoria" class="form-control border-primary rounded-3" placeholder="Titulo de categoria" pattern="[a-zA-Z\s]+" required>
                                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars(string: $_SESSION['token']); ?>">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button form="FormAddCat" type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <form class="d-inline-block form-inline ml-auto mw-100 navbar-search">
                                    <div class="input-group">
                                        <input id="searchData" name="searchData" type="text" class="form-control bg-light border-0 small" placeholder="Buscar Categoria" aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button onclick="copiarvalores() , enviarBusqueda()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchModal">
                                                <i onclick="copiarvalores(), enviarBusqueda()" class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>



                                <!---------- Modal Buscar Categoría ---------->
                                <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="searchModalLabel">Resultado de busqueda</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <p>Resultado de busqueda para: <span id="dataSearch"></span></p>
                                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-1 text-center align-middle">Cod.</th>
                                                                <th class="col-8 text-center align-middle">Categoria</th>
                                                                <th class="col-3 text-center align-middle">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $valorbusqueda = "busqueda";
                                                            foreach ($model->buscarCategoria($valorbusqueda) as $r):
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
                                                                                            <form action="#" method="post">

                                                                                                <input type="hidden" name="cdcategoria" value="<?php echo $idcategoria; ?>">
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
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function copiarvalores() {
                                        var labelValue1 = document.getElementById('searchData').value;
                                        document.getElementById('dataSearch').textContent = labelValue1;
                                    }
                                    $('#searchModal').on('show.bs.modal', function(e) {
                                        copiarvalores();
                                    });
                                </script>


                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card shadow mb-4 w-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Listar Categorias</h6>
                            </div>
                            <div class="card-body">
                                <!--------------------------- Alertas -------------------------->
                                <?php if (!empty($_SESSION['msjcategoria'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjcategoria']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjcategoria']); ?>
                                <?php endif; ?>

                                <?php if (!empty($_SESSION['msjdeletecat'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjdeletecat']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjdeletecat']); ?>
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

                                                                            <form action="admcategoria.php" id="FormEditCat<?php echo $idcategoria; ?>" method="post" class="p-3">
                                                                                <div class="row mb-3">
                                                                                    <div class="col-md-12 form-group text-left">
                                                                                        <label for="modnamecat">Codigo:</label>
                                                                                        <input type="hidden" name="tokenedit" value="<?php echo $_SESSION['tokenedit']; ?>">
                                                                                        <input type="text" name="modcodcat" class="form-control border-primary rounded-3" value="<?php echo $idcategoria; ?>" readonly>
                                                                                    </div>

                                                                                    <div class="col-md-12 form-group text-left">
                                                                                        <label for="modnamecat">Categoria</label>
                                                                                        <input type="text" name="modnamecat" class="form-control border-primary rounded-3" value="<?php echo $categoria; ?>" placeholder="Titulo de categoria" pattern="[a-zA-Z\s]+" required>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" form="FormEditCat<?php echo $idcategoria; ?>" class="btn btn-primary">Guardar Cambios</button>
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
                                                                            <form action="admcategoria.php" method="post">
                                                                                <input type="hidden" name="tokendlt" value="<?php echo $_SESSION['tokendlt']; ?>">
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

    <script src="../source/jquery/jquery.min.js"></script>
    <script src="../source/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../source/jquery-easing/jquery.easing.min.js"></script>
    <script src="../source/js/sb-admin-2.min.js"></script>
    <script src="../source/chart.js/Chart.min.js"></script>
    <script src="../source/js/demo/chart-area-demo.js"></script>
    <script src="../source/js/demo/chart-pie-demo.js"></script>
</body>

</html>