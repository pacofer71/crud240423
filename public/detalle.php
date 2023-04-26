<?php
    require_once __DIR__ . "/../vendor/autoload.php";
    use Src\Articulo;
    if(!isset($_GET['id'])){
        header("Location:index.php");
        die();
    }
    $id=$_GET['id'];
    $articulo=(new articulo)->setId($id)->detalleArticulo();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CDN BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- CDN FONTAWesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CDN SWEEALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>detalle</title>
</head>

<body style="background-color:bisque">
    <h4 class="my-2 text-center">Detalle Articulo</h4>
    <div class="container">
        <div class="card mx-auto" style="width: 24rem;">
            <img src="<?php echo "/crud190423/public".$articulo->imagen ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $articulo->nombre; ?></h5>
                <p class="card-text"><b>Categoria: </b><?php echo $articulo->nomcat; ?></p>
                <p class="card-text"><b>Precio: </b><?php echo $articulo->precio; ?> €</p>
                <p class="card-text"><b>Disponible: </b><?php echo $articulo->disponible; ?></p>
                <button class="btn btn-primary" onclick="history.back()">VOLVER</button
                >
            </div>
        </div>
    </div>
</body>

</html>