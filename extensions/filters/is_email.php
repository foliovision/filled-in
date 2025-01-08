<?php

class Filter_Email extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		if (preg_match ('/^([a-zA-Z0-9])+([a-zA-Z0-9\.\+=_-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($value) ))
			return true;
		return __ ("invalid email address", 'filled-in');
	}
	
	function name ()
	{
		return __ ("Email", 'filled-in');
	}

	function show ()
	{
		parent::show ();
		echo wp_kses( __('is an <strong>Email Address</strong>', 'filled-in'), array( 'strong' => array() ) );
	}
}

$this->register ('Filter_Email');
?>
