<?php

namespace App\Business\Contracts;

/**
 * WelfareService interface
*/ 
interface IWelfareService{

  /**
   * Adds a welfare
   *
   * @param array $welfare
   * @param int $userId
   *
   * @return mixed (int or null)
  */
	public function Add($welfare, $userId);

  /**
   * Checks if code exists
	 *
   * @param string $code
	 *
	 * @return bool
	*/
	public function CheckCode($code, $userId);

  /**
   * Checks if name exists
	 *
   * @param string $name
	 *
	 * @return bool
	*/
	public function CheckName($name, $userId);

	/** 
	 * Edits a welfare
	 *
	 * @param array $welfare
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Edit($welfare, $id, $userId);

	/**
   * Gets welfares by paginated
   *
   * @param int $offset
   * @param int $limit
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit, $userId);

	/** 
	 * Gets all welfares
	 *
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetAll($userId);

	/** 
	 * Gets a welfare by id
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function GetById($id, $userId);

	/** 
	 * Removes a welfare
	 *
	 * @param int $id
	 * @param int $userId
	 *
	 * @return bool
	*/
	public function Remove($id, $userId);

	/** 
	 * Gets all welfares that matches the search criteria
	 *
	 * @param string $criteria
   * @param int $userId
	 *
	 * @return mixed (array or null)
	*/
	public function Search($criteria, $userId);
}