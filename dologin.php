<?php
// first we create a random session key
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];							// get client ip address
srand((double)microtime()*1000000 );							// initialize random seed
$rand = rand(1,9);												// generate a random number between 1 to 9
$session_id = $rand.substr(md5($REMOTE_ADDR), 0, 11+$rand);		/* append the random number to the beginning
of the session_id string followed by a substring of the md5 ip address hash with a dynamic length of anything between 11 to 16 digits (the max length of
the md5 hash) */
$session_id .= substr(md5(rand(1,1000000)), rand(1,32-$rand), 21-$rand);	// further add a dynamic length digits to
// to the session_id string composed of the
// md5 hash for random number
session_id($session_id);							// apply the session_id that we created
//session_set_cookie_params(3600);						// deprecated, unsupported in older IE browsers, set's the session timeout
// to 3600 seconds (1 hour)
ini_set('session.gc_maxlifetime', 60*60);					// replaces the session_set_cookie_params directive

session_start();								// initiate the session

$operator_user = trim($_POST['operator_user']);
$operator_pass = trim($_POST['operator_pass']);

include_once 'databaseConfig.php';
$link = mysql_connect($cfg_dbhost, $cfg_dbuser, $cfg_dbpwd) or die('Could not connect: ' . mysql_error());
mysql_select_db($cfg_dbname,$link) or die('Could not select database');
mysql_query('SET NAMES utf8');
// check if the user id and password combination exist in database
$sql = "SELECT * FROM users WHERE userName = '".$operator_user."' AND userPassword = '".$operator_pass."'";
$res = mysql_query($sql);
$num_rows = mysql_num_rows($res);

if ($num_rows == 1) {
  $row = mysql_fetch_array($res, MYSQL_ASSOC);
  // the user id and password match,
  // set the session

  $_SESSION['logged_in'] = true;
  $_SESSION['operator_user'] = $row['nickname'];
  $_SESSION['lastlogin'] = $row['lastlogin'];

  // lets update the lastlogint time for this operator
  $date = date("Y-m-d H:i:s");
  $sql = 'UPDATE users SET lastlogin="'.$date.'" WHERE userName="'.$operator_user.'";';
  mysql_query($sql);

  echo '$("#loginform").effect( "explode", {}, "slow",function(){window.location.href="index.php";});';
  // after login we move to the main page
  //header('Location: index.php');
  exit;
} else {
  echo '$("#loginform").effect( "shake", {}, "fast",function(){$("#login_error").html("<strong>错误</strong>:用户名或密码不正确<br />").slideDown("slow");});';
  exit;
}


