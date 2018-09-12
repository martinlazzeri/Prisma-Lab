<?php

namespace App\DataAccess\Contracts;

/**
 * PatientRepository interface
*/ 
interface IPatientRepository{

  /**
   * Adds a patient
   *
   * @param array $patient
   * @param string $username
   *
   * @return int
  */
  public function Add($patient, $username);

  /**
   * Checks if dni exists
   *
   * @param int $dni
   *
   * @return bool
  */
  public function DNIExists($dni);

  /**
   * Edits a patient
   *
   * @param array $patient
   * @param int $id
   * @param string $username
  */
  public function Edit($patient, $id, $username);

  /**
   * Gets a patients count
   *
   * @return int
  */
  public function GetPatientsCount();

  /**
   * Gets patients by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit);

  /**
   * Gets all patients
   *
   * @return mixed (array or null)
  */
  public function GetAll();

  /**
   * Gets a patient by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id);

  /**
   * Removes a patient
   *
   * @param int $id
   * @param string $username
   *
   * @return bool
  */
  public function Remove($id, $username);

  /**
   * Gets all patients that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria);
}