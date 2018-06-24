<?php
use Phalcon\Config;

//baseurl and assets must end with trailing slash 

$config = [
  'baseurl' => 'http://'.$_SERVER['HTTP_HOST'].'/',
  'assets' => 'http://'.$_SERVER['HTTP_HOST'].'/static/'
];


$config['assets'] = 'https://static.salagame.net/file/salabox/assets/'; 

return new Config($config);