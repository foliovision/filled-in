<?php

class Prepare_for_mailto extends FI_Pre
{
	function process (&$data)
	{
		$source =& $data->get_source ('post');
		$source->data[$this->config['newfield']] = rawurlencode( $_POST[$this->config['field']] );
		return true;
	}

	function name ()
	{
		return __ ("Prepare for mailto link", 'filled-in');
	}
	
	function edit ()
	{
		?>
    <tr>
      <td width="130"><?php esc_html_e('Field name', 'filled-in') ?>:</td>
      <td><input style="width: 95%" type="text" name="field" value="<?php echo esc_attr ($this->config['field']) ?>"/></td>
    </tr>
		<tr>
			<td width="130"><?php esc_html_e('Prepared Field name', 'filled-in') ?>:</td>
      <td><input style="width: 95%" type="text" name="newfield" value="<?php echo esc_attr ($this->config['newfield']) ?>"/></td>
		</tr>
	  <?php
	}
	
	function show ()
	{
		parent::show ();
		
		$field     = $this->config['field'];
		$newfield = $this->config['newfield'];
		if ($field == '')
			$field = '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>';
		if ($newfield == '')
			$newfield = '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>';
		
		printf (__ (" from field '<strong>%s</strong>' into '<strong>%s</strong>'", 'filled-in'), $field, $newfield);
	}
	
	function save ($config)
	{
	  return array ('field' => $config['field'], 'newfield' => $config['newfield']);
  }

	function is_editable () { return true;}
}

$this->register ('Prepare_for_mailto');
?>