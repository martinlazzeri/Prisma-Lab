<?php

namespace App\DataAccess\Repositories;

use App\DataAccess\Contracts\BaseModel;
use App\DataAccess\Contracts\IPatientRepository;
use App\DataAccess\Entities\Patient;

/**
 * This class models an PatientRepository
*/ 
class PatientRepository extends BaseModel implements IPatientRepository{
	
  /**
   * PatientRepository class constructor
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
		return "Patients";
	}

  /**
   * Adds a patient
   *
   * @param array $patient
   * @param string $username
   *
   * @return int
  */
  public function Add($patient, $username){
    $this->Insert(array('DNI' => $patient['dni'],
                        'Firstname' => ucwords(strtolower($patient['firstname'])),
                        'Lastname' => ucwords(strtolower($patient['lastname'])),
                        'Birthdate' => $patient['birthdate'],
                        'Sex' => $patient['sex'],
                        'Address' => ($patient['address'] === '' || $patient['address'] === NULL) ? NULL : $patient['address'],
                        'Phone' => $patient['phone'],
                        'Email' => ($patient['email'] === '' || $patient['email'] === NULL) ? NULL : $patient['email'],
                        'CreatedBy' => $username,
                        'CreatedDate' => date('Y-m-d H:i:s')));
   
    return $this->db->id();      
  }

  /**
   * Checks if dni exists
   *
   * @param string $dni
   *
   * @return bool
  */
  public function DNIExists($dni){
    return $this->db->count('Patients', ['DNI' => $dni, 'IsDeleted' => 0]);
  }

  /**
   * Edits a patient
   *
   * @param array $patient
   * @param int $id
   * @param string $username
  */
  public function Edit($patient, $id, $username){
      $this->Update(array('Firstname' => ucwords(strtolower($patient['firstname'])),
                          'Lastname' => ucwords(strtolower($patient['lastname'])),
                          'Birthdate' => $patient['birthdate'],
                          'Sex' => $patient['sex'],
                          'Address' => ($patient['address'] === '' || $patient['address'] === NULL) ? NULL : $patient['address'],
                          'Phone' => $patient['phone'],
                          'Email' => ($patient['email'] === '' || $patient['email'] === NULL) ? NULL : $patient['email'],
                          'ModifiedBy' => $username,
                          'ModifiedDate' => date('Y-m-d H:i:s')),
             array('Id' => $id));         
  }

  /**
   * Gets a patients count
   *
   * @return int
  */
  public function GetPatientsCount(){
      return $patientCount = $this->Query('SELECT COUNT(*) FROM Patients WHERE IsDeleted = 0');
  }

  /**
   * Gets patients by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit){
    $result = array();
    $patients = $this->Query('SELECT Id, 
                                     DNI,
                                     Firstname,
                                     Lastname,
                                     Birthdate,
                                     Sex,
                                     Address,
                                     Phone,
                                     Email
                             FROM Patients 
                             WHERE IsDeleted = 0
                             LIMIT '.$offset.', '.$limit.'');

    if (!(empty($patients) || (is_null($patients)))){
      foreach ($patients as $patient){
        $result[] = (new Patient($patient))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets all patients
   *
   * @return mixed (array or null)
  */
  public function GetAll(){
    $result = array();
    $patients = $this->Query('SELECT Id, 
                                     DNI,
                                     Firstname,
                                     Lastname,
                                     Birthdate,
                                     Sex,
                                     Address,
                                     Phone,
                                     Email
                             FROM Patients
                             WHERE IsDeleted = 0
                             ORDER BY Id');

    if (!(empty($patients) || (is_null($patients)))){
      foreach ($patients as $patient){
        $result[] =  (new Patient($patient))->Expose();
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
   *
   * @return mixed (array or null)
  */
  public function GetById($id){
    $patient = $this->Select(array('Id', 
                                   'DNI',
                                   'Firstname', 
                                   'Lastname', 
                                   'Birthdate',  
                                   'Sex',
                                   'Address',
                                   'Phone',
                                   'Email'), 
                             array('Id' => $id,
                                   'IsDeleted' => 0));
    
    if (!(empty($patient) || (is_null($patient)))){
      $newPatient = (new Patient($patient[0]))->Expose();

      return $newPatient;
    } else {
      return null;
    }
  }

  /**
   * Removes a patient
   *
   * @param int $id
   * @param string $username
   *
   * @return bool
  */
  public function Remove($id, $username){
    $data = $this->Update(array('IsDeleted' => 1, 
                                'ModifiedBy' => $username,
                                'ModifiedDate' => date('Y-m-d H:i:s')),
                          array('Id' => $id,
                                'IsDeleted' => 0));

    return $data->rowCount();
  }

  /**
   * Gets all patients that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria){
    $result = array();
    $patientSearchs = $this->Query('SELECT Id, 
                                           DNI,
                                           Firstname,
                                           Lastname,
                                           Birthdate,
                                           Sex,
                                           Address,
                                           Phone,
                                           Email
                                   FROM Patients
                                   WHERE (DNI LIKE \'%' . $criteria . '%\'
                                   OR Firstname LIKE \'%' . $criteria . '%\'
                                   OR Lastname LIKE \'%' . $criteria . '%\'
                                   OR Phone LIKE \'%' . $criteria . '%\')
                                   AND IsDeleted = 0');

    if (!(empty($patientSearchs) || (is_null($patientSearchs)))){
      foreach ($patientSearchs as $patientSearch){
        $result[] =  (new Patient($patientSearch))->Expose();
      }
      
      return $result;
    } else {
      return null;
    }
  }
}