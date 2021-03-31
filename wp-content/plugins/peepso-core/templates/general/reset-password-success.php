<div class="reset-gap ps-clearfix">
	<form id="recoverpasswordform" name="recoverpasswordform" action="<?php PeepSo::get_page('activity'); ?>" method="post" class="ps-form">
		<p><?php echo __('Your password has been changed successfully. Please login to access your account.', 'peepso-core'); ?></p>
	</form>
    <div> </div>
    <div class="ps-form__row ps-form__row--submit">
              <a class="ps-btn" href="<?php echo get_bloginfo('wpurl'); ?>"><?php echo __('Back to Login', 'peepso-core'); ?></a>
              
					</div>
</div>