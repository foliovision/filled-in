<?php

class Filter_Is_Numeric extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		if (strlen ($value) > 0)
		{
			// Remove all non-digits
			if ($this->config['euro'] == 'false')
				$newval = preg_replace ('/[^0-9+\.\-]/', '', $value);
			else
				$newval = preg_replace ('/[^0-9+,\-]/', '', $value);

			if (is_numeric ($newval))
			{
				$value = $newval;
				return true;
			}
			
			return __ ("must be a number", 'filled-in');
		}
		
		return true;
	}
	
	function name ()
	{
		return __ ("Is Numeric", 'filled-in');
	}
	
	function save ($config)
	{
		if (isset ($config['euro']))
			$config['euro'] = 'true';
		else
			$config['euro'] = 'false';
			
		return array ('euro' => $config['euro']);
	}
	
	function edit ()
	{
		parent::edit ();
	?>
	<tr>
		<th><?php esc_html_e('European', 'filled-in'); ?>:</th>
		<td><input type="checkbox" name="euro" <?php if ($this->config['euro'] == 'true') echo ' checked="checked"' ?>/> <span class="sub"><?php esc_html_e('European-style decimal and thousands', 'filled-in') ?></span></td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		esc_html_e('is <strong>Numeric</strong>', 'filled-in');
		if ($this->config['euro'] == 'true')
		  esc_html_e(' (European style)', 'filled-in');
	}
}

$this->register ('Filter_Is_Numeric');
?>