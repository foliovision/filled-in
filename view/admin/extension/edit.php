<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<form method="post" action="" onsubmit="update_extension (<?php echo intval( $extension->id ) ?>,'<?php echo esc_attr( $extension->what_group () ) ?>',this); return false">
	<strong><?php echo esc_html( $extension->name () ) ?></strong>
	<table class="edit_filter" width="100%">
		
		<?php $extension->edit (); ?>
		
  	<tr>
			<th></th>
			<td>
				<?php wp_nonce_field( 'filled_in_nonce', '_ajax_nonce' ); ?>
				<input class="button-primary" type="submit" name="save" value="Save"/>
				<input class="button-secondary" type="button" name="cancel" value="Cancel" onclick="show_extension (<?php echo intval( $extension->id ) ?>,'<?php echo esc_attr( $extension->what_group () ) ?>', '<?php echo esc_attr( wp_create_nonce( 'filled_in_nonce_cancel' ) ); ?>'); return false"/>
			</td>
		</tr>
	</table>
</form>
