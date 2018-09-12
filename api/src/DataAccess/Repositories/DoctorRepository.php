<?php

namespace App\DataAccess\Repositories;

use App\DataAccess\Contracts\BaseModel;
use App\DataAccess\Contracts\IDoctorRepository;
use App\DataAccess\Entities\Doctor;

/**
 * This class models a DoctorRepository
*/ 
class DoctorRepository extends BaseModel implements IDoctorRepository{
	
  /**
   * DoctorRepository class constructor
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
		return "Doctors";
	}

  /**
   * Adds a doctor
   *
   * @param array $doctor
   * @param string $username
   *
   * @return int
  */
  public function Add($doctor, $username){
    $this->Insert(array('Enrollment' => $doctor['enrollment'],
                        'TypeEnrollment' => $doctor['typeEnrollment'],
                        'Firstname' => ucwords(strtolower($doctor['firstname'])),
                        'Lastname' => ucwords(strtolower($doctor['lastname'])),
                        'Address' => ($doctor['address'] === '' || $doctor['address'] === NULL) ? NULL : $doctor['address'],
                        'Phone' => ($doctor['phone'] === '' || $doctor['phone'] === NULL) ? NULL : $doctor['phone'],
                        'CreatedBy' => $username,
                        'CreatedDate' => date('Y-m-d H:i:s')));
   
    return $this->db->id();      
  }

  /**
   * Edits a doctor
   *
   * @param array $doctor
   * @param int $id
   * @param string $username
  */
  public function Edit($doctor, $id, $username){
    $this->Update(array('TypeEnrollment' => $doctor['typeEnrollment'],
                        'Firstname' => ucwords(strtolower($doctor['firstname'])),
                        'Lastname' => ucwords(strtolower($doctor['lastname'])),
                        'Address' => ($doctor['address'] === '' || $doctor['address'] === NULL) ? NULL : $doctor['address'],
                        'Phone' => ($doctor['phone'] === '' || $doctor['phone'] === NULL) ? NULL : $doctor['phone'],
                        'ModifiedBy' => $username,
                        'ModifiedDate' => date('Y-m-d H:i:s')),
                  array('Id' => $id));          
  }

  /**
   * Checks if enrollment exists
   *
   * @param string $enrollment
   *
   * @return bool
  */
  public function EnrollmentExists($enrollment){
    return $this->db->count('Doctors', ['Enrollment' => $enrollment, 'IsDeleted' => 0]);
  }

  /**
   * Gets a doctor count
   *
   * @return int
  */
  public function GetDoctorsCount(){
      return $doctorCount = $this->Query('SELECT COUNT(*) FROM Doctors WHERE IsDeleted = 0');
  }

  /**
   * Gets doctors by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit){
    $result = array();
    $doctors = $this->Query('SELECT Id, 
                                    Enrollment,
                                    TypeEnrollment,
                                    Firstname,
                                    Lastname,
                                    Address,
                                    Phone
                             FROM Doctors
                             WHERE IsDeleted = 0
                             LIMIT '.$offset.', '.$limit.'');

    if (!(empty($doctors) || (is_null($doctors)))){
      foreach ($doctors as $doctor){
        $result[] = (new Doctor($doctor))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets all doctors
   *
   * @return mixed (array or null)
  */
  public function GetAll(){
    $result = array();
    $doctors = $this->Query('SELECT Id, 
                                    Enrollment,
                                    TypeEnrollment,
                                    Firstname,
                                    Lastname,
                                    Address,
                                    Phone
                           FROM Doctors
                           WHERE IsDeleted = 0
                           ORDER BY Id');

    if (!(empty($doctors) || (is_null($doctors)))){
      foreach ($doctors as $doctor){
        $result[] =  (new Doctor($doctor))->Expose();
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
   *
   * @return mixed (array or null)
  */
  public function GetById($id){
    $doctor = $this->Select(array('Id', 
                                  'Enrollment',
                                  'TypeEnrollment',
                                  'Firstname',
                                  'Lastname',
                                  'Address',
                                  'Phone'), 
                            array('Id' => $id,
                                'IsDeleted' => 0));
    
    if (!(empty($doctor) || (is_null($doctor)))){
      $newdoctor = (new Doctor($doctor[0]))->Expose();

      return $newdoctor;
    } else {
      return null;
    }
  }

  /**
   * Removes a doctor
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
   * Gets all doctors that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria){
    $result = array();
    $doctorSearchs = $this->Query('SELECT Id, 
                                          Enrollment,
                                          TypeEnrollment,
                                          Firstname,
                                          Lastname,
                                          Address,
                                          Phone
                                 FROM Doctors
                                 WHERE (Enrollment LIKE \'%' . $criteria . '%\'
                                 OR Firstname LIKE \'%' . $criteria . '%\'
                                 OR Lastname LIKE \'%' . $criteria . '%\')
                                 AND IsDeleted = 0');

    if (!(empty($doctorSearchs) || (is_null($doctorSearchs)))){
      foreach ($doctorSearchs as $doctorSearch){
        $result[] =  (new Doctor($doctorSearch))->Expose();
      }
      
      return $result;
    } else {
      return null;
    }
  }
}