<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="wrap">
	<h2><?php esc_html_e('Form Edit', 'filled-in') ?></h2>
	<?php $this->submenu (true); ?>
	<form style="clear: both" method="post" action="<?php echo esc_attr( str_replace ('&', '&amp;', $_SERVER['REQUEST_URI'] ) ) ?>">
		<table class="form-table">
		  <tr>
			<th width="120" valign="top"><?php esc_html_e('Name', 'filled-in') ?>:<br/><span class="sub"><?php esc_html_e('Identifies the form', 'filled-in') ?></span></th>
			<td>
				<input class="regular-text" size="40" type="text" name="new_name" value="<?php echo esc_attr( $form->name ) ?>"/>

			</td>
		  </tr>
		  <tr>
			<th width="120" valign="top">
				<?php esc_html_e('Quick view', 'filled-in') ?>:<br/>
				<span class="sub"><?php esc_html_e('Fields/cookies to display in the results list', 'filled-in') ?></span>
			</th>
			<td><input class="regular-text" type="text" name="quickview" size="40" value="<?php echo esc_attr( $form->quickview ) ?>"/> <span class="sub"><?php esc_html_e('separate with comma', 'filled-in') ?></span></td>
		  </tr>
			<tr>
				<th width="120" valign="top"><?php esc_html_e('Special Options','filled-in') ?>:<br/><span class="sub">Enable AJAX or file uploads</span></th>
				<td valign="top">
					<select name="special">
						<option value="none"><?php esc_html_e('None', 'filled-in') ?></option>
						<option value="ajax"<?php if (isset($form->options['ajax']) && $form->options['ajax'] == 'true') echo ' selected="selected"'; ?>>AJAX</option>
						<option value="upload"<?php if (isset($form->options['upload']) && $form->options['upload'] == 'true') echo ' selected="selected"'; ?>>Allow uploads</option>
					</select>
			</tr>

		  <tr>
		    <td width="120" ></td>
		    <td>
					<?php wp_nonce_field( 'filled_in_nonce', 'filled_in_nonce' ); ?>
					<input class="button-primary" type="submit" name="update" value="<?php esc_attr_e('Update', 'filled-in') ?>"/>
				</td>
		  </tr>

		</table>
	</form>
</div>

<div class="wrap">
  <h2><?php esc_html_e('Extensions', 'filled-in') ?></h2>

	<h3><?php esc_html_e('Pre Processors', 'filled-in') ?>: <span class="sub"><?php esc_html_e('what we do before we begin', 'filled-in') ?></span></h3>
	<?php $this->render_admin ('extension/current', array ('form' => $form, 'group' => 'pre'))?>
	
	<h3><?php esc_html_e('Filters', 'filled-in') ?>: <span class="sub"><?php esc_html_e('ensure the data is correct', 'filled-in') ?></span></h3>
	<?php $this->render_admin ('extension/current', array ('form' => $form, 'group' => 'filter'))?>
	
	<h3><?php esc_html_e('Post Processors', 'filled-in') ?>: <span class="sub"><?php esc_html_e('what to do with the data when accepted', 'filled-in') ?></span></h3>
	<?php $this->render_admin ('extension/current', array ('form' => $form, 'group' => 'post')) ?>
	
	<h3><?php esc_html_e('Result Processor', 'filled-in') ?>: <span class="sub"><?php esc_html_e('what to show the user after correct submission', 'filled-in') ?></span></h3>
	<?php $this->render_admin ('extension/current', array ('form' => $form, 'group' => 'result'))?>
</div>

<div class="wrap">
	<h2><?php esc_html_e('Custom Options', 'filled-in') ?></h2>

	<form method="post" action="<?php echo esc_attr( str_replace ('&', '&amp;', $_SERVER['REQUEST_URI']) ) ?>">
	<table class="form-table">
		<tr>
			<th width="180" valign="top"><?php esc_html_e( 'Submit anchor', 'filled-in' ); ?>:<br/><span class="sub"><?php esc_html_e('When a form is submitted the user will be taken to specified anchor. Leave empty to submit to top of page', 'filled-in'); ?></span></th>
			<td valign="top">
				<input type="text" name="submit-anchor" value="<?php echo ! empty( $form->options['submit-anchor'] ) ? esc_attr( $form->options['submit-anchor'] ) : ''; ?>" />
			</td>
		</tr>
    <tr>
      <th width="180" valign="top"><?php esc_html_e('Predecessor\'s form allowed ID', 'filled-in'); ?>:<br/><span class="sub"><?php esc_html_e('Define allowed predecessor\'s form ID which has been submitted before this form has shown', 'filled-in'); ?></span></th>
      <td>
        <input type="text" name="custom_id" value="<?php echo ! empty( $form->options['custom_id'] ) ? esc_attr( $form->options['custom_id'] ) : ''; ?>" />
      </td>
    </tr>
		<tr>
			<th width="180" valign="top"><?php esc_html_e('Custom submit code', 'filled-in'); ?>:<br/><span class="sub"><?php esc_html_e('Override the default AJAX loading notice', 'filled-in'); ?></span></th>
			<td>
				<textarea class="large-text" name="custom_submit" rows="2"><?php echo esc_textarea( wp_unslash( ! empty( $form->options['custom_submit'] ) ? $form->options['custom_submit'] : '' ) ) ?></textarea>
			</td>
		</tr>
		<tr>
			<th valign="top"><span class="sub"><?php esc_html_e('Default submit code', 'filled-in'); ?>:</span></th>
			<td>
				<code style="font-size: 0.9em" class="sub">
				&lt;img src=&quot;<?php echo esc_attr( preg_replace ('@http://(.*?)/(.*)@', '/$2', get_bloginfo ('wpurl')) ) ?>/wp-content/plugins/filled-in/images/loading.gif&quot; alt=&quot;loading&quot; width=&quot;32&quot; height=&quot;32&quot;/&gt;
				<?php esc_html_e('Please wait...', 'filled-in'); ?>
				</code>
			</td>
		</tr>
		
	  <tr>
	    <td width="180"></td>
	    <td>
				<?php wp_nonce_field( 'filled_in_nonce', 'filled_in_nonce' ); ?>
				<input type="submit" class="button-primary" name="update_options" value="<?php esc_attr_e('Update', 'filled-in') ?>"/>
			</td>
	  </tr>
	</table>
	</form>
</div>
