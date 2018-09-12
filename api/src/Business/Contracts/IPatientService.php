<?php

namespace App\Business\Contracts;

/**
 * PatientService interface
*/ 
interface IPatientService{

  /**
   * Adds a patient
   *
   * @param array $patient
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($patient, $userId);

  /**
   * Checks if dni exists
	 *
   * @param int $dni
	 *
	 * @return bool
	*/
	public function CheckDNI($dni, $userId);

	/** 
	 * Edits a patient
	 *
	 * @param array $patient
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($patient, $id, $userId);

	/**
   * Gets patients by paginated
   *
   * @param int $offset
   * @param int $limit
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit, $userId);

	/** 
	 * Gets all patients
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId);

	/** 
	 * Gets a patient by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId);

	/** 
	 * Removes a patient
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId);

	/** 
	 * Gets all patients that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId);
}