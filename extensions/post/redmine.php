<?php


class PostToRedmine extends FI_Post
{
	function process (&$source)
	{
		global $wpdb;

		$data   = $source->get_source ('post');
		$server = $source->get_source ("server");

		$email    = esc_sql ($data->data[$this->config['email']]);
		$username = esc_sql ($data->data[$this->config['username']]);
		$prefix   = $this->config['prefix'];

		// Split full name into parts
		$parts = explode (' ', $data->data[$this->config['name_full']]);
		$parts = array_filter ($parts);
		
		$first_name = esc_sql ($parts[0]);
		if (count ($parts) > 1)
			$last_name = esc_sql ($parts[count ($parts) - 1]);

		global $filled_in;
		$password = $filled_in->shared['password'];
		$password = esc_sql (sha1 ($password));
		
		// Check that email doesnt already exist
		if ($wpdb->get_var ("SELECT COUNT(*) FROM {$prefix}users WHERE mail='$email'") == 0)
		{
			// Now add to Redmine
			$wpdb->query ("INSERT INTO {$prefix}users (login,hashed_password,firstname,lastname,mail,created_on,updated_on,type) VALUES('$username','$password','$first_name','$last_name','$email',NOW(),NOW(),'User')");
		}
		return true;
	}

	function name ()
	{
		return __ ("Add to Redmine user database", 'filled-in');
	}
	
	function edit ()
	{
		?>
	    <tr>
	      <td width="130"><?php esc_html_e('Redmine DB prefix', 'filled-in') ?>:</td>
	      <td>
					<input type="text" name="prefix" value="<?php echo esc_attr ($this->config['prefix']) ?>"/>
				</td>
	    </tr>
	    <tr>
	      <td width="130"><?php esc_html_e('Username field', 'filled-in') ?>:</td>
	      <td>
					<input type="text" name="username" value="<?php echo esc_attr ($this->config['username']) ?>"/>
					<span class="sub"><?php esc_html_e('Name of the Filled In field you want to use as the newsletter field', 'filled-in'); ?></span>
				</td>
	    </tr>
	    <tr>
	      <td width="130"><?php esc_html_e('Email field', 'filled-in') ?>:</td>
	      <td>
					<input type="text" name="email" value="<?php echo esc_attr ($this->config['email']) ?>"/>
					<span class="sub"><?php esc_html_e('Name of the Filled In field you want to use as the email address', 'filled-in'); ?></span>
				</td>
	    </tr>
			<tr>
				<td width="130"><?php esc_html_e('Field for full name', 'filled-in') ?>:</td>
	      <td><input type="text" name="name_full" value="<?php echo esc_attr ($this->config['name_full']) ?>"/></td>
			</tr>
	  <?php
	}
	
	function show ()
	{
		parent::show ();
		
		$email = $this->config['email'];
		if ($email == '')
			$email = '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>';
?>
 with email taken from '<?php echo esc_html( $email ) ?>' <?php echo esc_html( $fields ) ?>
<?php
	}
	
	function save ($config)
	{
		return array
		(
			'prefix'     => $config['prefix'],
			'email'      => $config['email'],
			'username'   => $config['username'],
			'name_full'  => $config['name_full']
		);
  }

	function is_editable () { return true;}
}

$this->register ('PostToRedmine');

?>