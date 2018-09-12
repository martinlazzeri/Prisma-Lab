<?php

namespace App\Helpers;

class RequiredParamsHelper{
	private $container;

	public function __construct($container){
		$this->container = $container;
	}

	/** 
	 * Function to verify that the required parameters, according to the calling function, are not empty or null
	 *
	 * @param array $required_fields
	 *
	 * @return boolean
	*/
	public static function VerifyRequiredParams($request, $response, $requiredFields){
    $error = false;
    $error_fields = "";
    $datapost = json_decode($request->getBody(), true);

    foreach ($requiredFields as $field) {

        if (!isset($datapost[$field]) || strlen(trim($datapost[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if($error){
    	$array = array();
      $array["Error"] = true;
      $array["Message"] = 'Campo(s) requerido(s) ' . substr($error_fields, 0, -2) . ' faltan, están vacíos o nulos';

			return $array;	
	  }
	}
}