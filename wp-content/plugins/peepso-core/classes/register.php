<?php

class PeepSoRegister
{
	protected static $_instance = NULL;

	private $user_id = NULL;
	private $user = NULL;

	// list of allowed template tags
	public $template_tags = array(
		'register_form',		// return the registration form
		'display_terms_and_conditions',
	);

	private function __construct()
	{
	}

	/*
	 * return singleton instance
	 */
	public static function get_instance()
	{
		if (self::$_instance === NULL)
			self::$_instance = new self();
		return (self::$_instance);
	}

	/* return propeties for the profile page
	 * @param string $prop The name of the property to return
	 * @return mixed The value of the property
	 */
	public function get_prop($prop)
	{
		$ret = '';
		return ($ret);
	}

	//// implementation of template tags

	/*
	 * constructs the profile edit form
	 */
	public function register_form()
	{

        $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url_components = parse_url($current_url);

        global $wpdb;

        $wp_open_ssl_key = $wpdb->prefix . 'open_ssl_key';
                            $secret_key = $wpdb->get_row("SELECT options, enc_iv, enc_key, ciphermethod FROM ".$wp_open_ssl_key." WHERE id = 1");
                            $secret_key = json_decode(json_encode($secret_key), true);

        $decrypted = openssl_decrypt (base64_decode($url_components['query']), $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16));

        parse_str($decrypted, $params);

        $invitefrom = isset($params['invite-from']) ? $params['invite-from'] : 0 ;
        $groupid = isset($params['group-id']) ? $params['group-id'] : 0 ;
        $emailid = isset($params['email-id']) ? $params['email-id'] : 'none';

        $input = new PeepSoInput();

		$fields = array(

        	'sender_id' => array(
				'type' => 'hidden',
				'value' => $invitefrom,
			),

            'group_id' => array(
				'type' => 'hidden',
				'value' => $groupid,
			),

            'nuser_email_id' => array(
				'type' => 'hidden',
				'value' => $emailid,
			),

			'task' => array(
				'type' => 'hidden',
				'value' => '-register-save',
			),

			'authkey' => array(
				'type' => 'hidden',
				'value' => '',
			),

			'-form-id' => array(
				'type' => 'hidden',
				'value' => wp_create_nonce('register-form'),
			),


			'username' => array(
				'label' => __('Username', 'peepso-core'),
			//	'descript' => __('Enter your desired username', 'peepso-core'),
				'value' => $input->value('username', '', FALSE), // SQL Safe
				'required' => 1,
	//			'row_wrapper_class' => 'ps-form__row--half',
				'validation' => array(
					'username',
					'required',
					'minlen:' . PeepSoUser::USERNAME_MINLEN,
					'maxlen:' . PeepSoUser::USERNAME_MAXLEN,
					'custom'
				),
				'validation_options' => array(
					'error_message' => __('Username must not be the same as your password.', 'peepso-core'),
					'function' => array(&$this, 'validate_username_not_password')
				),
				'type' => 'text',
			),
            'email' => array(
                'label' => __('Email', 'peepso-core'),
          //      'descript' => __('Enter your email address', 'peepso-core'),
                'value' => $input->value('email', '', FALSE), // SQL Safe
                'required' => 1,
          //      'row_wrapper_class' => 'ps-form__row--half',
                'type' => 'email',
                'validation' => array(
                    'email',
                    'required',
                    'maxlen:' . PeepSoUser::EMAIL_MAXLEN,
                ),
            ),
            'email_verify' => array(
                'label' => __('Verify Email', 'peepso-core'),
          //      'descript' => __('Please re-enter your email address', 'peepso-core'),
                'value' => $input->value('email', '', FALSE), // SQL Safe
                'required' => 1,
          //      'row_wrapper_class' => 'ps-form__row--half',
                'type' => 'email',
                'validation' => array(
                    'email',
                    'required',
                    'maxlen:' . PeepSoUser::EMAIL_MAXLEN,
                ),
                'extra' => ' onpaste="return false"',
            ),
				'password' => array(
						'label' => __('Password', 'peepso-core'),
			//			'descript' => __('Enter your desired password', 'peepso-core'),
						'value' => '',
						'required' => 1,
			//			'row_wrapper_class' => 'ps-form__row--half',
						'validation' => array('password', 'required'),
						'type' => 'password',
				),
				'password2' => array(
						'label' => __('Verify Password', 'peepso-core'),
			//			'descript' => __('Please re-enter your password', 'peepso-core'),
						'value' => '',
						'required' => 1,
			//			'row_wrapper_class' => 'ps-form__row--half',
						'validation' => array('password', 'required'),
						'type' => 'password',
				),
			/*'firstname' => array(
				'label' => __('First Name', 'peepso-core'),
				'descript' => __('Enter your first name', 'peepso-core'),
				'value' => $input->value('firstname', '', FALSE), // SQL Safe
				'required' => 1,
				'validation' => array(
					'name-utf8',
					'minlen:' . PeepSoUser::FIRSTNAME_MINLEN,
					'maxlen:' . PeepSoUser::FIRSTNAME_MAXLEN
				),
				'type' => 'text',
			),
			'lastname' => array(
				'label' => __('Last Name', 'peepso-core'),
				'descript' => __('Enter your last name', 'peepso-core'),
				'value' => $input->value('lastname', '', FALSE), // SQL Safe
				'required' => 1,
				'validation' => array(
					'name-utf8',
					'minlen:' . PeepSoUser::LASTNAME_MINLEN,
					'maxlen:' . PeepSoUser::LASTNAME_MAXLEN
				),
				'type' => 'text',
			),

			'gender' => array(
				'label' => __('Your Gender', 'peepso-core'),
				'descript' => __('Please enter your gender', 'peepso-core'),
				'value' => $input->value('gender', 'm', FALSE), // SQL Safe
				'required' => 1,
				'type' => 'radio',
				'options' => array('m' => __('Male', 'peepso-core'), 'f' => __('Female', 'peepso-core')),
			),*/

			'terms' => array(
			'label' => sprintf(__('I agree to the %s and %s.', 'peepso-core'),'<a href="#" class="rjterms">' . __('Terms and Conditions', 'peepso-core') . '</a>'
,'<a href="#" class="rjprivacy">' . __('Privacy Policy', 'peepso-core') . '</a>'
			),
			'type' => 'checkbox',
			'required' => 1,
			'row_wrapper_class' => 'ps-form__row--checkbox',
			'value' => 1
	),
/*  'privacy' => array(
			'label' => sprintf(__('I agree to the %s.', 'peepso-core'),
					'<a href="#" class="ps-js-btn-showprivacy">' . __('Privacy Policy', 'peepso-core') . '</a>'
			),
			'type' => 'checkbox',
			'required' => 1,
			'row_wrapper_class' => 'ps-form__row--checkbox',
			'value' => 1
	),*/

	'submit' => array(
		'label' => _x('Sign up', 'Submit Button on PeepSo registration form', 'peepso-core'),
		'class' => 'ps-btn--action',
		'type' => 'submit',
	),

/*						'message' => array(
		'label' =>sprintf(__('<br>By clicking <b>Sign up</b> above I hereby accept Dojoko %s and %s', 'peepso-core'),
									'<a href="#" class="ps-js-btn-showterms rjterms">' . __('Terms of Service', 'peepso-core') . '</a>',
									'<a href="#" class="ps-js-btn-showprivacy">' . __('Privacy Policy', 'peepso-core') . '</a>'

								),
		'type' => 'message',
	)



'submit' => array(
'label' => _x('Sign up', 'Submit Button on PeepSo registration form', 'peepso-core'),
'class' => 'ps-btn--action',
'type' => 'submit',
)

'message' => array(
'label' => __('Fields marked with an asterisk (<span class="ps-form__required">*</span>) are required.', 'peepso-core'),
'type' => 'message',
),

*/
		);

		if(PeepSo::get_option('registration_confirm_email_field',1)) {
		    $fields['username']['row_wrapper_class'] = 'ps-form__row--full ps-form__row--clear';
        } else {
		    unset($fields['email_verify']);
        }

		if(PeepSo::get_option('site_registration_recaptcha_enable', 0)) {
			$fields['submit']['class'] .= ' ps-js-recaptcha';

			// Enqueue recaptcha script.
			wp_enqueue_script('peepso-recaptcha');
		}

	$form = array(
			'name' => 'profile-edit',
			'action' => PeepSo::get_page('register'),
			'method' => 'POST',
			'class' => 'ps-form--register ps-form--register-main cform community-form-validate ps-js-form-register',
			'extra' => 'autocomplete="off"',
		);

        if (0 === PeepSo::get_option('site_registration_enableterms', 0)) {
            unset($fields['terms']);
            unset($fields['terms_text']);
        }

        if (0 === PeepSo::get_option('site_registration_enableprivacy', 0)) {
            unset($fields['privacy']);
            unset($fields['privacy_text']);
        }

		$fields = apply_filters('peepso_register_form_fields', $fields);

		$form = array(
			'container' => array(
				'element' => 'div',
				'class' => 'ps-form__grid',
			),
			'fieldcontainer' => array(
				'element' => 'div',
				'class' => 'ps-form__row',
			),
			'form' => $form,
			'fields' => $fields,
		);

		return ($form);
	}

	/**
	 * Custom form validation -
	 * Validates if username is not equal to the password.
	 * @param  string $value The username, supplied from the post value.
	 * @return boolean
	 */
	public function validate_username_not_password($value)
	{
		$input = new PeepSoInput();

		// SQL Safe
		return (!empty($value) && $input->value('password','', FALSE) !== $value);
	}
}

// EOF
