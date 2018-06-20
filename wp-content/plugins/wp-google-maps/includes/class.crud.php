<?php

namespace WPGMZA;

class Crud implements \IteratorAggregate, \JsonSerializable
{
	private static $cached_columns_by_table_name;
	private static $cached_column_name_map_by_table_name;

	private $id;
	private $table_name;
	private $fields;
	private $modified;
	
	private $trashed = false;
	
	/**
	 * Constructor
	 * @constructor
	 */
	public function __construct($table_name, $id_or_fields=-1)
	{
		global $wpdb;
		
		$this->fields = array();
		
		if(is_object($id_or_fields) || is_array($id_or_fields))
		{
			foreach($id_or_fields as $key => $value)
				$this->fields[$key] = $value;
				
			$id = -1;
		}
		else if(preg_match('/^-?\d+$/', $id_or_fields))
			$id = (int)$id_or_fields;
		else {
			var_dump($id_or_fields);
			throw new \Exception('Invalid ID');
		}
		
		$this->table_name = $table_name;
		
		$this->id = $id;
		
		if(!isset(Crud::$cached_columns_by_table_name))
			Crud::$cached_columns_by_table_name = array();
		
		if(!isset(Crud::$cached_columns_by_table_name[$table_name]))
		{
			$columns = $wpdb->get_results("SHOW COLUMNS FROM $table_name");
			
			Crud::$cached_column_name_map_by_table_name[$table_name] = array();
			foreach($columns as $col)
				Crud::$cached_column_name_map_by_table_name[$table_name][$col->Field] = true;
			
			Crud::$cached_columns_by_table_name[$table_name] = $columns;
		}
		
		if($this->id == -1)
			$this->create();
		else
			$this->read();
	}
	
	/**
	 * Gets the table name
	 * @return string
	 */
	public function get_table_name()
	{
		return $this->table_name;
	}
	
	/**
	 * Gets the column information (name, type, etc.)
	 * @return array
	 */
	public function get_columns()
	{
		return Crud::$cached_columns_by_table_name[$this->table_name];
	}
	
	/**
	 * Returns an array of the column names represented as strings
	 * @return array
	 */
	public function get_column_names()
	{
		return array_keys( Crud::$cached_column_name_map_by_table_name[$this->table_name] );
	}
	
	/**
	 * Return the SQL field type of the specified column
	 * @return string
	 */
	public function get_column_type($name)
	{
		$columns = $this->get_columns();
		
		foreach($columns as $index => $column)
		{
			if($column->Field == $name)
				return $column->Type;
		}
		
		return Crud::$cached_columns_by_table_name[$this->table_name];
	}
	
	protected function get_placeholder_by_type($type)
	{
		$type = strtolower(preg_replace('/\(\d+\)$/', '', $type));
		
		switch($type)
		{
			case 'tinyint':
			case 'smallint':
			case 'mediumint':
			case 'int':
			case 'bigint':
			case 'bit':
			case 'boolean':
				$placeholder = '%d';
				break;
			
			case 'decimal':
			case 'float':
			case 'double':
			case 'real':
				$placeholder = '%f';
				break;
				
			/*case 'geometry':
			case 'point':
			case 'linestring':
			case 'polygon':
			case 'multipoint':
			case 'multilinestring':
			case 'multipolygon':
			case 'geometrycollection':
				$placeholders[] = 'NULL';
				
				// This can be implemented in a subclass
				
				break;*/
				
			default:
				$placeholder = '%s';
				break;
		}
		
		return $placeholder;
	}
	
	protected function get_column_parameter($name)
	{
		if(array_key_exists($name, $this->fields))
			return $this->fields[$name];
		
		return '';
	}
	
	protected function get_column_placeholders()
	{
		$columns = $this->get_columns();
		$placeholders = array();
		
		foreach($columns as $index => $column)
		{
			if($column->Field == 'id')
				continue;
			
			$placeholders[] = $this->get_placeholder_by_type($column->Type);
		}
		
		return $placeholders;
	}
	
	protected function get_column_parameters()
	{
		$columns = $this->get_columns();
		$params = array();
		
		foreach($columns as $index => $column)
		{
			if($column->Field == 'id')
				continue;
			
			$params[] = $this->get_column_parameter($column->Field);
		}
		
		return $params;
	}
	
	protected function get_arbitrary_data_column_name()
	{
		return null;
	}
	
	/**
	 * Asserts that this object hasn't been trashed and throws an exception if it has
	 * @return void
	 */
	protected function assert_not_trashed()
	{
		if($this->trashed)
			throw new \Exception('Operation on trashed map object');
	}
	
	/**
	 * Returns true if the named column exists on this map objects table
	 * @return void
	 */
	protected function column_exists($name)
	{
		return isset($cached_column_name_map_by_table_name[$this->table_name]);
	}
	
	protected function parse_arbitrary_data($data)
	{
		if(!$this->get_arbitrary_data_column_name())
			throw new \Exception('No arbitrary data field on this table');
		
		$data = maybe_unserialize($data);
		
		if(!is_object($data) && !is_array($data))
			return;
		
		foreach($data as $key => $value)
			$this->fields[$key] = $value;
	}
	
	protected function store_arbitrary_data($key, $value)
	{
		if(!$this->get_arbitrary_data_column_name())
			throw new \Exception('No arbitrary data field on this table');
		
		
	}
	
	/**
	 * Creates the map object in the database
	 * @return void
	 */
	protected function create()
	{
		global $wpdb;
		
		$this->assert_not_trashed();
		
		// TODO: Support arbitrary data
		
		$column_names = array_flip( $this->get_column_names() );
		unset($column_names['id']);
		$column_names	= implode(',', array_keys($column_names));
		
		$placeholders	= implode(',', $this->get_column_placeholders());
		$parameters		= $this->get_column_parameters();
		
		$qstr = "INSERT INTO `{$this->table_name}` ($column_names) VALUES ($placeholders)";
		$stmt = $wpdb->prepare($qstr, $parameters);
		$wpdb->query($stmt);
		
		$this->id = $wpdb->insert_id;
	}
	
	/**
	 * Reads the data from the database into this object
	 * @return void
	 */
	protected function read()
	{
		global $wpdb;
		
		$this->assert_not_trashed();
		
		$stmt = $wpdb->prepare("SELECT * FROM " . $this->get_table_name() . " WHERE id = %d", array($this->id));
		$results = $wpdb->get_results($stmt);
		
		if(empty($results))
			throw new \Exception('Map object not found');
		
		$this->fields = (array)$results[0];
		unset($this->fields['id']);
		
		$arbitrary_data_column_name = $this->get_arbitrary_data_column_name();
		
		if($arbitrary_data_column_name && isset($this->fields->arbitrary_data_column_name))
		{
			$this->parse_arbitrary_data($this->fields[$arbitrary_data_column_name]);
			unset($this->fields[$arbitrary_data_column_name]);
		}
	}
	
	protected function is_read_only($key)
	{
		switch($key)
		{
			case 'id':
			case 'table_name':
			case 'fields':
			case 'modified':
			case 'trashed':
				return true;
				break;
		}
		
		return false;
	}
	
	/**
	 * Updates the map object in the database
	 * @return $this
	 */
	public function update()
	{
		global $wpdb;
		
		$this->assert_not_trashed();
		
		$column_names = array_flip( $this->get_column_names() );
		unset($column_names['id']);
		$column_names = array_keys($column_names);
		
		$placeholders = $this->get_column_placeholders();
		$parameters	= $this->get_column_parameters();
		
		$assignments = array();
		for($i = 0; $i < count($column_names); $i++)
			$assignments[] = $column_names[$i] . '=' . $placeholders[$i];
		$assignments = implode(',', $assignments);
		
		$parameters[] = $this->id;
		
		$qstr = "UPDATE {$this->table_name} SET $assignments WHERE id=%d";
		$stmt = $wpdb->prepare($qstr, $parameters);
		$wpdb->query($stmt);

		// Arbitrary data
		$data = array();
			
		foreach($this->fields as $key => $value)
		{
			if(array_search($key, $column_names) !== false)
				continue;
			
			$data[$key] = $value;
		}
		
		$arbitrary_data_column_name = $this->get_arbitrary_data_column_name();
		
		if(!empty($data) && !$arbitrary_data_column_name)
			trigger_error('Arbitrary data cannot be stored on this column - the following fields will be lost: ' . implode(', ', array_keys($data)), E_USER_WARNING);
		else if($arbitrary_data_column_name)
		{
			$data = serialize($data);
			
			$stmt = $wpdb->prepare("UPDATE {$this->table_name} SET $arbitrary_data_column_name=%s WHERE id=%d", array($data, $this->id));
			
			$wpdb->query($stmt);
		}
		
		return $this;
	}
	
	/**
	 * Deletes the marker
	 * @return void
	 */
	public function trash()
	{
		global $wpdb;
		
		$this->assert_not_trashed();
		
		$stmt = $wpdb->prepare("DELETE FROM {$this->table_name} WHERE id=%d", array($this->id));
		
		$wpdb->query($stmt);
		
		$this->trashed = true;
	}
	
	/**
	 * Set variables in bulk, this reduces the number of database calls
	 * @return $this
	 */
	public function set($arg, $val=null)
	{
		$this->assert_not_trashed();
		
		if(is_string($arg))
		{
			$this->__set($arg, $val);
		}
		else if(is_array($arg) || is_object($arg))
		{
			foreach($arg as $key => $value)
			{
				if($this->is_read_only($key))
					throw new \Exception('Property is read only');
				
				$this->fields[$key] = $value;
			}
			
			$this->update();
		}
		else
			throw new \Exception('Invalid argument');
		
		return $this;
	}
	
	/**
	 * Get's the iterator for iterating over map object properties
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		$this->assert_not_trashed();
		
		return new \ArrayIterator($this->fields);
	}
	
	/**
	 * Returns the objects properties to be serialized as JSON
	 * @return array
	 */
	public function jsonSerialize()
	{
		$this->assert_not_trashed();
		
		return $this->fields;
	}
	
	/**
	 * Magic method to get map object fields
	 * @return mixed
	 */
	public function __get($name)
	{
		$this->assert_not_trashed();
		
		if(isset($this->fields[$name]))
			return $this->fields[$name];
		
		switch($name)
		{
			case 'id':
			case 'modified':
			case 'custom_fields':
				return $this->{$name};
				break;				
		}
		
		return null;
	}
	
	/**
	 * Checks if a field is set by name
	 * @return boolean
	 */
	public function __isset($name)
	{
		$this->assert_not_trashed();
		
		return isset($this->fields[$name]);
	}
	
	/**
	 * Sets the property value by name
	 * @return void
	 */
	public function __set($name, $value)
	{
		global $wpdb;
		
		$this->assert_not_trashed();
		
		if($this->is_read_only($name))
			throw new \Exception('Property is read only');
		
		$this->fields[$name] = $value;
		
		$columns = $this->get_columns();
		
		// TODO: This loop could be replaced with a placeholder cache
		foreach($columns as $column)
		{
			if($column->Field != $name)
				continue;
			
			$placeholder = $this->get_placeholder_by_type($column->Type);
			$params = array($value, $this->id);
			
			$stmt = $wpdb->prepare("UPDATE {$this->table_name} SET $name = $placeholder WHERE id = %d", $params);
			$wpdb->query($stmt);
			
			return;
		}
		
		$arbitrary_data_column_name = $this->get_arbitrary_data_column_name();
		
		if(!$arbitrary_data_column_name)
			throw new \Exception('Cannot store arbitrary data on this table');
		
		$stmt = $wpdb->prepare("SELECT $arbitrary_data_column_name FROM {$this->table_name} WHERE id=%d", array($this->id));
		
		$data = maybe_unserialize($wpdb->get_var());
		
		if(empty($data))
			$data = array();
		
		$data[$name] = $value;
		
		$data = serialize($data);
		
		$stmt = $wpdb->prepare("UPDATE {$this->table_name} SET $arbitrary_data_column_name=%s WHERE id=%d", array($data, $this->id));
		
		$wpdb->query($stmt);
	}
	
	/**
	 * Unsets the named variable, only valid for arbitrary data
	 * @return void
	 * @throws \Exception when attempting to unset a column
	 */
	public function __unset($name)
	{
		$column_names = $this->get_column_names();
		
		if(array_search($name, $column_names) !== false)
			throw \Exception('Only arbitrary data can be unset. Columns must be set to NULL instead');
		
		unset($this->fields[$name]);
		
		$this->update();
	}
}
