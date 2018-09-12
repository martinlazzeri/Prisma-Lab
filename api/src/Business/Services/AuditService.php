<?php

namespace App\Business\Services;

use App\Business\Contracts\BaseService;
use App\Business\Contracts\IAuditService;
use App\Business\Models\AuditModel;
use App\DataAccess\Repositories\AuditRepository;

/**
 * This class models an AuditService
*/
class AuditService extends BaseService implements IAuditService{

  /**
   * AuditRepository
   *
   * @access private
   * @var object
  */
  private $auditRepository;

  /** 
   * AuditService class constructor
   *
   * @param \Slim\Container $container
   */
  public function __construct($container){
      parent::__construct($container);
      $this->auditRepository = new AuditRepository($this->container);
  }

  /** 
   * Gets all audits
   *
   * @return mixed (array or null)
  */
  public function GetAll(){
    $result = array();
    $audits  = $this->auditRepository->GetAll();
    $this->auditRepository->Add('Audits - GetAll');

    if (!is_null($audits )){
      foreach ($audits  as $audit){
        $result[] = (new AuditModel((array) json_decode($audit)))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets an audit by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id){
    $audit = $this->auditRepository->GetById($id);
    $this->auditRepository->Add('Audits - GetById');

    if (!is_null($audit)){
      return (new AuditModel((array) json_decode($audit)))->Expose();
    } else {
      return null;
    }
  }
  
  /**
   * Gets audits by dates
   *
   * @param date $initialDate
   * @param date $endDate
   *
   * @return mixed (array or null)
  */
  public function GetByDate($initialDate, $endDate){
    $result = array();
    $audits = $this->auditRepository->GetByDate($initialDate, $endDate);
    $this->auditRepository->Add('Audits - GetByDate');

    if (!is_null($audits)){
      foreach ($audits as $audit){
        $result[] = (new AuditModel((array) json_decode($audit)))->Expose();
      }
    
      return $result;
    } else {
      return null;
    }
  }
}