<?php

function info($id) {
  $response = [];
  $dbo = getDBO();
  $sql = $dbo->prepare('SELECT * FROM `space`.`satellites` as `s`, `space`.`satellite_params` as `p` WHERE `s`.`id` = :id AND `p`.`satellite_id` = :id AND `p`.`epoch` = (SELECT MAX(`space`.`satellite_params`.`epoch`) FROM `space`.`satellite_params` WHERE `space`.`satellite_params`.`satellite_id` = :id) LIMIT 1');
  $sql->execute([':id' => $id]);
  $object = $sql->fetch();
  $country = $dbo->prepare('SELECT `name` FROM `space`.`countries` WHERE `id` = :id;');
  $country->execute([':id' => $object['country_id']]);
  foreach ($country as $i) {
    $object['country_id'] = $i['name'];
  }
  if (is_numeric($id) && $object) {
    $object['launch_date'] = date('M d, Y', strtotime($object['launch_date']));
    ob_start();
    include '../template/table.tpl.php';
    $text = ob_get_contents();
    ob_end_clean();

    $response['answer']['status'] = TRUE;
    $response['answer']['text'] = $text; 
  } else {
    $response['answer']['status'] = FALSE;
    $response['answer']['text'] = '<div class="block"><span class="font">Object with NORAD ‘' . $_POST['text'] . '’ was not found.</span></div>';
  }
  $json = json_encode($response);
  echo $json;
}

function grafic($grafic, $id) {
  $data = [];
  $i = 0;
  $dbo = getDBO();
  $sql = $dbo->prepare('SELECT `' . $grafic . '`, `epoch` FROM `satellite_params` as `p` WHERE `p`.`satellite_id` = :id;');
  $sql->execute([':id' => $id]);
  while ($object = $sql->fetch()) {
    $year = '20' . trim(substr($object['epoch'], 0, 2));
    $date = new DateTime('01.01.' . $year);
    $day = trim(substr($object['epoch'], 2, 3));
    if (!$day) {
      $day--;
    }
    $date->add(new DateInterval('P' . $day . 'D'));
    $date = $date->format('M d');
    $val[0] = $date;
    $val[1] = (double)$object[$grafic];
    $vals[] = $val;
  }
  echo json_encode($vals);
}

function query($query) {
  $data = [];
  $dbo = getDBO();
  $sql = $dbo->prepare('SELECT `id`, `name` FROM `satellites` WHERE `id` LIKE :query ORDER BY `id` ASC LIMIT 5');
  $sql->execute([':query' => '%' . $query . '%']);
  foreach ($sql as $key =>$row){
    $data[$key]['id'] = $row['id'];
    $data[$key]['name'] = $row['name'];
  }
  ob_start();
  include '../template/tips.tpl.php';
  $answer = ob_get_contents();
  ob_end_clean();
  echo $answer;
}