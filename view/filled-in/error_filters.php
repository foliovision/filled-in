<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="form_notice">
	<p style="float: left; width: 40px">
		<img align="left" src="<?php echo esc_attr( site_url() ) ?>/wp-content/plugins/filled-in/images/error.png" alt="error" width="32" height="32"/>
	</p>
	<p>
		<?php echo esc_html( sprintf (__ ('Your form contains %s.  Please correct the highlighted fields and send again', 'filled-in'), $error_message) ) ?>
	</p>
<?php if ($errors->have_errors ()) : ?>
	<ul class="err_lst">
		<?php foreach ($errors->message AS $field => $error) : ?>
			<?php foreach ($error AS $err) :?>
			<li><?php echo esc_html (ucfirst ($err)); ?></li>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>
