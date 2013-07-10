<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');
$query = 'SELECT id,provinceName FROM `machineBill`.`province` order by convert(provinceName using gb2312);';
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_num_rows($res);

if($num_rows > 0){
  $queryresult = array();
  while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $queryresult[] = $row;
  }
  echo json_encode($queryresult);
}
mysql_free_result($res);
mysql_close($link);
