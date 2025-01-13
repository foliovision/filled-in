<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<tr>
	<?php if (current_user_can ('administrator')) : ?><th width="16" class="check-column">
		<input type="checkbox" name="select_all" class="select-all"/>
	</th><?php endif; ?>
  <th class="date"><?php esc_html_e('Date', 'filled-in') ?></th>

  <?php foreach ($columns AS $column) : ?>
  <th><?php echo esc_html( $column ) ?></th>
  <?php endforeach; ?>
</tr>
