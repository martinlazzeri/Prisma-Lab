<?php
namespace App\DataAccess\Repositories;

use App\DataAccess\Contracts\BaseModel;
use App\DataAccess\Contracts\IAuditRepository;
use App\DataAccess\Entities\Audit;

/**
 * This class models an AuditRepository
*/
class AuditRepository extends BaseModel implements IAuditRepository{

	/**
   * AuditRepository class constructor
   *
   * @param \Slim\Container $container
  */
	public function __construct($container){
		parent::__construct($container);
	}

	/**
   * Sets the database table name
   *
   * @return string
  */
	public function GetSource(){
		return "Audits";
	}

  /**
   * Adds an audit
   *
   * @param string $action
   * @param string $username
   *
  */
  public function Add($action, $username){
    $this->Insert(array('PHP_SELF' => $_SERVER['PHP_SELF'],
                        'ARGV' => $_SERVER['argv'],
                        'ARGC' => $_SERVER['argc'],
                        'GATEWAY_INTERFACE' => $_SERVER['GATEWAY_INTERFACE'],
                        'SERVER_ADDR' => $_SERVER['SERVER_ADDR'],
                        'SERVER_NAME' => $_SERVER['SERVER_NAME'],
                        'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'],
                        'SERVER_PROTOCOL' => $_SERVER['SERVER_PROTOCOL'],
                        'REQUEST_METHOD' => $_SERVER['REQUEST_METHOD'],
                        'REQUEST_TIME' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
                        'REQUEST_TIME_FLOAT' => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME_FLOAT']),
                        'QUERY_STRING' => $_SERVER['QUERY_STRING'],
                        'DOCUMENT_ROOT' => $_SERVER['DOCUMENT_ROOT'],
                        'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
                        'HTTP_ACCEPT_CHARSET' => $_SERVER['HTTP_ACCEPT_CHARSET'],
                        'HTTP_ACCEPT_ENCODING' => $_SERVER['HTTP_ACCEPT_ENCODING'],
                        'HTTP_ACCEPT_LANGUAGE' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                        'HTTP_CONNECTION' => $_SERVER['HTTP_CONNECTION'],
                        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
                        'HTTP_REFERER' => $_SERVER['HTTP_REFERER'],
                        'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
                        'HTTPS' => $_SERVER['HTTPS'],
                        'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
                        'REMOTE_HOST' => $_SERVER['REMOTE_HOST'],
                        'REMOTE_PORT' => $_SERVER['REMOTE_PORT'],
                        'REMOTE_USER' => $_SERVER['REMOTE_USER'],
                        'REDIRECT_REMOTE_USER' => $_SERVER['REDIRECT_REMOTE_USER'],
                        'SCRIPT_FILENAME' => $_SERVER['SCRIPT_FILENAME'],
                        'SERVER_ADMIN' => $_SERVER['SERVER_ADMIN'],
                        'SERVER_PORT' => $_SERVER['SERVER_PORT'],
                        'SERVER_SIGNATURE' => $_SERVER['SERVER_SIGNATURE'],
                        'PATH_TRANSLATED' => $_SERVER['PATH_TRANSLATED'],
                        'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'],
                        'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                        'PHP_AUTH_DIGEST' => $_SERVER['PHP_AUTH_DIGEST'],
                        'PHP_AUTH_USER' => $_SERVER['PHP_AUTH_USER'],
                        'PHP_AUTH_PW' => $_SERVER['PHP_AUTH_PW'],
                        'AUTH_TYPE' => $_SERVER['AUTH_TYPE'],
                        'PATH_INFO' => $_SERVER['PATH_INFO'],
                        'ORIG_PATH_INFO' => $_SERVER['ORIG_PATH_INFO'],
                        'OperatingSystem' => php_uname(),
                        'Action' => $action,
                        'CreatedBy' => $username,
                        'CreatedDate' => date('Y-m-d H:i:s')));
  }

	/**
   * Gets all audits
   *
   * @return mixed (array or null)
  */
	public function GetAll(){
    $result = array();
    $audits =  $this->Query('SELECT Id, 
                                    PHP_SELF,
                                    ARGV,
                                    ARGC,
                                    GATEWAY_INTERFACE,
                                    SERVER_ADDR,
                                    SERVER_NAME,
                                    SERVER_SOFTWARE,
                                    SERVER_PROTOCOL,
                                    REQUEST_METHOD,
                                    REQUEST_TIME,
                                    REQUEST_TIME_FLOAT,
                                    QUERY_STRING,  
                                    DOCUMENT_ROOT,     
                                    HTTP_ACCEPT,
                                    HTTP_ACCEPT_CHARSET,
                                    HTTP_ACCEPT_ENCODING,
                                    HTTP_ACCEPT_LANGUAGE,
                                    HTTP_CONNECTION,
                                    HTTP_HOST,
                                    HTTP_REFERER,
                                    HTTP_USER_AGENT,
                                    HTTPS,  
                                    REMOTE_ADDR,  
                                    REMOTE_HOST,
                                    REMOTE_PORT,
                                    REMOTE_USER,
                                    REDIRECT_REMOTE_USER,
                                    SCRIPT_FILENAME,
                                    SERVER_ADMIN,
                                    SERVER_PORT,
                                    SERVER_SIGNATURE,
                                    PATH_TRANSLATED,  
                                    SCRIPT_NAME,  
                                    REQUEST_URL,
                                    PHP_AUTH_DIGEST,
                                    PHP_AUTH_USER,
                                    PHP_AUTH_PW,
                                    AUTH_TYPE,
                                    PATH_INFO,
                                    ORIG_PATH_INFO,
                                    OperatingSystem,
                                    Action,
                                    CreatedBy,  
                                    CreatedDate                                                                                                       
                             FROM Audits 
                             ORDER BY CreatedDate');

    if (!(empty($audits) || (is_null($audits)))){
      foreach ($audits as $audit){
        $result[] =  (new Audit($audit))->Expose();
      }

      return $result;
    } else {
      return null;
    }
	}

  /**
   * Gets an audit by its id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id){
    $audit = $this->Select(array('Id', 
                                 'PHP_SELF',
                                 'ARGV',
                                 'ARGC',
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
                                 'REQUEST_URL',
                                 'PHP_AUTH_DIGEST',
                                 'PHP_AUTH_USER',
                                 'PHP_AUTH_PW',
                                 'AUTH_TYPE',
                                 'PATH_INFO',
                                 'ORIG_PATH_INFO',
                                 'OperatingSystem',
                                 'Action',
                                 'CreatedBy',  
                                 'CreatedDate'), 
                           array('Id' => $id));
    
    if (!(empty($audit) || (is_null($audit)))){
      $newAudit = (new Audit($audit[0]))->Expose();

      return $newAudit;
    } else {
      return null;
    }
  }

  /**
   * Gets audits by dates
   *
   * @param string $initialDate
   * @param string $endDate
   *
   * @return mixed (array or null)
  */
  public function GetByDate($initialDate, $endDate){
    $result = array();
    $audits =  $this->Query('SELECT Id, 
                                    PHP_SELF,
                                    ARGV,
                                    ARGC,
                                    GATEWAY_INTERFACE,
                                    SERVER_ADDR,
                                    SERVER_NAME,
                                    SERVER_SOFTWARE,
                                    SERVER_PROTOCOL,
                                    REQUEST_METHOD,
                                    REQUEST_TIME,
                                    REQUEST_TIME_FLOAT,
                                    QUERY_STRING,  
                                    DOCUMENT_ROOT,     
                                    HTTP_ACCEPT,
                                    HTTP_ACCEPT_CHARSET,
                                    HTTP_ACCEPT_ENCODING,
                                    HTTP_ACCEPT_LANGUAGE,
                                    HTTP_CONNECTION,
                                    HTTP_HOST,
                                    HTTP_REFERER,
                                    HTTP_USER_AGENT,
                                    HTTPS,  
                                    REMOTE_ADDR,  
                                    REMOTE_HOST,
                                    REMOTE_PORT,
                                    REMOTE_USER,
                                    REDIRECT_REMOTE_USER,
                                    SCRIPT_FILENAME,
                                    SERVER_ADMIN,
                                    SERVER_PORT,
                                    SERVER_SIGNATURE,
                                    PATH_TRANSLATED,  
                                    SCRIPT_NAME,  
                                    REQUEST_URL,
                                    PHP_AUTH_DIGEST,
                                    PHP_AUTH_USER,
                                    PHP_AUTH_PW,
                                    AUTH_TYPE,
                                    PATH_INFO,
                                    ORIG_PATH_INFO,
                                    OperatingSystem,
                                    Action,
                                    CreatedBy,  
                                    CreatedDate                                                                                                     
                             FROM Audits
                             WHERE CAST(CreatedDate AS date) BETWEEN \'' . $initialDate . '\'  AND  \'' . $endDate . '\' 
                             ORDER BY CreatedDate ');

    if (!(empty($audits) || (is_null($audits)))){
      foreach ($audits as $audit){
        $result[] = (new Audit($audit))->Expose();
      }
      
      return $result;
    } else {
      return null;
    }
  }
}