<?php

namespace App\DataAccess\Contracts;

/**
 * UserRepository interface
*/ 
interface IUserRepository{

  /**
   * Adds an user
   *
   * @param array $user
   * @param string $username
   *
   * @return int
  */
  public function Add($user, $username);

  /**
   * Edits an user
   *
   * @param array $user
   * @param int $id
   * @param string $username
  */
  public function Edit($user, $id, $username);

  /**
   * Checks if email exists
   *
   * @param string $email
   *
   * @return bool
  */
  public function EmailExists($email);

  /**
   * Gets an user count
   *
   * @return int
  */
  public function GetUsersCount();


  /**
   * Gets users by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit);

  /**
   * Gets all users
   *
   * @return mixed (array or null)
  */
  public function GetAll();

  /**
   * Gets an user by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id);

  /**
   * Gets a token by username
   *
   * @param string $username
   *
   * @return mixed (array or null)
  */
  public function GetByUsername($username);

  /**
   * Gets an username by id
   *
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetUsernameById($userId);

  /**
   * Gets an user by username and password
   *
   * @param string $username
   * @param string $password
   *
   * @return mixed (array or null)
  */
  public function GetUser($username, $password);

  /**
   * Removes an user
   *
   * @param int $id
   * @param string $username
   *
   * @return bool
  */
  public function Remove($id, $username);

  /**
   * Gets all users that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria);

  /**
   * Checks if username exists
   *
   * @param string $username
   *
   * @return bool
  */
  public function UsernameExists($username);
}