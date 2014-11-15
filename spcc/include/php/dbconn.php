<?php

$dbconn = mysql_connect("localhost","user","password");
if(!$dbconn){
	die('Could not connect: ' . mysql_error());
}

?>
