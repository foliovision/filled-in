<?php

class Result_Display_Message extends FI_Results
{
	function process (&$source)
	{
		global $filled_in;
		
		$text = $this->config['message'];
		$text = $this->fill_in_details( $source, $text );
    
    $text = do_shortcode($text);

		if ($this->config['autop'] == 'true')
			$text = wpautop ($text);
			
		if ($this->config['entire'] == 'true')
		{
			global $filled_in;
			$filled_in->replace_entire_post = true;
		}
    
    $post = $source->get_source ('post');
		
    if( isset($post->form->id) ) {
      $text = '<div id="filled_in_result" data-form-id="'.$post->form->id.'">'.$text.'</div>';
    }
    
		return $text;
	}

	function name ()
	{
		return __ ("Display a 'thank-you' message", 'filled-in');
	}
	
	function edit ()
	{
		?>
		<tr>
			<td colspan="2">
    		<textarea style="width: 95%; margin-top: 10px" rows="10" name="message"><?php echo esc_textarea (isset($this->config['message']) ? $this->config['message'] : '') ?></textarea>
			</td>
		</tr>
		<tr>
			<th width="160"><label for="autop"><?php esc_html_e('Auto Formatting', 'filled-in'); ?>:</label></th>
			<td><input type="checkbox" name="autop" id="autop"<?php if (isset($this->config['autop']) && $this->config['autop'] == 'true') echo ' checked="checked"'?>/></td>
		</tr>
		<tr>
			<th width="160"><label for="entire"><?php esc_html_e('Replace entire page', 'filled-in'); ?>:</label></th>
			<td><input type="checkbox" name="entire" id="entire"<?php if (isset($this->config['entire']) && $this->config['entire'] != 'false') echo ' checked="checked"'?>/></td>
		</tr>
	  <?php
	}
	
	function show ()
	{
		parent::show ();
		if (isset($this->config['message']) && $this->config['message'] != '')
			$message = htmlspecialchars (substr (strip_tags ($this->config['message']), 0, 50));
		else
			$message = '<em>' . __ ('&lt;not configured&gt;', 'filled-in') . '</em>';
		
		echo wp_kses( sprintf (__ (" with '%s'", 'filled-in'), $message), array( 'em' => array() ) );
	}
	
	function save ($arr)
	{
		return array ('message' => $arr['message'], 'autop' => isset ($arr['autop']) ? 'true' : 'false', 'entire' => isset ($arr['entire']) ? 'true' : 'false');
  }

   function fill_in_details ($source, $text, $encode = false)
   {
      assert (is_a ($source, 'FI_Data'));

      $server = $source->get_source ('server');
      $post   = $source->get_source ('post');
      $cookie = $source->get_source ('cookies');
      $upload = $source->get_source ('files');

      // Replace server details
      $text = str_replace ('$remote$', $server->remote_host, $text);
      $text = str_replace ('$agent$',  $server->user_agent, $text);

      // Replace fields
      $text = $post->replace ($text, $encode);
      $text = $cookie->replace ($text, $encode);

      return $text;
   }

	function is_editable () { return true;}
}


$this->register ('Result_Display_Message');
