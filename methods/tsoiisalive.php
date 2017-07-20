<?php

include 'main.php';
include 'functions.php';

if (isset($_POST['text']) && !empty($_POST['text'])) {
	info($_POST['text']);
  die;
}

if (isset($_POST['grafic']) && !empty($_POST['grafic'])) {
  grafic($_POST['grafic'], $_POST['id']);
  die;
}

if (isset($_POST['query']) && !empty($_POST['query'])) {
  query($_POST['query']);
  die;
}