<?php

class FI_Errors
{
	var $id;
	var $data_id;
	var $form_id;
	var $type;
	var $message;
	
	function __construct ($values = '')
	{
		if (is_array ($values))
		{
			foreach ($values AS $key => $value)
			 	$this->$key = $value;

			if ($this->message != '')
				$this->message = unserialize ($this->message);
				
			$this->id      = intval ($this->id);       // It makes my test case easier...
			$this->data_id = intval ($this->data_id);
			$this->form_id = intval ($this->form_id);
		}
	}
	
	public static function load ($dataid)
	{
		global $wpdb;
		
		$row = $wpdb->get_row ("SELECT * FROM {$wpdb->prefix}filled_in_errors WHERE data_id='$dataid'", ARRAY_A);
		if ($row)
			return new FI_Errors ($row);
		return false;
	}
	
	function delete ()
	{
		global $wpdb;
		return $wpdb->query ("DELETE FROM {$wpdb->prefix}filled_in_errors WHERE id='{$this->id}'");
	}
	
	function save ($form_id, $data_id)
	{
		assert ('intval ($form_id) > 0');
		assert ('intval ($data_id) > 0');
		global $wpdb;

		$this->form_id = $form_id;
		$this->data_id = $data_id;

		$group   = esc_sql ($this->type);
		$message = esc_sql (serialize ($this->message));
		$result = $wpdb->query ("INSERT INTO {$wpdb->prefix}filled_in_errors (form_id,data_id,type,message) VALUES ('$form_id','$data_id','$group','$message')");
    
    if( ip2long($_SERVER['REMOTE_ADDR']) > 0 ) {
      $entries = $wpdb->get_col( "select d.id from {$wpdb->prefix}filled_in_data as d join {$wpdb->prefix}filled_in_errors as e on d.id = e.data_id where ip = '".ip2long($_SERVER['REMOTE_ADDR'])."' order by d.id asc" );
      if( count($entries) > 100 ) {
        $entries = array_slice($entries,100);
        $ids = implode( ',', $entries);
        //file_put_contents( ABSPATH.'/fi-errors-save.log', date('r')." submission from ".$_SERVER['REMOTE_ADDR']." deleting ".count($entries)." items: ".$ids."\n", FILE_APPEND );
        $wpdb->query( "delete from {$wpdb->prefix}filled_in_data where id IN ($ids)" );
        $wpdb->query( "delete from {$wpdb->prefix}filled_in_errors where data_id IN ($ids)" );
      }
    }
    
    
		$this->id = $wpdb->insert_id;
		return $result !== false;
	}

	function to_string ()
	{
		if (count ($this->message) == 1)
			return __ ('1 error', 'filled-in');
		else
			return sprintf (__ ("%d errors", 'filled-in'), count ($this->message));
	}
	
	function add ($name, $message, $type)
	{
		$this->message[$name] = $message;
		$this->type = $type;
	}
	
	function gather ($extensions)
	{
		assert (is_array ($extensions));

		foreach ($extensions AS $extent)
		{
			if (!empty ($extent->errors))
			{
				$this->type = $extent->what_group ();
				if (is_array ($extent->errors))
					$this->message[$extent->errors[0]][] = $extent->errors[1];
				else
					$this->message = $extent->errors;
			}
		}
	}
	
	function show_error ($key)
	{
		if ($this->in_error ($key))
		{
			if (is_array ($this->message[$key]))
				return implode (', ', $this->message[$key]);
			else
				return $this->message[$key];
		}
	}
	
	function have_errors () { return !empty ($this->message); }
	function in_error ($name) { return is_array ($this->message) && isset ($this->message[$name]) === true; }
	function what_type () { return $this->type; }
}


?>