<?php

#Start Autenticar

/** 
 * Verifica si existe una ApiKey válida dado un valor en el header 'Authorization'.
 *
 * @return Retorna la api key correspondiente al usuario, en casi de que exista.
 *         Caso contrario retorna un mensaje de error.
 */
function Autenticar() 
{
    // Obtiene header
    $slim = \Slim\Slim::getInstance();
    $headers = apache_request_headers();
    $response = array();
    
    //checkea que el header no esté vacío
    if (!empty($headers['authorization'])) 
    {
        // Obtenemos la API KEY
        $api_key = $headers['authorization'];
        // validamos la api key
        if (!$slim->pdo->isValidApiKey($api_key)) 
        {
            // Api_Key no está presente en la tabla de usuarios
            $response["error"] = TRUE;
            $response["message"] = "Acceso Denegado. Api key inválida.";
            GenerarRespuesta(401, $response, 'Autenticación inválida');

            $slim->stop();
        }
        else
        {
            $slim->apikey = $api_key;
        }
        // se debe manterner la sesión dentro del cliente y debe enviar la api key en cada request
    } 
    else 
    {
        // Api_Key en 'Authorization' vacía
        $response["error"] = TRUE;
        $response["message"] = "Api key perdida.";
        GenerarRespuesta(401, $response, 'Autenticación inválida. ApiKey perdida.');

        $slim->stop();
    }
}

#End Autenticar

/** 
* Función para verificar que los parámetros requeridos, según la función que llama, no esten vacíos o nulos
*
* @param $required_fields array
*
* @return Retorna, en caso de error, error en true y un mensaje especificando qué campos están vacíos o nulos.
*/
function VerificarParametrosRequeridos($required_fields) 
{
    $error = false;
    $error_fields = "";
    $app = \Slim\Slim::getInstance();
    $request_params = $app->request->getBody();
    $datapost = json_decode($request_params, true);

    // Handling PUT request params
    foreach ($required_fields as $field) 
    {
        //checkea que el campo este seteado y que el largo de su nombre sea mayor a 0
        if (!isset($datapost[$field]) || strlen(trim($datapost[$field])) <= 0) 
        {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
    
    //checkea el valor de error. Si es True devuelve el error en el/los campo/s correspondiente/s
    if ($error) 
    {
        $response = array();
        $response["error"] = true;
        $response["message"] = 'Campo(s) requerido(s) ' . substr($error_fields, 0, -2) . ' estan vacios o nulos';
        echoResponse2(400, $response, 'Verificar Parametros Requeridos. Error: campo/s incompleto/s o vacío/s');
        $app->stop();
    }
}

/** 
* Función para mostrar la respuesta mas el código header
*
* @param $codigoEstado int
*        $respuesta array(error, data)
*/
function GenerarRespuesta($codigoEstado = 200, $respuesta, $origen) 
{
    $app = \Slim\Slim::getInstance();
    
    // Seteo del estado del encabezado
    $app->status($codigoEstado);

    // Seteo del tipo de respuesta, JSON, en este caso
    $app->contentType('application/json');

    /*if ($_SERVER['HTTP_HOST'] == 'localhost') 
    {
        if (!isset($_SESSION['Id'])) 
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaLocalHost(array($respuesta['Id'], $origen));
        }
        else
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaLocalHost(array($_SESSION['Id'], $origen));
        }
    }
    else
    {
        if (!isset($_SESSION['Id'])) 
        {
            //Creo registro de auditoría // cambiar
            $app->pdo->CrearAuditoriaLocalHost(array($respuesta['Id'], $origen));
        }
        else
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaOnline(array($_SESSION['Id'], $origen));
        }
    }*/
    
    
    // Muestra la respuesta codificada en JSON    
    echo json_encode($respuesta);
}

?>