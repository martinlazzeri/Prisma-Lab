<?php
namespace App\DataAccess\Repositories;

use App\DataAccess\Contracts\BaseModel;
use App\DataAccess\Contracts\IOauthRepository;

/**
 * This class models an OauthRepository
*/
class OauthRepository extends BaseModel implements IOauthRepository{

	/**
   * OauthRepository class constructor
   *
   * @param \Slim\Container $container
  */
	public function __construct($container){
		parent::__construct($container);
	}

	/**
   * Sets the database table name
   *
   * @return string
  */
	public function GetSource(){
		return "oauth_access_tokens";
	}

  /**
   * Adds an oauth user
   *
   * @param array $user
  */
  public function AddOauthUser($user){
    $this->db->Insert('oauth_users', ['username' => $user['username'],
                                      'password' => password_hash($user['password'], PASSWORD_DEFAULT),
                                      'first_name' => $user['firstname'],
                                      'last_name' => $user['lastname'],
                                      'email' => $user['email']]);
  }

  /**
   * Edits an oauth user
   *
   * @param array $user
  */
  public function EditOauthUser($user){
    $this->db->Update('oauth_users', ['username' => $user['username'],
                                      'first_name' => $user['firstname'],
                                      'last_name' => $user['lastname'],
                                      'email' => $user['email']],
                                     ['username' =>$user['username']]);
    
  }

  /**
   * Gets user_id by its token and if not expire
   *
   * @param string $token
   *
   * @return string
  */
  public function GetUserId($token){
    return $this->db->get('oauth_access_tokens', 'user_id',['access_token' => $token,
                                                            'expires[>]' => date('Y-m-d H:i:s')]);
  }

  /**
   * Removes an oauth user
   *
   * @param string $username
   *
   * @return bool
  */
  public function RemoveByUserId($username){
    $this->db->delete("oauth_users", ["username" => [$username]]);
  }
}