<?php

namespace controllers;

class BaseController{

    /**
     *
     * @var string 
     */
    protected $baseUrl;

    /**
     *
     * @var string 
     */
    protected $basePublicUrl;

    /**
     * la respuesta de cada accion
     * 
     * @var array
     */
    protected $response;


    /**
     * setea el modelo de cateogiras en categoriasModel
     *              
     */
    public function __construct()
    {
        $this->baseUrl       = $_SERVER['DOCUMENT_ROOT'].'/aleph/';
        $this->basePublicUrl = $this->getBaseAssetsUrl();
    }

    /**
     * Renderiza una vista
     * 
     * @param string $fileName              nombre del archivo
     * 
     * @return
     */
    public function render(string $fileName){
        return require_once 'src/views/'.$fileName;  
     }

    /**
     * Devuelve la url base para la utilizacion de assets
     * 
     * @return string
     */
    private function getBaseAssetsUrl(): string{
        return sprintf(
          "%s://%s%s",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
          $_SERVER['SERVER_NAME'],
          '/aleph/'
        );
    }
}