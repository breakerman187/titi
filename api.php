<?php
session_start();
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1);
/*

Made by Red Penguin

*/

error_reporting(0);
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once('functions.php');
extract($_GET);
$things = explode('|', strtr($check, [' ' => '']));

foreach($things as $thing){
  $things['p_d'][] = preg_replace('/[^0-9]/', '', $thing);
}

function EF($o, $e, $ar){
  $o->{$e}($ar);
}

list($cc, $mm, $yyyy, $cvv) = $things['p_d'];
unset($things);

$checker = new PayMaya([$cc, $mm, $yyyy, $cvv]);

//$d = $checker->genesis();

$checker->unconditional();
$checker->love();
$checker->is();
$checker->orchestrate();

$checker->removeFiles($checker->checker_data['files']['cookies']['first']);

?>