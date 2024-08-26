<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();
    include('../est/header.php');
    session_start();

    if (isset($_POST['codigocategoria'])) {
        $codigocategoria = $_POST['codigocategoria'];
    }
    foreach ($model-> buscarIdCategoria($codigocategoria) as $r):
        $idcategoria = $r->__get('idcategoria');
        $titulocategoria = $r->__get('titulocategoria');
    endforeach;
?>
<body>
    <nav class="navbar navbar-expand-lg bg-primary">    
        <div>
            <a class="navbar-brand fw-bold" href="admclientes.php">
                <img src="../icons/izquierda.png" alt="atras" style="width: 20px;"> Atras
            </a>
        </div>
    </nav>  
    <div class="container mt-3">
        <form action="admcategoria.php" method="post" class="p-3">
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="codcategoria">Codigo</label>
                    <input type="text" name="codcategoria" class="form-control border-primary bg-light rounded-3" value="<?php echo $idcategoria; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="nombrecategoria">Titulo</label>
                    <input type="text" name="nombrecategoria" class="form-control border-primary rounded-3" value="<?php echo $titulocategoria; ?>" placeholder="Titulo de categoria" pattern="[a-zA-Z\]+" required>
                </div>
                <div class="col-md-6 form-group"></div>
            </div>
            <div class="form-group">
                <input type="submit" value="Guardar" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
<?php include('../est/footer.php'); ?>