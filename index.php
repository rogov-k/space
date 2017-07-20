<?php

include 'template/main.tpl.php';
/*
include 'methods/main.php';
include 'methods/helper.php';
include 'class/curl.class.php';

$login = 'kempanchik@mail.ru';
$password = '38q8jd9f38q8jd9F';
$url = 'https://www.space-track.org/ajaxauth/login';
$data = 'identity=' . $login . '&password=' . $password;

$c = new cURL;
$auth = trim($c->post($url, $data), '"');

echo '<pre>';
if (empty($auth)) {
  $dbo = getDBO();
  $file = 'data.txt';
  $query = 'https://www.space-track.org/basicspacedata/query/class/satcat/predicates/NORAD_CAT_ID,COUNTRY,RCS_SIZE/DECAY/null-val/orderby/NORAD_CAT_ID';
  $data = $c->get($query);
  $json = file_put_contents($file, $data);
  $names = [];
  $countries = json_decode($data);
  
  foreach ($countries as $country) {
    if (!in_array($country->COUNTRY, $names)) {
      $names[] = $country->COUNTRY;
    }
  }
  sort($names);
  //$names = array_flip($names);
  
  foreach ($names as $i => $name) {
    if ($i==1){
      continue;
    }
    $dbo->query('INSERT INTO `countries` (`name`) VALUES (\'' . $name . '\')');
  }
  
	foreach ($countries as $country) {
  	$sql = $dbo->prepare('UPDATE `satellites` SET `size`= :size,`country_id`= :country WHERE `id` = :id;');
    $sql->execute([
    	':id' => $country->NORAD_CAT_ID,
    	':size' => $country->RCS_SIZE,
    	':country' => $names[$country->COUNTRY]
    ]);
    break;
    print_r($sql);
  }
}

  */

