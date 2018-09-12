<?php

namespace App\DataAccess\Repositories;

use App\DataAccess\Contracts\BaseModel;
use App\DataAccess\Contracts\IUserRepository;
use App\DataAccess\Entities\User;

/**
 * This class models an UserRepository
*/ 
class UserRepository extends BaseModel implements IUserRepository{
	
  /**
   * UserRepository class constructor
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
		return "Users";
	}

  /**
   * Adds an user
   *
   * @param array $user
   * @param string $username
   *
   * @return int
  */
  public function Add($user, $username){
    $this->Insert(array('Username' => $user['username'],
                        'Password' => password_hash($user['password'], PASSWORD_DEFAULT),
                        'Firstname' => ucwords(strtolower($user['firstname'])),
                        'Lastname' => ucwords(strtolower($user['lastname'])),
                        'Email' => $user['email'],
                        'Birthdate' => $user['birthdate'],
                        'RoleId' => $user['role'],
                        'AvatarURL' => $user['avatarUrl'],
                        'CreatedBy' => $username,
                        'CreatedDate' => date('Y-m-d H:i:s')));
   
    return $this->db->id();      
  }

  /**
   * Edits an user
   *
   * @param array $user
   * @param int $id
   * @param string $username
  */
  public function Edit($user, $id, $username){
    if($user['avatarUrl'] == ''){
      $this->Update(array('Firstname' => ucwords(strtolower($user['firstname'])),
                          'Lastname' => ucwords(strtolower($user['lastname'])),
                          'Birthdate' => $user['birthdate'],
                          'RoleId' => $user['role'],
                          'ModifiedBy' => $username,
                          'ModifiedDate' => date('Y-m-d H:i:s')),
               array('Id' => $id)); 
    } else {
      $this->Update(array('Firstname' => ucwords(strtolower($user['firstname'])),
                          'Lastname' => ucwords(strtolower($user['lastname'])),
                          'Birthdate' => $user['birthdate'],
                          'AvatarURL' => $user['avatarUrl'],
                          'RoleId' => $user['role'],
                          'ModifiedBy' => $username,
                          'ModifiedDate' => date('Y-m-d H:i:s')),
             array('Id' => $id)); 
    }          
  }

  /**
   * Checks if email exists
   *
   * @param string $email
   *
   * @return bool
  */
  public function EmailExists($email){
    return $this->db->count('Users', ['Email' => $email, 'IsDeleted' => 0]);
  }

  /**
   * Gets an user count
   *
   * @return int
  */
  public function GetUsersCount(){
      return $userCount = $this->Query('SELECT COUNT(*) FROM Users WHERE IsDeleted = 0');
  }

  /**
   * Gets users by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit){
    $result = array();
    $users = $this->Query('SELECT u.Id, 
                                  u.Firstname,
                                  u.Lastname,
                                  u.Email,
                                  u.Username,
                                  u.Birthdate,
                                  u.RoleId,
                                  r.Name AS RoleName
                           FROM Users u JOIN Roles r ON u.RoleId = r.Id
                           WHERE u.IsDeleted = 0
                           LIMIT '.$offset.', '.$limit.'');

    if (!(empty($users) || (is_null($users)))){
      foreach ($users as $user){
        $result[] = (new User($user))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets all users
   *
   * @return mixed (array or null)
  */
  public function GetAll(){
    $result = array();
    $users = $this->Query('SELECT u.Id,
                                  u.Username, 
                                  u.Firstname,
                                  u.Lastname,
                                  u.Email,
                                  u.Birthdate,
                                  u.RoleId,
                                  u.AvatarURL,
                                  r.Name AS RoleName
                           FROM Users u JOIN Roles r ON u.RoleId = r.Id
                           WHERE u.IsDeleted = 0
                           ORDER BY u.Id');

    if (!(empty($users) || (is_null($users)))){
      foreach ($users as $user){
        $result[] =  (new User($user))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets an user by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id){
    $user = $this->Select(array('Id', 
                                'Username',
                                'Firstname', 
                                'Lastname', 
                                'Email',  
                                'Birthdate',
                                'RoleId',
                                'AvatarURL' ), 
                          array('Id' => $id,
                                'IsDeleted' => 0));
    
    if (!(empty($user) || (is_null($user)))){
      $newuser = (new User($user[0]))->Expose();

      return $newuser;
    } else {
      return null;
    }
  }

  /**
   * Gets a token by username
   *
   * @param string $username
   *
   * @return mixed (array or null)
  */
  public function GetByUsername($username){
    $token = $this->Query('SELECT access_token FROM oauth_access_tokens WHERE  user_id  = \'' . $username . '\'');
    
    if (!(empty($token) || (is_null($token)))){
      $result = (new User($token[0]))->Expose();

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets an username by id
   *
   * @param int $userId
   *
   * @return mixed (array or null)
  */
  public function GetUsernameById($userId){
    $user = $this->Select(array('Username'), array('Id' => $userId, 'IsDeleted' => 0));
    
    if (!(empty($user) || (is_null($user)))){
      $newuser = (new User($user[0]))->Expose();

      return $newuser;
    } else {
      return null;
    }
  }

  /**
   * Gets an user by username and password
   *
   * @param string $username
   * @param string $password
   *
   * @return mixed (array or null)
  */
  public function GetUser($username, $password){
    $user = $this->Query('SELECT  u.Id,
                                  u.Username, 
                                  u.Firstname,
                                  u.Lastname,
                                  u.Email,
                                  u.Birthdate,
                                  u.RoleId,
                                  u.AvatarURL,
                                  u.Password,
                                 r.Name AS RoleName
                          FROM Users u JOIN Roles r ON u.RoleId = r.Id
                          WHERE u.Username = \'' . $username . '\'
                          AND u.IsDeleted = 0');

    if (!(empty($user) || is_null($user)) && password_verify($password, $user[0]['Password']) ){
      $newuser = (new User($user[0]))->Expose();

      return $newuser;
    } else {
      return null;
    }
  }

  /**
   * Removes an user
   *
   * @param int $id
   * @param string $username
   *
   * @return bool
  */
  public function Remove($id, $username){
    $data = $this->Update(array('IsDeleted' => 1, 
                                'ModifiedBy' => $username,
                                'ModifiedDate' => date('Y-m-d H:i:s')),
                          array('Id' => $id,
                                'IsDeleted' => 0));

    return $data->rowCount();
  }

  /**
   * Gets all users that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria){
    $result = array();
    $userSearchs = $this->Query('SELECT u.Id,
                                        u.Username, 
                                        u.Firstname,
                                        u.Lastname,
                                        u.Email,
                                        u.Birthdate,
                                        u.RoleId,
                                        r.Name AS RoleName
                                 FROM Users u JOIN Roles r ON u.RoleId = r.Id
                                 WHERE (Username LIKE \'%' . $criteria . '%\'
                                 OR Birthdate LIKE \'%' . $criteria . '%\'
                                 OR Firstname LIKE \'%' . $criteria . '%\'
                                 OR Lastname LIKE \'%' . $criteria . '%\')
                                 AND IsDeleted = 0');

    if (!(empty($userSearchs) || (is_null($userSearchs)))){
      foreach ($userSearchs as $userSearch){
        $result[] =  (new User($userSearch))->Expose();
      }
      
      return $result;
    } else {
      return null;
    }
  }

  /**
   * Checks if username exists
   *
   * @param string $username
   *
   * @return bool
  */
  public function UsernameExists($username){
      return $this->db->count('Users', ['Username' => $username, 'IsDeleted' => 0]);
  }
}