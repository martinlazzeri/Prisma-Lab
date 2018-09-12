<?php

namespace App\Business\Contracts;

/**
 * UserService interface
*/ 
interface IUserService{

  /**
   * Adds an user
   *
   * @param array $user
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($user, $userId);

  /**
   * Checks if username exists
	 *
   * @param string $username
	 *
	 * @return bool
	*/
	public function CheckUsername($username, $userId);

  /**
   * Checks if email exists
	 *
   * @param string $email
	 *
	 * @return bool
	*/
	public function CheckEmail($email, $userId);

	/**
	 * Edits an user
	 *
	 * @param array $user
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($user, $id, $userId);

	/**
   * Gets users by paginated
   *
   * @param int $offset
   * @param int $limit
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit, $userId);

	/**
	 * Gets all users
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId);

	/** 
	 * Gets an user by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId);

	/** 
	 * Gets a token  by its username
	 *
	 * @param string $username
	 *
	 * @return mixed (array or null)
	*/
	public function GetByUsername($username);

	/**
	 * Removes an user
	 *
	 * @param int $id
	 * @param int $userId
	*/
	public function Remove($id, $userId);

	/**
	 * Gets all users that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId);
}