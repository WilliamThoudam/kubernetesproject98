<div class="ps-posts__filters">
  <div class="ps-posts__filters-group" id="rj-post-filter">
  <?php

  /** STREAM ID **/

  $stream_id = $user_stream_filters['stream_id'];
  if(count($stream_id_list)) {

      $default = PeepSo::get_option('stream_id_default');

      if(!isset($stream_id_list[$stream_id]) && !array_key_exists($stream_id, $stream_id_list)) {
          $stream_id = $default;
      }

      if(!isset($stream_id_list[$stream_id]) && !array_key_exists($stream_id, $stream_id_list)) {
          reset($stream_id_list);
          $stream_id = key($stream_id_list);
      }

      $selected = $stream_id_list[$stream_id];

      ?>
      <input type="hidden" id="peepso_stream_id" value="<?php echo $stream_id; ?>"/>
      <?php if (count($stream_id_list) > 1) { ?>

      <div class="ps-posts__filter ps-posts__filter--type ps-js-dropdown ps-js-activitystream-filter ps-rj-streamfilter" data-id="peepso_stream_id">
        <a href="javascript:" class="ps-posts__filter-toggle ps-js-dropdown-toggle" aria-haspopup="true">
          <i class="<?php echo $selected['icon']; ?>"></i>
          <span><?php echo $selected['label']; ?></span>
        </a>
        <div class="ps-posts__filter-box ps-posts__filter-box--type ps-js-dropdown-menu" role="menu">
          <?php foreach ($stream_id_list as $key => $value) { ?>
          <a class="ps-posts__filter-select" data-option-value="<?php echo $key; ?>" data-option-label-warning="<?php echo $value['label_warning'];?>" role="menuitem">
            <div class="ps-checkbox">
              <input type="radio" name="peepso_stream_id" id="peepso_stream_id_opt_<?php echo $key ?>"
                value="<?php echo $key ?>" <?php if ($key == $stream_id) echo "checked"; ?> />
              <label for="peepso_stream_id_opt_<?php echo $key ?>">
                <span><?php echo $value['label']; ?></span>
                <div class="ps-posts__filter-select-desc"><?php echo $value['desc']; ?></div>
              </label>
              <i class="<?php echo $value['icon']; ?>"></i>
            </div>
          </a>
          <?php } ?>
          <div class="ps-posts__filter-actions">
            <button class="ps-posts__filter-action ps-btn ps-btn--sm ps-js-cancel"><?php echo __('Cancel', 'peepso-core'); ?></button>
            <button class="ps-posts__filter-action ps-btn ps-btn--sm ps-btn--action ps-js-apply" ><?php echo __('Apply', 'peepso-core'); ?></button>
          </div>
        </div>
      </div>

      <?php } ?>
    <?php } ?>

    <?php

    /** HIDE MY POSTS **/

    $show_my_posts_list = array(
    	'1' => array('label' => __('Show my posts', 'peepso-core')),
    	'0' => array('label' => __('Hide my posts', 'peepso-core')),
    );

    $show_my_posts = $user_stream_filters['show_my_posts'];
    $selected = $show_my_posts_list[$show_my_posts];

    ?>

    <input type="hidden" id="peepso_stream_filter_show_my_posts" value="<?php echo $show_my_posts; ?>" />
    <div class="ps-posts__filter ps-posts__filter--myposts ps-js-dropdown ps-js-activitystream-filter" data-id="peepso_stream_filter_show_my_posts">
    	<a href="javascript:" class="ps-posts__filter-toggle ps-js-dropdown-toggle" aria-haspopup="true">
    		<span><i class="dojokoequalizer"></i> FILTER<?php //echo $show_my_posts ? __('Show my posts', 'peepso-core') : __('Hide my posts', 'peepso-core'); ?></span>
    	</a>
    	<div class="ps-posts__filter-box ps-posts__filter-box--myposts ps-js-dropdown-menu" role="menu">
    		<?php foreach ($show_my_posts_list as $key => $value) { ?>
    		<a class="ps-posts__filter-select" data-option-value="<?php echo $key; ?>" role="menuitem">
          <div class="ps-checkbox">
            <input type="radio" name="peepso_stream_filter_show_my_posts" id="peepso_stream_filter_show_my_posts_opt_<?php echo $key ?>"
              value="<?php echo $key ?>" <?php if($key == $show_my_posts) echo "checked"; ?> />
      			<label for="peepso_stream_filter_show_my_posts_opt_<?php echo $key ?>">
              <span><?php echo $value['label']; ?></span>
      			</label>
          </div>
    		</a>
    		<?php } ?>
    		<div class="ps-posts__filter-actions">
    			<button class="ps-posts__filter-action ps-btn ps-btn--sm ps-js-cancel"><?php echo __('Cancel', 'peepso-core'); ?></button>
    			<button class="ps-posts__filter-action ps-btn ps-btn--sm ps-btn--action ps-js-apply"><?php echo __('Apply', 'peepso-core'); ?></button>
    		</div>
    	</div>
    </div>
  </div>

  <div class="ps-posts__filters-group" id="rj-post-search">
  <?php

  /** SEARCH POSTS **/
  $search = FALSE;
  $PeepSoUrlSegments = PeepSoUrlSegments::get_instance();

  #4158 ?search/querystring does not work with special chars
  if('search' == $PeepSoUrlSegments->get(1)) {
      $search = $PeepSoUrlSegments->get(2);
  }

  #4158 ?search/querystring does not work with special chars
  if(isset($_GET['filter'])) {
      $PeepSoInput = new PeepSoInput();
      $search = $PeepSoInput->value('filter', '', FALSE);
  }
  ?>
  <input type="hidden" id="peepso_search" value="<?php echo $show_my_posts; ?>" />
  <div class="ps-posts__filter ps-posts__filter--search ps-js-dropdown ps-js-activitystream-filter" data-id="peepso_search">
  	<a class="ps-posts__filter-toggle ps-js-dropdown-toggle" aria-haspopup="true" aria-label="<?php echo __('Search', 'peepso-core'); ?>">
  		<i class="gcis gci-search"></i>
  		<span data-empty="<?php //echo __('Search', 'peepso-core'); ?>"
  			data-keyword="<?php echo __('Search: ', 'peepso-core'); ?>"></span>
  	</a>
  	<div class="ps-posts__filter-box ps-posts__filter-box--search ps-js-dropdown-menu" role="menu">
  		<div class="ps-posts__filter-search">
  			<i class="gcis gci-search"></i><input type="text" id="ps-activitystream-search" class="ps-input ps-input--sm"
  				placeholder="<?php echo __('Type to search', 'peepso-core'); ?>" value="<?php echo $search;?>" />
  		</div>

  		<a role="menuitem" class="ps-posts__filter-select" data-option-value="exact">
  			<div class="ps-checkbox">
  				<input type="radio" name="peepso_search" id="peepso_search_opt_exact" value="exact" checked />
  				<label for="peepso_search_opt_exact">
  					<span><?php echo __('Exact phrase', 'peepso-core'); ?></span>
  				</label>
  			</div>
  		</a>
  		<a role="menuitem" class="ps-posts__filter-select" data-option-value="any">
  			<div class="ps-checkbox">
  				<input type="radio" name="peepso_search" id="peepso_search_opt_any" value="any" />
  				<label for="peepso_search_opt_any">
  					<span><?php echo __('Any of the words', 'peepso-core'); ?></span>
  				</label>
  			</div>
  		</a>
  		<div class="ps-posts__filter-actions">
  			<button class="ps-posts__filter-action ps-btn ps-btn--sm ps-js-cancel"><?php echo __('Cancel', 'peepso-core'); ?></button>
  			<button class="ps-posts__filter-action ps-btn ps-btn--sm ps-btn--action ps-js-search"><?php echo __('Search', 'peepso-core'); ?></button>
  		</div>
  	</div>
  </div>

  <?php

  /** ADDITIONAL FILTERS - HOOKABLE **/

  do_action('peepso_action_render_stream_filters');
  ?>
  </div>
  
  <div class="elementor-row explore-rj">
  						<div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-72cc3d1" data-id="72cc3d1" data-element_type="column">
  				<div class="elementor-column-wrap elementor-element-populated">
  								<div class="elementor-widget-wrap">
  							<section class="elementor-section elementor-inner-section elementor-element elementor-element-85c63a1 elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="85c63a1" data-element_type="section">
  							<div class="elementor-container elementor-column-gap-no">
  								<div class="elementor-row">
  						<div class="elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-8738e6f" data-id="8738e6f" data-element_type="column">
  				<div class="elementor-column-wrap elementor-element-populated">
  								<div class="elementor-widget-wrap">
  							<div class="elementor-element elementor-element-7320416b elementor-align-left elementor-widget elementor-widget-button" data-id="7320416b" data-element_type="widget" data-widget_type="button.default">
  					<div class="elementor-widget-container">
  						<div class="elementor-button-wrapper">
  				<a href="#" class="elementor-button-link elementor-button elementor-size-xs" role="button">
  							<span class="elementor-button-content-wrapper">
  							<span class="elementor-button-icon elementor-align-icon-left">
  					<i aria-hidden="true" class="fas fa-stream"></i>			</span>
  							<span class="elementor-button-text">Posts</span>
  			</span>
  						</a>
  			</div>
  					</div>
  					</div>
  							</div>
  						</div>
  			</div>
  					<div class="elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-08e6c21" data-id="08e6c21" data-element_type="column">
  				<div class="elementor-column-wrap elementor-element-populated">
  								<div class="elementor-widget-wrap">
  							<div class="elementor-element elementor-element-2773970 elementor-align-left elementor-widget elementor-widget-button" data-id="2773970" data-element_type="widget" data-widget_type="button.default">
  					<div class="elementor-widget-container">
  						<div class="elementor-button-wrapper">
  				<a href="/community-photos/" class="elementor-button-link elementor-button elementor-size-xs" role="button">
  							<span class="elementor-button-content-wrapper">
  							<span class="elementor-button-icon elementor-align-icon-left">
  					<i aria-hidden="true" class="fas fa-camera"></i>			</span>
  							<span class="elementor-button-text">Photos</span>
  			</span>
  						</a>
  			</div>
  					</div>
  					</div>
  							</div>
  						</div>
  			</div>
  					<div class="elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-2c8d93e" data-id="2c8d93e" data-element_type="column">
  				<div class="elementor-column-wrap elementor-element-populated">
  								<div class="elementor-widget-wrap">
  							<div class="elementor-element elementor-element-1f398b52 elementor-align-left elementor-widget elementor-widget-button" data-id="1f398b52" data-element_type="widget" data-widget_type="button.default">
  					<div class="elementor-widget-container">
  						<div class="elementor-button-wrapper">
  				<a href="/community-videos/" class="elementor-button-link elementor-button elementor-size-xs" role="button">
  							<span class="elementor-button-content-wrapper">
  							<span class="elementor-button-icon elementor-align-icon-left">
  					<i aria-hidden="true" class="fas fa-video"></i>			</span>
  							<span class="elementor-button-text">Videos</span>
  			</span>
  						</a>
  			</div>
  					</div>
  					</div>
  							</div>
  						</div>
  			</div>
  					<div class="elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-aa98d7c" data-id="aa98d7c" data-element_type="column">
  				<div class="elementor-column-wrap">
  								<div class="elementor-widget-wrap">
  									</div>
  						</div>
  			</div>
  					<div class="elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-4c0d548" data-id="4c0d548" data-element_type="column">
  				<div class="elementor-column-wrap">
  								<div class="elementor-widget-wrap">
  									</div>
  						</div>
  			</div>
  									</div>
  						</div>
  			</section>
  							</div>
  						</div>
  			</div>
  									</div>
  
</div>
<div id="ps-stream__filters-warning" >
  <!--<i class="gcis gci-info-circle"></i> <?php //echo __('You are currently only viewing %s content.','peepso-core'); ?>
-->
</div>