<?php

namespace Shared\Locker;

class Locker{
  private $keys = [];
  private $blockers = [];
  public function initialize(){}
  public function unlock(){}
  public function getBlockers(){}
  public function addKey(){}
  public function addKeys(){}
  public function removeKey(){}
  public function removeKeys(){}
  public function persistKeys(){}
  public function destroyKey(){}
}