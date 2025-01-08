<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="pager">
	<form method="get" action="<?php echo esc_attr( $pager->url ); ?>">
		<input type="hidden" name="page" value="filled_in.php"/>
		<input type="hidden" name="curpage" value="<?php echo $pager->current_page () ?>"/>
		<?php if (isset ($_GET['total'])) : ?>
		<input type="hidden" name="total" value="<?php echo esc_attr( $_GET['total'] ) ?>"/>
		<?php else : ?>
		<input type="hidden" name="errors" value="<?php echo esc_attr( $_GET['errors'] ) ?>"/>
		<?php endif; ?>


		<?php esc_html_e('Search', 'filled-in'); ?>: 
		<input type="text" name="search" value="<?php echo htmlspecialchars ($_GET['search']) ?>"/>
		
		<?php esc_html_e('Results per page', 'filled-in') ?>: 
		<select name="perpage">
			<?php foreach ($pager->steps AS $step) : ?>
		  	<option value="<?php echo esc_attr( $step ); ?>"<?php if ($pager->per_page == $step) echo ' selected="selected"' ?>><?php echo $step ?></option>
			<?php endforeach; ?>
		</select>
		
		<input type="submit" name="go" value="<?php esc_attr_e('go', 'filled-in') ?>"/>
	</form>
</div>
