<?php

class Filter_Is_Equal extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		$this->config['values'] = $this->replace_fields ($all_data, $this->config['values']);
		$equals = preg_split ('/[\n\r]+/', $this->config['values']);
		if (count ($equals) > 0)
		{
			$matched = false;
			foreach ($equals AS $item)
			{
				if ($this->config['regex'] == 'true')
				{
					if (preg_match ('@'.str_replace ('@', '\\@', $item).'@', $value, $matches) > 0)
					{
						$matched = true;
						break;
					}
				}
				else if ($value == $item)
				{
					$matched = true;
					break;
				}
			}

			if ($matched == true && $this->config['not'] == 'true')
				return sprintf (__ ("must not equal '%s'", 'filled-in'), $value);
			else if ($matched == false && $this->config['not'] != 'true')
			{
				if($this->config['error']){
					return __ ($this->config['error'],'filled-in');					
				}elseif (count ($equals) == 1){
					return sprintf (__ ("must equal '%s'", 'filled-in'), $this->config['values']);
				}else{
					return sprintf (__ ('must equal one of: %s', 'filled-in'), "'".implode ('\' or \'', $equals)."'");
				}
			}
		}
		
		return true;
	}
	
	function name ()
	{
		return __ ("Is Equal", 'filled-in');
	}
	
	function save ($config)
	{
		return array ('values' => $config['values'], 'regex' => (isset ($config['regex']) ? 'true' : 'false'), 'not' => isset ($config['not']) ? 'true' : 'false');
	}
	
	function edit ()
	{
		parent::edit ();
	?>
	<tr>
		<th><label for="not"><?php esc_html_e('Not equal', 'filled-in')?>:</label></th>
		<td valign="top">
			<input type="checkbox" name="not" id="not" <?php if ( ! empty( $this->config['not'] ) && $this->config['not'] == 'true') echo ' checked="checked"' ?>/>
		</td>
	</tr>
	<tr>
		<th valign="top"><?php esc_html_e('Values', 'filled-in') ?>:<br/>
			<span class="sub"><?php esc_html_e('Each value on a separate line.', 'filled-in'); ?></span>
		</th>
		<td>
			<textarea name="values" rows="5" style="width: 95%"><?php echo esc_textarea( ! empty( $this->config['values'] ) ? $this->config['values'] : '' ) ?></textarea>
		</td>
	</tr>
	<tr>
		<th><label for="regex"><?php esc_html_e('Regex', 'filled-in')?>:</label></th>
		<td valign="top">
			<input type="checkbox" name="regex" id="regex" <?php if ( ! empty( $this->config['regex'] ) && $this->config['regex'] == 'true') echo ' checked="checked"' ?>/>
		</td>
	</tr>
	<tr>
		<th></th>
		<td><span class="sub"><?php esc_html_e('Remember that you can use other fields (i.e. this field is less than <code>$otherfield$</code>)', 'filled-in') ?></span></td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		if ( ! empty( $this->config['not'] ) && $this->config['not'] == 'true')
			echo wp_kses( __('is <strong>Not Equal To</strong>: ', 'filled-in'), array( 'strong' => array() ) );
		else
			echo wp_kses( __('is <strong>Equal To</strong>: ', 'filled-in'), array( 'strong' => array() ) );
			
		if (!isset ($this->config['values']) || $this->config['values'] == '')
			echo ' <em>' . esc_html( __('&lt;not configured&gt;', 'filled-in') ) . '</em>';
		else
		{
			$values = preg_split ('/[\n\r]+/', $this->config['values']);
			echo esc_html( "'".implode ('\' or \'', $values)."'" );
		}
	}
}

$this->register ('Filter_Is_Equal');
?>