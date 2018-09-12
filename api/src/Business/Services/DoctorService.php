<?php

namespace App\Business\Services;

use App\Business\Contracts\BaseService;
use App\Business\Contracts\IDoctorService;
use App\Business\Models\DoctorModel;
use App\DataAccess\Repositories\DoctorRepository;
use App\DataAccess\Repositories\UserRepository;
use App\DataAccess\Repositories\AuditRepository;

/**
 * This class models a DoctorService
*/
class DoctorService extends BaseService implements IDoctorService{

  /**
   * DoctorRepository
   *
   * @access private
   * @var object
  */
	private $doctorRepository;

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
	 * DoctorService class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->doctorRepository = new DoctorRepository($this->container);
		$this->userRepository = new UserRepository($this->container);
		$this->auditRepository = new AuditRepository($this->container);
	}

  /**
   * Adds a doctor
   *
   * @param array $doctor
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($doctor, $userId){
 		if (!$this->doctorRepository->EnrollmentExists($doctor['enrollment'])){
			$userName = $this->userRepository->GetUsernameById($userId);
	  	$username = (array) json_decode($userName);	
	  	$this->auditRepository->Add('Doctors - Add', $username['username']);
		  $idDoctor = $this->doctorRepository->Add($doctor, $username['username']);

			return $idDoctor;
		} else {
			return null;
		}
	}

  /**
   * Checks if enrollment exists
	 *
   * @param string $enrollment
	 *
	 * @return bool
	*/
	public function CheckEnrollment($enrollment, $userId){
		$userName = $this->userRepository->GetUsernameById($userId);
  	$Username = (array) json_decode($userName);	
		$this->auditRepository->Add('Doctors - CheckEnrollment', $Username['username']);

 		if (!($this->doctorRepository->EnrollmentExists($enrollment))){
 		  return true;
 		} else {
 		  return false;
 		}
	}

	/** 
	 * Edits a doctor
	 *
	 * @param array $doctor
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($doctor, $id, $userId){
  	$old = $this->doctorRepository->GetById($id);
  	$oldDoctor = (array) json_decode($old);
  	
		if (!is_null($old)){

			$userName = $this->userRepository->GetUsernameById($userId);
		  $username = (array) json_decode($userName);
		  $this->auditRepository->Add('Doctors - Edit', $username['username']);
		  $this->doctorRepository->Edit($doctor, $id, $username['username']);
		  $doctorUpdate = $this->doctorRepository->GetById($id);

		  return (new DoctorModel((array) json_decode($userUpdate)))->Expose();
		} else {
		  return null;
		}
	}

	/**
   * Gets doctors by paginated
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
  	$this->auditRepository->Add('Doctors - GetByPaginated', $username['username']);
  	$doctors = $this->doctorRepository->GetByPaginated($offset, $limit);
  	$result['Total'] = $this->doctorRepository->GetDoctorsCount()[0][0];
  	$doctorsArray = array();
  	
		if (!is_null($doctors)){
		  foreach ($doctors as $doctor){
		  	$doctorsArray[] = (new DoctorModel((array) json_decode($doctor)))->Expose();
		  }

		  $result['Doctors'] = $doctorsArray;

		  return $result;
		} else {
		  return null;
		}
  }

	/** 
	 * Gets all doctors
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId){
		$result = array();
		$doctors = $this->doctorRepository->GetAll();
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);
  	$this->auditRepository->Add('Doctors - GetAll', $username['username']);

		if (!is_null($doctors)){
		  foreach ($doctors as $doctor){
        	$result[] = (new DoctorModel((array) json_decode($doctor)))->Expose();
		  }

		  return $result;
		} else {
    	return null;
		}
	}

	/** 
	 * Gets a doctor by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId){
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
		$doctor = $this->doctorRepository->GetById($id);
    $this->auditRepository->Add('Doctors - GetById', $username['username']);

		if (!is_null($doctor)){
		  return (new DoctorModel((array) json_decode($doctor)))->Expose();
		} else {
		  return null;
		}
	}

	/** 
	 * Removes a doctor
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId){
   	$doctor = $this->doctorRepository->GetById($id);
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
    
    if(!is_null($doctor)){
			$this->auditRepository->Add('Doctors - Remove', $username['username']);
			
			return $this->doctorRepository->Remove($id, $username['username']);
    } else {
    	return 0;
    }
  }

	/** 
	 * Gets all doctors that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId){
		$result = array();
		$doctorSearchs = $this->doctorRepository->Search($criteria);
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);	
    $this->auditRepository->Add('Doctors - Search', $username['username']);		
		
		if (!is_null($doctorSearchs)){
		  foreach ($doctorSearchs as $doctorSearch){
        	$result[] = (new DoctorModel((array) json_decode($doctorSearch)))->Expose();
		  }

		  return $result;
		} else {
 		  return null;
		}
	}
}