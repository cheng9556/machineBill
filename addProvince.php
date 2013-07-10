<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
if( (!isset($_POST['province'])) || $_POST['province'] == '' ){
  echo "请填写“省份”名称";
  exit;
}
$province = trim($_POST['province']);

if ( (!isset($_POST['serverPlanNumber'])) || $_POST['serverPlanNumber'] == '') {
  echo "请填写“应该提供服务器数量”";
  exit;
}
$numberPlan = trim($_POST['serverPlanNumber']);
if( !is_numeric($numberPlan)){
  echo "“应该提供服务器数量” 应该为整数";
  exit;
}

if( (!isset($_POST['serverActualNumber'])) || $_POST['serverActualNumber'] == '' ){
  echo "请填写“实际提供服务器数量”";
  exit;
}
$numberActual = trim($_POST['serverActualNumber']);
if( !is_numeric($numberActual)){
  echo "“实际提供服务器数量” 应该为整数";
  exit;
}

include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');  
$query = 'INSERT INTO `machineBill`.`province` VALUES ("","'.$province.'",'.$numberPlan.','.$numberActual.',"'.trim($_POST['remarks']).'");';
//echo $query;
$res = mysql_query($query) or die('Query failed: ' . mysql_error());

//history
$date = date("Y-m-d H:i:s");
$query = 'INSERT INTO `machineBill`.`history` VALUES ("","'.$date.'","'.$operator.'","添加省份 '.$province.'");';
mysql_query($query); 

mysql_close($link);
if($res){
  echo "添加省份  ".$province." 成功";
}
