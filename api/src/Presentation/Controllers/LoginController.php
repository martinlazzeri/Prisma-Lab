<?php

namespace App\Presentation\Controllers;

use App\Presentation\Contracts\BaseController;
use App\Presentation\DTOs\UserDTO;
use App\Business\Services\LoginService;
use App\Helpers\RequiredParamsHelper;

/**
 * This class models a LoginController
*/
class LoginController extends BaseController{

  /**
	 * LoginService
	 *
	 * @access private
	 * @var object
	*/
	private $loginService;

  /**
	 * RequiredParamsHelper
	 *
	 * @access private
	 * @var object
	*/
	private $requiredParamsHelper;

	/** 
	 * LoginController class constructor 
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->loginService = new LoginService($this->container);
		$this->requiredParamsHelper = new RequiredParamsHelper($this->container);
	}

	/** 
	 * User login
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Login($request, $response){
		$result = array();
		$requestedParams = array ('username', 'password');
		$var = $request->getheader('Authorization');
		$token = explode(" ", $var[0]);
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if(!$processParams['Error']){
		  $data = $request->getParsedBody();
		  $user = $this->loginService->Login($data['username'], $data['password'], $token[1]);

		  if(!is_null($user)){
				$result['Data'] = (new UserDTO((array) json_decode($user)))->Expose();
				$newResponse = $response->withJson($result, 200);
		  } else {
				$newResponse = $response->withStatus(404);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}

	/** 
	 * Logout
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Logout($request, $response){
		$result = array();
		$url = $this->loginService->Logout();
		$result['Data'] = $url;
		$newResponse = $response->withJson($result, 200);

		return $newResponse;
	}
}