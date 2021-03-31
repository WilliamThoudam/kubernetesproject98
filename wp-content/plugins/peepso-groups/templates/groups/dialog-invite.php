<?php
$force_add = FALSE;
if(PeepSo::is_admin() && 1 == PeepSo::get_option('groups_add_by_admin_directly', 0)) {
$force_add = TRUE;
}

    $PeepSoUrlSegments= PeepSoUrlSegments::get_instance();
    $url_rj = $PeepSoUrlSegments->get(1);
    $page_type = $PeepSoUrlSegments->get(0);
    $grp_id = 0;
    $par_id = 0;

    if($page_type == 'peepso_groups')
    {
        $posts = get_posts(array('name' => $url_rj, 'post_type' => 'peepso-group'));

        foreach ($posts as $post) {
        $grp_id = $post->ID;
        break; //use this to limit to a single result
        }

        $par_id = wp_get_post_parent_id($grp_id);
    }

		$PeepSoGroup = new PeepSoGroup($grp_id);

?>



<div class="ps-group__invite">


    <?php
    if($par_id == 0)
    {
    ?>
    <!--For showing other option to invite users.-->
    <div id="cWindowContent" class="ps-modal__content ">
    <p class="cus_invite_via" >Invite via..</p>
        <div class=" cus_ps-sharebox">
            

					<?php
            $links = array(
									'facebook' => array(
										//'label' => 'Facebook',
                                        'label' => '',
										'icon' => 'facebook',
										'url'  => 'https://www.facebook.com/sharer.php?u='.$PeepSoGroup->get_url()
									),
									'twitter' => array(
										//'label' => 'Twitter',
                                        'label' => '',
										'icon' => 'twitter',
										'url'  => 'https://twitter.com/share?url='.$PeepSoGroup->get_url()
									),
						            'whatsapp' => array(
										//'label' => 'WhatsApp',
                                        'label' => '',
										'icon' => 'whatsapp',
										'url'  => 'https://api.whatsapp.com/send?text='.$PeepSoGroup->get_url()
									),
						            'linkedin' => array(
										//'label' => 'LinkedIn',
                                        'label' => '',
										'icon' => 'linkedin',
										'url'  => 'https://www.linkedin.com/shareArticle?mini=true&url='.$PeepSoGroup->get_url().'&source=' . urlencode(get_bloginfo('name'))
									),
            );

					if(count($links)) {
            foreach ($links as $link) {
                echo '<a class="ps-sharebox__item cus_ps-sharebox-item" href="', $link['url'], '" target="_blank">', PHP_EOL;
                echo '<span class="cus_ps_sharebox_icon ps-sharebox__icon ps-icon--social ps-icon--social-', $link['icon'], '">', $link['label'], '</span>', PHP_EOL;
                echo '</a>', PHP_EOL;
            	}
        	}
      ?>
            <a class="ps-sharebox__item cus_ps-sharebox-item ps-js-close" href="javascript:" onclick="invite_email_modal('block')"  role="button" aria-label="Invite by Email">
            <span class="cus_ps_sharebox_icon ps-sharebox__icon ps-icon--social ">
            <svg t="1613410712537" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2580" xmlns:xlink="http://www.w3.org/1999/xlink" width="23" height="23"><defs><style type="text/css"></style></defs><path fill="#FF4081" d="M981.333333 255.2c-0.533333-70.133333-57.6-127.2-128-127.2H170.666667c-70.4 0-127.466667 56.8-128 127.2V768c0 70.666667 57.333333 128 128 128h682.666666c70.666667 0 128-57.333333 128-128V256.533333v-1.333333zM170.666667 213.333333h682.666666c16.8 0 31.2 9.6 38.133334 23.733334L512 502.666667 132.533333 237.066667c6.933333-14.133333 21.333333-23.733333 38.133334-23.733334z m682.666666 597.333334H170.666667c-23.466667 0-42.666667-19.2-42.666667-42.666667V337.866667l359.466667 251.733333c7.466667 5.066667 16 7.733333 24.533333 7.733333s17.066667-2.666667 24.533333-7.733333L896 337.866667V768c0 23.466667-19.2 42.666667-42.666667 42.666667z" p-id="2581"></path></svg>
            
            E-mail</span>
            </a>



          <?php

            // create invitation copy link //
              global $wpdb;
                            $current_user_id = get_current_user_id();

                            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                            {
                                $http = "https://";
                            }
                            else
                            {
                                $http = "http://";
                            }

                            // Retrieving OPENSSL iv and key from the table
                            $wp_open_ssl_key = $wpdb->prefix . 'open_ssl_key';
                            $secret_key = $wpdb->get_row("SELECT options, enc_iv, enc_key, ciphermethod FROM ".$wp_open_ssl_key." WHERE id = 1");
                            $secret_key = json_decode(json_encode($secret_key), true);

                            $plain_params = "invite-from=".$current_user_id."&group-id=".$grp_id;
                            // Use OpenSSl Encryption method
                            $iv_length = openssl_cipher_iv_length($secret_key['ciphermethod']);
                            // Use openssl_encrypt() function to encrypt the data
                            $encrypted_params = base64_encode(openssl_encrypt($plain_params, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16)));

                            //$invitation_copy_link = $http.$_SERVER['SERVER_NAME']."/register?".$encrypted_params;
                            $main_domain = str_replace("/wp-content/themes/peepso-theme-gecko","",get_template_directory_uri());
                            $invitation_copy_link = $main_domain."/register?".$encrypted_params; ?>


            <script type="text/javascript" src="<?=get_template_directory_uri()."/assets/js/copy_text_library.js";?>"></script>

            <a  data-clipboard-text="<?php echo $invitation_copy_link; ?>" class="copy_link_btn ps-sharebox__item cus_ps-sharebox-item  ps-invite-via-email" >
            <span class="cus_ps_sharebox_icon ps-sharebox__icon ps-icon--social ">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" t="1613410757990" class="icon" viewBox="0 0 1024 1024" version="1.1" p-id="3375" width="23" height="23"><defs><style type="text/css"/></defs><path fill="#FF4081" d="M682.666667 42.666667H170.666667c-46.933333 0-85.333333 38.4-85.333334 85.333333v597.333333h85.333334V128h512V42.666667z m128 170.666666H341.333333c-46.933333 0-85.333333 38.4-85.333333 85.333334v597.333333c0 46.933333 38.4 85.333333 85.333333 85.333333h469.333334c46.933333 0 85.333333-38.4 85.333333-85.333333V298.666667c0-46.933333-38.4-85.333333-85.333333-85.333334z m0 682.666667H341.333333V298.666667h469.333334v597.333333z" p-id="3376"/></svg>
            <span id="link_copy_text">Copy Link</span></span>
            </a>
                <script>
                var clip = new Clipboard('.copy_link_btn');
                clip.on('success', function(e) {

                    document.getElementById('link_copy_text').innerHTML="Copied!";
                   setTimeout(function(){ document.getElementById('link_copy_text').innerHTML="Copy link"; }, 3000);
                });
                </script>
        </div>
    </div>

    <?php
}

    ?>

<div class="ps-group__invite-search">
<input type="text" class="ps-input ps-full" value="" placeholder="<?php echo __('Start typing to search...', 'groupso'); ?>" />
</div>

<div class="ps-group__invite-list ps-js-scrollable">
<div class="ps-members ps-js-member-items"></div>
<div class="ps-loading ps-js-loading"><img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="loading" /></div>
<button class="ps-btn ps-btn--full ps-btn--action ps-js-loadmore" style="margin-top:var(--PADD--MD)"><?php echo __('Load more', 'groupso'); ?></button>
<div class="ps-alert ps-js-nomore"><?php echo __('Nothing more to show.', 'groupso'); ?></div>
</div>

<div class="ps-alert ps-alert--neutral">
<p>
<?php echo __('Please note: Users who are either banned, already invited, members or blocked receiving invitations will not show in this listing.', 'groupso'); ?>
</p>
</div>
</div>

<script type="text/template" class="ps-js-member-item">
<div class="ps-member">
<div class="ps-member__inner">
<div class="ps-member__header">
<a href="{{= data.profileurl }}" class="ps-avatar ps-avatar--member">
<img src="{{= data.avatar }}" title="{{= data.fullname }}" alt="{{= data.fullname }} avatar">
</a>
</div>

<div class="ps-member__body">
<div class="ps-member__name">
<a href="{{= data.profileurl }}" class="ps-members-item-title" title="{{= data.fullname }}">
{{= data.fullname_with_addons }}
</a>
</div>
</div>

<div class="ps-member__actions">
<a class="ps-member__action ps-js-invite" data-id="{{= data.id }}" href="javascript:">
<span data-invited="<?php echo $force_add ? __('Added', 'groupso') : __('Invited', 'groupso'); ?>"><?php echo $force_add ? __('Add', 'groupso') : __('Invite', 'groupso'); ?></span>
<img src="<?php echo PeepSo::get_asset('images/ajax-loader.gif'); ?>" alt="loading" style="display:none" />
</a>
</div>
</div>
</div>
</script>

<?php

// Additional popup options (optional).
$opts = array(



'title' => $force_add ? __('Add users', 'groupso') : __('Invite users', 'groupso'),
'actions' => false,
'class' => 'ps-modal--group-invite',
'reloadOnClose' => isset($reload_on_close) ? $reload_on_close : false
);

?>
<script type="text/template" data-name="opts"><?php echo json_encode($opts); ?></script>
