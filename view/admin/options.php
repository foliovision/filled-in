<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<div class="wrap">
	<?php $this->render_admin ('annoy'); ?>
	<?php screen_icon(); ?>
	
  <h2><?php esc_html_e('Options', 'filled-in'); ?></h2>
	<?php $this->submenu (true); ?>
	
  <p style="clear: both"><?php esc_html_e('NOTE: All save directories <strong>must</strong> be writable by the web server', 'filled-in'); ?></p>

  <form method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>">
	<?php wp_nonce_field ('filledin-save_options'); ?>
	
  <table class="filled_in form-table">
    <tr>
  	<th width="180" ><?php esc_html_e('Disable notice on FV Antispam', 'filled-in') ?>:</th>
  	<td>
      <input type="checkbox" name="notice"<?php if (get_option ('filled_in_notice') == 'true' ) echo ' checked="checked"' ?>/>
  	</td>
    </tr>
    
    <tr>
  	<th width="180" ><?php esc_html_e('Default error CSS', 'filled-in') ?>:</th>
  	<td>
      <input type="checkbox" name="css"<?php if (get_option ('filled_in_css') == 'true') echo ' checked="checked"' ?>/>
  	</td>
    </tr>
    
    <tr>
  	<th width="180" ><?php esc_html_e('Delete failed submission', 'filled-in') ?>:<br/><span class="sub"><?php esc_html_e('Run cron once per day. Delete failed submission older than 30 days', 'filled-in'); ?></span></th>
  	<td>
      <input type="checkbox" name="cron_delete_failed"<?php if (get_option ('filled_in_cron_delete_failed') == 'true') echo ' checked="checked"' ?>/>
      <?php
        $failed_cron_last_run = get_option ('filled_in_cron_delete_failed_last_run');
        if ( $failed_cron_last_run != false ){
          echo ' <strong>Last run:</strong> '. date( 'r', $failed_cron_last_run );
        }
      ?>
    </td>
    </tr>

    <tr>
  	<th valign="top" width="180" ><?php esc_html_e('Track cookies', 'filled-in') ?>:<br/><span class="sub"><?php esc_html_e('Store these cookies in collected data<br/>Each cookie on a separate line', 'filled-in'); ?></span></th>
  	<td>
      <textarea name="cookies" style="width: 95%" rows="5"><?php echo esc_textarea( get_option ('filled_in_cookies')) ?></textarea>
  	</td>
    </tr>

    <tr>
	  	<th width="180" ><?php esc_html_e('Attachment directory', 'filled-in') ?>:<br/>
				<span class="sub"><?php esc_html_e('Where email attachments are saved', 'filled-in'); ?></span>
			</th>
	  	<td>
	      <input type="text" class="regular-text" style="width: 95%" name="attachments" value="<?php echo get_option ('filled_in_attachments') ?>"/>
	  	</td>
    </tr>

    <tr>
	  	<th width="180" ><?php esc_html_e('Saved upload directory', 'filled-in') ?>:<br/>
			<span class="sub"><?php esc_html_e('Where uploads are saved before being moved by processors', 'filled-in'); ?></span>
			</th>
	  	<td>
	      <input type="text" class="regular-text" style="width: 95%" name="uploads" value="<?php echo get_option ('filled_in_uploads') ?>"/>
	  	</td>
    </tr>

		<tr>
			<th width="180">
				<?php esc_html_e('SMTP host', 'filled-in'); ?>:<br/><span class="sub"><?php esc_html_e('Leave blank to use default settings', 'filled-in'); ?></span>
			</th>
			<td valign="top">
				<input type="text" class="regular-text" name="smtp_host" value="<?php echo get_option ('filled_in_smtp_host') ?>" />
				<?php esc_html_e('Port', 'filled-in'); ?>: <input type="text" size="5" name="smtp_port" value="<?php echo get_option ('filled_in_smtp_port') ?>" />
				<select name="smtp_ssl">
					<option value="none" <?php if (get_option ('filled_in_smtp_ssl') == 'none') echo ' selected="selected"' ?>><?php esc_html_e('Unencrypted', 'filled-in'); ?></option>
					<option value="ssl" <?php if (get_option ('filled_in_smtp_ssl') == 'ssl') echo ' selected="selected"' ?>>SSL</option>
					<option value="tls" <?php if (get_option ('filled_in_smtp_ssl') == 'tls') echo ' selected="selected"' ?>>TLS</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<th width="180">
				<?php esc_html_e('SMTP username', 'filled-in'); ?>:
				<br/><span class="sub"><?php esc_html_e('Leave blank for default', 'filled-in'); ?></span>
			</th>
			<td>
				<input class="regular-text" type="text" name="smtp_username" value="<?php echo esc_attr (get_option ('filled_in_smtp_username')) ?>" id="smtp_username"/>
				<?php esc_html_e('Password', 'filled-in'); ?>: <input type="password" name="smtp_password" value="<?php echo esc_attr (get_option ('filled_in_smtp_password')) ?>" id="smtp_password"/>
			</td>
		</tr>

    <tr>
      <td></td>
      <td><input class="button-primary" type="submit" name="save" value="<?php esc_attr_e('Update', 'filled-in') ?>"/></td>
    </tr>
    
  </table>
  </form>
</div>

<div class="wrap">
	<h2><?php esc_html_e('Remove Filled In', 'filled-in'); ?></h2>
	<p><?php esc_html_e('This will remove all Filled In configuration and database tables.  Doing this will destroy <strong>all</strong> your Filled In data and does not have an undo - please be sure this is what you want to do!', 'filled-in'); ?></p>
	
	<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>" method="post" accept-charset="utf-8">
		<?php wp_nonce_field ('filledin-remove_plugin'); ?>
		
		<input class="button-primary" type="submit" name="destroy" value="<?php esc_attr_e('Remove Filled In', 'filled-in') ?>" id="destroy" onclick="if (confirm ('Are you sure you want to remove all Filled In data?')) return true; else return false"/>
	</form>
</div>