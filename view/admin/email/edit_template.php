<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<td colspan="<?php echo (current_user_can ('administrator'))?'4':'3'; ?>">
<form id="template_form_<?php echo esc_attr( $template->name ) ?>" method="post" action="<?php echo esc_attr( $this->url () ) ?>/controller/admin_ajax.php?cmd=update_template&amp;id=<?php echo esc_attr( $template->name ) ?>&amp;ajax_nonce=<?php echo esc_attr( wp_create_nonce ('filledin-save_template') );?>">
		<h3><?php echo esc_html( sprintf (__ (((current_user_can ('administrator'))?'Editing':'Viewing')." template '%s'", 'filled-in'), $template->name) ); ?></h3>
		<p><?php esc_html_e('You can insert form data into the template by entering it as $fieldname$ in any of \'from\', \'subject\', \'to\', and the content.  Cookies can be inserted with %cookie%.', 'filled-in'); ?></p>

	  <table width="100%" class="form-table">
	    <tr>
	      <th><?php esc_html_e('From', 'filled-in'); ?>:</th>
	      <td><input <?php echo (!current_user_can ('administrator'))?'readonly':''; ?> class="regular-text" type="text" name="from" value="<?php echo esc_attr (stripslashes ($template->from)) ?>" size="40"/> (<?php esc_html_e('Leave blank for admin email address', 'filled-in') ?>)</td>
	    </tr>
	    <tr>
	      <th><?php esc_html_e('Subject', 'filled-in'); ?>:</th>
	      <td><input <?php echo (!current_user_can ('administrator'))?'readonly':''; ?> class="regular-text" type="text" name="subject" value="<?php echo esc_attr (stripslashes ($template->subject)) ?>" size="40"/></td>
	    </tr>

	    <tr>
	      <th valign="top"><?php esc_html_e('HTML content', 'filled-in'); ?>:<br/><small><a href="#" onclick="jQuery('#text_<?php echo esc_attr( $template->name ) ?>').toggle (); return false">plain text</a></small></th>
	      <td>
					<textarea <?php echo (!current_user_can ('administrator'))?'readonly':''; ?> class="large-text" name="html" rows="10"><?php echo esc_textarea( stripslashes ($template->html)) ?></textarea>
				</td>
	    </tr>

	    <tr <?php if (strlen ($template->text) == 0) echo 'style="display: none"'; ?> id="text_<?php echo esc_attr( $template->name ) ?>">
	      <th valign="top"><?php esc_html_e('Text content', 'filled-in'); ?>:</th>
	      <td><textarea <?php echo (!current_user_can ('administrator'))?'readonly':''; ?> class="large-text" name="text" rows="10"><?php echo esc_textarea( stripslashes ($template->text)) ?></textarea></td>
	    </tr>

			<tr>
				<th valign="top"><?php esc_html_e('Attachments', 'filled-in'); ?>:</th>
				<td>
					<div class="files" id="files_<?php echo esc_attr( $template->name ) ?>">
						<?php $attachments->show (); ?>
					</div>
                                    <?php if (current_user_can ('administrator')): ?>
					<iframe src="<?php echo esc_attr( $this->url () ) ?>/controller/attachment.php?id=<?php echo esc_attr( $template->name ) ?>" width="100%" frameborder="0" height="80">How did you get this far?</iframe>
                                    <?php endif; ?>
				</td>
			</tr>
		</table>
<?php if (current_user_can ('administrator')): ?>
 	<input class="button-primary" type="submit" name="edit" value="<?php esc_attr_e('Update', 'filled-in') ?>"/> 
  <input class="button-secondary" type="submit" name="cancel" value="<?php esc_attr_e('Cancel', 'filled-in') ?>" onclick="cancel_template ('<?php echo esc_attr( $template->name ) ?>')"/>
<?php endif; ?>
</form>

<script type="text/javascript" charset="utf-8">
	 jQuery('#template_form_<?php echo esc_attr( $template->name ) ?>').ajaxForm ( { beforeSubmit: function ()
			{
 				jQuery('#loading').show ();
			},
			success: function (response)
			{
				jQuery('#loading').hide ();
				jQuery('#temp_<?php echo esc_attr( $template->name ) ?>').html (response);
				setupTemplates ();
			}});
</script>
</td>