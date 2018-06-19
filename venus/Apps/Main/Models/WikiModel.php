<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;

class WikiModel extends Model
{
    /**
    * collectionName
    *
    * @var string
    */
    protected $collectionName = 'wiki_pages';

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
        LET user = (RETURN DOCUMENT(CONCAT('users/', item.last_user)))
        RETURN {page:item, user:user[0]}
        ";
        
        $results = [];
        foreach ($this->executeAql($q)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results;
    }//listAll

    public function view($page, $lang, $id = null){
        $collection = $this->collectionName;
        if(isset($id)){
            $q = "
            FOR item IN $collection
                filter item._key == '$id'
                filter item.hidden == false
                SORT item.last_time DESC
                LIMIT 1
            RETURN item
            ";
        }
        else{
          $q = "
        FOR item IN $collection
            FILTER item.slug == '$page'
            FILTER item.lang == '$lang'
            filter item.hidden == false
            SORT item.last_time DESC
            LIMIT 1
        RETURN item
        ";  
        }
        
        
        $results = [];
        foreach ($this->executeAql($q)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results[0];
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
        FOR item IN $collection FILTER item.$column like @value LIMIT $offset,$perPage
        LET user = (RETURN DOCUMENT(CONCAT('users/', item.last_user)))
        RETURN {page:item, user:user[0]}
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
        FOR item IN $collection FILTER item.$column like @value
        RETURN item._key
        ";
        $b = [
        'value'=>$value
        ];
        
        $count = $this->executeAql($q,$b)->getCount();
        return $count;
    }//filteredCount

/**
    * historyList
    *
    * @param string $lang
    * @param string $value
    * @param integer $page
    * @param integer $perPage
    * @return array
    */
    public function historyList($lang, $slug, $page, $perPage){
        $offset = $page * $perPage;
        $collection = $this->collectionName;
        $q = "
        FOR item IN $collection FILTER item.slug like @slug && item.lang == @lang SORT item.last_time DESC LIMIT $offset,$perPage
        LET user = (RETURN DOCUMENT(CONCAT('users/', item.last_user)))
        RETURN {page:item, user:user[0]}
        ";  
        $b = [
        'slug'=>$slug,
        'lang'=>$lang
        ];
        
        $results = [];
        foreach ($this->executeAql($q,$b)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results;
    }//historyList

/**
    * historyCount
    *
    * @param string $column
    * @param string $value
    * @return integer
    */
    public function historyCount($lang, $slug){
        $collection = $this->collectionName;
        $q = "
        FOR item IN $collection FILTER item.slug like @slug && item.lang == @lang
        RETURN item._key
        ";
        $b = [
        'slug'=>$slug,
        'lang'=>$lang
        ];
        
        $count = $this->executeAql($q,$b)->getCount();
        return $count;
    }//historyCount


/**
    * search
    *
    * @param string $serchLine
    * @return string
    */
    public function search($serchLine, $page, $perPage){
        $offset = $page * $perPage;
        $serchLine = '%'.$serchLine.'%';
        $f[] = "u.subject like '$serchLine' || u.slug like '$serchLine' || u.content like '$serchLine' || u.last_user like '$serchLine'";

        $filter = !empty($f) ? ' filter ' . implode($f, ' && ') : '';
        $query = "FOR u IN " . "wiki_pages" . $filter . "LIMIT $offset,$perPage RETURN u";
        $results = [];
        /* transform in array  */
        foreach ($this->executeAql($query)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results;
    }//search
    
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