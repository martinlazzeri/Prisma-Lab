<?php

namespace App\Presentation\Controllers;

use App\Presentation\Contracts\BaseController;
use App\Presentation\DTOs\UserDTO;
use App\Business\Services\UserService;
use App\Helpers\RequiredParamsHelper;
/**
 * This class models an UserController
*/
class UserController extends BaseController{

  /**
	 * UserService
	 *
	 * @access private
	 * @var object
	*/
	private $userService;

  /**
	 * RequiredParamsHelper
	 *
	 * @access private
	 * @var object
	*/
	private $requiredParamsHelper;

	/** 
	 * UserController class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->userService = new UserService($this->container);
		$this->requiredParamsHelper = new RequiredParamsHelper($this->container);
	}

	/** 
	 * Adds an user
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param int $userId
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Add($request, $response, $userId){		
		$result = array();
		$requestedParams = array('username', 'password', 'email', 'firstname', 'lastname', 'birthdate', 'role'); 
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!$processParams['Error']){
		  $user = $request->getParsedBody();
		  $idUser = $this->userService->Add($user, $userId['userId']);
		  
		  if (!(is_null($idUser))){
				$result['Data'] = $idUser;
				$newResponse = $response->withJson($result, 201);
		  } else {
				$newResponse = $response->withStatus(409);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}

	/** 
	 * Checks if the username exists
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $username
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function CheckUsername($request, $response, $username){
		$userName = $this->userService->CheckUsername($username['username']);

		if($userName){
		  $result['Data'] = $userName;		
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $result['Message'] = 'El nombre de usuario ya existe';	
		  $result['Data'] = $userName;		
		  $newResponse = $response->withJson($result, 200);
		}

		return $newResponse;
	}

	/** 
	 * Checks if the email exists
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $email
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function CheckEmail($request, $response, $email){
		$eMail = $this->userService->CheckEmail($email['email']);

		if($eMail){
		  $result['Data'] = $eMail;
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $result['Message'] = 'El email ya existe o no es valido';			
		  $result['Data'] = $eMail;
		  $newResponse = $response->withJson($result, 200);
		}

		return $newResponse;
	}

	/** 
	 * Edits an user
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/	
	public function Edit($request, $response, $args){
		$result = array();
		$requestedParams = array('firstname', 'lastname', 'birthdate', 'role'); 

		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!($processParams['Error'])){
		  $updatedUser = $request->getParsedBody();
		  $userUpdate = $this->userService->Edit($updatedUser, $args['id'], $args['userId']);

		  if (!(is_null($userUpdate))){
				$result['Data'] = (new UserDTO((array) json_decode($userUpdate)))->Expose();
				$newResponse = $response->withJson($result, 201);
		  } else {
				$newResponse = $response->withStatus(409);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}

	/** 
	 * Gets users by filter
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
  public function GetByFilter($request, $response, $args){
  	$result = array();
  	$userArray = array();
  	$val = $request->getQueryParams();

  	if (empty($val)){
	  	$users = $this->userService->GetAll($args['userId']);
    } elseif (!empty($val['initialDate'] && $val['endDate'])){
			$users = $this->userService->GetByDate($val['initialDate'], $val['endDate'], $args['userId']);
    } else {
			$users = $this->userService->GetByPaginated($val['offset'], $val['limit'], $args['userId']);
    } 

  	if(!is_null($users)){
	  
	  	foreach ($users['Users'] as $user){
	  		$userArray[] = (new UserDTO((array) json_decode($user)))->Expose();
	  	}

	 	 	$result['Users'] = $userArray;	
	 	 	$result['Total'] = $users['Total'];	
	  	$newResponse = $response->withJson($result, 200);
		} else {
	  	$newResponse = $response->withStatus(404);
		}

		return $newResponse;
  }

	/** 
 	 * Gets an user by its id
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function GetById($request, $response, $args){		
		$user = $this->userService->GetById($args['id'], $args['userId']);

		if(!is_null($user)){
		  $result['Data'] = (new UserDTO((array) json_decode($user)))->Expose();			
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
	}

	/** 
 	 * Gets a token by its username
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $username
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function GetByUsername($request, $response, $username){		
		$user = $this->userService->GetByUsername($username['username']);

		if(!is_null($user)){
		  $result['Data'] = (new UserDTO((array) json_decode($user)))->Expose();			
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
	}

	/** 
	 * Removes an user
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Remove($request, $response, $args){
		$result = $this->userService->Remove($args['id'], $args['userId']);

		if (!(empty($result))){
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}	
		
		return $newResponse;
	} 

	/** 
	 * Gets all users that matches the search criteria
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Search($request, $response, $userId){	
		$result = array();	
		$requestedParams = array('searchCriteria');
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);
		
		if(!$processParams['Error']){
		  $criteria = $request->getParsedBody();
		  $userSearchs = $this->userService->Search($criteria['searchCriteria'], $userId['userId']);

		  if(!is_null($userSearchs)){
		  	
		  	foreach ($userSearchs as $userSearch){
          $results[] = (new UserDTO((array) json_decode($userSearch)))->Expose();
		    }

		  	$result['Users'] = $results;
		  	$newResponse = $response->withJson($result, 200);
		  } else {
		  	$newResponse = $response->withStatus(404);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}	
}