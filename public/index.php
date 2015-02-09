<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../includes/initialize.php';

//if(isset($database)){echo "true";} else {echo "false";}
//echo "<br />";
//
//echo $database->escape_value("It's working? <br>");
//
//$sql = "INSERT INTO users(id, username, password, first_name, last_name)";
//$sql .= "VALUE (1, 'kskoglund', 'secretpwd', 'Kevin', 'kskoglund')";
//$result = $database->query($sql);

echo "<hr />";


//$user = User::find_by_id(1);
//$user->password="456";
//$user->update();
//echo $user->full_name();
//
//echo "<hr>";

//echo "army below: <br \>";
//$armies = Army::find_all();
//
//foreach($armies as $army){
//
//	echo $army->full_info()."<br>";
//}


echo "avator below: <br \>";
$avatars = new Avatar();
//$values=array('250', '50','50','50','50','50','\0\0\0\0\0\0\0\0\0\0\0\0\0$@\0\0\0\0\0\0$@','50','50','10','15');
//$avatars->insert($values);

echo "find all test: <br \>";
$results = $avatars->find_all();

foreach($results as $result){

	echo $result->full_info()."<br>";
}



echo "<hr />";
echo "create test: <br \>";
echo 'create an avatars item: 50, 50,50,50,50,50,\0\0\0\0\0\0\0\0\0\0\0\0\0$@\0\0\0\0\0\0$@,50,50,50,15';
$avatars->id_player="50";
$avatars->id_team="50";
$avatars->hp="50";
$avatars->exp="50";
$avatars->attack="50";
$avatars->defense="50";
$avatars->position="\0\0\0\0\0\0\0\0\0\0\0\0\0$@\0\0\0\0\0\0$@";
$avatars->armor_leg="50";
$avatars->armor_torso="50";
$avatars->armor_helmet="50";
$avatars->troops="50";

$avatars->create();


echo "result is: <br \>";
$results_by_id = $avatars->find_by_id(50);
echo $results_by_id->full_info();

echo "<hr />";
echo "update test: <br \>";
$avatars->id_player=50;
$avatars->hp=100;
$avatars->exp=100;
$avatars->attack=100;
$avatars->defense=100;

$avatars->update();

echo "update result is: <br \>";
$results_by_id = $avatars->find_by_id(50);
echo $results_by_id->full_info();

echo "<hr />";
echo "delete test: <br \>";
$avatars->delete();

echo "final database result: <br \>";
$results = $avatars->find_all();

foreach($results as $result){

	echo $result->full_info()."<br>";
}