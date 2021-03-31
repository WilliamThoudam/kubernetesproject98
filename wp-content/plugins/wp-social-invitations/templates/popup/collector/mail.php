<?php
/**
 * Mail provider collector template
 * @link       http://wp.timersys.com/wordpress-social-invitations/
 * @since      2.5.0
 *
 * @package    Wsi
 * @subpackage Wsi/templates/popup/collector
 */
?>
<h2><?php _e("Invite your friends", 'wsi');?></h2>
<div class="mail-wrapper">
	<label for="subject"><?php _e('Enter your friends email', 'wsi');?></label>
	<input type="email" name="friend" id="emails" class="form-control" required="required" />
</div>