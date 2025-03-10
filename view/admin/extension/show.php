<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="options">
<?php if ($extension->status == 'off') : ?>
	<a href="#" title="<?php esc_attr_e('Enable', 'filled-in') ?>" class="nol" onclick="return enable_extension(<?php echo intval( $extension->id ) ?>,'<?php echo esc_attr( $extension->what_group () ) ?>','<?php echo esc_attr( wp_create_nonce ('filledin-extension_enable_'.$extension->id) ); ?>');">
		<img src="<?php echo esc_attr( $this->url () ) ?>/images/enable.png" alt="edit" width="16" height="16"/>
	</a>
<?php else : ?>
	<a href="#" title="<?php esc_attr_e('Disable', 'filled-in') ?>" class="nol" onclick="return disable_extension(<?php echo intval( $extension->id ) ?>,'<?php echo esc_attr( $extension->what_group () ) ?>','<?php echo esc_attr( wp_create_nonce ('filledin-extension_disable_'.$extension->id) ); ?>');">
		<img src="<?php echo esc_attr( $this->url () ) ?>/images/disable.png" alt="edit" width="16" height="16"/>
	</a>
<?php endif; ?>
<a href="#" class="nol" onclick="return delete_extension(<?php echo intval( $extension->id ) ?>,'<?php echo esc_attr( $extension->what_group () ) ?>','<?php echo esc_attr( wp_create_nonce ('filledin-extension_delete_'.$extension->id) ); ?>');"><img src="<?php echo esc_attr( $this->url () ) ?>/images/delete.png" alt="edit" width="16" height="16"/></a>
</div>

<?php if ($extension->status == 'on' && $extension->is_editable ()) : ?>
<a href="#" onclick="return edit_extension(<?php echo intval( $extension->id ) ?>,'<?php echo esc_attr( $extension->what_group () ); ?>', '<?php echo esc_attr( wp_create_nonce( 'filled_in_nonce_edit' ) ); ?>' )">
<?php endif; ?>

	<?php $extension->show () ?>
	
<?php if ($extension->status == 'on') : ?>
</a>
<?php endif; ?>
