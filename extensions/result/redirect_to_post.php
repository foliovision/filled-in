<?php

class Result_Redirect_Post extends FI_Results
{
	function process (&$source)
	{
		global $filled_in;
		if ($filled_in->is_ajax)
		{
			ob_start ();
			?>
			<script type="text/javascript">
				document.location.href = '<?php echo esc_attr( get_permalink ($this->config["post"]) ) ?>';
			</script>
			<?php
			$output = ob_get_contents ();
			ob_end_clean ();
			return $output;
		}
		else
		{
			@wp_redirect (get_permalink ($this->config['post']));
			exit;
		}
	}

	function name ()
	{
		return __ ("Redirect to post", 'filled-in');
	}
	
	function edit ()
	{
		?>
	<tr>
		<td><?php esc_html_e('Post ID', 'filled-in'); ?>:</td>
		<td>
			<input type="text" name="post" value="<?php echo esc_attr( $this->config['post'] ); ?>" id="post_id"/>
		</td>
	</tr>		
<?php
	}
	
	function show ()
	{
		parent::show ();
		if (intval ($this->config['post']) != 0)
		{
			$post = get_post ($this->config['post']);
			if ($post->ID == $this->config['post'])
				echo esc_html( $post->ID . " ( " . $post->post_title . ")" );
			else
				echo esc_html( $this->config['post'] );
		}
		else
			echo '<em>' . esc_html( __ ('&lt;not configured&gt;', 'filled-in') ) . '</em>';
	}
	
	function save ($arr)
	{
		return array ('post' => intval ($arr['post']));
  }

	function is_editable () { return true;}
}


$this->register ('Result_Redirect_Post');
?>