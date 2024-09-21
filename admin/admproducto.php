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
$page = new Head('Productos');

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
    //  Agregar una Productos
    if (isset($_POST['token']) && $_POST['token'] === $_SESSION['token']) {
        if (isset($_POST["tituloprod"])) {
            $tituloprod = $_POST["tituloprod"];
            $categoriaprod = $_POST["categoriaprod"];
            $descripcionprod = $_POST["descripcionprod"];
            $precioprod = $_POST["precioprod"];
            $stockprod = $_POST["stockprod"];
            $proveedorprod = $_POST["proveedorprod"];

            $data = new Local();
            $data->__set('tituloproducto', $tituloprod);
            $data->__set('categoria_id', $categoriaprod);
            $data->__set('descripcion', $descripcionprod);
            $data->__set('precio', $precioprod);
            $data->__set('stock', $stockprod);
            $data->__set('proveedor_id', $proveedorprod);
            $model->agregarProducto($data);

            $newproducto = strtoupper($tituloprod);
            $_SESSION['msjaddprod'] = 'Producto ' . $newproducto . ' agregado correctamente.';
            header(header: 'Location: admproducto.php');
            exit;
        }
    // Eliminación de Productos
    } elseif (isset($_POST['tokendlt']) && $_POST['tokendlt'] === $_SESSION['tokendlt']) {
        if (isset($_POST['codigoprod'])) {
            $idproducto = $_POST['codigoprod'];
            $model->eliminarProducto(idproducto: $idproducto);
            $_SESSION['msjdeleteprod'] = 'Producto eliminado correctamente.';
            header(header: 'Location: admproducto.php');
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
                        <h1 class="h3 mb-0 text-gray-800">Productos</h1>
                    </div>
                    <div class="row">
                        <div class="navbar navbar-expand navbar-light topbar mb-2 static-top shadow w-100">
                            <div class="d-flex w-100">
                                <!---------- Modal Agregar Producto ---------->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Producto</button>
                                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Nuevo Producto</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-1">
                                                <form action="admproducto.php" id="FormAddProd" method="post" class="px-3">
                                                    <div class="row mb-1">
                                                        <div class="col-md-12 form-group text-left">
                                                            <label for="tituloprod" class="mb-0 mt-1">Producto:</label>
                                                            <input type="text" name="tituloprod" id="tituloprod" class="form-control border-primary rounded-3" placeholder="Titulo del producto" required>
                                                            <input type="hidden" name="token" value="<?php echo htmlspecialchars(string: $_SESSION['token']); ?>">

                                                            <label for="categoriaprod" class="mb-0 mt-1">Categoria</label>
                                                            <select class="form-control border-primary rounded-3" name="categoriaprod" id="categoriaprod" aria-label="Default select example">
                                                                <option value="" disabled selected>Seleccionar Categoria</option>
                                                                <?php foreach ($model->listarCategoria() as $r):
                                                                    $idcategoria = $r->__get('idcategoria');
                                                                    $categoria = $r->__get('titulocategoria');
                                                                ?>
                                                                <option value="<?php echo $idcategoria; ?>">
                                                                    <?php echo $categoria; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                            <div class="mb-3">
                                                                <label for="descripcionprod" class="form-label">Descripción:</label>
                                                                <textarea class="form-control border-primary rounded-3" name="descripcionprod" id="descripcionprod" placeholder="Breve descripción del producto" rows="3"></textarea>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <div class="col-6">
                                                                    <label for="precioprod" class="form-label">Precio:</label>
                                                                    <input type="text" name="precioprod" id="precioprod" class="form-control border-primary rounded-3" placeholder="S/. 00.00" required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="stockprod" class="form-label">Stock:</label>
                                                                    <input type="text" name="stockprod" id="stockprod"  class="form-control border-primary rounded-3" placeholder="Cantidad en almacén" required>
                                                                </div>
                                                            </div>
                                                            <label for="proveedorprod" class="mb-0 mt-1">Proveedor:</label>
                                                            <select class="form-control border-primary rounded-3" name="proveedorprod" id="proveedorprod" aria-label="Default select example">
                                                                <option value="" disabled selected>Seleccionar Proveedor</option>
                                                                <?php foreach ($model->listarProveedor() as $r):
                                                                    $idproveedor = $r->__get('idproveedor');
                                                                    $nombreproveedor = $r->__get('nombre');
                                                                ?>
                                                                <option value="<?php echo $idproveedor; ?>">
                                                                    <?php echo $nombreproveedor; ?>
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button form="FormAddProd" type="submit" class="btn btn-primary">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form class="d-inline-block form-inline ml-auto mw-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" name="searchproduct" class="form-control bg-light border-0 small" placeholder="Buscar categoria"
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
                                <h6 class="m-0 font-weight-bold text-primary">Listar Productos</h6>
                            </div>
                            <div class="card-body">
                                <!--------------------------- Alertas -------------------------->
                                <?php if (!empty($_SESSION['msjaddprod'])): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjaddprod']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjaddprod']); ?>
                                <?php endif; ?>

                                <?php if (!empty($_SESSION['msjdeleteprod'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['msjdeleteprod']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msjdeleteprod']); ?>
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
                                                <th class="col-3 text-center align-middle">Producto</th>
                                                <th class="col-1 text-center align-middle">Categoria</th>
                                                <th class="col-3 text-center align-middle">Descripción</th>
                                                <th class="col-1 text-center align-middle">Precio</th>
                                                <th class="col-1 text-center align-middle">Stock</th>
                                                <th class="col-1 text-center align-middle">Proveedor</th>
                                                <th class="col-1 text-center align-middle">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($model->listarProducto() as $r):
                                                $idproducto = $r->__get('idproducto');
                                                $tituloproducto = $r->__get('tituloproducto');
                                                $categoria = $r->__get('categoria');
                                                $descripcion = $r->__get('descripcion');
                                                $precio = $r->__get('precio');
                                                $stock = $r->__get('stock');
                                                $proveedor = $r->__get('proveedor');
                                            ?>
                                                <tr>
                                                    <td class="text-center align-middle"><?php echo $idproducto; ?></td>
                                                    <td class="align-middle"><?php echo $tituloproducto; ?></td>
                                                    <td class="align-middle"><?php echo $categoria; ?></td>
                                                    <td class="align-middle"><?php echo $descripcion; ?></td>
                                                    <td class="align-middle text-center"><?php echo $precio; ?></td>
                                                    <td class="align-middle text-center"><?php echo $stock; ?></td>
                                                    <td class="align-middle"><?php echo $proveedor; ?></td>

                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-around align-items-stretch">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal<?php echo $idproducto; ?>">Editar</button>
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $idproducto; ?>">Eliminar</button>

                                                            <!---------- Modal Editar Producto ---------->
                                                            <div class="modal fade" id="editModal<?php echo $idproducto; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $idproducto; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $idproducto; ?>">Editar Producto</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <form action="admproducto.php" id="FormEditCat<?php echo $idproducto; ?>" method="post" class="p-3">
                                                                                <div class="container-fluid">

                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <input type="hidden" name="token" value="<?php echo htmlspecialchars(string: $_SESSION['token']); ?>">
                                                                                        <label for="tituloprod" class="mb-0 mt-1">Producto:</label>
                                                                                        <input type="text" name="tituloprod" id="tituloprod" class="form-control border-primary rounded-3" value="<?php echo $tituloproducto; ?>" placeholder="Titulo del producto" required>
                                                                                        
                                                                                    </div>

                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="categoriaprod" class="mb-0 mt-1">Categoria</label>
                                                                                        <select class="form-control border-primary rounded-3" name="categoriaprod" id="categoriaprod" aria-label="Default select example">
                                                                                            <option value="" disabled selected>Seleccionar Categoria</option>
                                                                                            <?php foreach ($model->listarCategoria() as $r):
                                                                                                $idcategoria = $r->__get('idcategoria');
                                                                                                $categoria = $r->__get('titulocategoria');
                                                                                            ?>
                                                                                            <option value="<?php echo $idcategoria; ?>">
                                                                                                <?php echo $categoria; ?>
                                                                                            </option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="descripcionprod" class="form-label">Descripción:</label>
                                                                                        <textarea class="form-control border-primary rounded-3" name="descripcionprod" id="descripcionprod" placeholder="Breve descripción del producto" rows="3"><?php echo $descripcion; ?></textarea>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left d-flex">
                                                                                        <div class="col-6 pl-0">
                                                                                            <label for="precioprod" class="form-label">Precio:</label>
                                                                                            <input type="text" name="precioprod" id="precioprod" class="form-control border-primary rounded-3" value="<?php echo $precio; ?>" placeholder="S/. 00.00" required>
                                                                                        </div>
                                                                                        <div class="col-6 p-0">
                                                                                            <label for="stockprod" class="form-label">Stock:</label>
                                                                                            <input type="text" name="stockprod" id="stockprod"  class="form-control border-primary rounded-3" value="<?php echo $stock; ?>" placeholder="Cantidad en almacén" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="mb-2 form-group text-left">
                                                                                        <label for="proveedorprod" class="mb-0 mt-1">Proveedor:</label>
                                                                                        <select class="form-control border-primary rounded-3" name="proveedorprod" id="proveedorprod" aria-label="Default select example">
                                                                                            <option value="" disabled selected>Seleccionar Proveedor</option>
                                                                                            <?php foreach ($model->listarProveedor() as $r):
                                                                                                $idproveedor = $r->__get('idproveedor');
                                                                                                $nombreproveedor = $r->__get('nombre');
                                                                                            ?>
                                                                                            <option value="<?php echo $idproveedor; ?>">
                                                                                                <?php echo $nombreproveedor; ?>
                                                                                            </option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
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

                                                            <!---------- Modal Eliminar Producto ---------->
                                                            <div class="modal fade" id="deleteModal<?php echo $idproducto; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?php echo $idproducto; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $idproducto; ?>">Confirmar Eliminación</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>¿Estás seguro de que deseas eliminar este Proveedor:<br><strong><?php echo $tituloproducto; ?></strong>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="admproducto.php" method="post">
                                                                                <input type="hidden" name="tokendlt" value="<?php echo $_SESSION['tokendlt']; ?>">
                                                                                <input type="hidden" name="codigoprod" value="<?php echo $idproducto; ?>">
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