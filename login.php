<?php
session_start();
include("config.php");

connect();

$user = mysql_real_escape_string($_GET['u']);
$pw = mysql_real_escape_string($_GET['p']);

$result0 = mysql_query("SELECT * FROM users WHERE user='".$user."'") or die(mysql_error()); 

while($row0 = mysql_fetch_array($result0)){
	$p1 = $row0['pw'];
	if($p1 == $pw){
		$_SESSION['username'] = $user;
		$_SESSION['password'] = $pw;
		header("location: index.php");
		exit;
	}
}

header("location: index.php?error");
exit;

?>