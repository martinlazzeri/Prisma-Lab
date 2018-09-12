<?php

namespace App\DataAccess\Contracts;

/**
 * WelfareRepository interface
*/ 
interface IWelfareRepository{

  /**
   * Adds a welfare
   *
   * @param array $welfare
   * @param string $username
   *
   * @return int
  */
  public function Add($welfare, $username);

  /**
   * Checks if code exists
   *
   * @param string $code
   *
   * @return bool
  */
  public function CodeExists($code);

  /**
   * Edits a welfare
   *
   * @param array $welfare
   * @param int $id
   * @param string $username
  */
  public function Edit($welfare, $id, $username);

  /**
   * Gets a welfare count
   *
   * @return int
  */
  public function GetWelfaresCount();

  /**
   * Gets welfares by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit);
  /**
   * Gets all welfares
   *
   * @return mixed (array or null)
  */
  public function GetAll();

  /**
   * Gets a welfare by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id);

  /**
   * Checks if name exists
   *
   * @param string $name
   *
   * @return bool
  */
  public function NameExists($name);

  /**
   * Removes a welfare
   *
   * @param int $id
   * @param string $username
   *
   * @return bool
  */
  public function Remove($id, $username);

  /**
   * Gets all welfares that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria);

}