<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<div class="wrap">
	<?php $this->render_admin ('annoy'); ?>
	<?php screen_icon(); ?>

	<h2><?php esc_html_e('Form List', 'filled-in') ?></h2>
	<?php $this->submenu (true); ?>

	<?php if ( is_array($forms) && count($forms) > 0) : ?>

      <?php if( $bDisplayPostError ) : ?>

         <div id="post-error" style="clear: both;">
            <h3>Last error on post extension:</h3>
            <table cellspacing="3" class="widefat post fixed">
               <?php foreach( $aPostErrorData as $strKey => $mixData ) : ?>
                  <tr>
                     <td><?php echo esc_html( $strKey ); ?></td>
                     <td>
                        <?php if( is_array( $mixData ) || is_object( $mixData ) ) : ?>
                           <?php echo esc_html( str_replace( "\n", '<br />', print_r( $mixData, true ) ) ); ?>
                        <?php else : ?>
                           <?php echo esc_html( $mixData ); ?>
                        <?php endif; ?>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </table>
            <div>
               <input type="button" name="dismiss" value="Dismiss" id="post-error-dismiss" />
            </div>
         </div>

      <?php endif; ?>

	<form method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>">	
		<input type="hidden" name="page" value="filled_in.php"/>
		<input type="hidden" name="curpage" value="<?php echo esc_attr( $pager->current_page () ) ?>"/>

		<div id="pager" class="tablenav">
                    <?php if (current_user_can ('administrator')) : ?>
			<div class="alignleft actions">
				<select name="action2" id="action2_select">
					<option value="-1" selected="selected"><?php esc_html_e('Bulk Actions', 'filled-in'); ?></option>
					<option value="delete"><?php esc_html_e('Delete', 'filled-in'); ?></option>
				</select>

				<input type="submit" value="<?php esc_attr_e('Apply', 'filled-in'); ?>" name="doaction2" id="doaction2" class="button-secondary action" />

				<?php $pager->per_page ('filled-in'); ?>

				<input type="submit" value="<?php esc_attr_e('Filter', 'filled-in'); ?>" class="button-secondary" />

				<br class="clear" />
			</div>
                    <?php endif; ?>
			<div class="tablenav-pages">
				<?php echo wp_kses( $pager->page_links (), array( 'a' => array( 'class' => array(), 'href' => array() ), 'span' => array( 'class' => array() ) ) ); ?>
			</div>
		</div>
	</form>
        

	<table cellspacing="3" class="widefat post fixed">
	   <thead>
			<tr valign="top">
				<?php if (current_user_can ('administrator')) : ?><th width="16" class="check-column">
					<input type="checkbox" name="select_all" class="select-all"/>
				</th><?php endif; ?>
				<?php
				$wp_kses = array( 'a' => array( 'href' => array() ), 'img' => array( 'src' => array(), 'width' => array(), 'height' => array() ) );
				?>
				<th><?php echo wp_kses( $pager->sortable ('name', __ ('Form name', 'filled-in')), $wp_kses ); ?></th>
				<th class="center"><a href=""><?php echo wp_kses( $pager->sortable ('_success', __ ('Succeeded', 'filled-in')), $wp_kses ); ?></th>
				<th class="center"><a href=""><?php echo wp_kses( $pager->sortable ('_failed', __ ('Failed', 'filled-in')), $wp_kses ); ?></th>
				<th class="center"><a href=""><?php echo wp_kses( $pager->sortable ('_last', __ ('Last Completed', 'filled-in')), $wp_kses ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php 
				$alt = 0;
				foreach ($forms AS $form)
					$this->render_admin ('form/list_entry', array ('form' => $form, 'base' => $base, 'admin' => $admin, 'alt' => ($alt++ % 2) == 1 ? 'alt' : ''));
			?>
		</tbody>
	</table>
	
		<div id="loading" style="display: none">
			<img src="<?php bloginfo ('wpurl') ?>/wp-content/plugins/filled-in/images/loading.gif" alt="loading" width="32" height="32"/>
		</div>

	<?php else : ?>
	  <p><?php esc_html_e('You currently have no forms to display.', 'filled-in') ?></p>
	<?php endif; ?>

	<?php if ($admin) : ?>
		<h3><?php esc_html_e('Create new form', 'filled-in') ?></h3>
	
		<form method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ); ?>" class="form-table">
			<?php wp_nonce_field ('filledin-create_form'); ?>
			
			<?php esc_html_e('Name', 'filled-in') ?>: <input type="text" name="form_name"/>
			<input class="button-primary" type="submit" name="create" value="Create"/>
		</form>
	<?php endif; ?>
</div>


<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function()
	{
		jQuery('.select-all').click (function (item)
		{
			var check = jQuery('.select-all').attr ('checked');
		  jQuery('.item :checkbox').each (function ()
		  {
		    this.checked = check;
		  });
	
			return true;
		});
		
		jQuery('#doaction2').click (function ()
		{
			if (jQuery('#action2_select').attr ('value') == 'delete')
				deleteItems ('delete_forms','<?php echo esc_attr( wp_create_nonce ('filledin-delete_items') ); ?>');
			return false;
		});
	});
</script>