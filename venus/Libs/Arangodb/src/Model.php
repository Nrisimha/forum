<?php

namespace Pharango;
use ArangoDBClient\ClientException;
use ArangoDBClient\CollectionHandler;
use ArangoDBClient\DocumentHandler;
use ArangoDBClient\EdgeHandler;
use ArangoDBClient\ServerException;
use ArangoDBClient\Statement;


/**
* Simple model base for ArangoDB
* https://github.com/arangodb/arangodb-php
*/
class Model{
    /**
    * Some variables :)
    */
    protected $connection = null;
    protected $collectionName = null;
    private $collectionHandler = null;
    private $documentHandler = null;
    private $document = null;
    private $keepNullOnUpdate = true;

    /**
    * Create connection on __construct
    * @todo create global connection on DI
    */
    function __construct($connection){
        $this->connection = $connection; //new Connection($this->connectionOptions);
    }

    /**
    * Local document object
    * set-> sets a key value pair
    * remove-> removes a key value //don't confuse with removeByExample
    * get-> gets the value of given key
    * clear-> destroys local document object
    */
    function set($key, $val){
        if(!isset($this->document)){$this->document = new Document();};
        $this->document->set($key,$val);    }

    function remove($key){
        $this->document->set($key,null);
        $this->keepNullOnUpdate = false;    }

    function get($key){
        if(!isset($this->document)){$this->document = new Document();};
        return $this->document->get($key);    }

    function getKey(){
        if(!isset($this->document)){$this->document = new Document();};
        return $this->document->getKey();    }

    function save(){
        return $this->create($this->document);    }

    function clear(){
        $x = $this->document;
        $this->document = null;   
        return $x; }

    /****
    ***** Collection and Document handlers for internal use
    ****/
    /*
    * Singleton collection handler provider
    */
    private function collectionH(){
        if (!isset($this->collectionHandler)) $this->collectionHandler = new CollectionHandler($this->connection);
        return $this->collectionHandler;
    }

    /*
    * Singleton document handler provider
    */
    private function documentH(){
        if (!isset($this->documentHandler)) $this->documentHandler = new DocumentHandler($this->connection);
        return $this->documentHandler;
    }

    /*
    * Singleton edge handler provider
    */
    private function edgeH(){
        if (!isset($this->edgeHandler)) $this->edgeHandler = new EdgeHandler($this->connection);
        return $this->edgeHandler;
    }

    /****
    ***** Operational functions
    ****/
    /**
    * Saves given document object to databaes
    */
    function create(Document $document){
        $documentId = $this->documentH()->save($this->collectionName, $document);
        return $documentId;
    }

    /**
    * Connects two documents with an edge ($from and $to are handles)
    */    
    function createEdge($from,$to,$pairs = []){
        return $this->edgeH()->saveEdge($this->edgeName,$from,$to,$pairs);    }

    /*
    * Reads a document with given id
    */
    function read($id){
         try{
             $this->document = $this->documentH()->get($this->collectionName, $id);
            return $this->document;
        } catch(ServerException $e){}
    }

    /*
    * Reads a document without changing loaded document object
    */
    function readOnce($id){
         try{
            return $this->documentH()->get($this->collectionName, $id);
        } catch(ServerException $e){}
    }

    /*
    * Reads only one document with given example and loads local document object
    */
    function findOne($example){
        try{
             $this->document = $this->collectionH()->firstExample($this->collectionName,$example);
            return $this->document;
        } catch(ServerException $e){
            return false;
        }
    }

    /*
    * Get all documents in a collection
    */
    function readAll($options = []){
        return $this->collectionH()->all($this->collectionName,$options);
    }

    /*
    * Get count of all documents in a collection
    */
    function countAll(){
        return $this->collectionH()->count($this->collectionName);
    }

    /*
    * 'find' is 'findByExample' allias
    */
    function find($example){$this->findByExample($example);}
    function findByExample($example){
        return $this->collectionH()->byExample($this->collectionName, $example, ['_flat' => true]);
    }

    /*
    * Removes all documents matchin with example
    */
    function removeByExample($example){
        return $this->collectionH()->removeByExample($this->collectionName, $example);
    }

    /*
    * Check if a document exist
    */
    function isThere($key,$value){
        try{
        try{
            if($this->collectionH()->firstExample($this->collectionName,[$key => $value])){
                return true;
            }else{
                return false;
            }
        } catch(ClientException $e){return false;}
        } catch(ServerException $e){return false;}
    }

    /*
    * Updates a document by using loaded document object
    */
    function update(){
        $return = $this->documentH()->update($this->document,['keepNull' => $this->keepNullOnUpdate]); 
        $this->keepNullOnUpdate = true;
        return $return;
    }

    /*
    * Deletes a document by using loaded document object
    */
    function delete(){
        try{
        if(!isset($this->document)){return false;};
        return $this->documentH()->remove($this->document);
        } catch(ServerException $e){}
    }

    /*
    * Executes given AQL
    */
    protected function executeAql($query, $bind=[]){
        $statement = new Statement(
        $this->connection,
        array(
            "query"     => $query,
            "count"     => true,
            "batchSize" => 1000,
            "sanitize"  => true,
            "bindVars"  => $bind
        )
        );
        return $statement->execute();
    }
}