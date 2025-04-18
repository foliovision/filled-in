<?php

class Filter_Is_Required_WP extends FI_Filter
{
	function filter (&$value, $all_data)
	{
    if ($this->config['smallest'] > 0 && $this->config['largest'] > 0)
		{
			if ((is_string($value) && strlen($value) >= $this->config['smallest'] && strlen($value) <= $this->config['largest']) || (is_array($value) && count($value) >= $this->config['smallest'] && count($value) <= $this->config['largest'])) 
				return true;
			return sprintf (__ ('between %d and %d items are required', 'filled-in'), $this->config['smallest'], $this->config['largest']);
		}
		else if ($this->config['smallest'] > 0)
		{
			if ((is_string($value) && strlen($value) > $this->config['smallest']) || (is_array($value) && count($value) >= $this->config['smallest'])) 
				return true;
			return sprintf (__ ("at least %d items are required", 'filled-in'), $this->config['smallest']);
		}
		else if ($this->config['largest'] > 0)
		{
			if ((is_string($value) && strlen($value) < $this->config['largest']) || (is_array($value) && count($value) <= $this->config['largest']))
				return true;
			return sprintf (__ ("no more than %d items are required", 'filled-in'), $this->config['largest']);
		}
		else if ((is_string($value) && strlen($value) > 0) || (is_array($value) && count($value) > 0))
			return true;
		return __ ("a value is required", 'filled-in');
	}
	
	function name ()
	{
		return __ ("Is Required", 'filled-in');
	}
	
	function save ($config)
	{
		if ($config['largest'] < $config['smallest'])
			$config['largest'] = '';
		return array ('smallest' => intval ($config['smallest']), 'largest' => intval ($config['largest']));
	}
	
	function edit ()
	{
		parent::edit ();
	?>
	<tr>
		<th><?php esc_html_e('Smallest', 'filled-in'); ?>:</th>
		<td><input type="text" name="smallest" value="<?php echo esc_attr( isset($this->config['smallest']) ? $this->config['smallest'] : '' ) ?>"/> <span class="sub"><?php esc_html_e('items required, leave empty for no smallest', 'filled-in'); ?></span></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Largest', 'filled-in'); ?>:</th>
		<td><input type="text" name="largest" value="<?php echo esc_attr( isset($this->config['largest']) ? $this->config['largest'] : '' ) ?>"/> <span class="sub"><?php esc_html_e('items required, leave empty for no largest', 'filled-in'); ?></span></td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		echo wp_kses( 'is <strong>Required</strong>', 'filled-in', array( 'strong' => array() ) );
		if (isset($this->config['smallest']) && $this->config['smallest'] > 0 && $this->config['largest'] > 0)
			echo esc_html( sprintf (__(' with between %d and %d items', 'filled-in'), $this->config['smallest'], $this->config['largest']) );
		else if (isset($this->config['smallest']) && $this->config['smallest'] > 0)
			echo esc_html( sprintf (__(' with at least %d items', 'filled-in'), $this->config['smallest']) );
		else if (isset($this->config['largest']) && $this->config['largest'] > 0)
			echo esc_html( sprintf (__(' with less than %d items', 'filled-in'), $this->config['largest']) );
	}
}

$this->register ('Filter_Is_Required_WP');
?>