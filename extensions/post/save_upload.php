<?php

class Post_Save_Upload extends FI_Post
{
	function process (&$source)
	{
		// Move the uploaded file into the directory
		$uploads =& $source->get_source ('files');
		
		if (isset ($uploads->data[$this->config['field']]))
		{
			$upload  =& $uploads->data[$this->config['field']];
			$dest    = rtrim ($this->config['directory'], '/');
			$convert = ($this->config['downcase'] == 'true') ? true : false;

			foreach ($upload AS $pos => $file)
			{
				if ($convert == true)
					$file->name_to_lower ();
				
				if ($file->move_to_unique ($dest.'/'.$file->name))
					$uploads->data[$this->config['field']][$pos] = $file;
				else
					return __ ('Failed to move upload', 'filled-in');
			}
		}

		return true;
	}

	function name ()
	{
		return __ ("Save Uploaded File", 'filled-in');
	}
	
	function edit ()
	{
		?>
    <tr>
      <td width="130"><?php esc_html_e('Field name', 'filled-in') ?>:</td>
      <td><input style="width: 95%" type="text" name="field" value="<?php echo esc_attr ($this->config['field']) ?>"/></td>
    </tr>
		<tr>
			<td width="130"><?php esc_html_e('Directory', 'filled-in') ?>:</td>
      <td><input style="width: 95%" type="text" name="directory" value="<?php echo esc_attr ($this->config['directory']) ?>"/></td>
		</tr>
		<tr>
			<td width="130"><?php esc_html_e('Force lowercase', 'filled-in') ?>:</td>
      <td><input type="checkbox" name="downcase" <?php if ($this->config['downcase'] == 'true') echo ' checked="checked"'; ?>/></td>
		</tr>
	  <?php
	}
	
	function show ()
	{
		parent::show ();
		
		$field     = $this->config['field'];
		$directory = $this->config['directory'];
		if ($field == '')
			$field = '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>';
		if ($directory == '')
			$directory = '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>';
		
		echo wp_kses( sprintf (__ (" from field '<strong>%s</strong>' into '<strong>%s</strong>'", 'filled-in'), $field, $directory), array( 'strong' => array() ) );
	}
	
	function save ($config)
	{
	  return array ('field' => $config['field'], 'directory' => $config['directory'], 'downcase' => isset ($config['downcase']) ? 'true' : 'false');
  }

	function is_editable () { return true;}
}

$this->register ('Post_Save_Upload');
?>