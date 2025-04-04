<?php

class Filter_String_Length extends FI_Filter
{
	var $lower;
	var $higher;
	
	function filter (&$value, $all_data)
	{
		if ($this->config['shortest'] > 0 && $this->config['longest'] > 0)
		{
			if (strlen ($value) > $this->config['shortest'] && strlen ($value) < $this->config['longest'])
				return true;
			return sprintf (__ ('value must be between %d and %d characters long', 'filled-in'), $this->config['shortest'], $this->config['longest']);
		}
		else if ($this->config['shortest'] > 0)
		{
			if (strlen ($value) > $this->config['shortest'])
				return true;
			return sprintf (__ ("value must be %d characters long", 'filled-in'), $this->config['shortest']);
		}
		else if ($this->config['longest'] > 0)
		{
			if (strlen ($value) < $this->config['longest'])
				return true;
			return sprintf (__ ("value must be less than %d characters long", 'filled-in'), $this->config['longest']);
		}

		return true;
	}
	
	function name ()
	{
		return __ ("String Length", 'filled-in');
	}
	
	function save ($config)
	{
		if ($config['longest'] < $config['shortest'])
			$config['longest'] = '';
		return array ('shortest' => intval ($config['shortest']), 'longest' => intval ($config['longest']));
	}
	
	function edit ()
	{
		parent::edit ();
	?>
	<tr>
		<th><?php esc_html_e('Shortest', 'filled-in'); ?>:</th>
		<td><input type="text" name="shortest" value="<?php echo esc_attr( isset($this->config['shortest']) ? $this->config['shortest'] : '' ) ?>"/> <span class="sub"><?php esc_html_e('characters, leave empty for no shortest', 'filled-in'); ?></span></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Longest', 'filled-in'); ?>:</th>
		<td><input type="text" name="longest" value="<?php echo esc_attr( isset($this->config['longest']) ? $this->config['longest'] : '' ) ?>"/> <span class="sub"><?php esc_html_e('characters, leave empty for no longest', 'filled-in'); ?></span></td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		echo wp_kses( 'with <strong>String Length</strong> ', 'filled-in', array( 'strong' => array() ) );
		if (isset($this->config['shortest']) && $this->config['shortest'] > 0 && $this->config['longest'] > 0)
			echo esc_html( sprintf (__('between %d and %d characters long', 'filled-in'), $this->config['shortest'], $this->config['longest']) );
		else if (isset($this->config['shortest']) && $this->config['shortest'] > 0)
			echo esc_html( sprintf (__('at least %d characters long', 'filled-in'), $this->config['shortest']) );
		else if (isset($this->config['longest']) && $this->config['longest'] > 0)
			echo esc_html( sprintf (__('less than %d characters long', 'filled-in'), $this->config['longest']) );
		else
			echo esc_html( sprintf ( '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>' ) );
	}
}

$this->register ('Filter_String_Length');
?>