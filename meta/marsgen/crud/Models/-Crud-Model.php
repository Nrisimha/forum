<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;

class /*{classPrefix}*/Model extends Model
{
    /**
    * collectionName
    *
    * @var string
    */
    protected $collectionName = '/*{collectionName}*/';

    /**
    * listAll
    *
    * @param integer $page
    * @param integer $perPage
    * @return array
    */
    public function listAll($page, $perPage){
        $offset = $page * $perPage;
        $collection = $this->collectionName;
        $q = "
        FOR item IN $collection LIMIT $offset,$perPage
        RETURN item
        ";
        
        $results = [];
        foreach ($this->executeAql($q)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results;
    }//listAll

    /**
    * filteredList
    *
    * @param string $column
    * @param mixed $value
    * @param integer $page
    * @param integer $perPage
    * @return array
    */
    public function filteredList($column, $value, $page, $perPage){
        $offset = $page * $perPage;
        $collection = $this->collectionName;
        $q = "
        FOR item IN $collection FILTER item.$column == @value LIMIT $offset,$perPage
        RETURN item
        ";
        $b = [
        'value'=>$value
        ];
        
        $results = [];
        foreach ($this->executeAql($q,$b)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results;
    }//filteredList

    /**
    * filteredCount
    *
    * @param string $column
    * @param mixed $value
    * @return integer
    */
    public function filteredCount($column, $value){
        $collection = $this->collectionName;
        $q = "
        FOR item IN $collection FILTER item.$column == @value
        RETURN item._key
        ";
        $b = [
        'value'=>$value
        ];
        
        $count = $this->executeAql($q,$b)->getCount();
        return $count;
    }//filteredCount
    
}//class