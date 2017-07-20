<?php

session_start();
session_destroy();

include 'methods/main.php';
include 'class/curl.class.php';

$login = 'kempanchik@mail.ru';
$password = '38q8jd9f38q8jd9F';
$url = 'https://www.space-track.org/ajaxauth/login';
$data = 'identity=' . $login . '&password=' . $password;

$c = new cURL;
$auth = trim($c->post($url, $data), '"');
echo '<pre>';

if (empty($auth)) {
  $data = [];
  $file = getFile($c);
  $handle = @fopen("data/" . $file, "r");
  $index = 0;
  
  while ($line = fgets($handle, 8192)) {
    switch ($index % 3){
      case 0:
        firstLine($line, $data);
        break;
      case 1:
        secondLine($line, $data);
        break;
      case 2:
        thirdLine($line, $data);
        createQuery($data, $prepare_query_s, 's');
        createQuery($data, $prepare_query_d, 'd');
        $data = [];
        break;
    }
    $index++;
  }
  insert($prepare_query_s, 's');
  insert($prepare_query_d, 'd');
  fclose($handle);
  echo getReport();
} else {
  print_r(json_decode($auth));
}