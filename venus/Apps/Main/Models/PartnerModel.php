<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;
use DateTime;
class PartnerModel extends Model
{
  protected $collectionName = "players";
  public function getAllUsers($ref){
    $q = "
    FOR user IN $this->collectionName filter user.ref=='$ref'
    RETURN user
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
  public function addPayment($partner_key, $land, $time, $amount, $notes=null, $method){
    //$this->set('time', time());
    $this->collectionName = "payments";
    $this->set('land',$land);
    $this->set('time',$time);
    $this->set('amount',(double)$amount);
    $this->set('notes',$notes);
    $this->set('payment_method',$method);
    $this->set('partner_key',$partner_key);
    $this->save();
    $this->collectionName = "players";
  }
  public function getPayments($key){
    $q = "
    FOR payment IN payments filter payment.partner_key=='$key'
    RETURN payment
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
  public function getPaymentsLands(){
    $q = "
    for payment in payments 
    return distinct payment.land
    ";
    /*if(isset($lands)){
      $q = $q . " && (";
      for($i = 0; $i<count($lands)-1;$i++){
        $q = $q . "payment.land like " . $lands[$i] . " || ";
      }
      $q = $q . "payment.land like " . $lands[count($lands)-1] . ")";
    }

    $q = $q . " return distinct payment.land";*/
    return $this->executeAql($q)->getAll();
  }
  public function getPaymentsSum($land, $key, $dateInThePast){
    $q = "
    return sum(
      (
        FOR payment IN payments 
        filter payment.land=='$land' && payment.partner_key=='$key' && payment.time>=$dateInThePast 
        return payment.amount
        )
        )
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value;
    }
    return $results[0];
  }
  public function getClicks($short_land, $ref, $from){
    $q = "
    FOR user IN $this->collectionName filter user.ref=='$ref' && user.land=='$short_land' && user.time>=$from 
    RETURN user
    ";
    $count = $this->executeAql($q)->getCount();
    return $count;
  }
  public function getRegistered($ref, $land, $from){
    $q = "
    FOR user IN $this->collectionName 
    filter user.ref=='$ref' && user.land=='$land' && user.registration!=null && user.registration.registered==true && user.registration.time>=$from 
    RETURN user
    ";
    $count = $this->executeAql($q)->getCount();
    return $count;
  }
  public function getUsers($short_land, $ref, $interval){
    $q = "
    let purch = (FOR user IN $this->collectionName filter user.ref=='$ref' && user.land=='$short_land' && user.purchases!=null
    let purchases = (
    for purchase in user.purchases filter purchase.time>=$interval
    return purchase)
    RETURN {media:user.media,land:user.land, purchases})
    for p in purch filter LENGTH(p.purchases)>0
    return p
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
  public function getAllPartnerUsers($ref, $dateInThePast){
    $q = "
    let purch = (FOR user IN $this->collectionName filter user.ref=='$ref' && user.purchases!=null
    let purchases = (
    for purchase in user.purchases filter purchase.time>=$dateInThePast
    return purchase)
    RETURN {media:user.media,land:user.land, purchases})
    for p in purch filter LENGTH(p.purchases)>0
    return p
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
  public function findPartner($column, $value){
    $q = "
    FOR partner IN users filter partner.$column=='$value'
    RETURN partner
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results[0]  ;
  }
  ////////////////////////save in spec class!!!
public function apply(array $input, $nextPosition, $filter)
{
    if (empty($input)) {
        return 0;
    }
    if (count($input) < 2) {
        return reset($input);
    }
    $y0 = reset($input);
    $x0 = DateTime::createFromFormat($filter, (key($input)))->getTimestamp();
    $y1 = end($input);
    $x1 = DateTime::createFromFormat($filter, (key($input)))->getTimestamp();

    $y = $y0 + ($y1 - $y0) * ($nextPosition - $x0) / ($x1 - $x0);
    return $y * (sin($nextPosition) / 2 + 1);
}
public function getAllGames(){
  $q = "
  FOR game IN land_pages
  RETURN game
  ";
  
  $results = [];
  foreach ($this->executeAql($q)->getAll() as $key => $value) {
      $results[$key] = $value->getAll();
  }
  return $results;
}
public function getGame($short_land){
  $q = "
  FOR game IN land_pages filter game.short == '$short_land' limit 1
  RETURN game
  ";
  
  $results = [];
  foreach ($this->executeAql($q)->getAll() as $key => $value) {
      $results[$key] = $value->getAll();
  }
  return $results[0];
}
public function getGameAddress($land){
  $q = "
      for game in land_pages 
      filter game.short == '$land'
      return game.address";
      $results =[];
      $result = $this->executeAql($q)->getAll();
      if(isset($result[0])){
        foreach ($result as $key => $value){
          $results[$key] = $value;
        }
        return $results[0];
      }
      return null;
}
public function getAllBanners($land){
  $q = "
  FOR game IN land_pages
  FILTER game.short=='$land'
  RETURN game.banners
  ";

  $results =[];
  $result = $this->executeAql($q)->getAll();
  if(isset($result[0])){
    foreach ($result as $key => $value){
      $results[$key] = $value->getAll();
    }
    return $results[0];
  }
  return null;
}
public function addPartnerToLandPages($partnerKey){
  $q = "
      FOR game IN land_pages
      return game._id
    ";
    
    $this->edgeName = 'partners';
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $this->createEdge('users/'.$partnerKey,$value, ["rate"=>0,"ARPU"=>0.6]);
    }
    
}
public function removePartnerFromLandPages($key){
  $q = "
      for game in land_pages
      FOR partner IN partners filter game._id==partner._to and partner._from==CONCAT('users/','$key')
      REMOVE { _key: partner._key } IN partners
    ";
    $this->executeAql($q);
    
}
public function getPartnerSite($key){
  $q = "
        for partner IN partners filter partner._key='$key'
        return partner.ref";
}
public function getPartnerRate($land, $key){
  $q = "
      for game in land_pages filter game.short=='$land'
      FOR partner IN partners filter game._id==partner._to and partner._from==CONCAT('users/','$key')
      return partner.rate
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value;
    }
    return (isset($results[0]))?$results[0]:null;
}
public function setPartnerRate($land, $key, $rate){
  $q = "
  for game in land_pages filter game.short=='$land'
  FOR partner IN partners filter game._id==partner._to and partner._from==CONCAT('users/','$key')
  UPDATE partner with {rate:$rate}
  in partners
    ";
    
    $this->executeAql($q);
}
public function getPartnerARPU($land, $key){
  $q = "
      for game in land_pages filter game.short=='$land'
      FOR partner IN partners filter game._id==partner._to and partner._from==CONCAT('users/','$key')
      return partner.ARPU
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value;
    }
    return (isset($results[0]))?$results[0]:null;
}
public function setPartnerARPU($land, $key, $ARPU){
  $q = "
  for game in land_pages filter game.short=='$land'
  FOR partner IN partners filter game._id==partner._to and partner._from==CONCAT('users/','$key')
  UPDATE partner with {ARPU:$ARPU}
  in partners
    ";
    
    $this->executeAql($q);
}
}