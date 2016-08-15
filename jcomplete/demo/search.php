<?php
$host = "localhost";
	$database = "autocomplete";
	$user = "root";
	$password = "";

// You don't have touch a thing from here on unless you really want to:

	mysql_connect($host,$user,$password);
	mysql_select_db($database);
	
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql="SELECT title FROM autocomplete_demo WHERE title LIKE '%$q%'";
$res=mysql_query($sql);
//$row=mysql_fetch_array($res);

foreach ($row as $value) {
	if (strpos(strtolower($value['title']), $q) !== false) {
		echo $value['title']."\n";
	}
}

?>