<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php if (current_user_can ('administrator')) : ?><td width="16" class="item center">
	<input type="checkbox" class="check" name="checkall[]" value="<?php echo esc_attr( $template->name ); ?>"/>
</td><?php endif; ?>
<td>
	<a href="<?php echo esc_attr( $this->url () ) ?>/controller/admin_ajax.php?cmd=edit_template&amp;id=<?php echo esc_attr( $template->name ) ?>" class="filledin-template-edit"><?php echo esc_attr( $template->name ) ?></a>
</td>
<td><?php echo esc_html ($template->from); ?></td>
<td><?php echo esc_html ($template->to); ?></td>


