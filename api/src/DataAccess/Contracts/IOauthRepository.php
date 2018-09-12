<?php

namespace App\DataAccess\Contracts;

/**
 * OauthRepository interface
*/ 
interface IOauthRepository{

  /**
   * Adds an oauth user
   *
   * @param array $user
  */
  public function AddOauthUser($user);

  /**
   * Edits an oauth user
   *
   * @param array $user
  */
  public function EditOauthUser($user);

  /**
   * Gets user_id by its token and if not expire
   *
   * @param string $token
   *
   * @return string
  */
  public function GetUserId($token);

  /**
   * Removes an oauth user
   *
   * @param string $username
   *
   * @return bool
  */
  public function RemoveByUserId($username);
}