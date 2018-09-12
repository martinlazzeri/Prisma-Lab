<?php

namespace App\DataAccess\Entities;

/**
* Audit class
*/  
class Audit{

	/**
	 * Id
	 *
	 * @access private
	 * @var int
	*/
	private $id;

	/**
	 * The name of the script file currently running
	 *
	 * @access private
	 * @var string
	*/
	private $php_self;

	/**
	 * Array of the arguments sent to the script
	 *
	 * @access private
	 * @var string
	*/
	private $argv;

	/**
	 * Number of command line parameters sent to the script
	 *
	 * @access private
	 * @var int
	*/
	private $argc;

	/**
	 * Revision number of the CGI specification
	 *
	 * @access private
	 * @var string
	*/
	private $gateway_interface;

	/**
	 * The IP address of the server
	 *
	 * @access private
	 * @var string
	*/
	private $server_addr;

	/**
	 * The host name of the server
	 *
	 * @access private
	 * @var string
	*/
	private $server_name;

	/**
	 * Server identification string
	 *
	 * @access private
	 * @var string
	*/
	private $server_software;

	/**
	 * Name and revision number of the information protocol through which the page is requested
	 *
	 * @access private
	 * @var string
	*/
	private $server_protocol;

	/**
	 * Method of request used to access the page
	 *
	 * @access private
	 * @var string
	*/
	private $request_method;

	/**
	 * Unix date of request initiation
	 *
	 * @access private
	 * @var datetime
	*/
	private $request_time;

	/**
	 * The timestamp of the start of the request, with microsecond precision
	 *
	 * @access private
	 * @var datetime
	*/
	private $request_time_float;

	/**
	 * Query string of the page request
	 *
	 * @access private
	 * @var string
	*/
	private $query_string;

	/**
	 * The server's document root directory
	 *
	 * @access private
	 * @var string
	*/
	private $document_root;

	/**
	 * Content of the Accept header
	 *
	 * @access private
	 * @var string
	*/
	private $http_accept;

	/**
	 * Content of the Accept-Charset header
	 *
	 * @access private
	 * @var string
	*/
	private $http_accept_charset;

	/**
	 * Content of the Accept-Encoding header
	 *
	 * @access private
	 * @var string
	*/
	private $http_accept_encoding;

	/**
	 * Content of the Accept-Language header
	 *
	 * @access private
	 * @var string
	*/
	private $http_accept_language;

	/**
	 * Contents of the Connection header
	 *
	 * @access private
	 * @var string
	*/
	private $http_connection;

	/**
	 * Content of the Host header
	 *
	 * @access private
	 * @var string
	*/
	private $http_host;

	/**
	 * Address of the page (if any) used by the user agent for the current page
	 *
	 * @access private
	 * @var string
	*/
	private $http_referer;

	/**
	 * Content of the User-Agent header
	 *
	 * @access private
	 * @var string
	*/
	private $http_user_agent;

	/**
	 * It offers a non-empty value if the script is requested through the HTTPS protocol
	 *
	 * @access private
	 * @var bit
	*/
	private $https;

	/**
	 * The IP address from which the user is viewing the current page
	 *
	 * @access private
	 * @var string
	*/
	private $remote_addr;

	/**
	 * The name of the host from which the user is viewing the current page
	 *
	 * @access private
	 * @var string
	*/
	private $remote_host;

	/**
	 * The port used by the user's machine to communicate with the web server
	 *
	 * @access private
	 * @var string
	*/
	private $remote_port;

	/**
	 * The authenticated user
	 *
	 * @access private
	 * @var string
	*/
	private $remote_user;

	/**
	 * The authenticated user if the request is redirected internally
	 *
	 * @access private
	 * @var string
	*/
	private $redirect_remote_user;

	/**
	 * The path of the script currently running in absolute
	 *
	 * @access private
	 * @var string
	*/
	private $script_filename;

	/**
	 * The value given to the server_admin directive in the web server configuration file
	 *
	 * @access private
	 * @var string
	*/
	private $server_admin;

	/**
	 * The port of the server machine used by the web server for communication
	 *
	 * @access private
	 * @var int
	*/
	private $server_port;

	/**
	 * String that contains the server version and the name of the virtual host
	 *
	 * @access private
	 * @var string
	*/
	private $server_signature;

	/**
	 * System-based path of the current script
	 *
	 * @access private
	 * @var string
	*/
	private $path_translated;

	/**
	 * Current script path
	 *
	 * @access private
	 * @var string
	*/
	private $script_name;

	/**
	 * URI that was used to access the page
	 *
	 * @access private
	 * @var string
	*/
	private $request_url;

	/**
	 * Is set for the 'Authorization' header sent by the client
	 *
	 * @access private
	 * @var string
	*/
	private $php_auth_digest;

	/**
	 * Is set for the username provided by the user
	 *
	 * @access private
	 * @var string
	*/
	private $php_auth_user;

	/**
	 * Is set for the key provided by the user
	 *
	 * @access private
	 * @var string
	*/
	private $php_auth_pw;

	/**
	 * Is set for the authentication type
	 *
	 * @access private
	 * @var string
	*/
	private $auth_type;

	/**
	 * Contains any information about the route provided by the client
	 *
	 * @access private
	 * @var string
	*/
	private $path_info;

	/**
	 * Original version of 'path_info' before being processed by PHP.
	 *
	 * @access private
	 * @var string
	*/
	private $orig_path_info;

	/**
	 * Operatingsystem
	 *
	 * @access private
	 * @var string
	*/
	private $operatingsystem;

	/**
	 * Action
	 *
	 * @access private
	 * @var string
	*/
	private $action;

	/**
	 * CreatedBy
	 *
	 * @access private
	 * @var string
	*/
	private $createdBy;

	/**
	 * CreatedDate
	 *
	 * @access private
	 * @var datetime
	*/
	private $createdDate;

	/**
	 * Audit class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($audit){
		$this->id = $audit['Id'];
		$this->php_self = $audit['PHP_SELF'];
		$this->argv = $audit['ARGV'];
		$this->argc = $audit['ARGC'];
		$this->gateway_interface = $audit['GATEWAY_INTERFACE'];
		$this->server_addr = $audit['SERVER_ADDR'];
		$this->server_name = $audit['SERVER_NAME'];
		$this->server_software = $audit['SERVER_SOFTWARE'];
		$this->server_protocol = $audit['SERVER_PROTOCOL'];
		$this->request_method = $audit['REQUEST_METHOD'];
		$this->request_time = $audit['REQUEST_TIME'];
		$this->request_time_float = $audit['REQUEST_TIME_FLOAT'];
		$this->query_string = $audit['QUERY_STRING'];
		$this->document_root = $audit['DOCUMENT_ROOT'];
		$this->http_accept = $audit['HTTP_ACCEPT'];
		$this->http_accept_charset = $audit['HTTP_ACCEPT_CHARSET'];
		$this->http_accept_encoding = $audit['HTTP_ACCEPT_ENCODING'];
		$this->http_accept_language = $audit['HTTP_ACCEPT_LANGUAGE'];
		$this->http_connection = $audit['HTTP_CONNECTION'];
		$this->http_host = $audit['HTTP_HOST'];
		$this->http_referer = $audit['HTTP_REFERER'];
		$this->http_user_agent = $audit['HTTP_USER_AGENT'];
		$this->https = $audit['HTTPS'];
		$this->remote_addr = $audit['REMOTE_ADDR'];
		$this->remote_host = $audit['REMOTE_HOST'];
		$this->remote_port = $audit['REMOTE_PORT'];
		$this->remote_user = $audit['REMOTE_USER'];
		$this->redirect_remote_user = $audit['REDIRECT_REMOTE_USER'];
		$this->script_filename = $audit['SCRIPT_FILENAME'];
		$this->server_admin = $audit['SERVER_ADMIN'];
		$this->server_port = $audit['SERVER_PORT'];
		$this->server_signature = $audit['SERVER_SIGNATURE'];
		$this->path_translated = $audit['PATH_TRANSLATED'];
		$this->script_name = $audit['SCRIPT_NAME'];
		$this->request_url = $audit['REQUEST_URL'];
		$this->php_auth_digest = $audit['PHP_AUTH_DIGEST'];
		$this->php_auth_user = $audit['PHP_AUTH_USER'];
		$this->php_auth_pw = $audit['PHP_AUTH_PW'];
		$this->auth_type = $audit['AUTH_TYPE'];
		$this->path_info = $audit['PATH_INFO'];
		$this->orig_path_info = $audit['ORIG_PATH_INFO'];
		$this->operatingsystem = $audit['OperatingSystem'];
		$this->action = $audit['Action'];
		$this->createdBy = $audit['CreatedBy'];
		$this->createdDate = $audit['CreatedDate'];
	}

	/**
	 * Sets the php_self
	 *
	 * @param string $php_self
	 *
	 * @return void
	*/
	public function SetPHP_SELF($php_self){
		$this->php_self = $php_self;
	}

	/**
	 * Sets the argv
	 *
	 * @param string $argv
	 *
	 * @return void
	*/
	public function SetARGV($argv){
		$this->argv = $argv;
	}

	/**
	 * Sets the argc
	 *
	 * @param int $argc
	 *
	 * @return void
	*/
	public function SetARGC($argc){
		$this->argc = $argc;
	}

	/**
	 * Sets the gateway_interface
	 *
	 * @param string $gateway_interface
	 *
	 * @return void
	*/
	public function SetGATEWAY_INTERFACE($gateway_interface){
		$this->gateway_interface = $gateway_interface;
	}

	/**
	 * Sets the server_addr
	 *
	 * @param string $server_addr
	 *
	 * @return void
	*/
	public function SetSERVER_ADDR($server_addr){
		$this->server_addr = $server_addr;
	}

	/**
	 * Sets the server_name
	 *
	 * @param string $server_name
	 *
	 * @return void
	*/
	public function SetSERVER_NAME($server_name){
		$this->server_name = $server_name;
	}

	/**
	 * Sets the server_software
	 *
	 * @param string $server_software
	 *
	 * @return void
	*/
	public function SetSERVER_SOFTWARE($server_software){
		$this->server_software = $server_software;
	}

	/**
	 * Sets the server_protocol
	 *
	 * @param string $server_protocol
	 *
	 * @return void
	*/
	public function SetSERVER_PROTOCOL($server_protocol){
		$this->server_protocol = $server_protocol;
	}

	/**
	 * Sets the request_method
	 *
	 * @param string $request_method
	 *
	 * @return void
	*/
	public function SetREQUEST_METHOD($request_method){
		$this->request_method = $request_method;
	}

	/**
	 * Sets the request_time
	 *
	 * @param datetime $request_time
	 *
	 * @return void
	*/
	public function SetREQUEST_TIME($request_time){
		$this->request_time = $request_time;
	}

	/**
	 * Sets the request_time_float
	 *
	 * @param datetime $request_time_float
	 *
	 * @return void
	*/
	public function SetREQUEST_TIME_FLOAT($request_time_float){
		$this->request_time_float = $request_time_float;
	}

	/**
	 * Sets the query_string
	 *
	 * @param string $query_string
	 *
	 * @return void
	*/
	public function SetQUERY_STRING($query_string){
		$this->query_string = $query_string;
	}

	/**
	 * Sets the document_root
	 *
	 * @param string $document_root
	 *
	 * @return void
	*/
	public function SetDOCUMENT_ROOT($document_root){
		$this->document_root = $document_root;
	}

	/**
	 * Sets the http_accept
	 *
	 * @param string $http_accept
	 *
	 * @return void
	*/
	public function SetHTTP_ACCEPT($http_accept){
		$this->http_accept = $http_accept;
	}

	/**
	 * Sets the http_accept_charset
	 *
	 * @param string $http_accept_charset
	 *
	 * @return void
	*/
	public function SetHTTP_ACCEPT_CHARSET($http_accept_charset){
		$this->http_accept_charset = $http_accept_charset;
	}

	/**
	 * Sets the http_accept_encoding
	 *
	 * @param string $http_accept_encoding
	 *
	 * @return void
	*/
	public function SetHTTP_ACCEPT_ENCODING($http_accept_encoding){
		$this->php_self = $http_accept_encoding;
	}

	/**
	 * Sets the http_accept_language
	 *
	 * @param string $http_accept_language
	 *
	 * @return void
	*/
	public function SetHTTP_ACCEPT_LANGUAGE($http_accept_language){
		$this->http_accept_language = $http_accept_language;
	}

	/**
	 * Sets the http_connection
	 *
	 * @param string $http_connection
	 *
	 * @return void
	*/
	public function SetHTTP_CONNECTION($http_connection){
		$this->http_connection = $http_connection;
	}

	/**
	 * Sets the http_host
	 *
	 * @param string $http_host
	 *
	 * @return void
	*/
	public function SetHTTP_HOST($http_host){
		$this->http_host = $http_host;
	}

	/**
	 * Sets the http_referer
	 *
	 * @param string $http_referer
	 *
	 * @return void
	*/
	public function SetHTTP_REFERER($http_referer){
		$this->http_referer = $http_referer;
	}

	/**
	 * Sets the http_user_agent
	 *
	 * @param string $http_user_agent
	 *
	 * @return void
	*/
	public function SetHTTP_USER_AGENT($http_user_agent){
		$this->http_user_agent = $http_user_agent;
	}

	/**
	 * Sets the https
	 *
	 * @param bit $https
	 *
	 * @return void
	*/
	public function SetHTTPS($https){
		$this->https = $https;
	}

	/**
	 * Sets the remote_addr
	 *
	 * @param string $remote_addr
	 *
	 * @return void
	*/
	public function SetREMOTE_ADDR($remote_addr){
		$this->remote_addr = $remote_addr;
	}

	/**
	 * Sets the remote_host
	 *
	 * @param string $remote_host
	 *
	 * @return void
	*/
	public function SetREMOTE_HOST($remote_host){
		$this->remote_host = $remote_host;
	}

	/**
	 * Sets the remote_port
	 *
	 * @param string $remote_port
	 *
	 * @return void
	*/
	public function SetREMOTE_PORT($remote_port){
		$this->remote_port = $remote_port;
	}

	/**
	 * Sets the remote_user
	 *
	 * @param string $remote_user
	 *
	 * @return void
	*/
	public function SetREMOTE_USER($remote_user){
		$this->remote_user = $remote_user;
	}

	/**
	 * Sets the redirect_remote_user
	 *
	 * @param string $redirect_remote_user
	 *
	 * @return void
	*/
	public function SetREDIRECT_REMOTE_USER($redirect_remote_user){
		$this->redirect_remote_user = $redirect_remote_user;
	}

	/**
	 * Sets the script_filename
	 *
	 * @param string $script_filename
	 *
	 * @return void
	*/
	public function SetSCRIPT_FILENAME($script_filename){
		$this->script_filename = $script_filename;
	}

	/**
	 * Sets the server_admin
	 *
	 * @param string $server_admin
	 *
	 * @return void
	*/
	public function SetSERVER_ADMIN($server_admin){
		$this->server_admin = $server_admin;
	}

	/**
	 * Sets the server_port
	 *
	 * @param int $server_port
	 *
	 * @return void
	*/
	public function SetSERVER_PORT($server_port){
		$this->server_port = $server_port;
	}

	/**
	 * Sets the server_signature
	 *
	 * @param string $server_signature
	 *
	 * @return void
	*/
	public function SetSERVER_SIGNATURE($server_signature){
		$this->server_signature = $server_signature;
	}

	/**
	 * Sets the path_translated
	 *
	 * @param string $path_translated
	 *
	 * @return void
	*/
	public function SetPATH_TRANSLATED($path_translated){
		$this->path_translated = $path_translated;
	}

	/**
	 * Sets the script_name
	 *
	 * @param string $script_name
	 *
	 * @return void
	*/
	public function SetSCRIPT_NAME($script_name){
		$this->script_name = $script_name;
	}

	/**
	 * Sets the request_url
	 *
	 * @param string $request_url
	 *
	 * @return void
	*/
	public function SetREQUEST_URL($request_url){
		$this->request_url = $request_url;
	}

	/**
	 * Sets the php_auth_digest
	 *
	 * @param string $php_auth_digest
	 *
	 * @return void
	*/
	public function SetPHP_AUTH_DIGEST($php_auth_digest){
		$this->php_auth_digest = $php_auth_digest;
	}

	/**
	 * Sets the php_auth_user
	 *
	 * @param string $php_auth_user
	 *
	 * @return void
	*/
	public function SetPHP_AUTH_USER($php_auth_user){
		$this->php_auth_user = $php_auth_user;
	}

	/**
	 * Sets the php_auth_pw
	 *
	 * @param string $php_auth_pw
	 *
	 * @return void
	*/
	public function SetPHP_AUTH_PW($php_auth_pw){
		$this->php_auth_pw = $php_auth_pw;
	}

	/**
	 * Sets the auth_type
	 *
	 * @param string $auth_type
	 *
	 * @return void
	*/
	public function SetAUTH_TYPE($auth_type){
		$this->auth_type = $auth_type;
	}

	/**
	 * Sets the path_info
	 *
	 * @param string $path_info
	 *
	 * @return void
	*/
	public function SetPATH_INFO($path_info){
		$this->path_info = $path_info;
	}

	/**
	 * Sets the orig_path_info
	 *
	 * @param string $orig_path_info
	 *
	 * @return void
	*/
	public function SetORIG_PATH_INFO($orig_path_info){
		$this->orig_path_info = $orig_path_info;
	}

	/**
	 * Sets the operatingsystem
	 *
	 * @param string $operatingsystem
	 *
	 * @return void
	*/
	public function SetOperatingsSystem($operatingsystem){
		$this->operatingsystem = $operatingsystem;
	}

	/**
	 * Sets the action
	 *
	 * @param string $action
	 *
	 * @return void
	*/
	public function SetAction($action){
		$this->action = $action;
	}

	/**
	 * Sets the createdBy
	 *
	 * @param string $createdBy
	 *
	 * @return void
	*/
	public function SetCreatedBy($createdBy){
		$this->createdBy = $createdBy;
	}

	/**
	 * Sets the createdDate
	 *
	 * @param datetime $createdDate
	 *
	 * @return void
	*/
	public function SetCreatedDate($createdDate){
		$this->createdDate = $createdDate;
	}

	/**
	 * Gets the php_self
	 *
	 * @return string
	*/
	public function GetPHP_SELF($php_self){
		return $this->php_self;
	}

	/**
	 * Gets the argv
	 *
	 * @return string
	*/
	public function GetARGV($argv){
		return $this->argv;
	}

	/**
	 * Gets the argc
	 *
	 * @return int
	*/
	public function GetARGC($argc){
		return $this->argc;
	}

	/**
	 * Gets the gateway_interface
	 *
	 * @return string
	*/
	public function GetGATEWAY_INTERFACE($gateway_interface){
		return $this->gateway_interface;
	}

	/**
	 * Gets the server_addr
	 *
	 * @return string
	*/
	public function GetSERVER_ADDR($server_addr){
		return $this->server_addr;
	}

	/**
	 * Gets the server_name
	 *
	 * @return string
	*/
	public function GetSERVER_NAME($server_name){
		return $this->server_name;
	}

	/**
	 * Gets the server_software
	 *
	 * @return string
	*/
	public function GetSERVER_SOFTWARE($server_software){
		return $this->server_software;
	}

	/**
	 * Gets the server_protocol
	 *
	 * @return string
	*/
	public function GetSERVER_PROTOCOL($server_protocol){
		return $this->server_protocol;
	}

	/**
	 * Gets the request_method
	 *
	 * @return string
	*/
	public function GetREQUEST_METHOD($request_method){
		return $this->request_method;
	}

	/**
	 * Gets the request_time
	 *
	 * @return datetime
	*/
	public function GetREQUEST_TIME($request_time){
		return $this->request_time;
	}

	/**
	 * Gets the request_time_float
	 *
	 * @return datetime
	*/
	public function GetREQUEST_TIME_FLOAT($request_time_float){
		return $this->request_time_float;
	}

	/**
	 * Gets the query_string
	 *
	 * @return string
	*/
	public function GetQUERY_STRING($query_string){
		return $this->query_string;
	}

	/**
	 * Gets the document_root
	 *
	 * @return string
	*/
	public function GetDOCUMENT_ROOT($document_root){
		return $this->document_root;
	}

	/**
	 * Gets the http_accept
	 *
	 * @return string
	*/
	public function GetHTTP_ACCEPT($http_accept){
		return $this->http_accept;
	}

	/**
	 * Gets the http_accept_charset
	 *
	 * @return string
	*/
	public function GetHTTP_ACCEPT_CHARSET($http_accept_charset){
		return $this->http_accept_charset;
	}

	/**
	 * Gets the http_accept_encoding
	 *
	 * @return string
	*/
	public function GetHTTP_ACCEPT_ENCODING($http_accept_encoding){
		return $this->http_accept_encoding;
	}

	/**
	 * Gets the http_accept_language
	 *
	 * @return string
	*/
	public function GetHTTP_ACCEPT_LANGUAGE($http_accept_language){
		return $this->http_accept_language;
	}

	/**
	 * Gets the http_connection
	 *
	 * @return string
	*/
	public function GetHTTP_CONNECTION($http_connection){
		return $this->http_connection;
	}

	/**
	 * Gets the http_host
	 *
	 * @return string
	*/
	public function GetHTTP_HOST($http_host){
		return $this->http_host;
	}

	/**
	 * Gets the http_referer
	 *
	 * @return string
	*/
	public function GetHTTP_REFERER($http_referer){
		return $this->http_referer;
	}

	/**
	 * Gets the http_user_agent
	 *
	 * @return string
	*/
	public function GetHTTP_USER_AGENT($http_user_agent){
		return $this->http_user_agent;
	}

	/**
	 * Gets the https
	 *
	 * @return bit
	*/
	public function GetHTTPS($https){
		return $this->https;
	}

	/**
	 * Gets the remote_addr
	 *
	 * @return string
	*/
	public function GetREMOTE_ADDR($remote_addr){
		return $this->remote_addr;
	}

	/**
	 * Gets the remote_host
	 *
	 * @return string
	*/
	public function GetREMOTE_HOST($remote_host){
		return $this->remote_host;
	}

	/**
	 * Gets the remote_port
	 *
	 * @return string
	*/
	public function GetREMOTE_PORT($remote_port){
		return $this->remote_port;
	}

	/**
	 * Gets the remote_user
	 *
	 * @return string
	*/
	public function GetREMOTE_USER($remote_user){
		return $this->remote_user;
	}

	/**
	 * Gets the redirect_remote_user
	 *
	 * @return string
	*/
	public function GetREDIRECT_REMOTE_USER($redirect_remote_user){
		return $this->redirect_remote_user;
	}

	/**
	 * Gets the script_filename
	 *
	 * @return string
	*/
	public function GetSCRIPT_FILENAME($script_filename){
		return $this->script_filename;
	}

	/**
	 * Gets the server_admin
	 *
	 * @return string
	*/
	public function GetSERVER_ADMIN($server_admin){
		return $this->server_admin;
	}

	/**
	 * Gets the server_port
	 *
	 * @return int
	*/
	public function GetSERVER_PORT($server_port){
		return $this->server_port;
	}

	/**
	 * Gets the server_signature
	 *
	 * @return string
	*/
	public function GetSERVER_SIGNATURE($server_signature){
		return $this->server_signature;
	}

	/**
	 * Gets the path_translated
	 *
	 * @return string
	*/
	public function GetPATH_TRANSLATED($path_translated){
		return $this->path_translated;
	}

	/**
	 * Gets the script_name
	 *
	 * @return string
	*/
	public function GetSCRIPT_NAME($script_name){
		return $this->script_name;
	}

	/**
	 * Gets the request_url
	 *
	 * @return string
	*/
	public function GetREQUEST_URL($request_url){
		return $this->request_url;
	}

	/**
	 * Gets the php_auth_digest
	 *
	 * @return string
	*/
	public function GetPHP_AUTH_DIGEST($php_auth_digest){
		return $this->php_auth_digest;
	}

	/**
	 * Gets the php_auth_user
	 *
	 * @return string
	*/
	public function GetPHP_AUTH_USER($php_auth_user){
		return $this->php_auth_user;
	}

	/**
	 * Gets the php_auth_pw
	 *
	 * @return string
	*/
	public function GetPHP_AUTH_PW($php_auth_pw){
		return $this->php_auth_pw;
	}

	/**
	 * Gets the auth_type
	 *
	 * @return string
	*/
	public function GetAUTH_TYPE($auth_type){
		return $this->auth_type;
	}

	/**
	 * Gets the path_info
	 *
	 * @return string
	*/
	public function GetPATH_INFO($path_info){
		return $this->path_info;
	}

	/**
	 * Gets the orig_path_info
	 *
	 * @return string
	*/
	public function GetORIG_PATH_INFO($orig_path_info){
		return $this->orig_path_info;
	}

	/**
	 * Gets the operatingsystem
	 *
	 * @return string
	*/
	public function GetOperatingsSystem($operatingsystem){
		return $this->operatingsystem;
	}

	/**
	 * Gets the action
	 *
	 * @return string
	*/
	public function GetAction($action){
		return $this->action;
	}

	/**
	 * Gets the createdBy
	 *
	 * @return string
	*/
	public function GetCreatedBy($createdBy){
		return $this->createdBy;
	}

	/**
	 * Gets the createdDate
	 *
	 * @return datetime
	*/
	public function GetCreatedDate($createdDate){
		return $this->createdDate;
	}

	/**
	 * Gets the the audit object as a json
	 *
	 * @return json
	*/
	public function Expose(){
		return json_encode(get_object_vars($this));
	}
}