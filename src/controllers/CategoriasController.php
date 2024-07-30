<?php

namespace controllers;

require 'src/controllers/BaseController.php';
require 'src/models/CategoriasModel.php';
require 'src/handlers/ResponseHandler.php';
require 'src/handlers/CsvHandler.php';

use handlers\CvsHandler;
use models\CategoriasModel;
use handlers\ResponseHandler;

class CategoriasController extends BaseController
{

    /**
     * todas las categorias
     * 
     * @var array
     */
    protected $categorias;

    /**
     * el modelo categorias
     * 
     * @var CategoriasModel
     */
    private $categoriasModel;

    /**
     * setea el modelo de categorias en $categoriasModel y todas las categorias en $categorias
     *              
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoriasModel  = new CategoriasModel();

        $response               = $this->categoriasModel->fetchAll();

        $this->validateResponse($response);
   
        $this->categorias       = json_decode(json_encode($response['body']->categorias), true);
    }

    /**
     * Devuelve un listado de todas las categorias
     * 
     * @return
     */
    public function getCategorias()
    {
        $this->response = ResponseHandler::getResponse(200, false);

        return $this->render('layaout.php');
    }

    /**
     * Genera un archivo csv con la categoria buscada
     * 
     * @param int $id                   el id de la categoria buscada
     * 
     * @return
     */
    public function exportCategoriaCsv(int $id)
    {
        if (empty($id)){
            $this->response = ResponseHandler::getResponse(400, true);
            return $this->render('layaout.php');
        }

        $response = $this->categoriasModel->findById($id, $this->categorias);

        if(!count($response)){
            $this->response = ResponseHandler::getResponse(400, true);
            return $this->render('layaout.php');
        }

        $csvHandler             = new CvsHandler();
        $this->response         = $csvHandler->exportIntoFolder(end($response), $csvHandler::REPORTES_FOLDER, 'saveCmdbOfCategory');

        return $this->render('layaout.php');
    }

    /**
     * Inserta datos del csv dentro en una categoria especifica de la api
     * 
     * @param int $id                   el id de la categoria
     * 
     * @return
     */
    public function insertCsvDataIntoCategoria(int $id)
    {
        if (empty($id)){
            $this->response = ResponseHandler::getResponse(400, true);
            return $this->render('layaout.php');
        }

        $csvHandler             = new CvsHandler();
        $this->response         = $csvHandler->read('src/csv/'.$csvHandler::ACTIVOS_FILE, 2);

        if($this->response['error']){
            return $this->render('layaout.php');
        }

        $response                = null;

        foreach($this->response['data'] as $data){

            $response           = $this->categoriasModel->insertCmdb($id, $data);
            if(is_null($response) || (isset($response['httpCode']) && $response['httpCode'] > 300)){
                break;
            }    
        }

        $this->validateResponse($response);

        $this->response = ResponseHandler::getResponse(201, false, '');

        return $this->render('layaout.php');
    }

    /**
     * Valida la respuesta y genera los mensajes adecuados si existe un error
     * 
     * @param mixed $response               respuesta de la api
     */
    private function validateResponse(mixed $response){

        if (is_null($response)){
            $this->response = ResponseHandler::getResponse(500, true, ResponseHandler::MESSAGE_500);
            return $this->render('layaout.php');
        }

        if ($response['httpCode'] > 300){        
            $this->response = ResponseHandler::getResponse($response['httpCode'], true);
            return $this->render('layaout.php');
        }
    }

}
