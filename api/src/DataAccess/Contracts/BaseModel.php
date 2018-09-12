<?php
namespace App\DataAccess\Contracts;

abstract class BaseModel{
  protected $container;

  public function __construct($container){
	$this->container = $container;
  }

  public function __get($property){
    if($this->container->{$property}){
	  return $this->container->{$property};
	}
  }

  abstract public function GetSource();

  public function Select($columns, $where=[]){
    return $this->container->db->select($this->getSource(), $columns, $where);
  }

  public function Insert($data = []){
    return $this->db->insert($this->getSource(), $data);
  }

  public function Update($data = [], $where = []){
    if (empty($where)){
      return 0;
    }

    return $this->db->update($this->getSource(), $data, $where);
  }

  public function Delete($where){
    if (empty($where)){
      return 0;
    }

    return $this->db->delete($this->getSource(), $where);
  }

  public function Query($statement){
    if (empty($statement)){
      return 0;
    }

    return $this->db->query($statement)->fetchAll();
  }
}