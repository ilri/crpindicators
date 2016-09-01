<?php
class DB{
	var $host;
	var $user;	
	var $pass;
	var $database;

	var $connection;

	function __construct(){
		date_default_timezone_set('Africa/Nairobi');
		$this->host="localhost";
		$this->user="root";
		$this->pass="jgatheru";
		$this->database="crps";
// 		$this->period="2016 Round 1";
		
		$auth = new stdClass();
		$auth->success = false;

		$con=mysql_connect($this->host,$this->user,$this->pass) or die("Can not establish Connection");
		$this->connection=$con;
		if($con)
			mysql_select_db($this->database,$con) or die("Can not select Database");
	}
}
?>
