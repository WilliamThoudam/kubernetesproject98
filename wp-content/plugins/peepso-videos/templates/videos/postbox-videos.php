<div class="ps-postbox__media ps-postbox__media--video ps-postbox-videos">
	<div class="ps-postbox__media-inner ps-postbox-input ps-inputbox">

		<!-- Media embed -->
		<div class="ps-postbox__media-embed ps-js-video-embed">
			<input class="ps-input ps-input--sm ps-videos-url input ps-js-url"
				placeholder="<?php echo __('Enter video URL here', 'vidso'); ?>" />
			<div class="ps-loading ps-postbox-loading ps-js-loading">
				<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
			</div>
		</div>

		<?php if (PeepSo::get_option('videos_upload_enable', 0) === 1) { ?>
		<!-- Separator -->
		<div class="ps-postbox__media-separator ps-js-video-separator">
			<span>
				<?php echo __('or', 'vidso'); ?>
			</span>
		</div>

		<!-- Media upload -->
		<div class="ps-postbox__media-upload ps-js-video-upload">

			<!-- Media upload button -->
			<div class="ps-postbox__media-action ps-js-btn">
				<i class="gcis gci-upload"></i>
				<strong><?php echo __('Upload', 'vidso'); ?></strong>

				<?php if ( isset($video_size) ) { ?>
					<span><?php echo sprintf( __('Max file size: %1$sMB', 'vidso'), $video_size['max_size'] ); ?></span>
				<?php } ?>
			</div>

			<div class="ps-postbox__media-file">
				<input type="file" name="filedata[]" class="ps-js-file"
					accept=".avi,.flv,.mkv,.mov,.mp4,.mpeg,.mpg,.swf,.webm,.wmv" style="display:none" />
			</div>

			<!-- Media upload form -->
			<div class="ps-postbox__media-form ps-js-form">
				<div class="ps-postbox__media-message ps-postbox__media-message--done ps-js-done">
					<i class="gcis gci-check-circle"></i> <?php echo __( 'File uploaded', 'vidso' ); ?>
				</div>
				<div class="ps-postbox__media-message ps-postbox__media-message--fail ps-js-failed">
					<i class="gcis gci-exclamation-circle"></i> <?php echo __( 'Upload failed: ', 'vidso' ); ?>
					<div class="ps-postbox__media-message-data ps-js-failed-message"></div>
				</div>
				<div class="ps-postbox__media-progress-wrapper ps-js-progress">
					<div class="ps-postbox__media-progress">
						<div class="ps-postbox__media-progress-bar"><span class="ps-js-percent-bar"></span></div>
					</div>
					<div class="ps-postbox__media-progress-percent ps-js-percent"></div>
				</div>
				<div class="ps-postbox__media-details">
					<div class="ps-postbox__media-details-field">
						<input class="ps-input ps-input--sm ps-js-title"
							placeholder="<?php echo __('Enter the title...', 'vidso'); ?>" />
					</div>
				</div>
			</div>

			<!-- Media upload success notice -->
			<div class="ps-postbox__media-alert ps-alert ps-alert--success ps-js-success">
				<i class="gcis gci-check-circle"></i>
				<?php

					$notice = __( "Your video was uploaded successfully!\nIt's been added to the queue, we will notify you when your video is published.", 'vidso' );
					echo nl2br( $notice );

				?>
			</div>

		</div>

		<?php } ?>

		<!-- Media preview -->
		<div class="ps-postbox__media-preview ps-js-video-preview"></div>
	</div>
</div>
