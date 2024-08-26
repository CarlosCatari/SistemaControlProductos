<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();
    include('../est/header.php');
?>

<body>
    <nav class="navbar navbar-expand-lg bg-primary mb-3">    
        <div>
            <a class="navbar-brand fw-bold" href="admcategoria.php">
                <img src="../icons/izquierda.png" alt="atras" style="width: 20px;"> Atras
            </a>
        </div>
    </nav> 
    
    <div class="ms-3 h4">Resultado de Búsqueda</div>

    <?php if (!empty($msjcliente)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $msjcliente; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <?php if (!empty($mensajeclientedlt)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $mensajeclientedlt; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="container-fluid w-100">
        <table class="table table-bordered text-center">
            <tr>
                <th>Codigo</th>
                <th>Titulo</th>
                <th>Acciones</th>
            </tr>
            <?php
            $DisableButton = false; 
            if(isset($_POST["titulocategoria"])) {
                $resultado = $model->buscarCategoria($_REQUEST['titulocategoria']);
                if (empty($resultado)) {
                    echo '<div class="alert alert-warning" role="alert">¡Categoria no registrada!</div>';
                    $DisableButton = true; 
                } else {
                    foreach ($resultado as $r) { 
                        ?>
                        <tr> 
                            <td class="align-middle col-3"><?php echo $r->__get('idcategoria'); ?></td>
                            <td class="align-middle col-6"><?php echo $r->__get('titulocategoria'); ?></td>
                            <td class="align-middle col-3">
                                <div class="d-flex justify-content-around align-items-stretch">
                                    <form action="editclientes.php" method="post">
                                        <input type="hidden" name="codigocliente" id="codigocliente" value="<?php echo $r->__get('idcategoria'); ?>">
                                        <input type="submit" class="btn btn-info flex-fill mx-1" value="Editar" <?php if ($DisableButton) echo 'disabled'; ?>>
                                    </form>
                                    <form action="dltclientes.php" method="post">
                                        <input type="hidden" name="codigocliente" id="codigocliente" value="<?php echo $r->__get('idcategoria'); ?>">
                                        <input type="submit" class="btn btn-danger flex-fill mx-1" value="Eliminar" <?php if ($DisableButton) echo 'disabled'; ?>>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </table>
    </div>
</body>
<?php include('../est/footer.php'); ?>
