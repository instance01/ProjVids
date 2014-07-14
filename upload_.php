<?php
include("config.php");
connect();

$fileName = $_FILES['file']['name'];
$fileType = $_FILES['file']['type'];
$fileContent = file_get_contents($_FILES['file']['tmp_name']);
$dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);

$pos = strpos($fileType, "video");
if($pos === FALSE){
	echo("Failed to upload file: Unsupported file type.");
	exit;
}

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$title = $_REQUEST['title'];
$desc = $_REQUEST['desc'];
$tags = $_REQUEST['tags'];


$result0 = mysql_query("SELECT * FROM users WHERE user='".$username."'") or die(mysql_error()); 

while($row0 = mysql_fetch_array($result0)){
	$p1 = $row0['pw'];
	if($p1 != $password){
		echo("You're sum 1337 H4XX0R. (tried uploading file without being logged in)");
		exit;
	}
}


$target = "videos/".basename( $_FILES[ 'file' ][ 'name' ]);

if ( move_uploaded_file( $_FILES[ 'file' ][ 'tmp_name' ], $target ) ){
	echo($target);
	mysql_query("INSERT INTO videos VALUES ('0', '$username', '0', '0', '$target', '', '$title', '$desc', '$tags', '')") or die(mysql_error());
}else{
	echo( "An error occurred." );
}


?>