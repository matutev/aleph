<?php

require 'src/controllers/CategoriasController.php';

use controllers\CategoriasController;

$url                    = $_SERVER['REQUEST_URI'];
$root                   = '/aleph/';
$partialRequest         = explode('/', str_replace($root,'',$url));
$request                = $partialRequest[0];

switch ($request) {
    case '':
    case '/':
        $categoriasController   = new CategoriasController();
        $categoriasController->getCategorias();
        break;
    case 'exportCategoria':
        $id                     = (int) end($partialRequest);
        $categoriasController   = new CategoriasController();
        $categoriasController->exportCategoriaCsv($id);
        break;

    case 'insertCsvDataIntoCategoriaTest':
        $id                     = (int) end($partialRequest);
        $categoriasController   = new CategoriasController();
        $categoriasController->insertCsvDataIntoCategoria($id);
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        echo '<h1>404 Not Found</h1>';
        echo 'No se pudo encontrar la página que usted solicitó.';
        exit();
        break;
}

