<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><div class="filled_in_upload">
	
<?php if (count ($uploads) == 1) :?>
	<p><?php esc_html_e('Your file has been saved and is awaiting completion of this form','filled-in') ?></p>
<?php else : ?>
	<p><?php esc_html_e('Your files have been saved and are awaiting completion of this form','filled-in') ?></p>
<?php endif; ?>

	<ul>
<?php foreach ($uploads AS $upload): ?>
		<li><?php echo esc_html ($upload->name) ?></li>
<?php endforeach; ?>
	</ul>
</div>
