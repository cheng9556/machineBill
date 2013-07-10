<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
//provinceData = [[0,""], [1, "河北省"], [2, "河南省"], [3, "湖北省"],[4,"山东省"], [5, "湖南省"]];
//datasets = {
//        "plan": {
//            label: "应该提供服务器数量",
//            data: [[1, 10], [2, 12],[4,9],[3,10]]
//        },
//        "actual": {
//            label: "实际提供服务器数量",
//            data: [[1, 9], [2, 7],[4,9],[3,8]]
//        }
//};
include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');
$query = 'SELECT * FROM `machineBill`.`province` order by convert(provinceName using gb2312);';
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_num_rows($res);

if($num_rows > 0){
  //$queryresult = array();
  $i=1;
  $provincdData = '';
  $plan = '';
  $actual = '';
  while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
    //    $queryresult[] = $row;
    $provincdData .= '['.$i.',"'.$row['provinceName'].'"],';
    $plan .=  '['.$i.','.$row['serverPlanNumber'].'],';
    $actual .= '['.$i.','.$row['serverActualNumber'].'],'; 
    $i++;
  }
  echo 'provinceData = ['.substr($provincdData, 0, -1).'];datasets = {"plan": {label: "应该提供服务器数量",data:['.substr($plan, 0, -1).']},"actual":{label: "实际提供服务器数量",data:['.substr($actual, 0, -1).']}};';
}else{
  echo 'provinceData = [[0,""],[1,"无数据"],[2,"示例"]];datasets = {"plan": {label: "应该提供服务器数量",data:[[1,10],[2,12]]},"actual":{label: "实际提供服务器数量",data:[[1,9],[2,10]]}};';
}

mysql_free_result($res);
mysql_close($link);

?>
