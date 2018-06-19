<?php
namespace Venus\Apps\Desk\Controllers;

class TicketController extends ControllerBase
{
    public function indexAction(){
        
    }//indexAction
    
    public function getallAction(){
        echo $this->faker->numberBetween($min = 1000, $max = 9000);
    }//getAll
    
    public function alllabelsAction(){
        $labels['tags'] = array ('angry','german','refund',
        'error','question','vip','persistent','solved','lostitem','event','connection','bug','payment','help','guide','star');
        $labels['statuses'] = array ('open','closed','pending','waiting','solved','spam');
        $this->sendJson($labels);
    }
    
    public function ticketListAction(){
        $tickets = [];
        
        for ($i=0; $i < 20; $i++ ) {
            $tickets[] = array(
            'id' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'user' => $this->faker->userName,
            'subject' => $this->faker->text($maxNbChars = 20),
            'overwrite_subject' => $this->faker->text($maxNbChars = 70),
            'tags' => $this->faker->randomElements($array = array ('angry','german','refund',
            'error','question','vip','persistent','solved','lostitem','event','connection','bug','payment','help','guide'), $count = 2),
            'status' => $this->faker->randomElements($array = array ('open','closed','pending',
            'pending','open','waiting','solved','spam'), $count = 1)[0],
            'date' => (time() - rand(80000,900000)),
            'last_date' => (time() - rand(70,70000)),
            'user_messages' => rand(1,24),
            'agent_messages' => rand(1,24),
            'last_message_from' => $this->faker->randomElements(
            $array = array ('user','agent'), $count = 1)[0],
            'handler_agent' => $this->faker->randomElements(
            $array = array ('diego','metehan','maksym','emilia','alicja'), $count = 1)[0]
            , 'custom_fields' => []
            );
        }
        $this->sendJson($tickets);
    }
    
    
    public function sampleTicketAction(){
        $ticket = array(
        'id' => $this->faker->numberBetween($min = 1000, $max = 9000),
        'user' => $this->faker->userName,
        'subject' => $this->faker->text($maxNbChars = 80),
        'overwrite_subject' => $this->faker->text($maxNbChars = 70),
        'tags' => $this->faker->randomElements($array = array ('angry','german','refund',
        'error','question','vip','persistent','solved','lostitem','event','connection','bug','payment','help','guide'), $count = 2),
        'status' => $this->faker->randomElements($array = array ('open','closed','pending',
        'pending','open','waiting','solved','spam'), $count = 1)[0],
        'date' => time() - rand(80000,900000),
        'last_date' => time() - rand(70,70000),
        'user_messages' => rand(1,24),
        'agent_messages' => rand(1,24),
        'last_message_from' => $this->faker->randomElements(
        $array = array ('user','agent'), $count = 1)[0],
        'handler_agent' => $this->faker->randomElements(
        $array = array ('diego','metehan','maksym','emilia','alicja'), $count = 1)[0],
        'custom_fields' => array(
        [
        'key' => 'reporter_nick',
        'value' => $this->faker->userName
        ],
        [
        'key' => 'reported_user',
        'value' => $this->faker->userName
        ],
        [
        'key' => 'date',
        'value' => (time() - rand(800000,1000000))."",
        ],
        [
        'key' => 'server',
        'value' => rand(1,64)."",
        ],
        [
        'key' => 'attach',
        'areaType' => 'image',
        'value' => 'http://lorempixel.com/'.rand(400,900).'/'.rand(400,900)
        ],
        [
        'key' => 'message',
        'value' => $this->faker->text($maxNbChars = 800),
        ]
        ),
        'messages' => $this->messageList(),
        'team_discuss' =>$this->agentMessageList(),
        );
        $this->sendJson($ticket);
    }
    
    public function messageList(){
        $messages = [];
        
        $f_user = $this->faker->userName;
        $f_agent = "you";
        
        for ($i=0; $i < 20; $i++ ) {
            $messages[] = array(
            'id' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'user' => $this->faker->randomElements($array = array ($f_user,$f_agent), $count = 1)[0],
            'date' => (time() - rand(70,70000)),
            'message' => $this->faker->text($maxNbChars = 250)
            );
        }
        return $messages;
    }
    
    public function agentMessageList(){
        $messages = [];
        
        $f_user = $this->faker->randomElements($array = array ('zhumin','duncan','simon','choji','wang'), $count = 1)[0];
        $f_agent = $this->faker->randomElements($array = array ('diego','metehan','maksym','emilia','you','you'), $count = 1)[0];
        
        for ($i=0; $i < 20; $i++ ) {
            $messages[] = array(
            'id' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'user' => $this->faker->randomElements($array = array ($f_user,$f_agent), $count = 1)[0],
            'date' => (time() - rand(70,70000)),
            'message' => $this->faker->text($maxNbChars = 250)
            );
        }
        return $messages;
    }
}