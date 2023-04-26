<?php
session_start();
require_once __DIR__ . "/../vendor/autoload.php";

use Src\{Categoria, Articulo};

Categoria::crearCategorias(10);
Categoria::devolverCategoryId();
Articulo::crearArticulos(50);
$articulos = Articulo::readParcial();
if (isset($_POST['btnborrar'])) {
    $id = $_POST['id'];

    $imagen = (new Articulo)->setId($id)->getImagen();  // "/img/sdfsdfdsfs.jpg";
    unlink(__DIR__ . $imagen);

    (new Articulo)->setId($id)->delete();
    $_SESSION['mensaje'] = "Registro Borrado";
    header("Location:index.php");
    //die();
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
        <title>inicio</title>
    </head>

    <body style="background-color:bisque">
        <h4 class="my-2 text-center">Listado de Articulos</h4>
        <div class="container">
            <div class="d-flex flex-row-reverse mb-2">
                <a href="nuevo.php" class="btn btn-success">
                    <i class="fas fa-add"></i> Nuevo
                </a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">INFO</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">DISPONIBE</th>
                        <th scope="col">PVP (€)</th>
                        <th scope="col">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($articulos as $item) {
                        echo <<<TXT
                        <tr>
                        <th scope="row">
                        <a href="detalle.php?id={$item->id}" class="btn btn-info btn-sm">
                        <i class="fas fa-edit"></i>
                        </a>
                        </th>
                        <td>{$item->nombre}</td>
                        <td>{$item->disponible}</td>
                        <td>{$item->precio}</td>
                        <td>
                        <form name='a' method="POST" action="index.php">
                        <input type="hidden" name="id" value="{$item->id}" />
                        <a href="editar.php?id={$item->id}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                        </a>
                        <button type="submit" class="btn btn-danger btn-sm" name="btnborrar">
                        <i class="fas fa-trash"></i>
                        </button>
                        </form>
                        </td>
                    </tr>
                    TXT;
                    }
                    ?>

                </tbody>
            </table>
        </div>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo <<<TXT
            <script>
            Swal.fire({
                icon: 'success',
                title: '{$_SESSION['mensaje']}',
                showConfirmButton: false,
                timer: 1500
              })
            </script>
            TXT;
            unset($_SESSION['mensaje']);
        }
        ?>
    </body>

    </html>
<?php } ?>