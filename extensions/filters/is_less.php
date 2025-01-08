<?php

class Filter_Is_Less extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		$less = $this->replace_fields ($all_data, $this->config['value']);

		if (($this->config['equal'] == 'true' && $value <= $less) ||
			  ($this->config['equal'] == 'false' && $value < $less))
			return true;
			
		if ($this->config['equal'] == 'true')
			return sprintf (__ ("value must be less than or equal to %d", 'filled-in'), $less);
		else
			return sprintf (__ ("value must be less than %d", 'filled-in'), $less);
	}
	
	function name ()
	{
		return __ ("Is Less", 'filled-in');
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
		<th valign="top"><?php esc_html_e('Less than', 'filled-in') ?>:</th>
		<td>
			<input type="text" name="value" value="<?php echo esc_attr( $this->config['value'] ); ?>"/>
			<?php esc_html_e ('or equal:', 'filled-in')?>
			<input type="checkbox" name="equal" <?php if ($this->config['equal'] == 'true') echo ' checked="checked"' ?>/>
			<p><?php esc_html_e('Remember that you can use other fields (i.e. this field is less than $otherfield$)', 'filled-in'); ?></p>
		</td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		if ($this->config['equal'] == 'true')
			echo wp_kses( 'is <strong>Less Than Or Equal To</strong> ', 'filled-in', array( 'strong' => array() ) );
		else
			echo wp_kses( 'is <strong>Less Than</strong> ', 'filled-in', array( 'strong' => array() ) );
			
		if (!isset ($this->config['value']))
			echo ' <em>' . __('&lt;not configured&gt;', 'filled-in') . '</em>';
		else
			echo $this->config['value'];
	}
}

$this->register ('Filter_Is_Less');
?>