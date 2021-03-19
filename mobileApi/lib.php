<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
$activePage = basename($_SERVER['PHP_SELF'], ".php");
include_once '../zooAdmin/lib/dao.php';
include_once '../zooAdmin/lib/model.php';
include_once '../zooAdmin/fcm_file/user_fcm.php';

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

$d = new dao();
$m = new model();

$nResident = new firebase_resident();
$con = $d->dbCon();

header('Access-Control-Allow-Origin: *'); //I have also tried the * wildcard and get the same response
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
$base_url = $m->base_url();
$keydb = $m->api_key();
extract(array_map("test_input", $headers));
$key = $_SERVER['HTTP_KEY'];

?>