<?php

namespace Venus\Apps\Main\Controllers;

use Venus\Apps\Main\Forms\Testform;
use Venus\Apps\Main\Forms\SignupForm;
use Venus\Apps\Main\Forms\PartnerForm;
use Venus\Apps\Main\Forms\PaymentForm;
use Venus\Apps\Main\Forms\LoginForm;
use Venus\Apps\Main\Forms\UsernameForm;
use Venus\Apps\Main\Forms\SalaSignupForm;
use Venus\Apps\Main\Models\UserModel;
use Venus\Apps\Main\Models\PartnerModel;
use Venus\Apps\Main\Models\LoginWithModel;
use Shared\SalaLogin;

use DateTime;
use DateInterval;
class UserController extends ControllerBase
{
    /**
     * sRegister
     * Registers user with FORUM.com api
     * 
     * @return void
     */
    public function sregisterAction()
    {
        $registerform  = new SalaSignupForm();
        $this->view->form = $registerform;

          if ($this->request->isPost()) {
            if ($registerform->isValid($this->request->getPost())) {

                $usermodel = new UserModel($this->connection);
                $salacom = new SalaLogin();

                  if($salacom->register($this->request->getPost('email'),$this->request->getPost('password'))){
                    $this->persistent->set('temp_mail', $this->request->getPost('email'));
                    $this->persistent->set('temp_pass', $this->request->getPost('password'));
                    $this->response->redirect($this->view->lang.'/user/newnick');
                  }else{
                    $this->flash->error($this->text->simple('if_you_registered_on_FORUMcom_you_can_login_with_it'));
                  }
            }//if formvalid
          }//if ispost
    }//sregisterAction

    /**
     * sLogin
     * Login with FORUM api
     * 
     * @return void
     */
    public function sLoginAction()
    {
        if(!isset($_SESSION['redirUrl'])){
          if(isset($_SERVER['HTTP_REFERER'])){
            $_SESSION['redirUrl'] =  $_SERVER['HTTP_REFERER'];
          }
        }
        $loginform = new LoginForm();
        $this->view->form = $loginform;

        if ($this->request->isPost()) {
          if ($loginform->isValid($this->request->getPost())) {
            $loginmodel = new LoginWithModel($this->connection);
            $salacom = new SalaLogin();

            if($loginmodel->findOne(['email'=>$this->request->getPost('email'),'vendor'=>'salacom'])){
              if ($salacom->login($this->request->getPost('email'),$this->request->getPost('password'))){
                $this->loginDo($loginmodel->get("user"));
                  } 
                  else {
                    $this->flash->error($this->text->simple('wrong_email_or_password'));
                  }//password check
                }
                else{
                  if($salacom->login($this->request->getPost('email'),$this->request->getPost('password'))){
                    $this->persistent->set('temp_mail', $this->request->getPost('email'));
                    $this->persistent->set('temp_pass', $this->request->getPost('password'));
                    $this->response->redirect($this->view->lang.'/user/newnick');
                  }else{
                    $this->flash->error($this->text->simple('there_is_no_user_with_this_email'));
                  }
                }//email check
            }//if formvalid
          }//if ispost

    }//sloginAction
    private function loginDo($userKey){
      if(!isset($_SESSION['redirUrl'])){
        if(isset($_SERVER['HTTP_REFERER'])){
          $_SESSION['redirUrl'] =  $_SERVER['HTTP_REFERER'];
        }
      }
      $usermodel = new UserModel($this->connection);
      $usermodel->read($userKey);
      if(empty($_SESSION['redirUrl'])){
        header( "refresh:1; url=".$this->view->lang.'/forum' );}
      else{
        header( "refresh:1; url=".$_SESSION['redirUrl']);
        $_SESSION['redirUrl'] = null;
      }
      $this->flash->success($this->text->simple('you_have_logged_in'));
      $this->session->set('nick',$usermodel->get("nick"));
      $this->session->set('user_key',$usermodel->getKey());      
      $this->session->set('ref',$usermodel->get("ref"));
      foreach ($usermodel->get("roles") as $value) {
         $this->locker->addKey($value);
      }
    }
    /**
     * newNick
     * When user registers or logins with FORUM api user will choose a nick
     * 
     * @return void
     */
    public function newNickAction()
    {
      if(!isset($_SESSION['redirUrl'])){
        if(isset($_SERVER['HTTP_REFERER'])){ 
          $_SESSION['redirUrl'] =  $_SERVER['HTTP_REFERER'];
        }   
      }    
      $uform = new UsernameForm();
      $this->view->form = $uform;

      if($this->locker->unlock('__user')) die('Fatal Error: User logged in.');
      if(!isset($this->persistent->temp_mail)) die('Fatal Error: No mail is set');

      if ($this->request->isPost()) {
        if ($uform->isValid($this->request->getPost())) {

          $usermodel = new UserModel($this->connection);
          $loginmodel = new LoginWithModel($this->connection);

          $userKey = \Shared\Uuid::generate();

          if($usermodel->isThere('nick',$this->request->getPost('nick'))){
            $this->flash->error($this->text->simple('this_username_is_already_taken'));
          }
          else{
            //Save User
            $usermodel->set("nick", $this->request->getPost('nick', 'alphanum'));
            $usermodel->set("forumtitle", "☆");
            $usermodel->set("avatar", "https://www.gravatar.com/avatar/".md5($this->persistent->temp_mail));
            $usermodel->set("roles", ['user']);
            $loginmodel->set("ref", $this->session->ref);
            $usermodel->set("_key", $userKey);
            $usermodel->save();

            //Save Login
            $loginmodel->set("ref", $this->session->ref);
            $loginmodel->set("user", $userKey);
            $loginmodel->set("vendor", "salacom");
            $loginmodel->set("email", $this->persistent->temp_mail);
            $loginmodel->set("password", $this->persistent->temp_pass);
            $loginmodel->save();

            //Delete temp data
            $this->persistent->remove('temp_mail');
            $this->persistent->remove('temp_pass');

            $this->flash->success($this->text->simple('you_have_registered'));
            $this->loginDo($userKey);

          }//if nick taken
        }//if formvalid
      }//if ispost    
    }//newnickAction

    /**
     * signUp
     * Deprecated internal signup function
     *
     * @return void
     */
    public function signUpAction()
    {
        return $this->dispatcher->forward(["controller" => "end","action"=> "http404"]);
        $hey = $this->security->checkToken();

        $signupform = new SignupForm();
        $this->view->form = $signupform;
        if ($this->request->isPost()) {
            if ($signupform->isValid($this->request->getPost())) {
                $usermodel = new UserModel($this->connection);
                $loginmodel = new LoginWithModel($this->connection);
                if(
                    $loginmodel->isThere('email',$this->request->getPost('email'))
                    ||
                    $usermodel->isThere('nick',$this->request->getPost('nick'))
                
                ){
                    $this->flash->error($this->text->simple('the_email_or_username_already_registered'));
                }else{
                    $userKey = \Shared\Uuid::generate();

                    //Save User
                    $usermodel->set("nick", $this->request->getPost('nick', 'alphanum'));
                    $usermodel->set("forumtitle", "☆");
                    $usermodel->set("avatar", "https://www.gravatar.com/avatar/".md5($this->request->getPost('email')));
                    $usermodel->set("roles", ['user','unconfirmed']);
                    $usermodel->set("_key", $userKey);
                    $usermodel->save();

                    //Save Login
                    $loginmodel->set("user", $userKey);
                    $loginmodel->set("vendor", "email");
                    $loginmodel->set("email", $this->request->getPost('email'));
                    $loginmodel->set("password", $this->security->hash($this->request->getPost('password')));
                    $loginmodel->save();


                    $this->flash->success($this->text->simple('you_have_registered'));
                }
            }//if formvalid
        }//if ispost
    }//signUpAction

    /**
     * login
     * Deprecated internal login function 
     * 
     * @return void
     */
    public function loginAction()
    {
        return $this->dispatcher->forward(["controller" => "end","action"=> "http404"]);
        $loginform = new LoginForm();
        $this->view->form = $loginform;

          if ($this->request->isPost()) {
            if ($loginform->isValid($this->request->getPost())) {

                $usermodel = new UserModel($this->connection);
                $loginmodel = new LoginWithModel($this->connection);

                if($loginmodel->findOne(['email'=>$this->request->getPost('email')])){

                  if ($this->security->checkHash($this->request->getPost('password'),$loginmodel->get("password"))){
                    /*
                    * User logged in
                    */
                    $usermodel->read($loginmodel->get("user"));
                    $this->flash->success($this->text->simple('you_have_logged_in'));
                    $this->session->set('nick',$usermodel->get("nick"));
                    $this->session->set('user_key',$usermodel->getKey());
                    foreach ($usermodel->get("roles") as $value) {
                       $this->locker->addKey($value);
                    }
                  } else {
                    $this->flash->error($this->text->simple('wrong_email_or_password'));
                  }//password check
                }else{
                  $this->flash->error($this->text->simple('there_is_no_user_with_this_email'));
                }//email check
            }//if formvalid
          }//if ispost
    }//loginAction

    /**
     * logout
     * Destroys login session
     * 
     * @return void
     */
    public function logoutAction()
    {
      
      if(!isset($_SESSION['redirUrl'])) {
        if(isset($_SERVER['HTTP_REFERER'])){
          $_SESSION['redirUrl'] =  $_SERVER['HTTP_REFERER'];
        }
      }
      
      $this->locker->destroyKeys();
      session_destroy();

      if(empty($_SESSION['redirUrl'])){
        $this->response->redirect($this->view->lang.'/forum');
      }
      else{
        $this->response->redirect($_SESSION['redirUrl']);
        $_SESSION['redirUrl'] = null;
      }
      
    }
    public function usersAction( $page = 1, $perPage = 10){
      $_SESSION['redirUrl'] =  $_SERVER['REQUEST_URI'];
      if($this->locker->unlock('__employee')) {//die("Unauthorized access");
          $model = new UserModel($this->connection);  
          $page = ($this->request->getPost('page')!=null)?$this->request->getPost('page'):1;
          $perPage = 10;
          $this->view->perPage = $perPage;
              
          if(!is_int((int)$page)){$page = 1;};$page--;
          if($this->request->getPost("perpage") != null){
            if($this->request->getPost("perpage") == $this->text->simple('all_pages')){
                $perPage = $model->usersListCount();
                $this->view->perPage = $perPage;
            }
            else{
                $perPage = $this->request->getPost("perpage");
                $this->view->perPage = $perPage;
            }
          }
          $nick =null;
          if($this->request->getPost('nick') != null){
            $nick = $this->request->getPost('nick');
            $this->view->nick = $nick;
          }
          $data = $model->usersList($page,$perPage, $nick);
          $this->view->total = $model->usersListCount();
          $this->view->data = $data;
          $this->view->on_page = $page +1;
          $this->view->total_page = $model->usersListCount($nick) / $perPage;
      }
      else {
          $this->flash->error($this->text->simple('you_have_no_access'));
      }
      
  }//usersAction
    //move to other class!
  
  public function paymentsAction(){
    $_SESSION['redirUrl'] =  $_SERVER['REQUEST_URI'];
    if($this->locker->unlock('__employee')) {//die("Unauthorized access");
        $model = new UserModel($this->connection);  
        $partner = new PartnerModel($this->connection);  
        $page = ($this->request->getPost('page')!=null)?$this->request->getPost('page'):1;
        $perPage = 10;
        $this->view->perPage = $perPage;
            
        if(!is_int((int)$page)){$page = 1;};$page--;
        
        $selected_lands = null;
        $time_from=null;
        $time_to=null;
        $order_by = null;
        $lands = $partner->getPaymentsLands();
        if($this->request->getPost("perpage") != null){
          if($this->request->getPost("perpage") == $this->text->simple('all_pages')){
              $perPage = $model->paymentsListCount();
              $this->view->perPage = $perPage;
          }
          else{
              $perPage = $this->request->getPost("perpage");
              $this->view->perPage = $perPage;
          }
        }
            if($this->request->getPost('selected_lands') != null){
              $selected_lands = $this->request->getPost('selected_lands');
              //mark lands as selected or not
              for($i = 0; $i < count($lands); $i++){
                $lands[$i] = array('land'=>$lands[$i], 'selected'=>in_array($lands[$i], $selected_lands));
              }
            }else{
                for($i = 0; $i < count($lands); $i++){
                $lands[$i] = array('land'=>$lands[$i], 'selected'=>false);
              }
            }
            if($this->request->getPost('time_from') != null){
              $temp_time_from = $this->request->getPost('time_from');
              $time_from = DateTime::createFromFormat("d/m/Y H:i", $temp_time_from)->getTimestamp();
              $this->view->time_from = $time_from;
            }
            if($this->request->getPost('time_to') != null){
              $temp_time_to = $this->request->getPost('time_to');
              $time_to = DateTime::createFromFormat("d/m/Y h:i", $temp_time_to)->getTimestamp();
              $this->view->time_to = $time_to;
            }
            if($this->request->getPost('order_by') != null){
              $order_by = $this->request->getPost('order_by');
              $this->view->order_by = $order_by;
            }
            $data = $model->paymentsList(
              $page,$perPage, 
            $selected_lands, 
            $time_from,
            $time_to,
            $order_by,
            filter_var($this->request->getPost('order'), FILTER_VALIDATE_BOOLEAN)
          );
            //$this->response->redirect($this->viewconf->baseurl.$this->view->lang .'/user/payments/1/'.$perPage);
        
        
        //init sort_keys array
        $sort_keys = [];
        if(!empty($data)){
          $sort_keys = array_keys($data[0]);
        }
        $this->view->payments_lands = $lands;
        $this->view->total = $model->paymentsListCount();
        $this->view->data = $data;
        $this->view->sort_keys = $sort_keys;
        $this->view->order_by = $this->request->getPost('order_by');
        $this->view->order = filter_var($this->request->getPost('order'), FILTER_VALIDATE_BOOLEAN);
        $this->view->on_page = $page +1;
        $this->view->total_page = $model->paymentsListCount($selected_lands, $time_from, $time_to, $order_by, filter_var($this->request->getPost('order'), FILTER_VALIDATE_BOOLEAN)) / $perPage;
    }
    else {
        $this->flash->error($this->text->simple('you_have_no_access'));
    }
    
}//paymentsAction

  public function editAction($_key){
    if($this->locker->unlock('__employee')){
      $model = new UserModel($this->connection);
      $registerform  = new PartnerForm();
      $this->view->form = $registerform;
      $this->view->data = $model->read($_key)->getAll();
      $this->view->partner = in_array('partner',$this->view->data['roles']);
      if($_key == $this->session->get('user_key') ){
        $nicknames = $model->getNicknames();
        if(isset($this->view->data['added_partners'])){
          for($i = 0;$i<count($nicknames);$i++){
            $nicknames[$i] = array('nick'=>$nicknames[$i], 'selected'=>in_array($nicknames[$i], $this->view->data['added_partners'])); 
        }
        }else{
          for($i = 0;$i<count($nicknames);$i++){
            $nicknames[$i] = array('nick'=>$nicknames[$i], 'selected'=>false); 
        }
        }
      
        $this->view->nicknames = $nicknames;
      }
      if($this->request->isPost()){
        if ($registerform->isValid($this->request->getPost())) {
          $model->set('forumtitle',$this->request->getPost('forumtitle'));
          $model->set('name',$this->request->getPost('name'));
          $model->set('surname',$this->request->getPost('surname'));
          $model->set('company_name',$this->request->getPost('company_name'));
          $model->set('partner_site',$this->request->getPost('partner_site'));
          $model->set('phone',$this->request->getPost('phone'));
          $model->set('info',$this->request->getPost('info'));
          $new_roles = $this->request->getPost('roles');
          $roles = array();
          foreach($new_roles as $key => $item){
            array_push($roles, $key);
          };
          $partnerModel = new PartnerModel($this->connection);
          if(in_array('partner',$roles)){
            //add user's _key to array 'partners' in each element in land_pages  
              $partnerModel->addPartnerToLandPages($_key);
          }else{
            //remove user's key from array 'partners' in each element in land_pages  
            $partnerModel->removePartnerFromLandPages($_key);
          }
          $model->set('roles',$roles);
          $model->set('added_partners',$this->request->getPost('send_to_partner'));

          $model->update();
          $this->response->redirect($this->viewconf->baseurl.$this->view->lang.'/user/edit/'.$_key);
        }
      }
    }
    else {
        $this->flash->error($this->text->simple('you_have_no_access'));
    }
  }
  public function profileAction(){
    if($this->locker->unlock('__user')){
      $model = new UserModel($this->connection);
      $this->view->data = $model->read( $this->session->get('user_key') )->getAll();
      if($this->locker->unlock('__partner')){
        $updateForm  = new PartnerForm();
        $this->view->form = $updateForm;        
      $patner = new PartnerModel($this->connection);
      $this->view->payments = $patner->getPayments($this->session->get('user_key') );
        if($this->request->isPost()){
          $_POST;
          $payout = array();
            if(isset($_POST['payout_method'])){
              
                if(isset($_POST['email'])){
                  if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $payout['method'] = $this->request->getPost('payout_method');
                    $payout['email'] = $this->request->getPost('email');  
                  }else{
                    $this->flash->error($this->text->simple('email_is_required'));
                  return;
                  }    
                }else {
                  $this->flash->error($this->text->simple('email_is_required'));
                  return;
                }
            }
            $model->set('payout',$payout);
            $model->update();
          
        }
      }
    }else {
      $this->flash->error($this->text->simple('you_have_no_access'));
    }
  }
  public function peekAction($user_key = null){
    if($this->locker->unlock('__employee')){
      $model = new UserModel($this->connection);
      $this->view->data = $model->read( $user_key)->getAll();
      $updateForm  = new PartnerForm();
      $this->view->form = $updateForm;              
      $patner = new PartnerModel($this->connection);
      $this->view->payments = $patner->getPayments($user_key);
    }else{
      $this->flash->error($this->text->simple('you_have_no_access'));
    }
  }
  public function employee_panelAction($lang, $format = "Y-m-d", $interval = 'P3M'/*, $month_number = 37*/){
    if($this->locker->unlock('__employee')){   
      $partnerModel = new PartnerModel($this->connection);
      $model = new UserModel($this->connection);
      $paymentForm  = new PaymentForm();
      $user = $model->read($this->session->get('user_key'))->getAll();
      if(isset($user['added_partners'][0])){
          $partner = $partnerModel->findPartner('nick', $user['added_partners'][0]); 
        }else{
          $partner = array();
        }
      $this->view->selected_partner = $partner['nick'];
      if($this->request->isPost()){
        //$partnerModel = new PartnerModel($this->connection);
        $format = rawurldecode($this->request->getPost('format')); 
        $this->view->format = $format;
        $this->view->interval = $this->request->getPost('interval');
        //$this->view->month_number = $this->request->getPost('month_number');
        //load data for choosen partner
        $postFormMarker = $this->request->getPost('get_another_partner');
        $land = $this->request->getPost('land');
        //if filter form is being procesed
        if(isset($postFormMarker)){
          $this->view->selected_partner = $this->request->getPost('send_to_partner');
          $partner = $partnerModel->findPartner('nick', $this->view->selected_partner);    
        } else if($paymentForm->isValid($this->request->getPost())){
            $this->view->selected_partner = $this->request->getPost('partner');
            $partner = $partnerModel->findPartner('nick', $this->view->selected_partner);
             if(isset($partner['payout'])){
              $partnerModel->addPayment($partner['_key'], $land, time(), $this->request->getPost('amount'), $this->request->getPost('notes'), $partner['payout']['method']); 
              $partnerRate = $this->request->getPost('partnerRate');
              $partnerModel->setPartnerRate($land, $partner['_key'], $partnerRate);
              $this->flash->success($this->text->simple('payment_added'));
            }     
            else{
              $this->flash->error($this->text->simple('partner_did_not_choose_payout_method'));
            }
          }
          $_POST;
      }

      $format = rawurldecode($format); 
      $this->view->format = $format;
      $this->view->interval = $interval;
      //$this->view->month_number = $month_number;
      $this->view->currency = '$';

      ///
      $intervalPosition = DateTime::createFromFormat($format, date($format, time()));
      $lastMonth = DateTime::createFromFormat('Y-m', date('Y-m', time()));
      $lastMonth->sub(new DateInterval('P1M'));    
      $this->view->currYear = $lastMonth->format("Y");
      $intervalPosition->sub(new DateInterval($interval));
      $this->view->dateInThePastFromWhichCalculate = $intervalPosition->getTimestamp();
      $this->view->employee_account = $model->read( $this->session->get('user_key') )->getAll();
      $this->view->paymentForm = $paymentForm;
      

      //$user = $model->read($this->session->get('user_key'))->getAll();
      if(isset  ($partner['partner_site'])){
          $this->view->users = $partnerModel->getAllPartnerUsers($partner['_key'], $this->view->dateInThePastFromWhichCalculate);
      }
      else{
          $this->view->users = $partnerModel->getAllPartnerUsers("", $this->view->dateInThePastFromWhichCalculate);
      }
      ///load data for games
      $games = $partnerModel->getAllGames();
      for($i = 0; $i<count($games); $i++){
        $games[$i]['pastPurchases'] = array();
        $games[$i]['media'] = array();
        $games[$i]['land'] = array();
        $games[$i]['sumEarnedAmount'] = 0;
        $games[$i]['sumPaidAmount'] = 0;
        $games[$i]['partnerRate'] = $partnerModel->getPartnerRate($games[$i]['short'], $partner['_key']); 
        if(isset($partner['_key'])){
          $games[$i]['sumPaidAmount'] = $partnerModel->getPaymentsSum($games[$i]['short'], $partner['_key'],$this->view->dateInThePastFromWhichCalculate);
        }
        $games[$i]['numberOfRegisteredPlayers'] = $partnerModel->getRegistered($partner['_key'], $games[$i]['short'], 0);
        foreach($this->view->users as $user){
            //collect games[$i]['media'] here
            if($user['land'] == $games[$i]['short']){
                array_push($games[$i]['media'], $user['media']);
                array_push($games[$i]['land'], $user['land']);
                
                if(isset($user['purchases'])){
                    
                    foreach($user['purchases'] as $purchase){
                        $time = date($format, $purchase['time']);
                        //put purchase to created cell if it was at the same time interval made otherwise put to a new cell
                        if(array_key_exists($time,$games[$i]['pastPurchases']))  {
                            $games[$i]['pastPurchases'][$time] += $purchase['amount'];
                        } else{
                            $games[$i]['pastPurchases'][$time] = $purchase['amount'];
                        }
                        $games[$i]['sumEarnedAmount']+=$purchase['amount'];
                    }
                }
            }
        }
        $games[$i]['media'] = array_count_values($games[$i]['media']);
        $games[$i]['land'] = array_count_values($games[$i]['land']);
        ksort($games[$i]['pastPurchases']);
      }
      $this->view->games = $games;
    }else {
      $this->flash->error($this->text->simple('you_have_no_access'));
    }
  }

}