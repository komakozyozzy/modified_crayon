<?php

$dbconn = mysql_connect("localhost","root","mysql");
if(!$dbconn){
	die('Could not connect: ' . mysql_error());
}

?>