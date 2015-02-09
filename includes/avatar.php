<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'database.php';

class Avatar extends DatabaseObject{

    protected static $table_name='avatar';
    protected static $id_name="id_player";


	public $id_player;
	public $id_team;
	public $hp;
	public $exp;
    public $attack;
    public $defense;
    public $position;
    public $armor_leg;
    public $armor_torso;
    public $armor_helmet;
    public $troops;

	protected static $db_fields = array('id_player', 'id_team', 'hp', 'exp', 'attack', 'defense', 'position', 'armor_leg', 'armor_torso', 'armor_helmet', 'troops');



	public function full_info(){
//		echo "test full info.<br />";
//		echo $this->id_player;
		if(isset($this->id_player)&&isset($this->id_team)){

            return $this->id_player." ".
                $this->id_team." ".
                $this->hp. " " . 
                $this->exp." ".
                $this->attack." ".
                $this->defense." ".
                $this->position." ".
                $this->armor_leg." ".
                $this->armor_torso." ".
                $this->armor_helmet." ".
                $this->troops;
		}	
		else{
			return "";
		}
	}

	
	public function authenticate($username="",$password=""){
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);

		$sql = "SELECT * FROM ".self::$table_name." ";
		$sql .= "WHERE username = '{$username}' ";
		$sql .= "AND password = '{$password}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);

		return !empty($result_array) ? array_shift($result_array):false;
		
	}

	protected function update_id($id){
		echo "<br />child update id: ".$id."<br />";
		$this->$id_player = $id;
	}

	// Common Database Methods
//	public static function find_all(){
//		echo "from child <br />";
//		return self::find_by_sql("SELECT * FROM ".self::$table_name);
//	}	
//	
//	public static function find_by_id($id=0){
//		global $database;
//		$sql = "SELECT * FROM ".self::$table_name." WHERE id={$id}";
//		$result_array = self::find_by_sql($sql);
//		return !empty($result_array) ? array_shift($result_array) : false;
//	}
//
//	public static function find_by_sql($sql=""){
//		global $database;
//		$result_set = $database->query($sql);
//		$object_array = array();
//		while($row = $database->fetch_array($result_set)){
//			$object_array[] = self::instantiate($row);
//		}
//		return $object_array;
//	}
//
//	private static function instantiate($record){
//		$object = new self;
//		foreach ($record as $attribute => $value) {
//			if($object->has_attribute($attribute)){
////				echo $attribute." ".$value."<br />";
//				$object->$attribute = $value;
//			}	
//		}
//		
//		return $object;
//	}
//			
//	private function has_attribute($attribute){
//		$object_vars = $this->attributes();
//		return array_key_exists($attribute, $object_vars);
//	}	

//	public function create(){
//		global $database;
//		$attributes = $this->sanitized_attributes();
//		$sql = "INSERT INTO ".self::$table_name." (";
//		$sql .= join(", ", array_keys($attributes));
//		$sql .= ") VALUES ('";
//		$sql .= join("', '", array_values($attributes));
//		$sql .= "')";
//
//		if($database->query($sql)){
//			$this->id = $database->insert_id();
//			return true;
//		}
//		else{
//			return false;
//		}
//		
//	}
//	
//	public function update(){
//		global $database;
//		$attributes = $this->sanitized_attributes();
//		$attribute_pairs = array();
//		foreach ($attributes as $key => $value){
//			$attribute_pairs[] = "{$key}='{$value}'"; // don't forget '=' sign
//		}
//		$sql = "UPDATE ".self::$table_name." SET ";
//		$sql .= join(", ", $attribute_pairs);
//		$sql .= " WHERE id=".$database->escape_value($this->id);
//		$database->query($sql);
//		return ($database->affected_rows() == 1)?true:false;
//	}
//
//	public function delete(){
//		global $database;
//		$sql = "DELETE FROM ".self::$table_name." ";
//		$sql .= "WHERE id=".$database->escape_value($this->id);
//		$sql .= " LIMIT 1";
//		$database->query($sql);
//		return ($database->affected_rows() == 1)?true:false;
//	}
//
//	public function save(){
//		return isset($this->id)?$this->update():$this->create();
//	}
//	
//	protected function attributes(){
//		$attributes = array();
//		foreach(self::$db_fields as $field){
//			if(property_exists($this, $field)){
//				$attributes[$field] = $this->$field;	
//			}
//		}
//		return $attributes;
//	}	
//
//	protected function sanitized_attributes(){
//		global $database;
//		$clean_attributes = array();
//		foreach($this->attributes() as $key => $value){
//			$clean_attributes[$key]=$database->escape_value($value);
//		}
//		return $clean_attributes;
//	}	
}
