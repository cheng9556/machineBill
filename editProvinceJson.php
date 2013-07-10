<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
$action = trim($_GET['action']);
$provinceid = trim($_GET['id']);
if( ($action =='edit') && is_numeric($provinceid)){
  include_once 'databaseConfig.php';
  $link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
  mysql_select_db($cfg_dbname,$link) or die('Could not select database');
  mysql_query('SET NAMES utf8');
  $query = 'SELECT * FROM `machineBill`.`province`  WHERE `id`='.$provinceid.';';
  //echo $query;
  $res = mysql_query($query) or die('Query failed: ' . mysql_error());
  $row = mysql_fetch_array($res, MYSQL_ASSOC);
  mysql_free_result($res); 
  mysql_close($link);
  
  $row2 = array();
  $row2['provinceid'] = $row['id'];
  $row2['province'] = $row['provinceName'];
  $row2['serverPlanNumber'] = $row['serverPlanNumber'];
  $row2['serverActualNumber'] = $row['serverActualNumber'];
  $row2['remarks'] = $row['remarks'];
  echo json_encode($row2);
}
