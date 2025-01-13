<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div id="filled_in_wrap_<?php echo intval( $formid ) ?>">
	<form method="post" action="<?php echo esc_attr( $action.$top ); ?>" <?php echo $params ?><?php echo $upload ? ' enctype="multipart/form-data"' : ''; ?>>
		<input type="hidden" name="filled_in_form" value="<?php echo esc_attr( $formid ); ?>"/>
		<input type="hidden" name="filled_in_start" value="<?php echo esc_attr( $time ); ?>"/>

    <?php echo $inside; ?>
  </form>

	<?php echo ( isset($ajax) ? $ajax : '') ?>
</div>