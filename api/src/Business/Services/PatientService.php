<?php

namespace App\Business\Services;

use App\Business\Contracts\BaseService;
use App\Business\Contracts\IPatientService;
use App\Business\Models\PatientModel;
use App\DataAccess\Repositories\PatientRepository;
use App\DataAccess\Repositories\UserRepository;
use App\DataAccess\Repositories\AuditRepository;

/**
 * This class models a PatientService
*/
class PatientService extends BaseService implements IPatientService{

  /**
   * PatientRepository
   *
   * @access private
   * @var object
  */
	private $patientRepository;

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
	 * PatientService class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->patientRepository = new PatientRepository($this->container);
		$this->userRepository = new UserRepository($this->container);
		$this->auditRepository = new AuditRepository($this->container);
	}

  /**
   * Adds a patient
   *
   * @param array $patient
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($patient, $userId){
 		if (!$this->patientRepository->DNIExists($patient['dni']) && ($this->IsValidFormat($patient['email']) || $patient['email'] == '')){
			$userName = $this->userRepository->GetUsernameById($userId);
	  	$username = (array) json_decode($userName);	
	  	$this->auditRepository->Add('Patients - Add', $username['username']);
		  $idPatient = $this->patientRepository->Add($patient, $username['username']);

			return $idPatient;
		} else {
			return null;
		}
	}

  /**
   * Checks if dni exists
	 *
   * @param int $dni
	 *
	 * @return bool
	*/
	public function CheckDNI($dni, $userId){
		$userName = $this->userRepository->GetUsernameById($userId);
  	$Username = (array) json_decode($userName);	
		$this->auditRepository->Add('Patients - CheckDNI', $Username['username']);

 		if (!($this->patientRepository->DNIExists($dni))){
 		  return true;
 		} else {
 		  return false;
 		}
	}

	/** 
	 * Edits a patient
	 *
	 * @param array $patient
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($patient, $id, $userId){
  	$old = $this->patientRepository->GetById($id);
  	$oldPatient = (array) json_decode($old);
  	
		if (!is_null($old) && $this->IsValidFormat($patient['email'])){

			$userName = $this->userRepository->GetUsernameById($userId);
		  $username = (array) json_decode($userName);
		  $this->auditRepository->Add('Patients - Edit', $username['username']);
		  $this->patientRepository->Edit($patient, $id, $username['username']);
		  $patientUpdate = $this->patientRepository->GetById($id);

		  return (new PatientModel((array) json_decode($patientUpdate)))->Expose();
		} else {
		  return null;
		}
	}

	/**
   * Gets patients by paginated
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
  	$this->auditRepository->Add('Patients - GetByPaginated', $username['username']);
  	$patients = $this->patientRepository->GetByPaginated($offset, $limit);
  	$result['Total'] = $this->patientRepository->GetPatientsCount()[0][0];
  	$patientsArray = array();
  	
		if (!is_null($patients)){
		  foreach ($patient as $patient){
		  	$patientsArray[] = (new PatientModel((array) json_decode($patient)))->Expose();
		  }

		  $result['Patients'] = $patientsArray;

		  return $result;
		} else {
		  return null;
		}
  }

	/** 
	 * Gets all patients
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId){
		$result = array();
		$patients = $this->patientRepository->GetAll();
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);
  	$this->auditRepository->Add('Patients - GetAll', $username['username']);

		if (!is_null($patients)){
		  foreach ($patients as $patient){
        	$result[] = (new PatientModel((array) json_decode($patient)))->Expose();
		  }

		  return $result;
		} else {
    	return null;
		}
	}

	/** 
	 * Gets a patient by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId){
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
		$patient = $this->patientRepository->GetById($id);
    $this->auditRepository->Add('Patients - GetById', $username['username']);

		if (!is_null($patient)){
		  return (new PatientModel((array) json_decode($patient)))->Expose();
		} else {
		  return null;
		}
	}

	/** 
	 * Removes a patient
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId){
   	$patient = $this->patientRepository->GetById($id);
    $userName = $this->userRepository->GetUsernameById($userId);
		$username = (array) json_decode($userName);
    
    if(!is_null($patient)){
			$this->auditRepository->Add('Patients - Remove', $username['username']);
			
			return $this->patientRepository->Remove($id, $username['username']);
    } else {
    	return 0;
    }
  }

	/** 
	 * Gets all patients that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId){
		$result = array();
		$patientSearchs = $this->patientRepository->Search($criteria);
		$userName = $this->userRepository->GetUsernameById($userId);
  	$username = (array) json_decode($userName);	
    $this->auditRepository->Add('Patients - Search', $username['username']);		
		
		if (!is_null($patientSearchs)){
		  foreach ($patientSearchs as $patientSearch){
        	$result[] = (new PatientModel((array) json_decode($patientSearch)))->Expose();
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