<?php
//NOTE: check http://uploads.im/apidocs

namespace Venus\Apps\Main\Controllers;

class FileController extends ControllerBase
{    
    public function uploadAction($folder='upload',$subfolder='main')
    {
        //Die if user not logged in
        if(!$this->locker->unlock('__user')){
            $this->response->setStatusCode(401, "Unauthorized");
            $this->response->setContent('Login is necessary to upload files.');
            $this->response->send();
            die();
          }
        if ($this->request->hasFiles() == true) {

            /*
            * Check if another file sent recently
            */
            if (isset($this->persistent->file_sent)) {
                $a = $this->persistent->file_sent +20;
                $b = time();
                if($a > $b){
                    $c = $a-$b;
                        $this->response->setStatusCode(400, "Bad Request");
                        $this->response->setContent('Request frequency is higher than allowed please wait '.$c.' seconds');
                        $this->response->send();
                        die();
                }
            }

            /*
            * Get only one file per request
            */
            $file = $this->request->getUploadedFiles()[0];
            if($file->getSize()>1000000){
                $this->response->setStatusCode(400, "Bad Request");
                $this->response->setContent("File size must be smaller than 100000");
                $this->response->send();
                die();}

            /*
            * Chek if allowed filetype (jpg,gif,png)
            */
            $rtype = $file->getRealType();
            if($rtype == 'image/jpeg' || $rtype == 'image/gif' || $rtype == 'image/png'){

                //Define file extension
                if($rtype=='image/jpeg') $ext = 'jpg';
                if($rtype=='image/gif') $ext = 'gif';
                if($rtype=='image/png') $ext = 'png';


                //Define folder
                $nick = $this->session->get('nick');
                $date_dHis = date('dHis');
                $date_Ym = date('Ym');
                if($folder == 'forum'){
                    $remotename="forum/$subfolder/$date_Ym/$nick-$date_dHis.$ext";
                }elseif($folder == 'wiki'){
                    $remotename="wiki/$subfolder/$nick/$date_Ym$date_dHis.$ext";
                }else{
                    $remotename="upload/$subfolder/$date_Ym/$nick-$date_dHis.$ext";
                }

                //B2 Confguration //fixLater: move to config
                $b2conf=[
                    'accountId'=>'f2563f3dadc7', 
                    'applicationKey'=>'001afd8c52afbbaba763c2dfcf32167afc343176bf', 
                    'bucketId'=> '8f52859673bff31d5aad0c17'];
                $b2url = 'https://static.FORUM.net/file/salabox/';
                $b2 = new \Shared\B2($b2conf);

                //Get uploaded file information and echo
                $result = $b2->uploadFile($file->getTempName(),$remotename);              
                echo($b2url.$result->fileName);
                $this->persistent->set('file_sent',time());

                
            }else{
                //If filetype is not allowed 
                $this->response->setStatusCode(400, "Bad Request");
                $this->response->setContent("Only JPEG, GIF and PNG files are allowed.");
                $this->response->send();
                die();
            }

            
        }else{
            //If there is no attachment
            $this->response->setStatusCode(400, "Bad Request");
            $this->response->setContent("Request must has an attach");
            $this->response->send();
            die();
        }
    }
}
