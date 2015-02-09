<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once (LIB_PATH.DS.'database.php');

class DatabaseObject {
	
//	public static $table_name="avatar";

	public static function find_all(){
		return self::find_by_sql("SELECT * FROM ".static::$table_name);
	}	
	
	public static function find_by_id($id=0){
		global $database;
		$sql = "SELECT * FROM ".  static::$table_name." WHERE ".static::$id_name."={$id}";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
//		return self::find_by_sql($sql);
	}

	public static function find_by_sql($sql=""){
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while($row = $database->fetch_array($result_set)){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}

	private static function instantiate($record){
		$class_name = get_called_class();
		$object = new $class_name;
		foreach ($record as $attribute => $value) {
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}	
		}
		
		return $object;
	}
			
	private function has_attribute($attribute){
		$object_vars = $this->attributes();
		return array_key_exists($attribute, $object_vars);
	}	

	protected static function update_id($id){
		echo "<br />parent update id: ".$id."<br />";
		static::$id = $id;
	}



	public function create(){
		global $database;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".static::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";

		var_dump($sql);
		if($database->query($sql)){
			$ret_id = $database->insert_id();
			echo "<br />the db obj ret_id: ".$ret_id."<br />";
			static::update_id($ret_id);
			return true;
		}
		else{
			return false;
		}
		
	}
	
	public function update(){
		global $database;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach ($attributes as $key => $value){
			$attribute_pairs[] = "{$key}='{$value}'"; // don't forget '=' sign
		}
		$sql = "UPDATE ".static::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE ".static::$id_name."=".$database->escape_value(static::$id);
		
		$database->query($sql);
		return ($database->affected_rows() == 1)?true:false;
	}

	public function delete(){
		global $database;
		$sql = "DELETE FROM ".static::$table_name." ";
		$sql .= "WHERE ".static::$id_name."=".$database->escape_value(static::$id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1)?true:false;
	}

	public function save(){
		return isset(static::$$id_name)?$this->update():$this->create();
	}
	
	protected function attributes(){
		$attributes = array();
		foreach(static::$db_fields as $field){
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;	
			}
		}
		return $attributes;
	}	

	protected function sanitized_attributes(){
		global $database;
		$clean_attributes = array();
		foreach($this->attributes() as $key => $value){
			$clean_attributes[$key]=$database->escape_value($value);
		}
		return $clean_attributes;
	}	
}

