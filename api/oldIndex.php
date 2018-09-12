<?php
// Inicio Configuración de las variables de sesión
session_cache_limiter(false);
session_start();
// Fin Configuración de las variables de sesión

// Inicio Variables globales que van a ser utilizadas para los valores de las variables de sesión
$usuario = "";
$apiKey = "";
$nombre = "";
$apellido = "";
$email = "";
$rolId = "";
$descriptionRol = "";
$imagen = "";
$logoLab = "";
$nombreLab = "";
$lemaLab = "";
$trabajaSinConexion = "";
// Fin Variables globales que van a ser utilizadas para los valores de las variables de sesión

// Inicio Require del framework
require 'vendor/autoload.php';
require 'DbConnect.php';

$app = new \Slim\Slim();
$app->pdo = new DbConnect();

// Fin Require del framework

#Start Autenticar

/** 
 * Verifica si existe una ApiKey válida dado un valor en el header 'Authorization'.
 *
 * @return Retorna la api key correspondiente al usuario, en casi de que exista.
 *         Caso contrario retorna un mensaje de error.
 *//*
function Autenticar() {
    // Obtiene header
    $slim = \Slim\Slim::getInstance();
    $headers = apache_request_headers();
    $response = array();
    //checkea que el header no esté vacío
    if (!empty($headers['Authorization'])) 
    {
        // Obtenemos la API KEY
        $api_key = $headers['Authorization'];
        // validamos la api key
        if (!$slim->pdo->isValidApiKey($api_key)) 
        {
            // Api_Key no está presente en la tabla de usuarios
            $response["error"] = TRUE;
            $response["message"] = "Acceso Denegado. Api key inválida.";
            echoResponse2(401, $response, 'Autenticación inválida');
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
        echoResponse2(401, $response, 'Autenticación inválida. ApiKey perdida.');
        $slim->stop();
    }
}*/


#End Autenticar
/*
require 'app/crosscutting/FuncionesGenerales.php';
require 'app/Usuarios.php';
$app->post('/usuarios/login','IniciarSesion');

$app->group('/usuarios', function () use ($app) {
    
    /** 
    * Creación de un nuevo usuario
    *
    * @param $NombreUsuario -> varchar
    *        $Contrasena -> varchar
    *        $Apellido -> varchar
    *        $Nombre ->varchar
    *        $Email ->varchar
    *        $FechaNacimiento -> datetime
    *        $RoleId -> int
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, el Id del usuario recientemente creado y, si falla,
    *         error en true por usuario existente o por no poder crearlo.
    */
    $app->post('/crear', 'Autenticar', function() use ($app) {
        verifyRequiredParams(array('NombreUsuario',
                                   'Contrasena',
                                   'Nombre',
                                   'Apellido',
                                   'Email',
                                   'FechaNacimiento',
                                   'RoleId',
                                   'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $nombreUsuario        =  filter_var(substr($datapost['NombreUsuario'], 0, 50),                 FILTER_SANITIZE_STRING);
        $contrasena           =  filter_var(substr($datapost['Contrasena'], 0, 50),                    FILTER_SANITIZE_STRING);
        $nombre               =  filter_var(ucwords(strtolower(substr($datapost['Nombre'], 0, 50))),   FILTER_SANITIZE_STRING);
        $apellido             =  filter_var(ucwords(strtolower(substr($datapost['Apellido'], 0, 50))), FILTER_SANITIZE_STRING);
        $email                =  filter_var(substr($datapost['Email'], 0, 100),                        FILTER_SANITIZE_EMAIL);
        $fechaNacimiento      =  filter_var($datapost['FechaNacimiento'],                              FILTER_SANITIZE_STRING);
        $roleId               =  filter_var(substr($datapost['RoleId'], 0, 10),                        FILTER_SANITIZE_NUMBER_INT);
        $img                  =  filter_var(substr($datapost['Imagen'], 0, 500),                       FILTER_SANITIZE_STRING);
        $colorEncabezado      =  filter_var(substr($datapost['ColorEncabezado'], 0, 7),                FILTER_SANITIZE_STRING);
        $colorEncabezadoCinta =  filter_var(substr($datapost['ColorEncabezadoCinta'], 0, 7),           FILTER_SANITIZE_STRING); 
        $colorMenuLateral     =  filter_var(substr($datapost['ColorMenuLateral'], 0, 7),               FILTER_SANITIZE_STRING);
        $colorPiePagina       =  filter_var(substr($datapost['ColorPiePagina'], 0, 7),                 FILTER_SANITIZE_STRING);
        $colorFondo           =  filter_var(substr($datapost['ColorFondo'], 0, 7),                     FILTER_SANITIZE_STRING);
        $creadoPor            =  filter_var(substr($datapost['CreadoPor'], 0, 50),                     FILTER_SANITIZE_STRING);

        //chequea formato de email
        if (!checkEmail($email)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Error en el email";
            echoResponse2(200, $response, 'Crear Usuario. Error: Email incorrecto');
            $app->stop();
        }    

        // Verifica que el usuario no esté duplicado
        if ($app->pdo->CheckearNombreUsuario($nombreUsuario)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Nombre de usuario repetido";
            echoResponse2(200, $response, 'Crear Usuario. Error: Nombre usuario repetido');
            $app->stop();
        }    
        
        // Verifica que el mail no se duplique
        if ($app->pdo->CheckearEmailUsuario($email)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Email de usuario repetido";
            echoResponse2(200, $response, 'Crear Usuario. Error: Email repetido');
            $app->stop();
        }

        // Verifica la existencia del Rol
        if (!$app->pdo->ExisteRol($roleId)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "El rol no existe";
            echoResponse2(200, $response, 'Crear Usuario. Error: El rol ya no existe');
            $app->stop();
        }
        
        // Establezco el avatar predeterminado
        $img === '' ? $img = 'avatar.gif' : '';
        $colorEncabezado === '' ? $colorEncabezado = '#E7E7E7' : '';
        $colorEncabezadoCinta === '' ? $colorEncabezadoCinta = '#474544' : '';
        $colorMenuLateral === '' ? $colorMenuLateral = '#3A3633' : '';
        $colorPiePagina === '' ? $colorPiePagina = '#2A2725' : '';
        $colorFondo === '' ? $colorFondo = '#F3F3F3' : '';        
        
        // Se crea el usuario
        $result = $app->pdo->CrearUsuario(array(
                                                $nombreUsuario, 
                                                $contrasena, 
                                                $nombre, 
                                                $apellido, 
                                                $email, 
                                                $fechaNacimiento, 
                                                $roleId, 
                                                $img, 
                                                $creadoPor));
        
        if ($result)
        {   // Se cre la configuración por defecto para el usuario
            $resultConfi = $app->pdo->CrearConfiguracion(array(
                                                                $result, 
                                                                $colorEncabezado, 
                                                                $colorEncabezadoCinta, 
                                                                $colorMenuLateral, 
                                                                $colorPiePagina, 
                                                                $colorFondo, 
                                                                $creadoPor));            
        }        
        
        if ($result && $resultConfi) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Usuario. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "Usuario No Creado";
            echoResponse2(400, $response, 'Crear Usuario. Error: el usuario no se creó');
        }
    });

    /** 
    * Modificación de un usuario según su nombre de usuario
    *
    * @param $Id - string
    *        $Nombre ->varchar
    *        $Apellido -> varchar
    *        $FechaNacimiento -> datetime
    *        $RoleId -> int
    *        $Imagen -> string
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False un 1 y, si falla, 
    *         error en true y un mensaje de error en data.
    */
    $app->put('/modificar', 'Autenticar' , function() use ($app){
        verifyRequiredParams(array(
                                   'Id',
                                   'NombreUsuario',
                                   'Nombre',
                                   'Apellido',
                                   'Email',
                                   'FechaNacimiento',
                                   'RoleId',
                                   'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, true);

        $id               = filter_var(substr($datapost['Id'], 0, 10),                              FILTER_SANITIZE_STRING);       
        $nombreUsuario    = filter_var(substr($datapost['NombreUsuario'], 0, 50),                   FILTER_SANITIZE_STRING);
        $nombre           = filter_var(ucwords(strtolower(substr($datapost['Nombre'], 0, 50))),     FILTER_SANITIZE_STRING);
        $apellido         = filter_var(ucwords(strtolower(substr($datapost['Apellido'], 0, 50))),   FILTER_SANITIZE_STRING);
        $email            = filter_var(substr($datapost['Email'], 0, 100),                          FILTER_SANITIZE_EMAIL);
        $fechaNacimiento  = filter_var($datapost['FechaNacimiento'],                                FILTER_SANITIZE_STRING);
        $roleId           = filter_var(substr($datapost['RoleId'], 0, 10),                          FILTER_SANITIZE_NUMBER_INT);
        $img              = filter_var(substr($datapost['Imagen'], 0, 500),                         FILTER_SANITIZE_STRING);
        $modificadoPor    = filter_var(substr($datapost['ModificadoPor'], 0, 50),                   FILTER_SANITIZE_STRING);

        // Busca el usuario por id
        $usuario = $app->pdo->ExisteUsuario($id);

        // Verifica la existencia del usuario
        if (!$usuario) 
        {
            $response["error"] = TRUE;
            $response["data"] = "El usuario no existe";
            echoResponse2(200, $response, 'Modificar Usuario. Error: el usuario no existe');
            $app->stop();
        }    

        //verifica si va a modificar el nombre de usuario
        if ($usuario['NombreUsuario'] !== $nombreUsuario)
        {
            //chequea duplicado de nombre de usuario 
            if ($app->pdo->CheckearNombreUsuario($nombreUsuario)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Nombre de usuario repetido";
                echoResponse2(200, $response, 'Modificar Usuario. Error: nombre usuario repetido');
                $app->stop();
            }    
        }

        //verifica si va a modificar el email de usuario
        if ($usuario['Email'] !== $email)
        {   //checkea duplicado de email de usuario
            if ($app->pdo->CheckearEmailUsuario($email)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Email de usuario repetido";
                echoResponse2(200, $response, 'Modificar Usuario. Error: Email repetido');
                $app->stop();
            }
        }
        
        //checkea la existencia del rol
        if (!$app->pdo->ExisteRol($roleId)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "El rol no existe";
            echoResponse2(200, $response, 'Modificar Usuario. Error: el rol ya no existe');
            $app->stop();
        }    
        
        //setea la imagen por default si $img es igual a vacío
        $img === '' ? $img = substr($usuario['Imagen'], strripos($usuario['Imagen'], '/')+1) : '';     
        
        //modifica el usuario
        $result = $app->pdo->ModificarUsuario(array(
                                                    $id, 
                                                    $nombreUsuario, 
                                                    $nombre, 
                                                    $apellido, 
                                                    $email, 
                                                    $fechaNacimiento, 
                                                    $roleId, 
                                                    $img, 
                                                    $modificadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Usuario. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "Usuario No Modificado";
            echoResponse2(400, $response, 'Modificar Usuario. Error: el usuario no se modificó');
        }
    });

    /** 
    * Eliminación de un usuario según su Id
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False un 1 y, si falla,
    *         error en true y el mensaje de error en data.
    */
    $app->delete('/eliminar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id','ModificadoPor'));

        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, true);

        $id            = filter_var(substr($datapost['Id'], 0, 10),            FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //chequea existencia del usuario
        if (!$app->pdo->ExisteUsuario($id))
        {
            $response["error"] = TRUE;
            $response["data"] = "El usuario no existe";
            echoResponse2(200, $response, 'Eliminar Usuario. Error: el usuario no existe');
            $app->stop();
        }
        
        //elimina el usuario
        $result = $app->pdo->EliminarUsuario(array($id, $modificadoPor));
        
        if ($result) 
        {
            //elimina la configuracion de usuario
            $resultConfi = $app->pdo->EliminarConfiguracion(array($id, $modificadoPor));
        }

        if ($result && $resultConfi)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Usuario. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "Usuario No Eliminado ".$result.'  '.$resultConfi;
            echoResponse2(400, $response, 'Eliminar Usuario. Error: el usuario no se eliminó');
        }
    });

    /** 
    * Chequea datos del usuario para habilitarle el login
    *
    * @param $NombreUsuario -> varchar
    *        $Contrasena -> varchar
    *
    * @return Retorna, en caso de éxito, error en false y los datos en data si el login es correcto y, si falla,
    *         error en true y el mensaje de error en data.
    */
    /*$app->post('/login', function() use ($app) {
        verifyRequiredParams(array('NombreUsuario', 'Contrasena'));

        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $nombreUsuario  = filter_var(substr($datapost['NombreUsuario'], 0, 50), FILTER_SANITIZE_STRING);
        $contrasena     = filter_var(substr($datapost['Contrasena'], 0, 50),    FILTER_SANITIZE_STRING);
        
        //checkea los datos de login del usuario que intenta ingresar
        $data = $app->pdo->ChequearLogin(array($nombreUsuario, $contrasena));                
        
        $configSis = ObtenerConfigSis($data['Id']);

        if ($data) 
        {
            $data['Logo']         = $configSis[2];
            $data['NombreLab']    = $configSis[3];
            $data['LemaLab']      = $configSis[4];
            $data['SinConexion']  = $configSis[5];
            $response["error"]    = FALSE;
            $response["data"]     = $data;
            $response["Id"]       = $data['Id'];
            
            // Seteo las variables de sesión
            $_SESSION['NombreUsuario']      = $data['NombreUsuario'];
            $_SESSION['ApiKey']             = $data['ApiKey'];
            $_SESSION['Nombre']             = $data['Nombre'];
            $_SESSION['Apellido']           = $data['Apellido'];
            $_SESSION['Email']              = $data['Email'];
            $_SESSION['RolId']              = $data['RolId'];
            $_SESSION['RolDescrip']         = $data['ApiRolDescripKey'];
            $_SESSION['UrlParcialImagen']   = $data['Imagen'];
            $_SESSION['UrlParcialLogo']     = $data['Logo'];
            $_SESSION['NombreLab']          = $data['NombreLab'];
            $_SESSION['LemaLab']            = $data['LemaLab'];
            $_SESSION['SinConexion']        = $data['SinConexion'];

            // Seteo las variables globales
            //global $usuario, $apiKey, $nombre, $apellido, $email, $rolId, $descriptionRol, $imagen, $logoLab, $nombreLab, $lemaLab, $trabajaSinConexion;
            
            $GLOBALS['usuario']      = $data['NombreUsuario'];
            $apiKey            = $data['ApiKey'];
            $nombre             = $data['Nombre'];
            $apellido           = $data['Apellido'];
            $email              = $data['Email'];
            $rolId              = $data['RolId'];
            $descriptionRol         = $data['ApiRolDescripKey'];
            $imagen   = $data['Imagen'];
            $logoLab     = $data['Logo'];
            $nombreLab          = $data['NombreLab'];
            $lemaLab            = $data['LemaLab'];
            $trabajaSinConexion        = $data['SinConexion'];
           
            echoResponse2(200, $response, 'Log In. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "Login incorrecto";
            echoResponse2(401, $response, 'Log In. Error: datos incorrectos');
        }
    }); */

    /** 
    * Obtiene todos los usuarios no borrados
    *
    * @return Retorna, en caso de éxito, un arreglo con los datos de todos los usuarios existentes y, si falla, 
    *         un error.
    */ 
    $app->post('/', 'Autenticar', function () use ($app) {
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('usu.Id', 
                                                   'usu.Nombre', 
                                                   'usu.Apellido', 
                                                   'usu.NombreUsuario', 
                                                   'usu.Email', 
                                                   'usu.FechaNacimiento', 
                                                   'usu.RoleId', 
                                                   'rol.Descripcion', 
                                                   'usu.Imagen'))
                                    ->from('Usuarios usu')
                                    ->join('Roles rol', 'usu.RoleId', '=', 'rol.Id', 'INNER')
                                    ->where('usu.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('usu.Id', $as = 'Total')
                        ->from('Usuarios usu')
                        ->where('usu.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }
        
        if ($data) 
        {                   
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get General Usuarios. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han econtrado datos";
            echoResponse2(200, $response, 'Get General Usuarios. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los usuarios no borrados
    *
    * @return Retorna, en caso de éxito, un arreglo con los datos de todos los usuarios existentes y, si falla, 
    *         un error.
    */ 
    $app->get('/', 'Autenticar', function () use ($app) {
        $response = array();        

        $selectStatement = $app->pdo->select(array('usu.Id', 
                                                   'usu.Nombre', 
                                                   'usu.Apellido', 
                                                   'usu.NombreUsuario', 
                                                   'usu.Email', 
                                                   'usu.FechaNacimiento', 
                                                   'usu.RoleId', 
                                                   'rol.Descripcion', 
                                                   'usu.Imagen'))
                                    ->from('Usuarios usu')
                                    ->join('Roles rol', 'usu.RoleId', '=', 'rol.Id', 'INNER')
                                    ->where('usu.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {                   
            $response["error"] = FALSE;
            $response["data"] = $data; 
            echoResponse2(200, $response, 'Get General Usuarios. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han econtrado datos";
            echoResponse2(200, $response, 'Get General Usuarios. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene el usuario coincidente según el Id enviado
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de éxito, un arreglo con todos los datos del usuario y, si falla, error en true.
    */
    $app->get('/:id', 'Autenticar', function ($id) use ($app) {
        $selectStatement = $app->pdo->select(array('usu.Id', 
                                                   'usu.Nombre', 
                                                   'usu.Apellido', 
                                                   'usu.NombreUsuario', 
                                                   'usu.Contrasena', 
                                                   'usu.Email', 
                                                   'usu.FechaNacimiento', 
                                                   'usu.RoleId', 
                                                   'rol.Descripcion', 
                                                   'usu.Imagen'))
                                    ->from('Usuarios usu')
                                    ->join('Roles rol', 'usu.RoleId', '=', 'rol.Id', 'INNER')
                                    ->where('usu.Id', '=', $id)
                                    ->where('usu.EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Usuarios Id. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han econtrado datos";
            echoResponse2(200, $response, 'Get Usuarios Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/roles', function() use($app){

    /** 
    * Obtiene todos los roles existentes para un usuario    
    *
    * @return Retorna, en caso de éxito, un arreglo con todos los datos de los roles de usuario y, si falla, error en true
    *         y en data el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){
        $selectStatement = $app->pdo->select(array('rol.Id', 'rol.Descripcion'))
                                    ->from('Roles rol')                                    
                                    ->where('rol.EstaBorrado', '=', (int) 0);

        $response = array();

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Roles. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han econtrado datos";
            echoResponse2(200, $response, 'Get General Roles. Error: no se encontraron datos');
        }
    });
});

$app->group('/mutuales', function() use($app){

    /** 
    * Crea una nueva Mutual
    *
    * @param $Codigo -> string
    *        $Nombre -> string
    *        $AbonoDomicilio -> int
    *        $PMO -> int
    *        $CobroSeguro -> int
    *        $ServicioCortado -> int
    *        $INOSReducido -> int
    *        $Reconoce677 -> int
    *        $NomenCompleto -> int
    *        $ValorA -> decimal
    *        $ValorB -> decimal
    *        $ValorC -> decimal
    *        $ValorNBU -> decimal
    *        $CoeficienteUGastos -> decimal
    *        $CoeficienteUHono -> decimal
    *        $ImporteBoletaMin -> decimal
    *        $AbonoAPB -> int
    *        $Comentarios -> string
    *        $PorcCobertura -> int
    *        $Porcentaje -> int
    *        $Condicion -> int
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y en data el codigo de la mutual creada y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Codigo',
                                   'Nombre', 
                                   'AbonoDomicilio', 
                                   'PMO', 
                                   'CobroCoseguro', 
                                   'ServicioCortado', 
                                   'Reconoce677', 
                                   'NomenCompleto', 
                                   'ImporteBoletaMin', 
                                   'AbonoAPB', 
                                   'PorcCobertura', 
                                   'Porcentaje', 
                                   'Condicion', 
                                   'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $codigo = filter_var(substr($datapost['Codigo'], 0, 4), FILTER_SANITIZE_STRING);
        $nombre = filter_var(ucwords(strtolower(substr($datapost['Nombre'], 0, 50))), FILTER_SANITIZE_STRING);
        $abonoDomicilio = filter_var($datapost['AbonoDomicilio'], FILTER_SANITIZE_STRING);
        $pmo = filter_var($datapost['PMO'], FILTER_SANITIZE_STRING);
        $cobroCoseguro = filter_var($datapost['CobroCoseguro'], FILTER_SANITIZE_STRING);
        $servicioCortado = filter_var($datapost['ServicioCortado'], FILTER_SANITIZE_STRING);
        $inosReducido = filter_var($datapost['INOSReducido'], FILTER_SANITIZE_STRING);
        $reconoce677 = filter_var($datapost['Reconoce677'], FILTER_SANITIZE_STRING);
        $nomenCompleto = filter_var($datapost['NomenCompleto'], FILTER_SANITIZE_STRING);
        $valorA = filter_var($datapost['ValorA'], FILTER_SANITIZE_STRING);
        $valorB = filter_var($datapost['ValorB'], FILTER_SANITIZE_STRING);
        $valorC = filter_var($datapost['ValorC'], FILTER_SANITIZE_STRING);
        $valorNbu = filter_var($datapost['ValorNBU'], FILTER_SANITIZE_STRING);
        $coeficienteUgastos = filter_var($datapost['CoeficienteUGastos'], FILTER_SANITIZE_STRING);
        $coeficienteUhono = filter_var($datapost['CoeficienteUHono'], FILTER_SANITIZE_STRING);        
        $importeBoletaMin = filter_var($datapost['ImporteBoletaMin'], FILTER_SANITIZE_STRING);
        $abonoApb = filter_var($datapost['AbonoAPB'], FILTER_SANITIZE_STRING);
        $porcCobertura = filter_var(substr($datapost['PorcCobertura'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        $comentarios = filter_var(substr($datapost['Comentarios'], 0, 500), FILTER_SANITIZE_STRING);
        $comentariosInternos = filter_var(substr($datapost['ComentariosInternos'], 0, 500), FILTER_SANITIZE_STRING);  
        $porcentaje = filter_var(substr($datapost['Porcentaje'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        $condicion = filter_var(substr($datapost['Condicion'], 0, 1), FILTER_SANITIZE_NUMBER_INT);
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //checkea que el código de mutual no esté repetido
        if ($app->pdo->CheckearCodigoMutual($codigo)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Código de Matrícula repetido";
            echoResponse2(200, $response, 'Crear Mutual. Error: codigo de mutual repetido');
            $app->stop();
        }

        $inosReducido === '' ? $inosReducido = NULL : '';
        $valorA === '' ? $valorA = NULL : '';
        $valorB === '' ? $valorB = NULL : '';
        $valorC === '' ? $valorC = NULL : '';
        $valorNbu === '' ? $valorNbu = NULL : '';
        $coeficienteUgastos === '' ? $coeficienteUgastos = NULL : '';
        $coeficienteUhono === '' ? $coeficienteUhono = NULL : '';

        //crea la mutual
        $result = $app->pdo->CrearMutual(array($codigo, 
                                               $nombre, 
                                               $abonoDomicilio, 
                                               $pmo, 
                                               $cobroCoseguro, 
                                               $servicioCortado, 
                                               $inosReducido, 
                                               $reconoce677, 
                                               $nomenCompleto, 
                                               $valorA, 
                                               $valorB,
                                               $valorC, 
                                               $valorNbu, 
                                               $coeficienteUgastos, 
                                               $coeficienteUhono, 
                                               $importeBoletaMin, 
                                               $abonoApb, 
                                               $porcCobertura, 
                                               $comentarios, 
                                               $comentariosInternos, 
                                               $porcentaje, 
                                               $condicion, 
                                               $creadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Mutual. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "Mutual no creada";
            echoResponse2(400, $response, 'Crear Mutual. Error: la mutual no se creó');
        }
    });

    /** 
    * Modifica una mutual 
    *
    * @param $Id -> int
    *        $Codigo -> string
    *        $nombre -> string
    *        $AbonoDomicilio -> int
    *        $PMO -> int
    *        $CobroCoseguro -> inst
    *        $ServicioCortado -> int
    *        $INOSReducido -> int
    *        $Reconoce677 -> int
    *        $NomenCompleto -> int
    *        $ValorA -> decimal
    *        $ValorB -> decimal
    *        $ValorC -> decimal
    *        $ValorNbu -> decimal
    *        $CoeficienteUgastos -> decimal
    *        $CoeficienteUhono -> decimal
    *        $ImporteBoletaMin -> decimal
    *        $AbonoAPB -> string
    *        $Comentarios -> string
    *        $ComentariosInternos -> string
    *        $PorcCobertura -> int
    *        $Porcentaje -> int
    *        $Condicion -> int
    *        $ModificadoPor -> string 
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si la mutual inicada se modifica y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 
                                   'Codigo', 
                                   'Nombre', 
                                   'AbonoDomicilio', 
                                   'PMO', 
                                   'CobroCoseguro', 
                                   'ServicioCortado', 
                                   'Reconoce677', 
                                   'NomenCompleto', 
                                   'ImporteBoletaMin', 
                                   'AbonoAPB', 
                                   'PorcCobertura', 
                                   'Porcentaje', 
                                   'Condicion', 
                                   'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE); 

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $codigo = filter_var(substr($datapost['Codigo'], 0, 4), FILTER_SANITIZE_STRING);
        $nombre = filter_var(ucwords(strtolower(substr($datapost['Nombre'], 0, 50))), FILTER_SANITIZE_STRING);
        $abonoDomicilio = filter_var($datapost['AbonoDomicilio'], FILTER_SANITIZE_STRING);
        $pmo = filter_var($datapost['PMO'], FILTER_SANITIZE_STRING);
        $cobroCoseguro = filter_var($datapost['CobroCoseguro'], FILTER_SANITIZE_STRING);
        $servicioCortado = filter_var($datapost['ServicioCortado'], FILTER_SANITIZE_STRING);
        $inosReducido = filter_var($datapost['INOSReducido'], FILTER_SANITIZE_STRING);
        $reconoce677 = filter_var($datapost['Reconoce677'], FILTER_SANITIZE_STRING);
        $nomenCompleto = filter_var($datapost['NomenCompleto'], FILTER_SANITIZE_STRING);
        $valorA = filter_var($datapost['ValorA'], FILTER_SANITIZE_STRING);
        $valorB = filter_var($datapost['ValorB'], FILTER_SANITIZE_STRING);
        $valorC = filter_var($datapost['ValorC'], FILTER_SANITIZE_STRING);
        $valorNbu = filter_var($datapost['ValorNBU'], FILTER_SANITIZE_STRING);
        $coeficienteUgastos = filter_var($datapost['CoeficienteUGastos'], FILTER_SANITIZE_STRING);
        $coeficienteUhono = filter_var($datapost['CoeficienteUHono'], FILTER_SANITIZE_STRING);
        $importeBoletaMin = filter_var($datapost['ImporteBoletaMin'], FILTER_SANITIZE_STRING);
        $abonoApb = filter_var($datapost['AbonoAPB'], FILTER_SANITIZE_STRING);
        $porcCobertura = filter_var(substr($datapost['PorcCobertura'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        $comentarios = filter_var(substr($datapost['Comentarios'], 0, 500), FILTER_SANITIZE_STRING);      
        $comentariosInternos = filter_var(substr($datapost['ComentariosInternos'], 0, 500), FILTER_SANITIZE_STRING);
        $porcentaje = filter_var(substr($datapost['Porcentaje'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        $condicion = filter_var(substr($datapost['Condicion'], 0, 1), FILTER_SANITIZE_NUMBER_INT);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //busco la mutual por código
        $mutual = $app->pdo->ExisteMutual($id);

        //checkeo la existencia de la mutual
        if (!$mutual)
        {   //la mutual no existe
            $response["error"] = TRUE;
            $response["data"] = "La mutual no existe.";
            echoResponse2(200, $response, 'Modificar Mutual. Error: la mutual no existe');
            $app->stop();
        }

        //chekceo si el código de mutual cambia
        if ($mutual[0]['Codigo'] !== $codigo) 
        {   //checkeo la existencia del nuevo código de mutual
            if ($app->pdo->CheckearCodigoMutual($codigo)) 
            {   //código de mutual repetido
                $response["error"] = TRUE;
                $response["data"] = "Código de mutual repetido";
                echoResponse2(200, $response, 'Modificar Mutual. Error: código de mutual repetido');
                $app->stop();
            }
        }

        $inosReducido === '' ? $inosReducido = NULL : '';
        $valorA === '' ? $valorA = NULL : '';
        $valorB === '' ? $valorB = NULL : '';
        $valorC === '' ? $valorC = NULL : '';
        $valorNbu === '' ? $valorNbu = NULL : '';
        $coeficienteUgastos === '' ? $coeficienteUgastos = NULL : '';
        $coeficienteUhono === '' ? $coeficienteUhono = NULL : '';

        //modifica la mutual
        $result = $app->pdo->ModificarMutual(array($id, 
                                                   $codigo, 
                                                   $nombre, 
                                                   $abonoDomicilio, 
                                                   $pmo, 
                                                   $cobroCoseguro, 
                                                   $servicioCortado,
                                                   $inosReducido, 
                                                   $reconoce677, 
                                                   $nomenCompleto, 
                                                   $valorA, 
                                                   $valorB, 
                                                   $valorC, 
                                                   $valorNbu,
                                                   $coeficienteUgastos, 
                                                   $coeficienteUhono, 
                                                   $importeBoletaMin, 
                                                   $abonoApb, 
                                                   $porcCobertura, 
                                                   $comentarios, 
                                                   $comentariosInternos, 
                                                   $porcentaje,
                                                   $condicion, 
                                                   $modificadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Mutual. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se modificó la mutual";
            echoResponse2(400, $response, 'Modificar Mutual. Error: la mutual no se modificó');
        }
    });

    /** 
    * Elimina una mutual 
    *
    * @param $Id -> int
    *        $ModificadoPor -> string 
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si la mutual inicada se elimina y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //checkea que exista la mutual por id
        if (!$app->pdo->ExisteMutual($id)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "La mutual no existe.";
            echoResponse2(200, $response, 'Eliminar Mutual. Error: la mutual no existe');
            $app->stop();
        }

        //checkea que la mutual a borrar no tenga pacientes asociados
        if(CheckearAsocMutPac($id))
        {
            $response["error"] = TRUE;
            $response["data"] = "La mutual no se puede borrar porque tiene pacientes asociados.";
            echoResponse2(200, $response, 'Eliminar Mutual. Error: no se eliminó la mutual por pacientes asociados.');
            $app->stop();
        }

        //checkea que la mutual a borrar no tenga prácticas asociadas
        if(CheckearAsocMutPrac($id))
        {
            $response["error"] = TRUE;
            $response["data"] = "La mutual no se puede borrar porque tiene prácticas asociadas.";
            echoResponse2(200, $response, 'Eliminar Mutual. Error: no se eliminó la mutual por prácticas asociadas.');
            $app->stop();
        }

        //elimina la mutual
        $result = $app->pdo->EliminarMutual(array($id, $modificadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Mutual. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se eliminó la mutual";
            echoResponse2(400, $response, 'ELiminar Mutual. Error: la mutual no se eliminó');
        }
    });

    /** 
    * Obtiene todas las mutuales credas que no esten borradas
    *
    * @return Retorna, en caso de éxito, error en False y en data todas las mutuales encontradas y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('Id',
                                                   'Codigo', 
                                                   'Nombre', 
                                                   'AbonoDomicilio', 
                                                   'PMO', 
                                                   'CobroCoseguro', 
                                                   'ServicioCortado', 
                                                   'INOSReducido', 
                                                   'Reconoce677', 
                                                   'NomenCompleto', 
                                                   'ValorA', 
                                                   'ValorB', 
                                                   'ValorC', 
                                                   'ValorNBU', 
                                                   'CoeficienteUGastos', 
                                                   'CoeficienteUHono', 
                                                   'ImporteBoletaMin', 
                                                   'AbonoAPB', 
                                                   'PorcCobertura', 
                                                   'Comentarios', 
                                                   'ComentariosInternos', 
                                                   'Porcentaje', 
                                                   'Condicion'))
                                    ->from('Mutuales')                                    
                                    ->where('EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('m.Id', $as = 'Total')
                        ->from('Mutuales m')
                        ->where('m.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        $algo = $ultimaPag[0]['Total'];
        $parcial = $algo - (20 + ($offset - 1) * 20);

            // anda, solo que en la segunda iteracion se rompe
        if ((($ultimaPag[0]['Total']) - (($offset - 1) * 20 + 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data; 
            $response["ultimaPag"] = $ultimaPag;
            $response["total"] = $algo;
            $response["offset"] = ($offset - 1) * 20 + 20;
            $response["parcial"] = $parcial;
            echoResponse2(200, $response, 'Get General Mutuales. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han econtrado datos";            
            echoResponse2(200, $response, 'Get General Mutuales. Error: no se encontraron datos');
        }
    });

    $app->post('/pornombre', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Nombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $nombre = filter_var(substr($datapost['Nombre'], 0, 50), FILTER_SANITIZE_STRING);
        $codigo = filter_var(substr($datapost['Nombre'], 0, 4), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('mut.Id', 
                                                   'mut.Codigo', 
                                                   'mut.Nombre', 
                                                   'mut.AbonoDOmicilio', 
                                                   'mut.PMO', 
                                                   'mut.CobroCoseguro', 
                                                   'mut.ServicioCortado', 
                                                   'mut.INOSReducido', 
                                                   'mut.Reconoce677', 
                                                   'mut.NomenCompleto', 
                                                   'mut.ValorA', 
                                                   'mut.ValorB', 
                                                   'mut.ValorC', 
                                                   'mut.ValorNBU', 
                                                   'mut.CoeficienteUGastos', 
                                                   'mut.CoeficienteUHono', 
                                                   'mut.ImporteBoletaMin', 
                                                   'mut.AbonoAPB', 
                                                   'mut.PorcCobertura', 
                                                   'mut.Comentarios', 
                                                   'mut.ComentariosInternos', 
                                                   'mut.Porcentaje', 
                                                   'mut.Condicion'))
                                    ->from('Mutuales mut')
                                    ->whereLike('mut.Codigo', '%'.$codigo.'%')
                                    ->orWhereLike('mut.Nombre', '%'.$nombre.'%')
                                    ->where('mut.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Mutuales Por Nombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Mutuales Por Nombre. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todas las mutuales credas que no esten borradas
    *
    * @return Retorna, en caso de éxito, error en False y en data todas las mutuales encontradas y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){        
        $response = array();

        $selectStatement = $app->pdo->select(array('Id', 'Codigo', 'Nombre', 'AbonoDomicilio', 'PMO', 'CobroCoseguro', 'ServicioCortado', 'INOSReducido', 'Reconoce677', 'NomenCompleto', 'ValorA', 'ValorB', 'ValorC', 'ValorNBU', 'CoeficienteUGastos', 'CoeficienteUHono', 'ImporteBoletaMin', 'AbonoAPB', 'PorcCobertura', 'Comentarios', 'ComentariosInternos', 'Porcentaje', 'Condicion'))
                                    ->from('Mutuales')                                    
                                    ->where('EstaBorrado', '=', (int) 0);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;            
            echoResponse2(200, $response, 'Get General Mutuales. Correcto');
        } 
        else 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han econtrado datos";            
            echoResponse2(200, $response, 'Get General Mutuales. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de una mutual en particular segun un Id ingresado
    *
    * @param $Id -> int 
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de la mutual encontrada y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('Id', 'Codigo', 'Nombre', 'AbonoDomicilio', 'PMO', 'CobroCoseguro', 'ServicioCortado', 'INOSReducido', 'Reconoce677', 'NomenCompleto', 'ValorA', 'ValorB', 'ValorC', 'ValorNBU', 'CoeficienteUGastos', 'CoeficienteUHono', 'ImporteBoletaMin', 'AbonoAPB', 'PorcCobertura', 'Comentarios', 'ComentariosInternos', 'Porcentaje', 'Condicion'))
                                    ->from('Mutuales')              
                                    ->where('Id', '=', $id)                      
                                    ->where('EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Mutuales Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han encontrado datos";
            echoResponse2(200, $response, 'Get Mutuales Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/medicos', function() use($app){
    
    /** 
    * Crea un nuevo medico
    *
    * @param $Matricula -> string
    *        $TipoMatricula -> string
    *        $Nombre -> string
    *        $Apellido -> string
    *        $Domicilio1 -> string
    *        $Telefono1 -> int
    *        $Domicilio2 -> string
    *        $Telefono2 -> int
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y en data la matricula del medico creado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Matricula', 'TipoMatricula', 'Nombre', 'Apellido', 'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $matricula = filter_var(substr($datapost['Matricula'], 0, 6), FILTER_SANITIZE_STRING);
        $tipoMatricula = filter_var($datapost['TipoMatricula'], FILTER_SANITIZE_STRING);
        $nombre = filter_var(ucwords(strtolower(substr($datapost['Nombre'], 0, 50))), FILTER_SANITIZE_STRING);
        $apellido = filter_var(ucwords(strtolower(substr($datapost['Apellido'], 0, 50))), FILTER_SANITIZE_STRING);
        $domicilio1 = filter_var(substr($datapost['Domicilio1'], 0, 50), FILTER_SANITIZE_STRING);
        $telefono1 = filter_var(substr($datapost['Telefono1'], 0, 50), FILTER_SANITIZE_STRING);
        $domicilio2 = filter_var(substr($datapost['Domicilio2'], 0, 50), FILTER_SANITIZE_STRING);
        $telefono2 = filter_var(substr($datapost['Telefono2'], 0, 50), FILTER_SANITIZE_STRING);
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        $tipoMat = decbin($tipoMatricula);

        //checkea que la matrícula no esté repetida
        if ($app->pdo->CheckearMatricula($matricula))
        {
            $response["error"] = TRUE;
            $response["data"] = "Matrícula repetida";
            $response["dato"] = $matricula;
            echoResponse2(200, $response, 'Crear Médico. Error: matrícula repetida');
            $app->stop();
        }
        
        //hace NULL domicilio2 y/o telefono2 si vienen vacíos
        $domicilio1 === '' ? $domicilio1 = NULL : '';
        $telefono1 === '' ? $telefono1 = NULL : '';
        $domicilio2 === '' ? $domicilio2 = NULL : '';
        $telefono2 === '' ? $telefono2 = NULL : '';
        
        //crea el médico
        $result = $app->pdo->CrearMedico(array($matricula, $tipoMat, $nombre, $apellido, $domicilio1, $telefono1, $domicilio2, $telefono2, $creadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Médico. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "Médico no creado";
            echoResponse2(400, $response, 'Crear Médico. Error: el médico no se creó');
        }
    });

    /** 
    * Modifica un medico
    *
    * @param $Id -> int
    *        $Matricula -> int
    *        $TipoMatricula -> int
    *        $Nombre -> string
    *        $Apellido -> string
    *        $Domicilio1 -> string
    *        $Telefono1 -> int
    *        $Domicilio2 -> string
    *        $Telefono2 -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si el medico indicado se modifica y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'Matricula', 'TipoMatricula', 'Nombre', 'Apellido', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $matricula = filter_var(substr($datapost['Matricula'], 0, 6), FILTER_SANITIZE_STRING);
        $tipoMatricula = filter_var($datapost['TipoMatricula'], FILTER_SANITIZE_STRING);
        $nombre = filter_var(ucwords(strtolower(substr($datapost['Nombre'], 0, 50))), FILTER_SANITIZE_STRING);
        $apellido = filter_var(ucwords(strtolower(substr($datapost['Apellido'], 0, 50))), FILTER_SANITIZE_STRING);
        $domicilio1 = filter_var(substr($datapost['Domicilio1'], 0, 50), FILTER_SANITIZE_STRING);
        $telefono1 = filter_var(substr($datapost['Telefono1'], 0, 50), FILTER_SANITIZE_STRING);
        $domicilio2 = filter_var(substr($datapost['Domicilio2'], 0, 50), FILTER_SANITIZE_STRING);
        $telefono2 = filter_var(substr($datapost['Telefono2'], 0, 50), FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //busco el médico por Id
        $medico = $app->pdo->ExisteMedico($id);

        if (!$medico)        
        {
            $response["error"] = TRUE;
            $response["data"] = "El médico no existe";
            echoResponse2(200, $response, 'Modificar Médico. Error: el médico no existe');
            $app->stop();
        }

        if ($medico[0]['Matricula'] !== (int)$matricula)
        {
            if ($app->pdo->CheckearMatricula($matricula)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Matrícula repetida";
                echoResponse2(200, $response, 'Modificar Médico. Error: matrícula repetida');
                $app->stop();
            }
        }
        
        //hace NULL domicilio2 y/o telefono2 si vienen vacíos
        $domicilio2 === '' ? $domicilio2 = NULL : '';
        $telefono2 === '' ? $telefono2 = NULL : '';
        
        //modifica el médico
        $result = $app->pdo->ModificarMedico(array($id, $matricula, $tipoMatricula, $nombre, $apellido, $domicilio1, $telefono1, $domicilio2, $telefono2, $modificadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Médico. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El médico no se modificó";
            echoResponse2(400, $response, 'Modificar Médico. Error: el médico no se modificó');
        }
    });

    /** 
    * Elimina un medico
    *
    * @param $Id -> int
    *        modificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si el medico indicado se elimina y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);        
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //checkea que el medico exista
        if (!$app->pdo->ExisteMedico($id)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "El médico no existe";
            echoResponse2(200, $response, 'Eliminar Médico. Error: el médico no existe');
            $app->stop();
        }

        //checkea que el médico a borrar no tenga pacientes asociados
        if (CheckearAsocMedPac($id)) {
            $response["error"] = TRUE;
            $response["data"] = "El médico no se puede eliminar porque tiene pacientes asociados.";
            echoResponse2(200, $response, 'Eliminar Médico. Error: no se eliminó el médico por pacientes asociados');
            $app->stop();
        }

        //elimina el médico
        $result = $app->pdo->EliminarMedico(array($id, $modificadoPor));
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Médico. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El médico no se eliminó";
            echoResponse2(400, $response, 'Eliminar Médico. Error: el médico no se eliminó');
        }
    });

    /** 
    * Obtiene los datos de todos los medicos existentes no borradas
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de los medicos encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('Id', 'Matricula', 'TipoMatricula', 'Nombre', 'Apellido', 'Domicilio1', 'Telefono1', 'Domicilio2', 'Telefono2'))
                                    ->from('Medicos')
                                    ->where('EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('m.Id', $as = 'Total')
                        ->from('Medicos m')
                        ->where('m.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get General Médicos. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han encontrado datos";
            echoResponse2(200, $response, 'Get General Médicos. Error: no se encontraron datos');
        }
    });

    $app->post('/porapellido', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Apellido'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $apellido = filter_var(substr($datapost['Apellido'], 0, 50), FILTER_SANITIZE_STRING);
        $nombre = filter_var(substr($datapost['Apellido'], 0, 50), FILTER_SANITIZE_STRING);
        $matricula = filter_var(substr($datapost['Apellido'], 0, 6), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('med.Id', 'med.Nombre', 'med.Apellido', 'med.Matricula', 'med.TipoMatricula', 'med.Domicilio1', 'med.Telefono1', 'med.Domicilio2', 'med.Telefono2'))
                                    ->from('Medicos med')
                                    ->whereLike('med.Apellido', '%'.$apellido.'%')
                                    ->orWhereLike('med.Nombre', '%'.$apellido.'%')
                                    ->where('med.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Médicos Por Apellido. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Médicos Por Apellido. Error: no se encontraron datos');
        }
    });

    $app->post('/pornombre', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Nombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $nombre = filter_var(substr($datapost['Nombre'], 0, 50), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('med.Id', 'med.Nombre', 'med.Apellido', 'med.Matricula', 'med.TipoMatricula', 'med.Domicilio1', 'med.Telefono1', 'med.Domicilio2', 'med.Telefono2'))
                                    ->from('Medicos med')
                                    ->whereLike('med.Nombre', '%'.$nombre.'%')
                                    ->where('med.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Médicos Por Nombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Médicos Por Nombre. Error: no se encontraron datos');
        }
    });

    $app->post('/pormatricula', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Matricula'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $matricula = filter_var(substr($datapost['Matricula'], 0, 50), FILTER_SANITIZE_NUMBER_INT);

        $data = MedicosPorMatricula($matricula);

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Médicos Por Matrícula. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Médicos Por Matrícula. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de todos los medicos existentes no borradas
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de los medicos encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('Id', 'Matricula', 'TipoMatricula', 'Nombre', 'Apellido', 'Domicilio1', 'Telefono1', 'Domicilio2', 'Telefono2'))
                                    ->from('Medicos')
                                    ->where('EstaBorrado', '=', (int) 0);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Médicos. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han encontrado datos";
            echoResponse2(200, $response, 'Get General Médicos. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de un medicos existente no borrado, segun un Id ingresado
    *
    * @param $Id -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del medico encontrado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){        
        $selectStatement = $app->pdo->select(array('Matricula', 'TipoMatricula', 'Nombre', 'Apellido', 'Domicilio1', 'Telefono1', 'Domicilio2', 'Telefono2'))
                                    ->from('Medicos')
                                    ->where('Id', '=', $id)
                                    ->where('EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Médicos Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han encontrado datos";
            echoResponse2(200, $response, 'Get Médicos Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/pacientes', function() use($app){

    /** 
    * Crea un nuevo paciente
    *
    * @param $Id -> int
    *        $NumPaciente -> string
    *        $ApellidoNombre -> string
    *        $FechaNacimiento -> date
    *        $Sexo -> int
    *        $Origen -> string
    *        $Cuenta -> string
    *        $Direccion -> string
    *        $NumDocumento -> int
    *        $Telefono -> int
    *        $Celular -> int
    *        $Lugar -> string
    *        $Mail -> int
    *        $MatriculaMedico -> int
    *        $Mutual1 -> int
    *        $DebeOrden1 -> int
    *        $NumAfiliado1 -> int
    *        $TipoAfiliado1 -> int
    *        $Mutual2 -> int
    *        $DebeOrden2 -> int
    *        $NumAfiliado2 -> int
    *        $TipoAfiliado2 -> int
    *        $Factor -> decimal
    *        $ActoProf -> string
    *        $Practicas -> array(PracticaId)
    *        $CreadoEn -> int
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y en data el id del paciente creado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumPaciente', 'ApellidoNombre', 'CreadoEn', 'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        
        if ($datapost['CreadoEn'] == 0) //verifica el campo CreadoEn para saber en qué pantalla se creó el paciente
        {
            $numPaciente = GenerarNumeroPaciente(); //El paciente se crea en Ingreso Normal -> autogenera NumPaciente
        }
        else
        {
            $numPaciente = substr($datapost['NumPaciente'], 0, 8); //El paciente se crea en Ingreso 1 a 1 -> ya posee NumPacinte
            
            //verifica largo y validez del NumPaciente ingresado
            if (strlen($numPaciente) !== 8 || substr($numPaciente, -3) === '000') 
            {
                $response["error"] = TRUE;
                $response["data"] = "Número de paciente incorrecto.";
                echoResponse2(200, $response, 'Crear Paciente. Error: número de paciente incorrecto');
                $app->stop();
            }            
        }
        
        $apellidoNombre = filter_var(ucwords(strtolower(substr($datapost['ApellidoNombre'], 0, 100))), FILTER_SANITIZE_STRING);        
        $fechaNacimiento = filter_var($datapost['FechaNacimiento'], FILTER_SANITIZE_STRING);
        $sexo = filter_var($datapost['Sexo'], FILTER_SANITIZE_STRING);
        $origen = filter_var(substr($datapost['Origen'], 0, 1), FILTER_SANITIZE_STRING);
        $cuenta = filter_var(substr($datapost['Cuenta'], 0, 4), FILTER_SANITIZE_STRING);
        $direccion = filter_var(substr($datapost['Direccion'], 0, 50), FILTER_SANITIZE_STRING);
        $numDocumento = filter_var(substr($datapost['NumDocumento'], 0, 10), FILTER_SANITIZE_STRING);
        $telefono = filter_var(substr((int)$datapost['Telefono'], 0, 50), FILTER_SANITIZE_NUMBER_INT);
        $celular = filter_var(substr($datapost['Celular'], 0, 50), FILTER_SANITIZE_STRING);
        $lugar = filter_var(substr($datapost['Lugar'], 0, 100), FILTER_SANITIZE_STRING);
        $mail = filter_var(substr($datapost['Mail'], 0, 100), FILTER_SANITIZE_EMAIL);
        $matriculaMedico = filter_var($datapost['MatriculaMedico'], FILTER_SANITIZE_NUMBER_INT);
        $mutual1 = filter_var($datapost['Mutual1'], FILTER_SANITIZE_NUMBER_INT);
        $debeOrden1 = filter_var($datapost['DebeOrden1'], FILTER_SANITIZE_STRING);
        $numAfiliado1 = filter_var(substr($datapost['NumAfiliado1'], 0, 20), FILTER_SANITIZE_STRING);
        $tipoAfiliado1 = filter_var($datapost['TipoAfiliado1'], FILTER_SANITIZE_STRING);
        $mutual2 = filter_var($datapost['Mutual2'], FILTER_SANITIZE_NUMBER_INT);
        $debeOrden2 = filter_var($datapost['DebeOrden2'], FILTER_SANITIZE_STRING);
        $numAfiliado2 = filter_var(substr($datapost['NumAfiliado2'], 0, 20), FILTER_SANITIZE_STRING);
        $tipoAfiliado2 = filter_var($datapost['TipoAfiliado2'], FILTER_SANITIZE_STRING);
        $factor = filter_var($datapost['Factor'], FILTER_SANITIZE_STRING);        
        $actoProf = filter_var(substr($datapost['ActoProf'], 0, 2), FILTER_SANITIZE_STRING);
        $practicas = $datapost['Practicas'];        
        $cama = filter_var(substr($datapost['Cama'], 0, 4), FILTER_SANITIZE_STRING);
        $sinCargo = filter_var(substr($datapost['SinCargo'], 0, 1), FILTER_SANITIZE_STRING);
        $realizaDesc = filter_var(substr($datapost['RealizaDescuentos'], 0, 1), FILTER_SANITIZE_STRING);
        $reajustaImporte = filter_var(substr($datapost['ReajustaImporte'], 0, 1), FILTER_SANITIZE_STRING);
        $abonoSena = filter_var(substr($datapost['AbonoSena'], 0, 10), FILTER_SANITIZE_STRING);
        $comentarios = filter_var(substr($datapost['Comentarios'], 0, 500), FILTER_SANITIZE_STRING);
        $creadoEn = filter_var($datapost['CreadoEn'], FILTER_SANITIZE_STRING);
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //checkea que el NumPaciente no esté repetido
        if ($app->pdo->CheckearNumeroPaciente($numPaciente)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Número de paciente repetido";
            echoResponse2(200, $response, 'Crear Paciente. Error: número de paciente repetido');
            $app->stop();
        }  

        //hace NULL el $mail si viene vacío
        if($mail == '')
        {
            $mail = NULL;
        }
        else
        {
            //checkea el formato del $mail, si es distinto de vacío
            if (!checkEmail($mail)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Email incorrecto";
                echoResponse2(200, $response, 'Crear Paciente. Error: email incorrecto');
                $app->stop();
            }
            else
            {
                //checkea que el email ingresado no esté repetido para pacientes nuevos
                if($app->pdo->CheckearEmailPaciente($mail) && $id == NULL)
                {
                    $response["error"] = TRUE;
                    $response["data"] = "Email repetido";
                    echoResponse2(200, $response, 'Crear Paciente. Error: email repetido');
                    $app->stop();
                }
            }            
        }

        //hace NULL $numDocumento si viene vacío
        if($numDocumento == '')
        {
            $numDocumento = NULL;
        }
        else
        {
            //checkea que el número de documento ingresado no esté repetido para pacientes nuevos
            if ($app->pdo->CheckearNumDocPaciente($numDocumento) && $id == NULL) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Número de documento repetido";
                echoResponse2(200, $response, 'Crear Paciente. Error: número de documento repetido');
                $app->stop();
            }
        } 

        //hace NULL la matrícula del médico si viene vacío  
        if($matriculaMedico == '')
        {
            $matriculaMedico = NULL;
        }
        else
        {
            //checkea que el médico todavía exista
            if (!$app->pdo->ExisteMedico($matriculaMedico)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "El médico no existe";
                echoResponse2(200, $response, 'Crear Paciente. Error: el médico elegido no existe');
                $app->stop();
            }
        }

        //checkea si la mutual1 es 0 le corresponde Null a todos los campos asociados a mutual1
        if ($mutual1 == 0 || $mutual1 == '') 
        {
            $mutual1 = NULL;
            $debeOrden1 = NULL;
            $numAfiliado1 = NULL;
            $tipoAfiliado1 = NULL;
        }
        else
        {   //checkea si todavía existe la mutual.
            if (!$app->pdo->ExisteMutual($mutual1)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "La mutual 1 no existe";
                echoResponse2(200, $response, 'Crear Paciente. Error: la mutual 1 elegida no existe');
                $app->stop();
            }
        }     

        //checkea si la mutual2 es 0 le corresponde Null a todos los campos asociados a mutual2
        if ($mutual2 == 0 || $mutual2 == '') 
        {
            $mutual2 = NULL;
            $debeOrden2 = NULL;
            $numAfiliado2 = NULL;
            $tipoAfiliado2 = NULL;
        }
        else
        {   //checkea si todavía existe la mutual.
            if (!$app->pdo->ExisteMutual($mutual2)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "La mutual 2 no existe";
                echoResponse2(200, $response, 'Crear Paciente. Error: la mutual 2 elegida no existe');
                $app->stop();
            }
        }    

        //hace NULL a todos los campos que vengan vacíos
        $fechaNacimiento === '' ? $fechaNacimiento = NULL : '';
        $sexo === '' ? $sexo = NULL : '';
        $origen === '' ? $origen = NULL : '';       
        $cuenta === '' ? $cuenta = NULL : ''; 
        $direccion === '' ? $direccion = NULL : '';
        $telefono == '' ? $telefono = NULL : '';
        $telefono === 0 ? $telefono = NULL : '';
        $celular === '' ? $celular = NULL : '';
        $lugar === '' ? $lugar = NULL : '';
        $factor === '' ? $factor = NULL : '';
        $actoProf === '' ? $actoProf = NULL : '';
        $debeOrden1 === '' ? $debeOrden1 = NULL : '';
        $tipoAfiliado1 === '' ? $tipoAfiliado1 = NULL : '';
        $debeOrden2 === '' ? $debeOrden2 = NULL : '';
        $tipoAfiliado2 === '' ? $tipoAfiliado2 = NULL : '';
        $cama === '' ? $cama = NULL : '';
        $sinCargo === '' ? $sinCargo = NULL : '';
        $realizaDesc === '' ? $realizaDesc = NULL : '';
        $reajustaImporte === '' ? $reajustaImporte = NULL : '';
        $abonoSena === '' ? $abonoSena = NULL : '';
        $comentarios === '' ? $comentarios = NULL : '';

        if ($id == NULL) 
        {   //ToDo migrar a una transaccion
            //Crear paciente nuevo
            $result = $app->pdo->CrearPaciente(array($apellidoNombre, $fechaNacimiento, $sexo, $origen, $cuenta, $direccion, $numDocumento, $telefono, $celular, $lugar, $mail, $matriculaMedico, $mutual1, $debeOrden1, $numAfiliado1, $tipoAfiliado1, $mutual2, $debeOrden2, $numAfiliado2, $tipoAfiliado2, $factor, $actoProf, $creadoEn, $creadoPor));
            if ($result)
            {   //si se crea bien el paciente, crear Ingreso del paciente nuevo
                $resultIng = $app->pdo->CrearIngreso(array($numPaciente, $result, $cama, $sinCargo, $realizaDesc, $reajustaImporte, $abonoSena, $comentarios, $creadoPor));    
            }
            if ($resultIng)
            {   //checkeo si se crea un paciente sin ninguna practica
                if ($practicas[0] !== NULL) 
                {
                    //si se crea bien el Ingreso del paciente, crear IngresoPractica del paciente nuevo
                    $ppresult = $app->pdo->CrearIngresoPractica(array($resultIng, $creadoPor), $practicas);   
                }
                else
                {
                    $ppresult = TRUE;
                }
            }            
        }
        else
        {
            //checkea si el paciente existente ingresado, todavia existe
            if (!$app->pdo->ExistePaciente($id))
            {
                $response["error"] = TRUE;
                $response["data"] = "El paciente no existe";
                echoResponse2(200, $response, 'Crear Paciente. Error: el paciente no existe');
                $app->stop();
            }

            //Paciente existente-> modifica el paciente, crea el Ingreso del paciente existente y crea el IngresoPractica del paciente existente
            $result = $app->pdo->ModificarPaciente(array($id, $apellidoNombre, $fechaNacimiento, $sexo, $origen, $cuenta, $direccion, $numDocumento, $telefono, $celular, $lugar, $mail, $matriculaMedico, $mutual1, $debeOrden1, $numAfiliado1, $tipoAfiliado1, $mutual2, $debeOrden2, $numAfiliado2, $tipoAfiliado2, $factor, $actoProf, $creadoPor));
            if($result)
            {   //si se modifica bien el paciente, crea el ingreso del paciente existente
                $resultIng = $app->pdo->CrearIngreso(array($numPaciente, $id, $cama, $sinCargo, $realizaDesc, $reajustaImporte, $abonoSena, $comentarios, $creadoPor));
            }
            if ($resultIng)
            {   
                //checkeo que las practicas vengan con datos
                if ($practicas[0] !== NULL) 
                {
                    //si se crea bien el ingreso del paciente existente, se crea el IngresoPractica del paciente existente                
                    $ppresult = $app->pdo->CrearIngresoPractica(array($resultIng, $creadoPor), $practicas);
                }
                else
                {
                    $ppresult = TRUE;
                }
            }            
        }

        if($result && $resultIng && $ppresult)         
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Paciente. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "Paciente no creado";
            echoResponse2(400, $response, 'Crear Paciente. Error: el paciente no se creó');
        }
    });

    /** 
    * Modifica un paciente
    *
    * @param $Id -> int
    *        $NumPaciente -> string
    *        $ApellidoNombre -> string    
    *        $FechaNacimiento -> date
    *        $Sexo -> int
    *        $Origen -> string
    *        $Cuenta -> string
    *        $Direccion -> string
    *        $Telefono -> int
    *        $Celular -> int
    *        $Mutual1 -> int
    *        $DebeOrden1 -> int
    *        $NumAfiliado1 -> int
    *        $TipoAfiliado1 -> int
    *        $Mutual2 -> int
    *        $DebeOrden2 -> int
    *        $NumAfiliado2 -> int
    *        $TipoAfiliado2 -> int
    *        $Factor -> decimal
    *        $ActoProf -> string   
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si el paciente indicado se modifica y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'ApellidoNombre', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $idIngreso = filter_var(substr($datapost['IngresoId'], 0, 10), FILTER_SANITIZE_STRING);
        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);        
        $apellidoNombre = filter_var(ucwords(strtolower(substr($datapost['ApellidoNombre'], 0, 100))), FILTER_SANITIZE_STRING);        
        $fechaNacimiento = filter_var($datapost['FechaNacimiento'], FILTER_SANITIZE_STRING);
        $sexo = filter_var($datapost['Sexo'], FILTER_SANITIZE_STRING);
        $origen = filter_var(substr($datapost['Origen'], 0, 1), FILTER_SANITIZE_STRING);
        $cuenta = filter_var(substr($datapost['Cuenta'], 0, 4), FILTER_SANITIZE_STRING);
        $direccion = filter_var(substr($datapost['Direccion'], 0, 50), FILTER_SANITIZE_STRING);
        $numDocumento = filter_var(substr($datapost['NumDocumento'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $telefono = filter_var(substr($datapost['Telefono'], 0, 50), FILTER_SANITIZE_STRING);
        $celular = filter_var(substr($datapost['Celular'], 0, 50), FILTER_SANITIZE_STRING);
        $lugar = filter_var(substr($datapost['Lugar'], 0, 100), FILTER_SANITIZE_STRING);
        $mail = filter_var(substr($datapost['Mail'], 0, 100), FILTER_SANITIZE_EMAIL);
        $matriculaMedico = filter_var($datapost['MatriculaMedico'], FILTER_SANITIZE_STRING);
        $mutual1 = filter_var($datapost['Mutual1'], FILTER_SANITIZE_STRING);
        $debeOrden1 = filter_var($datapost['DebeOrden1'], FILTER_SANITIZE_STRING);
        $numAfiliado1 = filter_var(substr($datapost['NumAfiliado1'], 0, 20), FILTER_SANITIZE_STRING);
        $tipoAfiliado1 = filter_var($datapost['TipoAfiliado1'], FILTER_SANITIZE_STRING);
        $mutual2 = filter_var($datapost['Mutual2'], FILTER_SANITIZE_STRING);
        $debeOrden2 = filter_var($datapost['DebeOrden2'], FILTER_SANITIZE_STRING);
        $numAfiliado2 = filter_var(substr($datapost['NumAfiliado2'], 0, 20), FILTER_SANITIZE_STRING);
        $tipoAfiliado2 = filter_var($datapost['TipoAfiliado2'], FILTER_SANITIZE_STRING);
        $factor = filter_var($datapost['Factor'], FILTER_SANITIZE_STRING);        
        $actoProf = filter_var(substr($datapost['ActoProf'], 0, 2), FILTER_SANITIZE_STRING);
        $practicas = $datapost['Practicas'];
        $cama = filter_var(substr($datapost['Cama'], 0, 4), FILTER_SANITIZE_STRING);
        $sinCargo = filter_var(substr($datapost['SinCargo'], 0, 1), FILTER_SANITIZE_STRING);
        $realizaDesc = filter_var(substr($datapost['RealizaDescuentos'], 0, 1), FILTER_SANITIZE_STRING);
        $reajustaImporte = filter_var(substr($datapost['ReajustaImporte'], 0, 1), FILTER_SANITIZE_STRING);
        $abonoSena = filter_var(substr($datapost['AbonoSena'], 0, 10), FILTER_SANITIZE_STRING);
        $comentarios = filter_var(substr($datapost['Comentarios'], 0, 500), FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //busca el paciente por Id
        $paciente = $app->pdo->ExistePaciente($id);        

        //checkeao la existencia del paciente
        if (!$paciente)
        {   //paciente inexistente
            $response["error"] = TRUE;
            $response["data"] = "El paciente no existe";
            echoResponse2(200, $response, 'Modificar Paciente. Error: el paciente no existe');
            $app->stop();
        }   

        //checkea si el numero de documento viene vacío, le corresponde NULL
        if ($numDocumento == '')
        {
            $numDocumento = NULL;
        }
        else
        {   //si el numero de documento viene con datos, checkeo si se modifica
            if ($paciente[0]['NumDocumento'] !== (int) $numDocumento) 
            {   //checkea que el nuevo número de documento no se repita
                if ($app->pdo->CheckearNumDocPaciente($numDocumento))
                {   //número de documento nuevo repetido
                    $response["error"] = TRUE;
                    $response["data"] = "Número de documento de paciente repetido";
                    echoResponse2(200, $response, 'Modificar Paciente. Error: número de documento repetido');
                    $app->stop();
                }
            }
        }

        //checkea si el mail vacío, le corresponde NULL
        if ($mail == '')
        {
            $mail = NULL;
        }
        else
        {   //si el mail viene con datos, checkeo si se modifica
            if ($paciente[0]['Mail'] !== $mail)
            {   //checkea el formato del nuevo mail
                if (!checkEmail($mail))
                {
                    $response["error"] = TRUE;
                    $response["data"] = "Mail de paciente incorrecto";
                    echoResponse2(200, $response, 'Modificar Paciente. Error: mail incorrect');
                    $app->stop();
                }

                //checkea la existencia el nuevo mail
                if ($app->pdo->CheckearEmailPaciente($mail))
                {   //mail nuevo repetido
                    $response["error"] = TRUE;
                    $response["data"] = "Mail de paciente repetido";
                    echoResponse2(200, $response, 'Modificar Paciente. Error: mail repetido');
                    $app->stop();
                }
            }
        }

        //hace NULL la matrícula del médico si viene vacía
        if($matriculaMedico == '')
        {
            $matriculaMedico = NULL;
        }
        else
        {
            //checkea que el médico todavía exista
            if (!$app->pdo->ExisteMedico($matriculaMedico)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "El médico no existe";
                echoResponse2(200, $response, 'Modificar Paciente. Error: el médico elegido no existe');
                $app->stop();
            }
        }    

        //checkea si la mutual1 es 0 le corresponde Null a todos los campos asociados a mutual1
        if ($mutual1 == 0 || $mutual1 == '') 
        {
            $mutual1 = NULL;
            $debeOrden1 = NULL;
            $numAfiliado1 = NULL;
            $tipoAfiliado1 = NULL;
        }
        else
        {   //si la mutual1 es distinta de 0, entonces consulta si todavía existe.
            if (!$app->pdo->ExisteMutual($mutual1)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "La mutual 1 no existe";
                echoResponse2(200, $response, 'Modificar Paciente. Error: la mutual 1 elegida no existe');
                $app->stop();
            }
        }       

        //checkea si la mutual2 es 0 le corresponde Null a todos los campos asociados a mutual2
        if ($mutual2 == 0 || $mutual2 == '') 
        {
            $mutual2 = NULL;
            $debeOrden2 = NULL;
            $numAfiliado2 = NULL;
            $tipoAfiliado2 = NULL;
        }
        else
        {   //si la mutual2 es distinta de 0, entonces consulta si todavía existe.
            if (!$app->pdo->ExisteMutual($mutual2)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "La mutual 2 no existe";
                echoResponse2(200, $response, 'Modificar Paciente. Error: la mutual 2 elegida no existe');
                $app->stop();
            }
        }

        //hace NULL todos los campos que vengan vacíos
        $fechaNacimiento === '' ? $fechaNacimiento = NULL : '';
        $sexo === '' ? $sexo = NULL : '';
        $origen === '' ? $origen = NULL : ''; 
        $cuenta === '' ? $cuenta = NULL : '';
        $direccion === '' ? $direccion = NULL : '';
        $telefono == '' ? $telefono = NULL : '';
        $telefono === 0 ? $telefono = NULL : '';
        $telefono === '0' ? $telefono = NULL : '';
        $celular === '' ? $celular = NULL : '';
        $lugar === '' ? $lugar = NULL : '';
        $factor === '' ? $factor = NULL : '';
        $actoProf === '' ? $actoProf = NULL : '';        
        $cama === '' ? $cama = NULL : '';
        $sinCargo === '' ? $sinCargo = NULL : '';
        $realizaDesc === '' ? $realizaDesc = NULL : '';
        $reajustaImporte === '' ? $reajustaImporte = NULL : '';
        $abonoSena === '' ? $abonoSena = NULL : '';
        $comentarios === '' ? $comentarios = NULL : '';
        $debeOrden1 === '' ? $debeOrden1 = NULL : '';
        $numAfiliado1 === '' ? $numAfiliado1 = NULL : '';
        $tipoAfiliado1 === '' ? $tipoAfiliado1 = NULL : '';
        $debeOrden2 === '' ? $debeOrden2 = NULL : '';
        $numAfiliado2 === '' ? $numAfiliado2 = NULL : '';
        $tipoAfiliado2 === '' ? $tipoAfiliado2 = NULL : '';

        $practicas == NULL ? $practicas = NULL : '';

        //modifica el paciente
        $result = $app->pdo->ModificarPaciente(array($id, $apellidoNombre, $fechaNacimiento, $sexo, $origen, $cuenta, $direccion, $numDocumento, $telefono, $celular, $lugar, $mail, $matriculaMedico, $mutual1, $debeOrden1, $numAfiliado1, $tipoAfiliado1, $mutual2, $debeOrden2, $numAfiliado2, $tipoAfiliado2, $factor, $actoProf, $modificadoPor));
        
        if ($result) 
        {
            $resultIng = $app->pdo->ModificarIngreso(array($idIngreso, $cama, $sinCargo, $realizaDesc, $reajustaImporte, $abonoSena, $comentarios, $modificadoPor), $practicas);
        }

        if ($result && $resultIng) 
        {        
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Paciente. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El paciente no se modificó";
            echoResponse2(400, $response, 'Modificar Paciente. Error: el paciente no se modificó');
        }        
    });

    /** 
    * Elimina un paciente
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si el paciente indicado se elimina y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('IngresoId', 'PacienteId', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $ingresoid = filter_var(substr($datapost['IngresoId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $pacienteid = filter_var(substr($datapost['PacienteId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //checkea que el paciente exista por id
        if (!$app->pdo->ExistePaciente($pacienteid)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "El paciente no existe";
            echoResponse2(200, $response, 'Eliminar Paciente. Error: el paciente no existe');
            $app->stop();
        }

        //elimina el paciente
        $result = $app->pdo->EliminarPaciente(array($pacienteid, $modificadoPor));

        //checkeo que se elminó el paciente
        if ($result)
        {               
            //elimino los ingresos correspondientes al paciente eliminado
            $resultIng = $app->pdo->EliminarIngreso(array($pacienteid, $modificadoPor));            
            //checkeo que se elimino el ingreso del paciente eliminado            
        }        
        
        if ($result && $resultIng)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Paciente. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El paciente no se eliminó";
            echoResponse2(400, $response, 'Eliminar Paciente. Error: el paciente no se eliminó');
        }
    });    

    /** 
    * Obtiene los datos de todos los pacientes existentes.
    *
    * @return Retorna, en caso de éxito, error False y en data los datos de los pacientes encontrados y, si falla, 
    *         error en True y en data el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){       
        $response = array();

        $selectStatement = $app->pdo->select(array('p.Id', 'p.ApellidoNombre', 'p.FechaNacimiento', 'p.Sexo', 'p.Origen', 'p.Cuenta', 'p.Direccion', 'p.NumDocumento', 'p.Telefono', 'p.Celular', 'p.Lugar', 'p.Mail', 'p.MatriculaMedico', 'm.Nombre as Mutual1', 'm.Codigo as CodMutual1', 'p.DebeOrden1', 'p.NumAfiliado1', 'p.TipoAfiliado1', 'n.Nombre as Mutual2', 'n.Codigo as CodMutual2', 'p.DebeOrden2', 'p.NumAfiliado2', 'p.TipoAfiliado2', 'p.Factor', 'p.ActoProf', 'p.CreadoEn'))
                                    ->from('Pacientes p')
                                    ->join('Mutuales m', 'p.Mutual1', '=', 'm.Id', 'LEFT')
                                    ->join('Mutuales n', 'p.Mutual2', '=', 'n.Id', 'LEFT')
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->orderby('p.Id');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Pacientes. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get General Pacientes. Erro: no se encontraron datos');
        }
    });

    /** 
    * Obtiene una cantidad de pacientes según una cantidad ingresada.
    *
    * @param $cantPacientes -> int
    *
    * @return Retorna, en caso de éxito, error False y en data los datos de los pacientes encontrados y, si falla, 
    *         error en True y en data el mensaje de error.
    */
    $app->post('/paginado', 'Autenticar', function() use($app){
        verifyRequiredParams(array('CantPacientes'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $cantPacientes = filter_var(substr($datapost['CantPacientes'], 0, 3), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('p.Id', 'p.ApellidoNombre', 'p.FechaNacimiento', 'p.Sexo', 'p.Origen', 'p.Cuenta', 'p.Direccion', 'p.NumDocumento', 'p.Telefono', 'p.Celular', 'p.Lugar', 'p.Mail', 'p.MatriculaMedico', 'm.Nombre as Mutual1', 'm.Codigo as CodMutual1', 'p.DebeOrden1', 'p.NumAfiliado1', 'p.TipoAfiliado1', 'n.Nombre as Mutual2', 'n.Codigo as CodMutual2', 'p.DebeOrden2', 'p.NumAfiliado2', 'p.TipoAfiliado2', 'p.Factor', 'p.ActoProf', 'p.CreadoEn'))
                                    ->from('Pacientes p')
                                    ->join('Mutuales m', 'p.Mutual1', '=', 'm.Id', 'LEFT')
                                    ->join('Mutuales n', 'p.Mutual2', '=', 'n.Id', 'LEFT')
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->orderby('p.Id')
                                    ->limit(20, ($cantPacientes-1)*20);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('p.Id', $as = 'Total')
                        ->from('Pacientes p')
                        ->where('p.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($cantPacientes-1)*20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Pacientes Paginado. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Pacientes Paginado. Erro: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los pacientes coincidentes con el ApellidoNombre ingresado
    *
    * @param $ApellidoNombre -> string
    *
    * @return Retorna, en caso de éxito, error False, en data los datos de los pacientes encontrados y en cantidad el numero 
    *         de pacientes encontrados y, si falla, error en True y en data el mensaje de error.
    */
    $app->post('/pornombre', 'Autenticar', function() use($app){
        verifyRequiredParams(array('ApellidoNombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $apellidonombre = filter_var(ucwords(strtolower(substr($datapost['ApellidoNombre'], 0, 100))), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('pac.Id', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail',/* 'med.Id', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed',*/ 'mut1.Id as Mutual1Id', 'mut1.Codigo as CodMutual1', 'mut1.Nombre as NombreMutual1', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as CodMutual2', 'mut2.Nombre as NombreMutual2', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf', 'ing.Cama'))
                                    ->from('Pacientes pac')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->join('Ingresos ing', 'pac.Id', '=', 'ing.PacienteId', 'LEFT')
                                    ->whereLike('pac.ApellidoNombre', '%'.$apellidonombre.'%')
                                    ->where('pac.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Pacientes ApellidoNombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = 'No se encontraron datos';
            echoResponse2(200, $response, 'Get Pacientes ApellidoNombre. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los pacientes existentes, creados entre las fechas ingresadas.
    *
    * @param $desde -> date
    *        $hasta -> date
    *
    * @return Retorna, en caso de éxito, error False y en data los datos de los pacientes y, si falla, 
    *         error en True y en data el mensaje de error.
    */
    $app->post('/pacientesfecha', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Desde', 'Hasta', 'CantPacientes'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $desde = filter_var($datapost['Desde'], FILTER_SANITIZE_STRING);
        $hasta = filter_var($datapost['Hasta'], FILTER_SANITIZE_STRING);
        $cantPacientes = filter_var(substr($datapost['CantPacientes'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        
        //checkea que la fecha de inicio no sea inválida
        if ($desde === '' || $desde == NULL || $desde === undefined) 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se indicó una fecha de inicio";
            echoResponse2(200, $response, 'Get Pacientes Fecha. Error: no hay fecha de inicio');
            $app->stop();
        }
        else
        {   //si la fecha de inicio es válida completa la fecha para comparar con un tipo datetime
            $desde = $desde.' 00:00:00';
        }

        //checkea que la fecha límite no sea inválida
        if ($hasta === '' || $desde == NULL || $desde === undefined)
        {
            $response["error"] = TRUE;
            $response["data"] = "No se indicó una fecha límite";
            echoResponse2(200, $response, 'Get Pacientes Fecha. Error: no hay fecha límite');
            $app->stop();
        }
        else
        {   //si la fecha límite es válida completa la fecha para comparar con un tipo datetime
            $hasta = $hasta.' 23:59:59';
        }  

        $selectStatement = $app->pdo->select(array('p.Id', 'p.ApellidoNombre', 'p.FechaNacimiento', 'p.Sexo', 'p.Origen', 'p.Cuenta', 'p.Direccion', 'p.NumDocumento', 'p.Telefono', 'p.Celular', 'p.Lugar', 'p.Mail', 'p.MatriculaMedico', 'med.Matricula', 'med.Apellido as MedApellido', 'med.Nombre as MedNombre', 'm.Nombre as Mutual1', 'm.Codigo as CodMutual1', 'p.DebeOrden1', 'm.PorcCobertura as PorcCobertura1', 'p.NumAfiliado1', 'p.TipoAfiliado1', 'n.Nombre as Mutual2', 'n.Codigo as CodMutual2', 'p.DebeOrden2', 'p.NumAfiliado2', 'p.TipoAfiliado2', 'n.PorcCobertura as PorcCobertura2', 'p.Factor', 'p.ActoProf', 'p.CreadoEn', 'p.CreadoFecha'))
                                    ->from('Pacientes p')
                                    ->join('Mutuales m', 'p.Mutual1', '=', 'm.Id', 'LEFT')
                                    ->join('Mutuales n', 'p.Mutual2', '=', 'n.Id', 'LEFT')
                                    ->join('Medicos med', 'p.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->where('p.CreadoFecha', '>=', $desde)
                                    ->where('p.CreadoFecha', '<=', $hasta)                                    
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($cantPacientes-1)*20)
                                    ->orderby('p.Id');
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();        

        $selectStatement->count('p.Id', $as = 'Total') //ToDo pasar a un stored procedure
                        ->from('Pacientes p')
                        ->where('p.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($cantPacientes-1)*20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Pacientes Fecha. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Pacientes Fecha. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los ingresos existentes
    *
    * @return Retorna error en False y en data los ingresos encontrados, y error en True si no encuentra datos.
    */
    $app->get('/numpaciente', 'Autenticar', function() use ($app){                
        $response = array();

        $selectStatement = $app->pdo->select(array('ing.Id', 'ing.NumPaciente', 'ing.PacienteId'))
                                    ->from('Ingresos ing')
                                    ->where('ing.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Ingresos. Correcto');            
        }
        else
        {
            $response["error"] = FALSE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get General Ingresos. Error: no se encontraron datos');
        }
    });    

    /** 
    * Checkea que el número de paciente ingresado está disponible o no.
    *
    * @param $NumPaciente -> int
    *
    * @return Retorna un error False si el número de paciente está disponible y un error True si está ocupado.
    */
    $app->get('/numpaciente/:numpaciente', 'Autenticar', function($numpaciente) use ($app){        
        //checkea el largo y validez el número de paciente ingresado
        if ((strlen($numpaciente) !== 8) || (substr($numpaciente, -3) == '000')) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Número de paciente incorrecto.";
            echoResponse2(200, $response, 'Get Pacientes NumPaciente. Error: número de paciente incorrecto');
            $app->stop();
        }

        $selectStatement = $app->pdo->select(array('ing.Id', 'ing.NumPaciente'))
                                    ->from('Ingresos ing')
                                    ->where('ing.NumPaciente', '=', $numpaciente);

        $response = array();

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Número de paciente ocupado.";
            echoResponse2(200, $response, 'Get Paciente NumPaciente. Error: número de paciente repetido');
            $app->stop();
        }
        else
        {
            $response["error"] = FALSE;
            $response["data"] = "Número de paciente disponible.";
            echoResponse2(200, $response, 'Get Paciente NumPaciente. Correcto: número paciente disponible');
        }
    });

    /** 
    * Obtiene el numero de pciente del proximo paciente a ingresar
    *
    * @return Retorna el numero de paciente del proximo paciente.
    */
    $app->get('/ultimo', 'Autenticar', function() use($app){
        //obtiene el último número de paciente
        $data = GenerarNumeroPaciente();

        $response = array();

        if ($data) 
        {
            $response["data"] = $data;
            $response["error"] = FALSE;
            echoResponse2(200, $response, 'Get Pacientes Ultimo. Correcto');
        }
        else
        {
            $response["data"] = $data;
            $response["error"] = TRUE;
            echoResponse2(200, $response, 'Get Pacientes Ultimo. Error: no existe ultimo');
        }        
    });

    $app->post('/pordocumento', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumDocumento'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $dni = filter_var(substr($datapost['NumDocumento'], 0, 10), FILTER_SANITIZE_NUMBER_INT);        

        $data = PacientesPorDocumento($dni);

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Pacientes Por Documento. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Pacientes Por Documento. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de todos los pacientes no borrados con dni distinto de nulo
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del los pacientes encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/condocumento', 'Autenticar', function() use ($app){                
        //obtiene solo pacientes con dni distinto de NULL
        
        $data = PacientesConDNI();

        $response = array();

        if ($data) 
        {
            $response["data"] = $data;
            $response["error"] = FALSE;
            echoResponse2(200, $response, 'Get Pacientes ConDocumento. Correcto');
        }
        else
        {            
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Pacientes ConDocumento. Error: no se encontraron datos');
        }       
    });

    /** 
    * Obtiene los datos de un paciente no borrado segun su numero de documento
    *
    * @param $doc -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del paciente encontrado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/documento/:doc', 'Autenticar', function($doc) use ($app){
        $selectStatement = $app->pdo->select(array('p.Id', 'p.ApellidoNombre', 'p.FechaNacimiento', 'p.Sexo', 'p.Origen', 'p.Cuenta', 'p.Direccion', 'p.NumDocumento', 'p.Telefono', 'p.Celular', 'p.Lugar', 'p.Mail', 'p.MatriculaMedico', 'p.Mutual1', 'p.DebeOrden1', 'p.NumAfiliado1', 'p.TipoAfiliado1', 'p.Mutual2', 'p.DebeOrden2', 'p.NumAfiliado2', 'p.TipoAfiliado2', 'p.Factor', 'p.ActoProf', 'p.CreadoEn'))
                                    ->from('Pacientes p')
                                    ->where('p.NumDocumento', '=', $doc)                                    
                                    ->where('p.EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["data"] = $data;
            $response["error"] = FALSE;
            echoResponse2(200, $response, 'Get Pacientes Documento. Correcto');
        }
        else
        {
            $response["data"] = "No se encontraron datos";
            $response["error"] = TRUE;
            echoResponse2(200, $response, 'Get Pacientes Documento. Error: no se encontraron datos');
        }       
    });   

    /** 
    * Obtiene los datos de un paciente no borrado segun un id ingresado
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del paciente encontrado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/resultados/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('pac.Id', 
                                                   'pac.ApellidoNombre', 
                                                   'pac.FechaNacimiento', 
                                                   'pac.NumDocumento', 
                                                   'pac.Sexo', 
                                                   'pac.Origen', 
                                                   'pac.MatriculaMedico', 
                                                   'med.Apellido as ApellidoMed', 
                                                   'med.Nombre as NombreMed', 
                                                   'ing.Id as IngresoId', 
                                                   'ing.NumPaciente', 
                                                   'ing.Cama', 
                                                   'ingp.Id as IngresoPracticaId', 
                                                   'ingp.NomencladorId as NomencladorId', 
                                                   'nom.Codigo as NomencladorCodigo', 
                                                   'nom.Nombre as NomencladorNombre', 
                                                   'tit.Unidades', 
                                                   'tit.ValoresReferenciaAmpliados'))
                                    ->from('Pacientes pac')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->join('Ingresos ing', 'pac.Id', '=', 'ing.PacienteId', 'INNER')
                                    ->join('IngresosPracticas ingp', 'ing.Id', '=', 'ingp.IngresoId', 'LEFT')                                    
                                    ->join('Nomencladores nom', 'ingp.NomencladorId', '=', 'nom.Id', 'LEFT')
                                    ->join('Titulos tit', 'nom.Codigo', '=', 'tit.Codigo', 'LEFT')
                                    ->where('pac.Id', '=', $id)
                                    ->where('pac.EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {   //checkeo que el ingreso encontrado, posea prácticas asociadas
            if ($data[0]['IngresoPracticaId'] === NULL) 
            {   //ingreso sin prácticas -> no puede ingresar resultados
                $response["error"] = TRUE;
                $response["data"] = "El ingreso del paciente no posee prácticas asociadas.";
                echoResponse2(200, $response, 'Get Pacientes-Resultados Id. Error: el ingreso no posee prácticas asociadas.');
                $app->stop();
            }
            else
            {   //ingreso con prácticas asociadas, devuelve los datos.
                $response["error"] = FALSE;
                $response["data"] = $data;            
                echoResponse2(200, $response, 'Get Pacientes-Resultados Id. Correcto');
            }            
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han encontrado datos";
            echoResponse2(200, $response, 'Get Pacientes-Resultados Id. Error: no se encontraron datos');
        }
    }); 

    /** 
    * Obtiene los datos de un paciente no borrado segun un id ingresado
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del paciente encontrado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('p.Id', 'p.ApellidoNombre', 'p.FechaNacimiento', 'p.Sexo', 'p.Origen', 'p.Cuenta', 'p.Direccion', 'p.NumDocumento', 'p.Telefono', 'p.Celular', 'p.Lugar', 'p.Mail', 'p.MatriculaMedico', 'med.Matricula', 'med.Nombre as NombreMed', 'med.Apellido as ApellidoMed', 'p.Mutual1', 'mut1.Nombre as NombreMutual1', 'mut1.Codigo as CodMutual1', 'p.DebeOrden1', 'p.NumAfiliado1', 'p.TipoAfiliado1', 'mut1.PorcCobertura as PorcCobertura1', 'p.Mutual2', 'mut2.Nombre as NombreMutual2', 'mut2.Codigo as CodMutual2', 'p.DebeOrden2', 'p.NumAfiliado2', 'p.TipoAfiliado2', 'mut2.PorcCobertura as PorcCobertura2', 'p.Factor', 'p.ActoProf', 'p.CreadoEn', 'ing.Cama'))
                                    ->from('Pacientes p')
                                    ->join('Mutuales mut1', 'p.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'p.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'p.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->join('Ingresos ing', 'p.Id', '=', 'ing.PacienteId', 'LEFT')                                    
                                    ->where('p.Id', '=', $id)
                                    ->where('p.EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;            
            echoResponse2(200, $response, 'Get Pacientes Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se han encontrado datos para un paciente en particular";
            echoResponse2(200, $response, 'Get Pacientes Id. Error: no se encontraron datos');
        }
    });      
});

$app->group('/ingresos', function() use($app){

    /**
    * Obtiene los ingresos de los pacientes según un paginado ingresado.
    *
    * @param $Offset -> int
    *
    * @return Devuelve, en caso de encontrar, error en False y en data los ingresos coincidentes al paginado
    *         solicitado y, si falla, error en True y en data el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();
       
        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        
        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 
                                                   'ing.NumPaciente', 
                                                   'pac.Id as PacienteId', 
                                                   'pac.ApellidoNombre', 
                                                   'pac.FechaNacimiento', 
                                                   'pac.Sexo', 
                                                   'pac.Origen', 
                                                   'pac.Cuenta', 
                                                   'pac.Direccion', 
                                                   'pac.NumDocumento', 
                                                   'pac.Telefono', 
                                                   'pac.Celular', 
                                                   'pac.Lugar', 
                                                   'pac.Mail', 
                                                   'med.Id as MedicoId', 
                                                   'med.Matricula', 
                                                   'med.Apellido as ApellidoMed', 
                                                   'med.Nombre as NombreMed', 
                                                   'mut1.Id as Mutual1Id', 
                                                   'mut1.Codigo as CodMutual1', 
                                                   'mut1.Nombre as NombreMutual1', 
                                                   'mut1.PorcCobertura as PorcCobertura1', 
                                                   'pac.DebeOrden1', 
                                                   'pac.NumAfiliado1', 
                                                   'pac.TipoAfiliado1', 
                                                   'mut2.Id as Mutual2Id', 
                                                   'mut2.Codigo as CodMutual2', 
                                                   'mut2.Nombre as NombreMutual2', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->where('ing.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20)
                                    ->orderby('ing.NumPaciente');
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();        

        $ultimaPag = GetIngresosTotal();       

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Pacientes Paginado. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Pacientes Paginado. Error: no se encontraron datos');
        }
    });

    /**
    * Obtiene los ingresos de los pacientes según un paginado ingresado, creados entre dos fechas ingresadas.
    *
    * @param $Offset -> int
    *        $Desde -> date
    *        $Hasta -> date
    *
    * @return Devuelve, en caso de encontrar, error en False y en data los ingresos coincidentes al paginado
    *         solicitado y a las fechas ingresadas y, si falla, error en True y en data el mensaje de error.
    */
    $app->post('/porfecha', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset', 'Desde', 'Hasta'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $desde = filter_var($datapost['Desde'], FILTER_SANITIZE_STRING);
        $hasta = filter_var($datapost['Hasta'], FILTER_SANITIZE_STRING);
        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        
        //checkea que la fecha de inicio no sea inválida
        if ($desde === '' || $desde == NULL || $desde === undefined) 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se indicó una fecha de inicio";
            echoResponse2(200, $response, 'Get Ingresos Fecha. Error: no hay fecha de inicio');
            $app->stop();
        }
        else
        {   //si la fecha de inicio es válida completa la fecha para comparar con un tipo datetime
            $desde = $desde.' 00:00:00';
        }

        //checkea que la fecha límite no sea inválida
        if ($hasta === '' || $desde == NULL || $desde === undefined)
        {
            $response["error"] = TRUE;
            $response["data"] = "No se indicó una fecha límite";
            echoResponse2(200, $response, 'Get Ingresos Fecha. Error: no hay fecha límite');
            $app->stop();
        }
        else
        {   //si la fecha límite es válida completa la fecha para comparar con un tipo datetime
            $hasta = $hasta.' 23:59:59';
        }  
        
        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 'ing.NumPaciente', 'pac.Id as PacienteId', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail', 'med.Id as MedicoId', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed', 'mut1.Id as Mutual1Id', 'mut1.Codigo as CodMutual1', 'mut1.Nombre as NombreMutual1', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as CodMutual2', 'mut2.Nombre as NombreMutual2', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->where('ing.EstaBorrado', '=', (int) 0)
                                    ->where('ing.CreadoFecha', '>=', $desde)
                                    ->where('ing.CreadoFecha', '<=', $hasta)
                                    ->limit(20, ($offset - 1) * 20)
                                    ->orderby('ing.NumPaciente');
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();        

        $ultimaPag = GetIngresosTotal();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Pacientes Fecha. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Pacientes Fecha. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los ingresos existentes que coincidan en algún punto con el ApellidoNombre de paciente ingresado
    *
    * @param $ApellidoNombre -> string
    *
    * @return Retorna, en caso de éxito, error en False y en data los ingresos encontrados, y error en True si no encuentra datos.
    */
    $app->post('/pornombre', 'Autenticar', function() use($app){
        verifyRequiredParams(array('ApellidoNombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $apellidonombre = filter_var(substr($datapost['ApellidoNombre'], 0, 50), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 
                                                   'ing.NumPaciente', 
                                                   'ing.PacienteId', 
                                                   'ing.Cama', 
                                                   'ing.SinCargo', 
                                                   'ing.RealizaDescuentos', 
                                                   'ing.ReajustaImporte', 
                                                   'ing.AbonoSena', 
                                                   'ing.Comentarios',
                                                   'pac.ApellidoNombre', 
                                                   'pac.FechaNacimiento', 
                                                   'pac.Sexo', 
                                                   'pac.Origen', 
                                                   'pac.Cuenta', 
                                                   'pac.Direccion', 
                                                   'pac.NumDocumento', 
                                                   'pac.Telefono', 
                                                   'pac.Celular', 
                                                   'pac.Lugar', 
                                                   'pac.Mail', 
                                                   'pac.MatriculaMedico as MedicoId', 
                                                   'med.Apellido as ApellidoMed', 
                                                   'med.Nombre as NombreMed', 
                                                   'med.Matricula', 
                                                   'mut1.Id as Mutual1Id', 
                                                   'mut1.Codigo as Mutual1Cod', 
                                                   'mut1.Nombre as Mutual1Nombre', 
                                                   'mut1.PorcCobertura as PorcCobertura1', 
                                                   'pac.DebeOrden1', 
                                                   'pac.NumAfiliado1', 
                                                   'pac.TipoAfiliado1', 
                                                   'mut2.Id as Mutual2Id', 
                                                   'mut2.Codigo as Mutual2Cod', 
                                                   'mut2.Nombre as Mutual2Nombre', 
                                                   'mut2.PorcCobertura as PorcCobertura2', 
                                                   'pac.DebeOrden2', 
                                                   'pac.NumAfiliado2', 
                                                   'pac.TipoAfiliado2', 
                                                   'pac.Factor', 
                                                   'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->whereLike('pac.ApellidoNombre', '%'.$apellidonombre.'%')
                                    ->where('ing.EstaBorrado', '=', (int) 0);                                   

        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 
                                                       'ingp.IngresoId as IngresoId', 
                                                       'ingp.NomencladorId', 
                                                       'pr.Id as PracticaId', 
                                                       'pr.Codigo as PracticaCodigo', 
                                                       'pr.Nombre as PracticaNombre', 
                                                       'pr.EsNomencladorTrabajo'))
                                        ->from('IngresosPracticas ingp')
                                        ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                        ->where('ingp.IngresoId', '=', $ingresos[$i]['IngresoId'])
                                        ->where('ingp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();

            $ingresosP = $stmt->fetchAll();

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;
            $response["cantidad"] = count($ingresos);
            echoResponse2(200, $response, 'Get Ingresos Por ApellidoNombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Por ApellidoNombre. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los ingresos existentes que coincidan en algún punto con el número de paciente ingresado
    *
    * @param $NumPaciente -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los ingresos encontrados, y error en True
    *         y en data el mensaje de error si no encuentra datos.
    */
    $app->post('/pornumpaciente', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumPaciente'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $numpaciente = filter_var(substr($datapost['NumPaciente'], 0, 8), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 'ing.NumPaciente', 'ing.PacienteId', 'ing.Cama', 'ing.SinCargo', 'ing.RealizaDescuentos', 'ing.ReajustaImporte', 'ing.AbonoSena', 'ing.Comentarios', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail', 'pac.MatriculaMedico as MedicoId', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed', 'med.Matricula', 'mut1.Id as Mutual1Id', 'mut1.Codigo as Mutual1Cod', 'mut1.Nombre as Mutual1Nombre', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as Mutual2Cod', 'mut2.Nombre as Mutual2Nombre', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->whereLike('ing.NumPaciente', '%'.$numpaciente.'%')
                                    ->where('ing.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 'ingp.IngresoId as IngresoId', 'ingp.NomencladorId', 'pr.Id as PracticaId', 'pr.Codigo as PracticaCodigo', 'pr.Nombre as PracticaNombre', 'pr.EsNomencladorTrabajo'))
                                        ->from('IngresosPracticas ingp')
                                        ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                        ->where('ingp.IngresoId', '=', $ingresos[$i]['IngresoId'])
                                        ->where('ingp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $ingresosP = $stmt->fetchAll();

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;
            $response["cantidad"] = count($ingresos);
            echoResponse2(200, $response, 'Get Ingresos Por Número. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Por Número. Error: no se encontraron datos');
        }
    });

    $app->get('/', 'Autenticar', function() use($app){
        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 'ing.NumPaciente', 'ing.PacienteId', 'ing.Cama', 'ing.SinCargo', 'ing.RealizaDescuentos', 'ing.ReajustaImporte', 'ing.AbonoSena', 'ing.Comentarios', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail', 'pac.MatriculaMedico as MedicoId', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed', 'med.Matricula', 'mut1.Id as Mutual1Id', 'mut1.Codigo as Mutual1Cod', 'mut1.Nombre as Mutual1Nombre', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as Mutual2Cod', 'mut2.Nombre as Mutual2Nombre', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')                                    
                                    ->where('ing.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 'ingp.IngresoId as IngresoId', 'ingp.NomencladorId', 'pr.Id as PracticaId', 'pr.Codigo as PracticaCodigo', 'pr.Nombre as PracticaNombre', 'pr.EsNomencladorTrabajo'))
                                        ->from('IngresosPracticas ingp')
                                        ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                        ->where('ingp.IngresoId', '=', $ingresos[$i]['IngresoId'])
                                        ->where('ingp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $ingresosP = $stmt->fetchAll();

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;            
            echoResponse2(200, $response, 'Get General Ingresos. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get General Ingresos. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de un ingreso existente que coincida con un Id ingresado
    *
    * @param $Id -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del ingreso encontrado, y error en True
    *         si no encuentra datos y en data el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){       
        //obtengo el ingreso en concreto que busco según su Id
        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 'ing.NumPaciente', 'ing.PacienteId', 'ing.Cama', 'ing.SinCargo', 'ing.RealizaDescuentos', 'ing.ReajustaImporte', 'ing.AbonoSena', 'ing.Comentarios', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail', 'pac.MatriculaMedico as MedicoId', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed', 'med.Matricula', 'mut1.Id as Mutual1Id', 'mut1.Codigo as Mutual1Cod', 'mut1.Nombre as Mutual1Nombre', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as Mutual2Cod', 'mut2.Nombre as Mutual2Nombre', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->where('ing.Id', '=', $id)
                                    ->where('ing.EstaBorrado', '=', (int) 0);                                   
        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        //obtengo los ingresos práctica que tenga asociados el ingreso que deseo obtener, tambien con el Id del ingreso
        $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 'ingp.IngresoId as IngresoId', 'ingp.NomencladorId', 'pr.Id as PracticaId', 'pr.Codigo as PracticaCodigo', 'pr.Nombre as PracticaNombre', 'pr.EsNomencladorTrabajo'))
                                    ->from('IngresosPracticas ingp')
                                    ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                    ->where('ingp.IngresoId', '=', $id)
                                    ->where('ingp.EstaBorrado', '=', (int) 0);
        $stmt = $selectStatement->execute();
        $ingresosP = $stmt->fetchAll();

        if ($ingresosP) 
        {
            $ingresos[0]['IngresosPractica'] = $ingresosP;
        }
        else
        {
            $ingresos[0]['IngresosPractica'] = NULL;
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;            
            echoResponse2(200, $response, 'Get Ingresos Por Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Por Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/nomencladores', function() use ($app){

    /** 
    * Crea un nuevo nomenclador
    *
    * @param $Codigo -> string
    *        $Nombre -> string
    *        $INOS -> int
    *        $677 -> int
    *        $UGastos -> decimal
    *        $UHonorarios -> decimal
    *        $Area -> string
    *        $Complejidad -> int
    *        $INOSReducido -> int
    *        $NoNomenclada -> int
    *        $TiempoRealizacion -> string
    *        $IdMuestra -> int
    *        $Proceso -> string
    *        $Lista -> string
    *        $CodigoFABA -> int
    *        $Nivel -> decimal
    *        $RIA -> int 
    *        $NBUFrecuencia -> int
    *        $NBUCodigo -> int
    *        $Cantidad -> decimal
    *        $Determinaciones -> array(Nombre, Seccion, Orden)
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y el Id del nomenclador creado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Codigo', 'Nombre', 'INOS', '_677', 'UGastos', 'UHonorarios', 'Area', 'Complejidad', 'INOSReducido', 'NoNomenclada', 'TiempoRealizacion', 'IdMuestra', 'Proceso', 'Lista', 'CodigoFABA', 'Nivel', 'RIA', 'NBUFrecuencia', 'NBUCodigo', 'Cantidad', 'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);        

        $codigo = filter_var(strtoupper(substr($datapost['Codigo'], 0, 3)), FILTER_SANITIZE_STRING);
        $nombre = filter_var(substr($datapost['Nombre'], 0, 50), FILTER_SANITIZE_STRING);
        $inos = filter_var(substr($datapost['INOS'], 0, 4), FILTER_SANITIZE_NUMBER_INT);
        $_677 = filter_var($datapost['_677'], FILTER_SANITIZE_STRING);
        $uGastos = filter_var($datapost['UGastos'], FILTER_SANITIZE_STRING);
        $uHonorarios = filter_var($datapost['UHonorarios'], FILTER_SANITIZE_STRING);
        $area = filter_var(substr($datapost['Area'], 0, 50), FILTER_SANITIZE_STRING);
        $complejidad = filter_var($datapost['Complejidad'], FILTER_SANITIZE_STRING);
        $inosReducido = filter_var($datapost['INOSReducido'], FILTER_SANITIZE_STRING);
        $noNomenclada = filter_var($datapost['NoNomenclada'], FILTER_SANITIZE_STRING);
        $tiempoRealizacion = filter_var(substr($datapost['TiempoRealizacion'], 0, 50), FILTER_SANITIZE_STRING);
        $idMuestra = filter_var($datapost['IdMuestra'], FILTER_SANITIZE_NUMBER_INT);
        $proceso = filter_var(substr($datapost['Proceso'], 0, 50), FILTER_SANITIZE_STRING);
        $lista = filter_var(substr($datapost['Lista'], 0, 50), FILTER_SANITIZE_STRING);
        $codigoFaba = filter_var(substr($datapost['CodigoFABA'], 0, 4), FILTER_SANITIZE_NUMBER_INT);
        $nivel = filter_var($datapost['Nivel'], FILTER_SANITIZE_STRING);
        $ria = filter_var($datapost['RIA'], FILTER_SANITIZE_STRING);
        $nbuFrecuencia = filter_var($datapost['NBUFrecuencia'], FILTER_SANITIZE_STRING);
        $nbuCodigo = filter_var(substr($datapost['NBUCodigo'], 0, 6), FILTER_SANITIZE_NUMBER_INT);
        $cantidad = filter_var($datapost['Cantidad'], FILTER_SANITIZE_STRING);        
        $determinaciones = $datapost['Determinaciones'];
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //checkea que el código de nomenclador no esté repetido
        if ($app->pdo->CheckearCodigoNomenclador($codigo)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Código de nomenclador repetido.";
            echoResponse2(200, $response, 'Crear Nomenclador. Error: código de nomenclador repetido');
            $app->stop();
        }
        
        if ($determinaciones[0] == NULL || $determinaciones[0] == '') 
        {
            $response["error"] = TRUE;
            $response["data"] = "No existen determinaciones.";
            echoResponse2(200, $response, 'Crear Nomenclador. Error: no existen determinaciones');
            $app->stop();
        }

        //crea el nomenclador
        $result = $app->pdo->CrearNomenclador(array($codigo, $nombre, $inos, $_677, $uGastos, $uHonorarios, $area, $complejidad, $inosReducido, $noNomenclada, $tiempoRealizacion, $idMuestra, $proceso, $lista, $codigoFaba, $nivel, $ria, $nbuFrecuencia, $nbuCodigo, $cantidad, $creadoPor));

        if ($result) 
        {            
            $resultPractica = $app->pdo->CrearPractica(array($result, $codigo, $nombre, 1, $creadoPor), $determinaciones);
        }

        if ($result && $resultPractica) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Nomenclador. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se pudo crear el nomenclador.";
            echoResponse2(400, $response, 'Crear Nomenclador. Error: el nomenclador no se creó');
        }
    });

    /** 
    * Modifica un nomenclador
    *
    * @param $Id -> int 
    *        $Nombre -> string
    *        $INOS -> int
    *        $677 -> int
    *        $UGastos -> decimal
    *        $UHonorarios -> decimal
    *        $Area -> string
    *        $Complejidad -> int
    *        $INOSReducido -> int
    *        $NoNomenclada -> int
    *        $TiempoRealizacion -> string
    *        $IdMuestra -> int
    *        $Proceso -> string
    *        $Lista -> string
    *        $CodigoFABA -> int
    *        $Nivel -> decimal
    *        $RIA -> int 
    *        $NBUFrecuencia -> int
    *        $NBUCodigo -> int
    *        $Cantidad -> decimal
    *        $Determinaciones -> array(IdDeterminacion, Determinacion, Seccion, Orden)
    *        $ModificadoPor string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si se modifica y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'Codigo', 'Nombre', 'INOS', '_677', 'UGastos', 'UHonorarios', 'Area', 'Complejidad', 'INOSReducido', 'NoNomenclada', 'TiempoRealizacion', 'IdMuestra', 'Proceso', 'Lista', 'CodigoFABA', 'Nivel', 'RIA', 'NBUFrecuencia', 'NBUCodigo', 'Cantidad', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $codigo = filter_var(strtoupper(substr($datapost['Codigo'], 0, 3)), FILTER_SANITIZE_STRING);
        $nombre = filter_var(substr($datapost['Nombre'], 0, 50), FILTER_SANITIZE_STRING);
        $inos = filter_var(substr($datapost['INOS'], 0, 4), FILTER_SANITIZE_NUMBER_INT);
        $_677 = filter_var($datapost['_677'], FILTER_SANITIZE_STRING);
        $uGastos = filter_var($datapost['UGastos'], FILTER_SANITIZE_STRING);
        $uHonorarios = filter_var($datapost['UHonorarios'], FILTER_SANITIZE_STRING);
        $area = filter_var(substr($datapost['Area'], 0, 50), FILTER_SANITIZE_STRING);
        $complejidad = filter_var($datapost['Complejidad'], FILTER_SANITIZE_STRING);
        $inosReducido = filter_var($datapost['INOSReducido'], FILTER_SANITIZE_STRING);
        $noNomenclada = filter_var($datapost['NoNomenclada'], FILTER_SANITIZE_STRING);
        $tiempoRealizacion = filter_var(substr($datapost['TiempoRealizacion'], 0, 50), FILTER_SANITIZE_STRING);
        $idMuestra = filter_var(substr($datapost['IdMuestra'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        $proceso = filter_var(substr($datapost['Proceso'], 0, 50), FILTER_SANITIZE_STRING);
        $lista = filter_var(substr($datapost['Lista'], 0, 50), FILTER_SANITIZE_STRING);
        $codigoFaba = filter_var(substr($datapost['CodigoFABA'], 0, 4), FILTER_SANITIZE_NUMBER_INT);
        $nivel = filter_var($datapost['Nivel'], FILTER_SANITIZE_STRING);
        $ria = filter_var($datapost['RIA'], FILTER_SANITIZE_STRING);
        $nbuFrecuencia = filter_var($datapost['NBUFrecuencia'], FILTER_SANITIZE_STRING);
        $nbuCodigo = filter_var(substr($datapost['NBUCodigo'], 0, 6), FILTER_SANITIZE_NUMBER_INT);
        $cantidad = filter_var($datapost['Cantidad'], FILTER_SANITIZE_STRING);
        $determinaciones = $datapost['Determinaciones'];
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //busca el nomenclador por su Id
        $nomenclador = $app->pdo->ExisteNomenclador($id);

        //checkea que el nomenclador todavía exista
        if (!$nomenclador) 
        {
            $response["error"] = TRUE;
            $response["data"] = "No existe el nomenclador.";
            echoResponse2(200, $response, 'Modificar Nomenclador. Error: el nomenclador no existe');
            $app->stop();
        }  

        if ($nomenclador[0]['Codigo'] !== $codigo)
        {
            if ($app->pdo->CheckearCodigoNomenclador($codigo)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Código de nomenclador repetido";
                echoResponse2(200, $response, 'Modificar Nomenclador. Error: código de nomenclador repetido');
                $app->stop();
            }    
        }   

        for ($i = 0; $i < count($determinaciones); $i++) 
        { 
            if ($determinaciones[$i][0] == '' || $determinaciones[$i][1] == '' || $determinaciones[$i][2] == '' || $determinaciones[$i][3] == '') 
            {
                $response["error"] = TRUE;
                $response["data"] = "Determinaciones con error";
                echoResponse2(200, $response, 'Modificar Nomenclador. Error: determinaciones con error');
                $app->stop();
            }
        }
        
        //modifica el nomenclador
        $result = $app->pdo->ModificarNomenclador(array($id, $codigo, $nombre, $inos, $_677, $uGastos, $uHonorarios, $area, $complejidad, $inosReducido, $noNomenclada, $tiempoRealizacion, $idMuestra, $proceso, $lista, $codigoFaba, $nivel, $ria, $nbuFrecuencia, $nbuCodigo, $cantidad, $modificadoPor));
        if ($result) 
        {           
            //$resultDet = $app->pdo->ModificarDeterminaciones($id, $determinaciones, $modificadoPor);
        }

        if($result/* && $resultDet*/)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Nomenclador. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se modificó el nomenclador.";
            echoResponse2(400, $response, 'Modificar Nomenclador. Error: el nomenclador no se modificó');
        }
    });

    /** 
    * Elimina un nomenclador
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si se elimina y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //checkea que el nomenclador todavía exista
        if (!$app->pdo->ExisteNomenclador($id)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "No existe el nomenclador.";
            echoResponse2(200, $response, 'Eliminar Nomenclador. Error: el nomenclador no existe');
            $app->stop();
        }
        
        //elimina el nomenclador
        $result = $app->pdo->EliminarNomenclador(array($id, $modificadoPor));
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Nomenclador. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se eliminó el nomenclador.";
            echoResponse2(400, $response, 'Eliminar Nomenclador. Error: el nomenclador no se eliminó');
        }
    });

    /** 
    * Obtiene todos los nomencladores no borrados segun un paginado solicitado
    *
    * @return Retorna, en caso de éxito, error en False y los datos de todos los nomencladores encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Offset'));

        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);
        $offset = $datapost['Offset'];

        $selectStatement = $app->pdo->select(array('n.Id', 
                                                   'n.Codigo', 
                                                   'n.Nombre', 
                                                   'n.INOS', 
                                                   'n._677', 
                                                   'n.UGastos', 
                                                   'n.UHonorarios', 
                                                   'n.Area', 
                                                   'n.Complejidad', 
                                                   'n.INOSReducido', 
                                                   'n.NoNomenclada', 
                                                   'n.TiempoRealizacion', 
                                                   'n.IdMuestra', 
                                                   'n.Proceso', 
                                                   'n.Lista', 
                                                   'n.CodigoFABA', 
                                                   'n.Nivel', 
                                                   'n.RIA', 
                                                   'n.NBUFrecuencia', 
                                                   'n.NBUCodigo', 
                                                   'n.Cantidad'))
                                    ->from('Nomencladores n')
                                    ->where('n.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $countStatement = $app->pdo->select(array('n.Id'))
                        ->from('Nomencladores n')
                        ->where('n.EstaBorrado', '=', 0);
        $result = $countStatement->execute();
        $count = $result->fetchAll();        
        
        $ultimaPag = ($offset * 20) > count($count);
        
        if ($data) 
        {
            $response["algo"] = count($count);
            $response["ultimaPag"] = $ultimaPag;
            $response["error"] = FALSE;
            $response["data"] = $data;            
            echoResponse2(200, $response, 'Get General Nomencladores. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get General Nomencladores. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los nomencladores no borrados
    *
    * @return Retorna, en caso de éxito, error en False y los datos de todos los nomencladores encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use ($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('n.Id', 'n.Codigo', 'n.Nombre', 'n.INOS', 'n._677', 'n.UGastos', 'n.UHonorarios', 'n.Area', 'n.Complejidad', 'n.INOSReducido', 'n.NoNomenclada', 'n.TiempoRealizacion', 'n.IdMuestra', 'n.Proceso', 'n.Lista', 'n.CodigoFABA', 'n.Nivel', 'n.RIA', 'n.NBUFrecuencia', 'n.NBUCodigo', 'n.Cantidad'))
                                    ->from('Nomencladores n')
                                    ->where('n.EstaBorrado', '=', (int) 0);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement = $app->pdo->select(array('valU.ValorFABAA', 'valU.ValorFABAB', 'valU.ValorFABAC', 'valU.ValorNBUAltaFrec', 'valU.ValorNBUBajaFrec', 'valU.UGastos', 'valU.UHonorarios', 'valU.ValorPracticaMinima', 'valU.ActoProfesionalBioquimico', 'valU.ValorMontoMaximo'))
                                    ->from('ValoresUnidades valU')
                                    ->where('valU.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $valores = $stmt->fetchAll();
        
        if ($data && $valores) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["valores"] = $valores;
            echoResponse2(200, $response, 'Get General Nomencladores. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get General Nomencladores. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los nomencladores no borrados, ordenados alfabeticamente según su nombre
    *
    * @return Retorna, en caso de éxito, error en False y los datos de todos los nomencladores encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/alfabetico', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('n.Id', 'n.Codigo', 'n.Nombre', 'n.INOS', 'n._677', 'n.UGastos', 'n.UHonorarios', 'n.Area', 'n.Complejidad', 'n.INOSReducido', 'n.NoNomenclada', 'n.TiempoRealizacion', 'n.IdMuestra', 'n.Proceso', 'n.Lista', 'n.CodigoFABA', 'n.Nivel', 'n.RIA', 'n.NBUFrecuencia', 'n.NBUCodigo', 'n.Cantidad'))
                                    ->from('Nomencladores n')
                                    ->where('n.EstaBorrado', '=', (int) 0)
                                    ->orderby('Nombre')
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('n.Id', $as = 'Total') //ToDo pasar a un stored procedure
                        ->from('Nomencladores n')
                        ->where('n.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Nomencladores Alfabético. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get Nomencladores Alfabético. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los nomencladores no borrados, que coincidan en código o nombre, en algún punto, con 
    * el criterio ingresado.
    *
    * @param $Nombre -> string
    *
    * @return Retorna, en caso de éxito, error en False y los datos de todos los nomencladores encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/pornombre', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Nombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $nombre = filter_var(substr($datapost['Nombre'], 0, 50), FILTER_SANITIZE_STRING);
        $codigo = filter_var(substr($datapost['Nombre'], 0, 3), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('n.Id', 'n.Codigo', 'n.Nombre', 'n.INOS', 'n._677', 'n.UGastos', 'n.UHonorarios', 'n.Area', 'n.Complejidad', 'n.INOSReducido', 'n.NoNomenclada', 'n.TiempoRealizacion', 'n.IdMuestra', 'n.Proceso', 'n.Lista', 'n.CodigoFABA', 'n.Nivel', 'n.RIA', 'n.NBUFrecuencia', 'n.NBUCodigo', 'n.Cantidad'))
                                    ->from('Nomencladores n')                                    
                                    ->where('n.EstaBorrado', '=', (int) 0)
                                    ->whereLike('n.Codigo', '%'.$codigo.'%')
                                    ->orWhereLike('n.Nombre', '%'.$nombre.'%');
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();     

        if (count($data) == 1) 
        {
            $selectStatement = $app->pdo->select(array('p.Id', 'p.NomencladorId', 'p.Codigo', 'p.Nombre', 'p.EsNomencladorTrabajo', 'p.NombreDeterminacion', 'p.Seccion', 'p.Orden'))
                                        ->from('Practicas p')
                                        ->where('p.NomencladorId', '=', $data[0]['Id'])
                                        ->where('p.EsNomencladorTrabajo', '=', (int) 1)
                                        ->where('p.EstaBorrado', '=', (int) 0)
                                        ->orderby('p.Id');

            $stmt = $selectStatement->execute();
            $determinaciones = $stmt->fetchAll();
        }   
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["determinaciones"] = $determinaciones;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Nomencladores Alfabético. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get Nomencladores Alfabético. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene todos los datos de un nomenclador según un Id ingresado
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de éxito, error en False y los datos del nomenclador encontrado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use ($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('n.Id', 'n.Codigo', 'n.Nombre', 'n.INOS', 'n._677', 'n.UGastos', 'n.UHonorarios', 'n.Area', 'n.Complejidad', 'n.INOSReducido', 'n.NoNomenclada', 'n.TiempoRealizacion', 'n.IdMuestra', 'n.Proceso', 'n.Lista', 'n.CodigoFABA', 'n.Nivel', 'n.RIA', 'n.NBUFrecuencia', 'n.NBUCodigo', 'n.Cantidad'))
                                    ->from('Nomencladores n')
                                    ->where('n.Id', '=', $id)
                                    ->where('n.EstaBorrado', '=', (int) 0);        
        
        $stmt = $selectStatement->execute();
        $nomencladores = $stmt->fetchAll();

        $selectStatement = $app->pdo->select(array('p.Id', 'p.NomencladorId', 'p.Codigo', 'p.Nombre', 'p.EsNomencladorTrabajo', 'p.NombreDeterminacion', 'p.Seccion', 'p.Orden'))
                                    ->from('Practicas p')
                                    ->where('p.NomencladorId', '=', $nomencladores[0]['Id'])
                                    ->where('p.EsNomencladorTrabajo', '=', (int) 1)
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->orderby('p.Id');

        $stmt = $selectStatement->execute();
        $determinaciones = $stmt->fetchAll();
        
        if ($nomencladores) 
        {
            $response["error"] = FALSE;
            $response["data"] = $nomencladores;
            $response["determinaciones"] = $determinaciones;
            echoResponse2(200, $response, 'Get Nomencladores Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get Nomencladores Id. Error: no se encontraron datos');
        }
    });

    $app->post('/buscarpornombre', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Nombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();
        
        $codigo = filter_var(substr($datapost['Nombre'], 0, 3), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('p.Id', 'p.NomencladorId', 'p.Codigo', 'p.Nombre', 'p.EsNomencladorTrabajo', 'p.NombreDeterminacion', 'p.Seccion', 'p.Orden'))
                                    ->from('Practicas p')                                    
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->whereLike('p.Codigo', '%'.$codigo.'%')
                                    ->where('p.EsNomencladorTrabajo', '=', (int) 1)
                                    ->groupby('p.Codigo');
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Nomencladores Alfabético. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get Nomencladores Alfabético. Error: no se encontraron datos');
        }
    });
});

$app->group('/practicas', function() use($app){
    
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('p.Id', 'p.NomencladorId', 'p.Codigo', 'p.Nombre', 'p.EsNomencladorTrabajo'))
                                    ->from('Practicas p')
                                    ->where('p.Id', '=', $id)
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->where('p.EsNomencladorTrabajo', '=', (int) 1)
                                    ->groupby('p.Codigo');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Practicas Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos.";
            echoResponse2(200, $response, 'Get Practicas Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/secciones', function() use ($app){

    /** 
    * Crea una sección nueva
    *
    * @param $Codigo -> string
    *        $Nombre -> string
    *        $Determinaciones -> array()
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y el Id de la sección recientemente creada y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Codigo', 'Nombre', 'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);        

        $codigo = filter_var(strtoupper(substr($datapost['Codigo'], 0, 2)), FILTER_SANITIZE_STRING);
        $nombre = filter_var(strtoupper(substr($datapost['Nombre'], 0, 50)), FILTER_SANITIZE_STRING);
        $determinaciones = $datapost['Determinaciones'];
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        $response["data"] = $codigo;
        $response["data2"] = $nombre;
        $response["data3"] = $determinaciones;
        $response["data4"] = $creadoPor;
        echoResponse2(200, $response, 'prueba');
        $app->stop();

        //checkea que el código de sección no esté repetido
        if ($app->pdo->CheckearCodigoSeccion($codigo)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "Código de sección repetido";
            echoResponse2(200, $response, 'Crear Sección. Error: código de sección repetido');
            $app->stop();
        }

        //crea la sección
        $result = $app->pdo->CrearSeccion(array($codigo, $nombre, $creadoPor));

        if ($result) 
        {
            $resultSec = $app->pdo->CrearSeccionesPracticas(array($result, $creadoPor), $determinaciones);
        }
        
        if ($result && $resultSec) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Sección. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se creó la sección";
            echoResponse2(400, $response, 'Crear Sección. Error: la sección no se creó');
        }
    });

    /** 
    * Modifica una sección
    *
    * @param $Id -> int
    *        $Nombre -> string
    *        $Determinacion1 -> string
    *        $Determinacion2 -> string
    *        $Determinacion3 -> string
    *        $Determinacion4 -> string
    *        $Determinacion5 -> string
    *        $Determinacion6 -> string
    *        $Determinacion7 -> string
    *        $Determinacion8 -> string
    *        $Determinacion9 -> string
    *        $Determinacion10 -> string
    *        $Determinacion11 -> string
    *        $Determinacion12 -> string
    *        $Determinacion13 -> string
    *        $Determinacion14 -> string
    *        $Determinacion15 -> string
    *        $Determinacion16 -> string
    *        $Determinacion17 -> string
    *        $Determinacion18 -> string
    *        $Determinacion19 -> string
    *        $Determinacion20 -> string
    *        $Determinacion21 -> string
    *        $Determinacion22 -> string
    *        $Determinacion23 -> string
    *        $Determinacion24 -> string
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si se modifica correctamente y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'Codigo', 'Nombre', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);    
        $codigo = filter_var(strtoupper(substr($datapost['Codigo'], 0, 2)), FILTER_SANITIZE_STRING);
        $nombre = filter_var(strtoupper(substr($datapost['Nombre'], 0, 50)), FILTER_SANITIZE_STRING);
        $determinaciones = $datapost['Determinaciones'];
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //busca la sección por su Id
        $seccion = $app->pdo->ExisteSeccion($id);

        //checkea que la sección todavía exista
        if (!$seccion) 
        {   //sección inexistente
            $response["error"] = TRUE;
            $response["data"] = "La sección no existe";
            echoResponse2(200, $response, 'Modificar Sección. Error: la sección no existe');
            $app->stop();
        }

        //checkea si el código se va a modificar
        if ($seccion[0]['Codigo'] !== $codigo)
        {   //se modifica el código, checkea que no exista el nuevo código
            if ($app->pdo->CheckearCodigoSeccion($codigo))
            {   //nuevo código repetido
                $response["error"] = TRUE;
                $response["data"] = "Código de sección repetido";
                echoResponse2(200, $response, 'Modificar Sección. Error: código de sección repetido');
                $app->stop();
            }
        }

        //modifica la sección
        $result = $app->pdo->ModificarSeccion(array($id, $codigo, $nombre, $modificadoPor), $determinaciones);
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Sección. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se modificó la sección";
            echoResponse2(400, $response, 'Modificar Sección. Error: la sección no se modificó');
        }
    });

    /** 
    * Elimina una sección
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si se elimina correctamente y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);
        
        //checkea que la sección todavía exista
        if (!$app->pdo->ExisteSeccion($id)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "La sección no existe";
            echoResponse2(200, $response, 'Eliminar Sección. Error: la sección no existe');
            $app->stop();
        }
        
        //elimina la sección
        $result = $app->pdo->EliminarSeccion(array($id, $modificadoPor));
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Sección. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se eliminó la sección";
            echoResponse2(400, $response, 'Eliminar Sección. Error: la sección no se eliminó');
        }
    });

    /** 
    * Obtiene los datos de todas las secciones no borradas que se encuentren.
    *
    * @return Retorna, en caso de éxito, error en False y los datos de las secciones encontradas y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use ($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('sec.Id', 'sec.Codigo', 'sec.Nombre'))
                                    ->from('Secciones sec')
                                    ->where('sec.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('sec.Id', $as = 'Total') //ToDo pasar a un stored procedure
                        ->from('Secciones sec')
                        ->where('sec.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data) 
        {
            for ($i = 0; $i < count($data); $i++) 
            { 
                $selectStatement = $app->pdo->select(array('sp.Id', 'sp.SeccionId', 'sp.PracticaId', 'pr.Codigo'))
                                            ->from('SeccionesPracticas sp')
                                            ->join('Practicas pr', 'sp.PracticaId', '=', 'pr.Id', 'INNER')
                                            ->where('sp.EstaBorrado', '=', (int) 0)
                                            ->where('sp.SeccionId', '=', $data[$i]['Id']);
                $stmt = $selectStatement->execute();
                $determinaciones = $stmt->fetchAll();

                if ($determinaciones) 
                {
                    $data[$i]['determinaciones'] = $determinaciones;
                }
                else
                {
                    $data[$i]['determinaciones'] = null;
                }
            }

            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get General Secciones. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos para secciones en general.";
            echoResponse2(200, $response, 'Get General Secciones. Error: no se encontraron datos');
        }

    });

    /** 
    * Obtiene los datos de todas las secciones no borradas que se encuentren.
    *
    * @return Retorna, en caso de éxito, error en False y los datos de las secciones encontradas y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use ($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('Id', 'Codigo', 'Nombre', 'Determinacion1', 'Determinacion2', 'Determinacion3', 'Determinacion4', 'Determinacion5', 'Determinacion6', 'Determinacion7', 'Determinacion8', 'Determinacion9', 'Determinacion10', 'Determinacion11', 'Determinacion12', 'Determinacion13', 'Determinacion14', 'Determinacion15', 'Determinacion16', 'Determinacion17', 'Determinacion18', 'Determinacion19', 'Determinacion20', 'Determinacion21', 'Determinacion22', 'Determinacion23', 'Determinacion24'))
                                    ->from('Secciones')
                                    ->where('EstaBorrado', '=', (int) 0);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Secciones. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos para secciones en general.";
            echoResponse2(200, $response, 'Get General Secciones. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de una sección en particular, según su Id.
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de éxito, error en False y los datos de la sección encontrada y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use ($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('sec.Id', 'sec.Codigo', 'sec.Nombre'))
                                    ->from('Secciones sec')
                                    ->where('sec.Id', '=', $id)
                                    ->where('sec.EstaBorrado', '=', (int) 0);
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $selectStatement = $app->pdo->select(array('sp.Id', 'sp.SeccionId', 'sp.PracticaId', 'pr.Codigo'))
                                        ->from('SeccionesPracticas sp')
                                        ->join('Practicas pr', 'sp.PracticaId', '=', 'pr.Id', 'INNER')
                                        ->where('sp.EstaBorrado', '=', (int) 0)
                                        ->where('sp.SeccionId', '=', $data[0]['Id']);
            $stmt = $selectStatement->execute();
            $determinaciones = $stmt->fetchAll();

            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["determinaciones"] = $determinaciones;
            echoResponse2(200, $response, 'Get Secciones Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos para secciones Id.";
            echoResponse2(200, $response, 'Get Secciones Id. Error: no se encontraron datos');
        }
    });

    $app->post('/buscarporcodigo', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Codigo'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $codigo = filter_var(substr($datapost['Codigo'], 0, 3), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('sec.Id', 'sec.Codigo', 'sec.Nombre'))
                                    ->from('Secciones sec')
                                    ->whereLike('sec.Codigo', '%'.$codigo.'%')
                                    ->where('sec.EstaBorrado', '=', (int) 0);
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            if (count($data) == 1) 
            {
                $selectStatement = $app->pdo->select(array('sp.Id', 'sp.SeccionId', 'sp.PracticaId', 'pr.Codigo'))
                                            ->from('SeccionesPracticas sp')
                                            ->join('Practicas pr', 'sp.PracticaId', '=', 'pr.Id', 'INNER')
                                            ->where('sp.EstaBorrado', '=', (int) 0)
                                            ->where('sp.SeccionId', '=', $data[0]['Id']);
                $stmt = $selectStatement->execute();
                $determinaciones = $stmt->fetchAll();

                $response["error"] = FALSE;
                $response["data"] = $data;
                $response["determinaciones"] = $determinaciones;
                $response["cantidad"] = count($data);
                echoResponse2(200, $response, 'Get Secciones Por Codigo. Correcto');
            }
            else
            {
                $response["error"] = FALSE;
                $response["data"] = $data;
                $response["cantidad"] = count($data);
                echoResponse2(200, $response, 'Get Secciones Por Codigo. Correcto');
            }
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Secciones Por Codigo. Error: no se econtraron datos');
        }
    });
});

$app->group('/nomencladoresespeciales', function() use($app){

    /**
    * Crea un nomenclador especial nuevo
    *
    * @param $MutualId -> int
    *        $A -> string
    *        $Nombre -> string
    *        $Codigo -> string
    *        $UnidadGasto -> decimal
    *        $UnidadHonorario -> decimal
    *        Nivel -> decimal
    *        $CreadoPor -> string
    *
    * @return Devuelve, en caso de éxito, error en False y en data el Id del nomenclador especial creado y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('MutualId', 'A', 'Nombre', 'Codigo', 'UnidadGasto', 'UnidadHonorario', 'Nivel', 'CreadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $mutualId = filter_var(substr($datapost['MutualId'], 0, 10), FILTER_SANITIZE_STRING);
        $a = filter_var(substr($datapost['A'], 0, 1), FILTER_SANITIZE_STRING);
        $nombre = filter_var(strtoupper(strtolower(substr($datapost['Nombre'], 0, 3))), FILTER_SANITIZE_STRING);
        $codigo = filter_var(strtoupper(strtolower(substr($datapost['Codigo'], 0, 10))), FILTER_SANITIZE_STRING);                    
        $unidadGasto = filter_var(substr($datapost['UnidadGasto'], 0, 13), FILTER_SANITIZE_STRING);
        $unidadHonorario = filter_var(substr($datapost['UnidadHonorario'], 0, 13), FILTER_SANITIZE_STRING);
        $nivel = filter_var(substr($datapost['Nivel'], 0, 13), FILTER_SANITIZE_STRING);
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //checkeo que el nomrbe del nomenclador especial no esté repetido
        if ($app->pdo->CheckearNombreNomencladorEspecial($nombre, $mutualId))
        {   //nombre de nomenclador especial repetido
            $response["error"] = TRUE;
            $response["data"] = "El nombre está repetido";
            echoResponse2(200, $response, 'Crear Práctica. Error: nombre repetido');
            $app->stop();
        }

        //checkeo que la mutual a la que se asocia el nomenclador especial exista
        if (!$app->pdo->ExisteMutual($mutualId)) 
        {   //la mutual no existe
            $response["error"] = TRUE;
            $response["data"] = "La mutual no existe";
            echoResponse2(200, $response, 'Crear Práctica. Error: la mutual no existe');
            $app->stop();
        }

        //crea el nomenclador especial
        $result = $app->pdo->CrearNomencladorEspecial(array($mutualId, $a, $nombre, $codigo, $unidadGasto, $unidadHonorario, $nivel, $creadoPor));

        $array = array();

        if ($result) 
        {
            $resultPractica = $app->pdo->CrearPractica(array($result, $codigo, $nombre, 0, $creadoPor), $array);
        }

        if ($result && $resultPractica) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Práctica. Correcto');            
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "La práctica no se creó";
            $response["data2"] = $result;
            $response["data3"] = $resultPractica;
            echoResponse2(400, $response, 'Crear Práctica. Error: la práctica no se creó');
        }
    });

    /**
    * Modifica un nomenclador especial
    *
    * @param $Id -> int
    *        $MutualId -> int
    *        $A -> string
    *        $Nombre -> string
    *        $Codigo -> string
    *        $UnidadGasto -> decimal
    *        $UnidadHonorario -> decimal
    *        Nivel -> decimal
    *        $ModificadoPor -> string
    *
    * @return Devuelve, en caso de éxito, error en False y en data un 1 y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'MutualId', 'A', 'Nombre', 'Codigo', 'UnidadGasto', 'UnidadHonorario', 'Nivel', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $mutualId = filter_var(substr($datapost['MutualId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $a = filter_var(substr($datapost['A'], 0, 1), FILTER_SANITIZE_STRING);
        $nombre = filter_var(strtoupper(strtolower(substr($datapost['Nombre'], 0, 3))), FILTER_SANITIZE_STRING);
        $codigo = filter_var(strtoupper(strtolower(substr($datapost['Codigo'], 0, 10))), FILTER_SANITIZE_STRING);                    
        $unidadGasto = filter_var(substr($datapost['UnidadGasto'], 0, 13), FILTER_SANITIZE_STRING);
        $unidadHonorario = filter_var(substr($datapost['UnidadHonorario'], 0, 13), FILTER_SANITIZE_STRING);
        $nivel = filter_var(substr($datapost['Nivel'], 0, 13), FILTER_SANITIZE_STRING);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //busco el nomenclador especial a modificar por su Id
        $practica = $app->pdo->ExisteNomencladorEspecial($id);

        //checkeo que el nomenclador especial a modificar todavia exista
        if (!$practica) 
        {   //el nomenclador especial a modificar ya no existe
            $response["error"] = TRUE;
            $response["data"] = "La práctica no existe";
            echoResponse2(200, $response, 'Modificar Práctica. Error: la práctica no existe');
            $app->stop();
        }

        //checkeo si se va a modificar la mutual a la que se asocia el nomenclador especial
        if ($practica[0]['MutualId'] !== $mutualId) 
        {   //como la mutual cambia, checkeo que exista la nueva mutual
            if (!$app->pdo->ExisteMutual($mutualId)) 
            {   //la mutual nueva no existe
                $response["error"] = TRUE;
                $response["data"] = "La mutual no existe";
                echoResponse2(200, $response, 'Modificar Práctica. Error: la mutual no existe');
                $app->stop();
            }
        }

        //checkeo si se va a modificar el nombre del nomenclador especial
        if ($practica[0]['Nombre'] !== $nombre) 
        {   //como el nombre del nomenclador especial cambia, checkeo que no se repita
            if ($app->pdo->CheckearNombreNomencladorEspecial($nombre)) 
            {   //nombre del nomenclador especial repetido
                $response["error"] = TRUE;
                $response["data"] = "El nombre de práctica está repetido";
                echoResponse2(200, $response, 'Modificar Práctica. Error: nombre de práctica repetido');
                $app->stop();
            }
        }

        //modifica el nomenclador especial
        $result = $app->pdo->ModificarNomencladorEspecial(array($id, $mutualId, $a, $nombre, $codigo, $unidadGasto, $unidadHonorario, $nivel, $modificadoPor));

        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Práctica. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "La práctica no se modificó";
            echoResponse2(400, $response, 'Modificar Práctica. Error: la práctica no se modificó');
        }
    });

    /**
    * Elimina un nomenclador especial
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Devuelve, en caso de éxito, error en False y en data un 1 y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //busco el nomenclador especial a modificar por su Id
        $practica = $app->pdo->ExistePractica($id);

        //checkeo que el nomenclador especial a modificar todavia exista
        if (!$practica) 
        {   //el nomenclador especial a modificar ya no existe
            $response["error"] = TRUE;
            $response["data"] = "La práctica no existe";
            echoResponse2(200, $response, 'Eliminar Práctica. Error: la práctica no existe');
            $app->stop();
        }

        //elimino el nomenclador especial
        $result = $app->pdo->EliminarNomencladorEspecial(array($id, $modificadoPor));

        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Práctica. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "La práctica no se eliminó";
            echoResponse2(400, $response, 'Eliminar Práctica. Error: la práctica no se eliminó');
        }
    });

    /**
    * Obtiene los datos de los nomencladores especiales para ser listados según un paginado ingresado
    *
    * @param $Offset -> int
    *
    * @return Devuelve, en caso de éxito, error en False y en data los datos de los nomencladores especiales
    *         para ser paginadas y, si falla, error en True y en data el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('p.Id', 'p.MutualId', 'p.A', 'p.Nombre', 'p.Codigo', 'p.UnidadGasto', 'p.UnidadHonorario', 'p.Nivel', 'mut.Codigo as CodMutual', 'mut.Nombre as NombreMutual'))
                                    ->from('NomencladoresEspeciales p')
                                    ->join('Mutuales mut', 'p.MutualId', '=', 'mut.Id', 'INNER')
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->orderby('p.Nombre')
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('p.Id', $as = 'Total')
                        ->from('NomencladoresEspeciales p')
                        ->where('p.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Paginado Prácticas. Correcto');            
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Paginado Prácticas. Error: no se encontraron datos');
        }
    });

    /**
    * Obtiene los datos de los nomencladores especiales para ser listados según un paginado ingresado
    *
    * @param $Offset -> int
    *
    * @return Devuelve, en caso de éxito, error en False y en data los datos de los nomencladores especiales para
    *         ser paginadas y, si falla, error en True y en data el mensaje de error.
    */
    $app->post('/nomenpormutual', 'Autenticar', function() use($app){
        verifyRequiredParams(array('MutualId', 'Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $mutualId = filter_var(substr($datapost['MutualId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        if (!$app->pdo->ExisteMutual($mutualId)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "La mutual no existe";
            echoResponse2(200, $response, 'Get Paginado Prácticas Por Mutual. Error: la mutual no existe');
            $app->stop();
        }

        $selectStatement = $app->pdo->select(array('p.Id', 'p.MutualId', 'p.A', 'p.Nombre', 'p.Codigo', 'p.UnidadGasto', 'p.UnidadHonorario', 'p.Nivel', 'mut.Codigo as CodMutual', 'mut.Nombre as NombreMutual'))
                                    ->from('NomencladoresEspeciales p')
                                    ->join('Mutuales mut', 'p.MutualId', '=', 'mut.Id', 'INNER')
                                    ->where('p.EstaBorrado', '=', (int) 0)
                                    ->where('p.MutualId', '=', $mutualId)
                                    ->orderby('p.Nombre')
                                    ->limit(20, ($offset - 1) * 20);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('p.Id', $as = 'Total')
                        ->from('NomencladoresEspeciales p')
                        ->where('p.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Paginado Prácticas Por Mutual. Correcto');            
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Paginado Prácticas Por Mutual. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de todao los nomencladores especiales existentes
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de todos los nomencladores especiales 
    *         encontrados y, si falla, error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){
        $selectStatement = $app->pdo->select(array('p.Id', 'p.MutualId', 'p.A', 'p.Nombre', 'p.Codigo', 'p.UnidadGasto', 'p.UnidadHonorario', 'p.Nivel', 'mut.Codigo as CodMutual', 'mut.Nombre as NombreMutual'))
                                    ->from('NomencladoresEspeciales p')
                                    ->join('Mutuales mut', 'p.MutualId', '=', 'mut.Id', 'INNER')
                                    ->where('p.EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Prácticas. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos de prácticas";
            echoResponse2(200, $response, 'Get General Practicas. Error: no se encontraron datos');
        }
    });

    /**
    * Obtiene los datos de todos los nomencladores especiales existentes asociados a una mutual, por el Id de
    * la mutual, siempre y cuando los nomencladores especiales asociados a la mutual se encuentre en Nomencladores
    *
    * @param $Id -> int
    *
    * @return Devuelve, en caso de éxito, error en False y en data los datos de todos los nomencladores especiales 
    *         asociados a la mutual de la cual se ingresó su Id. Y si falla, devuelve error en True y en data
    *         el mensaje de error.
    */
    $app->post('/pormutual', 'Autenticar', function() use($app){
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $nombre = filter_var(substr($datapost['Nombre'], 0, 50), FILTER_SANITIZE_STRING);
        $mutual1 = filter_var(substr($datapost['Mutual1'], 0, 10), FILTER_SANITIZE_NUMBER_INT);

        $data = GetNomencladoresEspeciales($mutual1, $nombre);        
        
        //creo un arreglo solo con los codigos de los nomencladores especiales encontrados
        $codigos = array();        
        for ($i = 0; $i < count($data['NomencladoresEspeciales']); $i++) { 
            array_push($codigos, $data['NomencladoresEspeciales'][$i]['NomEspCodigo']);
        }

        //creo el arreglo final de nomencladores de trabajo $data
        $nomencladores = array();
        for ($j = 0; $j < count($data['Nomencladores']); $j++) { 
            if (!in_array($data['Nomencladores'][$j]['NomencladorCodigo'], $codigos)) 
            {
                array_push($nomencladores, $data['Nomencladores'][$j]);
            }
        }

        if (count($data['NomencladoresEspeciales']) > 0) 
        {
            $tipoNomen = 0;
        }

        if (count($nomencladores) > 0) 
        {
            $tipoNomen = 1;
        }

        if (($data['NomencladoresEspeciales'] || $nomencladores) && $data['Valores']) 
        {
            $response["error"] = FALSE;            
            $response["nomencladoresespeciales"] = $data['NomencladoresEspeciales'];
            $response["nomencladores"] = $nomencladores;                        
            $response["valores"] = $data['Valores'];
            $response["cantidad"] = count($data['NomencladoresEspeciales']) + count($nomencladores);
            $response["tipoNomenc"] = $tipoNomen;
            echoResponse2(200, $response, 'Get Prácticas de Mutual. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Prácticas de Mutual. Error: no se encontraron datos');
        }
    });

    /**
    * Obtiene los datos de un nomenclador especial o de trabajo según un Id y un tipo de nomenclador ingresado.
    *
    * @param $Id -> int
    *
    * @return Devuelve, en caso de éxito, error en False, en data los datos del nomenclador encontrado y en valores,
    *         el registro de valores de unidades. Si falla, devuelve error en True, y en data el mensaje de error.
    */
    $app->post('/porid', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'EsNomencladorTrabajo'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $esdetrabajo = filter_var(substr($datapost['EsNomencladorTrabajo'], 0, 1), FILTER_SANITIZE_NUMBER_INT);

        //checkeo el tipo de nomenclador, para obtener los datos necesarios
        if ($esdetrabajo == 0) 
        {
            //obtengo el nomenclador especial que coincida con el Id ingresado
            $selectStatement = $app->pdo->select(array('p.Id as PracticaId', 'p.NomencladorId', 'p.Codigo NomEspCodigo', 'p.Nombre NomEspNombre', 'p.EsNomencladorTrabajo', 'ne.UnidadGasto', 'ne.UnidadHonorario', 'ne.A as Categoria', 'ne.Nivel', 'mut.Id as MutualId', 'mut.ValorA', 'mut.ValorB', 'mut.ValorC', 'mut.ValorNBU', 'mut.CoeficienteUGastos', 'mut.CoeficienteUHono'))
                                        ->from('NomencladoresEspeciales ne')
                                        ->join('Practicas p', 'ne.Id', '=', 'p.NomencladorId', 'INNER')
                                        ->join('Mutuales mut', 'ne.MutualId', '=', 'mut.Id', 'INNER')                                        
                                        ->where('p.Id', '=', $id)
                                        ->where('ne.EstaBorrado', '=', (int) 0);
            
            $stmt = $selectStatement->execute();
            $nomencladorespecial = $stmt->fetchAll();
        }

        //checkeo el tipo de nomenclador, para obtener los datos necesarios
        if ($esdetrabajo == 1) 
        {
            //obtengo el nomenclador de trabajo que coincida con el Id ingresado
            $selectStatement = $app->pdo->select(array('p.Id as PracticaId', 'p.NomencladorId', 'p.Codigo as NomencladorCodigo', 'p.Nombre as NomencladorNombre', 'p.EsNomencladorTrabajo', 'nom.UGastos', 'nom.UHonorarios'))
                                        ->from('Nomencladores nom')
                                        ->join('Practicas p', 'nom.Id', '=','p.NomencladorId')
                                        ->where('p.Id', '=', $id)
                                        ->where('nom.EstaBorrado', '=', (int) 0)
                                        ->groupby('p.NomencladorId');

            $stmt = $selectStatement->execute();
            $nomenclador = $stmt->fetchAll();
        }                

        //obtengo el registro de valores de unidades
        $selectStatement = $app->pdo->select(array('valU.ValorFABAA', 'valU.ValorFABAB', 'valU.ValorFABAC', 'valU.ValorNBUAltaFrec', 'valU.ValorNBUBajaFrec', 'valU.UGastos', 'valU.UHonorarios', 'valU.ValorPracticaMinima', 'valU.ActoProfesionalBioquimico', 'valU.ValorMontoMaximo'))
                                    ->from('ValoresUnidades valU')
                                    ->where('EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $valoresunidades = $stmt->fetchAll();        

        if (($nomencladorespecial || $nomenclador) && $valoresunidades) 
        {
            $response["error"] = FALSE;     
            $response["tipoNomen"] = $esdetrabajo;
            $response["nomencladoresespeciales"] = $nomencladorespecial;
            $response["nomencladores"] = $nomenclador;
            $response["valores"] = $valoresunidades;            
            echoResponse2(200, $response, 'Get Nomencladores Especiales Por Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Nomenclaores Especiales Por Id. Error: no se encontraron datos');
        }
    });

    /**
    * Obtiene los datos de un nomenclador especial por su Id
    *
    * @param $Id -> int
    *
    * @return Devuelve, en caso de éxito, error en False y en data los datos del nomenclador especial encontrado y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('p.Id', 'p.MutualId', 'p.A', 'p.Nombre', 'p.Codigo', 'p.UnidadGasto', 'p.UnidadHonorario', 'p.Nivel', 'mut.Codigo as CodMutual', 'mut.Nombre as NombreMutual'))
                                    ->from('NomencladoresEspeciales p')
                                    ->join('Mutuales mut', 'p.MutualId', '=', 'mut.Id', 'INNER')
                                    ->where('p.Id', '=', $id)
                                    ->where('p.EstaBorrado', '=', (int) 0);

        $response = array();
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Id Prácticas. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Id Prácticas. Error: no se encontraron datos');
        }
    });
});

$app->group('/titulos', function() use($app){

    /** 
    * Crea un nuevo título
    *
    * @param $Codigo -> string
    *        $Descripcion -> string
    *        $Tipo -> int
    *        $Unidades -> string
    *        $Rango -> string
    *        $LineaTexto1 -> string
    *        $LineaTexto2 -> string
    *        $LineaTexto3 -> string
    *        $LineaTexto4 -> string
    *        $ValoresReferenciaAmpliados -> string
    *        $ValorMinimo -> string
    *        $ValorMaximo -> string
    *        $CreadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y en data el Id del título recientemente creado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Codigo', 'CreadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $codigo = filter_var(strtoupper(substr($datapost['Codigo'], 0, 3)), FILTER_SANITIZE_STRING);
        $descripcion = filter_var(substr($datapost['Descripcion'], 0, 50), FILTER_SANITIZE_STRING);
        $tipo = filter_var(substr($datapost['Tipo'], 0, 50), FILTER_SANITIZE_STRING);
        $unidades = filter_var(substr($datapost['Unidades'], 0, 50), FILTER_SANITIZE_STRING);
        $rango = filter_var(substr($datapost['Rango'], 0, 50), FILTER_SANITIZE_STRING);
        $linea1 = filter_var(substr($datapost['LineaTexto1'], 0, 50), FILTER_SANITIZE_STRING);
        $linea2 = filter_var(substr($datapost['LineaTexto2'], 0, 50), FILTER_SANITIZE_STRING);
        $linea3 = filter_var(substr($datapost['LineaTexto3'], 0, 50), FILTER_SANITIZE_STRING);
        $linea4 = filter_var(substr($datapost['LineaTexto4'], 0, 50), FILTER_SANITIZE_STRING);
        $valoresAmpliados = filter_var(substr($datapost['ValoresReferenciaAmpliados'], 0, 50), FILTER_SANITIZE_STRING);
        $valorMin = filter_var(substr($datapost['ValorMinimo'], 0, 50), FILTER_SANITIZE_STRING);
        $valorMax = filter_var(substr($datapost['ValorMaximo'], 0, 50), FILTER_SANITIZE_STRING);        
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING); 
        
        //hace NULL todos los campos que vengan vacíos
        $descripcion === '' ? $descripcion = NULL : '';
        $tipo === '' ? $tipo = NULL : '';
        $unidades === '' ? $unidades = NULL : '';
        $rango === '' ? $rango = NULL : '';
        $linea1 === '' ? $linea1 = NULL : '';
        $linea2 === '' ? $linea2 = NULL : '';
        $linea3 === '' ? $linea3 = NULL : '';
        $linea4 === '' ? $linea4 = NULL : '';
        $valoresAmpliados === '' ? $valoresAmpliados = NULL : '';
        $valorMin === '' ? $valorMin = NULL : '';
        $valorMax === '' ? $valorMax = NULL : '';

        //crea el título
        $result = $app->pdo->CrearTitulo(array($codigo, $descripcion, $tipo, $unidades, $rango, $linea1, $linea2, $linea3, $linea4, $valoresAmpliados, $valorMin, $valorMax, $creadoPor));

        if ($result)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Título. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El título no se pudo crear";
            echoResponse2(400, $response, 'Crear Título. Error: el título no se creó');
        }
    });

    /** 
    * Modifica un título
    *
    * @param $Id -> int
    *        $Codigo -> string
    *        $Descripcion -> string
    *        $Tipo -> int
    *        $Unidades -> string
    *        $Rango -> string
    *        $LineaTexto1 -> string
    *        $LineaTexto2 -> string
    *        $LineaTexto3 -> string
    *        $LineaTexto4 -> string
    *        $ValoresReferenciaAmpliados -> string
    *        $ValorMinimo -> string
    *        $ValorMaximo -> string
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'Codigo', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        
        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);
        $codigo = filter_var(strtoupper(substr($datapost['Codigo'], 0, 3)), FILTER_SANITIZE_STRING);
        $descripcion = filter_var(substr($datapost['Descripcion'], 0, 50), FILTER_SANITIZE_STRING);
        $tipo = filter_var(substr($datapost['Tipo'], 0, 50), FILTER_SANITIZE_STRING);
        $unidades = filter_var(substr($datapost['Unidades'], 0, 50), FILTER_SANITIZE_STRING);
        $rango = filter_var(substr($datapost['Rango'], 0, 50), FILTER_SANITIZE_STRING);
        $linea1 = filter_var(substr($datapost['LineaTexto1'], 0, 50), FILTER_SANITIZE_STRING);
        $linea2 = filter_var(substr($datapost['LineaTexto2'], 0, 50), FILTER_SANITIZE_STRING);
        $linea3 = filter_var(substr($datapost['LineaTexto3'], 0, 50), FILTER_SANITIZE_STRING);
        $linea4 = filter_var(substr($datapost['LineaTexto4'], 0, 50), FILTER_SANITIZE_STRING);
        $valoresAmpliados = filter_var(substr($datapost['ValoresReferenciaAmpliados'], 0, 50), FILTER_SANITIZE_STRING);
        $valorMin = filter_var(substr($datapost['ValorMinimo'], 0, 50), FILTER_SANITIZE_STRING);
        $valorMax = filter_var(substr($datapost['ValorMaximo'], 0, 50), FILTER_SANITIZE_STRING);        
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING); 
        
        //busco el título por su Id
        $titulo = $app->pdo->ExisteTitulo($id);

        //checkea que el título todavía exista
        if (!$titulo)
        {
            $response["error"] = TRUE;
            $response["data"] = "El título no existe";
            echoResponse2(200, $response, 'Modificar Título. Error: el título no existe');
            $app->stop();
        }

        if ($titulo[0]['Codigo'] !== $codigo) 
        {
            if ($app->pdo->CheckearCodigoTitulo($codigo)) 
            {
                $response["error"] = TRUE;
                $response["data"] = "Código del título repetido";
                echoResponse2(200, $response, 'Modificar Título. Error: código de título repetido');
                $app->stop();
            }
        }

        //hace NULL todos los campos que vengan vacíos
        $descripcion === '' ? $descripcion = NULL : '';
        $tipo === '' ? $tipo = NULL : '';
        $unidades === '' ? $unidades = NULL : '';
        $rango === '' ? $rango = NULL : '';
        $linea1 === '' ? $linea1 = NULL : '';
        $linea2 === '' ? $linea2 = NULL : '';
        $linea3 === '' ? $linea3 = NULL : '';
        $linea4 === '' ? $linea4 = NULL : '';
        $valoresAmpliados === '' ? $valoresAmpliados = NULL : '';
        $valorMin === '' ? $valorMin = NULL : '';
        $valorMax === '' ? $valorMax = NULL : '';        

        //modifica el título
        $result = $app->pdo->ModificarTitulo(array($id, $codigo, $descripcion, $tipo, $unidades, $rango, $linea1, $linea2, $linea3, $linea4, $valoresAmpliados, $valorMin, $valorMax, $modificadoPor));
        
        if ($result)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Título. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El título no se pudo modificar";
            echoResponse2(400, $response, 'Modificar Título. Error: el título no se modificó');
        }
    });

    /** 
    * Elimina un título
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        
        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_STRING);        
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING); 
        
        //checkea que el título todavía exista
        if (!$app->pdo->ExisteTitulo($id))
        {
            $response["error"] = TRUE;
            $response["data"] = "El título no existe";
            echoResponse2(200, $response, 'Eliminar Título. Error: el título no existe');
            $app->stop();
        }
        
        //elimina el título
        $result = $app->pdo->EliminarTitulo(array($id, $modificadoPor));
        
        if ($result)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Título. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El título no se pudo eliminar";
            echoResponse2(400, $response, 'Eliminar Título. Error: el título no se eliminó');
        }
    });

    /** 
    * Obtiene los datos de todos los títulos no borrados que se encuentren
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de todos los títulos encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('tit.Id', 'tit.Codigo', 'tit.Descripcion', 'tit.Tipo', 'tit.Unidades', 'tit.Rango', 'tit.LineaTexto1', 'tit.LineaTexto2', 'tit.LineaTexto3', 'tit.LineaTexto4', 'tit.ValoresReferenciaAmpliados', 'tit.ValorMinimo', 'tit.ValorMaximo'))
                                    ->from('Titulos tit')
                                    ->where('tit.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('tit.Id', $as = 'Total') //ToDo pasar a un stored procedure
                        ->from('Titulos tit')
                        ->where('tit.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }
        
        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;            
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get General Títulos. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";            
            echoResponse2(200, $response, 'Get General Títulos. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de todos los títulos no borrados que se encuentren
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de todos los títulos encontrados y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('tit.Id', 'tit.Codigo', 'tit.Descripcion', 'tit.Tipo', 'tit.Unidades', 'tit.Rango', 'tit.LineaTexto1', 'tit.LineaTexto2', 'tit.LineaTexto3', 'tit.LineaTexto4', 'tit.ValoresReferenciaAmpliados', 'tit.ValorMinimo', 'tit.ValorMaximo'))
                                    ->from('Titulos tit')
                                    ->where('tit.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;            
            echoResponse2(200, $response, 'Get General Títulos. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";            
            echoResponse2(200, $response, 'Get General Títulos. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de un título según un Id ingresado
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos del título encontrado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('tit.Id', 'tit.Codigo', 'tit.Descripcion', 'tit.Tipo', 'tit.Unidades', 'tit.Rango', 'tit.LineaTexto1', 'tit.LineaTexto2', 'tit.LineaTexto3', 'tit.LineaTexto4', 'tit.ValoresReferenciaAmpliados', 'tit.ValorMinimo', 'tit.ValorMaximo'))
                                    ->from('Titulos tit')
                                    ->where('tit.Id', '=', $id)
                                    ->where('tit.EstaBorrado', '=', (int) 0);
        
        $response = array();

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        
        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Títulos Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Títulos Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/auditoria', function() use($app){

    /** 
    * Crea un nuevo registro de auditoría
    *
    * @param $UsuarioId -> int
    *        $Operacion -> string
    *
    * @return Retorna, en caso de éxito, error en False y en data el Id del registro de auditoría creado y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('UsuarioId', 'Operacion'));
        $response = array();
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);

        $usuarioId = filter_var(substr($datapost['UsuarioId'], 0, 10), FILTER_SANITIZE_STRING);
        $operacion = filter_var(substr($datapost['Operacion'], 0, 500), FILTER_SANITIZE_STRING);
        $gateway_interface = filter_var(substr($_SERVER['GATEWAY_INTERFACE'], 0, 500), FILTER_SANITIZE_STRING);
        $server_addr = filter_var(substr($_SERVER['SERVER_ADDR'], 0, 500), FILTER_SANITIZE_STRING);
        $server_name = filter_var(substr($_SERVER['SERVER_NAME'], 0, 500), FILTER_SANITIZE_STRING);
        $server_software = filter_var(substr($_SERVER['SERVER_SOFTWARE'], 0, 500), FILTER_SANITIZE_STRING);
        $server_protocol = filter_var(substr($_SERVER['SERVER_PROTOCOL'], 0, 500), FILTER_SANITIZE_STRING);
        $request_method = filter_var(substr($_SERVER['REQUEST_METHOD'], 0, 500), FILTER_SANITIZE_STRING);
        $request_time = filter_var(substr($_SERVER['REQUEST_TIME'], 0, 500), FILTER_SANITIZE_STRING);
        $request_time_float = filter_var(substr($_SERVER['REQUEST_TIME_FLOAT'], 0, 500), FILTER_SANITIZE_STRING);
        $query_string = filter_var(substr($_SERVER['QUERY_STRING'], 0, 500), FILTER_SANITIZE_STRING);
        $document_root = filter_var(substr($_SERVER['DOCUMENT_ROOT'], 0, 500), FILTER_SANITIZE_STRING);
        $http_accept = filter_var(substr($_SERVER['HTTP_ACCEPT'], 0, 500), FILTER_SANITIZE_STRING);
        $http_accept_charset = filter_var(substr($_SERVER['HTTP_ACCEPT_CHARSET'], 0, 500), FILTER_SANITIZE_STRING);
        $http_accept_encoding = filter_var(substr($_SERVER['HTTP_ACCEPT_ENCODING'], 0, 500), FILTER_SANITIZE_STRING);
        $http_accept_language = filter_var(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 500), FILTER_SANITIZE_STRING);
        $http_connection = filter_var(substr($_SERVER['HTTP_CONNECTION'], 0, 500), FILTER_SANITIZE_STRING);
        $http_host = filter_var(substr($_SERVER['HTTP_HOST'], 0, 500), FILTER_SANITIZE_STRING);
        $http_referer = filter_var(substr($_SERVER['HTTP_REFERER'], 0, 500), FILTER_SANITIZE_STRING);
        $http_user_agent = filter_var(substr($_SERVER['HTTP_USER_AGENT'], 0, 500), FILTER_SANITIZE_STRING);
        $https = filter_var(substr($_SERVER['HTTPS'], 0, 500), FILTER_SANITIZE_STRING);
        $remote_addr = filter_var(substr($_SERVER['REMOTE_ADDR'], 0, 500), FILTER_SANITIZE_STRING);
        $remote_host = filter_var(substr($_SERVER['REMOTE_HOST'], 0, 500), FILTER_SANITIZE_STRING);
        $remote_port = filter_var(substr($_SERVER['REMOTE_PORT'], 0, 500), FILTER_SANITIZE_STRING);
        $remote_user = filter_var(substr($_SERVER['REMOTE_USER'], 0, 500), FILTER_SANITIZE_STRING);
        $redirect_remote_user = filter_var(substr($_SERVER['REDIRECT_REMOTE_USER'], 0, 500), FILTER_SANITIZE_STRING);
        $script_filename = filter_var(substr($_SERVER['SCRIPT_FILENAME'], 0, 500), FILTER_SANITIZE_STRING);
        $server_admin = filter_var(substr($_SERVER['SERVER_ADMIN'], 0, 500), FILTER_SANITIZE_STRING);
        $server_port = filter_var(substr($_SERVER['SERVER_PORT'], 0, 500), FILTER_SANITIZE_STRING);
        $server_signature = filter_var(substr($_SERVER['SERVER_SIGNATURE'], 0, 500), FILTER_SANITIZE_STRING);
        $path_translated = filter_var(substr($_SERVER['PATH_TRANSLATED'], 0, 500), FILTER_SANITIZE_STRING);
        $script_name = filter_var(substr($_SERVER['SCRIPT_NAME'], 0, 500), FILTER_SANITIZE_STRING);
        $request_uri = filter_var(substr($_SERVER['REQUEST_URI'], 0, 500), FILTER_SANITIZE_STRING);
        $php_auth_digest = filter_var(substr($_SERVER['PHP_AUTH_DIGEST'], 0, 500), FILTER_SANITIZE_STRING);
        $php_auth_user = filter_var(substr($_SERVER['PHP_AUTH_USER'], 0, 500), FILTER_SANITIZE_STRING);
        $php_auth_pw = filter_var(substr($_SERVER['PHP_AUTH_PW'], 0, 500), FILTER_SANITIZE_STRING);
        $auth_type = filter_var(substr($_SERVER['AUTH_TYPE'], 0, 500), FILTER_SANITIZE_STRING);
        $path_info = filter_var(substr($_SERVER['PATH_INFO'], 0, 500), FILTER_SANITIZE_STRING);
        $orig_path_info = filter_var(substr($_SERVER['ORIG_PATH_INFO'], 0, 500), FILTER_SANITIZE_STRING);

        $result = $app->pdo->CrearAuditoria(array($usuarioId, $operacion, $gateway_interface, $server_addr,$server_name,$server_software,
                                                  $server_protocol, $request_method, $request_time, $request_time_float, $query_string,
                                                  $document_root, $http_accept, $http_accept_charset, $http_accept_encoding,
                                                  $http_accept_language, $http_connection, $http_host, $http_referer, $http_user_agent,
                                                  $https, $remote_addr, $remote_host, $remote_port, $remote_user, $redirect_remote_user,
                                                  $script_filename, $server_admin, $server_port, $server_signature, $path_translated,
                                                  $script_name, $request_uri, $php_auth_digest, $php_auth_user, $php_auth_pw, $auth_type,
                                                  $path_info, $orig_path_info));

        if ($result)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse(200, $response);
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se pudo agregar el registro de auditoría";
            echoResponse(400, $response);
        }
    });
});

$app->group('/configuraciones', function() use($app){    

    /** 
    * Modifica una configuración de usuario
    *
    * @param 
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si se modifica y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('IdUsuario', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();
        
        $usuarioId            = filter_var(substr($datapost['IdUsuario'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $colorEncabezado      = filter_var(substr($datapost['ColorEncabezado'], 0, 7), FILTER_SANITIZE_STRING);
        $colorEncabezadoCinta = filter_var(substr($datapost['ColorEncabezadoCinta'], 0, 7), FILTER_SANITIZE_STRING);
        $colorMenuLateral     = filter_var(substr($datapost['ColorMenuLateral'], 0, 7), FILTER_SANITIZE_STRING);
        $colorPiePagina       = filter_var(substr($datapost['ColorPiePagina'], 0, 7), FILTER_SANITIZE_STRING);
        $colorFondo           = filter_var(substr($datapost['ColorFondo'], 0, 7), FILTER_SANITIZE_STRING);
        $logoLab              = filter_var(substr($datapost['LogoLab'], 0, 500), FILTER_SANITIZE_STRING);
        $imgusuario           = filter_var(substr($datapost['Imagen'], 0, 500), FILTER_SANITIZE_STRING);
        $nombrelab            = filter_var(substr($datapost['NombreLab'], 0, 50), FILTER_SANITIZE_STRING);
        $lemalab              = filter_var(substr($datapost['LemaLab'], 0, 100), FILTER_SANITIZE_STRING);
        $trabajarsinconexion  = filter_var(substr($datapost['TrabajarSinConexion'], 0, 1), FILTER_SANITIZE_NUMBER_INT);
        $modificadoPor        = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        //busca la configuracion por Id de usuario
        $configuracion = $app->pdo->ExisteConfiguracion($usuarioId);

        //busco el usuario por su Id
        $usuario = $app->pdo->ExisteUsuario($usuarioId);

        //busco la configuracion de sistema
        $configuracionSistema = $app->pdo->ExisteConfiguracionSistema();

        //checkea la existencia de la configuracion del usuario
        if (!$configuracion)
        {
            $response["error"] = TRUE;
            $response["data"] = "La configuración no existe";
            echoResponse2(200, $response, 'Modificar Configuración. Error: la configuración no existe');
            $app->stop();
        }

        //si los campos a modificar vienen nulos, asigno lo que ya tenían previo a modificar

        //colores -> Configuraciones
        $colorEncabezado      === '' ? $colorEncabezado = $configuracion[0]['ColorEncabezado'] : '';
        $colorEncabezadoCinta === '' ? $colorEncabezadoCinta = $configuracion[0]['ColorEncabezadoCinta'] : '';
        $colorMenuLateral     === '' ? $colorMenuLateral = $configuracion[0]['ColorMenuLateral'] : '';
        $colorPiePagina       === '' ? $colorPiePagina = $configuracion[0]['ColorPiePagina'] : '';
        $colorFondo           === '' ? $colorFondo = $configuracion[0]['ColorFondo'] : '';   

        //logo de laboratorio -> Configuracion Sistema
        $logoLab  == '' ? $logoLab = substr($configuracionSistema[0]['LogoLab'], strripos($configuracionSistema[0]['LogoLab'], '/')+1) : '';
        
        //imagen de usuario -> Usuarios
        $imgusuario == '' ? $imgusuario = substr($usuario['Imagen'], strripos($usuario['Imagen'], '/')+1) : '';

        $result = $app->pdo->ModificarConfiguracion(array($usuarioId, $colorEncabezado, $colorEncabezadoCinta, $colorMenuLateral, $colorPiePagina, $colorFondo, $imgusuario, $modificadoPor));

        if ($result)
        {   //checkea que exista el registro de configuración de sistema
            if ($app->pdo->ExisteConfiguracionSistema())
            {   //si existe, lo modifica
                $resultConfSis = $app->pdo->ModificarConfiguracionSistema(array($usuarioId, $logoLab, $nombrelab, $lemalab, $modificadoPor));   
            }
            else
            {   //si no existe, lo crea
                $resultConfSis = $app->pdo->CrearConfiguracionSistema(array($logoLab, $nombrelab, $lemalab, $trabajarsinconexion, $modificadoPor));
            }            
        }

        if ($result && $resultConfSis)
        {
            $_SESSION['UrlParcialImagen'] = 'app/usuarios/imagenes-perfil/' . $imgusuario;
            $_SESSION['UrlParcialLogo'] = 'img/logo/' . $logoLab;
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Configuración. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se pudo modificar la configuración";
            echoResponse2(400, $response, 'Modificar Configuración. Error: la configuración no se modificó');
        }        
    });

    /** 
    * Elimina una configuración de usuario
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Retorna, en caso de éxito, error en False y un 1 si se elimina y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        if ($app->pdo->ExisteConfiguracion($id))
        {
            $response["error"] = TRUE;
            $response["data"] = "La configuración no existe";
            echoResponse2(200, $response, 'Eliminar Configuración. Error: la configuración no existe');
            $app->stop();
        }

        $result = $app->pdo->EliminarConfiguracion(array($id, $modificadoPor));

        if ($result)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Configuración. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se pudo eliminar la configuración";
            echoResponse2(400, $response, 'Eliminar Configuración. Error: la configuración no se eliminó');
        }
    });

    /** 
    * Obtiene los datos de todas las configuraciones existentes    
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de todas las configuraciones encontradas y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){
        $selectStatement = $app->pdo->select(array('conf.Id', 'conf.IdUsuario', 'conf.ColorEncabezado', 'conf.ColorEncabezadoCinta', 'conf.ColorMenuLateral', 'conf.ColorPiePagina', 'conf.ColorFondo'))
                                    ->from('Configuraciones conf')
                                    ->where('conf.EstaBorrado', '=', (int) 0);
        
        $response = array();

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Configuraciones. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get General Configuraciones. Error: no se encontraron datos');
        }
    });

    /** 
    * Obtiene los datos de una configuración según su Id
    *
    * @param $Id -> int
    *
    * @return Retorna, en caso de éxito, error en False y en data los datos de la configuración encontrada y, si falla, 
    *         error en true y data con el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('conf.Id', 'conf.IdUsuario', 'conf.ColorEncabezado', 'conf.ColorEncabezadoCinta', 'conf.ColorMenuLateral', 'conf.ColorPiePagina', 'conf.ColorFondo'))
                                    ->from('Configuraciones conf')
                                    ->where('conf.IdUsuario', '=', $id)
                                    ->where('conf.EstaBorrado', '=', (int) 0);
        
        $response = array();

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Configuraciones Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Configuraciones Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/configuracionessistema', function() use($app){

    /**
    * Obtiene le registro de configuración del sistema
    *
    * @return Devuelve en caso de encontrarlo, el registro de configuración del sistema, en caso de fallar error en
    *         True y en data el mensaje de error
    */
    $app->get('/', 'Autenticar', function() use($app){
        $selectStatement = $app->pdo->select(array())
                                    ->from('ConfiguracionesSistema')
                                    ->where('EstaBorrado', '=', (int) 0);

        $response = array();
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data)
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get ConfiguracionesSistema. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get ConfiguracionesSistema. Error: no se encontraron datos');
        }
    });
});

$app->group('/resultados', function() use($app){

    /**
    * Crea un nuevo resultado para un paciente
    *
    * @param $PacienteId -> int
    *        $NomencladorId -> int
    *        $Resultado -> string    
    *        $CreadoPor -> string
    *
    * @return Devuelve en caso de éxito error en False y en data el Id del registro recientemente creado y, si falla
    *         error en True y en data el mensaje de error correspondiente.
    */
    $app->post('/crear', 'Autenticar', function() use($app){
        verifyRequiredParams(array('IngresoId', 'CreadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $ingresoid = filter_var(substr($datapost['IngresoId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $nomenclador1Id = filter_var(substr($datapost['Nomenclador1Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado1 = filter_var(substr($datapost['Resultado1'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador2Id = filter_var(substr($datapost['Nomenclador2Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado2 = filter_var(substr($datapost['Resultado2'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador3Id = filter_var(substr($datapost['Nomenclador3Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado3 = filter_var(substr($datapost['Resultado3'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador4Id = filter_var(substr($datapost['Nomenclador4Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado4 = filter_var(substr($datapost['Resultado4'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador5Id = filter_var(substr($datapost['Nomenclador5Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado5 = filter_var(substr($datapost['Resultado5'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador6Id = filter_var(substr($datapost['Nomenclador6Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado6 = filter_var(substr($datapost['Resultado6'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador7Id = filter_var(substr($datapost['Nomenclador7Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado7 = filter_var(substr($datapost['Resultado7'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador8Id = filter_var(substr($datapost['Nomenclador8Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado8 = filter_var(substr($datapost['Resultado8'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador9Id = filter_var(substr($datapost['Nomenclador9Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado9 = filter_var(substr($datapost['Resultado9'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador10Id = filter_var(substr($datapost['Nomenclador10Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado10 = filter_var(substr($datapost['Resultado10'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador11Id = filter_var(substr($datapost['Nomenclador11Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado11 = filter_var(substr($datapost['Resultado11'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador12Id = filter_var(substr($datapost['Nomenclador12Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado12 = filter_var(substr($datapost['Resultado12'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador13Id = filter_var(substr($datapost['Nomenclador13Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado13 = filter_var(substr($datapost['Resultado13'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador14Id = filter_var(substr($datapost['Nomenclador14Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado14 = filter_var(substr($datapost['Resultado14'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador15Id = filter_var(substr($datapost['Nomenclador15Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado15 = filter_var(substr($datapost['Resultado15'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador16Id = filter_var(substr($datapost['Nomenclador16Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado16 = filter_var(substr($datapost['Resultado16'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador17Id = filter_var(substr($datapost['Nomenclador17Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado17 = filter_var(substr($datapost['Resultado17'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador18Id = filter_var(substr($datapost['Nomenclador18Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado18 = filter_var(substr($datapost['Resultado18'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador19Id = filter_var(substr($datapost['Nomenclador19Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado19 = filter_var(substr($datapost['Resultado19'], 0, 50), FILTER_SANITIZE_STRING);
        $nomenclador20Id = filter_var(substr($datapost['Nomenclador20Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $resultado20 = filter_var(substr($datapost['Resultado20'], 0, 50), FILTER_SANITIZE_STRING);
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);        

        //crea el resultado
        $result = $app->pdo->CrearResultado(array($ingresoid, $creadoPor), 
                                            array($nomenclador1Id, $nomenclador2Id, $nomenclador3Id, $nomenclador4Id, $nomenclador5Id,
                                                  $nomenclador6Id, $nomenclador7Id, $nomenclador8Id, $nomenclador9Id, $nomenclador10Id,
                                                  $nomenclador11Id, $nomenclador12Id, $nomenclador13Id, $nomenclador14Id, $nomenclador15Id,
                                                  $nomenclador16Id, $nomenclador17Id, $nomenclador18Id, $nomenclador19Id, $nomenclador20Id),
                                            array($resultado1, $resultado2, $resultado3, $resultado4, $resultado5, $resultado6,
                                                  $resultado7, $resultado8, $resultado9, $resultado10, $resultado11, $resultado12,
                                                  $resultado13, $resultado14, $resultado15, $resultado16, $resultado17, $resultado18,
                                                  $resultado19, $resultado20));

        if ($result)
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Crear Resultado. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El resultado no se creó";
            echoResponse2(400, $response, 'CrearResultado. Error: no se creó el resultado');
        }
    });
  
  
    $app->post('/crearlo', 'Autenticar', function() use($app){
        verifyRequiredParams(array('IngresoId', 'NomencladorId', 'Resultado', 'EsUltimoResultado'));
        
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();
      
        $ingresoid          =    filter_var(substr($datapost['IngresoId'], 0, 10),             FILTER_SANITIZE_NUMBER_INT);
        $nomencladorId      =    filter_var(substr($datapost['NomencladorId'], 0, 10),         FILTER_SANITIZE_NUMBER_INT);
        $resultado          =    filter_var(substr($datapost['Resultado'], 0, 10),             FILTER_SANITIZE_NUMBER_INT);
        $esUltimoResultado  =    filter_var(substr($datapost['EsUltimoResultado'], 0, 10),     FILTER_SANITIZE_STRING);
      
        //crea el resultado
        $result = $app->pdo->CrearloResultado(array($ingresoid, $nomencladorId, $resultado, $esUltimoResultado == 1, 'mlazzeri'));
      
        $response["error"] = false;
        $response["data"] = $result;
        $response["esUltimoResultado"] = $esUltimoResultado == 1;
        echoResponse2(200, $response, 'CrearResultado. Error: no se creó el resultado');
      
    });

    /**
    *
    * Modifica un resultado según su Id
    *
    * @param $Id -> int
    *        $NomencladorId -> int
    *        $Resultado -> string    
    *        $ModificadoPor -> string    
    *
    * @return Devuelve en caso de éxito, error en False y un 1 si se modifica correctamente y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->put('/modificar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('IngresoId', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();
        
        $ingresoId = filter_var(substr($datapost['IngresoId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $practicas = $datapost['Practicas'];
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        if ($practicas[0][1] == null || $practicas[0][1] == undefined || $practicas[0][1] == '') 
        {
            $response["error"] = true;
            $response["data"] = 'No se han ingresado practicas';
            echoResponse2(200, $response, 'Modificar Resultad. Error: no se han ingresado practicas');
            $app->stop();
        }

        $result = $app->pdo->ModificarResultado(array($ingresoId, $modificadoPor), $practicas);
        
        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Modificar Resultado. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "El resultado no se modificó";
            echoResponse2(400, $response, 'Modificar Resultado. Error: no se modificó el resultado');
        }
    });

    /**
    *
    * Elimina un resultado según su Id
    *
    * @param $Id -> int
    *        $ModificadoPor -> string
    *
    * @return Devuelve en caso de eliminar el resultado, error en False y un 1 y, si falla, error en True y en data el
    *         mensaje de error.
    */
    $app->delete('/eliminar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id', 'ModificadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);
        $modificadoPor = filter_var(substr($datapost['ModificadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        if (!$app->pdo->ExisteResultado($id))
        {
            $response["error"] = TRUE;
            $response["data"] = "El resultado no existe";
            echoResponse2(200, $response, 'Eliminar Resultado. Error: el resultado no existe');
            $app->stop();
        }

        $resulto = $app->pdo->EliminarResultado(array($id, $modificadoPor));

        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Eliminar Resultado. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se eliminó el resultado";
            echoResponse2(400, $response, 'Eliminar Resultado. Error: no se eliminó el resultado');
        }
    });

    /**
    *
    * Obtiene todos los resultados según un paginado
    *
    * @param $Offset -> int
    *
    * @return Devuelve en caso de éxito todos los datos de los resultados comprendidos en la página solicitada y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->post('/', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Offset'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $offset = filter_var(substr($datapost['Offset'], 0, 3), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('res.Id', 'res.IngresoId', 'res.NomencladorId', 'res.Resultado'))
                                    ->from('Resultados res')
                                    ->where('res.EstaBorrado', '=', (int) 0)
                                    ->limit(20, ($offset - 1) * 20);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        $selectStatement->count('res.Id', $as = 'Total') //ToDo -> pasar a sp
                        ->from('Resultados res')
                        ->where('res.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ultimaPag = $stmt->fetchAll();

        if ((($ultimaPag[0]['Total']) - (20 + ($offset - 1) * 20)) > 0)
        {
            $ultimaPag = false;
        }
        else
        {
            $ultimaPag = true;
        }

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["ultimaPag"] = $ultimaPag;
            echoResponse2(200, $response, 'Get Paginado Resultados. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Paginado Resultados. Error: no se encontraron datos');
        }
    });

    /**
    *
    * Obtiene todos los resultados existentes
    *
    * @return Devuelve en caso de éxito todos los datos de los resultados existentes y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->get('/', 'Autenticar', function() use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('res.IngresoId as IngresoId', 'ing.PacienteId', 'ing.NumPaciente', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'med.Id as MedicoId', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed'))
                                    ->from('Resultados res')
                                    ->join('Ingresos ing', 'res.IngresoId', '=', 'ing.Id', 'INNER')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')                                    
                                    ->where('res.EstaBorrado', '=', (int) 0)
                                    ->groupby('ing.NumPaciente');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get General Resultados. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get General Resultados. Error: no se encontraron datos');
        }
    });

    $app->post('/idpaciente', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Id'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['Id'], 0, 10), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('res.Id as ResultadoId', 'res.IngresoId as IngresoId', 'res.NomencladorId', 'res.Resultado', 'ing.PacienteId', 'ing.NumPaciente', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'med.Id', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed'))
                                    ->from('Resultados res')
                                    ->join('Ingresos ing', 'res.IngresoId', '=', 'ing.Id', 'INNER')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')  
                                    ->where('pac.Id', '=', (int) $id)                                  
                                    ->where('res.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Resultados Por PacienteId. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Get Resultados Por PacienteId. Error: no se encontraron datos');
        }
    });

    $app->post('/idingreso', 'Autenticar', function() use($app){
        verifyRequiredParams(array('IngresoId'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $id = filter_var(substr($datapost['IngresoId'], 0, 10), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('res.Id as ResultadoId', 'res.IngresoId as IngresoId', 'res.NomencladorId', 'res.Resultado', 'tit.Unidades', 'tit.Rango', 'tit.ValorMinimo', 'tit.ValorMaximo', 'tit.ValoresReferenciaAmpliados', 'tit.Tipo', 'tit.Descripcion', 'tit.Codigo', 'ing.PacienteId', 'ing.NumPaciente', 'pac.ApellidoNombre', 'pac.NumDocumento', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'med.Id', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed'))
                                    ->from('Resultados res')       
                                    ->join('Practicas nom', 'res.NomencladorId', '=', 'nom.Id', 'INNER')
                                    ->join('Titulos tit', 'nom.Codigo', '=', 'tit.Codigo')
                                    ->join('Ingresos ing', 'res.IngresoId', '=', 'ing.Id', 'INNER')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')                                    
                                    ->where('res.IngresoId', '=', (int) $id)
                                    ->where('res.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Resultados Por IngresoId. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Get Resultados Por IngresoId. Error: no se encontraron datos');
        }
    });

    $app->post('/pornumpaciente', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumPaciente'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $numpaciente = filter_var(substr($datapost['NumPaciente'], 0, 8), FILTER_SANITIZE_NUMBER_INT);
        $dni = filter_var(substr($datapost['NumPaciente'], 0, 10), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('res.Id as ResultadoId', 'res.IngresoId as IngresoId', 'res.NomencladorId', 'res.Resultado', 'ing.PacienteId', 'ing.NumPaciente', 'pac.ApellidoNombre', 'pac.NumDocumento', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'med.Id as MedicoId', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed'))
                                    ->from('Resultados res')
                                    ->join('Ingresos ing', 'res.IngresoId', '=', 'ing.Id', 'INNER')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->whereLike('ing.NumPaciente', '%'.$numpaciente.'%')
                                    ->orWhereLike('pac.NumDocumento', '%'.$numpaciente.'%')
                                    ->where('res.EstaBorrado', '=', (int) 0)
                                    ->groupby('ing.NumPaciente');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Resultados Por NumPaciente. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Get Resultados Por NumPaciente. Error: no se encontraron datos');
        }
    });

    $app->post('/porapellidonombre', 'Autenticar', function() use($app){
        verifyRequiredParams(array('ApellidoNombre'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $apellidonombre = filter_var(substr($datapost['ApellidoNombre'], 0, 50), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('res.Id as ResultadoId', 'res.IngresoId as IngresoId', 'res.NomencladorId', 'res.Resultado', 'ing.PacienteId', 'ing.NumPaciente', 'pac.ApellidoNombre', 'pac.NumDocumento', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'med.Id', 'med.Matricula', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed'))
                                    ->from('Resultados res')
                                    ->join('Ingresos ing', 'res.IngresoId', '=', 'ing.Id', 'INNER')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->whereLike('pac.ApellidoNombre', '%'.$apellidonombre.'%')
                                    ->where('res.EstaBorrado', '=', (int) 0)
                                    ->groupby('ing.NumPaciente');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            $response["cantidad"] = count($data);
            echoResponse2(200, $response, 'Get Resultados Por ApellidoNombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Get Resultados Por ApellidoNombre. Error: no se encontraron datos');
        }
    });

    /**
    *
    * Obtiene los datos de un resultado en particular según su Id
    *
    * @return Devuelve en caso de éxito los datos del resultados buscado y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->get('/:id', 'Autenticar', function($id) use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('res.Id', 
                                                   'res.IngresoId', 
                                                   'res.NomencladorId', 
                                                   'res.Resultado'))
                                    ->from('Resultados res')
                                    ->where('res.EstaBorrado', '=', (int) 0);

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Id Resultados. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Id Resultados. Error: no se encontraron datos');
        }
    });

    $app->post('/ingresos/pornombre', 'Autenticar', function() use($app){
        verifyRequiredParams(array('ApellidoNombre', 'DesdeProtocolo'));

        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $apellidonombre = filter_var(substr($datapost['ApellidoNombre'], 0, 50), FILTER_SANITIZE_STRING);
        $desdeProtocolo = $datapost['DesdeProtocolo'];

        if($desdeProtocolo == 0)
        {            

            $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 
                                                       'ing.NumPaciente', 
                                                       'ing.PacienteId', 
                                                       'ing.Cama', 
                                                       'ing.SinCargo', 
                                                       'ing.RealizaDescuentos', 
                                                       'ing.ReajustaImporte', 
                                                       'ing.AbonoSena', 
                                                       'ing.Comentarios', 
                                                       'pac.ApellidoNombre', 
                                                       'pac.FechaNacimiento', 
                                                       'pac.Sexo', 
                                                       'pac.Origen', 
                                                       'pac.Cuenta', 
                                                       'pac.Direccion', 
                                                       'pac.NumDocumento', 
                                                       'pac.Telefono', 
                                                       'pac.Celular', 
                                                       'pac.Lugar', 
                                                       'pac.Mail', 
                                                       'pac.MatriculaMedico as MedicoId', 
                                                       'med.Apellido as ApellidoMed', 
                                                       'med.Nombre as NombreMed', 
                                                       'med.Matricula', 
                                                       'mut1.Id as Mutual1Id', 
                                                       'mut1.Codigo as Mutual1Cod', 
                                                       'mut1.Nombre as Mutual1Nombre', 
                                                       'mut1.PorcCobertura as PorcCobertura1', 
                                                       'pac.DebeOrden1', 
                                                       'pac.NumAfiliado1', 
                                                       'pac.TipoAfiliado1', 
                                                       'mut2.Id as Mutual2Id', 
                                                       'mut2.Codigo as Mutual2Cod', 
                                                       'mut2.Nombre as Mutual2Nombre', 
                                                       'mut2.PorcCobertura as PorcCobertura2', 
                                                       'pac.DebeOrden2', 
                                                       'pac.NumAfiliado2', 
                                                       'pac.TipoAfiliado2', 
                                                       'pac.Factor', 
                                                       'pac.ActoProf'))
                                        ->from('Ingresos ing')                                    
                                        ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                        ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                        ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                        ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                        ->whereLike('pac.ApellidoNombre', '%'.$apellidonombre.'%')
                                        ->where('ing.EstaBorrado', '=', (int) 0)
                                        ->where('ing.EstaCompleto', '=', (int) 0);
        }
        else
        {
            $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 
                                                       'ing.NumPaciente', 
                                                       'ing.PacienteId', 
                                                       'ing.Cama', 
                                                       'ing.SinCargo', 
                                                       'ing.RealizaDescuentos', 
                                                       'ing.ReajustaImporte', 
                                                       'ing.AbonoSena', 
                                                       'ing.Comentarios', 
                                                       'pac.ApellidoNombre', 
                                                       'pac.FechaNacimiento', 
                                                       'pac.Sexo', 
                                                       'pac.Origen', 
                                                       'pac.Cuenta', 
                                                       'pac.Direccion', 
                                                       'pac.NumDocumento', 
                                                       'pac.Telefono', 
                                                       'pac.Celular', 
                                                       'pac.Lugar', 
                                                       'pac.Mail', 
                                                       'pac.MatriculaMedico as MedicoId', 
                                                       'med.Apellido as ApellidoMed', 
                                                       'med.Nombre as NombreMed', 
                                                       'med.Matricula', 
                                                       'mut1.Id as Mutual1Id', 
                                                       'mut1.Codigo as Mutual1Cod', 
                                                       'mut1.Nombre as Mutual1Nombre', 
                                                       'mut1.PorcCobertura as PorcCobertura1', 
                                                       'pac.DebeOrden1', 
                                                       'pac.NumAfiliado1', 
                                                       'pac.TipoAfiliado1', 
                                                       'mut2.Id as Mutual2Id', 
                                                       'mut2.Codigo as Mutual2Cod', 
                                                       'mut2.Nombre as Mutual2Nombre', 
                                                       'mut2.PorcCobertura as PorcCobertura2', 
                                                       'pac.DebeOrden2', 
                                                       'pac.NumAfiliado2', 
                                                       'pac.TipoAfiliado2', 
                                                       'pac.Factor', 
                                                       'pac.ActoProf'))
                                        ->from('Ingresos ing')                                    
                                        ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                        ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                        ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                        ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                        ->whereLike('pac.ApellidoNombre', '%'.$apellidonombre.'%')
                                        ->where('ing.EstaBorrado', '=', (int) 0);
        }

        $resultadosIngresos = $selectStatement->execute();

        $ingresos = $resultadosIngresos->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $ingresosP = IngresosPractica($ingresos);

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;
            $response["cantidad"] = count($ingresos);
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por ApellidoNombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por ApellidoNombre. Error: no se encontraron datos');
        }
    });

    $app->post('/ingresos/pornumpaciente', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumPaciente'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $numpaciente = filter_var(substr($datapost['NumPaciente'], 0, 8), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 'ing.NumPaciente', 'ing.PacienteId', 'ing.Cama', 'ing.SinCargo', 'ing.RealizaDescuentos', 'ing.ReajustaImporte', 'ing.AbonoSena', 'ing.Comentarios', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail', 'pac.MatriculaMedico as MedicoId', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed', 'med.Matricula', 'mut1.Id as Mutual1Id', 'mut1.Codigo as Mutual1Cod', 'mut1.Nombre as Mutual1Nombre', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as Mutual2Cod', 'mut2.Nombre as Mutual2Nombre', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->whereLike('ing.NumPaciente', '%'.$numpaciente.'%')
                                    ->where('ing.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 'ingp.IngresoId as IngresoId', 'ingp.NomencladorId', 'pr.Id as PracticaId', 'pr.Codigo as PracticaCodigo', 'pr.Nombre as PracticaNombre', 'pr.EsNomencladorTrabajo', 'tit.Codigo as CodTitulo', 'tit.Descripcion as TitDescrip', 'tit.Tipo as TitTipo', 'tit.Unidades as TitUnidades', 'tit.Rango as TitRango', 'tit.LineaTexto1', 'tit.LineaTexto2', 'tit.LineaTexto3', 'tit.LineaTexto4', 'tit.ValoresReferenciaAmpliados', 'tit.ValorMinimo', 'tit.ValorMaximo'))
                                        ->from('IngresosPracticas ingp')
                                        ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                        ->join('Titulos tit', 'pr.Codigo', '=', 'tit.Codigo', 'INNER')
                                        ->where('ingp.IngresoId', '=', $ingresos[$i]['IngresoId'])
                                        ->where('ingp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $ingresosP = $stmt->fetchAll();

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if (count($ingresos) == 1) 
        {
            $selectStatement = $app->pdo->select(array('res.IngresoId', 'res.NomencladorId', 'res.Resultado'))
                                        ->from('Resultados res')
                                        ->where('res.IngresoId', '=', $ingresos[0]['IngresoId'])
                                        ->where('res.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $resultado = $stmt->fetchAll();

            if ($resultado) 
            {
                $response["error"] = TRUE;
                $response["data"] = 'El ingreso ya tiene resultados';
                echoResponse2(200, $response, 'Get Ingresos Para Resultados Por Id. Error: el ingreso ya tiene resultados');
                $app->stop();
            }   
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;
            $response["cantidad"] = count($ingresos);
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por Número de Paciente. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por Número de Paciente. Error: no se encontraron datos');
        }
    });

    $app->post('/ingresos/pordni', 'Autenticar', function() use($app){
        verifyRequiredParams(array('DNI'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $dni = filter_var(substr($datapost['DNI'], 0, 8), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 'ing.NumPaciente', 'ing.PacienteId', 'ing.Cama', 'ing.SinCargo', 'ing.RealizaDescuentos', 'ing.ReajustaImporte', 'ing.AbonoSena', 'ing.Comentarios', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'pac.Origen', 'pac.Cuenta', 'pac.Direccion', 'pac.NumDocumento', 'pac.Telefono', 'pac.Celular', 'pac.Lugar', 'pac.Mail', 'pac.MatriculaMedico as MedicoId', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed', 'med.Matricula', 'mut1.Id as Mutual1Id', 'mut1.Codigo as Mutual1Cod', 'mut1.Nombre as Mutual1Nombre', 'mut1.PorcCobertura as PorcCobertura1', 'pac.DebeOrden1', 'pac.NumAfiliado1', 'pac.TipoAfiliado1', 'mut2.Id as Mutual2Id', 'mut2.Codigo as Mutual2Cod', 'mut2.Nombre as Mutual2Nombre', 'mut2.PorcCobertura as PorcCobertura2', 'pac.DebeOrden2', 'pac.NumAfiliado2', 'pac.TipoAfiliado2', 'pac.Factor', 'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->whereLike('pac.NumDocumento', '%'.$dni.'%')
                                    ->where('ing.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 'ingp.IngresoId as IngresoId', 'ingp.NomencladorId', 'pr.Id as PracticaId', 'pr.Codigo as PracticaCodigo', 'pr.Nombre as PracticaNombre', 'pr.EsNomencladorTrabajo', 'tit.Codigo as CodTitulo', 'tit.Descripcion as TitDescrip', 'tit.Tipo as TitTipo', 'tit.Unidades as TitUnidades', 'tit.Rango as TitRango', 'tit.LineaTexto1', 'tit.LineaTexto2', 'tit.LineaTexto3', 'tit.LineaTexto4', 'tit.ValoresReferenciaAmpliados', 'tit.ValorMinimo', 'tit.ValorMaximo'))
                                        ->from('IngresosPracticas ingp')
                                        ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                        ->join('Titulos tit', 'pr.Codigo', '=', 'tit.Codigo', 'INNER')
                                        ->where('ingp.IngresoId', '=', $ingresos[$i]['IngresoId'])
                                        ->where('ingp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $ingresosP = $stmt->fetchAll();

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if (count($ingresos) == 1) 
        {
            $selectStatement = $app->pdo->select(array('res.IngresoId', 'res.NomencladorId', 'res.Resultado'))
                                        ->from('Resultados res')
                                        ->where('res.IngresoId', '=', $ingresos[0]['IngresoId'])
                                        ->where('res.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $resultado = $stmt->fetchAll();

            if ($resultado) 
            {
                $response["error"] = TRUE;
                $response["data"] = 'El ingreso ya tiene resultados';
                echoResponse2(200, $response, 'Get Ingresos Para Resultados Por Id. Error: el ingreso ya tiene resultados');
                $app->stop();
            }   
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;
            $response["cantidad"] = count($ingresos);
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por DNI. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por DNI. Error: no se encontraron datos');
        }
    });

    $app->get('/ingresos/:id', 'Autenticar', function($id) use($app){
        $selectStatement = $app->pdo->select(array('res.IngresoId', 'res.NomencladorId', 'res.Resultado'))
                                    ->from('Resultados res')
                                    ->where('res.IngresoId', '=', $id)
                                    ->where('res.EstaBorrado', '=', (int) 0);
        $stmt = $selectStatement->execute();
        $resultado = $stmt->fetchAll();

        if ($resultado) 
        {
            $response["error"] = TRUE;
            $response["data"] = 'El ingreso ya tiene resultados';
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por Id. Error: el ingreso ya tiene resultados');
            $app->stop();
        }        

        //obtengo el ingreso en concreto que busco según su Id
        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 
                                                   'ing.NumPaciente', 
                                                   'ing.PacienteId', 
                                                   'ing.Cama', 
                                                   'ing.SinCargo', 
                                                   'ing.RealizaDescuentos', 
                                                   'ing.ReajustaImporte', 
                                                   'ing.AbonoSena', 
                                                   'ing.Comentarios', 
                                                   'pac.ApellidoNombre', 
                                                   'pac.FechaNacimiento', 
                                                   'pac.Sexo', 
                                                   'pac.Origen', 
                                                   'pac.Cuenta', 
                                                   'pac.Direccion', 
                                                   'pac.NumDocumento', 
                                                   'pac.Telefono', 
                                                   'pac.Celular', 
                                                   'pac.Lugar', 
                                                   'pac.Mail', 
                                                   'pac.MatriculaMedico as MedicoId', 
                                                   'med.Apellido as ApellidoMed', 
                                                   'med.Nombre as NombreMed', 
                                                   'med.Matricula', 
                                                   'mut1.Id as Mutual1Id', 
                                                   'mut1.Codigo as Mutual1Cod', 
                                                   'mut1.Nombre as Mutual1Nombre', 
                                                   'mut1.PorcCobertura as PorcCobertura1', 
                                                   'pac.DebeOrden1', 
                                                   'pac.NumAfiliado1', 
                                                   'pac.TipoAfiliado1', 
                                                   'mut2.Id as Mutual2Id', 
                                                   'mut2.Codigo as Mutual2Cod', 
                                                   'mut2.Nombre as Mutual2Nombre', 
                                                   'mut2.PorcCobertura as PorcCobertura2', 
                                                   'pac.DebeOrden2',
                                                   'pac.NumAfiliado2', 
                                                   'pac.TipoAfiliado2', 
                                                   'pac.Factor', 
                                                   'pac.ActoProf'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Mutuales mut1', 'pac.Mutual1', '=', 'mut1.Id', 'LEFT')
                                    ->join('Mutuales mut2', 'pac.Mutual2', '=', 'mut2.Id', 'LEFT')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->where('ing.Id', '=', $id)
                                    ->where('ing.EstaBorrado', '=', (int) 0);                                   
        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        //obtengo los ingresos práctica que tenga asociados el ingreso que deseo obtener, tambien con el Id del ingreso
        $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 
                                                   'ingp.IngresoId as IngresoId', 
                                                   'ingp.NomencladorId', 
                                                   'pr.Id as PracticaId', 
                                                   'pr.Codigo as PracticaCodigo', 
                                                   'pr.Nombre as PracticaNombre', 
                                                   'pr.EsNomencladorTrabajo', 
                                                   'tit.Codigo as CodTitulo', 
                                                   'tit.Descripcion as TitDescrip', 
                                                   'tit.Tipo as TitTipo', 
                                                   'tit.Unidades as TitUnidades', 
                                                   'tit.Rango as TitRango', 
                                                   'tit.LineaTexto1', 
                                                   'tit.LineaTexto2', 
                                                   'tit.LineaTexto3', 
                                                   'tit.LineaTexto4', 
                                                   'tit.ValoresReferenciaAmpliados', 
                                                   'tit.ValorMinimo', 
                                                   'tit.ValorMaximo',
                                                   'secc.Nombre AS NombreSeccion'))
                                    ->from('IngresosPracticas ingp')
                                    ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                    ->join('SeccionesPracticas seccPr', 'pr.Id', '=', 'seccPr.PracticaId', 'INNER')
                                    ->join('Secciones secc', 'seccPr.SeccionId', '=', 'secc.Id', 'INNER')
                                    ->join('Titulos tit', 'pr.Codigo', '=', 'tit.Codigo', 'INNER')
                                    ->where('ingp.IngresoId', '=', $id)
                                    ->where('ingp.EstaBorrado', '=', (int) 0);
        $stmt = $selectStatement->execute();
        $ingresosP = $stmt->fetchAll();

        if ($ingresosP) 
        {
            $ingresos[0]['IngresosPractica'] = $ingresosP;
        }
        else
        {
            $ingresos[0]['IngresosPractica'] = NULL;
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;            
            echoResponse2(200, $response, 'Get Ingresos Por Id. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Para Resultados Por Id. Error: no se encontraron datos');
        }
    });
});

$app->group('/validacion', function() use($app){

    /**
    * Verifica que en cada determinación el nomenclador especificado, se encuentre en la sección especificada en el orden especificado.
    *
    * @return Devuelve, en caso que la validación sea correcta un True, y en caso que sea incorrecta, devuelve un False.
    */
    $app->get('/nomencladorseccion', function() use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('det.Id', 'det.Nombre', 'det.Seccion', 'det.Orden'))
                                    ->from('Determinaciones det')
                                    ->where('det.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if (!$data) 
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron determinaciones a validar";
            echoResponse2(200, $response, 'Validación Archivos Nomenclador/Sección. Error: no se encontraron determinaciones a validar');
            $app->stop();
        }

        $validacionCorrecta = TRUE;

        if ($data) 
        {
            for ($i = 0; $i < count($data); $i++) 
            { 
                $selectStatement = $app->pdo->select(array('sec.Id', 'sec.Codigo', 'sec.Determinacion'.$data[$i]['Orden']))
                                            ->from('Secciones sec')   
                                            ->where('sec.Codigo', '=', $data[$i]['Seccion'])
                                            ->where('sec.Determinacion'.$data[$i]['Orden'], '=', $data[$i]['Nombre'])
                                            ->where('sec.EstaBorrado', '=', (int) 0);

                $stmt = $selectStatement->execute();
                $data2 = $stmt->fetchAll();

                if ($data2) 
                {
                    $data3[$i] = $data2;
                }                
                else
                {
                    $validacionCorrecta = FALSE;
                    $i = 1000;
                }
            }
        }

        if ($data3)
        {
            if ($validacionCorrecta) 
            {
                $response["error"] = FALSE;
                $response["data"] = $validacionCorrecta;                
                echoResponse2(200, $response, 'Validación Archivos Nomenclador/Sección. Correcto');
            }
            else
            {
                $response["error"] = TRUE;
                $response["data"] = "La validación es incorrecta";
                echoResponse2(200, $response, 'Validación Archivos Nomenclador/Sección. Error: la validación es incorrecta');
            }
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "La validación es incorrecta";
            echoResponse2(200, $response, 'Validación Archivos Nomenclador/Sección. Error: la validación es incorrecta');
        }        
    });

    /**
    * Verifica que en cada determinación el nomenclador especificado, se encuentre en la sección especificada en el orden especificado.
    *
    * @return Devuelve, en caso que la validación sea correcta un True, y en caso que sea incorrecta, devuelve un False.
    */
    $app->get('/nomencladortitulo', function() use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array())
                                    ->from('Determinaciones det')
                                    ->where('det.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Validación Archivos Nomenclador/Título. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Validación Archivos Nomenclador/Título. Error: no se encontraron datos');
        }
    });
});

$app->group('/protocolos', function() use($app){

    $app->post('/PorApellidoNombre', function() use($app){
        VerificarParametrosRequeridos(array('ApellidoNombre'));

        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $apellidonombre = filter_var(substr($datapost['ApellidoNombre'], 0, 50), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('ing.Id as IngresoId', 
                                                   'ing.NumPaciente', 
                                                   'pac.ApellidoNombre'))
                                    ->from('Ingresos ing')                                    
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->whereLike('pac.ApellidoNombre', '%'.$apellidonombre.'%')
                                    ->where('ing.EstaBorrado', '=', (int) 0);                                   

        $stmt = $selectStatement->execute();
        $ingresos = $stmt->fetchAll();

        for ($i = 0; $i < count($ingresos); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 
                                                       'ingp.IngresoId as IngresoId', 
                                                       'ingp.NomencladorId', 
                                                       'pr.Id as PracticaId', 
                                                       'pr.Codigo as PracticaCodigo', 
                                                       'pr.Nombre as PracticaNombre', 
                                                       'pr.EsNomencladorTrabajo',
                                                       'res.Resultado',
                                                       'res.EstaEmitido'))
                                        ->from('IngresosPracticas ingp')
                                        ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id', 'INNER')
                                        ->join('Resultados res', 'ingp.IngresoId', '=', 'res.IngresoId', 'INNER')
                                        ->where('ingp.IngresoId', '=', $ingresos[$i]['IngresoId'])
                                        ->where('ingp.EstaBorrado', '=', (int) 0)
                                        ->where('pr.EstaBorrado', '=', (int) 0)
                                        ->where('res.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();

            $ingresosP = $stmt->fetchAll();

            if ($ingresosP) 
            {
                $ingresos[$i]['IngresosPractica'] = $ingresosP;
            }
            else
            {
                $ingresos[$i]['IngresosPractica'] = NULL;
            }
        }

        if ($ingresos) 
        {
            $response["error"] = FALSE;
            $response["data"] = $ingresos;
            $response["cantidad"] = count($ingresos);
            GenerarRespuesta(200, $response, 'Get Ingresos Por ApellidoNombre. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            GenerarRespuesta(200, $response, 'Get Ingresos Por ApellidoNombre. Error: no se encontraron datos');
        }
    });
});

$app->group('/valoresunidades', function() use($app){

    /**
    * Actualiza los valores de unidades en uso
    *
    * @param $NumeroUsoArranque -> int
    *        $ValorFABAA -> decimal
    *        $ValorFABAB -> decimal
    *        $ValorFABAC -> decimal
    *        $ValorNBUAltaFrec -> decimal
    *        $ValorNBUBajaFrec -> decimal
    *        $PMO -> decimal
    *        $UGastos -> int
    *        $UHonorarios -> int
    *        $Recibos -> string
    *        $Etiquetas -> string
    *        $Tarjetas -> string
    *        $ValorPracticaMinima -> int
    *        $ExtraccionDomicilio -> int
    *        $ActoProfesionalBioquimico -> int
    *        ValorMontoMaximo -> int
    *        $NumeradorDerivaciones -> string
    *        $SeccionFormulaHemograma -> string
    *        $PosicionSeccion -> string
    *        $PracticasComponentes -> string
    *        $DecodificarNemotecnicos -> int
    *        $CreadoPor -> string
    *
    * @return Devuelve en caso de crear el registro de valores, error en False y en data el Id del registro creado. En caso
    *         de modificar el registro de valores, error en False y en data un 1. Y si falla, devuelve error en True y en data
    *         el mensaje de error.
    */
    $app->post('/actualizar', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumeroUsoArranque', 'ValorFABAA', 'ValorFABAB', 'ValorFABAC', 'ValorNBUAltaFrec', 'ValorNBUBajaFrec', 'PMO', 'UGastos', 'UHonorarios', 'Recibos', 'Etiquetas', 'Tarjetas', 'ValorPracticaMinima', 'ExtraccionDomicilio', 'ActoProfesionalBioquimico', 'ValorMontoMaximo', 'NumeradorDerivaciones', 'SeccionFormulaHemograma', 'PosicionSeccion', /*'PracticasComponentes',*/ 'DecodificarNemotecnicos', 'CreadoPor'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();
        
        $numeroUsoArranque = filter_var(substr($datapost['NumeroUsoArranque'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $valorFabaA = filter_var(substr($datapost['ValorFABAA'], 0, 7), FILTER_SANITIZE_STRING);
        $valorFabaB = filter_var(substr($datapost['ValorFABAB'], 0, 7), FILTER_SANITIZE_STRING);
        $valorFabaC = filter_var(substr($datapost['ValorFABAC'], 0, 7), FILTER_SANITIZE_STRING);
        $valorNbuAF = filter_var(substr($datapost['ValorNBUAltaFrec'], 0, 7), FILTER_SANITIZE_STRING);
        $valorNbuBF = filter_var(substr($datapost['ValorNBUBajaFrec'], 0, 7), FILTER_SANITIZE_STRING);
        $pmo = filter_var(substr($datapost['PMO'], 0, 7), FILTER_SANITIZE_STRING);
        $uGastos = filter_var(substr($datapost['UGastos'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $uHonorarios = filter_var(substr($datapost['UHonorarios'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $recibos = filter_var(substr($datapost['Recibos'], 0, 50), FILTER_SANITIZE_STRING);
        $etiquetas = filter_var(substr($datapost['Etiquetas'], 0, 50), FILTER_SANITIZE_STRING);
        $tarjetas = filter_var(substr($datapost['Tarjetas'], 0, 50), FILTER_SANITIZE_STRING);
        $valorPracticaMinima = filter_var(substr($datapost['ValorPracticaMinima'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $extraccionDomicilio = filter_var(substr($datapost['ExtraccionDomicilio'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $actoProfesionalBioquimico = filter_var(substr($datapost['ActoProfesionalBioquimico'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $valorMontoMaximo = filter_var(substr($datapost['ValorMontoMaximo'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $numeradorDerivaciones = filter_var(substr($datapost['NumeradorDerivaciones'], 0, 11), FILTER_SANITIZE_NUMBER_INT);
        $seccionFormulaHemograma = filter_var(substr($datapost['SeccionFormulaHemograma'], 0, 50), FILTER_SANITIZE_STRING);
        $posicionSeccion = filter_var(substr($datapost['PosicionSeccion'], 0, 50), FILTER_SANITIZE_STRING);
        //$practicasComponentes = filter_var(substr($datapost['PracticasComponentes'], 0, 50), FILTER_SANITIZE_STRING);
        $decodificarNemotecnicos = filter_var(substr($datapost['DecodificarNemotecnicos'], 0, 1), FILTER_SANITIZE_NUMBER_INT);
        $creadoPor = filter_var(substr($datapost['CreadoPor'], 0, 50), FILTER_SANITIZE_STRING);

        if (!$app->pdo->ExisteSeccion($seccionFormulaHemograma)) 
        {
            $response["error"] = TRUE;
            $response["data"] = "La sección no existe";
            echoResponse2(200, $reponse, 'Actualizar Valores Unidades En Uso. Error: la sección no existe');
            $app->stop();
        }

        if ($app->pdo->ExisteValoresUnidades(1)) 
        {
            $result = $app->pdo->ModificarValoresUnidades(array($numeroUsoArranque, $valorFabaA, $valorFabaB, $valorFabaC, $valorNbuAF, $valorNbuBF, $pmo, $uGastos, $uHonorarios, $recibos, $etiquetas, $tarjetas, $valorPracticaMinima, $extraccionDomicilio, $actoProfesionalBioquimico, $valorMontoMaximo, $numeradorDerivaciones, $seccionFormulaHemograma, $posicionSeccion, /*$practicasComponentes,*/ $decodificarNemotecnicos, $creadoPor));   
        }
        else
        {
            $result = $app->pdo->CrearValoresUnidades(array($numeroUsoArranque, $valorFabaA, $valorFabaB, $valorFabaC, $valorNbuAF, $valorNbuBF, $pmo, $uGastos, $uHonorarios, $recibos, $etiquetas, $tarjetas, $valorPracticaMinima, $extraccionDomicilio, $actoProfesionalBioquimico, $valorMontoMaximo, $numeradorDerivaciones, $seccionFormulaHemograma, $posicionSeccion, /*$practicasComponentes,*/ $decodificarNemotecnicos, $creadoPor));   
        }

        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $result;
            echoResponse2(200, $response, 'Actualizar Valores Unidades En Uso. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "Los valores no se pudieron actualizar";
            echoResponse2(400, $response, 'Actualizar Valores Uniades En Uso. Error: los valores no se actualizaron');
        }
    });

    /**
    * Obtiene los datos del registro de valores de unidades en uso
    *
    * @return En caso de éxito, devuelve error en False y en data los datos del registro de valores de unidades en uso y, 
    *         si falla devuelve error en True y en data el mensaje de error.
    */
    $app->get('/', function() use($app){
        $response = array();

        $selectStatement = $app->pdo->select(array('valU.NumeroUsoArranque', 'valU.ValorFABAA', 'valU.ValorFABAB', 'valU.ValorFABAC', 'valU.ValorNBUAltaFrec', 'valU.ValorNBUBajaFrec', 'valU.PMO', 'valU.UGastos', 'valU.UHonorarios', 'valU.Recibos', 'valU.Etiquetas', 'valU.Tarjetas', 'valU.ValorPracticaMinima', 'valU.ExtraccionDomicilio', 'valU.ActoProfesionalBioquimico', 'valU.ValorMontoMaximo', 'valU.NumeradorDerivaciones', 'valU.SeccionFormulaHemograma', 'valU.PosicionSeccion', 'sec.Codigo as CodSeccion', 'sec.Nombre as NombreSeccion',/*'PracticasComponentes',*/ 'valU.DecodificarNemotecnicos'))
                                    ->from('ValoresUnidades valU')
                                    ->join('Secciones sec', 'valU.SeccionFormulaHemograma', '=', 'sec.Id', 'LEFT')
                                    ->limit(1);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Valores Unidades En Uso. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Valores Unidades En Uso. Error: no se encontraron datos');
        }
    });
});

$app->group('/planillas', function() use($app){

    $app->post('/obtenernumeros', 'Autenticar', function() use($app){
        verifyRequiredParams(array("Num_Actual"));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $numero = filter_var(substr($datapost['Num_Actual'], 0, 5), FILTER_SANITIZE_NUMBER_INT);

        $selectStatement = $app->pdo->select(array())
                                    ->from('Ingresos ing')
                                    ->where('ing.EstaBorrado', '=', (int) 0)
                                    ->whereLike('ing.NumPaciente', '%'.$numero.'%')
                                    ->orderby('ing.NumPaciente');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["Primero"] = $data[0];
            $response["Ultimo"] = $data[count($data) - 1];
            echoResponse2(200, $response, 'Get NumPaciente Planillas. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Get NumPaciente Planillas. Error: no se encontraron datos');
        }
    });

    $app->get('/secciones', function() use($app){
        $selectStatement = $app->pdo->select(array('sec.Id', 'sec.Codigo', 'sec.Nombre', 'sec.Determinacion1', 'sec.Determinacion2', 'sec.Determinacion3', 'sec.Determinacion4', 'sec.Determinacion5', 'sec.Determinacion6', 'sec.Determinacion7', 'sec.Determinacion8', 'sec.Determinacion9', 'sec.Determinacion10', 'sec.Determinacion11', 'sec.Determinacion12', 'sec.Determinacion13', 'sec.Determinacion14', 'sec.Determinacion15', 'sec.Determinacion16', 'sec.Determinacion17', 'sec.Determinacion18', 'sec.Determinacion19', 'sec.Determinacion20', 'sec.Determinacion21', 'sec.Determinacion22', 'sec.Determinacion23', 'sec.Determinacion24'))
                                    ->from('Secciones sec')
                                    ->where('sec.EstaBorrado', '=', (int) 0);
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["Primera"] = $data[0];
            $response["Ultima"] = $data[count($data) - 1];
            echoResponse2(200, $response, 'Get Secciones Planillas. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Get Secciones Planillas. Error: no se encontraron datos');
        }
    });

    $app->post('/ingresospendientes', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumDesde', 'NumHasta', 'SeccionDesde', 'SeccionHasta', 'Origen'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $numdesde = filter_var(substr($datapost['NumDesde'], 0, 8), FILTER_SANITIZE_NUMBER_INT);
        $numhasta = filter_var(substr($datapost['NumHasta'], 0, 8), FILTER_SANITIZE_NUMBER_INT);
        $secciondesde = filter_var(substr($datapost['SeccionDesde'], 0, 2), FILTER_SANITIZE_STRING);
        $seccionhasta = filter_var(substr($datapost['SeccionHasta'], 0, 2), FILTER_SANITIZE_STRING);
        $origen = filter_var(substr($datapost['Origen'], 0, 1), FILTER_SANITIZE_STRING);

        $selectStatement = $app->pdo->select(array('sec.Id', 'sec.Codigo', 'sec.Nombre'))
                                    ->from('Secciones sec')
                                    ->where('sec.EstaBorrado', '=', (int) 0)
                                    ->where('sec.Codigo', '>=', $secciondesde)
                                    ->where('sec.Codigo', '<=', $seccionhasta)
                                    ->orderby('sec.Codigo');
        $stmt = $selectStatement->execute();
        $secciones = $stmt->fetchAll();

        for ($i = 0; $i < count($secciones); $i++) 
        { 
            $selectStatement = $app->pdo->select(array('sp.Id', 'sp.SeccionId', 'sp.PracticaId'))
                                        ->from('SeccionesPracticas sp')
                                        ->where('sp.EstaBorrado', '=', (int) 0)
                                        ->where('sp.SeccionId', '=', $secciones[$i]['Id']);
            $stmt = $selectStatement->execute();
            $seccionesP = $stmt->fetchAll();

            if ($seccionesP) 
            {
                $secciones[$i]['seccionespracticas'] = $seccionesP;   
            }
            else
            {
                $secciones[$i]['seccionespracticas'] = null;
            }
        }

        if ($secciones) 
        {
            $response["error"] = FALSE;
            $response["data"] = $secciones;
            echoResponse2(200, $response, 'Planilla Por Secciones. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "no se encontraron datos";
            echoResponse2(200, $response, 'Planilla Por Secciones. Error: no se encontraron datos');
        }
    });

    $app->post('/ingresosnormales', 'Autenticar', function() use($app){
    });

    $app->post('/porpaciente', 'Autenticar', function() use($app){
        verifyRequiredParams(array('NumDesde', 'NumHasta'));
        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $numdesde = filter_var(substr($datapost['NumDesde'], 0, 8), FILTER_SANITIZE_NUMBER_INT);
        $numhasta = filter_var(substr($datapost['NumHasta'], 0, 8), FILTER_SANITIZE_NUMBER_INT);        

        $selectStatement = $app->pdo->select(array('ing.Id', 'ing.NumPaciente', 'ing.PacienteId', 'pac.ApellidoNombre', 'pac.FechaNacimiento', 'pac.Sexo', 'med.Apellido as ApellidoMed', 'med.Nombre as NombreMed'))
                                    ->from('Ingresos ing')
                                    ->join('Pacientes pac', 'ing.PacienteId', '=', 'pac.Id', 'INNER')
                                    ->join('Medicos med', 'pac.MatriculaMedico', '=', 'med.Id', 'LEFT')
                                    ->leftJoin('Resultados res', 'ing.Id', '=', 'res.IngresoId')
                                    ->where('ing.EstaBorrado', '=', (int) 0)
                                    ->where('ing.NumPaciente', '>=', $numdesde)
                                    ->where('ing.NumPaciente', '<=', $numhasta)
                                    ->groupby('ing.Id');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if (count($data) > 0) 
        {
            for ($i = 0; $i < count($data); $i++) 
            { 
                $selectStatement = $app->pdo->select(array('ingp.Id as IngresoPracticaId', 'ingp.NomencladorId', 'pr.Codigo', 'pr.Nombre', 'pr.EsNomencladorTrabajo'))
                                            ->from('IngresosPracticas ingp')
                                            ->join('Practicas pr', 'ingp.NomencladorId', '=', 'pr.Id')
                                            ->where('ingp.IngresoId', '=', $data[$i]['Id'])
                                            ->where('ingp.EstaBorrado', '=', (int) 0)
                                            ->groupby('pr.NomencladorId');
                $stmt = $selectStatement->execute();
                $ingresosP = $stmt->fetchAll();

                if ($ingresosP) 
                {
                    $data[$i]['IngresosPractica'] = $ingresosP;
                }
                else
                {
                    $data[$i]['IngresosPractica'] = null;
                }
            }
        }

        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            echoResponse2(200, $response, 'Get Ingresos Pendientes Planillas. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "No se encontraron datos";
            echoResponse2(200, $response, 'Get Ingresos Pendientes Planillas. Error: no se encontraron datos');
        }
    });

    $app->post('/protocoloUnoUno', 'Autenticar', function() use($app){
        VerificarParametrosRequeridos(array('IngresoId'));

        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $ingresoId = filter_var(substr($datapost['IngresoId'], 0, 8), FILTER_SANITIZE_NUMBER_INT);

        
        $selectStatement = $app->pdo->select(array('res.Resultado',
                                                   'tit.Codigo',
                                                   'tit.Descripcion',
                                                   'tit.ValorMinimo',
                                                   'tit.ValorMaximo'))
                                    ->from('Resultados res')
                                    ->leftJoin('Nomencladores nomen', 'res.NomencladorId', '=', 'nomen.Id')
                                    ->leftJoin('Titulos tit', 'nomen.Codigo', '=', 'tit.Codigo')
                                    ->where('res.EstaBorrado', '=', (int) 0)
                                    ->where('nomen.EstaBorrado', '=', (int) 0)
                                    ->where('tit.EstaBorrado', '=', (int) 0)
                                    ->where('res.IngresoId', '=', $ingresoId);
        
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();


        if ($data) 
        {
            $response["error"] = FALSE;
            $response["data"] = $data;
            GenerarRespuesta(200, $response, 'Generar Protocolos Uno a Uno. Correcto');
        }
        else
        {
            $response["error"] = TRUE;
            $response["data"] = "A ocurrido un error al intentar generar el protocolo individual.";
            GenerarRespuesta(200, $response, 'Generar Protocolos Uno a Uno. Error.');
        }
    });    
});

$app->group('/controlador', function() use($app){

    /**
    * Crea un nomenclador especial nuevo
    *
    * @param $MutualId -> int
    *        $A -> string
    *        $Nombre -> string
    *        $Codigo -> string
    *        $UnidadGasto -> decimal
    *        $UnidadHonorario -> decimal
    *        Nivel -> decimal
    *        $CreadoPor -> string
    *
    * @return Devuelve, en caso de éxito, error en False y en data el Id del nomenclador especial creado y, si falla,
    *         error en True y en data el mensaje de error.
    */
    $app->post('/porCodigo', 'Autenticar', function() use($app){
        verifyRequiredParams(array('Codigo'));

        $json = $app->request->getBody();
        $datapost = json_decode($json, TRUE);
        $response = array();

        $codigo = filter_var(substr($datapost['Codigo'], 0, 10), FILTER_SANITIZE_STRING);
              
        $selectStatement = $app->pdo->select(array(
                                                   'cont.Id',
                                                   'cont.Codigo',
                                                   'cont.Nombre',
                                                   'cont.Apellido',
                                                   'cont.Firma'))
                                        ->from('Controladores cont')
                                        ->whereLike('cont.Codigo', '%'.$codigo.'%')
                                        ->where('cont.EstaBorrado', '=', (int) 0);

        $result = $selectStatement->execute();

        $controladores = $result->fetchAll();

        if ($result) 
        {
            $response["error"] = FALSE;
            $response["data"] = $controladores;
            $response["cantidad"] = count($controladores);
            echoResponse2(200, $response, 'Buscar controlador por código. Correcto');            
        }
        else
        {
            $response["error"] = TRUE;
            $response["mensajeError"] = "El controlador no existe";
            $response["data"] = $controladores;
            echoResponse2(400, $response, 'Buscar controlador por código. Incorrecto');
        }
    });
});    

// FUNCIONES COMUNES  
/** 
* Función para mostrar la respuesta mas el código header
*
* @param $status_code int
*        $response array(error, data)
*/
function echoResponse($status_code = 200, $response) {
    $app = \Slim\Slim::getInstance();
    // Mandamos los headers
    $app->status($status_code);
    // Convertimos la respuesta en JSON
    $app->contentType('application/json');
    // Muestra la respuesta codificada en JSON

    echo json_encode($response);
}

/** 
* Función para mostrar la respuesta mas el código header
*
* @param $status_code int
*        $response array(error, data)
*/
function echoResponse2($status_code = 200, $response, $origin) {
    $app = \Slim\Slim::getInstance();
    // Mandamos los headers
    $app->status($status_code);
    // Convertimos la respuesta en JSON
    $app->contentType('application/json');

    if ($_SERVER['HTTP_HOST'] == 'localhost') 
    {
        if (!isset($_SESSION['Id'])) 
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaLocalhost(array($response['Id'], $origin));
        }
        else
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaLocalHost(array($_SESSION['Id'], $origin));
        }
    }
    else
    {
        if (!isset($_SESSION['Id'])) 
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaOnline(array($response['Id'], $origin));
        }
        else
        {
            //Creo registro de auditoría
            $app->pdo->CrearAuditoriaOnline(array($_SESSION['Id'], $origin));
        }
    }
    
    
    // Muestra la respuesta codificada en JSON    
    echo json_encode($response);
}

/** 
* Función para verificar que los parámetros requeridos, según la función que llama, no esten vacíos o nulos
*
* @param $required_fields array
*
* @return Retorna, en caso de error, error en true y un mensaje especificando qué campos están vacíos o nulos.
*/
function verifyRequiredParams($required_fields) {
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
* Función para verificar que el formato del email es el correcto
*
* @param $email -> string
*
* @return Retorna, en caso de éxito, un true para formato correcto y, si falla,
*         false para formato incorrecto de email.
*/
function checkEmail($email) {
    //verifica el correcto formato de un email
    if (!filter_var(substr($email, 0, 100), FILTER_VALIDATE_EMAIL)) 
    {
        return FALSE;
    }
    return TRUE;
}

/** 
* Función para generar el siguiente numero de paciente
*
* @return Retorna el numero de paciente el proximo paciente a ingresar
*/
function GenerarNumeroPaciente(){
    $ano = date('Y');
    $ano = substr($ano, -1);
    $mes = date('m');
    $dia = date('d');

    //obtiene el mayor número de paciente
    $numUltimoPaciente = ObtenerUltimoPaciente();
    
    //verifica que exista al menos un número de paciente
    if ($numUltimoPaciente[0][0]) 
    {    
        //rescata y particiona el mayor número de paciente    
        $anoUltimo = substr($numUltimoPaciente[0][0], 0, 1);
        $mesUltimo = substr($numUltimoPaciente[0][0], 1, 2);
        $diaUltimo = substr($numUltimoPaciente[0][0], 3, 2);
        $numUltimo = substr($numUltimoPaciente[0][0], -3);
        
        if ($anoUltimo != $ano) //si el año actual es distinto del año del mayor NumPaciente -> cambio de año
        {
            $NumPaciente = $ano;
        }
        else //si son iguales -> no cambia de año
        {
            $NumPaciente = $anoUltimo;
        }
        
        if ($mesUltimo != $mes) //si el mes actual es distinto del mes del mayor NumPaciente -> cambio de mes
        {
            $NumPaciente = $NumPaciente . $mes;
        }
        else //si son iguales -> no cambia de mes
        {
            $NumPaciente = $NumPaciente . $mesUltimo;
        }
        
        if ($diaUltimo != $dia) //si el dia actual es distinto del dia del mayor NumPaciente -> cambio de dia
        {
            $NumPaciente = $NumPaciente . $dia . '001';
        }
        else //si son iguales -> no cambia de dia y calcula el siguiente NumPaciente
        {            
            $numUltimo = (int)$numUltimo + 1;
            switch (strlen($numUltimo)) //una vez calculado el NumPaciente, según su largo, completa con los 0 que falten
            {
                case 1:
                    $numUltimo = '00' . $numUltimo;
                    break;
                case 2:
                    $numUltimo = '0' . $numUltimo;
                    break;                    
            }
            //completa el formato del NumPaciente
            $NumPaciente = $NumPaciente . $diaUltimo . $numUltimo;
        }
    }
    else
    {
        $NumPaciente = $ano . $mes . $dia . '001';
    }
    //retorna el valor obtenido
    return $NumPaciente;
}

/** 
* Obtiene el mayor número de paciente.
*
* @return Retorna el mayor número de paciente y false si no encuentra pacientes.
*/
function ObtenerUltimoPaciente(){
    $query = "SELECT max(NumPaciente) FROM Ingresos";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();    
    $data = $stmt->fetchAll();
    
    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function IngresosPractica($ingresos)
{
    $ingresoId = $ingresos[0]['IngresoId'];

    $query = "SELECT ingp.Id as IngresoPracticaId, 
                     ingp.IngresoId as IngresoId,
                     ingp.NomencladorId, 
                     pr.Id as PracticaId, 
                     pr.Codigo as PracticaCodigo, 
                     pr.Nombre as PracticaNombre, 
                     pr.EsNomencladorTrabajo,
                     tit.Codigo as CodTitulo, 
                     tit.Descripcion as TitDescrip, 
                     tit.Tipo as TitTipo, 
                     tit.Unidades as TitUnidades, 
                     tit.Rango as TitRango, 
                     tit.LineaTexto1, 
                     tit.LineaTexto2, 
                     tit.LineaTexto3, 
                     tit.LineaTexto4, 
                     tit.ValoresReferenciaAmpliados, 
                     tit.ValorMinimo, 
                     tit.ValorMaximo,
                     res.Resultado,
                     res.EstaEmitido
                FROM  IngresosPracticas ingp
                LEFT JOIN Resultados res ON ingp.NomencladorId = res.NomencladorId
                LEFT JOIN Practicas pr ON ingp.NomencladorId = pr.Id
                LEFT JOIN Titulos tit  ON pr.Codigo = tit.Codigo
                WHERE (ingp.IngresoId = $ingresoId
                       AND ingp.EstaBorrado = 0)";

    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

/** 
* Checkea los pacientes asociados que tiene una mutual
*
* @param $id -> int
*
* @return Retorna True si la mutual tiene al menos un paciente asociado, y False si no tiene ninguno.
*/
function CheckearAsocMutPac($id){
    $query = "SELECT Id FROM Pacientes WHERE EstaBorrado = 0 AND (Mutual1 = $id OR Mutual2 = $id)";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    if ($data) 
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

/** 
* Checkea las practicas asociadas que tiene una mutual
*
* @param $id -> int
*
* @return Retorna True si la mutual tiene al menos una practica asociada, y False si no tiene ninguna.
*/
function CheckearAsocMutPrac($id){
    $query = "SELECT Id FROM Practicas WHERE EstaBorrado = 0 AND (MutualId = $id)";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();
    
    if ($data) 
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

/** 
* Checkea los pacientes asociados que tiene un médico
*
* @param $id -> int
*
* @return Retorna True si el médico tiene al menos un paciente asociado, y False si no tiene ninguno.
*/
function CheckearAsocMedPac($id){
    $query = "SELECT Id FROM Pacientes WHERE EstaBorrado = 0 AND MatriculaMedico = $id";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

/** 
* Obtiene los datos de todos los pacientes con DNI distinto de NULL
*
* @return Retorna en caso de éxito, los datos de los pacientes con DNI distinto de NULL y, si falla,
*         devuelve un FALSE.
*/
function PacientesConDNI(){
    $query = "SELECT Id, ApellidoNombre, FechaNacimiento, Sexo, Origen, Cuenta, Direccion, NumDocumento, Telefono, Celular, Lugar, Mail, MatriculaMedico, Mutual1, DebeOrden1, NumAfiliado1, TipoAfiliado1, Mutual2, DebeOrden2, NumAfiliado2, TipoAfiliado2, Factor, ActoProf FROM Pacientes WHERE NumDocumento IS NOT NULL AND EstaBorrado = 0";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function MedicosPorMatricula($mat){
    $query = "SELECT med.Id, med.Nombre, med.Apellido, med.Matricula, med.TipoMatricula, med.Domicilio1, med.Telefono1, med.Domicilio2, med.Telefono2 FROM Medicos med WHERE med.EstaBorrado = 0 AND CAST(med.Matricula AS CHAR) LIKE '%$mat%'";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function PacientesPorDocumento($doc){
    $query = "SELECT pac.Id, pac.ApellidoNombre, pac.FechaNacimiento, pac.Sexo, pac.Origen, pac.Cuenta, pac.Direccion, pac.NumDocumento, pac.Telefono, pac.Celular, pac.Lugar, pac.Mail,/* med.Id, med.Matricula, med.Apellido as ApellidoMed, med.Nombre as NombreMed,*/ mut1.Id as Mutual1Id, mut1.Codigo as CodMutual1, mut1.Nombre as NombreMutual1, mut1.PorcCobertura as PorcCobertura1, pac.DebeOrden1, pac.NumAfiliado1, pac.TipoAfiliado1, mut2.Id as Mutual2Id, mut2.Codigo as CodMutual2, mut2.Nombre as NombreMutual2, mut2.PorcCobertura as PorcCobertura2, pac.DebeOrden2, pac.NumAfiliado2, pac.TipoAfiliado2, pac.Factor, pac.ActoProf, ing.Cama
              FROM Pacientes pac
              LEFT JOIN Mutuales mut1 ON pac.Mutual1 = mut1.Id
              LEFT JOIN Mutuales mut2 ON pac.Mutual2 = mut2.Id
              LEFT JOIN Ingresos ing ON pac.Id = ing.PacienteId
              WHERE CAST(pac.NumDocumento AS CHAR) LIKE '%$doc%'";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

/** 
* Obtiene el registro de configuracion del sistema existente para extraer la ruta del logo del laboratorio
*
* @return Retorna en caso de éxito, la ruta del logo del laboratorio y, si falla,
*         devuelve FALSE.
*/
function ObtenerConfigSis($idUsuario)
{
    $query = "SELECT * FROM ConfiguracionesSistema conf WHERE IdUsuario = $idUsuario";

    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data[0];
    }
    else
    {
        return FALSE;
    }
}

/**
* Función para obtener los nomencladores de trabajo, mas los nomencladores especiales asociados a una mutual, identificada
* por su Id ingresado.
*
* @param $id_mutual -> int
*
* @return Devuelve, en caso de éxito, los nomencladores de trabajo existentes, mas los nomencladores especiales asociados
*         a la mutual de la cual se ingresó el Id.
*/
function GetPracticasPorMutual($id_mutual){ //ToDo para hacer sp
    if ($id_mutual) 
    {
        $query = "SELECT nom.Id AS 'NomencladorId', nom.Codigo AS 'NomencladorCodigo', nom.Nombre AS 'NomencladorNombre', pr.Id AS 'PracticaId', pr.Codigo AS 'PracticaCodigo', pr.Nombre AS 'PracticaNombre', pr.MutualId as 'MutualId'
                  FROM Nomenclador nom
                  INNER JOIN Practicas pr ON nom.Codigo = pr.Nombre
                  WHERE pr.MutualId = $id_mutual AND pr.EstaBorrado = 0 AND nom.EstaBorrado = 0
                  UNION
                  SELECT nom.Id AS 'NomencladorId', nom.Codigo AS 'NomencladorCodigo', nom.Nombre AS 'NomencladorNombre', NULL AS 'PracticaId', NULL AS 'PracticaCodigo', NULL AS 'PracticaNombre', NULL as 'MutualId'
                  FROM Nomenclador nom                  
                  WHERE nom.EstaBorrado = 0";

        $db = getConnection();

        $stmt = $db->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll();

        if ($data) 
        {
            return $data;
        }
        else
        {
            return FALSE;
        }
    }
}

function GetIngresosSinResultados(){
    $query = "SELECT ing.Id, ing.PacienteId, ingp.Id, ingp.NomencladorId, res.Id, res.IngresoId
              FROM Ingresos ing
              INNER JOIN IngresosPracticas ingp ON ing.Id = ingp.IngresoId
              LEFT OUTER JOIN Resultados res ON ing.Id = res.IngresoId";

    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function GetResultadosPorDoc($doc){
    $query = "SELECT res.Id as ResultadoId, res.IngresoId as IngresoId, res.NomencladorId, res.Resultado, ing.PacienteId, ing.NumPaciente, pac.ApellidoNombre, pac.FechaNacimiento, pac.Sexo, pac.Origen, med.Id, med.Matricula, med.Apellido as ApellidoMed, med.Nombre as NombreMed
              FROM Resultados res
              INNER JOIN Ingresos ing ON res.IngresoId = ing.Id
              INNER JOIN Pacientes pac ON ing.PacienteId = pac.Id
              LEFT JOIN Medicos med ON pac.MatriculaMedico = med.Id
              WHERE pac.NumDocumento LIKE '%$doc%' AND res.EstaBorrado = 0";

    $db = getConnection();
    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function GetNomencladoresEspeciales($id, $nombre){   
    if ($id !== '') 
    {
        //obtengo los nomencladores especiales que coincidan con los criterios de búsqueda
        $query = "SELECT p.Id as 'PracticaId', p.NomencladorId, p.Codigo as 'NomEspCodigo', p.Nombre as 'NomEspNombre', p.EsNomencladorTrabajo, ne.UnidadGasto, ne.UnidadHonorario, ne.A as 'Categoria', ne.Nivel, mut.Id as 'MutualId', mut.INOSReducido, mut.ValorA, mut.ValorB, mut.ValorC, mut.ValorNBU, mut.CoeficienteUGastos, mut.CoeficienteUHono
                  FROM NomencladoresEspeciales ne
                  INNER JOIN Practicas p ON ne.Id = p.NomencladorId
                  INNER JOIN Mutuales mut ON ne.MutualId = mut.Id
                  WHERE (p.EsNomencladorTrabajo = 0) AND (ne.MutualId = $id) AND (p.Codigo LIKE '%$nombre%' OR p.Nombre LIKE '%$nombre%')";
        $db = getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute();
        $nomencladoresespeciales = $stmt->fetchAll();
    }
    else
    {   //si el Id de mutual viene vacío, no hay nomencladores especiales posibles
        $nomencladoresespeciales = NULL;
    }

    //obtengo los nomencladores de trabajo que coincidan con los criterios de búsqueda
    $query = "SELECT p.Id as 'PracticaId', p.NomencladorId, p.Codigo as 'NomencladorCodigo', p.Nombre as 'NomencladorNombre', p.EsNomencladorTrabajo, nom.UGastos, nom.UHonorarios
              FROM Nomencladores nom
              INNER JOIN Practicas p ON nom.Id = p.NomencladorId
              WHERE (p.EsNomencladorTrabajo = 1) AND (p.Codigo LIKE '%$nombre%' OR p.Nombre LIKE '%$nombre%')
              GROUP BY p.NomencladorId";
    $db = getConnection();
    $stmt = $db->prepare($query);
    $stmt->execute();
    $nomencladores = $stmt->fetchAll();

    //obtengo el registro de valores de unidades del sistema
    $query = "SELECT valU.ValorFABAA, valU.ValorFABAB, valU.ValorFABAC, valU.ValorNBUAltaFrec, valU.ValorNBUBajaFrec, valU.UGastos, valU.UHonorarios, valU.ValorPracticaMinima, valU.ActoProfesionalBioquimico, valU.ValorMontoMaximo
              FROM ValoresUnidades valU
              WHERE valU.EstaBorrado = 0";
    $db = getConnection();
    $stmt = $db->prepare($query);
    $stmt->execute();
    $valores = $stmt->fetchAll();

    $data = array();

    $data['NomencladoresEspeciales'] = $nomencladoresespeciales;
    $data['Nomencladores'] = $nomencladores;
    $data['Valores'] = $valores;

    if(($data['NomencladoresEspeciales'] || $data['Nomencladores']) && $data['Valores'])
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function GetIngresosTotal(){
    $query = "SELECT COUNT(ing.Id) as Total From Ingresos ing WHERE ing.EstaBorrado = 0";
    $db = getConnection();

    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll();

    if ($data) 
    {
        return $data;
    }
    else
    {
        return FALSE;
    }
}

function getConnection() 
{
    $dbhost="localhost";
    $dbuser="entityst_user";
    $dbpass="JJlab2017";    
    $dbname="entityst_jjlab";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

*/

$app->run();