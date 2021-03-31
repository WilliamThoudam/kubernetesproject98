<div class="ps-postbox__photos-list-wrapper">
	<input type="file" name="filedata[]" accept=".gif,.jpg,.jpeg,.png,.tif,.tiff,.jfif" multiple style="display:none" />
	<?php wp_nonce_field('remove-temp-files', '_wpnonce_remove_temp_files'); ?>
	<div class="ps-postbox__photos-list ps-js-photos">
		<div class="ps-postbox__photos-item ps-postbox__photos-item--add ps-js-upload">
			<i class="gcir gci-plus-square"></i>
		</div>
	</div>
</div>