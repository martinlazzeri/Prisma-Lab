<?php

namespace App\Business\Services;

use App\Business\Contracts\BaseService;
use App\Business\Models\UserModel;
use App\DataAccess\Repositories\UserRepository;
use App\DataAccess\Repositories\AuditRepository;
use App\DataAccess\Repositories\OauthRepository;

/**
 * This class models a LoginService
*/
class LoginService extends BaseService{

  /**
   * UserRepository
   *
   * @access private
   * @var object
  */
	private $userRepository;

  /**
   * AuditRepository
   *
   * @access private
   * @var object
  */
  private $auditRepository;

  /**
   * OauthRepository
   *
   * @access private
   * @var object
  */
  private $oauthRepository;

	/** 
	 * LoginService class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->userRepository = new UserRepository($this->container);
		$this->auditRepository = new AuditRepository($this->container);
		$this->oauthRepository = new OauthRepository($this->container);
	}

	/** 
	 * User login
	 *
	 * @param string $username 
	 * @param string $password
	 * @param string $token
	 * 
	 * @return mixed (array or null)
	*/
	public function Login($username, $password, $token){
		$user_id = $this->oauthRepository->GetUserId($token);
		$user = $this->userRepository->GetUser($username, $password);
		
		if (!(is_null($user_id)) && $user_id == $username && !(is_null($user))){
		  $this->auditRepository->Add('Login', $username);

		  return (new UserModel((array) json_decode($user)))->Expose();
		} else {
		  return null;
		}
	}

	/** 
	 * Logout 
	 * 
	 * @return string
	*/
	public function Logout(){
		return $url = 'http://entity-studio.com/old/prismalab/login.php';
	}
}