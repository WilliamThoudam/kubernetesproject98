

window.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#dojokoEmoji');

    const picker = new EmojiButton({
        showAnimation: false,
        autoHide: false,
        showSearch: true,
        emojiSize: '24px',
        recentsCount: 5,
        zIndex: 999,
        theme: 'auto',
        emojisPerRow: 5,
        style: 'native'
    });
    picker.on('emoji', emoji => {
        document.querySelector('.ps-postbox-textarea').value += emoji;
    });
    button.addEventListener('click', () => {
        picker.togglePicker(button);
    });
});

window.addEventListener('load', function (){
    var theme_stored,color_theme;
    theme_stored = document.getElementById("dojoko_user_theme").value;
    if(theme_stored == 'gecko_light_rj_1')
    {
    color_theme = '<i class="dojokoIcoMoon"></i>Dark Mode';
    }
    else
    {
    color_theme = '<i class="dojokolight"></i>Light Mode';
    }
    document.getElementById("color_theme").innerHTML = color_theme;
});

window.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#color_theme');
    button.onclick=function()
    {
    var user_theme, user_id;
    user_id = document.getElementById("dojoko_user_id").value;
    user_theme = document.getElementById("dojoko_user_theme").value;
    var meta_key = 'peepso_gecko_user_theme';

    if(user_theme == 'gecko_light_rj_1')
    {
        color = 'gecko_dark_mode'
    }
    else if(user_theme == 'gecko_dark_mode')
    {
        color = 'gecko_light_rj_1'
    }
    else
    {
        color = (user_theme == 'gecko_light_rj_1') ? 'gecko_light_rj_1' : 'gecko_dark_mode';
    }

    jQuery.ajax({
    type: "POST",
    data: {user_id:user_id, view_user_id:user_id, meta_key:meta_key, value:color},
    url: "/peepsoajax/profilepreferencesajax.savepreference",
    success: function(data){
        location.reload();
        }
    });
    }
});


window.onload = function() {
    var location_host = window.location.host;
    var location = window.location.href;
    if (String(location).includes("/community-photos/")) {
        var element = document.getElementById("dj_explore");
        element.classList.add("active");



    }

    if (String(location).includes(location_host + "/members/")) {
        var element = document.getElementById("dj_network");
        element.classList.add("active");

        var element = document.getElementById("custom_html-22");
        element.style.display = "block";

        people_you_might_know();

    }

    if (String(location).includes(location_host + "/similarities/")) {
        var element = document.getElementById("dj_network");
        element.classList.add("active");

        var element = document.getElementById("custom_html-22");
        element.style.display = "block";

        var current_login_username = document.getElementById("cus_current_username").value;

        document.getElementById("similarities_my_connects").setAttribute("href", "/profile/?" +
            current_login_username + "/friends");

        people_you_might_know();
    }


    if (String(location).includes("/community-videos/")) {
        var element = document.getElementById("dj_explore");
        element.classList.add("active");

    }

    if (String(location).includes("/forums/")) {
        var element = document.getElementById("dj_forums");
        element.classList.add("active");

        var element = document.getElementById("wpforo_widget_tags-2");
        element.style.display = "block";
        var element = document.getElementById("wpforo_widget_recent_replies-2");
        element.style.display = "block";

        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";

    }



    if (String(location).includes("/groups/")) {


        var element = document.getElementById("dj_groups");
        element.classList.add("active");



        var element = document.getElementById("elementor-library-9");
        element.style.display = "block";


        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";

        var element = document.getElementById('group_wrapper_id');
        element.classList.add("cus_ps_focus_menu");
        setTimeout(
            function() {
                element.style.background = "#fff !important";
            }, 2000);


    }



    if (String(location).includes("/events/")) {
        var element = document.getElementById("dj_events");
        element.classList.add("active");

        var element = document.getElementById("widget_upcoming_events-5");
        element.style.display = "block";

        var element = document.getElementById("widget_recent_events-3");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-15");
        element.style.display = "block";



        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


        var element = document.getElementById("peepsowidgetsearch-10");
        element.style.display = "none";

    }

    if (String(location).includes("/event-venue/")) {
        var element = document.getElementById("dj_events");
        element.classList.add("active");

        var element = document.getElementById("widget_upcoming_events-5");
        element.style.display = "block";

        var element = document.getElementById("widget_recent_events-3");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-15");
        element.style.display = "block";




        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


        var element = document.getElementById("peepsowidgetsearch-10");
        element.style.display = "none";

    }

    if (String(location).includes("/event-organizer/")) {
        var element = document.getElementById("dj_events");
        element.classList.add("active");

        var element = document.getElementById("widget_upcoming_events-5");
        element.style.display = "block";

        var element = document.getElementById("widget_recent_events-3");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-15");
        element.style.display = "block";



        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


        var element = document.getElementById("peepsowidgetsearch-10");
        element.style.display = "none";

    }

    if (String(location).includes("/event_listing_category/")) {
        var element = document.getElementById("dj_events");
        element.classList.add("active");

        var element = document.getElementById("widget_upcoming_events-5");
        element.style.display = "block";

        var element = document.getElementById("widget_recent_events-3");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-15");
        element.style.display = "block";



        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


        var element = document.getElementById("peepsowidgetsearch-10");
        element.style.display = "none";

    }

    if (String(location).includes("/event_listing_type/")) {
        var element = document.getElementById("dj_events");
        element.classList.add("active");

        var element = document.getElementById("widget_upcoming_events-5");
        element.style.display = "block";

        var element = document.getElementById("widget_recent_events-3");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-15");
        element.style.display = "block";



        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


        var element = document.getElementById("peepsowidgetsearch-10");
        element.style.display = "none";

    }

    if (String(location).includes("/dwqa-questions/")) {
        var element = document.getElementById("dj_forums");
        element.classList.add("active");

        var element = document.getElementById("custom_html-17");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-13");
        element.style.display = "block";

        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";

    }






    if (String(location).includes("/forums/")) {
        var element = document.getElementById("dj_forums");
        element.classList.add("active");

        //var element = document.getElementById("custom_html-17");
        //  element.style.display = "block";

        // var element = document.getElementById("elementor-library-13");
        // element.style.display = "block";

        //var element = document.getElementById("peepsowidgetonlinemembers-7");
        // element.style.display = "none";
        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


    }

    if (String(location).includes("/dwqa-ask-question/")) {
        var element = document.getElementById("dj_forums");
        element.classList.add("active");
        var element = document.getElementById("custom_html-17");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-13");
        element.style.display = "block";




        var element = document.getElementById("peepsowidgetonlinemembers-7");
        element.style.display = "none";
        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


    }

    if (String(location).includes("/question/")) {
        var element = document.getElementById("dj_forums");
        element.classList.add("active");
        var element = document.getElementById("custom_html-17");
        element.style.display = "block";

        var element = document.getElementById("elementor-library-13");
        element.style.display = "block";




        var element = document.getElementById("peepsowidgetonlinemembers-7");
        element.style.display = "none";
        var element = document.getElementById("peepsowidgetfriends-5");
        element.style.display = "none";


    }





    if (String(location).includes(window.location.origin + "/messages/")) {
        var element = document.getElementById("dj_messages");
        element.classList.add("active");
    }


    if (String(location).includes("/advert")) {
        var element = document.getElementById("custom_html-5");
        element.style.display = "none";



        var element = document.getElementById("wpadverts-widget-categories-3");
        element.style.display = "block";



        var element = document.getElementById("dj_events");
        element.classList.add("active");

    }

    if (String(location) == window.location.origin + "/#") {


        var element = document.getElementById("dj_home");
        element.classList.add("active");


        var element = document.getElementById("custom_html-22");
        element.style.display = "block";
        people_you_might_know();

    }
    if (String(location) == window.location.origin + "/") {


        var element = document.getElementById("dj_home");
        element.classList.add("active");


        var element = document.getElementById("custom_html-22");
        element.style.display = "block";

        people_you_might_know();


    }


    if (String(location).includes("/explore/")) {

        var element = document.getElementById("dj_explore");
        element.classList.add("active");

        var element = document.getElementById("custom_html-22");
        element.style.display = "block";

        people_you_might_know();

    }


    if (String(location).includes("/about-us/")) {

        var element = document.getElementById("aboutus");
        element.classList.add("active");

    }

    if (String(location).includes(location_host + "/groups/") && String(location).includes("/messages/") ) {
        var element = document.getElementById("cus_msg_tab");
        element.classList.add("ps-focus__menu-item--active");
    }

    if (String(location).includes(location_host + "/groups/") && String(location).includes("/channels/") ) {
        var element = document.getElementById("cus_group_channel_tab");
        element.classList.add("ps-focus__menu-item--active");
    }


    if (String(location).includes(location_host + "/forums/activity/") ) {
        var element = document.getElementsByClassName("menu-item-6139");
        Object.keys(element).forEach(function(key) {
        element[key].classList.remove("wpforo-active");
        });
    }

};



document.getElementById("form-field-field_628641d").addEventListener("change", changet_text);

function changet_text() {
    var ele = document.getElementById("form-field-field_628641d");
    if (ele.value != "") {
        ele.style.color = '#FF4081';
       // alert("hello2");
    } else {
        ele.style.color = 'transparent';
      //  alert("hello");
    }
}


var login_username = document.getElementById("cus_username").value;

var location2 = window.location.href;
var name1 = location2.split('?')[1];
if(name1 === undefined){
}else{
    var name2 = name1.split('/')[0];
var username = name2;
}

function cus_user_bio_check() {
    if (login_username.toLowerCase() === username.toLowerCase()) {
        var onboarding_link = "/onboarding/?from=resume";

        window.location.replace(onboarding_link);
    } else {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = window.location.origin+"/wp-content/themes/peepso-theme-gecko/assets/js/viewing_someone_cv_ajax_function.js";
        document.getElementById("onboarding_ajax_function_link").appendChild(script);
        setTimeout(function() {
            calling_cv_data()
        }, 500);
    }
}

function close_cus_modal() {
    var element = document.getElementById("cus_ps-window");
    element.style.display = "none";
    document.getElementById("onboarding_ajax_function_link").innerHTML = '';
}


cus_flag = 0;

function cus_event_filter_show() {
    if (cus_flag == 0) {
        var element = document.getElementById("event_filters");
        element.style.display = "block";
        cus_flag = 1;

        var element = document.getElementById("cus_filter_id");
        element.style.background = "#00acc1";
        element.style.color = "#ffffff";

    } else {
        var element = document.getElementById("event_filters");
        element.style.display = "none";
        cus_flag = 0;

        var element = document.getElementById("cus_filter_id");
        element.style.background = "#ffffff";
        element.style.color = "#00acc1";
    }
}


//  document.getElementById("wpem-modal-close").innerHTML = "";



function show_interest(user_id) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);


            document.getElementById("cus_com_profile_type").innerHTML = '';
            document.getElementById("cus_com_educations").innerHTML = '';
            //document.getElementById("cus_com_interests").innerHTML = '';
            document.getElementById("cus_com_languages").innerHTML = '';
            document.getElementById("cus_com_careers").innerHTML = '';
            document.getElementById("cus_com_skills").innerHTML = '';
            document.getElementById("cus_com_locations").innerHTML = '';

            obj['compare_user_info']['profile_type'] ? document.getElementById("cus_com_profile_type").innerHTML = `Profile type - ` + obj['compare_user_info']['profile_type'] : '';

            for (const [key, value] of Object.entries(obj.common_educations)) {
                document.getElementById("cus_com_educations").insertAdjacentHTML('beforeend',
                    `<span class="cus_common_item" > ` + value + `</span>`);
            }

            // for (const [key, value] of Object.entries(obj.common_interests)) {
            //     document.getElementById("cus_com_interests").insertAdjacentHTML('beforeend',
            //         `<span class="cus_common_item" > ` + value + `</span>`);
            // }

            for (const [key, value] of Object.entries(obj.common_languages)) {
                document.getElementById("cus_com_languages").insertAdjacentHTML('beforeend',
                    `<span class="cus_common_item" > ` + value + `</span>`);
            }

            for (const [key, value] of Object.entries(obj.common_careers)) {
                document.getElementById("cus_com_careers").insertAdjacentHTML('beforeend',
                    `<span class="cus_common_item" > ` + value + `</span>`);
            }

            for (const [key, value] of Object.entries(obj.common_skills)) {
                document.getElementById("cus_com_skills").insertAdjacentHTML('beforeend',
                    `<span class="cus_common_item" > ` + value + `</span>`);
            }

            for (const [key, value] of Object.entries(obj.common_locations)) {
                document.getElementById("cus_com_locations").insertAdjacentHTML('beforeend',
                    `<span class="cus_common_item" > ` + value.city + `, ` + value.country + `</span>`);
            }


            var element = document.getElementById("common_educations_wr");
            element.style.display = 'block';

            // var element = document.getElementById("common_interests_wr");
            // element.style.display = 'block';

            var element = document.getElementById("cus_com_languages_wr");
            element.style.display = 'block';

            var element = document.getElementById("cus_com_careers_wr");
            element.style.display = 'block';

            var element = document.getElementById("cus_com_skills_wr");
            element.style.display = 'block';

            var element = document.getElementById("cus_com_locations_wr");
            element.style.display = 'block';



            if (obj.common_educations == "") {
                var element = document.getElementById("common_educations_wr");
                element.style.display = 'none';
            }
            // if (obj.common_interests == "") {
            //     var element = document.getElementById("common_interests_wr");
            //     element.style.display = 'none';
            // }
            if (obj.common_languages == "") {
                var element = document.getElementById("cus_com_languages_wr");
                element.style.display = 'none';
            }
            if (obj.common_languages == "") {
                var element = document.getElementById("cus_com_careers_wr");
                element.style.display = 'none';
            }
            if (obj.common_skills == "") {
                var element = document.getElementById("cus_com_skills_wr");
                element.style.display = 'none';
            }
            if (obj.common_locations == "") {
                var element = document.getElementById("cus_com_locations_wr");
                element.style.display = 'none';
            }



            document.getElementById("cus_com_full_name").innerHTML = obj['compare_user_info']['fullname'];

            document.getElementById("similarities_msg").innerHTML = obj['common_record_found'] +
                ' Similarities Found.';

            var element = document.getElementById("cus_com_modalbox");
            element.style.display = 'block';

            if (obj.common_educations.length + obj.common_careers.length + obj.common_languages.length + obj.common_skills.length + obj
                .common_locations.length == 0) {
                document.getElementById("similarities_msg").innerHTML =
                    'No similarities found. Please check user profile.';
            }
        }
    };
    xhttp.open("GET", window.location.origin + "/wp-content/themes/peepso-theme-gecko/api_js.php?compare_user_id=" +
        user_id, true);
    xhttp.send();
}

function close_cus_com_modalbox() {
    var element = document.getElementById("cus_com_modalbox");
    element.style.display = 'none';
}



function people_you_might_know() {
    var login_userid = document.getElementById("cus_userid").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);

            var cus_flag = 0;
            var cu_flag = 0;
            for (const [key, value] of Object.entries(obj.matched_member_id)) {
                var cu_flag = 1;

                if (cus_flag < 5) {
                    if (obj.mutual_friends_count[key]) {
                        var mutual_friends_count_html =
                            `<a class="ps-friends__mutual" href="#" onclick="psfriends.show_mutual_friends(` +
                            login_userid + `, ` + obj.matched_member_id[key] +
                            `); return false;"><i class="gcis gci-user-friends"></i>` + obj.mutual_friends_count[
                                key] + ` mutual connects</a>`;
                    } else {
                        var mutual_friends_count_html = '';
                    }


                    if (obj.is_requested[key]) {
                        var connect_button =
                            `<a href="#" class="ps-member__action ps-member__action--cancel ps-focus__cover-action ps-js-friend-cancel-request" data-user-id="` +
                        obj.matched_member_id[key] + `" data-request-id="` + obj.requested_id[key] + `" onclick="">
                    <span>Withdraw Request</span>
                    <img class="ps-loading" src="` + window.location.origin + `/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt="" style="display: none"></a>`;
                    } else {
                        var connect_button = `<a href="#" class="cus_ps_member_action_a ps-member__action ps-member__action--add ps-focus__cover-action ps-js-friend-send-request" data-user-id="` +
                        obj.matched_member_id[key] + `" onclick="">
                    <span>Connect</span>
                    <img class="ps-loading" src="` + window.location.origin + `/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt="" style="display: none">	</a>`;
                    }



                    document.getElementById("cus_similarities_pymk_user_card").insertAdjacentHTML('beforeend', `<div class="block">
<a href="` + obj.matched_profile[key] + `"><img class="cus_u_profile" src="` + obj.matched_avatar[key] +
                        `" onerror="this.src='` + window.location.origin +
                        `/wp-content/plugins/peepso-core/assets/images/avatar/user-neutral.png';" alt="` + obj
                        .matched_full_name[key] + `"> </a>
  <a href="` + obj.matched_profile[key] + `"><h2>` + obj.matched_full_name[key] + `</h2></a>
` + mutual_friends_count_html + `
</div>
  <div class=" btn-group" style="width:100%">
<button class="right" onclick="show_interest(` + obj.matched_member_id[key] + `)"><img  class="thunder_button_icon" src="https://s3.ap-south-1.amazonaws.com/cdn.dojoko.com/assets/magnet.svg" /><span class="cus_cum_text">Common Interests</span></button>
</div>
<div class="cus_pymk_member_card ps-member ps-js-member" data-user-id="` + obj.matched_member_id[key] + `">
        <div class="ps-member__inner">
            <div class="ps-member__body cus_member_body" id="cus_pymk_body" >
                <div class="ps-member__details"></div>
                <div class="ps-member__buttons cus_connect_button ps-js-member-actions-extra" data-user-id="` + obj
                        .matched_member_id[key] +
                        `">
                        `+ connect_button +`
                </div>
            </div>
        </div>
</div><hr>`);

                    cus_flag++;
                }
            }

            if (cu_flag == 0) {
                var element = document.getElementById("custom_html-22");
                element.style.display = "none";
            }

        }
    };
    xhttp.open("GET", window.location.origin + "/wp-content/themes/peepso-theme-gecko/api_js.php?user_id=" +
        login_userid, true);

    // Added timeout
    xhttp.timeout = 5000; // time in milliseconds
    xhttp.ontimeout = function (e) {
    //alert("Similarities api call time out!");
    };
    // Added timeout

    xhttp.send();
}


if (document.getElementById('body').classList.contains('gc-preset--gecko_dark_mode')) {


    var element = document.getElementsByClassName("gc-widget__title");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_widget_title");
    });



    var element = document.getElementsByClassName("psw-profile__header");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_profile__header");
    });


    var element = document.getElementsByClassName("psw-profile__menu-item");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_profile__header");
    });



    var element = document.getElementsByClassName("ps-notif__bubble");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_notif_bubble");
    });




    var element = document.getElementsByClassName("ps-modal__header");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_ps-modal__header");
    });

    var element = document.getElementsByClassName("cus_common_item");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cus_common_item");
    });

    var element = document.getElementsByClassName("elementor-form");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_elementor-form");
    });

    var element = document.getElementsByClassName("elementor-button");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_elementor-button");
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


    var element = document.getElementsByClassName("wpf-head-bar");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpf-head-bar");
    });


    var element = document.getElementsByClassName("wpf-content");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpf-content");
    });


    var element = document.getElementsByClassName("wpf-content-foot");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpf-content-foot");
    });

    var element = document.getElementsByClassName("wpf-action");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpf-action");
    });


    var element = document.getElementsByClassName("wpf-post-create");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpf-post-create");
    });


    var element = document.getElementsByClassName("mce-content-body");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_mce-content-body");
    });



    var element = document.getElementsByClassName("wpforo-topic-footer");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpforo-topic-footer");
    });


    var element = document.getElementsByClassName("wpf-reply-form-title");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpf-reply-form-title");
    });

    var element = document.querySelectorAll("input[type=submit]");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_input_submit");
    });

    var element = document.getElementsByClassName("fixed-bottom-menu");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_fixed-bottom-menu");
    });


    var element = document.getElementsByClassName("gc-modal--menu");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_gc-modal--menu");
    });

    var element = document.getElementsByClassName("wpforo-post-head");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpforo-post-head");
    });


    var element = document.getElementsByClassName("cus_reply_btn");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_cus_reply_btn");
    });

    var element = document.getElementsByClassName("wpfbg-9");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_wpfbg-9");
    });


    var element = document.getElementsByClassName("ps-poll__item-fill");
    Object.keys(element).forEach(function(key) {
        element[key].classList.add("dark_ps-poll__item-fill");
    });



}





function bulk_invite() {
    var group_id = document.getElementById("group_id").value;
    if (document.getElementById('to_emails').value == "") {
        document.getElementById("invite_email_msg").innerHTML = 'Please enter at least one valid email.';
        return false;
    }

    var to_emails = JSON.parse(document.getElementById("to_emails").value);

    //to_emails = to_emails.split(",").map(function (value) {
    //return value.trim();
    //});
    var max = 50;
    if (to_emails.length > max) {
        document.getElementById("invite_email_msg").innerHTML = 'Maximum ' + max + ' emails allowed.';
        return false;
    }

    if (to_emails.length == 0) {
        document.getElementById("invite_email_msg").innerHTML = 'Please enter at least one valid email.';
        return false;
    }


    document.getElementById("invite_email_msg").innerHTML =
        `<img class="ps-loading" src="` + window.location.origin + `/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt="" style="display: inline-block">`;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);

            var already_member = '';
            var already_invited = '';
            var invalid_email = '';
            var your_email = '';
            var success_email = '';

            reset_email();

            if (obj['already_member'].length > 0) {
                for (const [key, value] of Object.entries(obj['already_member'])) {
                  already_member += '<span class="warning_email_span">' + value + '</span>';
                }
                already_member = '<br>' + already_member+' already joined this group.';
            }

            if (obj['already_invited'].length > 0) {
                for (const [key, value] of Object.entries(obj['already_invited'])) {
                  already_invited += '<span class="warning_email_span">' + value + '</span>';
                }
                already_invited = '<br>' + already_invited+' already invited for this group.';
            }

            if (obj['invalid_email'].length > 0) {
                invalid_email = '<br>' + obj['invalid_email'] + ' invalid email';
            }

            if (obj['your_email'].length > 0) {
                for (const [key, value] of Object.entries(obj['your_email'])) {
                  your_email += '<span class="warning_email_span">' + value + '</span>';
                }
                your_email = '<br>' + your_email+' you cannot invite yourself.';
            }

            if (obj['success_email'].length > 0) {
                for (const [key, value] of Object.entries(obj['success_email'])) {
                    success_email += '<span class="success_email_span">' + value + '</span>';
                }
                success_email = '<br>' + success_email;
            }

            document.getElementById("invite_email_msg").innerHTML = obj['msg'] + success_email + already_member +
                already_invited + invalid_email + your_email;
        }
    };
    xhttp.open("GET", window.location.origin +
        "/wp-content/themes/peepso-theme-gecko/api_js.php?bulk_invite=true&to_emails=" + to_emails + "&group_id=" +
        group_id, true);
    xhttp.send();
}

function invite_email_modal(action) {
    var element = document.getElementById("invite_email_ps-window");
    element.style.display = action;
    document.getElementById("invite_email_msg").innerHTML = '';
    document.getElementById('clear_all_email').style.display = "none";
}


function close_confirm_reset_email() {
    var element = document.getElementById("reset_email_confirm_window");
    element.style.display = "none";
}

function show_confirm_reset_email() {
    document.getElementById("reset_email_confirm_window").style.display = 'block';
}

function reset_email() {
    document.getElementById("to_emails").value = "";
    document.getElementById("multiple_email_list").innerHTML = "";

    document.getElementById("multiple_emails_error_list").value = "";
    document.getElementById("multiple_emails_error_list").classList.remove("multiple_emails-error");

    if (document.getElementById("to_emails").value == "") {
        document.getElementById("email_count_level").innerHTML = "";
        document.getElementById('clear_all_email').style.display = "none";
    }

}



function email_count() {

    var to_emails = JSON.parse(document.getElementById("to_emails").value);
    if (to_emails.length > 0) {
        document.getElementById("email_count_level").innerHTML = to_emails.length + " Email(s)";
        document.getElementById('clear_all_email').style.display = "inline-block";
    } else {
        document.getElementById("email_count_level").innerHTML = "";
        document.getElementById('clear_all_email').style.display = "none";
    }
}


(function($) {

    $.fn.multiple_emails = function(options) {

        // Default options
        var defaults = {
            checkDupEmail: true,
            theme: "Bootstrap",
            position: "top"
        };

        // Merge send options with defaults
        var settings = $.extend({}, defaults, options);

        var deleteIconHTML = "";
        if (settings.theme.toLowerCase() == "Bootstrap".toLowerCase()) {
            deleteIconHTML =
                '<a href="#" class="multiple_emails-close" onclick="email_count()" title="Remove"><span class="glyphicon glyphicon-remove cus_multiple_email_span">X</span></a>';
        } else if (settings.theme.toLowerCase() == "SemanticUI".toLowerCase() || settings.theme
            .toLowerCase() == "Semantic-UI".toLowerCase() || settings.theme.toLowerCase() == "Semantic UI"
            .toLowerCase()) {
            deleteIconHTML =
                '<a href="#" class="multiple_emails-close" title="Remove"><i class="remove icon"></i></a>';
        } else if (settings.theme.toLowerCase() == "Basic".toLowerCase()) {
            //Default which you should use if you don't use Bootstrap, SemanticUI, or other CSS frameworks
            deleteIconHTML =
                '<a href="#" class="multiple_emails-close" title="Remove"><i class="basicdeleteicon">Remove</i></a>';
        }

        return this.each(function() {
            //$orig refers to the input HTML node
            var $orig = $(this);
            var $list = $(
                '<ul id="multiple_email_list" class="multiple_emails-ul" />'
                ); // create html elements - list of email addresses as unordered list

            if ($(this).val() != '' && IsJsonString($(this).val())) {
                $.each(jQuery.parseJSON($(this).val()), function(index, val) {
                    $list.append($(
                            '<li class="multiple_emails-email"><span class="email_name" data-email="' +
                            val.toLowerCase() + '">' + val + '</span></li>')
                        .prepend($(deleteIconHTML)
                            .click(function(e) {
                                $(this).parent().remove();
                                refresh_emails();
                                e.preventDefault();
                            })
                        )
                    );
                });

            }


            var $input = $(
                '<input type="text" style="margin-bottom:5px;" id="multiple_emails_error_list" placeholder="john@dojoko.com, alex@gmail.com, james@live.com" class="multiple_emails-input text-left" />'
            ).on('keyup', function(e) { // input
                $(this).removeClass('multiple_emails-error');
                var input_length = $(this).val().length;

                var keynum;
                if (window.event) { // IE
                    keynum = e.keyCode;
                } else if (e.which) { // Netscape/Firefox/Opera
                    keynum = e.which;
                }

                //if(event.which == 8 && input_length == 0) { $list.find('li').last().remove(); } //Removes last item on backspace with no input

                // Supported key press is tab, enter, space or comma, there is no support for semi-colon since the keyCode differs in various browsers
                if (keynum == 9 || keynum == 32 || keynum == 188) {
                    display_email($(this), settings.checkDupEmail);
                    email_count();
                } else if (keynum == 13) {
                    email_count();
                    display_email($(this), settings.checkDupEmail);
                    //Prevents enter key default
                    //This is to prevent the form from submitting with the submit button
                    //when you press enter in the email textbox
                    e.preventDefault();

                }

            }).on('blur', function(event) {
                if ($(this).val() != '') {
                    display_email($(this), settings.checkDupEmail);
                }
            });

            var $container = $('<div class="multiple_emails-container" />').click(function() {
                $input.focus();
            }); // container div

            // insert elements into DOM
            if (settings.position.toLowerCase() === "top") {
                $container.append($list).append(
                    '<span class="email_count_level" style="float:left;padding:5px;color:#00acc1;" id="email_count_level" ></span> <a class="clear_all_email" id="clear_all_email" style="float:right;padding:5px;color:#FF4081;cursor:pointer;" onclick="show_confirm_reset_email()" >Clear all</a>'
                ).append($input).insertAfter($(this));

            } else {
                $container.append($input).append($list).insertBefore($(this));
            }

            /*
            t is the text input device.
            Value of the input could be a long line of copy-pasted emails, not just a single email.
            As such, the string is tokenized, with each token validated individually.
            If the dupEmailCheck variable is set to true, scans for duplicate emails, and invalidates input if found.
            Otherwise allows emails to have duplicated values if false.
            */
            function display_email(t, dupEmailCheck) {

                //Remove space, comma and semi-colon from beginning and end of string
                //Does not remove inside the string as the email will need to be tokenized using space, comma and semi-colon
                var arr = t.val().trim().replace(/^,|,$/g, '').replace(/^;|;$/g, '');
                //Remove the double quote
                arr = arr.replace(/"/g, "");
                //Split the string into an array, with the space, comma, and semi-colon as the separator
                arr = arr.split(/[\s,;]+/);

                var errorEmails = new Array(); //New array to contain the errors

                var pattern = new RegExp(
                    /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i
                );

                for (var i = 0; i < arr.length; i++) {
                    //Check if the email is already added, only if dupEmailCheck is set to true
                    if (dupEmailCheck === true && $orig.val().indexOf(arr[i]) != -1) {
                        if (arr[i] && arr[i].length > 0) {
                            new function() {
                                var existingElement = $list.find('.email_name[data-email=' + arr[i]
                                    .toLowerCase().replace('.', '\\.').replace('@', '\\@') + ']'
                                );
                                existingElement.css('font-weight', 'bold');
                                setTimeout(function() {
                                    existingElement.css('font-weight', '');
                                }, 1500);
                            }
                            (); // Use a IIFE function to create a new scope so existingElement won't be overriden
                        }
                    } else if (pattern.test(arr[i]) == true) {
                        $list.append($(
                                '<li class="multiple_emails-email"><span class="email_name" data-email="' +
                                arr[i].toLowerCase() + '">' + arr[i] + '</span></li>')
                            .prepend($(deleteIconHTML)
                                .click(function(e) {
                                    $(this).parent().remove();
                                    refresh_emails();
                                    e.preventDefault();
                                })
                            )
                        );
                    } else
                        errorEmails.push(arr[i]);
                }
                // If erroneous emails found, or if duplicate email found
                if (errorEmails.length > 0)
                    t.val(errorEmails.join("; ")).addClass('multiple_emails-error');
                else
                    t.val("");
                refresh_emails();
            }

            function refresh_emails() {
                var emails = new Array();
                var container = $orig.siblings('.multiple_emails-container');
                container.find('.multiple_emails-email span.email_name').each(function() {
                    emails.push($(this).html());
                });
                $orig.val(JSON.stringify(emails)).trigger('change');
                email_count();
            }

            function IsJsonString(str) {
                try {
                    JSON.parse(str);
                } catch (e) {
                    return false;
                }
                return true;
            }

            return $(this).hide();

        });

    };

})(jQuery);









var videos = document.getElementsByTagName("video"),
fraction = 0.5;
function checkScroll() {

for(var i = 0; i < videos.length; i++) {

    var video = videos[i];

    var x = video.offsetLeft, y = video.offsetTop, w = video.offsetWidth, h = video.offsetHeight, r = x + w, //right
        b = y + h, //bottom
        visibleX, visibleY, visible;

        visibleX = Math.max(0, Math.min(w, window.pageXOffset + window.innerWidth - x, r - window.pageXOffset));
        visibleY = Math.max(0, Math.min(h, window.pageYOffset + window.innerHeight - y, b - window.pageYOffset));

        visible = visibleX * visibleY / (w * h);

        if (visible > fraction) {
            video.play();
        } else {
            video.pause();
        }

}

}

window.addEventListener('scroll', stopVideos, false);
window.addEventListener('resize', stopVideos, false);

function stopVideos() {
var videos = document.querySelectorAll('iframe, video');
Array.prototype.forEach.call(videos, function (video) {
/*
    var x = video.offsetLeft, y = video.offsetTop, w = video.offsetWidth, h = video.offsetHeight, r = x + w, //right
        b = y + h, //bottom
        visibleX, visibleY, visible;

        visibleX = Math.max(0, Math.min(w, window.pageXOffset + window.innerWidth - x, r - window.pageXOffset));
        visibleY = Math.max(0, Math.min(h, window.pageYOffset + window.innerHeight - y, b - window.pageYOffset));

        visible = visibleX * visibleY / (w * h);

        //console.log(visible+"-"+fraction)

        if (visible > fraction) {
            if (video.tagName.toLowerCase() === 'video') {
                video.pause();
            } else {
                var src = video.src;
                video.src = src;
            }
        }
        */

       const is_visible = isInViewport(video);
        if( is_visible ){
        }else{
            if (video.tagName.toLowerCase() === 'video') {
                video.pause();
            } else {
                var src = video.src;
                video.src = src;
            }
        }

});
}

var isInViewport = function (elem) {
var bounding = elem.getBoundingClientRect();
return (
    bounding.top >= 0 &&
    bounding.left >= 0 &&
    bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    bounding.right <= (window.innerWidth || document.documentElement.clientWidth)
);
};
