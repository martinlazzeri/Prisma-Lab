<?php

namespace App\Business\Contracts;

/**
 * AuditService interface
*/ 
interface IAuditService{

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
   * @return mixed (array or null)
  */
  public function GetByDate($initialDate, $endDate);
}