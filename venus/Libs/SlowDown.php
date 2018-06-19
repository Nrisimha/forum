<?php

namespace Shared;

use Phalcon\Mvc\User\Component;

class SlowDown extends Component{
public function __call($name, $arguments)
    {
      $name = $name.'_sec';
      $second = $arguments[0];

      if($second == 'start'){
        $this->persistent->set($name, time());
        return true;
        }
      
      if (isset($this->persistent->$name)) {
          $a = $this->persistent->$name + $second;
          $b = time();
          if($a  > $b){
            return false;
          }else{
            return true;
          }
      }else{
          return true;
      } 

    }
}