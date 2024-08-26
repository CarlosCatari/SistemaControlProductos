<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $model = new LocalModel();
    include('../est/header.php');
?>
<body>
    <nav class="navbar navbar-expand-lg bg-primary">    
        <div>
            <a class="navbar-brand fw-bold" href="admcategoria.php">
                <img src="../icons/izquierda.png" alt="atras" style="width: 20px;"> Atras
            </a>
        </div>
    </nav>  

    <div class="container mt-3">
        <?php   
            if (isset($_POST['codigocategoria'])) {
                $codigocategoria = $_POST['codigocategoria'];
            }
            foreach ($model-> buscarIdCategoria($codigocategoria) as $r):
                $idcategoria = $r->__get('idcategoria');
                $titulocategoria = $r->__get('titulocategoria');
            endforeach;
        ?>
        <form action="admcategoria.php" method="post" class="p-3">
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="cdcategoria">Codigo</label>
                    <input type="text" name="cdcategoria" class="form-control border-danger bg-light rounded-3" value="<?php echo $idcategoria; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="nombrecategoria">Titulo</label>
                    <input type="text" name="nombrecategoria" class="form-control border-danger bg-light rounded-3" value="<?php echo $titulocategoria; ?>" disabled>
                </div>
                <div class="col-md-6 form-group"></div>
            </div>
            <div class="form-group">
                <input type="submit" value="Eliminar Definitivamente" class="btn btn-danger">
            </div>
        </form>
    </div>
</body>
<?php include('../est/footer.php'); ?>