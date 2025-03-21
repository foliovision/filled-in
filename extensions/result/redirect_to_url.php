<?php

class Result_Redirect_URL extends FI_Results
{
	function process (&$source)
	{
		global $filled_in;
		if ($filled_in->is_ajax)
		{
			ob_start ();
			?>
			<script type="text/javascript">
				document.location.href = '<?php echo esc_attr( $this->config["url"] ) ?>';
			</script>
			<?php
			$output = ob_get_contents ();
			ob_end_clean ();
			return $output;
		}
		else
		{
			wp_redirect ($this->config['url']);
			exit;
		}
	}

	function name ()
	{
		return __ ("Redirect to URL", 'filled-in');
	}
	
	function edit ()
	{
		?>
	<tr>
		<td width="50"><?php esc_html_e('URL', 'filled-in'); ?>:</td>
		<td>
			<input style="width: 95%" type="text" name="url" value="<?php echo esc_attr( $this->config['url'] ); ?>" id="post_id"/>
		</td>
	</tr>		
<?php
	}
	
	function show ()
	{
		parent::show ();
		if (isset ($this->config['url']) != 0)
			echo esc_html( $this->config['url'] );
		else
			echo '<em>' . esc_html( __ ('&lt;not configured&gt;', 'filled-in') ) . '</em>';
	}
	
	function save ($arr)
	{
		return array ('url' => $arr['url']);
  }

	function is_editable () { return true;}
}


$this->register ('Result_Redirect_URL');
?>