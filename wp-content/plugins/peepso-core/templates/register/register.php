<?php
$PeepSoForm = PeepSoForm::get_instance();
$PeepSoRegister = PeepSoRegister::get_instance();
?>

<!-- PEEPSO WRAPPER -->
<div class="peepso">
	<div class="ps-page ps-page--register ps-page--register-main">
		<div class="psf-register psf-register--main">
			<?php if (!empty($error)) : ?>
			<div class="ps-alert ps-alert--error"><?php echo __('Error: ', 'peepso-core'); echo $error; ?></div>
			<?php endif; ?>

			<?php do_action('peepso_before_registration_form');?>

			<!-- REGISTER FORM -->
			<?php $PeepSoForm->render($PeepSoRegister->register_form()); ?>
            
          <!-- Login link added by rishabh -->
          <div class="elementor-element elementor-element-5c70e4a elementor-widget elementor-widget-heading" data-id="5c70e4a" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-widget-container">
			<h5 class="elementor-heading-title elementor-size-default"><a href="/#">I already have an account</a></h5>		</div>
				</div>
	
			<?php do_action('peepso_after_registration_form'); ?>
		</div>
	</div>
</div><!-- end: PEEPSO WRAPPER -->

<script>
jQuery(function($) {
    var data = window.peepsodata && peepsodata.register || {},
        TERMS_TITLE = '<?php echo esc_js( __('Terms and Conditions', 'peepso-core') ); ?>',
        TERMS_TEXT = data.text_terms,
        PRIVACY_TITLE = '<?php echo esc_js( __('Privacy Policy', 'peepso-core') ); ?>',
        PRIVACY_TEXT = data.text_privacy;

    $('.ps-js-btn-showterms').on('click', function(e) {
        e.preventDefault();
        peepso.dialog(TERMS_TEXT, { title: TERMS_TITLE, wide: true }).show();
    });

    $('.ps-js-btn-showprivacy').on('click', function(e) {
        e.preventDefault();
        peepso.dialog(PRIVACY_TEXT, { title: PRIVACY_TITLE, wide: true }).show();
    });
});
</script>