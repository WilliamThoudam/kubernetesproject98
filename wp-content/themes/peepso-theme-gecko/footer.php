<?php if (! is_page_template( 'page-tpl-landing.php' ) ) : ?>
<?php get_template_part( 'template-parts/widgets/bottom' ); ?>
<?php endif; ?>

<?php

  $PeepSoUrlSegments= PeepSoUrlSegments::get_instance();
    $url_rj = $PeepSoUrlSegments->get(1);
    $page_type = $PeepSoUrlSegments->get(0);
    $grp_id_rj = 0;

    if($page_type == 'peepso_groups')
    {
        $posts = get_posts(array('name' => $url_rj, 'post_type' => 'peepso-group'));

        foreach ($posts as $post) {
        $grp_id_rj = $post->ID;
        break; //use this to limit to a single result
        }
    }

  $hide_widgets = get_post_meta(get_proper_ID(), 'gecko-page-footer-mobile', true);
  $hide_sidebar_left = get_post_meta(get_proper_ID(), 'gecko-page-left-sidebar-mobile', true);
  $hide_sidebar_right = get_post_meta(get_proper_ID(), 'gecko-page-right-sidebar-mobile', true);
  $hide_footer = get_post_meta(get_proper_ID(), 'gecko-page-hide-footer', true);

  // Get search visibility option from admin settings
  $settings = GeckoConfigSettings::get_instance();

  if($settings->get_option('opt_sidebar_left_mobile_vis', '1') == 0) {
    $hide_sidebar_left = TRUE;
  }

  if($settings->get_option('opt_sidebar_right_mobile_vis', '1') == 0) {
    $hide_sidebar_right = TRUE;
  }

  if ($hide_widgets == 1) :
  ?>
<style>
@media screen and (max-width: 980px) {
    .footer__wrapper {
        display: none;
    }
}
</style>
<?php endif; ?>

<?php if ($hide_sidebar_left == 1) : ?>
<style>
@media screen and (max-width: 980px) {
    .sidebar--left {
        display: none;
    }
}
</style>
<?php endif; ?>

<?php if ($hide_sidebar_right == 1) : ?>
<style>
@media screen and (max-width: 980px) {
    .sidebar--right {
        display: none;
    }
}
</style>
<?php endif; ?>

<?php if(get_theme_mod('general_scroll_to_top', '1') == "1") : ?>
<a href="#body" class="gc-scroll__to-top js-scroll-top"><i class="gcis gci-angle-up"></i></a>
<?php endif; ?>

<?php if (! is_page_template( 'page-tpl-landing.php' ) ) : ?>
<?php if(! $hide_footer) : ?>
<footer class="gc-footer">
    <?php if (! is_page_template( 'page-tpl-landing.php' ) ) : ?>
    <?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
    <div class="gc-footer__grid">
        <!-- Include widgets -->
        <?php dynamic_sidebar( 'footer-widgets' ); ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <div class="gc-footer__bottom">
        <div class="gc-footer__bottom-inner">
            <div class="gc-footer__copyrights">
                <?php
            $line_1 = $settings->get_option( 'opt_footer_text_line_1', FALSE);
            if(FALSE === $line_1) {
                $line_1 = get_bloginfo('name');
            }
            if (strlen($line_1) ) : ?>
                <?php echo $line_1; ?>
                <?php endif; ?>
                <?php
            $line_2 = $settings->get_option( 'opt_footer_text_line_2', FALSE);
            if(FALSE === $line_2) {
                $line_2 = 'All rights reserved';
            }
            if (strlen($line_2)) : ?>
                <div class="gc-footer__rights">
                    <?php echo $line_2; ?>
                </div>
                <?php endif; ?>
            </div>

            <ul class="gc-footer__menu">
                <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'items_wrap' => '%3$s', 'container' => false, 'fallback_cb' => false ) ); ?>
            </ul>

            <?php if ( is_active_sidebar( 'footer-social' ) ) : ?>
            <div class="gc-footer__social">
                <!-- <a href="javascript:" class="gc-footer__social-item gc-footer__social-item--facebook">
              <i class="gcib gci-facebook-f"></i>
            </a>
            <a href="javascript:" class="gc-footer__social-item gc-footer__social-item--twitter">
              <i class="gcib gci-twitter"></i>
            </a>
            <a href="javascript:" class="gc-footer__social-item gc-footer__social-item--instagram">
              <i class="gcib gci-instagram"></i>
            </a> -->
                <?php dynamic_sidebar( 'footer-social' ); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php endif; ?>
<?php endif; ?>
<script type="text/javascript" src="<?=get_template_directory_uri()."/assets/js/emoji.js";?>"></script>


<?php wp_footer(); ?>
</body>

</html>


<div id="cus_ps-window" class="ps-modal__wrapper" style=" display:none ">
    <div class="ps-modal__container ps-dialog-container">
        <div class="ps-modal ps-dialog ps-dialog-wide cus_ps_modal_wide">
            <div class="ps-modal__inner">
                <div class="ps-modal__header ps-dialog-header cus_ps_modal_headre">
                    <div class="ps-modal__title ps-dialog-title"><span id="cv_heading_title"> </span> <br><span
                            class="cus_ps_modal_headline" id="cv_subheading_title"></span></div><a
                        class="ps-modal__close ps-dialog-close" href="#" onclick="close_cus_modal();"><i
                            class="gcis gci-times"></i></a>
                </div>
                <div class="ps-modal__body ps-dialog-body">
                    <div class="ps-modal__content cus_ps_modal_content">


                        <div class="cus_main_container">

                            <!-- <div class="empty_cv" style="margin:30px !important"><span class="empty_cv_firstname"></span> has not created their CV yet! Encourage <span class="empty_cv_firstname"></span> to create their CV by clicking <a href="#">here</a></div> -->
<input type="hidden" id="client_cv_user_id"/>
                            <div class="empty_cv" style="margin:30px !important; color: #FF4081 !important; background-color: transparent !important"><span class="empty_cv_firstname"></span> has not created their CV yet! Encourage <span class="empty_cv_firstname"></span> to create their CV by clicking <a href="javascript:sendCVNotification()">here</a>

                            <div id="cv_notification_msg" style="color:#FF4081; justify-content: center;"></div>

                            </div>
                            <div class="cv_body_wrapper">

                                <div class="cv_content_left">

                                    <h3 class="cv_section_heading">
                                        About Me
                                    </h3>

                                    <p class="cv_section_desc ql-editor" id="cv_summary">

                                    </p>

                                    <hr>
                                    <div hidden>
                                        <h3 class="cv_section_heading">
                                            User Profile Type
                                        </h3>

                                        <p class="cv_chip_wrapper" style="display:grid" id="cv_user_profile_type">
                                            <!-- <span class="cv_chip">Pre University Student</span><span class="cv_chip">University Student</span>-->
                                            <!--<span class="cv_chip">Young Professional (less than 4 Years)</span><span class="cv_chip">Experienced Professionals (more than 4 Years)</span> -->

                                        </p>

                                        <hr>
                                    </div>

                                    <h3 class="cv_section_heading">
                                        Phone
                                    </h3>

                                    <p class="cv_section_desc" id="cv_phone">
                                    </p>

                                    <hr>

                                    <h3 class="cv_section_heading">
                                        Email
                                    </h3>

                                    <p class="cv_section_desc" id="cv_email">
                                    </p>

                                    <hr>


                                    <p class="cv_section_desc">
                                    <h3 class="cv_section_heading">
                                        My Education
                                    </h3>
                                    <div class="cv_list_div" id="cv_education">

                                    </div>
                                    </p>

                                    <hr>



                                    <p class="cv_section_desc">
                                    <h3 class="cv_section_heading">
                                        Work Experience
                                    </h3>
                                    <div class="cv_list_div" id="cv_work_experience">

                                    </div>
                                    </p>

                                    <hr>




                                    <p class="cv_section_desc">
                                    <h3 class="cv_section_heading">
                                        Awards & Achievements
                                    </h3>
                                    <div class="cv_list_div" id="cv_award_achievement">

                                    </div>
                                    </p>

                                    <hr>

                                    <div class="cv_content_left_footer">
                                        <p>Generated by dojoko.com</p>
                                    </div>


                                </div>

                                <div class="cv_content_right">

                                    <p class="cv_section_desc">
                                    <h3 class="cv_section_heading">
                                        Location
                                    </h3>
                                    <div class="cv_chip_wrapper">
                                        <p class="cv_section_desc" id="cv_profile_info_current_location"></p>
                                    </div>
                                    </p>

                                    <hr>

                                    <!-- <p class="cv_section_desc" >-->
                                    <!-- <h3 class="cv_section_heading">-->
                                    <!-- Previous Locations-->
                                    <!-- </h3>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_profile_info_location_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->

                                    <!-- <hr>-->

                                    <p class="cv_section_desc">
                                    <h3 class="cv_section_heading">
                                        Languages
                                    </h3>
                                    <div class="cv_chip_wrapper" id="cv_profile_info_language_chip">

                                    </div>
                                    </p>

                                    <hr>

                                    <h3 class="cv_section_heading" id="cv_my_skills">
                                        My Skills
                                    </h3>
                                    <p class="cv_section_desc">
                                        <span style="font-size:12px">Technical Skills</span>
                                    <div class="cv_chip_wrapper" id="cv_my_skills_technical_chip">

                                    </div>
                                    </p>
                                    <br>

                                    <p class="cv_section_desc">
                                        <span style="font-size:12px">Personal Skills</span>
                                    <div class="cv_chip_wrapper" id="cv_my_skills_personal_chip">

                                    </div>
                                    </p>
                                    <br>

                                    <p class="cv_section_desc">
                                        <span style="font-size:12px">Hobbies</span>
                                    <div class="cv_chip_wrapper" id="cv_my_skills_hobbies_chip">

                                    </div>
                                    </p>
                                    <hr>

                                    <!-- <h3 class="cv_section_heading" id="cv_skills_i_want_to_learn">-->
                                    <!-- Skills I Want To Learn-->
                                    <!-- </h3>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Technical Skills</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_skills_i_want_to_learn_technical_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!--<br>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Personal Skills</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_skills_i_want_to_learn_personal_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!--<br>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Hobbies</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_skills_i_want_to_learn_hobbies_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!-- <hr>-->

                                    <!-- <h3 class="cv_section_heading" id="cv_higher_education_interests">-->
                                    <!--  Higher Education Interests-->
                                    <!-- </h3>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Location</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_higher_education_interests_location_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!--<br>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Degree Type</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_higher_education_interests_degree_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!--<br>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Specialisations</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_higher_education_interests_specialisation_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!--<br>-->

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Universities</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_higher_education_interests_university_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!-- <hr>-->

                                    <h3 class="cv_section_heading" id="cv_career_interests">
                                        Career Interests
                                    </h3>

                                    <p class="cv_section_desc">
                                        <span style="font-size:12px">Job Roles</span>
                                    <div class="cv_chip_wrapper" id="cv_career_interests_job_role_chip">

                                    </div>
                                    </p>
                                    <br>

                                    <!-- <p class="cv_section_desc" >-->
                                    <!--     <span style="font-size:12px">Location</span>-->
                                    <!--     <div class="cv_chip_wrapper" id="cv_career_interests_location_chip">-->

                                    <!--     </div>-->
                                    <!--</p>-->
                                    <!--<br>-->

                                    <p class="cv_section_desc">
                                        <span style="font-size:12px">Industries</span>
                                    <div class="cv_chip_wrapper" id="cv_career_interests_industry_chip">

                                    </div>
                                    </p>
                                    <br>

                                    <p class="cv_section_desc">
                                        <span style="font-size:12px">Type of Work</span>
                                    <div class="cv_chip_wrapper" id="cv_career_interests_type_of_work_chip">

                                    </div>
                                    </p>
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="flexbox">

    <!-- SPINNER 13   -->
    <div>
        <div class="ml-loader">
            <!--<div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>-->
            <img class="ps-loading" src="/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt=""
                style="display: flex">
        </div>
    </div>

</div>
<div id="snackbar"></div>

<div id="cus_com_modalbox" class="ps-modal__wrapper" style="display: none;">
    <div class="ps-modal__container ps-dialog-container">
        <div class="ps-modal ps-dialog ps-dialog-wide cus_ps_modal_wide">
            <div class="ps-modal__inner">
                <div class="ps-modal__header ps-dialog-header cus_ps_modal_headre">
                    <div class="ps-modal__title ps-dialog-title cus_common_header_title"><span
                            id="cus_common_title">Things in common with <span id="cus_com_full_name"></span></span>
                    </div>
                    <a class="ps-modal__close ps-dialog-close" href="javascript:close_cus_com_modalbox();">
                        <i class="gcis gci-times"></i></a>
                </div>
                <div class="ps-modal__body ps-dialog-body">
                    <div class="ps-modal__content cus_ps_modal_content">
                        <div class="cus_common_item_wrapper">

                        <div class="cus_common_item_section">
                            <h3 align="center" class="cus_common_item_header" id="cus_com_profile_type"></h3>
                            <span id="similarities_msg" align="center"></span>
                        </div>


                            <div class="cus_common_item_section">
                                <h3 class="cus_common_item_header" id="common_educations_wr">Educations <span
                                        class="cus_common_item_count"></span> </h3>
                                <span id="cus_com_educations"></span>
                            </div>

                            <div class="cus_common_item_section">
                                <h3 class="cus_common_item_header" id="cus_com_locations_wr">Locations <span
                                        class="cus_common_item_count"></span> </h3>
                                <span id="cus_com_locations"></span>
                            </div>

                            <!-- <div class="cus_common_item_section">
                                <h3 class="cus_common_item_header" id="common_interests_wr">Interests <span
                                        class="cus_common_item_count"></span> </h3>
                                <span id="cus_com_interests"></span>
                            </div> -->


                            <div class="cus_common_item_section">
                                <h3 class="cus_common_item_header" id="cus_com_languages_wr">Languages spoken <span
                                        class="cus_common_item_count"></span> </h3>
                                <span id="cus_com_languages"></span>
                            </div>


                            <div class="cus_common_item_section">
                                <h3 class="cus_common_item_header" id="cus_com_careers_wr">Careers <span
                                        class="cus_common_item_count"></span> </h3>
                                <span id="cus_com_careers"></span>
                            </div>


                            <div class="cus_common_item_section">
                                <h3 class="cus_common_item_header" id="cus_com_skills_wr">Skills and hobbies <span
                                        class="cus_common_item_count"></span> </h3>
                                <span id="cus_com_skills"></span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php global $current_user; wp_get_current_user(); ?>
<?php if ( is_user_logged_in() ) {
       echo "<input type='hidden' value= '" . $current_user->user_login ."' id='cus_username'></input>";
       echo "<input type='hidden' value= '" . get_current_user_id() ."' id='cus_userid'></input>";

     //  echo 'User display name: ' . $current_user->display_name . "\n";
     }
       ?>

<div id="onboarding_ajax_function_link">
</div>

<div id="invite_email_ps-window" class="ps-modal__wrapper" style=" display:none ">
    <div class="ps-modal__container ps-dialog-container">
        <div class="ps-modal ps-dialog ps-dialog-wide cus_ps_modal_wide">
            <div class="ps-modal__inner">
                <div class="ps-modal__header ps-dialog-header cus_ps_modal_headre">
                    <div class="ps-modal__title ps-dialog-title"><span>Invite via email</span> <br><span
                            class="cus_ps_modal_headline"></span></div><a class="ps-modal__close ps-dialog-close"
                        href="#" onclick="invite_email_modal('none');reset_email();"><i class="gcis gci-times"></i></a>
                </div>
                <div class="ps-modal__body ps-dialog-body">
                    <div class="ps-modal__content cus_ps_modal_content">

                        <div class="ps-modal__body ps-js-body">
                            <div class="ps-modal__content">
                                <div class="ps-group__create">
                                    <div class="ps-form ps-form--vertical ps-form--group-create">

                                        <div class="ps-form__row" style="display:none">
                                            <label class="ps-form__label">Group ID <span
                                                    class="ps-text--danger">*</span></label>
                                            <div class="ps-form__field ps-form__field--limit">
                                                <div class="ps-input__wrapper">
                                                    <input type="text" name="group_id" id="group_id"
                                                        class="ps-input ps-input--sm ps-input--count ps-js-name-input"
                                                        value="<?php echo ($grp_id_rj); ?>" placeholder="Group ID">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="ps-form__row">
                                            <ul class="dropdown-menu-list scroller cus_email_textfield">
                                                <li>
                                                    <a href="javascript:;">

                                                        <div class="form-group">
                                                            <label>Recipients:</label>
                                                            <div class="input-group input-group-md">
                                                                <input type="text" id="to_emails" name="to_emails"
                                                                    class="form-control">

                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div id="invite_email_msg" style="color:#FF4081;
justify-content: center;"></div>




                                    </div>
                                </div>
                            </div>
                            <div class="ps-modal__footer ps-js-footer">
                                <div class="ps-modal__actions">
                                    <button onclick="invite_email_modal('none');reset_email();"
                                        class="ps-btn ps-btn--sm ps-js-cancel">Cancel</button>
                                    <button type="button" onclick="bulk_invite()" id="invite_email_send"
                                        class="ps-btn ps-btn--sm ps-btn--action ps-js-submit">
                                        Send</button>



                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div id="reset_email_confirm_window" class="ps-modal__wrapper" style=" display: none; ">
        <div class="ps-modal__container ps-dialog-container">
            <div class="ps-modal ps-dialog ps-dialog-wide cus_ps_modal_wide">
                <div class="ps-modal__inner">
                    <div class="ps-modal__header ps-dialog-header cus_ps_modal_headre">
                        <div class="ps-modal__title ps-dialog-title">
                            <span>Clear all email</span> <br><span class="cus_ps_modal_headline"></span>
                        </div>
                        <a class="ps-modal__close ps-dialog-close" href="#" onclick="close_confirm_reset_email();"><i
                                class="gcis gci-times"></i></a>
                    </div>
                    <div class="ps-modal__body ps-dialog-body">
                        <div class="ps-modal__content cus_ps_modal_content">

                            <div class="ps-modal__body ps-js-body">
                                <div class="ps-modal__content">
                                    <p>Are you sure you want to clear all?</p>
                                </div>
                                <div class="ps-modal__footer ps-js-footer">
                                    <div class="ps-modal__actions">
                                        <button onclick="close_confirm_reset_email();"
                                            class="ps-btn ps-btn--sm ps-js-cancel">Cancel</button>
                                        <button type="button" onclick="close_confirm_reset_email();reset_email()"
                                            class="ps-btn ps-btn--sm ps-btn--action ps-js-submit">
                                            Yes, Clear all</button>



                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>



<script type="text/javascript" src="<?=get_template_directory_uri()."/assets/cdn/cdn.js";?>"></script>
