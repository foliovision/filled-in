<?php

class Filter_Checkbox extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		if ($this->config['smallest'] > 0 || $this->config['largest'] > 0)
		{
			if ($this->config['smallest'] > 0 && $this->config['largest'] > 0)
			{
				if (count ($value) >= $this->config['smallest'] && count ($value) <= $this->config['largest'])
					return true;
					
				if (!is_array ($value))
					$value = 'no';
				return sprintf (__ ('between %d and %d items are required', 'filled-in'), $this->config['smallest'], $this->config['largest']);
			}
			else if ($this->config['smallest'] > 0)
			{
				if (count ($value) < $this->config['smallest'])
				{
					if (!is_array ($value))
						$value = 'no';
					return sprintf (__ ("at least %d item(s) are required", 'filled-in'), $this->config['smallest']);
				}
			}
			else if ($this->config['largest'] > 0)
			{
				if (count ($value) > $this->config['largest'])
				{
					if (!is_array ($value))
						$value = 'no';
					return sprintf (__ ("no more than %d item(s) are required", 'filled-in'), $this->config['largest']);
				}
			}
			else if (count ($value) == 0)
				$value = __ ('no', 'filled-in');
		}
		else if ($value == 'on')
			$value = __ ('yes', 'filled-in');
		else if (empty ($value))
			$value = __ ('no', 'filled-in');
		return true;
	}
	
	function name ()
	{
		return __ ("Checkbox/Radio", 'filled-in');
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
		<td><input type="text" name="smallest" value="<?php echo esc_attr( $this->config['smallest'] ); ?>"/> <span class="sub"><?php esc_html_e('items required, leave empty for no smallest', 'filled-in'); ?></span></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Largest', 'filled-in'); ?>:</th>
		<td><input type="text" name="largest" value="<?php echo esc_attr( $this->config['largest'] ); ?>"/> <span class="sub"><?php esc_html_e('items required, leave empty for no smallest', 'filled-in'); ?></span></td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		echo wp_kses( __('is a <strong>Checkbox/Radio</strong>', 'filled-in'), array( 'strong' => array() ) );
		if ($this->config['smallest'] > 0 && $this->config['largest'] > 0)
			printf (__(' with between %d and %d items', 'filled-in'), $this->config['smallest'], $this->config['largest']);
		else if ($this->config['smallest'] > 0)
			printf (__(' with at least %d item(s)', 'filled-in'), $this->config['smallest']);
		else if ($this->config['largest'] > 0)
			printf (__(' with less than %d item(s)', 'filled-in'), $this->config['largest']);
	}
}

$this->register ('Filter_Checkbox');
?>