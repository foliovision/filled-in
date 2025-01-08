<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
	
<?php if (count ($reports) > 0 && count ($forms) > 0) : ?>
<div class="wrap">
	<?php $this->render_admin ('annoy'); ?>
	<?php screen_icon(); ?>
	
	<h2><?php esc_html_e('Batch Processing', 'filled-in'); ?></h2>
	<?php $this->submenu (true); ?>

	<p style="clear: both"><?php esc_html_e('While your original form data will remain untouched, please be aware that replaying data could cause unwanted side effects', 'filled-in'); ?></p>
	
	<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>" method="post" accept-charset="utf-8">
	<table width="100%" class="filled_in">
		<tr>
			<th><?php esc_html_e('Run form', 'filled-in'); ?>:</th>
			<td>
<?php if (count ($forms) > 0) : ?>
				<select name="form">
					<?php foreach ($forms AS $form) : ?>
					<option value="<?php echo esc_attr( $form->id ); ?>"><?php echo htmlspecialchars ($form->name) ?></option>
					<?php endforeach; ?>
				</select>
<?php endif; ?>
				
<?php if (count ($reports) > 0) : ?>
				<?php esc_html_e('through', 'filled-in'); ?>: 
				<select name="report">
				<?php foreach ($reports AS $report) : ?>
				<option value="<?php echo esc_attr( $report->id ); ?>"><?php echo htmlspecialchars ($report->name) ?></option>
				<?php endforeach; ?>
				</select>
<?php endif; ?>
			</td>
		</tr>
		
		<tr>
			<th valign="top"><?php esc_html_e('Start date', 'filled-in'); ?>:<br/>
				<span class="sub"><?php esc_html_e('Start date for data', 'filled-in'); ?></span>
			</th>
			<td>
				<select name="start_type" onchange="if (this.options[this.selectedIndex].value == 'custom') Element.show ('start_time'); else Element.hide ('start_time');">
					<option value="first"><?php esc_html_e('First entry', 'filled-in'); ?></option>
					<option value="custom"><?php esc_html_e('Custom date', 'filled-in'); ?></option>
				</select>
				
				<div id="start_time" style="display: none">
					<?php $this->render_admin ('date_and_time', array ('name' => 'start', 'current_month' => substr ($start_date, 5, 2), 'current_year' => substr ($start_date, 0, 4), 'current_day' => substr ($start_date, 8, 2), 'hour' => '00', 'minute' => '00', 'months' => $months)); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th valign="top"><?php esc_html_e('End date', 'filled-in'); ?>:<br/>
				<span class="sub"><?php esc_html_e('End date for data', 'filled-in'); ?></span>
				</th>
			<td>
				<select name="end_type" onchange="if (this.options[this.selectedIndex].value == 'custom') Element.show ('end_time'); else Element.hide ('end_time');">
					<option value="first"><?php esc_html_e('Last entry', 'filled-in'); ?></option>
					<option value="custom"><?php esc_html_e('Custom date', 'filled-in'); ?></option>
				</select>
				
				<div id="end_time" style="display: none">
					<?php $this->render_admin ('date_and_time', array ('name' => 'end', 'current_month' => substr ($end_date, 5, 2), 'current_year' => substr ($end_date, 0, 4), 'current_day' => substr ($end_date, 8, 2), 'hour' => 23, 'minute' => 59, 'months' => $months)); ?>
				</div>
			</td>
		</tr>
		
		<tr>
			<th></th>
			<td>
				<input class="button-secondary" type="submit" name="run" value="<?php esc_attr_e('Run', 'filled-in'); ?>" id="run"/>
			</td>
		</tr>
		
	</table>
	</form>

</div>
<?php endif; ?>

<div class="wrap">
	<?php if (count ($reports) == 0 || count ($forms) == 0 ) : ?>
	<?php $this->render_admin ('annoy'); ?>
	<?php screen_icon(); ?>
	<?php endif;?>
	
	<h2><?php esc_html_e('Batches', 'filled-in'); ?></h2>
	<?php if (count ($reports) == 0 || count ($forms) == 0 ) : ?>
	<?php $this->submenu (true); ?>
	<?php endif;?>
	
	<?php if (count ($reports) > 0) : ?>
	<ul class="emails" style="clear: both">
		<?php foreach ($reports AS $report) : ?>
		<li id="form_<?php echo $report->id ?>">
			<?php $this->render_admin ('report/item', array ('base' => $base, 'report' => $report)); ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else : ?>
	<p style="clear: both"><?php esc_html_e('You have no reports', 'filled-in'); ?></p>
	<?php endif; ?>
	
	<h3><?php esc_html_e('Create new batch', 'filled-in') ?></h3>
	
	<form method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>" class="form-table">
		<?php esc_html_e('Name', 'filled-in') ?>: <input type="text" name="form_name"/>
		<input class="button-primary" type="submit" name="create" value="<?php esc_attr_e('Create', 'filled-in'); ?>"/>
	</form>
</div>

