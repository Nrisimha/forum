<?php
namespace Venus\Apps\Desk\Controllers;

class MainController extends ControllerBase
{
    public function indexAction(){
    }//indexAction


    public function getuserAction(){
      $arrayName = array(
        "id" => 1,
        "name" => "Diego Nava",
        "email" => "diego@salagame.net"
      );
    
      $this->sendJson($arrayName);
    }
}

