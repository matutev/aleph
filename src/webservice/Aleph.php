<?php

namespace webservice;


class Aleph{


    /**
     * el api key
     * 
    * @var string
    */
    private $token;

    /**
     * contiene las opciones del curl
     * 
    * @var array
    */
    private $curl_opts;

    const  BASE_URL = 'https://qa.alephmanager.com/API/';

    const  API_KEY  = 'ewHdOECdjkpLkuFzw9Yv2w1639YzvY';

    /**
     * Setea el api token en $token y las opciones del curl en $curl_opts
     * 
     * @param string $token             el api key
     */
    public function __construct(string $token){

		$this->token = $token;

		$this->curl_opts = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT        => 60,
			CURLOPT_CUSTOMREQUEST  => 'POST'
		);

    }
    
    /**
     * Al ejecutar este servicio se devolverá todas las categorias
     *
     * @return array
     */
    public function getCategorias(): array {

        return $this->executeWs('get_categorias', [
            'api_key'      => $this->token,
        ]);
    }

    /**
     * inserta o actualiza un registro en la cmdb de una categoria
     *
     * @param int $categoriaId   el id de la categoria
     * @param array $cmdb        los campos de cmdb a insertar o actualizar
     * 
     * @return array
     */
    public function insertCmdb(int $categoriaId, array $cmdb): array  {

        return $this->executeWs('insert_cmdb', [
            'api_key'       => $this->token,
            'categoria_id'  => $categoriaId,
            'nombre'        => $cmdb[0],
            'identificador' => $cmdb[1],
        ]);
    }

    /**
     * Ejecuta el webservice
     * 
     * @param  string       $method                         el metodo del servicio
     * @param  string       $params                        token de autenticacion
     * 
     * @return array        $return                        ['body'=> mixed, 'httpCode'=> int, 'error'=> string]
     *                               
     */
     private function executeWs(string $method, array $params = null) : array {

        try {
           
            $post   = [
                CURLOPT_URL        => self::BASE_URL.$method,
                CURLOPT_POSTFIELDS => $params,
            ];
    
            $ch     = curl_init();
            curl_setopt_array($ch, $this->curl_opts);
            curl_setopt_array($ch, $post);
    
            $return['body']     = json_decode(curl_exec($ch));
            $return['httpCode'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $return['error']    = curl_error($ch);
    
            curl_close($ch);
    
            return $return;

        } catch (\Throwable $th) {
      
            return [
                'body'      => [],
                'httpCode'  => 500,
                'error'     => $th
            ];
        }
                
    }


}