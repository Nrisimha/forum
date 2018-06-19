<?php
namespace Venus\Apps\Main\Controllers;
use Venus\Apps\Main\Models\/*{classPrefix}*/Model;
use Venus\Apps\Main\Forms\/*{classPrefix}*/Form;

/*
 * This file created with marsgen.
 * There are things to do.
 * 1 - Alientext language file must be updated.
 * 2 - User roles must be defined.
 */

class /*{classPrefix}*/Controller extends ControllerBase{
    
    /**
    * indexAction
    * Main page for /*{classPrefix}*/
    */
    public function indexAction($page=1){
        $model = new /*{classPrefix}*/Model($this->connection);

        if(!is_int((int)$page)){$page = 1;};$page--;
        $perPage = 10;
        $data = $model->listAll($page,$perPage);
        $this->view->data = $data;
        $this->view->on_page = $page +1;
        $this->view->total_page = $model->countAll() / $perPage;
    }
    
/*{for:filterAreas}*/
    /**
    * /*{filterAreas>name}*/ListAction
    * Display all items for given category
    *
    * @param string $category
    * @param int $page
    */
    public function /*{filterAreas>name}*/ListAction($filter,$page=1){
        $model = new /*{classPrefix}*/Model($this->connection);
        $filterColumn = '/*{filterAreas>name}*/';

        if(!is_int((int)$page)){$page = 1;};$page--;
        $perPage = 3;
        $data = $model->filteredList($filterColumn,$filter,$page,$perPage);
        $this->view->data = $data;
        $this->view->filter = $filter;
        $this->view->on_page = $page +1;
        $this->view->total_page = $model->filteredCount($filterColumn,$filter) / $perPage;
    }

/*{/for}*/     

    /**
    * createAction
    * Create a record
    *
    * @param int $id
    */
    public function createAction(){
        $model = new /*{classPrefix}*/Model($this->connection);
        $createform = new /*{classPrefix}*/Form();
        $this->view->form = $createform;
        
        /*
        * If there is post data
        */
        if($this->request->isPost()){
            if(!$this->locker->unlock('user')) die("Unauthorized access");
            if ($createform->isValid($this->request->getPost())) {
                if($this->slowdown->createitem(20)){
                    /*
                    * Save to database
                    */
                    //$model->set('xssClean', \Shared\Input::xssClean($this->request->getPost('subject')));
                    /*{for:areas}*/
                    $model->set('/*{areas>name}*/',$this->request->getPost('/*{areas>name}*/', 'alphanum'));/*{/for}*/ 
                    //$model->set('time',time();
                    //$model->set('user_key',$this->session->get('user_key'));
                    $itemId = $model->save();

                    $this->flash->success($this->text->simple('the_item_is_created'));
                    $this->slowdown->createitem('start');
                }else{
                    $this->flash->error($this->text->simple('you_cant_create_items_this_often_please_wait'));
                }
            }
        }
    }


    /**
    * readAction
    *
    * @param int $id
    */
    public function readAction($id){
        $model = new /*{classPrefix}*/Model($this->connection);
        $this->view->data = $model->read($id)->getAll();
    }
    
    
    /**
    * updateAction
    *
    * @param int $id
    */
    public function updateAction($id){
        $id = $this->filter->sanitize($id,'alphanum');
        $model = new /*{classPrefix}*/Model($this->connection);
        $updateform = new /*{classPrefix}*/Form();
        $this->view->form = $updateform;
        $this->view->data = $model->read($id)->getAll();
        /*
        * If there is post data
        */
        if($this->request->isPost()){
            if(!$this->locker->unlock('user')) die("Unauthorized access");// Check user role
            if ($updateform->isValid($this->request->getPost())) {
            if($this->slowdown->updateitem(5)){
                /*
                * Save to database
                */
                //$model->set('xssClean', \Shared\Input::xssClean($this->request->getPost('subject')));
                /*{for:areas}*/
                $model->set('/*{areas>name}*/',$this->request->getPost('/*{areas>name}*/', 'alphanum'));/*{/for}*/     
                $model->update();

                $this->flash->success($this->text->simple('your_message_has_been_added'));
                $this->slowdown->updateitem('start');
            }else{
                $this->flash->error($this->text->simple('you_cant_send_messages_this_often_please_wait'));
            }
        }
        }
    }


    /**
    * deleteAction
    *
    * @param int $id
    */
    public function deleteAction($id){
        $id = $this->filter->sanitize($id,'alphanum');
        $json['id'] = $id;
        
        if($this->locker->unlock('user')){
            $model = new /*{classPrefix}*/Model($this->connection);
            $model->read($id);
            $model->delete();
            $json['deleted'] = true;
            $json['message'] = "Message $id is deleted.";
        }else{
            $json['deleted'] = false;
            $json['message'] = "You don't have permission to delete this item.";
        }
        
        $this->sendJson($json);
    }
}