<?php

require dirname(dirname(__FILE__)) .'/vendor/autoload.php';

function CrearUsuario()
{
    VerificarParametrosRequeridos(array('NombreUsuario',
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
        GenerarRespuesta(200, $response, 'Crear Usuario. Correcto');
    } 
    else 
    {
        $response["error"] = TRUE;
        $response["data"] = "Usuario No Creado";
        GenerarRespuesta(400, $response, 'Crear Usuario. Error: el usuario no se creó');
    }
}

function ObtenerUsuarioLogueado()
{
    $app = \Slim\Slim::getInstance();

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
                                ->where('usu.Id', '=', $_SESSION["UsuarioId"])
                                ->where('usu.EstaBorrado', '=', (int) 0);

    $response = array();
    
    $stmt = $selectStatement->execute();
    $data = $stmt->fetchAll();
    
    if ($data) 
    {
        $response["error"] = FALSE;
        $response["data"] = $data;
        GenerarRespuesta(200, $response, 'Get Usuarios Id. Correcto');
    } 
    else 
    {
        $response["error"] = TRUE;
        $response["data"] = "No se han econtrado datos";
        GenerarRespuesta(200, $response, 'Get Usuarios Id. Error: no se encontraron datos');
    }
}

function IniciarSesion()
{
    $app = \Slim\Slim::getInstance();
    VerificarParametrosRequeridos(array('NombreUsuario', 'Contrasena'));

    $json = $app->request->getBody();
    $datapost = json_decode($json, TRUE);

    $nombreUsuario  = filter_var(substr($datapost['NombreUsuario'], 0, 50), FILTER_SANITIZE_STRING);
    $contrasena     = filter_var(substr($datapost['Contrasena'], 0, 50),    FILTER_SANITIZE_STRING);
    
    //checkea los datos de login del usuario que intenta ingresar
    $data = $app->pdo->ChequearLogin(array($nombreUsuario, $contrasena));

    if ($data) 
    {
        $response["error"]    = FALSE;
        $response["data"]     = $data;
        $response["Id"]       = $data['Id'];
        
        // Seteo las variables de sesión del id del usuario logueado con éxito
        $_SESSION["UsuarioId"] = $data["Id"];
        $_SESSION["NombreUsuario"] = $data["NombreUsuario"];
       
        GenerarRespuesta(200, $response, 'Log In. Correcto');
    }
    else 
    {
        $response["error"] = TRUE;        
        $response["data"] = "Login incorrecto";
        GenerarRespuesta(401, $response, 'Log In. Error: datos incorrectos');
    }
}

?>