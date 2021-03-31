<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url,'channels') !== false)
{
    $uriArray = explode('&', $url);
    $parent_id = str_replace( '/', '', $uriArray[1]);

    $header_text = 'Create a Channel';
    $name_text = 'Channel Name';
    $name_placeholder = 'Enter your channels name...';
    $desc_text = 'Channel Description';
    $desc_placeholder = 'Enter your channels description...';
    $create = 'Finish';
}
else
{
    $parent_id = '0';

    $header_text = 'Create a Group';
    $name_text = 'Group Name';
    $name_placeholder = 'Enter your group name...';
    $desc_text = 'Group Description';
    $desc_placeholder = 'Enter your group description...';
    $create = 'Create Group';
}
?>

<div class="ps-group__create">
	<div class="ps-form ps-form--vertical ps-form--group-create">
		<div class="ps-form__row">
			<label class="ps-form__label"><?php echo __($name_text, 'groupso'); ?> <span class="ps-text--danger">*</span></label>
			<div class="ps-form__field ps-form__field--limit">
				<div class="ps-input__wrapper">
					<input type="text" name="group_name" class="ps-input ps-input--sm ps-input--count ps-js-name-input" value=""placeholder="<?php echo __($name_placeholder, 'groupso'); ?>" data-maxlength="<?php echo PeepSoGroup::$validation['name']['maxlength'];?>" />
					<div class="ps-form__chars-count"><span class="ps-js-limit ps-tip ps-tip--inline"><?php echo PeepSoGroup::$validation['name']['maxlength'];?></span></div>
				</div>
				<div class="ps-form__field-desc ps-form__required ps-js-error-name" style="display:none"></div>
			</div>
		</div>

		<div class="ps-form__row">
			<label class="ps-form__label"><?php echo __($desc_text, 'groupso'); ?> <span class="ps-text--danger">*</span></label>
			<div class="ps-form__field ps-form__field--limit">
				<div class="ps-input__wrapper">
					<textarea name="group_desc" class="ps-input ps-input--sm ps-input--textarea ps-input--count ps-js-desc-input" placeholder="<?php echo __($desc_placeholder, 'groupso'); ?>" data-maxlength="<?php echo PeepSoGroup::$validation['description']['maxlength'];?>"></textarea>

                    <input type="hidden" name="group_id" value="<?=$parent_id;?>" class="ps-input ps-input--sm ps-input--count ps-js-name-input" value="" />

					<div class="ps-form__chars-count"><span class="ps-js-limit ps-tip ps-tip--inline" aria-label="<?php echo __('Characters left', 'groupso'); ?>"><?php echo PeepSoGroup::$validation['description']['maxlength'];?></span></div>
				</div>
				<div class="ps-form__field-desc ps-form__required ps-js-error-desc" style="display:none"></div>
			</div>
		</div>

		<?php


       // parent_id check for not showing group category selection in channels

		if(PeepSo::get_option('groups_categories_enabled', FALSE) && ($parent_id == 0)) {

			$multiple_enabled = PeepSo::get_option('groups_categories_multiple_enabled', FALSE);
			$input_type = ($multiple_enabled) ?  'checkbox' : 'radio';

			$PeepSoGroupCategories = new PeepSoGroupCategories(FALSE, TRUE);
			$categories = $PeepSoGroupCategories->categories;
			?>
			<div class="ps-form__row">
				<label class="ps-form__label"><?php echo __('Category', 'groupso'); ?> <span class="ps-text--danger">*</span></label>
				<div class="ps-form__field">
					<div class="ps-checkbox__grid">
						<?php
						if(count($categories)) {
							foreach($categories as $id=>$category) {
								echo sprintf('<div class="ps-checkbox"><input type="%s" id="category_'.$id.'" name="category_id" value="%d" class="ps-checkbox__input"><label class="ps-checkbox__label" for="category_'.$id.'">%s</label></div>', $input_type, $id, $category->name);
							}
						}
						?>
					</div>
					<div class="ps-form__field-desc ps-form__required ps-js-error-category_id" style="display:none"></div>
				</div>
			</div>
		<?php } // ENDIF ?>



		<div class="ps-form__row">
			<label class="ps-form__label"><?php echo __('Privacy', 'groupso'); ?></label>
			<div class="ps-form__field">
				<?php
				$privacySettings = PeepSoGroupPrivacy::_();

                // parent_id check to disable open option for channel

                if($parent_id != 0)
                {
                    $privacyDefaultValue = PeepSoGroupPrivacy::PRIVACY_CLOSED;
                }
                else
                {
                    $privacyDefaultValue = PeepSoGroupPrivacy::PRIVACY_OPEN;
                }

                $privacyDefaultSetting = $privacySettings[ $privacyDefaultValue ];
                ?>

				<div class="ps-dropdown ps-dropdown--privacy ps-group__profile-privacy ps-js-dropdown ps-js-dropdown--privacy">
					<button data-value="" class="ps-btn ps-btn--sm ps-dropdown__toggle ps-js-dropdown-toggle">
						<span class="dropdown-value">
							<i class="<?php echo $privacyDefaultSetting['icon']; ?>"></i>
							<span><?php echo $privacyDefaultSetting['name']; ?></span>
						</span>
					</button>
                    <input type="hidden" name="group_privacy" value="<?php echo $privacyDefaultValue; ?>" />
					<?php echo PeepSoGroupPrivacy::render_dropdown(); ?>
				</div>
			</div>
		</div>



	</div>
</div>

<?php

// Additional popup options (optional).
$opts = array(
	'title' => __($header_text, 'groupso'),
	'actions' => array(

		array(
			'label' => __($create, 'groupso'),
			'class' => 'ps-js-submit',
			'loading' => true,
			'primary' => true
		)
	)
);

?>
<script type="text/template" data-name="opts"><?php echo json_encode($opts); ?></script>
