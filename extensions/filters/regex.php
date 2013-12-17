<?php

class Filter_regex extends FI_Filter {
	function filter(&$value, $all_data) {
		if ($this->config['regex'] != '') {
			if (empty($value))
				return false;
			if (preg_match($this->config['regex'], $value)) {
				return true;
			}
			return __('Your field does not meet field requirements', 'filled-in');
		}
		return true;
	}

	function name() {
		return __ ("Regex", 'filled-in');
	}

	function save ($config)
	{
		return array ('regex' => htmlentities($config['regex']));
	}

	function edit ()
	{
		parent::edit ();
	?>
	<tr>
		<th><?php _e ('Regex to meet', 'filled-in'); ?>:</th>
		<td><input type="text" name="regex" value="<?php echo isset($this->config['regex']) ? $this->config['regex'] : '' ?>"/> <span class="sub"><?php _e ('items required, leave empty for no regex', 'filled-in'); ?></span></td>
	</tr>
	<?php
	}

	function show() {
		parent::show ();
		_e ('is <strong>Regex</strong>', 'filled-in');
		if (isset($this->config['regex']) && !empty($this->config['regex']))
			printf (__ (' to match %s'), $this->config['regex']);
	}
}

$this->register ('Filter_regex');

?>