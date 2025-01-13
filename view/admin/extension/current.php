<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<div id="extension_<?php echo esc_html( $group ) ?>">
	
	<?php if (isset($form->extensions[$group]) && count ($form->extensions[$group]) > 0) : ?>
	<ol id="<?php echo esc_attr( $group ) ?>_list">
	<?php foreach ($form->extensions[$group] AS $extension) : ?>
		<li id="ext_<?php echo  esc_html( $extension->id ) ?>"<?php if ($extension->status == 'off') echo 'class="disabled"' ?>>
			<?php $this->render_admin ('extension/show', array ('extension' => $extension)) ?>
		</li>
	<?php endforeach; ?>
	</ol>
	<?php endif; ?>

	<form method="post" action="<?php echo esc_attr( str_replace ('&', '&amp;', $_SERVER['REQUEST_URI'] ) ) ?>" onsubmit="add_extension(<?php echo intval( $form->id ) ?>,'<?php echo esc_html( $group ) ?>', this,'<?php echo esc_html( wp_create_nonce ('filledin-add_extension') ); ?>'); return false">
		<?php esc_html_e('Add new', 'filled-in') ?>
		<?php $factory = FI_Extension_Factory::get (); $this->render_admin ('extension/available', array ('extensions' => $factory->group ($group), 'group' => $group)) ?>
		<input class="button-secondary" type="submit" name="add" value="Add"/>
	</form>

<div id="ext_loading_<?php echo esc_html( $group ) ?>" style="display: none">
  <img src="<?php echo esc_attr( $this->url () ) ?>/images/loading.gif" width="32" height="32" alt="loading"/>
</div>

<?php if (isset($form->extensions[$group]) && count ($form->extensions[$group]) > 1) : ?>
<script type="text/javascript" charset="utf-8">
	jQuery('#<?php echo esc_attr( $group ) ?>_list').sortable ({ cursor: 'move',  update: function() { save_extension_order ('<?php echo esc_attr( $group ) ?>'); }});
</script>
<?php endif; ?>

<?php if (isset($error) && !$error && $error != '') $this->render_error ($error);?>
</div>