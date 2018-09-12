<?php
class DbConnect extends \Slim\PDO\Database {

    protected $_dsn = 'mysql:host=localhost;dbname=entity6_lab;charset=utf8';
    protected $_usr = 'entity6_lab';
    protected $_pwd = 'LVmqtbMYW@!!';

    /** 
    * Constructor para la conexion con la base de datos
    */
    public function __construct() {

        parent::__construct($this->_dsn, $this->_usr, $this->_pwd);
    }

    /**
    * Función para agregar un registro de auditoría conectado desde localhost
    *
    * @param $params array(UsuarioId, Operacion, $_SERVER(GATEWAY_INTERFACE, SERVER_ADDR, SERVER_NAME, SERVER_SOFTWARE, 
    *                      SERVER_PROTOCOL, REQUEST_METHOD, REQUEST_TIME, REQUEST_TIME_FLOAT, QUERY_STRING, DOCUMENT_ROOT, 
    *                      HTTP_ACCEPT_ENCODING, HTTP_ACCEPT_LANGUAGE, HTTP_CONNECTION, 
    *                      HTTP_HOST, REMOTE_PORT, SCRIPT_FILENAME, SERVER_ADMIN, SERVER_PORT,
    *                      SERVER_SIGNATURE, SCRIPT_NAME, REQUEST_URI))
    *
    * @return Retorna, en caso de éxito, el Id del registro de auditoría creado y false si falla.
    */
    public function CrearAuditoriaLocalHost($params){
        if (is_array($params))
        {
            $insertStatement = $this->insert(array('UsuarioId', 
                                                   'Operacion', 
                                                   'GATEWAY_INTERFACE', 
                                                   'SERVER_ADDR', 
                                                   'SERVER_NAME', 
                                                   'SERVER_SOFTWARE', 
                                                   'SERVER_PROTOCOL', 
                                                   'REQUEST_METHOD', 
                                                   'REQUEST_TIME', 
                                                   'REQUEST_TIME_FLOAT', 
                                                   'QUERY_STRING', 
                                                   'DOCUMENT_ROOT',                                                    
                                                   'HTTP_ACCEPT_ENCODING', 
                                                   'HTTP_ACCEPT_LANGUAGE',
                                                   'HTTP_CONNECTION', 
                                                   'HTTP_HOST', 
                                                   'HTTP_REFERER', 
                                                   'HTTP_USER_AGENT',                                                    
                                                   'REMOTE_ADDR',                                                    
                                                   'REMOTE_PORT',                                                    
                                                   'SCRIPT_FILENAME', 
                                                   'SERVER_ADMIN', 
                                                   'SERVER_PORT', 
                                                   'SERVER_SIGNATURE', 
                                                   'SCRIPT_NAME', 
                                                   'REQUEST_URI',                                                    
                                                   'CreadoFecha'))
                                    ->into('Auditorias')
                                    ->values(array($params[0], 
                                                   $params[1], 
                                                   $_SERVER['GATEWAY_INTERFACE'], 
                                                   $_SERVER['SERVER_ADDR'], 
                                                   $_SERVER['SERVER_NAME'], 
                                                   $_SERVER['SERVER_SOFTWARE'], 
                                                   $_SERVER['SERVER_PROTOCOL'], 
                                                   $_SERVER['REQUEST_METHOD'],
                                                   $_SERVER['REQUEST_TIME'], 
                                                   $_SERVER['REQUEST_TIME_FLOAT'], 
                                                   $_SERVER['QUERY_STRING'], 
                                                   $_SERVER['DOCUMENT_ROOT'],                                                    
                                                   $_SERVER['HTTP_ACCEPT_ENCODING'], 
                                                   $_SERVER['HTTP_ACCEPT_LANGUAGE'], 
                                                   $_SERVER['HTTP_CONNECTION'], 
                                                   $_SERVER['HTTP_HOST'], 
                                                   $_SERVER['HTTP_REFERER'], 
                                                   $_SERVER['HTTP_USER_AGENT'], 
                                                   $_SERVER['REMOTE_ADDR'], 
                                                   $_SERVER['REMOTE_PORT'], 
                                                   $_SERVER['SCRIPT_FILENAME'], 
                                                   $_SERVER['SERVER_ADMIN'], 
                                                   $_SERVER['SERVER_PORT'], 
                                                   $_SERVER['SERVER_SIGNATURE'], 
                                                   $_SERVER['SCRIPT_NAME'], 
                                                   $_SERVER['REQUEST_URI'], 
                                                   date('Y-m-d H:i:s')));
                                                   
            $insertId = $insertStatement->execute();

            if($insertId)
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para agregar un registro de auditoría conectado online
    *
    * @param $params array(UsuarioId, Operacion, $_SERVER(GATEWAY_INTERFACE, SERVER_ADDR, SERVER_NAME, SERVER_SOFTWARE, 
    *                      SERVER_PROTOCOL, REQUEST_METHOD, REQUEST_TIME, REQUEST_TIME_FLOAT, QUERY_STRING, DOCUMENT_ROOT, 
    *                      HTTP_ACCEPT, HTTP_ACCEPT_CHARSET, HTTP_ACCEPT_ENCODING, HTTP_ACCEPT_LANGUAGE, HTTP_CONNECTION, 
    *                      HTTP_HOST, REMOTE_PORT, REMOTE_USER, REDIRECT_REMOTE_USER, SCRIPT_FILENAME, SERVER_ADMIN, SERVER_PORT,
    *                      SERVER_SIGNATURE, PATH_TRANSLATED, SCRIPT_NAME, REQUEST_URI, PHP_AUTH_DIGEST, PHP_AUTH_USER,
    *                      PHP_AUTH_PW, AUTH_TYPE, PATH_INFO, ORIG_PATH_INFO))
    *
    * @return Retorna, en caso de éxito, el Id del registro de auditoría creado y false si falla.
    */
    public function CrearAuditoriaOnline($params){
        if (is_array($params))
        {
            $insertStatement = $this->insert(array('UsuarioId', 
                                                   'Operacion', 
                                                   'GATEWAY_INTERFACE', 
                                                   'SERVER_ADDR', 
                                                   'SERVER_NAME', 
                                                   'SERVER_SOFTWARE', 
                                                   'SERVER_PROTOCOL', 
                                                   'REQUEST_METHOD', 
                                                   'REQUEST_TIME', 
                                                   'REQUEST_TIME_FLOAT', 
                                                   'QUERY_STRING', 
                                                   'DOCUMENT_ROOT', 
                                                   'HTTP_ACCEPT', 
                                                   'HTTP_ACCEPT_CHARSET',
                                                   'HTTP_ACCEPT_ENCODING', 
                                                   'HTTP_ACCEPT_LANGUAGE',
                                                   'HTTP_CONNECTION', 
                                                   'HTTP_HOST', 
                                                   'HTTP_REFERER', 
                                                   'HTTP_USER_AGENT', 
                                                   'HTTPS', 
                                                   'REMOTE_ADDR', 
                                                   'REMOTE_HOST', 
                                                   'REMOTE_PORT', 
                                                   'REMOTE_USER', 
                                                   'REDIRECT_REMOTE_USER',
                                                   'SCRIPT_FILENAME', 
                                                   'SERVER_ADMIN', 
                                                   'SERVER_PORT', 
                                                   'SERVER_SIGNATURE', 
                                                   'PATH_TRANSLATED', 
                                                   'SCRIPT_NAME', 
                                                   'REQUEST_URI', 
                                                   'PHP_AUTH_DIGEST', 
                                                   'PHP_AUTH_USER',
                                                   'PHP_AUTH_PW', 
                                                   'AUTH_TYPE', 
                                                   'PATH_INFO', 
                                                   'ORIG_PATH_INFO',
                                                   'CreadoFecha'))
                                    ->into('Auditorias')
                                    ->values(array($params[0], 
                                                   $params[1], 
                                                   $_SERVER['GATEWAY_INTERFACE'], 
                                                   $_SERVER['SERVER_ADDR'], 
                                                   $_SERVER['SERVER_NAME'], 
                                                   $_SERVER['SERVER_SOFTWARE'], 
                                                   $_SERVER['SERVER_PROTOCOL'], 
                                                   $_SERVER['REQUEST_METHOD'],
                                                   $_SERVER['REQUEST_TIME'], 
                                                   $_SERVER['REQUEST_TIME_FLOAT'], 
                                                   $_SERVER['QUERY_STRING'], 
                                                   $_SERVER['DOCUMENT_ROOT'], 
                                                   $_SERVER['HTTP_ACCEPT'], 
                                                   $_SERVER['HTTP_ACCEPT_CHARSET'],
                                                   $_SERVER['HTTP_ACCEPT_ENCODING'], 
                                                   $_SERVER['HTTP_ACCEPT_LANGUAGE'], 
                                                   $_SERVER['HTTP_CONNECTION'], 
                                                   $_SERVER['HTTP_HOST'], 
                                                   $_SERVER['HTTP_REFERER'], 
                                                   $_SERVER['HTTP_USER_AGENT'], 
                                                   $_SERVER['HTTPS'], 
                                                   $_SERVER['REMOTE_ADDR'], 
                                                   $_SERVER['REMOTE_HOST'], 
                                                   $_SERVER['REMOTE_PORT'], 
                                                   $_SERVER['REMOTE_USER'], 
                                                   $_SERVER['REDIRECT_REMOTE_USER'],
                                                   $_SERVER['SCRIPT_FILENAME'], 
                                                   $_SERVER['SERVER_ADMIN'], 
                                                   $_SERVER['SERVER_PORT'], 
                                                   $_SERVER['SERVER_SIGNATURE'], 
                                                   $_SERVER['PATH_TRANSLATED'], 
                                                   $_SERVER['SCRIPT_NAME'], 
                                                   $_SERVER['REQUEST_URI'], 
                                                   $_SERVER['PHP_AUTH_DIGEST'], 
                                                   $_SERVER['PHP_AUTH_USER'], 
                                                   $_SERVER['PHP_AUTH_PW'], 
                                                   $_SERVER['AUTH_TYPE'], 
                                                   $_SERVER['PATH_INFO'],
                                                   $_SERVER['ORIG_PATH_INFO'],
                                                   date('Y-m-d H:i:s')));
                                                   
            $insertId = $insertStatement->execute();

            if($insertId)
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para verificar la api key suministrada, se corresponse con un usuario no borrado
    *
    * @param $api_key varchar
    *
    * @return Retorna, en caso de éxito, true para api key correspondiente con un usuario no borrado y, si falla,
    *         false si no se corresponse con ningun usuario.
    */
    public function isValidApiKey($api_key) {

        $selectStatement = $this->select(array('Id','NombreUsuario','Contrasena','Nombre','Apellido','Email','FechaNacimiento','RoleId','CreadoPor','CreadoFecha','ModificadoPor','ModificadoFecha','EstaBorrado','ApiKey'))
                                ->from('Usuarios')
                                ->where('EstaBorrado', '=', (int) 0, 'AND')
                                ->where('ApiKey', '=', $api_key);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

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
    * Función para verificar que los datos de login se corresponden con un usuario existente y no borrado
    *
    * @param $params array(NombreUsuario, Contrasena)
    *
    * @return Retorna, en caso de éxito, un arreglo con los datos del usuario que desea loguearse y, si falla,
    *         false si los datos no se corresponden con ningun usuario.
    */
    public function ChequearLogin($params) {

        $selectStatement = $this->select(array('usu.Id', 
                                               'usu.NombreUsuario', 
                                               'usu.Contrasena', 
                                               'usu.Nombre', 
                                               'usu.Apellido', 
                                               'usu.Email', 
                                               'usu.RoleId', 
                                               'rol.Descripcion', 
                                               'usu.Imagen', 
                                               'usu.ApiKey', 
                                               'conf.ColorEncabezado', 
                                               'conf.ColorEncabezadoCinta', 
                                               'conf.ColorMenuLateral', 
                                               'conf.ColorPiePagina', 
                                               'conf.ColorFondo'))
                                ->from('Usuarios usu')
                                ->join('Roles rol', 'usu.RoleId', '=', 'rol.Id', 'INNER')
                                ->join('Configuraciones conf', 'usu.Id', '=', 'conf.IdUsuario', 'INNER')
                                ->where('usu.Contrasena', '=', md5(sha1($params[1])), 'AND')
                                ->where('usu.NombreUsuario', '=', $params[0], 'AND')
                                ->where('usu.EstaBorrado', '=', (int) 0);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

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
    * Función para verificar que el nombre de usuario existe
    *
    * @param $NombreUsuario -> string
    *
    * @return Retorna True si el nombre de usuario existe y, False si no existe.
    */
    public function CheckearNombreUsuario($nombreUsuario) {
        if ($nombreUsuario) 
        {
            $selectStatement = $this->select(array('usu.Id', 'usu.NombreUsuario'))
                                    ->from('Usuarios usu')
                                    ->where('usu.NombreUsuario', '=', $nombreUsuario)
                                    ->where('usu.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if ($data) 
            {
                return TRUE;
            } 
            else 
            {
                return FALSE;
            }
        }        
    }

    /** 
    * Función para verificar que el email de usuario existe
    *
    * @param $email -> string
    *
    * @return Retorna True si el email de usuario existe y, False si no existe.
    */
    public function CheckearEmailUsuario($email) {
        if ($email) 
        {
            $selectStatement = $this->select(array('usu.Id', 'usu.Email'))
                                    ->from('Usuarios usu')
                                    ->where('usu.Email', '=', $email)
                                    ->where('usu.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if ($data) 
            {
                return TRUE;
            } 
            else 
            {
                return FALSE;
            }
        }        
    }

    /** 
    * Función para verificar el usuario existe según su Id
    *
    * @param $id -> int
    *
    * @return Retorna True si el usuario existe y, False si no existe.
    */
    public function ExisteUsuario($id) {
        if ($id) 
        {
            $selectStatement = $this->select(array('usu.Id', 
                                                   'usu.NombreUsuario', 
                                                   'usu.Nombre', 
                                                   'usu.Apellido', 
                                                   'usu.Email', 
                                                   'usu.Imagen'))
                                    ->from('Usuarios usu')
                                    ->where('usu.Id', '=', $id)
                                    ->where('usu.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

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

    /** 
    * Función para crear un usuario nuevo
    *
    * @param $params array(NombreUsuario, Contrasena, Nombre, Apellido, Email, FechaNacimiento, RoleId, Imagen, CreadoPor)
    *
    * @return Retorna, en caso de éxito, Id del usuario recientemente ingresado y, si falla, 
    *         false en caso de no ingresarlo.
    */
    public function CrearUsuario($params) {

        if (is_array($params)) 
        {            
            $insertStatement = $this->insert(array('NombreUsuario',
                                                   'Contrasena',
                                                   'Nombre',
                                                   'Apellido',
                                                   'Email',
                                                   'FechaNacimiento',
                                                   'RoleId', 
                                                   'Imagen', 
                                                   'CreadoPor',
                                                   'CreadoFecha',
                                                   'EstaBorrado',
                                                   'ApiKey'))
                                    ->into('Usuarios')
                                    ->values(array($params[0],
                                                   md5(sha1($params[1])),
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   date('Y-m-d', strtotime($params[5])),
                                                   $params[6],
                                                   'app/usuarios/imagenes-perfil/'.$params[7],
                                                   $params[8],
                                                   date('Y-m-d H:i:s'),                
                                                   0,
                                                   $this->GenerarApiKey()));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            } 
            else 
            {
                return FALSE;
            }
        }
    }   

    /** 
    * Función para modificar un usuario
    *
    * @param $params array(Id, NombreApellido, Nombre, Apellido, Email, FechaNaciminto, RoleId, Imagen, ModificadoPor)
    *
    * @return Retorna, en caso de éxito, un 1 y, si falla,
    *         false en caso de no modificar el usuario.
    */
    public function ModificarUsuario($params) {

        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('NombreUsuario' => $params[1],
                                                   'Nombre' => $params[2],
                                                   'Apellido' => $params[3],
                                                   'Email' => $params[4],
                                                   'FechaNacimiento' => date('Y-m-d', strtotime($params[5])),
                                                   'RoleId' => $params[6],
                                                   'Imagen' => 'app/usuarios/imagenes-perfil/'.$params[7],
                                                   'ModificadoPor' => $params[8],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Usuarios')                                                                
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Función para eliminar un usuario
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna, en caso de éxito, un 1 y, si falla,
    *         false en caso de no poder eliminar.
    */
    public function EliminarUsuario($params){

        if (is_array($params)) 
        {            
            $updateStatement = $this->update(array('EstaBorrado' => 1,
                                                   'ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Usuarios')
                                    ->where('Id', '=', (int) $params[0]);

            $deleteId = $updateStatement->execute();

            if ($deleteId) 
            {
                return $deleteId;    
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para verificar que un rol existe, por su Id
    *
    * @param $id -> int
    *
    * @return Retorna True si el rol se encuentra y un False si no se encuentra.
    */
    public function ExisteRol($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('rol.Id', 
                                                   'rol.Descripcion'))
                                    ->from('Roles rol')
                                    ->where('rol.Id', '=', $id)
                                    ->where('rol.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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
 
    /** 
    * Funcion para generar una API KEY para los usuarios
    *
    * @return Retorna, un entero conteniendo la Api Key generada.
    */
    protected function GenerarApiKey() {

        return md5(uniqid(rand(), true));
    }

    /** 
    * Funcion para obtener la API KEY de un usuario según su Id
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de éxito, la Api Key correspondiente al Id ingresado y, si falla,
    *         un false para Id no encontrado.
    */
    public function ObtenerApiKey($id) {

        $selectStatement = $this->select(array('ApiKey'))
                                ->from('Usuarios')
                                ->where('Id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

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
    * Funcion para obtener el Id de un usuario según su ApiKey
    *
    * @param $key -> int
    *
    * @return Retorna, en caso de éxito, el Id correspondiente al Api Key ingresada y, si falla,
    *         un false para api key no encontrada.
    */
    public function ObtenerIdDeApiKey($key) {

        $selectStatement = $this->select(array('Id'))
                                ->from('Usuarios')
                                ->where('ApiKey', '=', $key);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

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
    * Funcion para crear una nueva mutual
    *
    * @param $params array(Codigo, Nombre, Abonoomicilio, PMO, CobroCoseguro, ServicioCortado, INOSReducido, NomenCompleto, ValorA, ValorB, ValorC, ValorNBU, CoeficienteUGastos, CoeficienteUHono, ImporteBoletaMin, AbonoAPB, PorcCobertura, Comentarios, ComentariosInternos, Porcentaje, Condicion, CreadoPor)
    *
    * @return Retorna, en caso de éxito, el Id de la mutual recientemente creada y, si falla,
    *         un false.
    */
    public function CrearMutual($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('Codigo', 
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
                                                   'Condicion', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Mutuales')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],
                                                   $params[8],
                                                   $params[9],
                                                   $params[10],
                                                   $params[11],
                                                   $params[12],
                                                   $params[13],
                                                   $params[14],
                                                   $params[15],
                                                   $params[16],
                                                   $params[17],
                                                   $params[18],
                                                   $params[19],
                                                   $params[20],
                                                   $params[21],
                                                   $params[22],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para chequear que un codigo de mutual existe o no
    *
    * @param $codigo : string
    *
    * @return Retorna True si el codigo de mutual ingresado ya existe, y False si no existe.
    */
    public function CheckearCodigoMutual($codigo){
        if ($codigo) 
        {
            $selectStatement = $this->select(array('mut.Id', 'mut.Codigo'))
                                    ->from('Mutuales mut')
                                    ->where('mut.Codigo', '=', $codigo)
                                    ->where('mut.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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
    }

    /** 
    * Funcion para chequear que la mutual existe o no por id
    *
    * @param $id -> int
    *
    * @return Retorna True si el id de mutual ingresado ya existe, y False si no existe.
    */
    public function ExisteMutual($id){        
        if($id)
        {
            $selectStatement = $this->select(array('mut.Id', 'mut.Codigo as Codigo', 'mut.Nombre'))
                                    ->from('Mutuales mut')
                                    ->where('mut.Id', '=', $id)
                                    ->where('mut.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para modificar una mutual
    *
    * @param $params array(Id, Codigo, Nombre, AbonoDomicilio, PMO, CobroCoseguro, ServicioCortado, INOSReducido, Reconoce677, NomenCompleto, ValorA, ValorB, ValorC, ValorNBU, CoeficienteUGastos, CoeficienteUHono, ImporteBoletaMin, AbonoAPB, PorcCobertura, Comentarios, ComentariosInternos, Porcentaje, Condicion, ModificadoPor)
    *
    * @return Retorna True si el codigo de mutual ingresado ya existe, y False si no existe.
    */
    public function ModificarMutual($params){

        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('Codigo' => $params[1],
                                                   'Nombre' => $params[2],
                                                   'AbonoDomicilio' => $params[3],
                                                   'PMO' => $params[4],
                                                   'CobroCoseguro' => $params[5],
                                                   'ServicioCortado' => $params[6],
                                                   'INOSReducido' => $params[7],
                                                   'Reconoce677' => $params[8],
                                                   'NomenCompleto' => $params[9],
                                                   'ValorA' => $params[10],
                                                   'ValorB' => $params[11],
                                                   'ValorC' => $params[12],
                                                   'ValorNBU' => $params[13],
                                                   'CoeficienteUGastos' => $params[14],
                                                   'CoeficienteUHono' => $params[15],                                                   
                                                   'ImporteBoletaMin' => $params[16],
                                                   'AbonoAPB' => $params[17],                                                   
                                                   'PorcCobertura' => $params[18],
                                                   'Comentarios' => $params[19],
                                                   'ComentariosInternos' => $params[20],
                                                   'Porcentaje' => $params[21],
                                                   'Condicion' => $params[22],
                                                   'ModificadoPor' => $params[23],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Mutuales')
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para eliminar una mutual
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna un 1 si la mutual se elimina correctamente, 0 si no se puede eliminar.
    */
    public function EliminarMutual($params){

        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Mutuales')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();            

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }    

    /** 
    * Funcion para crear un nuevo medico
    *
    * @param $params array(Matricula, TipoMatricula, Nombre, Apellio, Domicilio1, Telefono1, Domicilio2, Telefono2, CreadoPor) 
    *
    * @return Retorna, en caso de éxito, el Id del medico recientemente creado y, si falla,
    *         un false.
    */
    public function CrearMedico($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('Matricula', 
                                                   'TipoMatricula', 
                                                   'Nombre', 
                                                   'Apellido', 
                                                   'Domicilio1', 
                                                   'Telefono1', 
                                                   'Domicilio2',                                                   
                                                   'Telefono2', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Medicos')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],                                 
                                                   $params[8],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para chequear que la matricula ingresada de un medico existe o no
    *
    * @param $matricula -> int
    *
    * @return Retorna, un True si la matricula ingresada ya existe y un False si no existe.
    */
    public function CheckearMatricula($matricula){
        if ($matricula) 
        {
            $selectStatement = $this->select(array('Id', 'Matricula'))
                                    ->from('Medicos')
                                    ->where('Matricula', '=', $matricula);

            $stmt = $selectStatement->execute();
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
    }

    /** 
    * Funcion para chequear que el id de un medico existe o no
    *
    * @param $id -> int
    *
    * @return Retorna, un True si el id ingresado ya existe y un False si no existe.
    */
    public function ExisteMedico($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('med.Id', 
                                                   'med.Nombre', 
                                                   'med.Apellido', 
                                                   'med.Matricula'))
                                    ->from('Medicos med')                                    
                                    ->where('med.Id', '=', $id)
                                    ->where('med.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para modificar un medico
    *
    * @param $params array (Id, Matricula, TipoMatricula, Nombre, Apellido, Domicilio1, Telefono1, Domicilio2, Telefono2, ModificadoPor)
    *
    * @return Retorna, un 1 si se modifica el médico exitosamente y un False si no se modifica.
    */
    public function ModificarMedico($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('Matricula' => $params[1],
                                                   'TipoMatricula' => $params[2],
                                                   'Nombre' => $params[3],
                                                   'Apellido' => $params[4],
                                                   'Domicilio1' => $params[5],
                                                   'Telefono1' => $params[6],
                                                   'Domicilio2' => $params[7],
                                                   'Telefono2' => $params[8],
                                                   'ModificadoPor' => $params[9],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Medicos')
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();
            
            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para eliminar un médico
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna, un 1 si el médico se elimina correctamente y un False si no se elimina.
    */
    public function EliminarMedico($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Medicos')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();            

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para crear un nuevo paciente
    *
    * @param $params array(ApellidoNombre, FechaNacimiento, Sexo, Origen, Cuenta, Direccion, NumDocumento, Telefono, Celular, Lugar, Mail, MatriculaMedico, Mutual1, DebeOrden1, NumAfiliado1, TipoAfiliado1, Mutual2, DebeOrden2, NumAfiliado2, TipoAfiliado2, Factor, ActoProf, CreadoEn, CreadoPor)
    *
    * @return Retorna, en caso de éxito, el Id de la mutual recientemente creada y, si falla,
    *         un false.
    */
    public function CrearPaciente($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('ApellidoNombre', 
                                                   'FechaNacimiento', 
                                                   'Sexo', 
                                                   'Origen', 
                                                   'Cuenta', 
                                                   'Direccion', 
                                                   'NumDocumento', 
                                                   'Telefono', 
                                                   'Celular', 
                                                   'Lugar', 
                                                   'Mail', 
                                                   'MatriculaMedico', 
                                                   'Mutual1', 
                                                   'DebeOrden1', 
                                                   'NumAfiliado1', 
                                                   'TipoAfiliado1', 
                                                   'Mutual2', 
                                                   'DebeOrden2', 
                                                   'NumAfiliado2', 
                                                   'TipoAfiliado2', 
                                                   'Factor', 
                                                   'ActoProf', 
                                                   'CreadoEn', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Pacientes')            
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],
                                                   $params[8],
                                                   $params[9],
                                                   $params[10],
                                                   $params[11],
                                                   $params[12],
                                                   $params[13],
                                                   $params[14],
                                                   $params[15],
                                                   $params[16],
                                                   $params[17],
                                                   $params[18],
                                                   $params[19],
                                                   $params[20],
                                                   $params[21],
                                                   $params[22],
                                                   $params[23],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para chequear que el numero de paciente ingresado existe o no
    *
    * @param $numPaciente -> int
    *
    * @return Retorna True en caso que el numero de paciente ya exista y un False en caso que no exista.
    */
    public function CheckearNumeroPaciente($numPaciente){
        if ($numPaciente) 
        {
            $selectStatement = $this->select(array('ing.Id', 'ing.NumPaciente'))
                                    ->from('Ingresos ing')
                                    ->where('ing.NumPaciente', '=', $numPaciente)
                                    ->where('ing.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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
    }

    /** 
    * Funcion para chequear que el email ingresado de un paciente existe o no
    *
    * @param $mail -> int
    *
    * @return Retorna True en caso que el mail ya exista y un False en caso que no se encuentre.
    */
    public function CheckearEmailPaciente($mail){
        if ($mail) 
        {
            $selectStatement = $this->select(array('Id', 'Mail'))
                                    ->from('Pacientes')
                                    ->where('Mail', '=', $mail);

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para chequear que el documento ingresado de un paciente existe o no
    *
    * @param $doc -> int
    *
    * @return Retorna True en caso que el documento ya exista y un False en caso que no se encuentre.
    */
    public function CheckearNumDocPaciente($doc){
        if ($doc) 
        {
            $selectStatement = $this->select(array('p.NumDocumento'))
                                    ->from('Pacientes p')
                                    ->where('p.NumDocumento', '=', (int) $doc);

            $stmt = $selectStatement->execute();
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
    }

    /** 
    * Funcion para chequear que el id de un paciente existe o no
    *
    * @param $id -> int
    *
    * @return Retorna, un True si el id ingresado ya existe y un False si no existe.
    */
    public function ExistePaciente($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('pac.Id', 'pac.NumDocumento', 'pac.Mail'))
                                    ->from('Pacientes pac')
                                    ->where('pac.Id', '=', $id)
                                    ->where('pac.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para modificar un Paciente
    *
    * @param $params array(Id, ApellidoNombre, FechaNacimiento, Sexo, Origen, Cuenta, Direccion, NumDocumento, Telefono, Celular, Lugar, Mail, MatriculaMedico, Mutual1, DebeOrden1, NumAfiliado1, TipoAfiliado1, Mutual2, DebeOrden2, NumAfiliado2, TipoAfiliado2, Factor, ActoProf, ModificadoPor)
    *
    * @return Retorna, un 1 si se modifica el paciente exitosamente y un False si no se modifica.
    */
    public function ModificarPaciente($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ApellidoNombre' => $params[1],                                                   
                                                   'FechaNacimiento' => $params[2],
                                                   'Sexo' => $params[3],
                                                   'Origen' => $params[4], 
                                                   'Cuenta' => $params[5],
                                                   'Direccion' => $params[6],
                                                   'NumDocumento' => $params[7],
                                                   'Telefono' => $params[8],
                                                   'Celular' => $params[9],
                                                   'Lugar' => $params[10],
                                                   'Mail' => $params[11],
                                                   'MatriculaMedico' => $params[12],
                                                   'Mutual1' => $params[13],
                                                   'DebeOrden1' => $params[14],
                                                   'NumAfiliado1' => $params[15],
                                                   'TipoAfiliado1' => $params[16],
                                                   'Mutual2' => $params[17],
                                                   'DebeOrden2' => $params[18],
                                                   'NumAfiliado2' => $params[19],
                                                   'TipoAfiliado2' => $params[20],
                                                   'Factor' => $params[21],
                                                   'ActoProf' => $params[22],
                                                   'ModificadoPor' => $params[23],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Pacientes')
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();
            
            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }    

    /** 
    * Funcion para eliminar un paciente
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna, un 1 si el paciente se elimina correctamente y un False si no se elimina.
    */
    public function EliminarPaciente($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Pacientes')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();            

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para insertar un nuevo ingreso
    *
    * @param $params array(NumPaciente, PacienteId, Cama, SinCargo, RealizaDescuentos, ReajustaImporte, AbonoSena, Comentarios, CreadoPor)
    *
    * @return Retorna, un 1 si el ingreso se inserta correctamente y false en caso contrario
    */
    public function CrearIngreso($params){
        if (is_array($params))
        {
            $insertStatement = $this->insert(array('NumPaciente', 
                                                   'PacienteId', 
                                                   'Cama', 
                                                   'SinCargo', 
                                                   'RealizaDescuentos', 
                                                   'ReajustaImporte', 
                                                   'AbonoSena', 
                                                   'Comentarios', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Ingresos')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],
                                                   $params[8],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId)
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para insertar un nuevo ingreso
    *
    * @param $params = array(IdIngreso, Cama, SinCargo, RealizaDescuentos, ReajustaImporte, AbonoSena, Comentarios, ModificadoPor)
    *        $Practicas = array(IngresoPracticaId, PracticaId)
    *
    * @return Retorna, un 1 si el ingreso se inserta correctamente y false en caso contrario
    */
    public function ModificarIngreso($params, $practicas){
        if (is_array($params))
        {
            //modifico el ingreso del paciente - sin modificar id paciente 
            $updateStatement = $this->update(array('Cama' => $params[1],
                                                   'SinCargo' => $params[2],
                                                   'RealizaDescuentos' => $params[3],
                                                   'ReajustaImporte' => $params[4],
                                                   'AbonoSena' => $params[5],
                                                   'Comentarios' => $params[6],
                                                   'ModificadoPor' => $params[7],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Ingresos ing')
                                    ->where('ing.Id', '=', $params[0]);

            $modifId = $updateStatement->execute();

            //ingresos practica existentes antes de la modificacion
            $selectStatement = $this->select(array('ingp.Id'))
                                    ->from('IngresosPracticas ingp')
                                    ->where('ingp.IngresoId', '=', $params[0])
                                    ->where('ingp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $ingresosexistentes = $stmt->fetchAll();
                        
            if ($practicas !== null) //existen practicas para modificar o crear
            {
                for ($i = 0; $i < count($practicas); $i++) //recorro practicas a agregar
                {
                    $selectStatement = $this->select(array('ingp.Id', 'ingp.IngresoId', 'ingp.NomencladorId'))
                                            ->from('IngresosPracticas ingp')
                                            ->where('ingp.Id', '=', $practicas[$i][0])
                                            ->where('ingp.EstaBorrado', '=', (int) 0);
                    $stmt = $selectStatement->execute();
                    $ingresoP = $stmt->fetchAll();

                    if ($ingresoP) //el ingresopractica que se buscó ya existe -> averiguar que operacion hacer
                    {
                        if ($ingresoP[0]['NomencladorId'] !== $practicas[$i][1])
                        {
                            //el ingresopractica existente tiene una practica distinta -> modifica
                            $updateStatement = $this->update(array('NomencladorId' => $practicas[$i][1],
                                                                   'ModificadoPor' => $params[7],
                                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                                    ->table('IngresosPracticas')
                                                    ->where('Id', '=', $practicas[$i][0]);
                            $modifIP = $updateStatement->execute();
                        }
                    }
                    else //el ingresopractica que se buscó no existe -> se inserta
                    {
                        $insertStatement = $this->insert(array('IngresoId', 'NomencladorId', 'CreadoPor', 'CreadoFecha'))
                                                ->into('IngresosPracticas')
                                                ->values(array($params[0],
                                                               $practicas[$i][1],
                                                               $params[7],
                                                               date('Y-m-d H:i:s')));
                        $insertId = $insertStatement->execute();
                    }
                }
                //formo un array con los Id de los ingresos nuevos
                $ingresosnuevos = array();
                for ($i = 0; $i < count($practicas); $i++) 
                { 
                    array_push($ingresosnuevos, $practicas[$i][0]);
                }

                //cicla entre los ingresos existentes previos a la modificacion
                for ($i = 0; $i < count($ingresosexistentes); $i++) 
                {   //pregunta si el ingreso previo existe en los nuevos, sino existe lo borra
                    if (!in_array($ingresosexistentes[$i]['Id'], $ingresosnuevos)) 
                    {
                        $updateStatement = $this->update(array('EstaBorrado' => (int) 1,
                                                               'ModificadoPor' => $params[7],
                                                               'ModificadoFecha' => date('Y-m-d H:i:s')))
                                                ->table('IngresosPracticas')
                                                ->where('Id', '=', $ingresosexistentes[$i]['Id']);
                        $modifIP = $updateStatement->execute();
                    }
                }
            }
            else //no existen practicas para modificar o crear -> se borraron todas en la modificacion
            {                
                $updateStatement = $this->update(array('EstaBorrado' => (int) 1,
                                                       'ModificadoPor' => $params[7],
                                                       'ModificadoFecha' => date('Y-m-d H:i:s')))
                                        ->table('IngresosPracticas')
                                        ->where('IngresoId', '=', $params[0]);
                $modifIP = $updateStatement->execute();
            }

            if ($modifId)
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para eliminar un ingreso
    *
    * @param $params array(PacienteId, ModificadoPor)
    *
    * @return Retorna, un 1 si el ingreso se elimina correctamente y false en caso contrario
    */
    public function EliminarIngreso($params){
        if (is_array($params)) 
        {
            $selectStatement = $this->select(array('ing.Id', 'ing.PacienteId'))
                                    ->from('Ingresos ing')
                                    ->where('ing.PacienteId', '=', $params[0])
                                    ->where('ing.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $ingresos = $stmt->fetchAll();

            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Ingresos')
                                    ->where('PacienteId', '=', $params[0]);
            $deleteId = $updateStatement->execute();

            if ($ingresos) 
            {
                for ($i = 0; $i < count($ingresos); $i++) 
                {
                    $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                           'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                           'EstaBorrado' => (int) 1))
                                            ->table('IngresosPracticas')
                                            ->where('IngresoId', '=', $ingresos[$i]['Id']);
                    $deleteId = $updateStatement->execute();
                }
            }

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para checkear la existencia de un Ingreso por su Id
    *
    * @param $id -> int
    *
    * @return Devuelve, en caso de encontrarlo, los datos del ingreso y, si falla, devuelve un False.
    */
    public function ExisteIngreso($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('ing.Id', 
                                                   'ing.PacienteId', 
                                                   'ing.NumPaciente', 
                                                   'ing.Cama', 
                                                   'ing.SinCargo', 
                                                   'ing.RealizaDescuentos', 
                                                   'ing.ReajustaImporte', 
                                                   'ing.AbonoSena', 
                                                   'ing.Comentarios'))
                                    ->from('Ingresos ing')
                                    ->where('ing.Id', '=', $id)
                                    ->where('ing.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para crear un nomenclador
    *
    * @param $params array (Codigo, Nombre, INOS, _677, UGastos, UHonorarios, Area, Complejidad, INOSReducido, NoNomenclada, TiempoRealizacion, IdMuestra, Proceso, Lista, CodigoFABA, Nivel, RIA, NBUFrecuencia, NBUCodigo, Cantidad, CreadoPor)
    *
    * @return Retorna, en caso de éxito, el id del nomenclador creado y, si falla,
    *         un False.
    */
    public function CrearNomenclador($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('Codigo', 
                                                   'Nombre', 
                                                   'INOS', 
                                                   '_677', // material descartable
                                                   'UGastos', 
                                                   'UHonorarios', 
                                                   'Area', 
                                                   'Complejidad', 
                                                   'INOSReducido', 
                                                   'NoNomenclada', 
                                                   'TiempoRealizacion', 
                                                   'IdMuestra', 
                                                   'Proceso', 
                                                   'Lista', 
                                                   'CodigoFABA', 
                                                   'Nivel', 
                                                   'RIA', 
                                                   'NBUFrecuencia', 
                                                   'NBUCodigo', 
                                                   'Cantidad', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Nomencladores')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],
                                                   $params[8],
                                                   $params[9],
                                                   $params[10],
                                                   $params[11],
                                                   $params[12],
                                                   $params[13],
                                                   $params[14],
                                                   $params[15],
                                                   $params[16],
                                                   $params[17],
                                                   $params[18],
                                                   $params[19],                                                   
                                                   $params[20],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para crear Prácticas asociadas a un nomenclador de trabajo
    *
    * @param $params -> array(NomencladorId, Codigo, Nombre, EsDeTrabajo, CreadoPor)
    *        $determinaciones -> array(NombreDeterminacion, Seccion, Orden)
    *
    * @return Retorna el id del registro creado recientemente en caso de éxito y false en caso contrario
    */
    public function CrearPractica($params, $determinaciones){
        if (is_array($params) && is_array($determinaciones))
        {
            if ($params[3] == 1) 
            {
                for ($i = 0; $i < count($determinaciones); $i++) 
                {
                    $insertStatement = $this->insert(array('NomencladorId', 
                                                           'Codigo', 
                                                           'Nombre', 
                                                           'EsNomencladorTrabajo', 
                                                           'NombreDeterminacion', 
                                                           'Seccion', 
                                                           'Orden', 
                                                           'CreadoPor', 
                                                           'CreadoFecha'))
                                            ->into('Practicas')
                                            ->values(array($params[0],
                                                           $params[1],
                                                           $params[2],
                                                           $params[3],
                                                           $determinaciones[$i][0],
                                                           $determinaciones[$i][1],
                                                           $determinaciones[$i][2],
                                                           $params[4],
                                                           date('Y-m-d H:i:s')));

                    $insertId = $insertStatement->execute();
                }
            }
            else
            {
                $insertStatement = $this->insert(array('NomencladorId', 
                                                       'Codigo', 
                                                       'Nombre', 
                                                       'EsNomencladorTrabajo', 
                                                       'CreadoPor', 
                                                       'CreadoFecha'))
                                        ->into('Practicas')
                                        ->values(array($params[0],
                                                       $params[2],
                                                       $params[1],
                                                       $params[3],
                                                       $params[4],
                                                       date('Y-m-d H:i:s')));

                $insertId = $insertStatement->execute();
            }
        }

        if ($insertId) 
        {
            return $insertId;
        }
        else
        {
            return FALSE;
        }
    }

    /** 
    * Funcion para checkear la existencia de un código de nomenclador
    *
    * @param $codigo -> string
    *
    * @return Retorna True si el código de nomenclador ingresado ya existe y False si no existe.
    */
    public function CheckearCodigoNomenclador($codigo){
        if ($codigo) 
        {
            $selectStatement = $this->select(array('n.Codigo'))
                                    ->from('Nomencladores n')
                                    ->where('n.Codigo', '=', $codigo)                                    
                                    ->where('n.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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
    }

    /** 
    * Funcion para checkear la existencia de un id de nomenclador
    *
    * @param $id -> int
    *
    * @return Retorna True si el id de nomenclador ingresado ya existe y False si no existe.
    */
    public function ExisteNomenclador($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('n.Id', 'n.Codigo'))
                                    ->from('Nomencladores n')
                                    ->where('n.Id', '=', $id);                                    

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para modificar un nomenclador
    *
    * @param $params array(Id, Codigo, Nombre, INOS, _677, UGastos, UHonorario, Area, Complejidad, INOSReducido, NoNomenclada, TiempoRealizacion, IdMuestra, Proceso, Lista, CodigoFABA, Nivel, RIA, NBUFrecuencia, NBUCodigo, Cantidad, ModificadoPor)
    *
    * @return Retorna True si el nomenclador se modifica correctamente y False si no se modifica.
    */
    public function ModificarNomenclador($params){
        if (is_array($params))
        {
            $updateStatement = $this->update(array('Codigo' => $params[1],
                                                   'Nombre' => $params[2],
                                                   'INOS' => $params[3],
                                                   '_677' => $params[4],
                                                   'UGastos' => $params[5],
                                                   'UHonorarios' => $params[6],
                                                   'Area' => $params[7],
                                                   'Complejidad' => $params[8],
                                                   'INOSReducido' => $params[9],
                                                   'NoNomenclada' => $params[10],
                                                   'TiempoRealizacion' => $params[11],
                                                   'IdMuestra' => $params[12],
                                                   'Proceso' => $params[13],
                                                   'Lista' => $params[14],
                                                   'CodigoFABA' => $params[15],
                                                   'Nivel' => $params[16],
                                                   'RIA' => $params[17],
                                                   'NBUFrecuencia' => $params[18],
                                                   'NBUCodigo' => $params[19],
                                                   'Cantidad' => $params[20],
                                                   'ModificadoPor' => $params[21],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Nomencladores')
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();            

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para eliminar un nomenclador
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna True si el nomenclador se elimina correctamente y False si no se elimina.
    */
    public function EliminarNomenclador($params){
        if (is_array($params))
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Nomencladores')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();            

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para crear una sección
    *
    * @param $params array(Codigo, Nombre, Determinacion1, Determinacion2, Determinacion3, Determinacion4, Determinacion5, Determinacion6, Determinacion7, Determinacion8, Determinacion9, Determinacion10, Determinacion11, Determinacion12, Determinacion13, Determinacion14, Determinacion15, Determinacion16, Determinacion17, Determinacion18, Determinacion19, Determinacion20, Determinacion21, Determinacion22, Determinacion23, Determinacion24, CreadoPor)
    *
    * @return Retorna True si el nomenclador se elimina correctamente y False si no se elimina.
    */
    public function CrearSeccion($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('Codigo', 
                                                   'Nombre', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Secciones')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    public function CrearSeccionesPracticas($params, $determinaciones){
        if (is_array($params) && is_array($determinaciones)) 
        {
            for ($i = 0; $i < count($determinaciones); $i++) 
            { 
                $insertStatement = $this->insert(array('SeccionId', 
                                                       'PracticaId', 
                                                       'CreadoPor', 
                                                       'CreadoFecha'))
                                        ->into('SeccionesPracticas')
                                        ->values(array($params[0],
                                                       $determinaciones[$i],
                                                       $params[1],
                                                       date('Y-m-d H:i:s')));
                $insertId = $insertStatement->execute();
            }

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para checkear si el código de sección ingresado existe o no.
    *
    * @param $codigo -> string
    *
    * @return Retorna True si el código ingresado existe y False si no se encuentra.
    */
    public function CheckearCodigoSeccion($codigo){
        if ($codigo) 
        {
            $selectStatement = $this->select(array('Id', 
                                                   'Codigo'))
                                    ->from('Secciones')
                                    ->where('Codigo', '=', $codigo)
                                    ->where('EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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
    }

    /** 
    * Funcion para checkear que una sección existe o no según su Id
    *
    * @param $id -> int
    *
    * @return Retorna True si se encuentra una sección con Id igual al ingresado y False si no se encuentra ninguna.
    */
    public function ExisteSeccion($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('sec.Id', 
                                                   'sec.Codigo'))
                                    ->from('Secciones sec')
                                    ->where('sec.Id', '=', $id)
                                    ->where('sec.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /** 
    * Funcion para modificar una sección
    *
    * @param $params array(Id, Codigo, Nombre, Determinacion1, Determinacion2, Determinacion3, Determinacion4, Determinacion5, Determinacion6, Determinacion7, Determinacion8, Determinacion9, Determinacion10, Determinacion11, Determinacion12, Determinacion13, Determinacion14, Determinacion15, Determinacion16, Determinacion17, Determinacion18, Determinacion19, Determinacion20, Determinacion21, Determinacion22, Determinacion23, Determinacion24, ModificadoPor)
    *
    * @return Retorna True si el nomenclador se elimina correctamente y False si no se elimina.
    */
    public function ModificarSeccion($params, $determinaciones){
        
        if (is_array($params) && is_array($determinaciones))
        {
            //modifico la seccion (nombre y codigo)
            $updateStatement = $this->update(array('Codigo' => $params[1],
                                                   'Nombre' => $params[2],
                                                   'ModificadoPor' => $params[3],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Secciones sec')
                                    ->where('sec.Id', '=', $params[0]);

            $modifId = $updateStatement->execute();

            //determinaciones existentes antes de la modificacion
            $selectStatement = $this->select(array('sp.Id'))
                                    ->from('SeccionesPracticas sp')
                                    ->where('sp.SeccionId', '=', $params[0])
                                    ->where('sp.EstaBorrado', '=', (int) 0);
            $stmt = $selectStatement->execute();
            $determinacionesexistentes = $stmt->fetchAll();
                        
            if ($determinaciones !== null) //existen determinaciones para modificar o crear
            {
                for ($i = 0; $i < count($determinaciones); $i++) //recorro practicas a agregar
                {
                    $selectStatement = $this->select(array('sp.Id', 'sp.SeccionId', 'sp.PracticaId'))
                                            ->from('SeccionesPracticas sp')
                                            ->where('sp.Id', '=', $determinaciones[$i][0])
                                            ->where('sp.EstaBorrado', '=', (int) 0);
                    $stmt = $selectStatement->execute();
                    $determinacion = $stmt->fetchAll();
                    //hasta aca ok
                    if ($determinacion) //la determinacion que se buscó ya existe -> averiguar que operacion hacer
                    {
                        if ($determinacion[0]['PracticaId'] !== $determinaciones[$i][1])
                        {
                            //la determinacion existente tiene una practica distinta -> modifica
                            $updateStatement = $this->update(array('PracticaId' => $determinaciones[$i][1],
                                                                   'ModificadoPor' => $params[3],
                                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                                    ->table('SeccionesPracticas')
                                                    ->where('Id', '=', $determinaciones[$i][0]);
                            $modifSP = $updateStatement->execute();
                        }
                    }
                    else //la determinacion que se buscó no existe -> se inserta
                    {
                        $insertStatement = $this->insert(array('SeccionId', 
                                                               'PracticaId', 
                                                               'CreadoPor', 
                                                               'CreadoFecha'))
                                                ->into('SeccionesPracticas')
                                                ->values(array($params[0],
                                                               $determinaciones[$i][1],
                                                               $params[3],
                                                               date('Y-m-d H:i:s')));
                        $insertId = $insertStatement->execute();
                    }
                }
                //formo un array con los Id de las seccionespractica nuevas
                $detnuevas = array();
                for ($i = 0; $i < count($determinaciones); $i++) 
                { 
                    array_push($detnuevas, $determinaciones[$i][0]);
                }

                //cicla entre las secciones practicas previas a la modificacion
                for ($i = 0; $i < count($determinacionesexistentes); $i++) 
                {   //pregunta si la determinacion previa existe en las nuevas, sino existe la borra
                    if (!in_array($determinacionesexistentes[$i]['Id'], $detnuevas)) 
                    {
                        $updateStatement = $this->update(array('EstaBorrado' => (int) 1,
                                                               'ModificadoPor' => $params[3],
                                                               'ModificadoFecha' => date('Y-m-d H:i:s')))
                                                ->table('SeccionesPracticas')
                                                ->where('Id', '=', $determinacionesexistentes[$i]['Id']);
                        $modifIP = $updateStatement->execute();
                    }
                }
            }
            else //no existen practicas para modificar o crear -> se borraron todas en la modificacion
            {                
                $updateStatement = $this->update(array('EstaBorrado' => (int) 1,
                                                       'ModificadoPor' => $params[3],
                                                       'ModificadoFecha' => date('Y-m-d H:i:s')))
                                        ->table('SeccionesPracticas')
                                        ->where('SeccionId', '=', $params[0]);
                $modifIP = $updateStatement->execute();
            }

            if ($modifId)
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Funcion para eliminar una sección
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna True si la sección se elimina correctamente y False si no se elimina.
    */
    public function EliminarSeccion($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('SeccionesPracticas')
                                    ->where('SeccionId', '=', $params[0]);
            $deleteIdSP = $updateStatement->execute();

            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Secciones')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();

            if ($deleteId && $deleteIdSP) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para agregar las prácticas a realizar sobre un paciente
    *
    * @param $params -> array(IngresoId, CreadoPor)
    *        $practicas -> array(PracticaId)
    *
    * @return
    */
    public function CrearIngresoPractica($params, $practicas){
        if (is_array($params) && is_array($practicas)) 
        {
            for ($i = 0; $i < count($practicas); $i++) 
            { 
                $insertStatement = $this->insert(array('IngresoId', 
                                                       'NomencladorId', 
                                                       'CreadoPor', 
                                                       'CreadoFecha'))
                                        ->into('IngresosPracticas')
                                        ->values(array($params[0],
                                                       $practicas[$i],
                                                       $params[1],
                                                       date('Y-m-d H:i:s')));

                $insertId = $insertStatement->execute();
            }
            
            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Función para crear un nuevo título
    *
    * @param $params array(Codigo, Descripcion, Tipo, Unidades, Rango, LineaTexto1, LineaTexto2, LineaTexto3, LineaTexto4, ValoresReferenciaAmpliados, ValorMinimo, ValorMaximo, CreadoPor)
    *
    * @return Retorna, en caso de éxito, el Id del título recientemente creado y, si falla, 
    *         un False.
    */
    public function CrearTitulo($params){
        if (is_array($params)) 
        {
        $insertStatement = $this->insert(array('Codigo', 
                                               'Descripcion', 
                                               'Tipo', 
                                               'Unidades', 
                                               'Rango', 
                                               'LineaTexto1', 
                                               'LineaTexto2', 
                                               'LineaTexto3', 
                                               'LineaTexto4', 
                                               'ValoresReferenciaAmpliados', 
                                               'ValorMinimo', 
                                               'ValorMaximo', 
                                               'CreadoPor', 
                                               'CreadoFecha'))
                                    ->into('Titulos')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],
                                                   $params[8],
                                                   $params[9],
                                                   $params[10],
                                                   $params[11],
                                                   $params[12],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Función para modificar un título
    *
    * @param $params array(Id, Codigo, Descripcion, Tipo, Unidades, Rango, LineaTexto1, LineaTexto2, LineaTexto3, LineaTexto4, ValoresReferenciaAmpliados, ValorMinimo, ValorMaximo, ModificadoPor)
    *
    * @return Retorna, en caso de éxito, un 1 y, si falla, un False.
    *         
    */
    public function ModificarTitulo($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('Codigo' => $params[1],
                                                   'Descripcion' => $params[2],
                                                   'Tipo' => $params[3],
                                                   'Unidades' => $params[4],
                                                   'Rango' => $params[5],
                                                   'LineaTexto1' => $params[6],
                                                   'LineaTexto2' => $params[7],
                                                   'LineaTexto3' => $params[8],
                                                   'LineaTexto4' => $params[9],
                                                   'ValoresReferenciaAmpliados' => $params[10],
                                                   'ValorMinimo' => $params[11],
                                                   'ValorMaximo' => $params[12],
                                                   'ModificadoPor' => $params[13],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Titulos')
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Función para eliminar un título
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Retorna, en caso de éxito, un 1 y, si falla, un False.
    *         
    */
    public function EliminarTitulo($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Titulos')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();

            if($deleteId)
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /** 
    * Función para checkear que el código de un título existe o no.
    *
    * @param $codigo -> string
    *
    * @return Retorna, en caso de encontrar el código, Id y código del título correspondiente y, un False si no se encuentra.
    *         
    */
    public function CheckearCodigoTitulo($codigo){
        if($codigo)
        {
            $selectStatement = $this->select(array('tit.Id', 'tit.Codigo'))
                                    ->from('Titulos tit')
                                    ->where('tit.Codigo', '=', $codigo)
                                    ->where('tit.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /** 
    * Función para verificar que un título existe o no según su Id
    *
    * @param $id -> int
    *
    * @return Retorna, en caso de encontrar el título, Id y código, y, si no se encuentra, un False.
    *         
    */
    public function ExisteTitulo($id){
        if($id)
        {
            $selectStatement = $this->select(array('tit.Id', 'tit.Codigo'))
                                    ->from('Titulos tit')
                                    ->where('tit.Id', '=', $id)
                                    ->where('tit.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para modificar una configuración de usuario
    *
    * @param $params array(Id, IdUsuario, ColorEncabezado, ColorEncabezadoCinta, ColorMenuLateral, ColorPiePagina, ColorFondo, LogoLab, CreadoPor)
    *
    * @return Devuelve, en caso de éxito, el Id de la configuración creada y, si falla un False.
    */
    public function CrearConfiguracion($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('IdUsuario', 
                                                   'ColorEncabezado', 
                                                   'ColorEncabezadoCinta', 
                                                   'ColorMenuLateral', 
                                                   'ColorPiePagina', 
                                                   'ColorFondo', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('Configuraciones')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId)
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para modificar una configuración de usuario
    *
    * @param $params array(IdUsuario, ColorEncabezado, ColorEncabezadoCinta, ColorMenuLateral, ColorPiePagina, ColorFondo, Imgusuario, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito, un 1, y un False si no se modifica.
    */
    public function ModificarConfiguracion($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ColorEncabezado' => $params[1],
                                                   'ColorEncabezadoCinta' => $params[2],
                                                   'ColorMenuLateral' => $params[3],
                                                   'ColorPiePagina' => $params[4],
                                                   'ColorFondo' => $params[5],
                                                   'ModificadoPor' => $params[7],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Configuraciones')
                                    ->where('IdUsuario', '=', $params[0]);

            $modifId1 = $updateStatement->execute();

            $updateStatement = $this->update(array('Imagen' => 'app/usuarios/imagenes-perfil/' . $params[6],                                                   
                                                   'ModificadoPor' => $params[7],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('Usuarios')
                                    ->where('Id', '=', $params[0]);

            $modifId2 = $updateStatement->execute();

            if ($modifId1 && $modifId2) 
            {
                return $modifId1;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para eliminar una configuración de usuario
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito, un 1, y un False si no se elimina.
    */
    public function EliminarConfiguracion($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Configuraciones')
                                    ->where('IdUsuario', '=', $params[0]);

            $deleteId = $updateStatement->execute();

            if ($deleteId)
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para verificar si una configuración de usuario existe o no, según su Id de usuario
    *
    * @param $id -> int
    *
    * @return Devuelve, en caso de encontrarla, los datos de la configuración, y un False si no se encuentra.
    */
    public function ExisteConfiguracion($idusuario){
        if ($idusuario)
        {
            $selectStatement = $this->select(array('conf.Id', 
                                                   'conf.IdUsuario', 
                                                   'conf.ColorEncabezado', 
                                                   'conf.ColorEncabezadoCinta', 
                                                   'conf.ColorMenuLateral', 
                                                   'conf.ColorPiePagina', 
                                                   'conf.ColorFondo'))
                                    ->from('Configuraciones conf')
                                    ->where('conf.IdUsuario', '=', $idusuario)
                                    ->where('conf.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para crear un registro de configuración del sistema
    *
    * @param $params array(LogoLab, CreadoPor)
    *
    * @return Devuelve, en caso de encontrarla, los datos de la configuración, y un False si no se encuentra.
    */
    public function CrearConfiguracionSistema($params){
        if (is_array($params))
        {
            $insertStatement = $this->insert(array('LogoLab', 
                                                   'NombreLab', 
                                                   'LemaLab', 
                                                   'TrabajarSinConexion', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('ConfiguracionesSistema')
                                    ->values(array('img/logo/' . $params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId)
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para modificar un registro de configuración del sistema
    *
    * @param $params array(Id, LogoLab, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito, un 1 si se modifica, y un False si no se modifica.
    */
    public function ModificarConfiguracionSistema($params){
        if (is_array($params))
        {
            $updateStatement = $this->update(array('LogoLab' => 'img/logo/' . $params[1],
                                                   'NombreLab' => $params[2],
                                                   'LemaLab' => $params[3],
                                                   'ModificadoPor' => $params[4],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('ConfiguracionesSistema')
                                    ->where('IdUsuario', '=', $params[0]);

            $modifId = $updateStatement->execute();

            if ($modifId)
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para checkear si existe o no un registro de configuracion del sistema
    *
    * @return Devuelve, en caso de encontrarla, los datos de la configuración de sistema, y un False si no se encuentra.
    */
    public function ExisteConfiguracionSistema(){
        $selectStatement = $this->select(array())
                                ->from('ConfiguracionesSistema');

        $stmt = $selectStatement->execute();
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
    * Función para crear un resultado
    *
    * @param $params array(PacienteId, CreadoPor),
    *        $practicas array(Nomenclador1Id, Nomenclador2Id, Nomenclador3Id, Nomenclador4Id, Nomenclador5Id, Nomenclador6Id,
    *                         Nomenclador7Id, Nomenclador8Id, Nomenclador9Id, Nomenclador10Id, Nomenclador11Id, Nomenclador12Id, 
    *                         Nomenclador13Id, Nomenclador14Id, Nomenclador15Id, Nomenclador16Id, Nomenclador17Id, Nomenclador18Id, 
    *                         Nomenclador19Id, Nomenclador20Id),
    *        $resultados array(Resultado1, Resultado2, Resultado3, Resultado4, Resultado5, Resultado6, Resultado7, Resultado8,
    *                          Resultado9, Resultado10, Resultado11, Resultado12, Resultado13, Resultado14, Resultado15, Resultado16,
    *                          Resultado17, Resultado18, Resultado19, Resultado20)
    *
    * @return Devuelve, en caso de éxito, el Id del resultado creado y en caso que falle, un False.
    */
    public function CrearResultado($params, $practicas, $resultados){
        if (is_array($params) && is_array($practicas) && is_array($resultados))
        {
            for ($i = 0; $i < count($practicas); $i++)
            { 
                if ($practicas[$i] !== null && $practicas[$i] !== '') 
                {
                    $insertStatement = $this->insert(array('IngresoId', 
                                                           'NomencladorId', 
                                                           'Resultado',
                                                           'CreadoPor', 
                                                           'CreadoFecha'))
                                            ->into('Resultados')
                                            ->values(array($params[0],
                                                           $practicas[$i],
                                                           $resultados[$i],
                                                           $params[1],                                                   
                                                           date('Y-m-d H:i:s')));

                    $insertId = $insertStatement->execute();
                }
            }            

            if ($insertId) 
            {
              return $insertId;
            }
            else
            {
              return FALSE;
            }
        }
    }
  
     public function CrearloResultado($params){
        if (is_array($params))
        {
            $insertStatement = $this->insert(array('IngresoId', 
                                                   'NomencladorId',                                                   
                                                   'Resultado',
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                            ->into('Resultados')
                                            ->values(array($params[0],
                                                           $params[1],
                                                           $params[2],
                                                           $params[4],                                                   
                                                           date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if($params[3])
            {
                $updateStatement = $this->update(array('EstaCompleto' => (int) 1,
                                                       'ModificadoPor' => 'mlazzeri',
                                                       'ModificadoFecha' => date('Y-m-d H:i:s')))
                                        ->table('Ingresos')
                                        ->where('Id', '=', $params[0]);

                $modifId = $updateStatement->execute();  
            }

            if ($insertId) 
            {
              return $insertId;
            }
            else
            {
              return FALSE;
            }
        }
    }

    /**
    * Función para modificar un resultado
    *
    * @param $params array(Id, PacienteId, NomencladorId, Resultado, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito, un 1 y en caso que falle, un False.
    */
    public function ModificarResultado($params, $practicas){
        if (is_array($params) && is_array($practicas)) 
        {
            for ($i = 0; $i < count($practicas); $i++) 
            { 
                $updateStatement = $this->update(array('Resultado' => $practicas[$i][1],
                                                       'ModificadoPor' => $params[1],
                                                       'ModificadoFecha' => date('Y-m-d H:i:s')))
                                        ->table('Resultados')
                                        ->where('IngresoId', '=', $params[0])
                                        ->where('NomencladorId', '=', $practicas[$i][0]);

                $modifId = $updateStatement->execute();   
            }

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para eliminar un resultado
    *
    * @param $params array(Id, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito un 1, y si falla devuelve un False.
    */
    public function EliminarResultado($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('Resultados')
                                    ->where('Id', '=', (int) $params[0]);

            $deleteId = $updateStatement->execute();

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para checkear que un resultado existe por su id
    *
    * @param $id -> int
    *
    * @return Devuelve, en caso de encontrarlo, los datos del resultado coincidente con el id ingresado y,
    *         si falla devuelve un False.
    */
    public function ExisteResultado($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('res.Id', 
                                                   'res.IngresoId', 
                                                   'res.NomencladorId', 
                                                   'res.Resultado'))
                                    ->from('Resultados res')
                                    ->where('res.Id', '=', (int) $id)
                                    ->where('res.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para obtener el Id de un ingreso según un número de paciente ingresado
    *
    * @param $numPaciente -> int
    *
    * @return Devuelve, en caso de encontrarlo, el Id del ingreso correspondiente al número de paciente ingresado y,
    *         si falla devuelve un False.
    */
    public function ObtenerIdIngresoNumPaciente($numPaciente){
        if ($numPaciente) 
        {
            $selectStatement = $this->select(array('ing.Id'))
                                    ->from('Ingresos ing')
                                    ->where('ing.NumPaciente', '=', $numPaciente)
                                    ->where('ing.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para obtener el Id de un ingreso según un Id de paciente ingresado
    *
    * @param $id -> int
    *
    * @return Devuelve, en caso de encontrarlo, el Id del ingreso correspondiente al Id de paciente ingresado y,
    *         si falla devuelve un False.
    */
    public function ObtenerIdIngresoIdPaciente($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('ing.Id'))
                                    ->from('Ingresos ing')
                                    ->where('ing.PacienteId', '=', $id)
                                    ->where('ing.EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para crear un nomenclador especial nuevo
    *
    * @param $params -> array(MutualId, A, Nombre, Codigo, UnidadGasto, UnidadHonorario, Nivel, CreadoPor)
    *
    * @return Devuelve, en caso de éxito, el Id del nomenclador especial nuevo y, si falla, devuelve False.
    */
    public function CrearNomencladorEspecial($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('MutualId', 
                                                   'A', 
                                                   'Nombre', 
                                                   'Codigo', 
                                                   'UnidadGasto', 
                                                   'UnidadHonorario', 
                                                   'Nivel', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('NomencladoresEspeciales')
                                    ->values(array($params[0], 
                                                   $params[1], 
                                                   $params[2], 
                                                   $params[3], 
                                                   $params[4], 
                                                   $params[5], 
                                                   $params[6], 
                                                   $params[7], 
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para modificar un nomenclador especial
    *
    * @param $params -> array(Id, MutualId, A, Nombre, Codigo, UnidadGasto, UnidadHonorario, Nivel, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito, un 1 y, si falla, devuelve False.
    */
    public function ModificarNomencladorEspecial($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('MutualId' => $params[1],
                                                   'A' => $params[2],
                                                   'Nombre' => $params[3],
                                                   'Codigo' => $params[4],
                                                   'UnidadGasto' => $params[5],
                                                   'UnidadHonorario' => $params[6],
                                                   'Nivel' => $params[7],
                                                   'ModificadoPor' => $params[8],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('NomencladoresEspeciales')
                                    ->where('Id', '=', $params[0]);

            $modifId = $updateStatement->execute();

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para eliminar un nomenclador especial
    *
    * @param $params -> array(Id, ModificadoPor)
    *
    * @return Devuelve, en caso de éxito, un 1 y, si falla, devuelve False.
    */
    public function EliminarNomencladorEspecial($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('ModificadoPor' => $params[1],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s'),
                                                   'EstaBorrado' => (int) 1))
                                    ->table('NomencladoresEspeciales')
                                    ->where('Id', '=', $params[0]);

            $deleteId = $updateStatement->execute();

            if ($deleteId) 
            {
                return $deleteId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para checkear que un nomenclador especial existe o no por su Id
    *
    * @param $id -> int
    *
    * @return Devuelve, en caso de éxito, los datos del nomenclador especial encontrado y, si falla, devuelve False.
    */
    public function ExisteNomencladorEspecial($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('p.Id', 
                                                   'p.MutualId', 
                                                   'p.A', 
                                                   'p.Nombre', 
                                                   'p.Codigo', 
                                                   'p.UnidadGasto', 
                                                   'p.UnidadHonorario', 
                                                   'p.Nivel'))
                                    ->from('NomencladoresEspeciales p')
                                    ->where('p.Id', '=', $id);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para checkear que el nombre de un nomenclador especial está repetido o no
    *
    * @param $nombre -> string
    *
    * @return Devuelve, en caso de éxito, los datos del nomenclador especial correspondiente al nombre
    *         ingresado y, si falla, devuelve False.
    */
    public function CheckearNombreNomencladorEspecial($nombre, $mutualid){
        if ($nombre) 
        {
            $selectStatement = $this->select(array('p.Id', 
                                                   'p.MutualId', 
                                                   'p.A', 
                                                   'p.Nombre', 
                                                   'p.Codigo', 
                                                   'p.UnidadGasto', 
                                                   'p.UnidadHonorario', 
                                                   'p.Nivel'))
                                    ->from('NomencladoresEspeciales p')
                                    ->where('p.Nombre', '=', $nombre)
                                    ->where('p.MutualId', '=', $mutualid);

            $stmt = $selectStatement->execute();
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

    /**
    * Función para crear un nuevo registro de valores de unidades en uso
    *
    * @param $params -> array(NumeroUsoArranque, ValorFABAA, ValorFABAB, ValorFABAC, ValorNBUAltaFrec, ValorNBUBajaFrec, PMO, UGastos, UHonorarios, Recibos, Etiquetas, Tarjetas, ValorPracticaMinima, ExtraccionDomicilio, ActoProfesionalBioquimico, ValorMontoMaximo, NumeradorDerivaciones, SeccionFormulaHemograma, PosicionSeccion, PracticasComponentes, DecodificarNemotecnicos, CreadoPor)
    *
    * @return Devuelve, en caso de crear un registro de valores de unidades en uso, el Id del registro creado y,
    *         si falla, devuelve False.
    */
    public function CrearValoresUnidades($params){
        if (is_array($params)) 
        {
            $insertStatement = $this->insert(array('NumeroUsoArranque', 
                                                   'ValorFABAA', 
                                                   'ValorFABAB', 
                                                   'ValorFABAC', 
                                                   'ValorNBUAltaFrec', 
                                                   'ValorNBUBajaFrec', 
                                                   'PMO', 
                                                   'UGastos', 
                                                   'UHonorarios', 
                                                   'Recibos', 
                                                   'Etiquetas', 
                                                   'Tarjetas', 
                                                   'ValorPracticaMinima', 
                                                   'ExtraccionDomicilio', 
                                                   'ActoProfesionalBioquimico', 
                                                   'ValorMontoMaximo', 
                                                   'NumeradorDerivaciones', 
                                                   'SeccionFormulaHemograma', 
                                                   'PosicionSeccion', 
                                                   /*'PracticasComponentes',*/ 
                                                   'DecodificarNemotecnicos', 
                                                   'CreadoPor', 
                                                   'CreadoFecha'))
                                    ->into('ValoresUnidades')
                                    ->values(array($params[0],
                                                   $params[1],
                                                   $params[2],
                                                   $params[3],
                                                   $params[4],
                                                   $params[5],
                                                   $params[6],
                                                   $params[7],
                                                   $params[8],
                                                   $params[9],
                                                   $params[10],
                                                   $params[11],
                                                   $params[12],
                                                   $params[13],
                                                   //$params[14],
                                                   $params[14],
                                                   $params[15],
                                                   $params[16],
                                                   $params[17],
                                                   $params[18],
                                                   $params[19],
                                                   $params[20],
                                                   date('Y-m-d H:i:s')));

            $insertId = $insertStatement->execute();

            if ($insertId) 
            {
                return $insertId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    /**
    * Función para crear un nuevo registro de valores de unidades en uso
    *
    * @param $params -> array(NumeroUsoArranque, ValorFABAA, ValorFABAB, ValorFABAC, ValorNBUAltaFrec, ValorNBUBajaFrec, PMO, UGastos, UHonorarios, Recibos, Etiquetas, Tarjetas, ValorPracticaMinima, ExtraccionDomicilio, ActoProfesionalBioquimico, ValorMontoMaximo, NumeradorDerivaciones, SeccionFormulaHemograma, PosicionSeccion, PracticasComponentes, DecodificarNemotecnicos, CreadoPor)
    *
    * @return Devuelve, en caso de modificar un registro de valores de unidades en uso, un 1 y,
    *         si falla, devuelve False.
    */
    public function ModificarValoresUnidades($params){
        if (is_array($params)) 
        {
            $updateStatement = $this->update(array('NumeroUsoArranque' => $params[0],
                                                   'ValorFABAA' => $params[1],
                                                   'ValorFABAB' => $params[2],
                                                   'ValorFABAC' => $params[3],
                                                   'ValorNBUAltaFrec' => $params[4],
                                                   'ValorNBUBajaFrec' => $params[5],
                                                   'PMO' => $params[6],
                                                   'UGastos' => $params[7],
                                                   'UHonorarios' => $params[8],
                                                   'Recibos' => $params[9],
                                                   'Etiquetas' => $params[10],
                                                   'Tarjetas' => $params[11],
                                                   'ValorPracticaMinima' => $params[12],
                                                   'ExtraccionDomicilio' => $params[13],
                                                   'ActoProfesionalBioquimico' => $params[14],
                                                   'ValorMontoMaximo' => $params[15],
                                                   'NumeradorDerivaciones' => $params[16],
                                                   'SeccionFormulaHemograma' => $params[17],
                                                   'PosicionSeccion' => $params[18],
                                                   //'PracticasComponentes' => $params[14],
                                                   'DecodificarNemotecnicos' => $params[19],
                                                   'ModificadoPor' => $params[20],
                                                   'ModificadoFecha' => date('Y-m-d H:i:s')))
                                    ->table('ValoresUnidades');

            $modifId = $updateStatement->execute();

            if ($modifId) 
            {
                return $modifId;
            }
            else
            {
                return FALSE;
            }
        }
    }

    public function ExisteValoresUnidades($id){
        if ($id) 
        {
            $selectStatement = $this->select(array('NumeroUsoArranque', 
                                                   'ValorFABAA', 
                                                   'ValorFABAB', 
                                                   'ValorFABAC', 
                                                   'ValorNBUAltaFrec', 
                                                   'ValorNBUBajaFrec', 
                                                   'PMO', 
                                                   'UGastos', 
                                                   'UHonorarios', 
                                                   'Recibos', 
                                                   'Etiquetas', 
                                                   'Tarjetas', 
                                                   'ValorPracticaMinima', 
                                                   'ExtraccionDomicilio', 
                                                   'ActoProfesionalBioquimico', 
                                                   'ValorMontoMaximo', 
                                                   'NumeradorDerivaciones', 
                                                   'SeccionFormulaHemograma', 
                                                   'PosicionSeccion', 
                                                   /*'PracticasComponentes',*/ 
                                                   'DecodificarNemotecnicos'))
                                    ->from('ValoresUnidades')
                                    ->where('Id', '=', $id)
                                    ->where('EstaBorrado', '=', (int) 0);

            $stmt = $selectStatement->execute();
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
}