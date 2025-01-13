<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<select name="type" id="add_type_<?php echo esc_attr( $group ) ?>">
<?php foreach ($extensions AS $type => $name) : ?>
  <option value="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $name ) ?></option>
<?php endforeach; ?>
</select>