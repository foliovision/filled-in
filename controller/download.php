<?php

include ('../../../../wp-config.php');

if (!current_user_can ('activate_plugins'))
	die ('<p style="color: red">You are not allowed access to this resource</p>');

$id   = intval ($_GET['id']);
$name = $_GET['name'];
$pos  = intval ($_GET['pos']);

$data = FI_Data::load ($id);
if (isset ($data->sources['files']->data[$name][$pos]))
{
	$file = $data->sources['files']->data[$name][$pos];

	if (file_exists ($file->stored_location))
	{
		header ('Content-Type: application/octet-stream');
		header ("Content-Disposition: attachment; filename=\"".$file->name."\";");
		header ('Content-Length: ' . $file->size);
	
		@readfile ($file->stored_location);
		exit ();
	}
}

echo "<p>";
esc_html_e('That file does not exist.', 'filled-in');
echo "</p>";
