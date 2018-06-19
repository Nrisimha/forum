<?php
namespace Shared;

class Minitester{
public $ftest=0;public $ptest=0;private $t = [];private $tt = []; private $eol;
public function __construct($eol = PHP_EOL){$this->eol = $eol;}
public function assertTrue($x,$m){($x)? $this->pM($m):$this->fM($m);}
public function assertFalse($x,$m){(!$x)? $this->pM($m):$this->fM($m);}
public function assertEqual($x,$y,$m){($x == $y)? $this->pM($m):$this->fM($m);}
public function pM($m){echo('Passed test: '.$m.' test.'.$this->eol);$this->ptest++;}
public function fM($m){echo('FAILED TEST: '.$m.' test. <---FAIL--->'.$this->eol);$this->ftest++;}
public function m($m){echo('Message: '.$m.' '.$this->eol);}
public function prM($n,$x){echo('Timer: '.$n.' took '.round($x*1000,4).' ms'.$this->eol);}
public function timer($m){$this->t[] = microtime(true);$this->tt[] = $m;}
public function end(){$this->t[] = microtime(true);
  for($i=0;$i<count($this->t)-1;$i++){
    $this->prM($this->tt[$i],$this->t[$i+1]-$this->t[$i]);}
  $total = $this->ftest+$this->ptest;
  echo('---'.$this->eol.'Completed tests: '.$total.' ('.$this->ptest.' passed, '.$this->ftest.' failed)');
  }
}