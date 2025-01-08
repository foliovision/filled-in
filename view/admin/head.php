<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<script type="text/javascript">
  wp_base = '<?php echo $this->url () ?>/controller/admin_ajax.php';
	wp_confirm_ext = '<?php esc_attr_e ('Are you sure you want to delete that extension?', 'filled-in') ?>';
	wp_confirm_form = '<?php esc_attr_e ('Are you sure you?', 'filled-in') ?>';
	wp_confirm_data = '<?php esc_attr_e ('Are you sure you want to delete these entries?', 'filled-in') ?>';
	wp_confirm_file = '<?php esc_attr_e ('Are you sure you want to delete that file?', 'filled-in') ?>';
</script>