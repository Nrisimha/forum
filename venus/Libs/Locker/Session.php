<?php

namespace Shared\Locker;

use Phalcon\Mvc\User\Component;

class Session extends Component{
    
    public $allowByDefault = false;
    private $vault = ['everyone'];
    private $subKeys;
    private $locks = ['_open_' => ['keys'=> ['everyone'],'default_allow' => true]];
    private $redirUrl;
    /**
    * Meta functions
    */
    function __construct($locks=[],$subKeys=[]){
        $this->subKeys = $subKeys;
        $this->syncKeysIn();
        $this->addLocks($locks);
    }
    private function syncKeysIn(){
        if(null !== $this->persistent->get('_keys')) $this->vault=$this->persistent->get('_keys');
    }
    private function syncKeysOut(){
        $this->persistent->set('_keys',$this->vault);
    }
    
    
    public function reveal($lockName){return $this->unlock($lockName);}
    public function unlock($lockName){
        /*
        * Retrun true if key is user based 
        */
        if(in_array(ltrim($lockName,'__'),$this->vault)) return true;

        /*
        * Retrun default allow value if lock is not exist
        */
        if(!isset($this->locks[$lockName])) return $this->allowByDefault;
        
        /*
        * Retrun false if there is a block
        */
        if(isset($this->locks[$lockName]['blocks'])){
          foreach ($this->locks[$lockName]['blocks'] as $v) {
            if(in_array($v,$this->vault)) return false;
          }
        }

        /*
        * Retrun true if there is access key in vault
        */
        if(isset($this->locks[$lockName]['keys'])){
          foreach ($this->locks[$lockName]['keys'] as $v) {
            if(in_array($v,$this->vault)) return true;
          }
        }

        /*
        * Retrun default behavior of the lock
        */
        if(isset($this->locks[$lockName]['default_allow'])){
          return $this->locks[$lockName]['default_allow'];
        }else{
          return $this->allowByDefault;
        }

    }//unlock
    
    public function addKeys($aKeys){$this->addKey($aKeys);}
    public function addKey($aKeys){
        if(is_array($aKeys)){
            foreach($aKeys as $v){
                if(!in_array($v, $this->vault, true)){
                    array_push($this->vault, $v);
                }
            }
        }else{
            if(!in_array($aKeys, $this->vault, true)){
                array_push($this->vault, $aKeys);
            }
        }
        $this->syncKeysOut();
    }//addKey

    public function removeKey($rKeys){
      if(is_array($aKeys)){
        foreach($rKeys as $k => $v){
            if(!array_key_exists($k,$this->vault)){
                unset($this->vault[$k]);
            }
        }
      }else{
            if(!array_key_exists($rKeys,$this->vault)){
                unset($this->vault[$rKeys]);
            }
      }
        $this->syncKeysOut();
    }
    public function getKeys(){
        return $this->vault;
    }//getKeys

    public function destroyKeys(){
      $this->vault = ['everyone'];
      $this->syncKeysOut();
    }//destroyKeys
    
    public function addLocks($newLocks){
        foreach($newLocks as $k => $v){
            if(!array_key_exists($k,$this->locks)){
                $this->locks[$k] = $v;
            }
        }
    }//addLocks

    public function removeLocks($removeLocks){
        foreach($removeLocks as $k => $v){
            if(!array_key_exists($k,$this->locks)){
                unset($this->locks[$k]);
            }
        }
    }//removeLocks

}//Session