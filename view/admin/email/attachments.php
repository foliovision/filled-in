<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><ul>
	<?php foreach ($files AS $upload) :?>
	<li>
		<?php if (current_user_can ('administrator')) : ?><a style="float: right" class="nol" href="#" onclick="delete_file('<?php echo esc_attr( $name ) ?>','<?php echo esc_attr( urlencode ($upload->name) ) ?>'); return false"><img title="delete" src="<?php echo esc_attr( site_url() ) ?>/wp-content/plugins/filled-in/images/delete.png" alt="delete" width="16" height="16"/></a><?php endif; ?>
		<a title="<?php esc_attr_e('Download file', 'filled-in'); ?>" href="<?php echo esc_attr( site_url() ) ?>/wp-content/plugins/filled-in/controller/attachment.php?id=<?php echo esc_attr( $name ) ?>&amp;file=<?php echo esc_attr( urlencode ($upload->name) ) ?>"><?php echo esc_html( $upload->name ) ?></a>
	</li>
	<?php endforeach; ?>
</ul>