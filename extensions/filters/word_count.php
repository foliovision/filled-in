<?php

class Filter_Word_Count extends FI_Filter
{
	function filter (&$value, $all_data)
	{
		if ($this->config['shortest'] > 0 && $this->config['longest'] > 0)
		{
			if (str_word_count ($value) >= $this->config['shortest'] && str_word_count ($value) < $this->config['longest'])
				return true;
			return sprintf (__ ('value must be between %d and %d words long', 'filled-in'), $this->config['shortest'], $this->config['longest']);
		}
		else if ($this->config['shortest'] > 0)
		{
			if (str_word_count ($value) >= $this->config['shortest'])
				return true;
			return sprintf (__ ("value must be %d words long", 'filled-in'), $this->config['shortest']);
		}
		else if ($this->config['longest'] > 0)
		{
			if (str_word_count ($value) < $this->config['longest'])
				return true;
			return sprintf (__ ("value must be less than %d words long", 'filled-in'), $this->config['longest']);
		}

		return true;
	}
	
	function name ()
	{
		return __ ("Word Count", 'filled-in');
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
		<th><?php esc_html_e('Smallest', 'filled-in'); ?>:</th>
		<td><input type="text" name="shortest" value="<?php echo esc_attr( ! empty( $this->config['shortest'] ) ? $this->config['shortest'] : '' ); ?>"/> <span class="sub"><?php esc_html_e('words, leave empty for no shortest', 'filled-in'); ?></em></td>
	</tr>
	<tr>
		<th><?php esc_html_e('Largest', 'filled-in'); ?>:</th>
		<td><input type="text" name="longest" value="<?php echo esc_attr( ! empty( $this->config['longest'] ) ? $this->config['longest'] : '' ); ?>"/> <span class="sub"><?php esc_html_e('words, leave empty for no longest', 'filled-in'); ?></em></td>
	</tr>
	<?php
	}
	
	function show ()
	{
		parent::show ();
		echo wp_kses( 'with <strong>Word Count</strong> ', 'filled-in', array( 'strong' => array() ) );
		if ( ! empty( $this->config['shortest'] ) && intval( $this->config['shortest'] ) > 0 && ! empty( $this->config['longest'] ) && intval( $this->config['longest'] ) > 0)
			printf (__('between %d and %d words long', 'filled-in'), $this->config['shortest'], $this->config['longest']);
		else if ( ! empty( $this->config['shortest'] ) && intval( $this->config['shortest'] ) > 0 )
			printf (__('at least %d words long', 'filled-in'), $this->config['shortest']);
		else if ( ! empty( $this->config['longest'] ) && intval( $this->config['longest'] ) > 0 )
			printf (__('less than %d words long', 'filled-in'), $this->config['longest']);
		else
			printf ( '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>' );
	}
}

$this->register ('Filter_Word_Count');

?>