<?php

namespace App\Business\Contracts;

/**
 * DoctorService interface
*/ 
interface IDoctorService{

  /**
   * Adds a doctor
   *
   * @param array $doctor
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($doctor, $userId);

  /**
   * Checks if enrollment exists
	 *
   * @param string $enrollment
	 *
	 * @return bool
	*/
	public function CheckEnrollment($enrollment, $userId);

	/** 
	 * Edits a doctor
	 *
	 * @param array $doctor
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($doctor, $id, $userId);

	/**
   * Gets doctors by paginated
   *
   * @param int $offset
   * @param int $limit
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit, $userId);

	/** 
	 * Gets all doctors
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId);

	/** 
	 * Gets a doctor by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId);

	/** 
	 * Removes a doctor
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId);

	/** 
	 * Gets all doctors that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId);
}