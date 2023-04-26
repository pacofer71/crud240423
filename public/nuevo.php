<?php
session_start();
require_once __DIR__ . "/../vendor/autoload.php";

use Src\{Articulo, Categoria};

function mostrarErrores($nombre)
{
    if (isset($_SESSION[$nombre])) {
        echo "<p class='mt-2 text-danger italic text-sm'>{$_SESSION[$nombre]}</p>";
        unset($_SESSION[$nombre]);
    }
}
$tipos_mime = ['image/bmp', 'image/webp', 'image/gif', 'image/png', 'image/jpeg', 'image/x-icon', 'image/svg-xml'];

$categorias = Categoria::read();
if (isset($_POST['env'])) {
    $nombre = trim($_POST['nombre']);
    $precio = trim($_POST['precio']); //"45"
    $category_id = $_POST['category_id'];
    $disponible = isset($_POST['disponible']) ? $_POST['disponible'] : "Error";
    
    $editando = false;
    $id = null;

    //var_dump($_FILES['imagen']);
    //die();

    // VALIDACIONES
    require __DIR__ . "/../src/errores.php";
    //FIN VALIDACIONES

    if ($errores) {
        header("Location:nuevo.php");
        die();
    }
    //No hay errores
    (new Articulo)
        ->setNombre($nombre)
        ->setDisponible($disponible)
        ->setCategory_id($category_id)
        ->setImagen($nombreImagen)
        ->setPrecio($precio)
        ->create();
    $_SESSION['mensaje'] = "Articulo Guardado";
    header("Location:index.php");
    die();
} else {
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
        <title>nuevo</title>
    </head>

    <body style="background-color:bisque">
        <h4 class="my-2 text-center">Crear Artículo</h4>
        <div class="container">
            <form name="a" action="nuevo.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="n" class="form-label">Nombre Artículo</label>
                    <input type="text" class="form-control" id="n" placeholder="Nombre ..." name="nombre" />
                    <?php
                    mostrarErrores('err_nombre');
                    ?>
                </div>
                <div class="mb-3">
                    <label for="p" class="form-label">Precio Artículo (€)</label>
                    <input type="number" class="form-control" id="n" placeholder="Precio ..." name="precio" step="0.01" min=10 max="9999" />
                    <?php
                    mostrarErrores('err_precio');
                    ?>
                </div>
                <div class="mb-3">
                    <label for="c" class="form-label">Categoria Articulo</label>
                    <select class="form-control" id="c" name="category_id">
                        <option value='-1'>____ Elige una Categoría ____</option>
                        <?php
                        foreach ($categorias as $item)
                            echo "<option value='{$item->id}'>{$item->nombre}</option>" . PHP_EOL;
                        ?>
                    </select>
                    <?php
                    mostrarErrores('err_categoria');
                    ?>
                </div>
                <div>
                    <label class="form-check-label" for="d1">Articulo Disponible</label>
                </div>
                <div class="form-check form-check-inline mb-3">
                    <input class="form-check-input" type="radio" name="disponible" id="d1" value="SI">
                    <label class="form-check-label" for="d1">SI</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="disponible" id="d2" value="NO">
                    <label class="form-check-label" for="d2">NO</label>
                </div>
                <?php
                mostrarErrores('err_disponible');
                ?>
                <div class="mb-3">
                    <label for="i" class="form-label">Imagen Artículo</label>
                    <input type="file" class="form-control" id="i" name="imagen" accept="image/*" />
                    <?php
                    mostrarErrores('err_imagen');
                    ?>
                </div>
                <div class="d-flex flex-row-reverse">
                    <button type="submit" name="env" class="btn btn-primary">
                        <i class='fas fa-save'></i> Guardar
                    </button>&nbsp;
                    <a href="index.php" class="btn btn-warning">
                        <i class="fas fa-backward"></i> Volver
                    </a>
                </div>
            </form>

        </div>
    </body>

    </html>
<?php } ?>