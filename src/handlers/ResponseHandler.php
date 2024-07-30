<?php

namespace handlers;

use stdClass;


class ResponseHandler{

    const  MESSAGE_200       = 'Se han obtenido los datos exitosamente';
    const  MESSAGE_201       = 'Se ha insertado correctamente';
    const  MESSAGE_400       = 'La peticion es incorrecta.';
    const  MESSAGE_401       = 'Fallo en el token de autenticacion.';
    const  MESSAGE_403       = 'Fallo en el token de autenticacion.';
    const  MESSAGE_500       = 'Ha ocurrido un error al procesar la solicitud';
    const  READ_ERROR        = 'No se ha podido leer el archivo';
    const  INSERT_ERROR      = 'No se ha podido insertar el registro';
    const  READ_SUCCESS      = 'Se ha leido el archivo con exito';
    const  INSERT_SUCCESS    = 'Se ha insertado un registro';
    const  CSV_SUCCESS       = 'Se ha generedo el csv con exito';
    const  EMPTY_FILE        = 'No hay registros';


    /**
     * Devuelve el mensaje de acuerdo con el codigo del estado
     * 
     * @param  int $statusCode             codigo del estado
     * 
     * @return string $message              el mensaje             
     *                               
     */
     public static function getMessageByStatus(int $statusCode): string{
        
        $message = '';

       switch ($statusCode) {
            case 200:
                $message = self::MESSAGE_200;
                break;
            case 201:
                $message = self::MESSAGE_201;
                break;
            case 400:
                $message = self::MESSAGE_400;
                break;
            case 401:
                $message = self::MESSAGE_401;
                break; 
            case 403:
                $message = self::MESSAGE_403;
                break;
            case 500:
                $message = self::MESSAGE_500;
                break;                
        }

        return $message;
    }

    /**
     * Devuelve la respuesta 
     * 
     * @param int $status               codigo de estado
     * @param bool $error               true si existen errores, false si no los hay
     * @param string $message           el mensaje que se mostrara
     * @param stdClass|array $data      datos que se necesitan mostrar
     * 
     * @return array                    ['status'=>int,'error'=>bool,'data'=>array,'message'=>string]
     */
    public static function getResponse(int $status, bool $error, string $message = '', stdClass|array $data = []): array {

        return [
            'status'   => $status,
            'error'    => $error,
            'data'     => $data,
            'message'  => empty($message) ? self::getMessageByStatus($status) : $message
        ];

    }


}