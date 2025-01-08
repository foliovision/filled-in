<?php

class Filter_Is_Greater extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		$greater = $this->replace_fields ($all_data, $this->config['value']);

		if (($this->config['equal'] == 'true' && $value >= $greater) ||
			  ($this->config['equal'] == 'false' && $value > $greater))
			return true;
			
		if ($this->config['equal'] == 'true')
			return sprintf (__ ("value must be greater or equal to %d", 'filled-in'), $greater);
		else
			return sprintf (__ ("value must be greater than %d", 'filled-in'), $greater);
	}
	
	function name ()
	{
		return __ ("Is Greater", 'filled-in');
	}

	function save ($config)
	{
		if (isset ($config['equal']))
			$config['equal'] = 'true';
		else
			$config['equal'] = 'false';
		return array ('value' => $config['value'], 'equal' => $config['equal']);
	}
	
	function edit ()
	{
		parent::edit ();
	?>
	<tr>
		<th valign="top"><?php esc_html_e('Greater than', 'filled-in') ?>:</th>
		<td>
			<input type="text" name="value" value="<?php echo esc_attr( ! empty( $this->config['value'] ) ? $this->config['value'] : '' ); ?>"/>
			<?php esc_html_e ('or equal:', 'filled-in')?>
			<input type="checkbox" name="equal" <?php if ( ! empty( $this->config['equal'] ) && $this->config['equal'] == 'true') echo ' checked="checked"' ?>/>
			<p><?php esc_html_e('Remember that you can use other fields (i.e. this field is less than $otherfield$)', 'filled-in'); ?></p>
		</td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		if ( ! empty( $this->config['equal'] ) && $this->config['equal'] == 'true')
			echo wp_kses( 'is <strong>Greater Than Or Equal To</strong> ', 'filled-in', array( 'strong' => array() ) );
		else
			echo wp_kses( 'is <strong>Greater Than</strong> ', 'filled-in', array( 'strong' => array() ) );
			
		if (!isset ($this->config['value']))
			echo ' <em>' . __('&lt;not configured&gt;', 'filled-in') . '</em>';
		else
			echo esc_html( $this->config['value'] );
	}
}

$this->register ('Filter_Is_Greater');
?>