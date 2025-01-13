<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<ul <?php echo ! empty( $class ) ? 'class="' . esc_attr( $class ) . '"' : '' ?><?php echo ! empty( $id ) ? 'id="' . esc_attr( $id ) . '"' : '' ?>>
  <li><a <?php if ($sub == '') echo 'class="current"'; ?>href="<?php echo esc_attr( $url ); ?>"><?php esc_html_e('Forms', 'filled-in') ?></a><?php echo esc_html( $trail ); ?></li>
  <li><a <?php if ($sub == 'templates') echo 'class="current"'; ?>href="<?php echo esc_attr( $url ) ?>&amp;sub=templates"><?php esc_html_e('Email Templates', 'filled-in') ?></a></li>
	
	<?php if (current_user_can ('activate_plugins')) : ?>
  <li><?php echo esc_html( $trail ); ?><a <?php if ($sub == 'reports') echo 'class="current"'; ?>href="<?php echo esc_attr( $url ) ?>&amp;sub=reports"><?php esc_html_e('Batch Processing', 'filled-in') ?></a><?php echo esc_html( $trail ); ?></li>
  <li><a <?php if ($sub == 'options') echo 'class="current"'; ?>href="<?php echo esc_attr( $url ) ?>&amp;sub=options"><?php esc_html_e('Options', 'filled-in') ?></a></li>
	<?php endif; ?>
</ul>