<?php
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
if( (!isset($_POST['province'])) || $_POST['province'] == '' ){
  echo "请选择“省份”";
  exit;
}
$provinceid = trim($_POST['province']);

if ( (!isset($_POST['serverNumber'])) || $_POST['serverNumber'] == '') {
  echo "请填写“服务器序号”";
  exit;
}
$serverNumber = trim($_POST['serverNumber']);
if( !is_numeric($serverNumber)){
  echo "“服务器序号” 应该为整数";
  exit;
}

if( (!isset($_POST['area'])) || $_POST['area'] == '' ){
  echo "请填写“服务器放置地点”";
  exit;
}
$area = trim($_POST['area']);

if( (!isset($_POST['ip'])) || $_POST['ip'] == '' ){
  echo "请填写“服务器IP”";
  exit;
}
$ip = $_POST['ip'];

if( (!isset($_POST['eth'])) || $_POST['eth'] == '' ){
  echo "请填写“分光网卡”";
  exit;
}
$eth = $_POST['eth'];

include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');

$res = mysql_query('SELECT * FROM `machineBill`.`province` WHERE id = '.$provinceid.';');
$proviceRow = mysql_fetch_array($res, MYSQL_ASSOC);

$serverName = $proviceRow['provinceName'].$serverNumber.'号机器';

$res = mysql_query('SELECT * FROM `machineBill`.`serverMachine` WHERE  provinceID = '.$provinceid.' AND serverNumber = '.$serverNumber.';');
$num_rows = mysql_num_rows($res);
if ($num_rows > 0){
  echo '已经存在 '.$serverName;
  mysql_close($link);
  exit;
}

$query = 'INSERT INTO `machineBill`.`serverMachine` VALUES ("",'.$serverNumber.',"'.$area.'","'.$ip.'",'.trim($_POST['ping']).','.trim($_POST['login']).','.trim($_POST['proxylogin']).',"'.$eth.'","'.trim($_POST['remarks']).'",'.$provinceid.');';
//echo $query;
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
if($res){
  $res = mysql_query('SELECT * FROM `machineBill`.`serverMachine` WHERE provinceID = '.$provinceid.';');
  $num = mysql_num_rows($res);

  mysql_query('UPDATE `machineBill`.`province` SET `serverActualNumber`= '.$num.' WHERE id = '.$provinceid.';');
  //history
  $date = date("Y-m-d H:i:s");
  $query = 'INSERT INTO `machineBill`.`history` VALUES ("","'.$date.'","'.$operator.'","添加服务器 '.$serverName.'");';
  mysql_query($query);
   
   
  $txt = '<br />该省份应该提供  '.$proviceRow['serverPlanNumber'].'  台，实际到位  '.$num.'  台';
  echo "添加  ".$serverName." 成功.".$txt;
}

mysql_close($link);
