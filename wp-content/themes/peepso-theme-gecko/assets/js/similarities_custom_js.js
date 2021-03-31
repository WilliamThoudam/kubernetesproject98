
function getSimilarities() {
    var login_userid = document.getElementById("cus_userid").value;
    
              $.ajax({
                  type: "get",
                url: window.location.origin+"/wp-content/themes/peepso-theme-gecko/api_js.php?user_id="+login_userid,
                  success: function (response) {
                      try {
                          response = JSON.parse(response);
                          for (const [key, value] of Object.entries(response.matched_member_id)) {
                          
                          if(response.mutual_friends_count[key])
                          {
                          var mutual_friends_count_html = `<a class="cus_mutual_friends ps-friends__mutual" href="#" onclick="psfriends.show_mutual_friends(`+login_userid+`, `+response.matched_member_id[key]+`); return false;"><i class="gcis gci-user-friends"></i>`+response.mutual_friends_count[key]+` mutual connects</a>`;}
                          else{
                          var mutual_friends_count_html = '';
                          }


                          if (response.is_requested[key]) {
                            var connect_button =
                                `<a href="#" class="ps-member__action ps-member__action--cancel ps-focus__cover-action ps-js-friend-cancel-request" data-user-id="` +
                                response.matched_member_id[key] + `" data-request-id="` + response.requested_id[key] + `" onclick="">
                        <span>Withdraw Request</span> 
                        <img class="ps-loading" src="` + window.location.origin + `/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt="" style="display: none"></a>`;
                        } else {
                            var connect_button = `<a href="#" class="cus_ps_member_action_a ps-member__action ps-member__action--add ps-focus__cover-action ps-js-friend-send-request" data-user-id="` +
                            response.matched_member_id[key] + `" onclick="">
                        <span>Connect</span>
                        <img class="ps-loading" src="` + window.location.origin + `/wp-content/plugins/peepso-core/assets/images/ajax-loader.gif" alt="" style="display: none">	</a>`;
                        }
                          
      $('#cus_similarities_user_card').append(`<div class="ps-member ps-js-member" data-user-id="`+response.matched_member_id[key]+`">
            <div class="ps-member__inner">
                <div class="ps-member__header cus_ps_member_header">
                <a class="ps-avatar ps-avatar--member" href="`+response.matched_profile[key]+`">
                <img alt="`+response.matched_full_name[key]+` avatar" src="`+response.matched_avatar[key]+`" onerror="this.src='`+window.location.origin+`/wp-content/plugins/peepso-core/assets/images/avatar/user-neutral.png';">
                </a>

                    <div class="ps-member__options"><div class="ps-member__option ps-dropdown ps-dropdown--menu ps-dropdown--left ps-js-dropdown">
                    <a class="ps-dropdown__toggle ps-js-dropdown-toggle" data-value="">
                        <span class="gcis gci-ellipsis-h"></span>
                    </a>
                    <div class="ps-dropdown__menu ps-js-dropdown-menu" style="display: none;">
                        <a href="#" onclick="ps_member.block_user(`+response.matched_member_id[key]+`, this); return false"><i class="remove"></i><span>Block User</span>
                </a>
                <a href="#" onclick="peepso.user(`+response.matched_member_id[key]+`).doReport(); return false"><i class="warning-sign"></i><span>Report User</span>
                </a>
                    </div>
                </div>
                
                            </div>


                </div>
                <div class="ps-member__body cus_member_body">
                    <div class="ps-member__name cus_ps_member_name">
                        <a href="`+response.matched_profile[key]+`" class="" title="`+response.matched_full_name[key]+`" alt="`+response.matched_full_name[key]+` avatar">`+response.matched_full_name[key]+`</a>
                        
                    </div>
                    <!-- onclick="show_cus_common_modal('cus_`+response.matched_member_id[key]+`')" -->
                   
                    <div style="margin-bottom:10px;" class="ps-member__details">`+mutual_friends_count_html+`</div>
                    <a href="javascript:show_interest(`+response.matched_member_id[key]+`)"  class="cus_common_interest_btn" >
                        <img  class="thunder_button_icon" src="https://s3.ap-south-1.amazonaws.com/cdn.dojoko.com/assets/magnet.svg" />Common Interests
                    </a>
                    <div class="ps-member__buttons cus_connect_button ps-js-member-actions-extra" data-user-id="`+response.matched_member_id[key]+`">   
                    `+ connect_button +`
                    </div>
                </div>
                 
            </div>
        </div>`);
        
        
        
    };
    
    }
                      catch (e) {
                          alert(e);
                      }
                  }
              });
          }
          
          getSimilarities();
           function show_cus_common_modal(modal_id)
          {
                  var element = document.getElementById(modal_id);
                element.style.display = "block";
          }
          
          function close_cus_common_modal(modal_id)
          {
                  var element = document.getElementById(modal_id);
                element.style.display = "none";
          }