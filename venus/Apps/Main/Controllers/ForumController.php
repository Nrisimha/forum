<?php
namespace Venus\Apps\Main\Controllers;
use Venus\Apps\Main\Models\ForumModel;

class ForumController extends ControllerBase{
    
    /**
    * Get's all categories list for a language
    *
    * @return void
    */
    public function indexAction(){
        $model = new ForumModel($this->connection);
        $language = $this->view->lang;
        $this->view->data = $model->getGroup($language);
    }
    
    /**
    * topicsAction
    * Display all topics for given category
    *
    * @param string $category
    * @param int $page
    * @return void
    */
    public function topicsAction($category,$page=1){
        $model = new ForumModel($this->connection);
        $category = $this->filter->sanitize($category,'string');
        
        /*
        * If category not found
        */
        if(!$model->isCategoryExist($category)){
            return $this->dispatcher->forward(["controller" => "end","action"=> "http404"]);
        }
        
        /*
        * If there is post data
        */
        if($this->request->isPost()){
            if(!$this->locker->unlock('forum_newtopic')) die("Unauthorized access");
            if($this->slowdown->newsubject(60)){
                /*
                * Clean xss and check if it's long enough
                */
                $subject = $this->filter->sanitize($this->request->getPost('subject'),'string');
                $message = \Shared\Input::xssClean($this->request->getPost('content'));
                if(strlen($message)<25 || strlen($subject)<5){
                    $this->flash->error($this->text->assign('minimum_content_lenght_must_be_CONL_and_subject_SUBL_characters',['conl'=>'25','subl'=>'5']));
                }else{
                    /*
                    * Save to database
                    */
                    $model->newSubject($category,$subject,$message,$this->session->get('user_key'));
                    $this->flash->success($this->text->simple('the_new_topic_is_created'));
                    $this->slowdown->newsubject('start');
                }
                
            }else{
                $this->flash->error($this->text->simple('you_cant_create_new_topics_this_often_please_wait'));
            }
        }
        if(!is_int((int)$page)){$page = 1;};$page--;//workaround for a phalcon bug
        $perPage = 50;
        $categoryData = $model->getCategory($category,$page,$perPage);
        $this->view->data = $categoryData;
        $this->view->on_page = $page +1;
        $this->view->total_page = $categoryData['category']['total_topics'] / $perPage;
    }
    
    /**
    * topicAction
    * Display a topic and handle reply form
    *
    * @param int $id
    * @return void
    */
    public function topicAction($id,$page = 1){
        $model = new ForumModel($this->connection);
        
        /*
        * If subject not found
        */
        if(!$model->isSubjectExist((int)$id)){
            return $this->dispatcher->forward(["controller" => "end","action"=> "http404"]);
        }
        
        /*
        * If there is post data
        */
        if($this->request->isPost()){
            if(!$this->locker->unlock('forum_reply')) die("Unauthorized access");
            if($this->slowdown->postmessage(20)){
                /*
                * Clean xss and check if data longer than 50 char
                */
                $message = \Shared\Input::xssClean($this->request->getPost('content'));
                if(strlen($message)<20){
                    $this->flash->error($this->text->assign('the_message_must_be_longer_than_S_chars','20'));
                }else{
                    /*
                    * Save to database
                    */
                    $model->replyToSubject((int)$id,$message,$this->session->get('user_key'));
                    $this->flash->success($this->text->simple('your_message_has_been_added'));
                    $this->slowdown->postmessage('start');
                }
                
            }else{
                $this->flash->error($this->text->simple('you_cant_send_messages_this_often_please_wait'));
            }
        }
        
        /*
        * Generate content
        */
        if(!is_int((int)$page)){$page = 1;};$page--;//workaround for a phalcon bug
        $perPage = 20;
        $topicData = $model->getSubject((int)$id,$page,$perPage);
        $this->view->topic = $topicData;
        $this->view->on_page = $page +1;
        $this->view->total_page = ($topicData['subject']['replies']+1) / $perPage;
    }
    
    /**
    * deleteMsgAction
    *
    * @param int $id
    * @return void
    */
    public function deleteMsgAction($id){
        $id = $this->filter->sanitize($id,'int');
        $json['id'] = $id;
        
        if($this->locker->unlock('__employee')){
            $model = new ForumModel($this->connection);
            $model->deleteMessage((int)$id);
            $json['deleted'] = true;
            $json['message'] = "Message $id is deleted.";
        }else{
            $json['deleted'] = false;
            $json['message'] = "You don't have permission to delete this item.";
        }
        
        $this->sendJson($json);
    }
    
    /**
    * deleteSubjectAction
    *
    * @param int $id
    * @return void
    */
    public function deleteSubjectAction($id){
        $id = $this->filter->sanitize($id,'int');
        $json['id'] = $id;
        
        if($this->locker->unlock('__employee')){
            $model = new ForumModel($this->connection);
            $model->deleteSubject((int)$id);
            $json['deleted'] = true;
            $json['message'] = "Subject $id is deleted.";
        }else{
            $json['deleted'] = false;
            $json['message'] = "You don't have permission to delete this item.";
        }
        
        $this->sendJson($json);
    }
    
    /**
    * editMsgAction
    *
    * @param int $id
    * @return void
    */
    public function editMsgAction($id,$subjectkey){
        $model = new ForumModel($this->connection);
        /*
        * If there is post data
        */
        if($this->request->isPost()){
            if(!$this->locker->unlock('__employee')) die("Unauthorized access");// Check user role
            // if(!$this->security->checkToken($this->request->getPost('csrf'))) die("CSRF error");// Check CSRF token
            if($this->slowdown->postmessage(5)){
                /*
                * Clean xss and check if data longer than 50 char
                */
                $message = \Shared\Input::xssClean($this->request->getPost('content'));
                if(strlen($message)<50){
                    $this->flash->error($this->text->assign('the_message_must_be_longer_than_S_chars','50'));
                }else{
                    /*
                    * Save to database
                    */
                    $model->editMessage((int)$id,$message);
                    $this->flash->success($this->text->simple('your_message_has_been_added'));
                    $this->slowdown->postmessage('start');
                }
            }else{
                $this->flash->error($this->text->simple('you_cant_send_messages_this_often_please_wait'));
            }
        }
        
        $this->view->data = $model->getMessage((int)$id);
        $this->view->subjectkey = (int)$subjectkey;
    }
}