<?php
//working_dir> marsgen /meta/marsgen/crud /meta/marsgen/wiki_seed.php /venus/Apps/Main

// IMPORTANT
// if you run the marsgen code under venus.dev there will be php error
// you should go upper folder and run the code like this
// marsgen generate /venus.dev/meta/marsgen/crud /venus.dev/meta/marsgen/wiki_seed.php /venus.dev/venus/Apps/Main/

$seed = [];
$seed['__FileSystem__'] = [
  '-Crud-' => 'Wiki',
  '_crud_' => 'wiki'
];
$seed['classPrefix'] = 'Wiki';
$seed['classPrefix_'] = 'wiki';
$seed['collectionName'] = 'wiki_pages'; // database table


$seed['filterAreas'] = [
  ['name' => 'language'],
  ['name' => 'hidden'],
  ['name' => 'search']
];

$seed['areas'] = [
  ['name' => 'subject'],
  ['name' => 'slug'],
  ['name' => 'hidden'],
  ['name' => 'content'],
  ['name' => 'history'],
  ['name' => 'lang'],
  ['name' => 'last_user'],
  ['name' => 'last_time'],
  ['name' => 'last_id'],
];

return $seed;