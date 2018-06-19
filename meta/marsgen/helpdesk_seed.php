<?php
//working_dir> marsgen /meta/marsgen/crud /meta/marsgen/helpdesk_seed.php /venus/Apps/Main

// IMPORTANT
// if you run the marsgen code under venus.dev there will be php error
// you should go upper folder and run the code like this
// marsgen generate /venus.dev/meta/marsgen/crud /venus.dev/meta/marsgen/wiki_seed.php /venus.dev/venus/Apps/Main/

$seed = [];
$seed['__FileSystem__'] = [
  '-Crud-' => 'Helpdesk',
  '_crud_' => 'helpdesk'
];
$seed['classPrefix'] = 'Helpdesk';
$seed['classPrefix_'] = 'helpdesk';
$seed['collectionName'] = 'helpdesk_tickets'; // database table


$seed['filterAreas'] = [
  ['name' => 'status'],
  ['name' => 'sender'],
  ['name' => 'lang'],
  ['name' => 'category'],
  ['name' => 'user'],
  ['name' => 'search']
];

$seed['areas'] = [
  ['name' => 'h_subject'],
  ['name' => 'h_summary'],
  ['name' => 'time_created'],
  ['name' => 'time_updated'],
  ['name' => 'subject'],
  ['name' => 'status'],
  ['name' => 'priority'],
  ['name' => 'category'],
  ['name' => 'type'],
  ['name' => 'lang'],
  ['name' => 'user'],
  ['name' => 'agent']
];

return $seed;