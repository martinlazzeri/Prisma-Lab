<?php

namespace App\Presentation\Controllers;

use App\Presentation\Contracts\BaseController;
use App\Presentation\DTOs\DoctorDTO;
use App\Business\Services\DoctorService;
use App\Helpers\RequiredParamsHelper;
/**
 * This class models an DoctorController
*/
class DoctorController extends BaseController{

  /**
	 * DoctorService
	 *
	 * @access private
	 * @var object
	*/
	private $doctorService;

  /**
	 * RequiredParamsHelper
	 *
	 * @access private
	 * @var object
	*/
	private $requiredParamsHelper;

	/** 
	 * DoctorController class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->doctorService = new DoctorService($this->container);
		$this->requiredParamsHelper = new RequiredParamsHelper($this->container);
	}

	/** 
	 * Adds a doctor
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param int $userId
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Add($request, $response, $userId){		
		$result = array();
		$requestedParams = array('enrollment', 'typeEnrollment', 'firstname', 'lastname'); 
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!$processParams['Error']){
		  $doctor = $request->getParsedBody();
		  $idDoctor = $this->doctorService->Add($doctor, $userId['userId']);
		  
		  if (!(is_null($idDoctor))){
				$result['Data'] = $idDoctor;
				$newResponse = $response->withJson($result, 201);
		  } else {
				$newResponse = $response->withStatus(409);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}

	/** 
	 * Checks if the enrollment exists
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $enrollment
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function CheckEnrollment($request, $response, $enrollment){
		$Enrollment = $this->doctorService->CheckEnrollment($enrollment['enrollment']);

		if($Enrollment){
		  $result['Data'] = $Enrollment;		
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $result['Message'] = 'La matricula ya existe';	
		  $result['Data'] = $Enrollment;		
		  $newResponse = $response->withJson($result, 200);
		}

		return $newResponse;
	}

	/** 
	 * Edits a doctor
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/	
	public function Edit($request, $response, $args){
		$result = array();
		$requestedParams = array('typeEnrollment', 'firstname', 'lastname'); 

		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!($processParams['Error'])){
		  $updatedDoctor = $request->getParsedBody();
		  $doctorUpdate = $this->doctorService->Edit($updatedDoctor, $args['id'], $args['userId']);

		  if (!(is_null($doctorUpdate))){
				$result['Data'] = (new DoctorDTO((array) json_decode($doctorUpdate)))->Expose();
				$newResponse = $response->withJson($result, 201);
		  } else {
				$newResponse = $response->withStatus(409);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}

	/** 
	 * Gets doctors by filter
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
  public function GetByFilter($request, $response, $args){
  	$result = array();
  	$doctorArray = array();
  	$val = $request->getQueryParams();

  	if (empty($val)){
	  	$doctors = $this->doctorService->GetAll($args['userId']);
    } elseif (!empty($val['initialDate'] && $val['endDate'])){
			$doctors = $this->doctorService->GetByDate($val['initialDate'], $val['endDate'], $args['userId']);
    } else {
			$doctors = $this->doctorService->GetByPaginated($val['offset'], $val['limit'], $args['userId']);
    } 

  	if(!is_null($doctors)){
	  
	  	foreach ($doctors['Doctors'] as $doctor){
	  		$doctorArray[] = (new DoctorDTO((array) json_decode($doctor)))->Expose();
	  	}

	 	 	$result['Doctors'] = $doctorArray;	
	 	 	$result['Total'] = $doctors['Total'];	
	  	$newResponse = $response->withJson($result, 200);
		} else {
	  	$newResponse = $response->withStatus(404);
		}

		return $newResponse;
  }

	/** 
 	 * Gets a doctor by its id
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function GetById($request, $response, $args){		
		$doctor = $this->doctorService->GetById($args['id'], $args['userId']);

		if(!is_null($doctor)){
		  $result['Data'] = (new DoctorDTO((array) json_decode($doctor)))->Expose();			
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
	}

	/** 
	 * Removes a doctor
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Remove($request, $response, $args){
		$result = $this->doctorService->Remove($args['id'], $args['userId']);

		if (!(empty($result))){
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}	
		
		return $newResponse;
	} 

	/** 
	 * Gets all doctors that matches the search criteria
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Search($request, $response, $userId){	
		$result = array();	
		$requestedParams = array('searchCriteria');
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);
		
		if(!$processParams['Error']){
		  $criteria = $request->getParsedBody();
		  $doctorSearchs = $this->doctorService->Search($criteria['searchCriteria'], $userId['userId']);

		  if(!is_null($doctorSearchs)){
		  	
		  	foreach ($doctorSearchs as $doctorSearch){
          $results[] = (new DoctorDTO((array) json_decode($doctorSearch)))->Expose();
		    }

		  	$result['Doctors'] = $results;
		  	$newResponse = $response->withJson($result, 200);
		  } else {
		  	$newResponse = $response->withStatus(404);
		  }
		} else {
		  $newResponse = $response->withStatus(400);
		}

		return $newResponse;
	}	
}