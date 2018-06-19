<?php

namespace Venus\Apps\Desk\Controllers;

class EndController extends ControllerBase
{
    public function http404Action()
    {
        $this->response->setStatusCode(404, "Not Found");
        $arrayName = array(
          "http-error" => "Not Found"
        );
      
        $this->sendJson($arrayName);
    }

    public function http400Action()
    {
        $this->response->setStatusCode(400, "Bad Request");
        $arrayName = array(
          "http-error" => "Bad Request"
        );
      
        $this->sendJson($arrayName);
    }
}

