<?php

namespace Alientext;

class Alientext{

  private $lang = "en_us";
  private $folder;
  private $keys = [];

  function __construct($folder){
    $this->folder = $folder .= (substr($folder, -1) == '/' ? '' : '/');
  }

  function language($lang){
    $this->lang = $lang;
  }

  function load($file){
    $newset = require($this->folder.$this->lang.'/'.$file.'.php');
    $this->keys = array_merge($newset,$this->keys);
  }

  function simple($key){
    return isset($this->keys[$key])? $this->keys[$key] : $key;
  }

  function assign($key,$values){
    if(!isset($this->keys[$key])){return $key;};
    if(is_string($values)){return str_replace('%s',$values,$this->keys[$key]);}
    if(is_array($values)){
      $ret = $this->keys[$key];
      foreach ($values as $key => $value) {
        $ret = str_replace('%'.$key.'%',$value, $ret);
      }
      return $ret;
    }

    function advanced($key){
      return $key;
    }

  }
}