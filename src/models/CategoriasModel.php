<?php

namespace models;

require 'src/webservice/Aleph.php';

use webservice\Aleph;

class CategoriasModel{

    /**
     * Llama a la api y Devuelve todos los registros
     * 
     * @return array         
     */
    public function fetchAll(): array
    {   
        $aleph      = new Aleph(Aleph::API_KEY);

        $response   = $aleph->getCategorias();

        return $response;
    }

    /**
     * Devuelve el registro buscado por id
     * 
     * @param int $id            el id del registro buscado
     * @param array $data        todas las categorias
     * 
     * @return array         
     */
    public function findById(int $id, array $data): array
    {       
        //filtra los registros buscando por id
        $found = array_filter($data,function($v,$k) use ($id){
            return $v['id'] == $id;
          },ARRAY_FILTER_USE_BOTH);

        return $found;
    }

    /**
     * Llama a la api e insertar o actualizar un registro en la CMDB de una categoria
     * 
     * @param int $id            el id de la categoria
     * @param array $data        los campos de cmdb a insertar o actualizar
     * 
     * @return array         
     */
    public function insertCmdb(int $id, array $data): array
    {   
        $aleph      = new Aleph(Aleph::API_KEY);

        $response   = $aleph->insertCmdb($id, $data);

        return $response;
    }

}