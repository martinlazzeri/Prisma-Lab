<?php

namespace App\Business\Models;

/**
 * This class models a welfare
*/ 
class WelfareModel{
	
	/**
	 * Id
	 *
	 * @access private
	 * @var int
	*/
	private $id;

	/**
	 * Code
	 *
	 * @access private
	 * @var string
	*/
	private $code;

	/**
	 * Name
	 *
	 * @access private
	 * @var string
	*/
	private $name;

	/**
	 * PayAtHome	
	 *
	 * @access private
	 * @var int
	*/
	private $payAtHome	;

	/**
	 * PMO
	 *
	 * @access private
	 * @var int
	*/
	private $pmo;

	/**
	 * Coinsurance
	 *
	 * @access private
	 * @var int
	*/
	private $coinsurance;

	/**
	 * ServiceAvailable
	 *
	 * @access private
	 * @var int
	*/
	private $serviceAvailable;

	/**
	 * INOSReducido
	 *
	 * @access private
	 * @var int
	*/
	private $inosReducido;

	/**
	 * DisposableMaterial
	 *
	 * @access private
	 * @var boolean
	*/
	private $disposableMaterial;

	/**
	 * CompleteNomenclator
	 *
	 * @access private
	 * @var int
	*/
	private $completeNomenclator;

	/**
	 * AValue
	 *
	 * @access private
	 * @var decimal
	*/
	private $aValue;

	/**
	 * BValue
	 *
	 * @access private
	 * @var decimal
	*/
	private $bValue;

	/**
	 * CValue
	 *
	 * @access private
	 * @var decimal
	*/
	private $cValue;

	/**
	 * NBUValue
	 *
	 * @access private
	 * @var decimal
	*/
	private $nbuValue;

	/**
	 * MinimumAmount
	 *
	 * @access private
	 * @var decimal
	*/
	private $minimumAmount;

	/**
	 * CoveragePercentage
	 *
	 * @access private
	 * @var int
	*/
	private $coveragePercentage;

	/**
	 * Comments
	 *
	 * @access private
	 * @var string
	*/
	private $comments;

	/**
	 * InternalComments
	 *
	 * @access private
	 * @var string
	*/
	private $internalComments;

	/**
	 * Percentage	
	 *
	 * @access private
	 * @var int
	*/
	private $percentage	;

	/**
    * Welfare class constructor
    *
    * @param \Slim\Container $container
    */
	public function __construct($welfare){
		$this->id = $welfare['id'];
		$this->code = $welfare['code'];
		$this->name = $welfare['name'];
		$this->payAtHome = $welfare['payAtHome'];
		$this->pmo = $welfare['pmo'];
		$this->coinsurance = $welfare['coinsurance'];
		$this->serviceAvailable = $welfare['serviceAvailable'];
		$this->inosReducido = $welfare['inosReducido'];
		$this->disposableMaterial = $welfare['disposableMaterial'];
		$this->completeNomenclator = $welfare['completeNomenclator'];
		$this->aValue = $welfare['aValue'];
		$this->bValue = $welfare['bValue'];
		$this->nbuValue = $welfare['nbuValue'];
		$this->minimumAmount = $welfare['minimumAmount'];
		$this->coveragePercentage = $welfare['coveragePercentage'];
		$this->comments = $welfare['comments'];
		$this->internalComments = $welfare['internalComments'];
		$this->percentage = $welfare['percentage'];
	}

	/**
	  * Sets the code
	  *
	  * @param string $code
	  *
	  * @return void
	*/
	public function SetCode($code){
		$this->code = $code;
	}

	/**
	  * Sets the name
	  *
	  * @param string $name
	  *
	  * @return void
	*/
	public function SetName($name){
		$this->name = $name;
	}

	/**
	  * Sets the payAtHome
	  *
	  * @param int $payAtHome
	  *
	  * @return void
	*/
	public function SetPayAtHome($payAtHome){
		$this->payAtHome = $payAtHome;
	}

	/**
	  * Sets the pmo
	  *
	  * @param int $pmo
	  *
	  * @return void
	*/
	public function SetPMO($pmo){
		$this->pmo = $pmo;
	}

	/**
	  * Sets the coinsurance
	  *
	  * @param int $coinsurance
	  *
	  * @return void
	*/
	public function SetCoinsurance($coinsurance){
		$this->coinsurance = $coinsurance;
	}

	/**
	  * Sets the serviceAvailable
	  *
	  * @param int $serviceAvailable
	  *
	  * @return void
	*/
	public function SetServiceAvailable($serviceAvailable){
		$this->serviceAvailable = $serviceAvailable;
	}

	/**
	  * Sets the inosReducido
	  *
	  * @param int $inosReducido
	  *
	  * @return void
	*/
	public function SetINOSReducido($inosReducido){
		$this->inosReducido = $inosReducido;
	}

	/**
	  * Sets the disposableMaterial
	  *
	  * @param boolean $disposableMaterial
	  *
	  * @return void
	*/
	public function SetDisposableMaterial($disposableMaterial){
		$this->disposableMaterial = $disposableMaterial;
	}

	/**
	  * Sets the completeNomenclator
	  *
	  * @param int $completeNomenclator
	  *
	  * @return void
	*/
	public function SetCompleteNomenclator($completeNomenclator){
		$this->completeNomenclator = $completeNomenclator;
	}

	/**
	  * Sets the aValue
	  *
	  * @param decimal $aValue
	  *
	  * @return void
	*/
	public function SetAValue($aValue){
		$this->aValue = $aValue;
	}

	/**
	  * Sets the bValue
	  *
	  * @param decimal $bValue
	  *
	  * @return void
	*/
	public function SetBValue($bValue){
		$this->bValue = $bValue;
	}

	/**
	  * Sets the cValue
	  *
	  * @param decimal $cValue
	  *
	  * @return void
	*/
	public function SetCValue($cValue){
		$this->cValue = $cValue;
	}

	/**
	  * Sets the nbuValue
	  *
	  * @param decimal $nbuValue
	  *
	  * @return void
	*/
	public function SetNBUValue($nbuValue){
		$this->nbuValue = $nbuValue;
	}

	/**
	  * Sets the minimumAmount
	  *
	  * @param decimal $minimumAmount
	  *
	  * @return void
	*/
	public function SetMinimumAmount($minimumAmount){
		$this->minimumAmount = $minimumAmount;
	}

	/**
	  * Sets the coveragePercentage
	  *
	  * @param int $coveragePercentage
	  *
	  * @return void
	*/
	public function SetCoveragePercentage($coveragePercentage){
		$this->coveragePercentage = $coveragePercentage;
	}

	/**
	  * Sets the comments
	  *
	  * @param string $comments
	  *
	  * @return void
	*/
	public function SetComments($comments){
		$this->comments = $comments;
	}

	/**
	  * Sets the internalComments
	  *
	  * @param string $internalComments
	  *
	  * @return void
	*/
	public function SetInternalComments($internalComments){
		$this->internalComments = $internalComments;
	}

	/**
	  * Sets the percentage
	  *
	  * @param int $percentage
	  *
	  * @return void
	*/
	public function SetPercentage($percentage){
		$this->percentage = $percentage;
	}

	/**
	 * Gets the code
	 *
	 * @return string
	*/
	public function GetCode(){
		return $this->code;
	}

	/**
	 * Gets the name
	 *
	 * @return string
	*/
	public function GetName(){
		return $this->name;
	}

	/**
	 * Gets the payAtHome
	 *
	 * @return int
	*/
	public function GetPayAtHome(){
		return $this->payAtHome;
	}

	/**
	 * Gets the pmo
	 *
	 * @return int
	*/
	public function GetPMO(){
		return $this->pmo;
	}

	/**
	 * Gets the coinsurance
	 *
	 * @return int
	*/
	public function GetCoinsurance(){
		return $this->coinsurance;
	}

	/**
	 * Gets the serviceAvailable
	 *
	 * @return int
	*/
	public function GetServiceAvailable(){
		return $this->serviceAvailable;
	}

	/**
	 * Gets the inosReducido
	 *
	 * @return int
	*/
	public function GetINOSReducido(){
		return $this->inosReducido;
	}

	/**
	 * Gets the disposableMaterial
	 *
	 * @return boolean
	*/
	public function GetDisposableMaterial(){
		return $this->disposableMaterial;
	}

	/**
	 * Gets the completeNomenclator
	 *
	 * @return int
	*/
	public function GetCompleteNomenclator(){
		return $this->completeNomenclator;
	}

	/**
	 * Gets the aValue
	 *
	 * @return decimal
	*/
	public function GetAValue(){
		return $this->aValue;
	}

	/**
	 * Gets the bValue
	 *
	 * @return decimal
	*/
	public function GetBValue(){
		return $this->bValue;
	}

	/**
	 * Gets the cValue
	 *
	 * @return decimal
	*/
	public function GetCValue(){
		return $this->cValue;
	}

	/**
	 * Gets the nbuValue
	 *
	 * @return decimal
	*/
	public function GetNBUValue(){
		return $this->nbuValue;
	}

	/**
	 * Gets the minimumAmount
	 *
	 * @return decimal
	*/
	public function GetMinimumAmount(){
		return $this->minimumAmount;
	}

	/**
	 * Gets the coveragePercentage
	 *
	 * @return int
	*/
	public function GetCoveragePercentage(){
		return $this->coveragePercentage;
	}

	/**
	 * Gets the comments
	 *
	 * @return string
	*/
	public function GetComments(){
		return $this->comments;
	}

	/**
	 * Gets the internalComments
	 *
	 * @return string
	*/
	public function GetInternalComments(){
		return $this->internalComments;
	}

	/**
	 * Gets the percentage
	 *
	 * @return int
	*/
	public function GetPercentage(){
		return $this->percentage;
	}
	
	/**
	 * Gets the the welfare object as a json
	 *
	 * @return json
	*/
	public function Expose(){
    	return json_encode(get_object_vars($this));
	}
}