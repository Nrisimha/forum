<?php
namespace Venus\Apps\Main\Controllers;

use Venus\Apps\Main\Models\BaseModel;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function initialize()
    {
      /*
      * Set language
      */
      $lang = $this->dispatcher->getParam('lang');
      if(isset($lang)){
      $this->view->lang = $lang;
        switch ($lang) {
          case 'tr': $this->text->language('tr_tr'); break;
          case 'fr': $this->text->language('fr_fr'); break;
          case 'pl': $this->text->language('pl_pl'); break;
          case 'pt': $this->text->language('pt_br'); break;
          case 'ru': $this->text->language('ru_ru'); break;
          default  : $this->text->language('en_us'); break;
        }
      }else{
        $this->text->language('en_us');
        $this->view->lang = 'en';
      }

      $this->text->load('default');

      /*
      * CORS enable
      */
      $this->response->setHeader('Access-Control-Allow-Origin', '*.salagame.net');
      /*
      * Load Lockers
      */
        $this->locker->addLocks(include(__DIR__.'/../Config/Locker.php'));
        $base = new BaseModel($this->connection);
        $this->view->lands = $base->getLands();
    }

      public function sendJson($data) {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        echo(json_encode($data));
        return $this->response;
      }
}
