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
$query = 'SELECT * FROM `machineBill`.`history` order by `id` desc;';

$res = mysql_query($query) or die('Query failed: ' . mysql_error());
$num_rows = mysql_num_rows($res);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<table id="historyData" class="easyui-datagrid" striped="true">
  <thead>
    <tr>
      <th field="code" align="center" width="120">时间</th>
      <th field="name" align="center" width="50">用户</th>
      <th field="country" align="center" width="600">操作</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if($num_rows > 0){
    while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
      echo '<tr>';
      echo ' <td>'.$row['time'].'</td>';
      echo ' <td>'.$row['nickname'].'</td>';
      echo ' <td>'.$row['operate'].'</td>';
      echo '</tr>';
    }
  }
  ?>
  </tbody>
</table>
<script type="text/javascript">
$(function(){
	$('#historyData').datagrid({
		height:500,
		striped: true,
		singleSelect:true,
		fit: true
	});
});
</script>
</body>
</html>
