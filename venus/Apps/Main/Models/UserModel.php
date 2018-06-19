<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;

class UserModel extends Model
{
  protected $collectionName = "users";
  

  public function getNicknames(){
    $q = "
    for user in users 
    return user.nick
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value;
    }
    return $results;
  }
  public function usersList($offset,$perPage, $nick=null){
    $q = "
    for user in users";
    if(isset($nick)){
      $q = $q . " filter user.nick like '%$nick%'";
    }
    $q = $q . " LIMIT $offset,$perPage RETURN user";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
  public function usersListCount($nick=null){
    $q = "
    for user in users";
    if(isset($nick)){
      $q = $q . " filter user.nick like '%$nick%'";
    }
    $q = $q . " RETURN user._key";
    
    $count = $this->executeAql($q)->getCount();
    return $count;
  }//usersListCount
  public function paymentsList($offset,$perPage, $selected_lands=null, $time_from=null, $time_to=null, $order_by=null, $order=null){
    $q = "
    for payment in payments";
    if(isset($selected_lands)){
      foreach($selected_lands as $land){
        $q = $q . " filter payment.land == '$land'";
      }
    }
    if(isset($time_from)){
      $q = $q . " filter payment.time >= $time_from";
    }
    if(isset($time_to)){
      $q = $q . " filter payment.time <= $time_to";
    }
    if(isset($order_by)){
      if(isset($order)){
        if($order){
          $q = $q . " SORT payment.$order_by ASC";
        }else{
          $q = $q . " SORT payment.$order_by DESC";
        }
      }else{
        $q = $q . " SORT payment.$order_by ASC";
      }
    }
    $q = $q . " LIMIT $offset,$perPage
    return payment
    ";
    
    $results = [];
    foreach ($this->executeAql($q)->getAll() as $key => $value) {
        $results[$key] = $value->getAll();
    }
    return $results;
  }
  public function paymentsListCount($selected_lands=null, $time_from=null, $time_to=null, $order_by=null, $order=null){
    $collection = $this->collectionName;
    $q = "
    for payment in payments";
    if(isset($selected_lands)){
      foreach($selected_lands as $land){
        $q = $q . " filter payment.land == '$land'";
      }
    }
    if(isset($time_from)){
      $q = $q . " filter payment.time >= $time_from";
    }
    if(isset($time_to)){
      $q = $q . " filter payment.time <= $time_to";
    }
    if(isset($order_by)){
      if(isset($order)){
        if($order){
          $q = $q . " SORT payment.$order_by ASC";
        }else{
          $q = $q . " SORT payment.$order_by DESC";
        }
      }else{
        $q = $q . " SORT payment.$order_by ASC";
      }
    }
    $q = $q . " RETURN payment._key";
    
    $count = $this->executeAql($q)->getCount();
    return $count;
  }//paymentsListCount
  public function deletePayment($id){
    $this->collectionName = 'payments';
    $this->findOne(['_key' => $id]);
    //$this->set('hidden',true);
    return $this->delete();
    $this->collectionName = 'users';
}//deleteMessage
}