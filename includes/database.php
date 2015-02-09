<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'config.php';

class MySQLDatabase {
	private $connection;
	private $magic_quotes_active;
	private $real_escape_string_exits;
				
	public $last_query;
	

	function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exits = function_exists("mysql_real_escape_string");
	}

	public function open_connection(){
		$this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);	
//		$this->connection=  mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if(!$this->connection){
			die("Database connection failed: " . mysqli_error());
			
		}
		else{
			$db_select = mysqli_select_db($this->connection,DB_NAME);
			if(!$db_select){
				die("Database selection failed: " . mysqli_error());	
			}
		}
	}
	
	public function close_connection(){
		if(isset($this->connection)){
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql){
		$this->last_query=$sql;
		$result = mysqli_query($this->connection,$sql,MYSQLI_USE_RESULT);	
		$this->confirm_query($result);
		return $result;
	}
	private function confirm_query($result){
		if(!$result){
			$output = "Database query failed: ".mysqli_error()."<br><br>";
			$output .= "Last SQL query: ".$this->last_query;
			die($output);
		}
	}

	public function escape_value($value){
		if($this->real_escape_string_exits){
			if($this->magic_quotes_active){
				$value = stripslashes($value);
			}
			$value = mysqli_real_escape_string($this->connection,$value);
		}
		else{
			if(!$this->magic_quotes_active){
				$value = addslashes($value);
			}
		}
		return $value;

		
	}

	public function fetch_array($result_set){
		return mysqli_fetch_array($result_set);
	}

	public function num_rows($result_set){
		return mysqli_num_rows($result_set);
	}

	public function insert_id(){
		return mysqli_insert_id($this->connection);
	}

	public function affected_rows(){
		return mysqli_affected_rows($this->connection);
	}
	
}



$database = new MySQLDatabase();
$db = &$database;
