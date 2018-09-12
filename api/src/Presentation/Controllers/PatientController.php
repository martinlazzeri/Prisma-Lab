<?php

namespace App\Presentation\Controllers;

use App\Presentation\Contracts\BaseController;
use App\Presentation\DTOs\PatientDTO;
use App\Business\Services\PatientService;
use App\Helpers\RequiredParamsHelper;
/**
 * This class models an PatientController
*/
class PatientController extends BaseController{

  /**
	 * PatientService
	 *
	 * @access private
	 * @var object
	*/
	private $patientService;

  /**
	 * RequiredParamsHelper
	 *
	 * @access private
	 * @var object
	*/
	private $requiredParamsHelper;

	/** 
	 * PatientController class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->patientService = new PatientService($this->container);
		$this->requiredParamsHelper = new RequiredParamsHelper($this->container);
	}

	/** 
	 * Adds a patient
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param int $userId
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Add($request, $response, $userId){		
		$result = array();
		$requestedParams = array('dni', 'firstname', 'lastname', 'birthdate', 'sex', 'phone'); 
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!$processParams['Error']){
		  $patient = $request->getParsedBody();
		  $idPatient = $this->patientService->Add($patient, $userId['userId']);
		  
		  if (!(is_null($idPatient))){
				$result['Data'] = $idPatient;
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
	 * Checks if the dni exists
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param int $dni
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function CheckDNI($request, $response, $dni){
		$DNI = $this->patientService->CheckDNI($dni['dni']);

		if($DNI){
		  $result['Data'] = $DNI;		
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $result['Message'] = 'El DNI ya existe';	
		  $result['Data'] = $DNI;		
		  $newResponse = $response->withJson($result, 200);
		}

		return $newResponse;
	}

	/** 
	 * Edits a patient
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/	
	public function Edit($request, $response, $args){
		$result = array();
		$requestedParams = array('firstname', 'lastname', 'birthdate', 'sex', 'phone'); 

		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!($processParams['Error'])){
		  $updatedPatient = $request->getParsedBody();
		  $patientUpdate = $this->patientService->Edit($updatedPatient, $args['id'], $args['userId']);

		  if (!(is_null($patientUpdate))){
				$result['Data'] = (new PatientDTO((array) json_decode($patientUpdate)))->Expose();
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
	 * Gets patient by filter
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
  public function GetByFilter($request, $response, $args){
  	$result = array();
  	$patientArray = array();
  	$val = $request->getQueryParams();

  	if (empty($val)){
	  	$patients = $this->patientService->GetAll($args['userId']);
    } elseif (!empty($val['initialDate'] && $val['endDate'])){
			$patients = $this->patientService->GetByDate($val['initialDate'], $val['endDate'], $args['userId']);
    } else {
			$patients = $this->patientService->GetByPaginated($val['offset'], $val['limit'], $args['userId']);
    } 

  	if(!is_null($patients)){
	  
	  	foreach ($patients['Patients'] as $patient){
	  		$patientArray[] = (new PatientDTO((array) json_decode($patient)))->Expose();
	  	}

	 	 	$result['Patients'] = $patientArray;	
	 	 	$result['Total'] = $patients['Total'];	
	  	$newResponse = $response->withJson($result, 200);
		} else {
	  	$newResponse = $response->withStatus(404);
		}

		return $newResponse;
  }

	/** 
 	 * Gets a patient by its id
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function GetById($request, $response, $args){		
		$patient = $this->patientService->GetById($args['id'], $args['userId']);

		if(!is_null($patient)){
		  $result['Data'] = (new PatientDTO((array) json_decode($patient)))->Expose();			
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
	}

	/** 
	 * Removes a patient
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Remove($request, $response, $args){
		$result = $this->patientService->Remove($args['id'], $args['userId']);

		if (!(empty($result))){
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}	
		
		return $newResponse;
	} 

	/** 
	 * Gets all patients that matches the search criteria
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
		  $patientSearchs = $this->patientService->Search($criteria['searchCriteria'], $userId['userId']);

		  if(!is_null($patientSearchs)){
		  	
		  	foreach ($patientSearchs as $patientSearch){
          $results[] = (new PatientDTO((array) json_decode($patientSearch)))->Expose();
		    }

		  	$result['Patients'] = $results;
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