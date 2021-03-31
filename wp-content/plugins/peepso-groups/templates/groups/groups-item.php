<?php

$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url,'channels') !== false) 
{
    $uriArray = explode('&', $url);
    $parent_id = str_replace( '/', '', $uriArray[1]);
}
else
{
    $parent_id = 0;
}

?>

<div class="ps-group ps-js-group-item ps-js-group-item--{{= data.id }} {{= data.published ? '' : 'ps-group--unpublished' }}">
  <div class="ps-group__inner">
    <a href="{{= data.url }}" class="ps-group__header" style="background-image:url('{{= data.cover_url }}');">
      <div class="ps-avatar ps-avatar--group">
        <img src="{{= data.avatar_url_full }}" alt="">
      </div>
    </a>
		{{ if ( data.privacy ) { }}
    <div class="ps-group__privacy">
      <span class="ps-tip ps-tip--inline ps-tip--arrow" aria-label="{{= data.privacy.name }}"><i class="{{= data.privacy.icon }}"></i><span>{{= data.privacy.name }}</span></span>
    </div>
		{{ } }}
    <div class="ps-group__body">
      <div class="ps-group__name">
        <a href="{{= data.url }}">{{= data.nameHighlight }}</a>
      </div>

      <div class="ps-group__details">
        <div class="ps-group__desc">
          <p>{{= data.description }}</p>
        </div>

        <div class="ps-group__details-item">
          <i class="gcis gci-user-friends"></i>
          <span class="ps-js-member-count">
            {{= data.members_count }} {{= data.members_count > 1 ? '<?php echo __("members", "groupso"); ?>' : '<?php echo __("member", "groupso"); ?>' }}
            {{ if ( +data.pending_admin_members_count >= 1 ) { }}
            ({{- '<?php echo __("%d pending", "groupso"); ?>'.replace( '%d', data.pending_admin_members_count ) }})
            {{ } }}
          </span>
        </div>

        <?php if (intval(PeepSo::get_option('groups_listing_show_group_owner',1))) { ?>
        <div class="ps-group__details-item ps-group__details-item--hide">
          <i class="gcis gci-user-circle"></i><span class="ps-js-owner" data-id="{{= data.id }}"><img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif') ?>" /></span>
        </div>
        <?php } ?>

        <?php if (intval(PeepSo::get_option('groups_listing_show_group_creation_date',1))) { ?>
        <div class="ps-group__details-item ps-group__details-item--hide">
          <i class="gcis gci-clock"></i><span>{{= data.date_created_formatted }}</span>
        </div>
        <?php } ?>

        <?php if (PeepSo::get_option('groups_categories_enabled', FALSE) && ($parent_id == 0)){ ?>
        <div class="ps-group__details-item ps-group__details-item--hide">
          <i class="gcis gci-tag ps-js-category-icon"></i><span class="ps-js-categories" data-id="{{= data.id }}"><img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif') ?>" /></span>
        </div>
        <?php } ?>


        <a href="#" class="ps-group__details-item ps-group__details-item--more ps-link--more ps-js-more">
  				<i class="gcis gci-info-circle"></i>
  				<span><?php echo __('More', 'groupso'); ?></span>
  			</a>
			
			<a href="#" onclick="share.share_url('{{= data.url }}'); return false; return false;" title="Share this Group" class="ps-focus__detail share_group"><i class="gcis gci-share-alt"></i><span>Share</span></a>
      </div>
    </div>
  </div>
  <div class="ps-group__actions ps-js-member-actions">{{= data.member_actions }}</div>
</div>