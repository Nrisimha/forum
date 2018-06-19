<?php

/*$lock['sample'] = [
  'blocks' => ['banned'],
  'keys'=> ['user','moderator']
  'default_allow'=> true
  ];*/

//Forum controller
$lock['forum_reply'] = [
  'blocks' => ['banned'],
  'keys'=> ['user']
  ];

$lock['forum_newtopic'] = [
  'blocks' => ['banned'],
  'keys'=> ['user','validated']
  ];

$lock['forum_moderate'] = [
  'keys'=> ['employee','moderator']
  ];

return $lock;