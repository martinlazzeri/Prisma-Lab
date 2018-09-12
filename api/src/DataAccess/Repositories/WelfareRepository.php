<?php

namespace App\DataAccess\Repositories;

use App\DataAccess\Contracts\BaseModel;
use App\DataAccess\Contracts\IWelfareRepository;
use App\DataAccess\Entities\Welfare;

/**
 * This class models a WelfareRepository
*/ 
class WelfareRepository extends BaseModel implements IWelfareRepository{
	
  /**
   * WelfareRepository class constructor
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
		return "Welfares";
	}

  /**
   * Adds a welfare
   *
   * @param array $welfare
   * @param string $username
   *
   * @return int
  */
  public function Add($welfare, $username){
    $this->Insert(array('Code' => $welfare['code'],
                        'Name' => ucwords(strtolower($welfare['name'])),
                        'PayAtHome' => $welfare['payAtHome'],
                        'PMO' => $welfare['pmo'],
                        'Coinsurance' => $welfare['coinsurance'],
                        'ServiceAvailable' => $welfare['serviceAvailable'],
                        'INOSReducido' => ($welfare['inosReducido'] === '' || $welfare['inosReducido'] === NULL) ? NULL : $welfare['inosReducido'],
                        'DisposableMaterial' => $welfare['disposableMaterial'],
                        'CompleteNomenclator' => $welfare['completeNomenclator'],
                        'AValue' => ($welfare['aValue'] === '' || $welfare['aValue'] === NULL) ? NULL : $welfare['aValue'],
                        'BValue' => ($welfare['bValue'] === '' || $welfare['bValue'] === NULL) ? NULL : $welfare['bValue'],
                        'CValue' => ($welfare['cValue'] === '' || $welfare['cValue'] === NULL) ? NULL : $welfare['cValue'],
                        'NBUValue' => ($welfare['nbuValue'] === '' || $welfare['nbuValue'] === NULL) ? NULL : $welfare['nbuValue'],
                        'MinimumAmount' => $welfare['minimumAmount'],
                        'CoveragePercentage' => $welfare['coveragePercentage'],
                        'Comments' => ($welfare['comments'] === '' || $welfare['comments'] === NULL) ? NULL : $welfare['comments'],
                        'InternalComments' => ($welfare['internalComments'] === '' || $welfare['internalComments'] === NULL) ? NULL : $welfare['internalComments'],
                        'Percentage' => $welfare['percentage'],
                        'CreatedBy' => $username,
                        'CreatedDate' => date('Y-m-d H:i:s')));
   
    return $this->db->id();      
  }

  /**
   * Checks if code exists
   *
   * @param string $code
   *
   * @return bool
  */
  public function CodeExists($code){
    return $this->db->count('Welfares', ['Code' => $code, 'IsDeleted' => 0]);
  }

  /**
   * Edits a welfare
   *
   * @param array $welfare
   * @param int $id
   * @param string $username
  */
  public function Edit($welfare, $id, $username){
    $this->Update(array('PayAtHome' => $welfare['payAtHome'],
                        'PMO' => $welfare['pmo'],
                        'Coinsurance' => $welfare['coinsurance'],
                        'ServiceAvailable' => $welfare['serviceAvailable'],
                        'INOSReducido' => ($welfare['inosReducido'] === '' || $welfare['inosReducido'] === NULL) ? NULL : $welfare['inosReducido'],
                        'DisposableMaterial' => $welfare['disposableMaterial'],
                        'CompleteNomenclator' => $welfare['completeNomenclator'],
                        'AValue' => ($welfare['aValue'] === '' || $welfare['aValue'] === NULL) ? NULL : $welfare['aValue'],
                        'BValue' => ($welfare['bValue'] === '' || $welfare['bValue'] === NULL) ? NULL : $welfare['bValue'],
                        'CValue' => ($welfare['cValue'] === '' || $welfare['cValue'] === NULL) ? NULL : $welfare['cValue'],
                        'NBUValue' => ($welfare['nbuValue'] === '' || $welfare['nbuValue'] === NULL) ? NULL : $welfare['nbuValue'],
                        'MinimumAmount' => $welfare['minimumAmount'],
                        'CoveragePercentage' => $welfare['coveragePercentage'],
                        'Comments' => ($welfare['comments'] === '' || $welfare['comments'] === NULL) ? NULL : $welfare['comments'],
                        'InternalComments' => ($welfare['internalComments'] === '' || $welfare['internalComments'] === NULL) ? NULL : $welfare['internalComments'],
                        'Percentage' => $welfare['percentage'],
                        'ModifiedBy' => $username,
                        'ModifiedDate' => date('Y-m-d H:i:s')),
                  array('Id' => $id));          
  }

  /**
   * Gets a welfare count
   *
   * @return int
  */
  public function GetWelfaresCount(){
      return $welfareCount = $this->Query('SELECT COUNT(*) FROM Welfares WHERE IsDeleted = 0');
  }

  /**
   * Gets welfares by paginated
   *
   * @param int $offset
   * @param int $limit
   *
   * @return mixed (array or null)
  */
  public function GetByPaginated($offset, $limit){
    $result = array();
    $welfares = $this->Query('SELECT Id, 
                                     Code,
                                     Name,
                                     PayAtHome,
                                     PMO,
                                     Coinsurance,
                                     ServiceAvailable,
                                     INOSReducido,
                                     DisposableMaterial,
                                     CompleteNomenclator,
                                     AValue,
                                     BValue,
                                     CValue,
                                     NBUValue,
                                     MinimumAmount,
                                     CoveragePercentage,
                                     Comments,
                                     InternalComments,
                                     Percentage  
                             FROM Welfares
                             WHERE IsDeleted = 0
                             LIMIT '.$offset.', '.$limit.'');

    if (!(empty($welfares) || (is_null($welfares)))){
      foreach ($welfares as $welfare){
        $result[] = (new Welfare($welfare))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets all welfares
   *
   * @return mixed (array or null)
  */
  public function GetAll(){
    $result = array();
    $welfares = $this->Query('SELECT Id, 
                                     Code,
                                     Name,
                                     PayAtHome,
                                     PMO,
                                     Coinsurance,
                                     ServiceAvailable,
                                     INOSReducido,
                                     DisposableMaterial,
                                     CompleteNomenclator,
                                     AValue,
                                     BValue,
                                     CValue,
                                     NBUValue,
                                     MinimumAmount,
                                     CoveragePercentage,
                                     Comments,
                                     InternalComments,
                                     Percentage  
                           FROM Welfares
                           WHERE IsDeleted = 0
                           ORDER BY Id');

    if (!(empty($welfares) || (is_null($welfares)))){
      foreach ($welfares as $welfare){
        $result[] =  (new Welfare($welfare))->Expose();
      }

      return $result;
    } else {
      return null;
    }
  }

  /**
   * Gets a welfare by id
   *
   * @param int $id
   *
   * @return mixed (array or null)
  */
  public function GetById($id){
    $welfare = $this->Select(array('Id', 
                                   'Code',
                                   'Name',
                                   'PayAtHome',
                                   'PMO',
                                   'Coinsurance',
                                   'ServiceAvailable',
                                   'INOSReducido',
                                   'DisposableMaterial',
                                   'CompleteNomenclator',
                                   'AValue',
                                   'BValue',
                                   'CValue',
                                   'NBUValue',
                                   'MinimumAmount',
                                   'CoveragePercentage',
                                   'Comments',
                                   'InternalComments',
                                   'Percentage'), 
                             array('Id' => $id,
                                   'IsDeleted' => 0));
    
    if (!(empty($welfare) || (is_null($welfare)))){
      $newwelfare = (new Welfare($welfare[0]))->Expose();

      return $newwelfare;
    } else {
      return null;
    }
  }

  /**
   * Checks if name exists
   *
   * @param string $name
   *
   * @return bool
  */
  public function NameExists($name){
    return $this->db->count('Welfares', ['Name' => $name, 'IsDeleted' => 0]);
  }

  /**
   * Removes a welfare
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
   * Gets all welfares that matches the search criteria
   *
   * @param string $criteria
   *
   * @return mixed (array or null)
  */
  public function Search($criteria){
    $result = array();
    $welfareSearchs = $this->Query('SELECT Id, 
                                           Code,
                                           Name,
                                           PayAtHome,
                                           PMO,
                                           Coinsurance,
                                           ServiceAvailable,
                                           INOSReducido,
                                           DisposableMaterial,
                                           CompleteNomenclator,
                                           AValue,
                                           BValue,
                                           CValue,
                                           NBUValue,
                                           MinimumAmount,
                                           CoveragePercentage,
                                           Comments,
                                           InternalComments,
                                           Percentage  
                                   FROM Welfares
                                   WHERE (Code LIKE \'%' . $criteria . '%\'
                                   OR Name LIKE \'%' . $criteria . '%\')
                                   AND IsDeleted = 0');

    if (!(empty($welfareSearchs) || (is_null($welfareSearchs)))){
      foreach ($welfareSearchs as $welfareSearch){
        $result[] =  (new Welfare($welfareSearch))->Expose();
      }
      
      return $result;
    } else {
      return null;
    }
  }
}