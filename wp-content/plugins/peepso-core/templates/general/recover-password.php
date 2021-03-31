<?php

    $recaptchaEnabled = PeepSo::get_option('site_registration_recaptcha_enable', 0);
    $recaptchaClass = $recaptchaEnabled ? ' ps-js-recaptcha' : '';

?>
<div class="peepso">
  <div class="ps-page ps-page--register ps-page--register-recover">
    <h2><?php echo __('Forgot Password? No worries!', 'peepso-core'); ?></h2>
    <p><?php echo __('Just enter your email address below and we will send you instructions on how to reset your password', 'peepso-core'); ?></p>
    <?php
    if (isset($error)) {
        PeepSoGeneral::get_instance()->show_error($error);
    }
    ?>
    <div class="psf-register psf-register--recover">
      <form id="recoverpasswordform" name="recoverpasswordform" action="<?php PeepSo::get_page('recover'); ?>?submit" method="post" class="ps-form ps-form--register ps-form--register-recover">
          <input type="hidden" name="task" value="-recover-password" />
          <input type="hidden" name="-form-id" value="<?php echo wp_create_nonce('peepso-recover-password-form'); ?>" />
          <div class="ps-form__grid">
              <div class="ps-form__row">
                  <label for="email" class="ps-form__label"><?php echo __('Email Address:', 'peepso-core'); ?>
                      <span class="ps-form__required">&nbsp;*<span></span></span>
                  </label>
                  <div class="ps-form__field">
                      <input class="ps-input" type="email" name="email" placeholder="<?php echo __('Email address', 'peepso-core'); ?>" />
                  </div>
              </div>
              <div class="ps-form__row ps-form__row--submit">
                <a class="ps-btn" href="<?php echo get_bloginfo('wpurl'); ?>"><?php echo __('Back to Login', 'peepso-core'); ?></a>
                <input type="submit" name="submit-recover"
                  class="ps-btn ps-btn--action <?php echo $recaptchaClass; ?>"
                  value="<?php echo __('Submit', 'peepso-core'); ?>" />
              </div>
          </div>
      </form>
    </div>
  </div>
</div>