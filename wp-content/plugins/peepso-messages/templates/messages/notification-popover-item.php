<?php
$PeepSoMessages = PeepSoMessages::get_instance();
$PeepSoUser = PeepSoUser::get_instance($post_author);


/*
    To check the Message-Notification.
    If Messagge from Channel forward it to Channel-message view
    Else Show the message pop-up

*/

$par_msg_id = wp_get_post_parent_id($ID);
$par_msg_post = get_post($par_msg_id);
$grp_id = isset($par_msg_post->post_content_filtered) ? $par_msg_post->post_content_filtered : '0' ;
$PeepSoGroup = new PeepSoGroup($grp_id);
$grp_msg_url = $PeepSoGroup->get_url();

if($grp_id != 0)
{
    $msg_url = $PeepSoGroup->get_url().'messages/&'.$ID;
    $msg_name = $PeepSoGroup->get('name');
    $onclick = 'onclick="window.location ='."'".$msg_url."'".'"';
}else
{
    $msg_url = $PeepSoMessages->get_message_url();
}

?>

<div class="ps-notification ps-notification--message <?php if($grp_id == 0){echo ('ps-js-notification-message');} echo ($mrec_viewed) ? '' : 'ps-notification--unread'; ?>" data-id="<?php echo $PeepSoMessages->get_root_conversation();?>" data-url="<?php echo $msg_url; ?>"<?php if($grp_id != 0){echo ($onclick);}?>>


    <div class="ps-notification__link">
		<div class="ps-notification__avatar">
			<div class="ps-avatar ps-avatar--notification">
				<?php echo $PeepSoMessages->get_message_avatar(array('post_author' => $post_author, 'post_id' => $ID)); ?>
			</div>
		</div>
		<div class="ps-notification__body">
			<div class="ps-notification__desc ps-js-conversation-excerpt">
				<strong>
					<?php

                    // check for message is from channel or normal
                if($grp_id != 0)
                    {
                        echo $msg_name  ;

                    }else
                    {
                       $args = array(
						'post_author' => $post_author, 'post_id' => $ID
					);
					$PeepSoMessages->get_recipient_name($args);
				    }
					?>
				</strong>
				<?php
					$PeepSoMessages->get_last_author_name($args);
					echo $PeepSoMessages->get_conversation_title(); ?>
			</div>
			<div class="ps-notification__meta activity-post-age" data-timestamp="<?php echo strtotime($post_date); ?>">
				<?php #echo human_time_diff(strtotime($post_date), current_time('timestamp')) . ' ago'; ?>
        <?php echo sprintf(__('%s ago', 'peepso-core'), human_time_diff(strtotime($post_date), current_time('timestamp')));?>
			</div>
		</div>
	</div>
</div>
