<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="pager"><?php esc_html_e('Results per page', 'filled-in') ?>: 
	<form method="get" action="<?php echo esc_attr( $pager->url ); ?>">
		<input type="hidden" name="page" value="filled_in.php"/>
		<input type="hidden" name="curpage" value="<?php echo $pager->current_page () ?>"/>

		<select name="perpage">
			<?php foreach ($pager->steps AS $step) : ?>
		  	<option value="<?php echo esc_attr( $step ); ?>"<?php if ($pager->per_page == $step) echo ' selected="selected"' ?>><?php echo $step ?></option>
			<?php endforeach; ?>
		</select>
		
		<input type="submit" name="go" value="<?php esc_attr_e('go', 'filled-in') ?>"/>
	</form>
</div>
