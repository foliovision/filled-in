<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="email_content">
	<div class="options">
		<a title="<?php esc_attr_e('delete', 'filled-in') ?>" class="nol" href="#" onclick="delete_form (<?php echo intval( $report->id ) ?>); return false">
			<img src="<?php echo esc_attr( $this->url () ); ?>/images/delete.png" alt="report" width="16" height="16"/>
		</a>
	</div>
	<a href="<?php echo esc_attr( $base ) ?>&amp;sub=reports&amp;edit=<?php echo intval( $report->id ) ?>"><?php echo esc_html ($report->name) ?></a>
</div>