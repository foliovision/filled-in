<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<div id="form_status_<?php echo intval( $formid ) ?>" style="display: none">
<?php if ($waiting == '') : ?>
	<img src="<?php echo esc_attr( $this->url () ) ?>/images/loading.gif" alt="loading" width="32" height="32"/>
	<?php esc_html_e('Please wait...', 'filled-in'); ?>
<?php else : ?>
	<?php echo wp_kses_post( $waiting ); ?>
<?php endif; ?>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) { 
	jQuery('#<?php echo esc_attr( $name ) ?>').submit (function (item)
		{
			form_submit(this,'<?php echo esc_attr( $base ) ?>',<?php echo ($top == '' ? 'false' : 'true') ?>);
			return false;
		});
});
</script>
