<?php

include 'methods/main.php';
include 'class/satellite.class.php';

$dbo = getDBO();

if (isset($_GET['q'])) {
  switch ($_GET['q']) {
    case 'inclination_runs':
      echo 'inclination_runs';
      break;
    case 'mode_0':
      echo 'mode_0';
      break;
  }
} else {
  //echo 'Чет пошло не так<br>';
}

$sql = 'SELECT `inclination`, `raan`, `mean_motion`, `eccentricity`, `ft_derivative`, `st_derivative`, `bstar` FROM `satellites` as `s`, `satellite_params` as `p` WHERE `s`.`id` = `p`.`satellite_id` AND `s`.`epoch` = `p`.`epoch`';

$max_sql = 'SELECT MAX(`inclination`) as `max_inc`, MAX(`raan`) as `max_raan` FROM `satellite_params`;';
  
$data = $dbo->query($sql);

$max = $dbo->query($max_sql);

$satellites = [];

$r_max = 0;
$i_max = 0;
$i = 0;
$count = 0;

$Rz = 6371.2;
$mu = 398600.4415;

while ($row = $max->fetch()) {
  $max_inc = $row['max_inc'];
  $max_raan = $row['max_raan'];
}

$inclinations = array_fill(0, (int) ($max_inc / 5) + 2, 0);
$raans = array_fill(0, (int) ($max_raan / 10) + 2, 0);

while ($row = $data->fetch()) {
  $i_index = round($row['inclination'] / 5);
  $r_index = round($row['raan'] / 10);
  
  $inclinations[$i_index]++;
  
  $raans[$r_index]++;

  $p = 86400 / $row['mean_motion'];
  $n = 2 * M_PI / $p;
  //echo $n . ' ';
  //echo (pow($Rz * $Rz * 9.8 * $n * $n / 4 / 3.14 / 3.14, 1.0 / 3) - $Rz) . " ";
  $a = pow($mu / ($n * $n), 1.0/3);
  //echo "a = " . $a . " ";
  $r = $a * (1.0 - $row['eccentricity']);
  //echo "r = " . $r . " ";
  $hp =  $r - $Rz;
  //echo "hp = " . $hp;
  $ftd = $row['ft_derivative'];
  $std = $row['st_derivative'];
  $bstar = $row['bstar'];
  if ($hp < 1000) {
    $satellites[$i++] = new satellite($hp, $ftd, $std, $bstar);
  }
  $count++;
}

ksort($raans);
ksort($inclinations);
//echo $count;
$response = [];
$response['objects_count'] = $count;
$response['satellites_count'] = $i;
$response['inclinations_count'] = (int)($max_inc / 5) + 1;
$response['raans_count'] = (int)($max_raan / 10) + 1;
$response['inclinations'] = $inclinations;
$response['raans'] = $raans;
$response['satellites'] = $satellites;

echo json_encode($response, JSON_FORCE_OBJECT);