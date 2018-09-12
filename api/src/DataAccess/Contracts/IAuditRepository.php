<?php

namespace App\DataAccess\Contracts;

/**
 * AuditRepository interface
*/ 
interface IAuditRepository{

  /**
   * Adds an audit
   *
   * @param string $action
   * @param string $username
   *
  */
  public function Add($action, $username);

  /**
   * Gets all audits
   *
   * @return mixed (array or null)
  */
  public function GetAll();

  /**
   * Gets an audit by its id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id);

  /**
   * Gets audits by dates
   *
   * @param date $initialDate
   * @param date $endDate
   *
   * @return mixed (array or null)}
  */
  public function GetByDate($initialDate, $endDate);
}