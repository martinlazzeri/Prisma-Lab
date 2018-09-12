<?php

namespace App\Presentation\Controllers;

use App\Presentation\Contracts\BaseController;
use App\Presentation\DTOs\WelfareDTO;
use App\Business\Services\WelfareService;
use App\Helpers\RequiredParamsHelper;
/**
 * This class models an WelfareController
*/
class WelfareController extends BaseController{

  /**
	 * WelfareService
	 *
	 * @access private
	 * @var object
	*/
	private $welfareService;

  /**
	 * RequiredParamsHelper
	 *
	 * @access private
	 * @var object
	*/
	private $requiredParamsHelper;

	/** 
	 * WelfareController class constructor
	 *
	 * @param \Slim\Container $container
	*/
	public function __construct($container){
		parent::__construct($container);
		$this->welfareService = new WelfareService($this->container);
		$this->requiredParamsHelper = new RequiredParamsHelper($this->container);
	}

	/** 
	 * Adds a welfare
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param int $userId
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Add($request, $response, $userId){		
		$result = array();
		$requestedParams = array('code',
														 'name',
														 'payAtHome',
														 'pmo',
														 'coinsurance',
														 'serviceAvailable',
														 'disposableMaterial',
														 'completeNomenclator',
														 'minimumAmount',
														 'coveragePercentage',
														 'percentage'); 
		
		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!$processParams['Error']){
		  $welfare = $request->getParsedBody();
		  $idWelfare = $this->welfareService->Add($welfare, $userId['userId']);
		  
		  if (!(is_null($idWelfare))){
				$result['Data'] = $idWelfare;
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
	 * Checks if the code exists
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $code
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function CheckCode($request, $response, $code){
		$code = $this->welfareService->CheckCode($code['code']);

		if($code){
		  $result['Data'] = $code;		
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $result['Message'] = 'EL código ya existe';	
		  $result['Data'] = $code;		
		  $newResponse = $response->withJson($result, 200);
		}

		return $newResponse;
	}

	/** 
	 * Checks if the name exists
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param string $name
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function CheckName($request, $response, $name){
		$name = $this->welfareService->CheckName($name['name']);

		if($name){
		  $result['Data'] = $name;		
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $result['Message'] = 'EL nombre ya existe';	
		  $result['Data'] = $name;		
		  $newResponse = $response->withJson($result, 200);
		}

		return $newResponse;
	}

	/** 
	 * Edits a welfare
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/	
	public function Edit($request, $response, $args){
		$result = array();
		$requestedParams = array('payAtHome',
														 'pmo',
														 'coinsurance',
														 'serviceAvailable',
														 'disposableMaterial',
														 'completeNomenclator',
														 'minimumAmount',
														 'coveragePercentage',
														 'percentage'); 

		$processParams = $this->requiredParamsHelper->VerifyRequiredParams($request, $response, $requestedParams);

		if (!($processParams['Error'])){
		  $updatedWelfare = $request->getParsedBody();
		  $welfareUpdate = $this->welfareService->Edit($updatedWelfare, $args['id'], $args['userId']);

		  if (!(is_null($welfareUpdate))){
				$result['Data'] = (new WelfareDTO((array) json_decode($welfareUpdate)))->Expose();
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
	 * Gets welfares by filter
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
	  	$welfares = $this->welfareService->GetAll($args['userId']);
    } elseif (!empty($val['initialDate'] && $val['endDate'])){
			$welfares = $this->welfareService->GetByDate($val['initialDate'], $val['endDate'], $args['userId']);
    } else {
			$welfares = $this->welfareService->GetByPaginated($val['offset'], $val['limit'], $args['userId']);
    } 

  	if(!is_null($welfares)){
	  
	  	foreach ($welfares['Welfares'] as $welfare){
	  		$welfareArray[] = (new WelfareDTO((array) json_decode($welfare)))->Expose();
	  	}

	 	 	$result['Welfares'] = $welfareArray;	
	 	 	$result['Total'] = $welfares['Total'];	
	  	$newResponse = $response->withJson($result, 200);
		} else {
	  	$newResponse = $response->withStatus(404);
		}

		return $newResponse;
  }

	/** 
 	 * Gets a welfare by its id
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function GetById($request, $response, $args){		
		$welfare = $this->welfareService->GetById($args['id'], $args['userId']);

		if(!is_null($welfare)){
		  $result['Data'] = (new WelfareDTO((array) json_decode($welfare)))->Expose();			
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}

		return $newResponse;
	}

	/** 
	 * Removes a welfare
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @param array $args
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	*/
	public function Remove($request, $response, $args){
		$result = $this->welfareService->Remove($args['id'], $args['userId']);

		if (!(empty($result))){
		  $newResponse = $response->withJson($result, 200);
		} else {
		  $newResponse = $response->withStatus(404);
		}	
		
		return $newResponse;
	} 

	/** 
	 * Gets all welfares that matches the search criteria
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
		  $welfareSearchs = $this->welfareService->Search($criteria['searchCriteria'], $userId['userId']);

		  if(!is_null($welfareSearchs)){
		  	
		  	foreach ($welfareSearchs as $welfareSearch){
          $results[] = (new WelfareDTO((array) json_decode($welfareSearch)))->Expose();
		    }

		  	$result['Welfares'] = $results;
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