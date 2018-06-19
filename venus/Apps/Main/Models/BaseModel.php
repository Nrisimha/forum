<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;

class BaseModel extends Model
{
  protected $collectionName = "land_pages";
  
  public function getLands(){
    $q = "
    FOR land IN $this->collectionName
    RETURN land
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
}