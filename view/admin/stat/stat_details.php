<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
    <?php if (current_user_can ('administrator')) : ?><td class="nol"/><?php endif; ?>
<td colspan="<?php echo intval( $columns + 1 ) ?>" class="detail nol">

<table class="widefat post fixed" style="width: 95%">
 	<tr>
		<th class="core"><?php esc_html_e('Collected', 'filled-in') ?>:</th>
		<td class="core"><?php echo esc_html( sprintf (__ ('%s from <a href="http://urbangiraffe.com/map/?ip=%s&amp;from=filledin">%s</a>', 'filled-in'), date (get_option ('date_format').' '.get_option ('time_format'), $stat->created), $server->remote_host, $server->remote_host) ); ?></td>
	</tr>
	<tr>
		<th class="core" valign="top"><?php esc_html_e('Browser', 'filled-in') ?>:</th>
		<td class="core"><?php echo esc_html( $server->user_agent ) ?></td>
	</tr>
 	<tr>
		<th class="core" valign="top"><?php esc_html_e('Time', 'filled-in') ?>:</th>
		<td class="core"><?php if ($post->time_to_complete > 0) echo intval( $post->time_to_complete ) . 's'; ?></td>
	</tr>
 
 <?php if ($errors && $errors->what_type () == 'pre') : ?>
 	<tr class="error">
		<th><?php esc_html_e('Pre-Processor failure', 'filled-in') ?>:</th>
		<td><?php echo esc_html ($errors->message) ?></td>
	</tr>
 <?php elseif ($errors && $errors->what_type () == 'post') : ?>
 	<tr class="error">
		<th><?php esc_html_e('Post-Processor failure', 'filled-in') ?>:</th>
		<td><?php echo esc_html ($errors->message) ?></td>
	</tr>
 <?php endif; ?>
 
 <?php if (!empty ($post->data)) { foreach ($post->data AS $key => $value) : ?>
   <?php if ($errors && $errors->in_error ($key)) : ?>
 	<tr class="error">
   <th valign="top" class="data"><?php echo esc_html( $key ) ?>:</th>
   <td>
     <strong><?php echo esc_html( $errors->show_error ($key) ) ?></strong>
     (<?php echo ($value == '' ? esc_html( __('&lt;no data&gt;', 'filled-in') ) : esc_html ($value)) ?>)
   </td>
   
   <?php else : ?>
 	<tr>
   <th valign="top" class="data"><?php echo esc_html( $key ) ?>:</th>
   <td>
     <?php echo esc_html ($post->display ($key)) ?>
   </td>
 	</tr>
   
   <?php endif; ?>
 <?php endforeach; } ?>

<?php if (!empty ($files) && !empty ($files->data)) :?>
 <?php foreach ($files->data AS $key => $value) : ?>

 <tr class="files">
   <th valign="top"><?php echo esc_html( $key ) ?>:</th>
   
   <?php if ($errors && $errors->in_error ($key)) : ?>
   
   <td class="error">
     <strong><?php echo esc_html( $errors->show_error ($key) ) ?></strong> - <?php esc_html_e('deleted', 'filled-in'); ?>
   </td>
   
   <?php else : ?>
   
   <td>
		<ul>
		<?php foreach ($files->data[$key] AS $pos => $item) : ?>
			<li>
				<a href="<?php echo esc_attr( site_url() ) ?>/wp-content/plugins/filled-in/controller/download.php?id=<?php echo intval( $stat->id ) ?>&amp;name=<?php echo urlencode ($key) ?>&amp;pos=<?php echo intval( $pos ) ?>" title="download">
				<?php echo esc_html ($item->name) ?>
				</a>
			</li>
		<?php endforeach; ?>
		</ul>
   </td>
   
   <?php endif; ?>
 </tr>
 <?php endforeach; ?>
<?php endif; ?>

<?php if ( ! empty( $cookies->data ) && is_array ($cookies->data)) : ?>
 <?php foreach ($cookies->data AS $key => $value) : ?>
 <tr class="cookie">
   <th valign="top"><?php echo esc_html( $key ) ?>:</th>
   <td>
     <?php echo esc_html (stripslashes ($value)); ?>
   </td>
 </tr>
 <?php endforeach; ?>
<?php endif; ?>
</table>
</td>
