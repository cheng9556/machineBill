<?php 
include_once("checklogin.php");
$operator = $_SESSION['operator_user'];
$lastlogin = $_SESSION['lastlogin'];
?>
<?php
/*
 [{
 "id":"p12",
 "province":"\u4e91\u5357\u7701-\u5e94\u63d0\u4f9b10\u53f0,\u5b9e\u9645\u5230\u4f4d7\u53f0.",
 "state":"closed",
 "remarks":"\u51fa\u53e3\u6570\u91cf\u4e3a20G",
 "children":[
 {"id":"s25",
 "province":"\u4e91\u5357\u77013\u53f7\u673a\u5668",
 "area":"\u5927\u7406",
 "ip":"192.168.1.3",
 "ping":"1",
 "login":"1",
 "proxylogin":"1",
 "eth":"eth0",
 "remarks":"\u53ef\u7528"
 },{
 "id":"s26",
 "province":"\u4e91\u5357\u77015\u53f7\u673a\u5668",
 "area":"\u5927\u7406",
 "ip":"192.168.1.4",
 "ping":"1",
 "login":"1",
 "proxylogin":"1",
 "eth":"eth0",
 "remarks":"\u53ef\u7528"
 }]
 },{
 "id":"p13",
 "province":"\u4e91\u5357\u7701-",
 "remarks":"\u51fa\u53e3\u6570\u91cf\u4e3a20G",
 "children":[]
 }]*/
include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');
$query = 'SELECT `serverMachine`.*,`province`.`provinceName`,`province`.`serverPlanNumber`,`province`.`serverActualNumber`,`province`.`remarks` as `premarks` FROM `serverMachine`,`province` where `province`.`id` = `serverMachine`.`provinceID` order by convert(`provinceName` using gb2312),serverNumber;';
$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_num_rows($res);

if($num_rows > 0){
  $queryresult = array();
  $parray = array();
  $p = array();

  while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
    $provinceName = $row['provinceName'];
    $serverName =  $provinceName.$row['serverNumber'].'号机器';
    $s['id'] = 's'.$row['id'];
    $s['province'] = $serverName;
    $s['area'] = $row['area'];
    $s['ip'] = $row['ip'];
    $s['ping'] = $row['ping']?'是':'否';
    $s['login'] = $row['login']?'是':'否';
    $s['proxylogin'] = $row['proxylogin']?'是':'否';
    $s['eth'] = $row['eth'];
    $s['remarks'] = $row['remarks'];

    $p[$provinceName]['id'] = $row['provinceID'];
    $p[$provinceName]['serverPlanNumber'] = $row['serverPlanNumber'];
    $p[$provinceName]['serverActualNumber'] = $row['serverActualNumber'];
    $p[$provinceName]['remarks'] = $row['premarks'];

    $parray[$provinceName][] = $s;
  }

  $i=0;
  foreach ($parray as $k => $v){
    $queryresult[$i]['id'] = 'p'.$p[$k]['id'];
    $queryresult[$i]['province'] = $k.'-应提供'.$p[$k]['serverPlanNumber'].'台,实际到位'.$p[$k]['serverActualNumber'].'台.';
    $queryresult[$i]['state'] = 'closed';
    $queryresult[$i]['remarks'] = $p[$k]['remarks'];
    $queryresult[$i]['children'] = $v;

    $i++;
  }
  
  
  
  //一台服务器也没有的省份情况
  $query = 'SELECT * FROM `province` where `province`.`serverActualNumber` = 0 order by convert(`provinceName` using gb2312);';
  $res = mysql_query($query) or die('Query failed: ' . mysql_error());
  $num_rows = mysql_num_rows($res);
  if($num_rows > 0){
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      $queryresult[$i]['id'] = 'p'.$row['id'];
      $queryresult[$i]['province'] = $row['provinceName'].'-应提供'.$row['serverPlanNumber'].'台,实际到位'.$row['serverActualNumber'].'台.';
      $queryresult[$i]['remarks'] = $row['remarks'];
      $i++;
    }
  }
  //  print_r($queryresult);
  echo json_encode($queryresult);
}
mysql_free_result($res);
mysql_close($link);
