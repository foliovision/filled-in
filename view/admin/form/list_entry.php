<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<tr id="form_<?php echo intval( $form['form']->id ) ?>" class="<?php echo esc_attr( $alt ); ?>" align="center">
	<?php if (current_user_can ('administrator')) : ?><td width="16" class="item center">
		<input type="checkbox" class="check" name="checkall[]" value="<?php echo esc_attr( $form['form']->id ); ?>"/>
	</td><?php endif; ?>
	
	<td align="left">
		<?php if ($admin) : ?>
		<a href="<?php echo esc_attr( $base ) ?>&amp;edit=<?php echo intval( $form['form']->id ) ?>">
		<?php endif; ?>
		<?php echo esc_html( $form['form']->name) ?>
		<?php if ($admin) : ?>
		</a>
		<?php endif; ?>
	</td>
	
	<td class="center">
	<?php if ($form['total_results'] > 0) : ?>
	<a href="<?php echo esc_attr( $base ) ?>&amp;total=<?php echo intval( $form['form']->id ) ?>"><?php echo number_format ($form['total_results'], 0) ?></a>
	<?php else : ?>
	&mdash;
	<?php endif; ?>
	</td>

	<?php if ($form['total_errors']) : ?>
	<td class="center"><a href="<?php echo esc_attr( $base ) ?>&amp;errors=<?php echo intval( $form['form']->id ) ?>"><?php echo esc_html( $form['total_errors'] ) ?></a></td>
	<?php else : ?>
	<td>&mdash;</td>
	<?php endif; ?>
	
	<td class="center">
<?php if ($form['last_submitted']) : ?>
		<?php echo esc_html( date 	(get_option ('time_format'), $form['last_submitted']) ) ?>, <?php echo esc_html( date (get_option ('date_format'),  $form['last_submitted']) ) ?>
<?php else : ?>
 &mdash;
<?php endif; ?>
	</td>
</tr>