<?php
namespace Venus\Apps\Main\Models;

use Pharango\Model;
use Pharango\Document;

class ForumModel extends Model
{
    /**
    * collectionName
    *
    * @var string
    */
    protected $collectionName = '';
    
    /**
    * getSubject
    *
    * @param int $subject
    * @param int $page
    * @param int $perPage
    * @return void
    */
    public function getSubject($subject,$page,$perPage){
        $offset = $page * $perPage;
        $b = [
        'subject'=>(string)$subject
        ];
        $q = "
        LET doc = DOCUMENT(CONCAT('forum_subjects/',@subject))
        UPDATE doc WITH {
            views: doc.views +1
        } IN forum_subjects
        ";
        $this->executeAql($q,$b);
        
        $q = "
        FOR subject IN forum_subjects FILTER subject._key == @subject && subject.hidden != true
        LET messages = (
        FOR msg IN OUTBOUND subject._id forum_reply FILTER msg.hidden != true SORT msg.time LIMIT $offset,$perPage
        LET sender = (RETURN DOCUMENT(CONCAT('users/',msg.by)))
        RETURN {content:msg,  sender:sender[0]})
        RETURN {subject:subject, messages:messages}
        ";
        
        $results = [];
        foreach ($this->executeAql($q,$b)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results[0];
    }//getSubject
    
    /**
    * getCategory
    *
    * @param string $category
    * @param integer $page
    * @param integer $perPage
    * @return array
    */
    public function getCategory($category,$page,$perPage){
        $offset = $page * $perPage;
        $q = "
        LET list = (
        FOR topic IN forum_subjects FILTER topic.category == @category && topic.hidden != true SORT topic.time DESC LIMIT $offset,$perPage
        LET sender = (
        RETURN DOCUMENT(CONCAT('users/',topic.by))
        )
        RETURN {topic:topic,sender:sender[0]}
        )
        LET cat = (RETURN DOCUMENT(CONCAT('forum_categories/',@category)))
        RETURN {category:cat[0], list:list}
        ";
        $b = [
        'category'=>(string)$category
        ];
        
        $results = [];
        foreach ($this->executeAql($q,$b)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results[0];
    }//getCategory
    
    /**
    * isSubjectExist
    *
    * @param int $categoryKey
    * @return boolean
    */
    public function isSubjectExist($subjectKey){
        $this->collectionName = 'forum_subjects';
        return $this->isThere('_key',(string)$subjectKey);
    }//isSubjectExist
    
    /**
    * isCategoryExist
    *
    * @param int $categoryKey
    * @return boolean
    */
    public function isCategoryExist($categoryKey){
        $this->collectionName = 'forum_categories';
        return $this->isThere('_key',(string)$categoryKey);
    }//isCategoryExist
    
    /**
    * Undocumented function
    *
    * @param string $subjectKey
    * @param string $message
    * @param string $sender
    * @return void
    */
    public function replyToSubject($subjectKey,$message,$sender){
        $this->collectionName = 'forum_messages';
        $this->set('message',$message);
        $this->set('time',time());
        $this->set('by',$sender);
        $messageId = $this->save();
        $this->clear();
        
        $this->edgeName = 'forum_reply';
        $this->createEdge('forum_subjects/'.$subjectKey,$messageId);
        
        $b = ['subject'=>(string)$subjectKey];
        $q = "
        LET doc = DOCUMENT(CONCAT('forum_subjects/',@subject))
        UPDATE doc WITH {
            replies: doc.replies +1
        } IN forum_subjects
        ";
        $this->executeAql($q,$b);
    }//replyToSubject

    public function editMessage($id,$message){
        $this->collectionName = 'forum_messages';
        $this->findOne(['_key' => $id]);
        $this->set('message',$message);
        return $this->update();
    }//editMessage

    public function deleteMessage($id){
        $this->collectionName = 'forum_messages';
        $this->findOne(['_key' => $id]);
        $this->set('hidden',true);
        return $this->update();
    }//deleteMessage

    public function deleteSubject($id){
        $this->collectionName = 'forum_subjects';
        $this->findOne(['_key' => $id]);
        $this->set('hidden',true);
        return $this->update();
    }//deleteMessage
    
    /**
    * newSubject
    *
    * @param string $category
    * @param string $subject
    * @param string $message
    * @param string $sender
    * @return void
    */
    public function newSubject($category,$subject,$message,$sender){
        $this->collectionName = 'forum_subjects';
        $this->set('category',$category);
        $this->set('subject',$subject);
        $this->set('replies',0);
        $this->set('views',1);
        $this->set('time',time());
        $this->set('by',$sender);
        $subjectId = $this->save();
        $this->clear();
        
        $this->collectionName = 'forum_messages';
        $this->set('message',$message);
        $this->set('time',time());
        $this->set('by',$sender);
        $messageId = $this->save();
        $this->clear();
        
        $this->edgeName = 'forum_reply';
        $this->createEdge($subjectId,$messageId);
        
        /*
        * Increase category topic count by 1
        */
        $b = ['category'=>(string)$category];
        $q = "
        LET doc = DOCUMENT(CONCAT('forum_categories/',@category))
        UPDATE doc WITH {
            total_topics: doc.total_topics +1
        } IN forum_categories
        ";
        $this->executeAql($q,$b);
    }//newSubject
    
    /**
    * getMessage
    *
    * @param string $key
    * @return array
    */
    public function getMessage($key){
        $b = ['key'=>(string)$key];
        $q = "
        LET msg = DOCUMENT(CONCAT('forum_messages/',@key))
        LET sender = (RETURN DOCUMENT(CONCAT('users/',msg.by)))
        RETURN {content:msg,  sender:sender[0]}
        ";
        
        $results = [];
        foreach ($this->executeAql($q,$b)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results[0];
        
    }//getMessage

    /**
    * getGroup
    *
    * @param string $language two letter language code
    * @return array
    */
    public function getGroup($language){
        $b = ['language'=>(string)$language];
        $q = "
        FOR group IN forum_groups FILTER group.lang == @language SORT group.order
        LET category = (
        FOR category IN forum_categories FILTER category.group == group._key && category.hidden != true SORT category.order
        LET subject = (
        FOR subject IN forum_subjects FILTER subject.category == category._key && subject.hidden != true SORT subject.time DESC LIMIT 0,1
        RETURN subject
        )
        RETURN {category,topic:subject[0]}
        )
        RETURN {group:group,category:category}
        ";
        
        $results = [];
        foreach ($this->executeAql($q,$b)->getAll() as $key => $value) {
            $results[$key] = $value->getAll();
        }
        return $results;
        
    }//getGroup
    
}//class

/*
Forum Levels:
☆ 0
☆☆ 5
☆☆☆ 10
☆★☆ 25
★★★ 40
☆☆☆☆ 60
☆★★☆ 90
☆★★★☆ 120
★★★★★ 150
☆☆☀☆☆ 200
☆☆☀☆☆ 250
☆★☀★☆ 300
★★☀★★ 400
☆☀☆☀☆ 500
☆☀★☀☆ 600
★☀★☀★ 700
★☀☀☀★ 800
☀☀☀☀☀ 900
♛ 1000
☆♛☆ 1300
★♛★ 2000
☆☆♛☆☆ 3000
☆★♛★☆ 4000
★★♛★★ 5000
☆MOD☆
★MOD★
☆★MOD★☆
★★MOD★★
★★ADMIN★★
*/