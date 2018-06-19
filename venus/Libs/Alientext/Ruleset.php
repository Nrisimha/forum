<?php

namespace Alientext;

class Ruleset{

  public static function plural($var){
    if($var === 1) { return "single";};
    if($var > 1) {return "many";};
  }
}