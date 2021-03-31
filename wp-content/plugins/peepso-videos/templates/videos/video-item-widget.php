<div class="psw-media__video <?php if (!$vid_thumbnail) { echo "psw-media__audio"; } ?> ps-js-video" data-post-id="<?php echo $vid_post_id; ?>">
    <div class="psw-media__link">
        <a href="#" onclick="ps_comments.open('<?php echo $vid_post_id; ?>', 'video'); return false;">
            <?php if ($vid_thumbnail) { ?>
            	<img src="<?php echo $vid_thumbnail;?>" />
            <?php
            } else { ?>
            	<img src="<?php echo PeepSoVideos::get_cover_art($vid_artist, $vid_album, FALSE); ?>">
            <?php } ?>
            <i class="psw-media__play ps-js-media-play"></i>
        </a>
    </div>
</div>
