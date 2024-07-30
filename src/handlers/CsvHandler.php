<?php

namespace handlers;


class CvsHandler{

    /**
     * caracteres a ser reemplazados
     * 
    * @var string
    */
    private $restrictedCharacters = '< > : " / \ | ? * `';

    /**
     * el caracter separador del csv
     * 
    * @var string
    */
    private $delimiter = ';';

    
    const REPORTES_FOLDER = 'reportes';

    const ACTIVOS_FILE    = 'Activos_categoria_test_api.csv';

    /**
     * Lee un archivo csv
     * 
     * @param string $fileName                  la ruta del archivo csv
     * @param int $dataLimitPerRow              numero de datos por fila
     * 
     * @return array         
     */
    public function read(string $fileName, int $dataLimitPerRow): array {

        try {
            $file = fopen($fileName,'r');

            if(!$file){
                return ResponseHandler::getResponse(500, true, ResponseHandler::READ_ERROR);
            }

            $arrayData  = [];
            $index      = 0;

            while(($data = fgetcsv($file, 1000, $this->delimiter)) !== false){
                foreach($data as $key => $values){
                    $arrayData[$index][]  = trim(str_replace(['"'], '', $values));
                    if($key+1 == $dataLimitPerRow){
                        $index++;
                    }
                }
            }

            fclose($file);

            $message  = !count($arrayData) ? ResponseHandler::EMPTY_FILE : ResponseHandler::READ_SUCCESS;

            return ResponseHandler::getResponse(200, false, $message, $arrayData);

        } catch (\Throwable $th) {

            return ResponseHandler::getResponse(500, true, $th);
        }

    }

    /**
     * genera un archivo csv que contiene identificador y nombre de una categoria especifica
     * 
     * @param array $data                  la categoria solicitada
     * @param string $folder               la carpeta donde se creara el csv
     * @param string $method               el metodo que guardara la informacion especifica
     * 
     * @return array         
     */
    public function exportIntoFolder(array $data, string $folder, string $method): array {

        try {
            $cleanName  = str_replace(str_split($this->restrictedCharacters),'_',$data['nombre']);
            $filename   = $cleanName. '_' . date('d-m-Y') . '.csv'; 
     
            $file       = fopen($folder.'/'.$filename, 'wb');
            //llama al metodo que guardara la info especifica en el csv 
            $file       = $this->$method($data, $file); 

            fseek($file, 0); 
            
            fpassthru($file); 

            return ResponseHandler::getResponse(201, false, ResponseHandler::CSV_SUCCESS);

        } catch (\Throwable $th) {

            return ResponseHandler::getResponse(500, true, $th);
        }

    }

    /**
     * Guardar en un csv los campos cmdb de una categoria
     * 
     * @param array $data                  los campos cmdb
     * @param $file                         el archivo csv
     * 
     * @return $file
     */
    private function saveCmdbOfCategory(array $data, $file){

        $fields     = ['Identificador', 'Nombre']; 
        fputcsv($file, $fields, $this->delimiter); 

        if(is_string($data['campos_cmdb'][0])){
            fputcsv($file, [$data['campos_cmdb'][0], $data['campos_cmdb'][1]], $this->delimiter);
        }else{
            foreach($data['campos_cmdb'] as $values){
                fputcsv($file, [$values[0], $values[1]], $this->delimiter);   
            }
        }

        return $file;
    }



}