<?php
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
if( (!isset($_POST['id'])) || ($_POST['id'] == '' )){
  echo "请求错误，不知道删除那个省份。";
  exit;
}

$provinceid = trim($_POST['id']);
$province = trim($_POST['pname']);

include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');

$query = 'DELETE FROM `machineBill`.`province` WHERE `id`='.$provinceid.';';
//echo $query;
$res = mysql_query($query) or die('Query failed: ' . mysql_error());

$query = 'DELETE FROM `machineBill`.`serverMachine`  WHERE `provinceID`='.$provinceid.';';
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_affected_rows();

if($num_rows > 0 ){
  $numtext = '，并删除该省份下的 '.$num_rows.' 台服务器.';
}else{
  $numtext = '。';
}

//history
$date = date("Y-m-d H:i:s");
$query = 'INSERT INTO `machineBill`.`history` VALUES ("","'.$date.'","'.$operator.'","删除省份 '.$province.'");';
mysql_query($query);

//$row = mysql_fetch_array($res, MYSQL_ASSOC);

mysql_close($link);

echo '删除 '.$province.' 成功'.$numtext;
