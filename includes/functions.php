<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function strip_zeros_from_date($marked_string=""){
		
	$no_zeros = str_replace('*0', '', $marked_string);
	$cleaned_string = str_replace('*', '', $no_zeros);
	return $cleaned_string;
}

function redirect_to($location=NULL){
	
	if($location != NULL){ 
		header("Location: {$location}");
		exit;
	}
	
}

function output_message($message=""){
	if(!empty($message)){
		return "<p class=\"message\"></p>";
	}
	else{
		return "";
	}
	
}

function __autoload($class_name){
	$class_name = strtolower($class_name);
	$path = "../includes/{$class_name}.php";
	if(file_exists($path)){
		require_once($path);
	}
	else{
		die("The file {$class_name}.php could not be found.");
	}
}

function log_action($action, $message=""){
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile, 'a')?false:true;
	if($handle = fopen($logfile, 'a')){
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", $time());
		$content = "{$timestamp} | {$action}: {$message}\n";
		fwrite($handle, $content);
		fclose($handle);
		if($new){
			chmod($logfile, 0755);
		}
	}
	else{
		echo "Could not open log file for writing.";
	}
}