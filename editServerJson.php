<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
$action = trim($_GET['action']);
$serverid = trim($_GET['id']);
if( ($action =='edit') && is_numeric($serverid)){
  include_once 'databaseConfig.php';
  $link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
  mysql_select_db($cfg_dbname,$link) or die('Could not select database');
  mysql_query('SET NAMES utf8');
  $query = 'SELECT * FROM `machineBill`.`serverMachine`  WHERE `id`='.$serverid.';';
  //echo $query;
  $res = mysql_query($query) or die('Query failed: ' . mysql_error());
  $row = mysql_fetch_array($res, MYSQL_ASSOC);
  mysql_free_result($res); 
  mysql_close($link);
  
  $row2 = array();
  $row2['serverNumber'] = $row['serverNumber'];
  $row2['area'] = $row['area'];
  $row2['ip'] = $row['ip'];
  $row2['ping'] = $row['ping'];
  $row2['login'] = $row['login'];
  $row2['proxylogin'] = $row['proxylogin'];
  $row2['eth'] = $row['eth'];
  $row2['remarks'] = $row['remarks'];
  $row2['serverID'] = $row['id'];
  echo json_encode($row2);
}
