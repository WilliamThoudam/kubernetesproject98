<div class="ps-media__page-list-item <?php if (!$vid_thumbnail) { echo "ps-media__page-list-item--audio"; } ?> ps-js-video" data-post-id="<?php echo $vid_post_id; ?>">
  <div class="ps-media__page-list-item-inner">
    <a href="#" onclick="ps_comments.open('<?php echo $vid_post_id; ?>', 'video'); return false;">
      <?php if ($vid_thumbnail) { ?>
        <img src="<?php echo $vid_thumbnail;?>" />
      <?php
      } else { ?>
        <img src="<?php echo PeepSoVideos::get_cover_art($vid_artist, $vid_album, FALSE); ?>">
      <?php } ?>
      <i class="gcis gci-play"></i>
    </a>
  </div>
</div>
