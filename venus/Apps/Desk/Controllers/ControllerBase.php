<?php
namespace Venus\Apps\Desk\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
      /*
      * CORS enable
      */
      //$this->response->setHeader('Access-Control-Allow-Origin', '*.salagame.net');
      /*
      * Load Lockers
      */
      $this->locker->addLocks(include(__DIR__.'/../Config/Locker.php'));

      /*if(!$this->locker->unlock('__user')){
        //@todo make user -> employee
        $this->response->setStatusCode(401, "Unauthorized");
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setContent('{"http-error":"You need to login to use desk."}');
        $this->response->send();
        die();
      }/**/

    }

    public function sendJson($data) {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo(json_encode($data));
        return $this->response;
      
    }
}
