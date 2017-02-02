<?php
/*
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', '1');
*/

include(dirname(__FILE__).'/ZoomAPI.php');

$objZoom = new ZoomAPI();


//Creating a user on zoom API
if($_GET['flag'] == '1') {
$res = $objZoom->createAUser('shyam123.ckp@gmail.com','1');
}

if($_GET['flag'] == '2') {
$res2 = $objZoom->createAMeeting('yNUwW2q-Q_maUMX2k2weqg','Test Topic1', '2');
}

if($_GET['flag'] == '3') {
$res3 = $objZoom->createAWebinar('yNUwW2q-Q_maUMX2k2weqg','Test Topic1');
}

if($_GET['flag'] == '4') {
$res4 = $objZoom->getMeetingList('1','2016-10-1', '2016-11-15');        
}

if($_GET['flag'] == '5') {
$res5 = $objZoom->getDailyReport('2016', '11');        
}
?>
