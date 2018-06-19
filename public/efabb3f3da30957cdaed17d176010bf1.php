<?php
file_put_contents('../cache/debugip', $ip = $_SERVER['REMOTE_ADDR']);
if(file_get_contents('../cache/debugip') == $ip = $_SERVER['REMOTE_ADDR']){
  echo "I am following you!";
}else{
  echo "An error occured! It was 5 line code...";}