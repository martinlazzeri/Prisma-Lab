<?php

namespace App\Presentation\Controllers;

use App\Presentation\Contracts\BaseController;
use App\Presentation\DTOs\AuditDTO;
use App\Business\Services\AuditService;

/**
 * This class models an AuditController
*/
class AuditController extends BaseController{

  /**
	 * AuditService
	 *
	 * @access private
	 * @var object
	*/
	private $auditService;

	/** 
	 * Auditcontroller class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->auditService = new AuditService($this->container);
	}

	/** 
	 * Gets audits by filter
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
  public function GetByFilter($request, $response){
  	$result = array();
  	$val = $request->getQueryParams();

  	if (empty($val)){
	  	$audits = $this->auditService->GetAll();
    } else {
      $audits = $this->auditService->GetByDate($val['initialDate'], $val['endDate']);
    } 

  	if(!is_null($audits)){
	  
	  	foreach ($audits as $audit){
	  		$results[] = (new AuditDTO((array) json_decode($audit)))->Expose();
	  	}

	  	$result['Audits'] = $results;		
	 	  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
  }

  /** 
	 * Gets an audit by its id
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param int $id
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function GetById($request, $response, $id){		
		$audit = $this->auditService->GetById($id);

		if(!is_null($audit)){
		  $result['Data'] = (new AuditDTO((array) json_decode($audit)))->Expose();			
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
	}
}