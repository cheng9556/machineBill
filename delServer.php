<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
if( (!isset($_POST['id'])) || ($_POST['id'] == '' )){
  echo "请求错误，不知道删除那个服务器。";
  exit;
}

$serverID = trim($_POST['id']);
$serverName = trim($_POST['dname']);
include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');

$query = 'SELECT `province`.`id`,`province`.`serverActualNumber` FROM `serverMachine`,`province` WHERE `province`.`id`=`serverMachine`.`provinceID` AND `serverMachine`.`id` ='.$serverID.';';
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_num_rows($res);
if($num_rows > 0 ){
  $row = mysql_fetch_array($res, MYSQL_ASSOC);
  //现在该省份应该有的服务器数量
  $number = $row['serverActualNumber'] - 1;
  if($number < 0){
    echo '省份 "实际到位服务器数量" 数据出问题，请联系数据库管理员。';
    mysql_close($link);
    exit;
  }
  $query = 'UPDATE `machineBill`.`province` SET `serverActualNumber`= '.$number.' WHERE id = '.$row['id'].';';
  //echo $query;
  $res = mysql_query($query);
  
  $num_rows = mysql_affected_rows();
  if($num_rows ==0 ){
    echo '更新省份数据出问题，请重新删除该服务器。';
    mysql_close($link);
    exit;
  }
}else{
  echo '不知道该服务器属于哪个省份';
  mysql_close($link);
  exit;
}

$query = 'DELETE FROM `machineBill`.`serverMachine`  WHERE `id`='.$serverID.';';
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_affected_rows();

if($num_rows > 0 ){
    //history
  $date = date("Y-m-d H:i:s");
  $query = 'INSERT INTO `machineBill`.`history` VALUES ("","'.$date.'","'.$operator.'","删除服务器 '.$serverName.'");';
  mysql_query($query);
  
  echo '删除 '.$serverName.' 成功,目前该省份实际到位服务器数为 '.$number.' 台';
}else{
  echo '删除 '.$serverName.' 失败.';
}
mysql_close($link);
