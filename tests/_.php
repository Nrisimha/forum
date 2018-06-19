<?php
/**********************************************/
namespace Tests;   require("./_TestHelper.php");
/**********************************************/
echo('*******************************'.PHP_EOL);
echo('********** Mini test **********'.PHP_EOL);
echo('*******************************'.PHP_EOL);
/**********************************************/

use Shared\Locker\Session as Locker;

$locker = new Locker($di);
$userLocks = [
  'view' => [
  'blocks' => ['banned'],
  'keys'=> ['admin','moderator']
  ],
  'edit' => [
  'keys'=> ['superadmin']
  ],
  'search' =>[
  'default_allow'=> true
  ],
  'disallow' =>[
  'default_allow'=> false
  ],
  'empty' =>[]
];

//Check defaults
assertTrue($locker->unlock('_open_'),'unlock _open_');
assertFalse($locker->unlock('user_add'),'unlock not exist lock');

//Add roles
$locker->addLocks($userLocks);
message('new locks added');
$locker->addKey('admin');
message('new key "admin" added');
assertEqual($locker->getKeys(),['everyone','admin'],'"admin" added');
$locker->addKey(['admin','moderator']);
message('new keys "admin" and "moderator" added');
assertEqual($locker->getKeys(),['everyone','admin','moderator'],'"admin" ignored and "moderator" added');

//Unlock
assertTrue($locker->unlock('_open_'),'unlock _open_');
assertFalse($locker->unlock('user_add'),'unlock not exist lock');
assertTrue($locker->unlock('view'),'use a key');
assertFalse($locker->unlock('edit'),'reject a key');
assertTrue($locker->unlock('search'),'default allowed lock');
assertFalse($locker->unlock('disallow'),'default disallowed lock');
assertFalse($locker->unlock('empty'),'empty lock');

//Block
$locker->addKey('banned');
message('new key "banned" added');
assertFalse($locker->unlock('view'),'block an user');

/*********************************************************************************/
/****************************** Mini test functions ******************************/
/*********************************************************************************/
function assertTrue($x,$m){($x)? passed_message($m):failed_message($m);}
function assertFalse($x,$m){(!$x)? passed_message($m):failed_message($m);}
function assertEqual($x,$y,$m){($x == $y)? passed_message($m):failed_message($m);}
function passed_message($m){echo('Passed test: '.$m.' test.'.PHP_EOL);}
function failed_message($m){echo('FAILED TEST: '.$m.' test. <---FAIL--->'.PHP_EOL);}
function message($m){echo('<Metehan> '.$m.' '.PHP_EOL);}echo(PHP_EOL);/*********************************************************************************/