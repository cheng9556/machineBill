<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
if( (!isset($_POST['serverID'])) || $_POST['serverID'] == '' ){
  echo "请求出错，不知道在编辑那个服务器";
  exit;
}
$serverID = trim($_POST['serverID']);
$serverName = trim($_POST['sname']);

if( (!isset($_POST['serverNumber'])) || $_POST['serverNumber'] == '' ){
  echo "请填写“服务器序号”名称";
  exit;
}
$serverNumber = trim($_POST['serverNumber']);
if( !is_numeric($serverNumber)){
  echo "“服务器序号” 应该为整数";
  exit;
}

if ( (!isset($_POST['area'])) || $_POST['area'] == '') {
  echo "请填写“放置地点”";
  exit;
}
$area = trim($_POST['area']);

if( (!isset($_POST['ip'])) || $_POST['ip'] == '' ){
  echo "请填写“IP地址”";
  exit;
}
$ip = trim($_POST['ip']);

if( (!isset($_POST['eth'])) || $_POST['eth'] == '' ){
  echo "请填写“分光网卡”";
  exit;
}
$eth = trim($_POST['eth']);

include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');  

$query = 'UPDATE `machineBill`.`serverMachine` SET `serverNumber`="'.$serverNumber.'", `area`="'.$area.'", `ip`="'.$ip.'",`ping`="'.trim($_POST['ping']).'",`login`="'.trim($_POST['login']).'",`proxylogin`="'.trim($_POST['proxylogin']).'",`eth`="'.$eth .'", `remarks`="'. trim($_POST['remarks']) .'" WHERE `id`='.$serverID.';';
//echo $query;
$res = mysql_query($query) or die('Query failed: ' . mysql_error());

if($res){
  //history
  $date = date("Y-m-d H:i:s");
  $query = 'INSERT INTO `machineBill`.`history` VALUES ("","'.$date.'","'.$operator.'","更新了 '.$serverName.' 的数据");';
  mysql_query($query);
  echo '更新 '.$serverName.' 配置成功';
}else{
  echo "更新 ".$serverName." 配置失败，请联系数据库管理员";
}
mysql_close($link);
