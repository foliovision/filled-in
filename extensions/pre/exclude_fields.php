<?php

class Pre_Exclude_Fields extends FI_Pre
{
	function process (&$source)
	{
		$fields = explode (',', $this->config['fields']);
		
		if (count ($fields) > 0)
		{
			$post =& $source->get_source ('post');
			foreach ($fields AS $field)
			{
				if (isset ($post->data[$field]))
					unset ($post->data[$field]);
			}
		}

		return true;
	}
	
	function name ()
	{
		return __ ("Exclude these fields", 'filled-in');
	}
	
	function edit ()
	{
	  ?>
		<tr>
			<th><?php esc_html_e('Fields', 'filled-in'); ?>:</th>
			<td>
				<input size="40" type="text" name="fields" value="<?php echo esc_attr ($this->config['fields']) ?>"/>
				<span class="sub"><?php esc_html_e('separate fields with comma', 'filled-in'); ?></span>
			</td>
		</tr>
	  <?php
	}
	
	function show ()
	{
		parent::show ();
		
		$fields = $this->config['fields'];
		if ($fields == '')
			echo ' <em>' . esc_html( __('&lt;not configured&gt;', 'filled-in') ) . '</em>';
		else
			echo esc_html( " '$fields'" );
	}
	
	function save ($config)
	{
	  return array ('fields' => preg_replace ('/[^A-Za-z0-9\-_,]/', '', $config['fields']));
  }
	
	function is_editable ()
	{
		return true;
	}
}

$this->register ('Pre_Exclude_Fields');
?>