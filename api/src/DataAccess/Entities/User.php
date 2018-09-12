<?php

namespace App\DataAccess\Entities;

/**
 * User class
*/ 
class User {
	
	/**
	 * Id
	 *
	 * @access private
	 * @var int
	*/
	private $id;

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
	 * Email
	 *
	 * @access private
	 * @var string
	*/
	private $email;

	/**
	 * Birthdate
	 *
	 * @access private
	 * @var date
	*/
	private $birthdate;

	/**
	 * Username
	 *
	 * @access private
	 * @var string
	*/
	private $username;

	/**
	 * Password
	 *
	 * @access private
	 * @var string
	*/
	private $password;

	/**
	 * RoleId
	 *
	 * @access private
	 * @var int
	*/
	private $roleId;

	/**
	 * RoleName
	 *
	 * @access private
	 * @var string
	*/
	private $roleName;

	/**
	 * AvatarURL
	 *
	 * @access private
	 * @var string
	*/
	private $avatarUrl;

	/**
	 * Access_Token
	 *
	 * @access private
	 * @var string
	*/
	private $access_Token;

	/**
    * User class constructor
    *
    * @param \Slim\Container $container
    */
	public function __construct($user){
		$this->id = $user['Id'];
		$this->firstname = $user['Firstname'];
		$this->lastname = $user['Lastname'];
		$this->email = $user['Email'];
		$this->birthdate = $user['Birthdate'];
		$this->username = $user['Username'];
		$this->roleId = $user['RoleId'];
		$this->roleName = $user['RoleName'];
		$this->avatarUrl = $user['AvatarURL'];
		$this->access_Token = $user['access_token'];
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
	  * Sets the email
	  *
	  * @param string $email
	  *
	  * @return void
	*/
	public function SetEmail($email){
		$this->email = $email;
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
	  * Sets the username
	  *
	  * @param string $username
	  *
	  * @return void
	*/
	public function SetUsername($username){
		$this->username = $username;
	}

	/**
	  * Sets the password
	  *
	  * @param string $password
	  *
	  * @return void
	*/
	public function SetPassword($password){
		$this->password = $password;
	}

	/**
	  * Sets the roleId
	  *
	  * @param int $roleId
	  *
	  * @return void
	*/
	public function SetRoleId($roleId){
		$this->roleId = $roleId;
	}

	/**
	  * Sets the roleName
	  *
	  * @param string $roleName
	  *
	  * @return void
	*/
	public function SetRoleName($roleName){
		$this->roleName = $roleName;
	}

	/**
	  * Sets the avatarUrl
	  *
	  * @param string $avatarUrl
	  *
	  * @return void
	*/
	public function SetAvatarUrl($avatarUrl){
		$this->avatarUrl = $avatarUrl;
	}

	/**
	  * Sets the access_Token
	  *
	  * @param string $access_Token
	  *
	  * @return void
	*/
	public function Setaccess_token($access_Token){
		$this->access_Token = $access_Token;
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
	 * Gets the email
	 *
	 * @return string
	*/
	public function GetEmail(){
		return $this->email;
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
	 * Gets the username
	 *
	 * @return string
	*/
	public function GetUsername(){
		return $this->username;
	}

	/**
	 * Gets the password
	 *
	 * @return string
	*/
	public function GetPassword(){
		return $this->password;
	}

	/**
	 * Gets the roleId
	 *
	 * @return int
	*/
	public function GetRoleId(){
		return $this->roleId;
	}

	/**
	 * Gets the roleName
	 *
	 * @return string
	*/
	public function GetRoleName(){
		return $this->roleName;
	}

	/**
	 * Gets the avatarUrl
	 *
	 * @return string
	*/
	public function GetAvatarUrl(){
		return $this->avatarUrl;
	}

	/**
	 * Gets the access_Token
	 *
	 * @return string
	*/
	public function Getaccess_token(){
		return $this->access_Token;
	}
	
	/**
	 * Gets the the user object as a json
	 *
	 * @return json
	*/
	public function Expose(){
    	return json_encode(get_object_vars($this));
	}
}