<?php
$PeepSoPostbox = PeepSoPostbox::get_instance();
$PeepSoMessages= PeepSoMessages::get_instance();
$PeepSoGeneral = PeepSoGeneral::get_instance();

// Conversation flags.
$muted = isset($muted) && $muted;
$read_notification = isset($read_notification) && $read_notification;
#$notif = isset($notif) && $notif;

$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    $is_grp = 0;

if (strpos($url,'groups') !== false)
{
    $is_grp = 1;
}




add_filter('peepso_permissions_post_create', array('PeepSoMessagesPlugin', 'peepso_permission_message_create'), 99);
?>
<div class="peepso">
	<div id="cus_conversation_id" class="ps-page ps-page--conversation">
		<?php PeepSoTemplate::exec_template('general', 'navbar'); ?>

		<div class="ps-conversation">
			<div class="ps-conversation__header">

                <?php if($is_grp == 0)
            { ?>
				<div class="ps-conversation__header-inner">
					<div class="ps-conversation__back">
						<a class="ps-btn ps-btn--sm ps-btn--app" href="<?php echo PeepSo::get_page('messages') ?>">
							<i class="gcis gci-angle-left"></i><span><?php echo __('Back to Messages', 'msgso'); ?></span>
						</a>
					</div>

					<div class="ps-conversation__actions ps-btn__group">
						<?php if ($show_blockuser) { ?>
						<a href="javascript:" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-js-btn-blockuser" aria-label="<?php echo __('Block this user', 'msgso');?>" data-user-id="<?php echo $show_blockuser_id; ?>">
							<i class="gcis gci-ban"></i>
						</a>
						<?php } ?>
						<a href="javascript:" id="add-recipients-toggle" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline" aria-label="<?php echo __('Add People to the conversation', 'msgso');?>">
							<i class="gcis gci-user-plus"></i>
						</a>
						<?php if ($read_notification) { ?>
						<a href="javascript:" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-js-btn-toggle-checkmark <?php echo $notif ? '' : ' disabled' ?>" aria-label="<?php echo $notif ? __("Don't send read receipt", 'msgso') : __('Send read receipt', 'msgso'); ?>"
							onclick="return ps_messages.toggle_checkmark(<?php echo $parent->ID;?>, <?php echo $notif ? 0 : 1 ?>);"
						>
							<i class="gcir gci-check-circle"></i>
						</a>
						<?php } ?>
						<a href="javascript:" class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-js-btn-mute-conversation" aria-label="<?php echo $muted ? __('Unmute conversation', 'msgso') : __('Mute conversation', 'msgso'); ?>"
							onclick="return ps_messages.<?php echo $muted ? 'unmute' : 'mute'; ?>_conversation(<?php echo $parent->ID;?>, <?php echo $muted ? 0 : 1; ?>);"
						>
							<i class="<?php echo $muted ? 'gcis gci-bell-slash' : 'gcir gci-bell'; ?>"></i>
						</a>
						<a class="ps-btn ps-btn--sm ps-btn--app ps-btn--cp ps-tip ps-tip--inline ps-tip--right" aria-label="<?php echo __('Leave this conversation', 'msgso');?>"
							href="<?php echo $PeepSoMessages->get_leave_conversation_url();?>"
							onclick="return ps_messages.leave_conversation('<?php echo __('Are you sure you want to leave this conversation?', 'msgso'); ?>', this)"
						>
							<i class="gcis gci-times"></i>
						</a>
					</div>
				</div>
                <?php

                } ?>

				<div class="ps-conversation__add ps-js-recipients">
					<select name="recipients" id="recipients-search"
						data-placeholder="<?php echo __('Add People to the conversation', 'msgso');?>"
						data-loading="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>"
						multiple></select>
					<?php wp_nonce_field('add-participant', 'add-participant-nonce'); ?>
					<button class="ps-btn ps-btn--sm ps-btn--action" onclick="ps_messages.add_recipients(<?php echo $parent->ID;?>);">
						<?php echo __('Done', 'msgso'); ?>
						<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" style="display:none;">
					</button>
				</div>

				<div class="ps-conversation__participants ps-js-participant-summary">
					<span><?php echo __('Conversation with', 'msgso'); ?>:</span> <span class="ps-conversation__status"><i class="gcir gci-clock"></i></span><?php $PeepSoMessages->display_participant_summary();?>
				</div>
			</div>

			<div class="ps-conversation__chat">
				<div class="ps-chat__messages" id="cus_ps_chat_message_id">
					<div class="ps-chat__loading ps-js-loading">
						<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
					</div>
					<div class="ps-chat__typing ps-js-currently-typing"></div>
				</div>
			</div>

			<div id="postbox-message" class="ps-postbox ps-conversation__postbox">
				<?php $PeepSoPostbox->before_postbox(); ?>
				<div class="ps-postbox__inner">
				  <div id="ps-postbox-status" class="ps-postbox__content ps-postbox-content">
				    <div class="ps-postbox__views ps-postbox-tabs"><?php $PeepSoPostbox->postbox_tabs('messages'); ?></div>
            <?php //PeepSoTemplate::exec_template('general', 'postbox-status'); ?>

                        <?php if(TRUE === apply_filters('peepso_permissions_post_create', TRUE)) { ?>
                            <div class="ps-postbox__status ps-postbox-status">
                                <div class="ps-postbox__status-wrapper">
                                    <div class="ps-postbox__status-inner">
                                        <span class="ps-postbox__status-mirror ps-postbox-mirror"></span>
                                        <span class="ps-postbox__status-addons ps-postbox-addons"></span>
                                    </div>
                                    <div class="ps-postbox__input-wrapper ps-postbox-input ps-inputbox">
                                        <textarea class="ps-postbox__input ps-textarea ps-postbox-textarea"  placeholder="<?php echo __(apply_filters('peepso_postbox_message', 'Write a message'), 'peepso-core'); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="ps-postbox__chars-count ps-postbox-charcount ps-js-charcount" style="display:none"><?php echo PeepSo::get_option('site_status_limit', 4000) ?></div>
                            </div>
                            <?php } else { PeepSoTemplate::exec_template('general','postbox-permission-denied'); }// peepso_permissions_post_create ?>
				  </div>

				  <div class="ps-postbox__footer ps-js-postbox-footer ps-postbox-tab ps-postbox-tab-root" style="display: none;">
				    <div class="ps-postbox__menu ps-postbox__menu--tabs">
				      <?php $PeepSoGeneral->post_types(array('postbox_message' => TRUE)); ?>
				    </div>
				  </div>

				  <div class="ps-postbox__footer ps-conversation__postbox-footer ps-js-postbox-footer ps-postbox-tab selected interactions">
				    <div class="ps-postbox__menu ps-postbox__menu--interactions">
				      <?php $PeepSoPostbox->post_interactions(array('postbox_message' => TRUE)); ?>
				    </div>
				    <div class="ps-postbox__actions ps-postbox-action">
				      <div class="ps-checkbox ps-checkbox--enter">
				        <input type="checkbox" id="enter-to-send" class="ps-checkbox__input ps-js-checkbox-entertosend">
				        <label class="ps-checkbox__label" for="enter-to-send"><?php echo __('Press "Enter" to send', 'msgso'); ?></label>
				      </div>

				      <?php if(PeepSo::is_admin() && PeepSo::is_dev_mode('embeds')) { ?>
				      <button type="button" class="ps-btn ps-btn--sm ps-postbox__action ps-postbox__action--cancel ps-js-btn-preview"><?php echo __('Fetch URL', 'peepso-core'); ?></button>
				      <?php } ?>
				      <button type="button" class="ps-btn ps-btn--sm ps-postbox__action ps-tip ps-tip--arrow ps-postbox__action--cancel ps-button-cancel"
				        aria-label="<?php echo __('Cancel', 'peepso-core'); ?>"
				        style="display:none"><i class="gcis gci-times"></i></button>
				      <button type="button" class="ps-btn ps-btn--sm ps-btn--action ps-postbox__action ps-postbox__action--post ps-button-action postbox-submit"
				        style="display:none"><?php echo __('Post', 'peepso-core'); ?></button>
				    </div>
				    <div class="ps-loading ps-postbox-loading" style="display: none">
				      <img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>">
				      <div> </div>
				    </div>
				  </div>
				</div>
				<?php $PeepSoPostbox->after_postbox(); ?>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		ps_messages.init_conversation_view(<?php echo $parent->ID; ?>);
	});
</script>
<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>
<?php remove_filter('peepso_permissions_post_create', array('PeepSoMessagesPlugin', 'peepso_permission_message_create'), 99); ?>


<script>


var element_body = document.getElementById("body");
var element_conversation = document.getElementById("cus_conversation_id");
var element_chat_message = document.getElementById("cus_ps_chat_message_id");
const new_height = (element_body.offsetHeight - element_conversation.offsetHeight)-175;
element_chat_message.style.height=new_height+"px !important";
element_chat_message.style.height=new_height+"px !important";

</script>
