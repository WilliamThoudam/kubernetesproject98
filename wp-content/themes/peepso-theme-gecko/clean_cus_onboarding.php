<?php /* Template Name: Clean custom onboarding */ 
$theme_mode = get_user_meta(get_current_user_id(), 'peepso_gecko_user_theme', true);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DOJOKO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">


    <link href="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/bootstrap-datepicker.min.css"
        rel="stylesheet" />
    <link href="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/quill.snow.css" rel="stylesheet" />
    <link rel='stylesheet' href='/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/bootstrap_4_min_css.css'>
    <link rel="stylesheet" href="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/new_onboarding_style.css">

    <link rel="icon" href="/wp-content/uploads/2020/11/Icon-96x96-Desktop-Shortcut.png" sizes="32x32">

</head>

<body id="body" class="<?php if($theme_mode == 'gecko_dark_mode'){echo "gc-preset--gecko_dark_mode";}?>">

    <div id="view_profile_wraper">
        <div class="view_profile" onclick="show_cv_viewer()" id="cv_viewer">
            View Profile
        </div>
    </div>

    <!--PEN HEADER-->
    <header class="header">

        <h1 class="header__title"><a class="custom-logo-link" href="/"><img class="cus_logo_on_bd"
                    src="/wp-content/uploads/2020/12/Dojoko-Beta-Logo-–-Dark.svg" /></a><span id="dynamic_title">All right, let’s start with the basics. </span><span style="display: none" id="display_name"></span></h1>
    </header>
    <!--PEN CONTENT     -->
    <div class="content">
        <!--content inner-->
        <div class="content__inner">
            <div class="container">
                <!--content title-->


            </div>
            <div class="container overflow-hidden">

                <div id="snackbar"></div>
                <!--multisteps-form-->
                <div class="multisteps-form">
                    <!--progress bar-->
                    <div class="row">
                        <div class="col-12 col-lg-12 ml-auto mr-auto mb-4">
                            <div class="multisteps-form__progress">
                                <button class="multisteps-form__progress-btn js-active" id="cus_personal_btn"
                                    type="button" title="Personal Info">Personal
                                    Info</button>
                                <button class="multisteps-form__progress-btn " id="cus_edu_btn" type="button"
                                    title="Education">Education </button>
                                <button class="multisteps-form__progress-btn" id="cus_work_btn" type="button"
                                    title="Work Experience">Work
                                    Experience</button>
                                <button class="multisteps-form__progress-btn" id="cus_skills_btn" type="button"
                                    title="Skills">Skills</button>
                                <button class="multisteps-form__progress-btn" id="cus_interest_btn" type="button"
                                    title="Interests">Interests</button>
                                <button class="multisteps-form__progress-btn" id="cus_award_btn" type="button"
                                    title="Awards & Achievements">Awards &
                                    Achievements</button>
                            </div>
                        </div>
                    </div>
                    <!--form panels-->
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 " id="cus_left_cv_view">
                            <div class="new_cus_card left">
                                <form class="multisteps-form__form" id="onboarding_form">

                                    <!--single form panel personal info start here-->
                                    <div class="multisteps-form__panel   bg-white js-active" data-animation="slideHorz">
                                        <h3 class="multisteps-form__title mb-2  pt-3 pl-3 pr-3 pb-2">Personal Info

                                        </h3>
                                        <div class="multisteps-form__content px-3">
                                            <div class="cus_input_wrapper pb-2">

                                                <div class="cus_input_inside">
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6">
                                                            <label class="cus_field_label cus_mandatory_field">First
                                                                Name</label>
                                                            <input id="form-field-first_name"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="First Name" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label class="cus_field_label cus_mandatory_field">Last
                                                                Name</label>
                                                            <input id="form-field-last_name"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Last Name" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Email</label>
                                                            <input id="form-field-email" readonly
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Email" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6">
                                                            <label class="cus_field_label">Country Code</label>
                                                            <select id="form-field-country_code"
                                                                class="custom-select mr-sm-2 form-control form-control-sm">
                                                                <option value>Select an option</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label class="cus_field_label">Phone</label>
                                                            <input id="form-field-phone"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Phone" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6">
                                                            <label class="cus_field_label">Gender</label>
                                                            <select id="form-field-gender"
                                                                class="custom-select mr-sm-2 form-control form-control-sm">
                                                                <option value="">Select an option...</option>
                                                                <option value="m">Male</option>
                                                                <option value="f">Female</option>
                                                                <option value="option_17_1">Other</option>
                                                                <option value="option_17_2">Prefer not to say</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label class="cus_field_label cus_mandatory_field">Date of
                                                                Birth</label>
                                                            <input id="form-field-dob"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Date of Birth" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label cus_mandatory_field">Current
                                                                Location</label>
                                                            <input id="form-field-current_location"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Current Location" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Previous Location</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-location" type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Previous Location">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            personal_info_locations_json","profile_info_location_chip","form-field-location","location")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="profile_info_location_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Language(s)
                                                                Spoken</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-language" type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Languages Spoken">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm"
                                                                        id="">
                                                                        <button onclick="addChip("
                                                                            personal_info_languages_json","profile_info_language_chip","form-field-language","language")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="profile_info_language_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Intro</label>
                                                            <input id="form-field-headline"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Intro" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">About Me</label>
                                                            <div id="form-field-summary"></div>
                                                            <!-- <textarea  class="multisteps-form__input form-control form-control-sm" type="text"
                              placeholder="Intro"></textarea> -->
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-4">
                                                            <label class="cus_field_label">Social Media</label>
                                                            <select id="form-field-link_type"
                                                                class="custom-select mr-sm-2 form-control form-control-sm">
                                                                <option value="">Select an option...</option>
                                                                <option value="facebook">Facebook</option>
                                                                <option value="twitter">Twitter</option>
                                                                <option value="instagram">Instagram</option>
                                                                <option value="linkedin">LinkedIn</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-sm-8 mb-1">
                                                            <label class="cus_field_label">Link</label>

                                                            <div class="input-group ">
                                                                <input id="form-field-link" type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Link">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="updateSocialMediaLink()"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-12 col-sm-8 ">
                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="profile_info_social_media_chip">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="cus_form_footer_wrapper pt-3 pb-1 pr-3 pl-3">
                                            <div class="button-row cus_flex_button cus_personal_info_btn">
                                                <!-- <button onclick="savePersonalInfo()" class="btn btn-light " type="button" title="Save">Save</button> -->
                                                <button id="personal_info_next" class="btn btn-primary js-btn-next"
                                                    type="button" title="Next">Next</button>
                                            </div>
                                            <a class="cus_skip_to_home_btn pt-1"> &nbsp </a>
                                        </div>

                                    </div>
                                    <!--single form panel personal info end here-->

                                    <!--single form panel education info start here-->
                                    <div class="multisteps-form__panel    bg-white " id="education_form_panel"
                                        data-animation="slideHorz">
                                        <h3 class="multisteps-form__title mb-2  pt-3 pl-3 pr-3 pb-2">Education
                                            <div class="cus_reset_btn"><button onclick="resetEducationForm()"
                                                    class="MuiButtonBase-root MuiButton-root MuiButton-outlined MuiButton-outlinedSecondary MuiButton-outlinedSizeSmall MuiButton-sizeSmall"
                                                    tabindex="0" type="button"><span class="MuiButton-label">Reset <svg
                                                            class="MuiSvgIcon-root" focusable="false"
                                                            viewBox="0 0 24 24" aria-hidden="true">
                                                            <path
                                                                d="M7.11 8.53L5.7 7.11C4.8 8.27 4.24 9.61 4.07 11h2.02c.14-.87.49-1.72 1.02-2.47zM6.09 13H4.07c.17 1.39.72 2.73 1.62 3.89l1.41-1.42c-.52-.75-.87-1.59-1.01-2.47zm1.01 5.32c1.16.9 2.51 1.44 3.9 1.61V17.9c-.87-.15-1.71-.49-2.46-1.03L7.1 18.32zM13 4.07V1L8.45 5.55 13 10V6.09c2.84.48 5 2.94 5 5.91s-2.16 5.43-5 5.91v2.02c3.95-.49 7-3.85 7-7.93s-3.05-7.44-7-7.93z">
                                                            </path>
                                                        </svg></span></button></div>
                                        </h3>
                                        <div class="multisteps-form__content px-3">
                                            <div class="cus_input_wrapper pb-2">
                                                <div class="cus_input_inside">

                                                    <div class="form-row mt-1 mb-3">
                                                        <div class="col-12 ">
                                                            <div id="education_list">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 autocomplete">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Institution
                                                                Name</label>
                                                            <input id="form-field-institution_name"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Institution Name" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0 complete">
                                                            <label class="cus_field_label cus_mandatory_field">Location
                                                                Name</label>
                                                            <input id="form-field-institution_location"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Location (eg. Delhi, India)" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0 autocomplete">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Program</label>
                                                            <input id="form-field-institution_specialisation"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Program" />
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Degree</label>
                                                            <select
                                                                class="custom-select mr-sm-2 form-control form-control-sm"
                                                                id="form-field-institution_degree">
                                                                <option value="">Select</option>
                                                                <option value="High School">High School</option>
                                                                <option value="Secondary School">Secondary School
                                                                </option>
                                                                <option value="Under Graduate">Under Graduate</option>
                                                                <option value="Graduate">Graduate</option>
                                                                <option value="Post Graduate">Post Graduate</option>
                                                                <option value="Doctorate">Doctorate</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label class="cus_field_label cus_mandatory_field">Start
                                                                Date</label>
                                                            <input id="form-field-institution_from_year"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Start Date" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label class="cus_field_label cus_mandatory_field">End
                                                                Date</label>
                                                            <input id="form-field-institution_to_year"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="End Date" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Description</label>
                                                            <div id="form-field-institution_description"></div>
                                                            <!-- <textarea class="multisteps-form__input form-control form-control-sm" type="text"
                              placeholder="Intro"></textarea> -->
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button id="education_btn" onclick="addEducation()"
                                                        class="btn btn-primary add_more_btn" type="button"
                                                        title="Add"></button>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="cus_form_footer_wrapper pt-3 pb-1 pr-3 pl-3">
                                            <div class="button-row cus_flex_button">
                                                <input type="hidden" id="form-field-institution_id" />
                                                <button id="education_prev" class="btn btn-primary js-btn-prev"
                                                    type="button" title="Prev">Back</button>
                                                <!-- <button onclick="addEducation()" id="educationBtn"  class="btn btn-light " type="button" title="Save">Save</button> -->
                                                <button id="education_next" class="btn btn-primary js-btn-next"
                                                    type="button" title="Next">Next</button>
                                            </div>
                                            <a class="cus_skip_to_home_btn pt-1 skip_to_home" href="/">Skip to home</a>
                                        </div>
                                    </div>
                                    <!--single form panel education info end here-->


                                    <!--single form panel work experience info start here-->
                                    <div class="multisteps-form__panel  bg-white " id="education_form_panel"
                                        data-animation="slideHorz">
                                        <h3 class="multisteps-form__title mb-2  pt-3 pl-3 pr-3 pb-2">Work Experience
                                            <div class="cus_reset_btn"><button onclick="resetWorkExperienceForm()"
                                                    class="MuiButtonBase-root MuiButton-root MuiButton-outlined MuiButton-outlinedSecondary MuiButton-outlinedSizeSmall MuiButton-sizeSmall"
                                                    tabindex="0" type="button"><span class="MuiButton-label">Reset <svg
                                                            class="MuiSvgIcon-root" focusable="false"
                                                            viewBox="0 0 24 24" aria-hidden="true">
                                                            <path
                                                                d="M7.11 8.53L5.7 7.11C4.8 8.27 4.24 9.61 4.07 11h2.02c.14-.87.49-1.72 1.02-2.47zM6.09 13H4.07c.17 1.39.72 2.73 1.62 3.89l1.41-1.42c-.52-.75-.87-1.59-1.01-2.47zm1.01 5.32c1.16.9 2.51 1.44 3.9 1.61V17.9c-.87-.15-1.71-.49-2.46-1.03L7.1 18.32zM13 4.07V1L8.45 5.55 13 10V6.09c2.84.48 5 2.94 5 5.91s-2.16 5.43-5 5.91v2.02c3.95-.49 7-3.85 7-7.93s-3.05-7.44-7-7.93z">
                                                            </path>
                                                        </svg></span></button></div>
                                        </h3>
                                        <div class="multisteps-form__content px-3">
                                            <div class="cus_input_wrapper pb-2">
                                                <div class="cus_input_inside">
                                                    <div class="form-row mt-1 mb-3">
                                                        <div class="col-12 ">
                                                            <div id="work_experience_list">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0 autocomplete">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Title</label>
                                                            <input id="form-field-work_experience_title"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Title" />
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Employment
                                                                Type</label>
                                                            <select id="form-field-work_experience_employment_type"
                                                                class="custom-select mr-sm-2 form-control form-control-sm">
                                                                <option value="">Select</option>
                                                                <option value="Part Time">Part Time</option>
                                                                <option value="Full Time">Full Time</option>
                                                                <option value="Internship">Internship</option>
                                                                <option value="Apprenticeship">Apprenticeship</option>
                                                                <option value="Freelance">Freelance</option>
                                                                <option value="Contract">Contract</option>
                                                            </select>


                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 mt-sm-0 autocomplete">
                                                            <label class="cus_field_label cus_mandatory_field">Company
                                                                Name</label>
                                                            <input id="form-field-work_experience_company_name"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Company Name" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0 autocomplete">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Location</label>
                                                            <input id="form-field-work_experience_location"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Location (eg. Delhi, India)" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label class="cus_field_label cus_mandatory_field">From
                                                                Date</label>
                                                            <input id="form-field-work_experience_from_date"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="From Date" />
                                                        </div>
                                                        <div class="col-2 col-sm-2 mt-1 mt-sm-0">
                                                            <label class="cus_field_label "> Current</label>
                                                            <div class="form-check">
                                                                <input id="form-field-work_experience_current"
                                                                    class="form-check-input" type="checkbox"
                                                                    value="current">
                                                                <label class="form-check-label"
                                                                    for="form-field-work_experience_current">

                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-10 col-sm-4 mt-1 mt-sm-0">
                                                            <label class="cus_field_label cus_mandatory_field">To
                                                                Date</label>
                                                            <input id="form-field-work_experience_to_date"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="To Date" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Description</label>
                                                            <div id="form-field-work_experience_description"></div>
                                                            <!-- <textarea class="multisteps-form__input form-control form-control-sm" type="text"
                              placeholder="Intro"></textarea> -->
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button id="work_experience_btn" onclick="addWorkExperience()"
                                                        class="btn btn-primary add_more_btn" type="button"
                                                        title="Add"></button>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="cus_form_footer_wrapper pb-1 pt-3 pr-3 pl-3">
                                            <div class="button-row cus_flex_button">
                                                <input type="hidden" id="form-field-work_experience_id" />
                                                <button id="work_experience_prev" class="btn btn-primary js-btn-prev"
                                                    type="button" title="Prev">Back</button>
                                                <!-- <button id="workExperienceBtn" onclick="addWorkExperience()" class="btn btn-light " type="button" title="Save">Save</button> -->
                                                <button id="work_experience_next" class="btn btn-primary js-btn-next"
                                                    type="button" title="Next">Next</button>
                                            </div>
                                            <a class="cus_skip_to_home_btn pt-1 skip_to_home" href="/">Skip to home</a>
                                        </div>
                                    </div>
                                    <!--single form panel work experience info end here-->


                                    <!--single form panel skills info start here-->
                                    <div class="multisteps-form__panel   bg-white " data-animation="slideHorz">
                                        <h3 class="multisteps-form__title mb-2  pt-3 pl-3 pr-3 pb-2">My Skills

                                        </h3>
                                        <div class="multisteps-form__content px-3">
                                            <div class="cus_input_wrapper pb-2">
                                                <div class="cus_input_inside">
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Technical Skills</label>

                                                            <div class="input-group mb-1 autocomplete">
                                                                <input id="form-field-my_skills_technical" type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Javascript">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            my_skills_technical_json","my_skills_technical_chip","form-field-my_skills_technical","technical_skill")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="my_skills_technical_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Personal Skills</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-my_skills_personal" type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Listener">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            my_skills_personal_json","my_skills_personal_chip","form-field-my_skills_personal","personal_skill")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="my_skills_personal_chip">

                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Hobbies</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-my_skills_hobbies" type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Badminton">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            my_skills_hobbies_json","my_skills_hobbies_chip","form-field-my_skills_hobbies","hobbies")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="my_skills_hobbies_chip">

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <h3 class="multisteps-form__title mb-2 mt-2  pt-3 pl-3 pr-3 pb-2">
                                                        Skills
                                                        I Want to Learn</h3>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Technical Skills</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-skills_i_want_to_learn_technical"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Javascript">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            skills_i_want_to_learn_technical_json","skills_i_want_to_learn_technical_chip","form-field-skills_i_want_to_learn_technical","technical_skill")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="skills_i_want_to_learn_technical_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Personal Skills</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-skills_i_want_to_learn_personal"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Listener">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            skills_i_want_to_learn_personal_json","skills_i_want_to_learn_personal_chip","form-field-skills_i_want_to_learn_personal","personal_skill")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="skills_i_want_to_learn_personal_chip">
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Hobbies</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-skills_i_want_to_learn_hobbies"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Previous Location">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            skills_i_want_to_learn_hobbies_json","skills_i_want_to_learn_hobbies_chip","form-field-skills_i_want_to_learn_hobbies","hobbies")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="skills_i_want_to_learn_hobbies_chip">
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>

                                            </div>

                                        </div>
                                        <div class="cus_form_footer_wrapper pb-1 pt-3 pr-3 pl-3">
                                            <div class="button-row cus_flex_button">
                                                <button id="skills_prev" class="btn btn-primary js-btn-prev"
                                                    type="button" title="Prev">Back</button>
                                                <button id="skills_next" class="btn btn-primary js-btn-next"
                                                    type="button" title="Next">Next</button>
                                            </div>
                                            <a class="cus_skip_to_home_btn pt-1 skip_to_home" href="/">Skip to home</a>
                                        </div>
                                    </div>
                                    <!--single form panel skills info end here-->

                                    <!--single form panel higher education interest info start here-->
                                    <div class="multisteps-form__panel   bg-white " data-animation="slideHorz">
                                        <h3 class="multisteps-form__title mb-2  pt-3 pl-3 pr-3 pb-2">Higher Education
                                            Interest </h3>
                                        <div class="multisteps-form__content px-3">
                                            <div class="cus_input_wrapper pb-2">
                                                <div class="cus_input_inside">
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Location i'm interested
                                                                in</label>

                                                            <div class="input-group mb-1">
                                                                <input
                                                                    id="form-field-higher_education_interests_location"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Location (eg. Delhi, India)">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            higher_education_interests_locations_json","higher_education_interests_location_chip","form-field-higher_education_interests_location","location")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="higher_education_interests_location_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label cus_mandatory_field">Degree
                                                                Type</label>
                                                            <select id="form-field-higher_education_interests_degree"
                                                                class="custom-select mr-sm-2 form-control form-control-sm">
                                                                <option value="">Select</option>
                                                                <option value="High School">High School</option>
                                                                <option value="Secondary School">Secondary School
                                                                </option>
                                                                <option value="Graduate">Graduate</option>
                                                                <option value="Post Graduate">Post Graduate</option>
                                                                <option value="Doctorate">Doctorate</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Specialisations</label>

                                                            <div class="input-group mb-1">
                                                                <input
                                                                    id="form-field-higher_education_interests_specialisation"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Accounting">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            higher_education_interests_specialisations_json","higher_education_interests_specialisation_chip","form-field-higher_education_interests_specialisation","specialisation")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="higher_education_interests_specialisation_chip">
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Universities</label>

                                                            <div class="input-group mb-1">
                                                                <input
                                                                    id="form-field-higher_education_interests_university"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. University Amsterdam">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            higher_education_interests_universities_json","higher_education_interests_university_chip","form-field-higher_education_interests_university","university")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="higher_education_interests_university_chip">

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <h3 class="multisteps-form__title mb-2 mt-2  pt-3 pl-3 pr-3 pb-2">
                                                        Career
                                                        Interest</h3>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Jobs Role</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-career_interests_job_role"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Business Developer">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            career_interests_job_role_json","career_interests_job_role_chip","form-field-career_interests_job_role","job_role")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="career_interests_job_role_chip">

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12 autocomplete">
                                                            <label class="cus_field_label">Location I'm interested
                                                                in</label>

                                                            <div class="input-group mb-1">
                                                                <input id="form-field-career_interests_location"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Location (eg. Delhi, India)">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            career_interests_locations_json","career_interests_location_chip","form-field-career_interests_location","location")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="career_interests_location_chip">
                                                            </div>

                                                        </div>
                                                    </div>


                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Industries</label>

                                                            <div class="input-group mb-1 autocomplete">
                                                                <input id="form-field-career_interests_industry"
                                                                    type="text"
                                                                    class="multisteps-form__input form-control form-control-sm"
                                                                    placeholder="Ex. Education">
                                                                <div class="input-group-prepend">
                                                                    <span
                                                                        class="input-group-text cus_apend_btn form-control-sm">
                                                                        <button onclick="addChip("
                                                                            career_interests_industries_json","career_interests_industry_chip","form-field-career_interests_industry","industry")"
                                                                            class="cus_apend_btn_inner" type="button">
                                                                            +
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="career_interests_industry_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Types of Works</label>
                                                            <select id="form-field-career_interests_type_of_work"
                                                                class="custom-select mr-sm-2 form-control form-control-sm">
                                                                <option value="">Select</option>
                                                                <option value="Part Time">Part Time</option>
                                                                <option value="Full Time">Full Time</option>
                                                                <option value="Internship">Internship</option>
                                                                <option value="Apprenticeship">Apprenticeship</option>
                                                                <option value="Freelance">Freelance</option>
                                                                <option value="Contract">Contract</option>
                                                            </select>

                                                            <!-- custom chip  -->
                                                            <div class="cus_chip_div" style="position:relative"
                                                                id="career_interests_type_of_work_chip">
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>
                                        <div class="cus_form_footer_wrapper pb-1 pt-3 pr-3 pl-3">
                                            <div class="button-row cus_flex_button">
                                                <button id="interests_prev" class="btn btn-primary js-btn-prev"
                                                    type="button" title="Prev">Back</button>
                                                <button id="interests_next" class="btn btn-primary js-btn-next"
                                                    type="button" title="Next">Next</button>
                                            </div>
                                            <a class="cus_skip_to_home_btn pt-1 skip_to_home" href="/">Skip to home</a>
                                        </div>
                                    </div>
                                    <!--single form panel higher education interest info end here-->

                                    <!--single form panel awards and achievements info start here-->
                                    <div class="multisteps-form__panel    bg-white " id="education_form_panel"
                                        data-animation="slideHorz">
                                        <h3 class="multisteps-form__title mb-2  pt-3 pl-3 pr-3 pb-2">Awards &
                                            Achievements
                                            <div class="cus_reset_btn"><button onclick="resetAwardAchievementForm()"
                                                    class="MuiButtonBase-root MuiButton-root MuiButton-outlined MuiButton-outlinedSecondary MuiButton-outlinedSizeSmall MuiButton-sizeSmall"
                                                    tabindex="0" type="button"><span class="MuiButton-label">Reset <svg
                                                            class="MuiSvgIcon-root" focusable="false"
                                                            viewBox="0 0 24 24" aria-hidden="true">
                                                            <path
                                                                d="M7.11 8.53L5.7 7.11C4.8 8.27 4.24 9.61 4.07 11h2.02c.14-.87.49-1.72 1.02-2.47zM6.09 13H4.07c.17 1.39.72 2.73 1.62 3.89l1.41-1.42c-.52-.75-.87-1.59-1.01-2.47zm1.01 5.32c1.16.9 2.51 1.44 3.9 1.61V17.9c-.87-.15-1.71-.49-2.46-1.03L7.1 18.32zM13 4.07V1L8.45 5.55 13 10V6.09c2.84.48 5 2.94 5 5.91s-2.16 5.43-5 5.91v2.02c3.95-.49 7-3.85 7-7.93s-3.05-7.44-7-7.93z">
                                                            </path>
                                                        </svg></span></button></div>
                                        </h3>
                                        <div class="multisteps-form__content px-3">
                                            <div class="cus_input_wrapper pb-2 ">
                                                <div class="cus_input_inside">
                                                    <div class="form-row mt-1 mb-3">
                                                        <div class="col-12 ">
                                                            <div id="award_achievement_list">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Title</label>
                                                            <input id="form-field-award_achievement_title"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Title" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0 autocomplete">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Institution</label>
                                                            <input id="form-field-award_achievement_awarded_by"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Institution Name" />
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-6">
                                                            <label class="cus_field_label cus_mandatory_field">Issue
                                                                Date</label>
                                                            <input id="form-field-award_achievement_issue_date"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Issue Date" />
                                                        </div>
                                                        <div class="col-12 col-sm-6 mt-1 mt-sm-0">
                                                            <label
                                                                class="cus_field_label cus_mandatory_field">Link</label>
                                                            <input id="form-field-award_achievement_link"
                                                                class="multisteps-form__input form-control form-control-sm"
                                                                type="text" placeholder="Link" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row mt-1">
                                                        <div class="col-12 col-sm-12">
                                                            <label class="cus_field_label">Description</label>
                                                            <div id="form-field-award_achievement_description"></div>
                                                            <!-- <textarea class="multisteps-form__input form-control form-control-sm" type="text"
                           placeholder="Intro"></textarea> -->
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button id="award_achievement_btn" onclick="addAwardAchievement()"
                                                        class="btn btn-primary add_more_btn" type="button"
                                                        title="Add"></button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="cus_form_footer_wrapper pb-1 pt-3 pr-3 pl-3">
                                            <div class="button-row cus_flex_button">
                                                <input type="hidden" id="form-field-award_achievement_id" />
                                                <button id="award_achievement_prev" class="btn btn-primary js-btn-prev"
                                                    type="button" title="Prev">Back</button>
                                                <!-- <button id="awardAchievementBtn" onclick="addAwardAchievement()" class="btn btn-light " type="button" title="Save">Save</button> -->
                                                <button id="award_achievement_finish"
                                                    class="btn btn-primary js-btn-next" type="button"
                                                    title="Next">Finish</button>
                                            </div>
                                            <a class="cus_skip_to_home_btn pt-1 skip_to_home" href="/">Skip to home</a>
                                        </div>
                                    </div>
                                    <!--single form panel awards and achievements info end here-->

                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-md-6" id="cus_right_cv_view">

                            <div class="new_cus_card right" id="new_cus_card_right">
                                <div class="cv_main_container" id="content">

                                    <div style="display:block; page-break-inside: avoid;">
                                        <div id="cv_heading_id" class="cv_heading" style="text-align:left">
                                            <div class="cv_heading_wrapper_cus">
                                                <h3 class="cv_heading_title" id="cv_heading_title"
                                                    style="display:inline-block">
                                                </h3>



                                                <!--<button id="extract" onclick="open_download_info_message()" >Download</button> -->

                                                <div id="extract" class="new_extract"
                                                    style="float:right; margin: 7px 18px 0px 0px; cursor: pointer; width: 28px; height: 28px; border-radius: 50%; text-align: center; background: #FF4081;display:flex; padding-top: 2px; justify-content: center; align-items: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="16"
                                                        height="20" viewBox="0 0 36.99 29.52">
                                                        <defs>
                                                            <clipPath>
                                                                <rect width="36.99" height="29.52" />
                                                            </clipPath>
                                                        </defs>
                                                        <g clip-path="url(#clip-Download)">
                                                            <path fill="#ffffff" id="Add_to_download"
                                                                data-name="Add to download"
                                                                d="M17.681,26.412a1.385,1.385,0,0,0,.485.3,1.435,1.435,0,0,0,.567.118c.048,0,.09-.022.14-.026a1.425,1.425,0,0,0,1-.391L31.149,15.659a1.28,1.28,0,0,0,0-1.876,1.441,1.441,0,0,0-1.97,0L20.134,22.4V4.389a1.4,1.4,0,0,0-2.785,0V22.338L8.367,13.789a1.443,1.443,0,0,0-1.97,0,1.282,1.282,0,0,0,0,1.876ZM35.85,23.047A1.391,1.391,0,0,0,34.427,24.4V28.61A1.391,1.391,0,0,1,33,29.965H4.543A1.391,1.391,0,0,1,3.12,28.61V24.4a1.423,1.423,0,0,0-2.844,0V28.61a4.174,4.174,0,0,0,4.266,4.066H33a4.174,4.174,0,0,0,4.266-4.066V24.4a1.391,1.391,0,0,0-1.415-1.357Z"
                                                                transform="translate(-0.277 -3.156)" fill="#818181" />
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="cus_mob_em_wrapper">
                                                <p class="cv_subheading_title" id="cv_subheading_title">
                                                </p>
                                                <span class="new_cv_email_phone">
                                                    <span id="new_cv_email"></span>
                                                    <br>
                                                    <span id="new_cv_phone"></span>
                                                </span>
                                            </div>

                                        </div>

                                        <div class="cv_body_wrapper" id="cv_body_wrapper_id">

                                            <div class="cv_content_left" id="cv_content_left">
                                                <h3 class="cv_section_heading">
                                                    About Me
                                                </h3>

                                                <p class="cv_section_desc ql-editor" style="padding:0px; height:auto"
                                                    id="cv_summary">

                                                </p>

                                                <hr>
                                                <div hidden>
                                                    <h3 class="cv_section_heading">
                                                        User Profile Type
                                                    </h3>

                                                    <p class="cv_chip_wrapper" style="display:grid"
                                                        id="cv_user_profile_type">

                                                    </p>

                                                    <hr>
                                                </div>

                                                <div hidden>>
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
                                                </div>


                                                <p class="cv_section_desc">
                                                <h3 class="cv_section_heading">
                                                    Education
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


                                                <div class="cv_content_left_footer" id="cv_content_left_footer_id">
                                                    <p style="display:inline-block">Generated by dojoko.com </p>
                                                </div>

                                            </div>

                                            <div class="cv_content_right" id="cv_content_right">

                                                <p class="cv_section_desc">
                                                <h3 class="cv_section_heading">
                                                    Location
                                                </h3>
                                                <div class="cv_chip_wrapper">
                                                    <p class="cv_section_desc" id="cv_profile_info_current_location">
                                                    </p>
                                                </div>
                                                </p>

                                                <hr>

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

                                                <h3 class="cv_section_heading" id="cv_career_interests">
                                                    Career Interests
                                                </h3>

                                                <p class="cv_section_desc">
                                                    <span style="font-size:12px">Job Roles</span>
                                                <div class="cv_chip_wrapper" id="cv_career_interests_job_role_chip">

                                                </div>
                                                </p>
                                                <br>


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
        </div>
    </div>




    <!-- START MODAL POP UP AND LOADER -->



    <div id="popup1" class="overlay" style="opacity:0;visibility:hidden">
        <div class="popup">
            <h2 id="co_candidate_name"></h2>



            <div class="content">
                <img class="popup_dojoko_logo" src="/wp-content/uploads/2020/11/Icon-96x96-Desktop-Shortcut.png" />
                <h3 class="popup_heading"><span style="font-size:inherit;" id="popup_fullname"></span></h3>
                <p class="popup_desc">Welcome to Dojoko <span id="popup_firstname" style="font-size:inherit;"></span>!
                    Completing your profile helps us connect you to more people,
                    content and opportunities!</p>

                <!--Test William HTML #WWWWWWW-->

                <a class="cus_close" onclick="close_summernote()">Let's go!</a>
                <div hidden>
                    <a class="do_it_later" id="do_it_later" href="/">I'll do it later</a>
                </div>

            </div>
        </div>
    </div>

    <div id="download_info_message" class="overlay" style="opacity:0;visibility:hidden">
        <div class="popup">
            <h2 id=""></h2>

            <div class="content">

                <h3 class="popup_heading" style="padding-left: 0px; text-align: center">Are you sure ?</h3>
                <p class="beta_info_desc" style="text-align: center" id="download_msg"></p>

                <a class="cus_close" onclick="close_download_info_message()">No</a>
                <a id="yes_download" class="do_it_later">Yes</a>
            </div>
        </div>
    </div>

    <!-- William Test -->

    <div id="cv_empty_message" class="overlay" style="opacity:0;visibility:hidden">
        <div class="popup">
            <h2 id=""></h2>

            <div class="content">

                <h3 class="popup_heading" style="padding-left: 0px; text-align: center">Are you sure ?</h3>
                <p class="beta_info_desc" style="text-align: center">We encourage you to complete your profile so you
                    can be matched to more people and opportunities.</p>

                <a class="do_it_later" href="/">Skip</a>
                <a class="cus_close" onclick="close_cv_empty_message()">Cancel</a>

            </div>
        </div>
    </div>

    <div id="cvPreviewPopUp" class="overlay" style="opacity:0;visibility:hidden">
        <div class="popup">
            <h2 id=""></h2>

            <div class="content">
                <div id="cvPreview"></div>
                <a class="cus_close" onclick="close_cvPreviewPopUp()">Close</a>
                <a class="do_it_later" id="do_it_later" href="/">Go to home</a>
            </div>
        </div>
    </div>



    <div class="flexbox" style="display:flex;">

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
                <img class="ps-loading" src="/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt="">
            </div>
        </div>

    </div>




    <!-- END MODAL POP UP AND LOADER -->




</body>
<script>
if (document.getElementById('body').classList.contains('gc-preset--gecko_dark_mode')) {

    var element = document.getElementsByClassName("multisteps-form__panel");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_multisteps-form__panel");
    });

    var element = document.getElementsByClassName("cus_field_label");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cus_field_label");
    });

    var element = document.getElementsByClassName("cv_content_left_footer");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cv_content_left_footer");
    });


    var element = document.getElementsByClassName("cus_chip_div");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cus_chip_div");
    });

    var element = document.getElementsByClassName("multisteps-form__progress-btn");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_multisteps-form__progress-btn");
    });

    var element = document.getElementsByClassName("multisteps-form__title");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_multisteps-form__title");
    });

    var element = document.getElementsByClassName("cus_form_footer_wrapper");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cus_form_footer_wrapper");
    });

    var element = document.getElementsByClassName("flexbox");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_flexbox");
    });

    var element = document.getElementsByClassName("popup");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_popup");
    });

    var element = document.querySelectorAll("input[type=submit]");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_input_submit");
    });

    var element = document.querySelectorAll("input[type=text]");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_input_text");
    });

    var element = document.querySelectorAll("input[type=email]");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_input_text");
    });

    var element = document.querySelectorAll("select");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_input_select");
    });

    var element = document.querySelectorAll("textarea");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_input_textarea");
    });


    var element = document.getElementsByClassName("cv_main_container");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cv_main_container");
    });


    var element = document.getElementsByClassName("cv_content_right");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cv_content_right");
    });


    var element = document.getElementsByClassName("dialog-message");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_dialog-message");
    });


    var element = document.getElementsByClassName("cv_section_heading");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cv_section_heading");
    });

    var element = document.getElementsByClassName("cv_heading");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cv_heading");
    });


    var element = document.getElementsByClassName("view_profile");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_view_profile");
    });


    var element = document.getElementsByClassName("complete");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_complete");
    });

    var element = document.getElementsByClassName("autocomplete");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_autocomplete");
    });



}
</script>

</html>

<script src="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/jquery.min.js"></script>
<script src="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/bootstrap-datepicker.min.js"></script>
<script src="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/quill.js"></script>
<!-- <script src="/wp-content/themes/peepso-theme-gecko/assets/js/jspdf.js"></script>
<script src="/wp-content/themes/peepso-theme-gecko/assets/js/html2canvas.js"></script> -->
<script src="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/html2pdf.bundle.js"></script>
<script type="text/javascript"
    src="/wp-content/themes/peepso-theme-gecko/assets/onboardingv2/onboarding_custome_ajax_function_new.js"></script>