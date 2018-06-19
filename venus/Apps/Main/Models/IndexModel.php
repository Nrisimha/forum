<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;

class IndexModel extends Model
{
    /**
    * collectionName
    *
    * @var string
    */
    protected $collectionName = 'players';

    /**
    * land
    *
    * @param string $land
    * @return string
    */
    public function land($land){
        $collection = 'land_pages';
        $q = "
        FOR item IN $collection limit 1
        filter item.short == '$land'
        RETURN item
        ";
        
        $results = [];
        foreach ($this->executeAql($q)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results[0];
    }//land

    /**
    * find_record
    *
    * @param string $sgid
    * @return string
    */
    public function find_record($sgid){
        $collection = 'players';
        $q = "
        FOR item IN $collection 
        filter item.sgid == '$sgid'
        RETURN item
        ";
        
        $results = [];
        foreach ($this->executeAql($q)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results[0];
    }//find_record
    /**
    * find_purchause_by_time
    *
    * @param string $sgid
    * @return string
    */
    public function find_purchause_by_time($sgid, $time){
        $collection = 'players';
        $q = "
        FOR item IN $collection 
        filter item.sgid == '$sgid'
        for purch in item.purchases
        filter purch.time == $time
        limit 1
        RETURN purch
        ";
        
        $results = [];
        foreach ($this->executeAql($q)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        if(isset($results[0]))
            return $results[0];
        else
            return $results;
    }//find_purchause_by_time
    /**
    * addPurhause
    *
    * @param string $sgid
    * @param int amount
    * @return string
    */
    public function addPurhause($sgid, $amount = 0, $currency = '$', $time){
        
        if($this->findOne(['sgid' => $sgid])){
            $data = $this->find_record($sgid);
            if(!isset($data['purchases'])){
                $data['purchases'] = array();
            }
            array_push($data['purchases'], ["amount" => $amount, "time" => $time, "currency" => $currency]);
            $this->set('purchases', $data['purchases']);
            return $this->update();
        }
        return false;
    }//addPurhause
    public function isInPurchases($sgid, $time){
        return ($this->findOne(['sgid' => $sgid]) && $this->find_purchause_by_time($sgid, $time) != null);
    }
    /**
    * searchCount
    *
    * @param string $serchLine
    * @return string
    */
    public function searchCount($serchLine){
        $serchLine = '%'.$serchLine.'%';
        $f[] = "u.subject like '$serchLine' || u.slug like '$serchLine' || u.content like '$serchLine' || u.last_user like '$serchLine'";

        $filter = !empty($f) ? ' filter ' . implode($f, ' && ') : '';
        $query = "FOR u IN " . "wiki_pages" . $filter . " RETURN u";
        $results = [];
        /* transform in array  */
        $count = $this->executeAql($query)->getCount();
        return $count;
    }//search
}//class