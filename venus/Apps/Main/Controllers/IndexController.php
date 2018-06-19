<?php

namespace Venus\Apps\Main\Controllers;

use Pharango\Model;
use Venus\Apps\Main\Models\IndexModel;
use Venus\Apps\Main\Forms\Signupform;

class IndexController extends ControllerBase
{
    
    public function indexAction()
    {
        if(isset($_SERVER['HTTP_REFERER'])) {
            $this->session->set('ref',$_SERVER['HTTP_REFERER']);
        }
        else{
            $this->session->set('ref',"");
        }
    }
    public function RefAction(){
        $model = new IndexModel($this->connection);
        $model->set('time', time());
        $data = $this->dispatcher->getParams();$_GET;
        if(isset($_GET['referrer'])){
            $data['ref'] = $_GET['referrer'];
            //unset($data[0]);
        }
        if(isset($_GET['media'])){
            $data['media'] = $_GET['media'];
            //unset($data[1]);
        }
        if(isset($_GET['land'])){
            $data['land'] = $_GET['land'];
            //unset($data[2]);
            $land = $model->land($data['land']);
        }
        //$data = parse_url($params, PHP_URL_QUERY);
        
        
        if(isset($_SERVER['REMOTE_ADDR'])){
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
        }
        $data['sgid'] = uniqid();
        foreach($data as $key => $value){
            $model->set($key, $value);
        }
        $model->save();
        $this->response->redirect($land['address']."?id=".$data['sgid']);// for example http://d2fr.FORUM.com/d2fr/index.html?id=555555
            // also, on the 'adres' must be sent sgid of the player so we can send back that he was registered or not
    }
    public function RegisteredAction($sgid){
        $model = new IndexModel($this->connection);
        if($model->findOne(['sgid' => $sgid])){
            $model->set('registered.registered',true);
            $model->set('registered.time',time());
            $model->update();
        }
        
    }
    public function ProcPaidAction(){
        $model = new IndexModel($this->connection);
        if ($this->request->isPost()){
            $public_key = file_get_contents(__DIR__.'/../Config/public_key.pem');
            $pk = openssl_pkey_get_public($public_key);
            //$decr = array();
            //openssl_private_decrypt($_POST['all_data_in_one_string'], $decrypted_post, $sk);
            //$decrypted_post = json_decode($decrypted_post);
            $json['status'] = 'did not process';
            $_POST['time'] = intval($_POST['time']);
            $data = $_POST;
            unset($data['sign']);
            $data = json_encode($data);
            //check if signafication is right and request is unique (not repeated one)
            $verify = openssl_verify($data, $_POST['sign'], $pk, "sha256WithRSAEncryption");
            $repeated = $model->isInPurchases($this->request->getPost('sgid'), $this->request->getPost('time'));
            if($verify && !$repeated){
                // this is a new not repeated transaction, work with it
                if($model->addPurhause($this->request->getPost('sgid'),(double)$this->request->getPost('amount'),$this->request->getPost('currency'), $this->request->getPost('time'))){
                    $json['status'] = 'accepted';
                }else{
                    $json['status'] = 'rejected, no such sgid';
                }
            } else{
                $json['status'] = 'rejected';
            }
            

            $this->sendJson($json);
        }
    }
}
