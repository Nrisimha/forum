<?php
//working_dir> marsgen /meta/marsgen/crud /meta/marsgen/crud_seed.php /venus/Apps/Main
$seed = [];
$seed['__FileSystem__'] = [
  '-Crud-' => 'Cat',
  '_crud_' => 'cat'
];
$seed['classPrefix'] = 'Cat';
$seed['classPrefix_'] = 'cat';
$seed['collectionName'] = 'cats'; // database table


$seed['filterAreas'] = [
  ['name' => 'species'],
  ['name' => 'owned_by']
];

$seed['areas'] = [
  ['name' => 'name'],
  ['name' => 'species'],
  ['name' => 'weight'],
  ['name' => 'owned_by'],
  ['name' => 'year']
];

return $seed;