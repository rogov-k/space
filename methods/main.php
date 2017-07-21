<?php

function getDBO() {
    $dbname = 'space';
    $username = 'admin';
    $password = '38q8jd9f';
    $hosts = 'mysql';

    $db = new PDO('mysql:host=' . $hosts . ';port=3306;dbname=' . $dbname, $username, $password);
    $db->exec('SET NAMES "utf8";');

    return $db;
}

function up(&$a) {
  if (isset($a)) {
    $a++;
  } else {
    $a = 1;
  }
}

function getNumber($a) {
  $a = preg_replace("/(\-|\+)?[0-9]{2,}/", "$0e", $a);
  $a = number_format($a, 8);
  return $a;
}

function getFile ($c) {
  $file = time() . '-data.txt';
  $path = 'data/' . $file;
  $query = 'https://www.space-track.org/basicspacedata/query/class/tle_latest/ORDINAL/1/EPOCH/%3Enow-30/format/3le';
  $data = $c->get($query);
  
  file_put_contents($path, $data);
  
	return $file;
}

function check($str) {
  up($_SESSION['log']['all']);
  $symbols = explode($str, '');
  $count = 0;
  foreach ($symbols as $i => $symbol) {
    if($i + 1 == count($symbols)) {
      continue;
    }
    if ($symbol == '.' || $symbol == '+') {
      continue;
    }
    elseif ($symbol == '-') {
      $count++;
    }
    elseif (is_numeric($symbol)) {
      $count += $symbol;
    }
    else {
      continue;
    }
  }
  if ($count == substr($str, -1, 1)) { 
  	up($_SESSION['log']['done']);
    return TRUE;
  } else {
  	up($_SESSION['log']['fall']);
  	return FALSE;
	}
}

function firstLine($line, &$data) {
  // Get name object
  $data['name'] = trim(substr($line, 1));
}

function secondLine($line, &$data) {
  // Check the checksum
  if (check($line)) {
    // Get NORAD nubmer
    $number = trim(substr($line, 2, 5));
    
    // Get date launch object
    $year = trim(substr($line, 9, 2));
    $year = (($year > 57) ? '19' : '20') . $year;
    $day = trim(substr($line, 11, 3));
    $date = new DateTime('01.01.' . $year);
    if (!$day) {
      $day--;
    }
    $date->add(new DateInterval('P' . $day . 'D'));
    $date = $date->format('Y-m-d');
		
    // Get last epoch chenget tle
    $epoch = trim(substr($line, 18, 14));
		
    // Get ftd param
    $ftd = trim(substr($line, 33, 10));
    $ftd = number_format($ftd, 8);

    // Get std param
    $std = trim(substr($line, 44, 8));
    $std = getNumber($std);
		
    //get bstar param
    $bstar = trim(substr($line, 53, 8));
    $bstar = getNumber($bstar);
		
    // Save data in array
    $data['id'] = $number;
    $data['date'] = $date;
    $data['epoch'] = $epoch;
    $data['ftd'] = $ftd;
    $data['std'] = $std;
    $data['bstar'] = $bstar;
  }
}

function thirdLine($line, &$data) {
  if (check($line)) {
    $data['inclination'] = trim(substr($line, 8, 8));
    $data['raan'] = trim(substr($line, 17, 8));
    $data['eccentricity'] = '0.' . trim(substr($line, 26, 7));
    $data['ap'] = trim(substr($line, 34, 8));
    $data['m_anomaly'] = trim(substr($line, 43, 8));
    $data['m_motion'] = trim(substr($line, 52, 11));
    $data['revolution_number'] = trim(substr($line, 63, 5));
  }
}

function o($object) {
  return '\'' . $object . '\'';
}

function createQuery($data, &$str, $param) {
  if (!empty($str)){
  	$str .= ', (';
  } else {
  	$str = '(';
  }
  switch ($param) {
    case 'd':
      $str .= o($data['id']) . ', ';
      $str .= o($data['epoch']) . ', ';
      $str .= o($data['ftd']) . ', ';
      $str .= o($data['std']) . ', ';
      $str .= o($data['bstar']) . ', ';
      $str .= o($data['inclination']) . ', ';
      $str .= o($data['raan']) . ', ';
      $str .= o($data['eccentricity']) . ', ';
      $str .= o($data['ap']) . ', ';
      $str .= o($data['m_anomaly']) . ', ';
      $str .= o($data['m_motion']) . ', ';
      $str .= o($data['revolution_number']) . ')';
    	break;
    case 's':
      $str .= o($data['id']) . ', ';
      $str .= o($data['name']) . ', ';
      $str .= o($data['epoch']) . ', ';
      $str .= o($data['date']) . ')';
    	break;
  }
}

function insert($prepare_query, $param) {
  switch ($param) {
    case 'd':
      $query = 'INSERT IGNORE INTO `satellite_params` (`satellite_id`, `epoch`, `ft_derivative`, `st_derivative`, `bstar`, `inclination`, `raan`, `eccentricity`, `perigee`, `mean_anomaly`, `mean_motion`, `revolution_number`) VALUES ' . $prepare_query;
    	break;
    case 's':
      $query = 'INSERT IGNORE INTO `satellites` (`id`, `name`, `epoch`, `launch_date`) VALUES ' . $prepare_query;
    	break;
  }
  $dbo = getDBO();
  $dbo->query($query);
}

function getReport() {
  $str = '';
  if (isset($_SESSION['log'])) {
    $a = isset($_SESSION['log']['all']) ? $_SESSION['log']['all'] / 2 : 0;
    $str .= $a . ' objets were processed' . PHP_EOL;
    $a = isset($_SESSION['log']['done']) ? $_SESSION['log']['done'] / 2 : 0;
    $str .= $a . ' objets were successfully processed' . PHP_EOL;
    $a = isset($_SESSION['log']['fall']) ? $_SESSION['log']['fall'] / 2 : 0;
    $str .= $a . ' objets were unsuccessfully' . PHP_EOL;
  } else {
    $str = 'Variable `session` is was broken!' . PHP_EOL;
	}
  $str .= '---- ' . date('d.m.Y H:i:s') . ' ----' . PHP_EOL;
  file_put_contents('reports.log', $str, FILE_APPEND);
  return $str;
}