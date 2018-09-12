<?php

namespace App\Business\Services;

use App\Business\Contracts\BaseService;
use App\Business\Contracts\IWelfareService;
use App\Business\Models\WelfareModel;
use App\DataAccess\Repositories\WelfareRepository;
use App\DataAccess\Repositories\UserRepository;
use App\DataAccess\Repositories\AuditRepository;

/**
 * This class models a WelfareService
*/
class WelfareService extends BaseService implements IWelfareService{

  /**
   * WelfareRepository
   *
   * @access private
   * @var object
  */
	private $welfareRepository;

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
	 * WelfareService class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->welfareRepository = new WelfareRepository($this->container);
		$this->userRepository = new UserRepository($this->container);
		$this->auditRepository = new AuditRepository($this->container);
	}

  /**
   * Adds a welfare
   *
   * @param array $welfare
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($welfare, $userId){
 		if (!$this->welfareRepository->CodeExists($welfare['code']) && !$this->welfareRepository->NameExists($welfare['name'])){
			$userName = $this->userRepository->GetUsernameById($userId);
	  	$username = (array) json_decode($userName);	
	  	$this->auditRepository->Add('Welfares - Add', $username['username']);
		  $idWelfare = $this->welfareRepository->Add($welfare, $username['username']);

			return $idWelfare;
		} else {
			return null;
		}
	}

  /**
   * Checks if code exists
	 *
   * @param string $code
	 *
	 * @return bool
	*/
	public function CheckCode($code, $userId){
		$userName = $this->userRepository->GetUsernameById($userId);
  	$Username = (array) json_decode($userName);	
		$this->auditRepository->Add('Welfares - CheckCode', $Username['username']);

 		if (!($this->welfareRepository->CodeExists($code))){
 		  return true;
 		} else {
 		  return false;
 		}
	}

  /**
   * Checks if name exists
	 *
   * @param string $name
	 *
	 * @return bool
	*/
	public function CheckName($name, $userId){
		$userName = $this->userRepository->GetUsernameById($userId);
  	$Username = (array) json_decode($userName);	
		$this->auditRepository->Add('Welfares - CheckName', $Username['username']);

 		if (!($this->welfareRepository->NameExists($name))){
 		  return true;
 		} else {
 		  return false;
 		}
	}

	/** 
	 * Edits a welfare
	 *
	 * @param array $welfare
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($welfare, $id, $userId){
  	$old = $this->welfareRepository->GetById($id);
  	$oldWelfare = (array) json_decode($old);
  	
		if (!is_null($old)){

			$userName = $this->userRepository->GetUsernameById($userId);
		  $username = (array) json_decode($userName);
		  $this->auditRepository->Add('Welfares - Edit', $username['username']);
		  $this->welfareRepository->Edit($welfare, $id, $username['username']);
		  $welfareUpdate = $this->welfareRepository->GetById($id);

		  return (new WelfareModel((array) json_decode($welfareUpdate)))->Expose();
		} else {
		  return null;
		}
	}

	/**
   * Gets welfares by paginated
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
  	$this->auditRepository->Add('Welfares - GetByPaginated', $username['username']);
  	$welfares = $this->welfareRepository->GetByPaginated($offset, $limit);
  	$result['Total'] = $this->welfareRepository->GetWelfaresCount()[0][0];
  	$welfaresArray = array();
  	
		if (!is_null($welfares)){
		  foreach ($welfares as $welfare){
		  	$welfaresArray[] = (new WelfareModel((array) json_decode($welfare)))->Expose();
		  }

		  $result['Welfares'] = $welfaresArray;

		  return $result;
		} else {
		  return null;
		}
  }

	/** 
	 * Gets all welfares
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId){
		$result = array();
		$welfares = $this->welfareRepository->GetAll();
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);
  	$this->auditRepository->Add('Welfares - GetAll', $username['username']);

		if (!is_null($welfares)){
		  foreach ($welfares as $welfare){
        	$result[] = (new WelfareModel((array) json_decode($welfare)))->Expose();
		  }

		  return $result;
		} else {
    	return null;
		}
	}

	/** 
	 * Gets a welfare by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId){
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
		$welfare = $this->welfareRepository->GetById($id);
    $this->auditRepository->Add('Welfares - GetById', $username['username']);

		if (!is_null($welfare)){
		  return (new WelfareModel((array) json_decode($welfare)))->Expose();
		} else {
		  return null;
		}
	}

	/** 
	 * Removes a welfare
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId){
   	$welfare = $this->welfareRepository->GetById($id);
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
    
    if(!is_null($welfare)){
			$this->auditRepository->Add('Welfares - Remove', $username['username']);
			
			return $this->welfareRepository->Remove($id, $username['username']);
    } else {
    	return 0;
    }
  }

	/** 
	 * Gets all welfares that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId){
		$result = array();
		$welfareSearchs = $this->welfareRepository->Search($criteria);
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);	
    $this->auditRepository->Add('Welfares - Search', $username['username']);		
		
		if (!is_null($welfareSearchs)){
		  foreach ($welfareSearchs as $welfareSearch){
        	$result[] = (new WelfareModel((array) json_decode($welfareSearch)))->Expose();
		  }

		  return $result;
		} else {
 		  return null;
		}
	}
}