<?php
    require_once "../mvc/conectar.php";
    require_once "../mvc/Local.Model.php";
    require_once "../mvc/Local.entidad.php";
    $loc = new local();
    $model = new LocalModel();
    include('../est/header.php');

    if(isset($_POST["namecategoria"])) {
        $titulocategoria = $_POST["namecategoria"];
        $data = new Local();
        $data->__set('titulocategoria', $titulocategoria);
        $model->agregarCategoria($data);
        $category = strtoupper($titulocategoria);
        $msj = 'Categoria '. $category.' agregado correctamente.';
    }
?>
<body>
    <nav class="navbar navbar-expand-lg bg-primary">    
        <div>
            <a class="navbar-brand fw-bold" href="admcategoria.php">
                <img src="../icons/izquierda.png" alt="atras" style="width: 20px;"> Atras
            </a>
        </div>
    </nav> 
    
    <?php if (!empty($msj)): ?>
        <div class="alert alert-info" role="alert">
            <?php echo $msj; ?>
        </div>
    <?php endif; ?>

    <div class="container mt-3">
        <form action="addcategoria.php" method="post" class="p-3">
            <div class="row mb-3">
                <div class="col-md-6 form-group">
                    <label for="namecategoria">Categoria</label>
                    <input type="text" name="namecategoria" class="form-control border-primary rounded-3" placeholder="Titulo de categoria" pattern="[a-zA-Z\s]+" required>
                    </div><div class="col-md-6 form-group">
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="Agregar" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>
<?php include('../est/footer.php'); ?>