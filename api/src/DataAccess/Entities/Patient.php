<?php

namespace App\DataAccess\Entities;

/**
 * Patient class
*/ 
class Patient {
	
	/**
	 * Id
	 *
	 * @access private
	 * @var int
	*/
	private $id;

	/**
	 * DNI
	 *
	 * @access private
	 * @var int
	*/
	private $dni;

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
	 * Birthdate
	 *
	 * @access private
	 * @var date
	*/
	private $birthdate;

	/**
	 * Sex
	 *
	 * @access private
	 * @var int
	*/
	private $sex;

	/**
	 * Address
	 *
	 * @access private
	 * @var string
	*/
	private $address;

	/**
	 * Phone
	 *
	 * @access private
	 * @var int
	*/
	private $phone;

	/**
	 * Email
	 *
	 * @access private
	 * @var string
	*/
	private $email;

	/**
    * Patient class constructor
    *
    * @param \Slim\Container $container
    */
	public function __construct($patient){
		$this->id = $patient['Id'];
		$this->dni = $patient['DNI'];
		$this->firstname = $patient['Firstname'];
		$this->lastname = $patient['Lastname'];
		$this->birthdate = $patient['Birthdate'];
		$this->sex = $patient['Sex'];
		$this->address = $patient['Address'];
		$this->phone = $patient['Phone'];
		$this->email = $patient['Email'];
	}

	/**
	  * Sets the dni
	  *
	  * @param int $dni
	  *
	  * @return void
	*/
	public function SetDNI($dni){
		$this->dni = $dni;
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
	  * Sets the birthdate
	  *
	  * @param date $birthdate
	  *
	  * @return void
	*/
	public function SetBirthdate($birthdate){
		$this->birthdate = $birthdate;
	}

	/**
	  * Sets the sex
	  *
	  * @param int $sex
	  *
	  * @return void
	*/
	public function SetSex($sex){
		$this->sex = $sex;
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
	  * @param int $phone
	  *
	  * @return void
	*/
	public function SetPhone($phone){
		$this->phone = $phone;
	}

	/**
	  * Sets the email
	  *
	  * @param int $email
	  *
	  * @return void
	*/
	public function SetEmail($email){
		$this->email = $email;
	}

	/**
	 * Gets the dni
	 *
	 * @return int
	*/
	public function GetDNI(){
		return $this->dni;
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
	 * Gets the birthdate
	 *
	 * @return date
	*/
	public function GetBirthdate(){
		return $this->birthdate;
	}

	/**
	 * Gets the sex
	 *
	 * @return int
	*/
	public function GetSex(){
		return $this->sex;
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
	 * @return int
	*/
	public function GetPhone(){
		return $this->phone;
	}

	/**
	 * Gets the email
	 *
	 * @return int
	*/
	public function GetEmail(){
		return $this->email;
	}
	
	/**
	 * Gets the the patient object as a json
	 *
	 * @return json
	*/
	public function Expose(){
    	return json_encode(get_object_vars($this));
	}
}