<?php

namespace App\Business\Services;

use App\Business\Contracts\BaseService;
use App\Business\Contracts\IUserService;
use App\Business\Models\UserModel;
use App\DataAccess\Repositories\UserRepository;
use App\DataAccess\Repositories\AuditRepository;
use App\DataAccess\Repositories\OauthRepository;

/**
 * This class models an UserService
*/
class UserService extends BaseService implements IUserService{

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
	 * UserService class constructor
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
   * Adds an user
   *
   * @param array $user
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($user, $userId){
 		if (!($this->userRepository->UsernameExists($user['username']))  && ((!($this->userRepository->EmailExists($user['email'])) && $this->IsValidFormat($user['email'])) || ($user['email'] === '' || $user['email'] === null))){
		  $this->oauthRepository->AddOauthUser($user);

		  if($userId == 0){
		  	$this->auditRepository->Add('Users - Add', 'System');
		  	$idUser = $this->userRepository->Add($user, 'System');
		  } else {
				$userName = $this->userRepository->GetUsernameById($userId);
		  	$username = (array) json_decode($userName);	
		  	$this->auditRepository->Add('Users - Add', $username['username']);
			  $idUser = $this->userRepository->Add($user, $username['username']);
		  }

			return $idUser;
		} else {
			return null;
		}
	}

  /**
   * Checks if username exists
	 *
   * @param string $username
	 *
	 * @return bool
	*/
	public function CheckUsername($username, $userId){
		$userName = $this->userRepository->GetUsernameById($userId);
  	$Username = (array) json_decode($userName);	
		$this->auditRepository->Add('Users - CheckUsername', $Username['username']);

 		if (!($this->userRepository->UsernameExists($username))){
 		  return true;
 		} else {
 		  return false;
 		}
	}

  /**
   * Checks if email exists
	 *
   * @param string $email
	 *
	 * @return bool
	*/
	public function CheckEmail($email, $userId){
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);	
		$this->auditRepository->Add('Users - CheckEmail', $username['username']);
		
 		if (!($this->userRepository->EmailExists($email)) && $this->IsValidFormat($email)){
 		  return true;
 		} else {
 		  return false;
 		}
	}

	/** 
	 * Edits an user
	 *
	 * @param array $user
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($user, $id, $userId){
  	$old = $this->userRepository->GetById($id);
  	$oldUser = (array) json_decode($old);
  	
		if (!is_null($old)){

			$userName = $this->userRepository->GetUsernameById($userId);
		  $username = (array) json_decode($userName);
		  $this->auditRepository->Add('Users - Edit', $username['username']);
		  $this->userRepository->Edit($user, $id, $username['username']);
		  $this->oauthRepository->EditOauthUser($user);
		  $userUpdate = $this->userRepository->GetById($id);

		  return (new UserModel((array) json_decode($userUpdate)))->Expose();
		} else {
		  return null;
		}
	}

	/**
   * Gets users by paginated
   *
   * @param int $offset
   * @param int $limit
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit, $userId){
  	$result = array();
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);
  	$this->auditRepository->Add('Users - GetByPaginated', $username['username']);
  	$users = $this->userRepository->GetByPaginated($offset, $limit);
  	$result['Total'] = $this->userRepository->GetUsersCount()[0][0];
  	$usersArray = array();
  	
		if (!is_null($users)){
		  foreach ($users as $user){
		  	$usersArray[] = (new UserModel((array) json_decode($user)))->Expose();
		  }

		  $result['Users'] = $usersArray;

		  return $result;
		} else {
		  return null;
		}
  }

	/** 
	 * Gets all users
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId){
		$result = array();
		$users = $this->userRepository->GetAll();
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);
  	$this->auditRepository->Add('Users - GetAll', $username['username']);

		if (!is_null($users)){
		  foreach ($users as $user){
        	$result[] = (new UserModel((array) json_decode($user)))->Expose();
		  }

		  return $result;
		} else {
    	return null;
		}
	}

	/** 
	 * Gets an user by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId){
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
		$user = $this->userRepository->GetById($id);
    $this->auditRepository->Add('Users - GetById', $username['username']);

		if (!is_null($user)){
		  return (new UserModel((array) json_decode($user)))->Expose();
		} else {
		  return null;
		}
	}

	/** 
	 * Gets a token by username
	 *
	 * @param string $username
	 *
	 * @return mixed (array or null)
	*/
	public function GetByUsername($username){
		$user = $this->userRepository->GetByUsername($username);

		if (!is_null($user)){
		  return (new UserModel((array) json_decode($user)))->Expose();
		} else {
		  return null;
		}
	}

	/** 
	 * Removes an user
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId){
   	$user = $this->userRepository->GetById($id);
    $Username = (array) json_decode($user);
        
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
    
    if($Username['username'] == '' || $Username['username'] == null){
    	$this->auditRepository->Add('Users - Remove', $username['username']);
    	return $this->userRepository->Remove($id, $username['username']);
    } else if ($Username['username'] !== $username['username']) {
    	$this->oauthRepository->RemoveByUserId($Username['username']);
			$this->auditRepository->Add('Users - Remove', $username['username']);
			
			return $this->userRepository->Remove($id, $username['username']);
    } else {
    	return 0;
    }
  }

	/** 
	 * Gets all users that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId){
		$result = array();
		$userSearchs = $this->userRepository->Search($criteria);
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);	
    $this->auditRepository->Add('Users - Search', $username['username']);		
		
		if (!is_null($userSearchs)){
		  foreach ($userSearchs as $userSearch){
        	$result[] = (new UserModel((array) json_decode($userSearch)))->Expose();
		  }

		  return $result;
		} else {
 		  return null;
		}
	}

  /** 
	 * Checks format email
	 *
	 * @param string $email
	 *
	 * @return bool
	*/
	private function IsValidFormat($email){
		if (!filter_var(substr($email, 0, 100), FILTER_VALIDATE_EMAIL)){
	    return false;
	  }
	    
		return true;
	}
}