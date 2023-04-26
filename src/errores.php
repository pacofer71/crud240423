<?php

use Src\{Articulo, Categoria};

$errores = false;


if (strlen($nombre) < 3) {
    $errores = true;
    $_SESSION['err_nombre'] = "*** El nombre debe contener al menos 3 caracteres";
} else {
    if (Articulo::existeNombre($nombre, $id)) {
        $errores = true;
        $_SESSION['err_nombre'] = "*** Este nombre YA está registrado";
    }
}
if (!is_numeric($precio)) {
    $errores = true;
    $_SESSION['err_precio'] = "*** Precio Inválido";
} else {
    if ($precio < 10 || $precio > 9999.99) {
        $errores = true;
        $_SESSION['err_precio'] = "*** Precio Inválido";
    }
}
if (!in_array($category_id, Categoria::devolverCategoryId())) {
    $errores = true;
    $_SESSION['err_categoria'] = "*** Elija una categoría válida";
}
if (!in_array($disponible, ["SI", "NO"])) {
    $errores = true;
    $_SESSION['err_disponible'] = "*** Error, disponible debe ser SI o NO";
}
//tratamiento imagen
if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {
    if (!in_array($_FILES['imagen']['type'], $tipos_mime)) {
        $errores = true;
        $_SESSION['err_imagen'] = "*** Tipo ed archivo NO permitido";
    } else {
        //he subido un archivo y es de tipo imagen, vamos a guardarlo
        $nombreImagen = "/img/" . uniqid() . "_" . $_FILES['imagen']['name'];
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], __DIR__ . "/../public" . $nombreImagen)) {
            $errores = true;
            $_SESSION['err_imagen'] = "*** NO se pudo guardar la imagen";
        }else{
            unlink(__DIR__ . "/../public" . $articulo->imagen);
        }
    }
} else {
    if ($editando) {
        $nombreImagen=$articulo->imagen;
    } else {
        $errores = true;
        $_SESSION['err_imagen'] = "*** El campo imagen es requerido";
    }
}
