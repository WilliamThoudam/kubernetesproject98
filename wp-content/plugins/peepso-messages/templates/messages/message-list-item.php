<?php
$PeepSoActivity = PeepSoActivity::get_instance();
$PeepSoMessages = PeepSoMessages::get_instance();
$PeepSoUser = PeepSoUser::get_instance($post_author);

/*
    To check the Message is from Channel.
    If Messagge from Channel Change the name to Grp name
    Change the URL of message view to channel-message view
*/

$theme_mode = get_user_meta(get_current_user_id(), 'peepso_gecko_user_theme', true);

$par_msg_id = wp_get_post_parent_id($ID);
$par_msg_post = get_post($par_msg_id);
$grp_id = $par_msg_post->post_content_filtered;
$PeepSoGroup = new PeepSoGroup($grp_id);
$grp_msg_url = $PeepSoGroup->get_url();

if($grp_id != 0)
{
    $msg_url = $PeepSoGroup->get_url().'messages/&'.$ID;
    $msg_name = $PeepSoGroup->get('name');
}else
{
    $msg_url = $PeepSoMessages->get_message_url();
}

?>

<div class="ps-messages__list-item <?php echo ($mrec_viewed) ? '' : 'ps-messages__list-item--unread'; ?> ps-js-messages-list-item">
	<div class="ps-checkbox ps-messages__list-item-checkbox">
		<input class="ps-checkbox__input" name="messages[]" type="checkbox" id="<?php echo $ID; ?>" value="<?php echo $ID; ?>" />
		<label class="ps-checkbox__label" for="<?php echo $ID; ?>"></label>
	</div>

	<a class="ps-avatar ps-avatar--md ps-messages__list-item-avatar" href="<?php echo $msg_url;?>">
		<?php echo $PeepSoMessages->get_message_avatar(array('post_author' => $post_author, 'post_id' => $ID)); ?>
	</a>

	<div class="ps-messages__list-item-details" onclick="window.location = '<?php echo $msg_url; ?>'">
		<div class="ps-messages__list-item-author">
			<!--<a href="<?php echo $PeepSoUser->get_profileurl(); ?>">-->
				<?php

            // check for message is from channel or normal
                if($grp_id != 0)
                    {
                      $args = array(
                        'post_author' => $post_author, 'post_id' => $ID
                      );
                        echo $msg_name  ;

                    }else
                    {
                        $args = array(
					'post_author' => $post_author, 'post_id' => $ID
				);
				$PeepSoMessages->get_recipient_name($args);
				    }
                ?>

			<!--</a>-->
		</div>

		<div class="ps-messages__list-item-excerpt ps-js-conversation-excerpt <?php if($theme_mode == 'gecko_dark_mode'){echo "dark_mode_ps-messages__list-item-excerpt";}?>">
			<?php
			$PeepSoMessages->get_last_author_name($args);
			echo $PeepSoMessages->get_conversation_title(); ?>
		</div>
	</div>

	<div class="ps-messages__list-item-meta <?php if($theme_mode == 'gecko_dark_mode'){echo "dark_mode_ps-messages__list-item-meta";}?>">
		<i class="gcis gci-clock"></i><?php $PeepSoActivity->post_age(); ?>
	</div>
</div>
