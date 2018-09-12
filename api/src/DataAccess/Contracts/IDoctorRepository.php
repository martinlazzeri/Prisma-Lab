<?php

namespace App\DataAccess\Contracts;

/**
 * DoctorRepository interface
*/ 
interface IDoctorRepository{

  /**
   * Adds a doctor
   *
   * @param array $doctor
   * @param string $username
   *
   * @return int
  */
  public function Add($doctor, $username);

  /**
   * Edits a doctor
   *
   * @param array $doctor
   * @param int $id
   * @param string $username
  */
  public function Edit($doctor, $id, $username);

  /**
   * Checks if enrollment exists
   *
   * @param string $enrollment
   *
   * @return bool
  */
  public function EnrollmentExists($enrollment);

  /**
   * Gets an doctor count
   *
   * @return int
  */
  public function GetDoctorsCount();

  /**
   * Gets doctor by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit);

  /**
   * Gets all doctor
   *
   * @return mixed (array or null)
  */
  public function GetAll();

  /**
   * Gets a doctor by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id);

  /**
   * Removes a doctor
   *
   * @param int $id
   * @param string $username
   *
   * @return bool
  */
  public function Remove($id, $username);

  /**
   * Gets all doctors that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria);
}