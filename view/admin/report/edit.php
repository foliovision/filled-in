<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<div class="wrap">
	<h2><?php esc_html_e('Edit Batch', 'filled-in'); ?>: <?php echo esc_html ($report->name)?></h2>
	<?php $this->submenu (true); ?>
	
	<form method="post" action="<?php echo esc_attr( str_replace ('&', '&amp;', $_SERVER['REQUEST_URI']) ) ?>" style="clear:both" class="form-table">
		<input class="regular-text" size="20" type="text" name="new_name" value="<?php echo esc_attr( $report->name ); ?>"/>
		<input class="button-primary" type="submit" name="update" value="<?php esc_attr_e('Update Report Name', 'filled-in') ?>"/>
	</form>
	
	<h3><?php esc_html_e('Processing steps', 'filled-in') ?></h3>
	<?php $this->render_admin ('extension/current', array ('form' => $report, 'group' => 'post')) ?>
</div>