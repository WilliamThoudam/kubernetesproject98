<?php
$PeepSoActivityShortcode = PeepSoActivityShortcode::get_instance();
$small_thumbnail = PeepSo::get_option('small_url_preview_thumbnail', 0);
?>


<div class="peepso">
	<div class="ps-page ps-page--groups ps-page--groups-category">
		<?php PeepSoTemplate::exec_template('general', 'navbar'); ?>

		<div class="ps-profile ps-profile--groups-category">
			<?php PeepSoTemplate::exec_template('groups', 'group-category-header', array('group_category'=>$group_category, 'group_category_segment'=>$group_category_segment)); ?>

			<div class="ps-activity">
				<?php

				// Checks if logged-in user has joined any group in this category.
				$PeepSoGroups = new PeepSoGroups();

                // Passing 8 parameters to run the function in category page
				$groups = $PeepSoGroups->get_groups(0, 1, 'post_title', 'ASC', '', get_current_user_id(), $group_category->id,0);
				if (count($groups) > 0) {
					PeepSoTemplate::exec_template('general', 'postbox-legacy');
					PeepSoTemplate::exec_template('activity', 'activity-stream-filters-simple', array());
				} else {
					?>
					<div class="ps-alert ps-alert--warning">
						<i class="gcis gci-user-lock"></i>
						<?php echo __('You must join a group in this category to be able to participate.' ,'groupso') ?>
					</div>
					<?php
				}
				?>

				<!-- stream activity -->
				<input type="hidden" id="peepso_context" value="group-category" />
				<div class="ps-activity__container">
					<div id="ps-activitystream-recent" class="ps-posts <?php echo $small_thumbnail ? '' : 'ps-posts--narrow' ?>" style="display:none"></div>
					<div id="ps-activitystream" class="ps-posts <?php echo $small_thumbnail ? '' : 'ps-posts--narrow' ?>" style="display:none"></div>

					<div id="ps-activitystream-loading" class="ps-posts__loading">
						<?php PeepSoTemplate::exec_template('activity', 'activity-placeholder'); ?>
					</div>

					<div id="ps-no-posts" class="ps-posts__empty"><?php echo __('No posts found.', 'groupso'); ?></div>
					<div id="ps-no-posts-match" class="ps-posts__empty"><?php echo __('No posts found.', 'groupso'); ?></div>
					<div id="ps-no-more-posts" class="ps-posts__empty"><?php echo __('Nothing more to show.', 'groupso'); ?></div>

					<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if(get_current_user_id()) {
	PeepSoTemplate::exec_template('activity' ,'dialogs');
}
