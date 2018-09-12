<?php

namespace App\Business\Models;

/**
 * This class models a doctor
*/ 
class DoctorModel{
	
	/**
	 * Id
	 *
	 * @access private
	 * @var int
	*/
	private $id;

	/**
	 * Enrollment
	 *
	 * @access private
	 * @var string
	*/
	private $enrollment;

	/**
	 * TypeEnrollment
	 *
	 * @access private
	 * @var int
	*/
	private $typeEnrollment;

	/**
	 * Firstname
	 *
	 * @access private
	 * @var string
	*/
	private $firstname;

	/**
	 * Lastname
	 *
	 * @access private
	 * @var string
	*/
	private $lastname;

	/**
	 * Address
	 *
	 * @access private
	 * @var string
	*/
	private $address;

	/**
	 * Phone1
	 *
	 * @access private
	 * @var string
	*/
	private $phone;

	/**
    * Doctor class constructor
    *
    * @param \Slim\Container $container
    */
	public function __construct($doctor){
		$this->id = $doctor['id'];
		$this->enrollment = $doctor['enrollment'];
		$this->typeEnrollment = $doctor['typeEnrollment'];
		$this->firstname = $doctor['firstname'];
		$this->lastname = $doctor['lastname'];
		$this->address = $doctor['address'];
		$this->phone = $doctor['phone'];
	}

	/**
	  * Sets the enrollment
	  *
	  * @param string $enrollment
	  *
	  * @return void
	*/
	public function SetEnrollment($enrollment){
		$this->enrollment = $enrollment;
	}

	/**
	  * Sets the typeEnrollment
	  *
	  * @param int $typeEnrollment
	  *
	  * @return void
	*/
	public function SetTypeEnrollment($typeEnrollment){
		$this->typeEnrollment = $typeEnrollment;
	}

	/**
	  * Sets the firstname
	  *
	  * @param string $firstname
	  *
	  * @return void
	*/
	public function SetFirstname($firstname){
		$this->firstname = $firstname;
	}

	/**
	  * Sets the lastname
	  *
	  * @param string $lastname
	  *
	  * @return void
	*/
	public function SetLastname($lastname){
		$this->lastname = $lastname;
	}

	/**
	  * Sets the address
	  *
	  * @param string $address
	  *
	  * @return void
	*/
	public function SetAddress($address){
		$this->address = $address;
	}

	/**
	  * Sets the phone
	  *
	  * @param string $phone
	  *
	  * @return void
	*/
	public function SetPhone($phone){
		$this->phone = $phone;
	}

	/**
	 * Gets the enrollment
	 *
	 * @return string
	*/
	public function GetEnrollment(){
		return $this->enrollment;
	}

	/**
	 * Gets the typeEnrollment
	 *
	 * @return string
	*/
	public function GetTypeEnrollment(){
		return $this->typeEnrollment;
	}

	/**
	 * Gets the firstname
	 *
	 * @return string
	*/
	public function GetFirstname(){
		return $this->firstname;
	}

	/**
	 * Gets the lastname
	 *
	 * @return string
	*/
	public function GetLastname(){
		return $this->lastname;
	}

	/**
	 * Gets the address
	 *
	 * @return string
	*/
	public function GetAddress(){
		return $this->address;
	}

	/**
	 * Gets the phone
	 *
	 * @return string
	*/
	public function GetPhone(){
		return $this->phone;
	}
	
	/**
	 * Gets the the doctor object as a json
	 *
	 * @return json
	*/
	public function Expose(){
    	return json_encode(get_object_vars($this));
	}
}