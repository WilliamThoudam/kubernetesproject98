var php_function_url = window.location.origin+"/wp-content/themes/peepso-theme-gecko/api_js.php";
var php_autocomplete_url = window.location.origin+"/wp-content/themes/peepso-theme-gecko/api_js.php";
var timer;
var datepicker = $.fn.datepicker.noConflict();
$.fn.bootstrapDP = datepicker;
var date = new Date();
date.setUTCHours(0,0,0,0);

/* START DISABLED NEXT STEP WHEN ENTER KEYSTROKE */

$("#onboarding_form input, textarea, #form-field-summary, #form-field-institution_description, #form-field-work_experience_description, #form-field-award_achievement").on( "keydown", function(event) {
	var keycode = event.keyCode || event.which;
	if(keycode == 13) {
    console.log(event);
		event.preventDefault();
		return false;
	}
});

/* END DISABLED NEXT STEP WHEN ENTER KEYSTROKE */



/* VALIDATION START */

$('#form-field-phone,#form-field-institution_from_year,#form-field-institution_to_year').keypress(function (e) {
    var regex = new RegExp("^[0-9\b]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});


$('textarea').keypress(function (e) {
    var regex = new RegExp("[0-9 a-z A-Z ! @ # $ % & * ( ) - . , + / : ; ?  ']");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
});

  

/* VALIDATION END */
 

function close_summernote()
{
	$('#popup1').css('opacity','0');
	$('#popup1').css('visibility','hidden');
} 

function open_summernote()
{
	$('#popup1').css('opacity','1');
	$('#popup1').css('visibility','visible');
} 

function open_download_info_message()
{
	// $('#download_info_message').css('opacity','1');
	// $('#download_info_message').css('visibility','visible');
    // $('#download_msg').html('Click yes to download your cv.');
} 

function close_download_info_message()
{
	$('#download_info_message').css('opacity','0');
	$('#download_info_message').css('visibility','hidden');
} 
	
function showLoader()
{
    $('.flexbox').css({"display":"flex"});
}

function hideLoader()
{
    $('.flexbox').css({"display":"none"});
}
 
 
function snackbar(type,msg) {
  var x = document.getElementById("snackbar");
  x.innerHTML = msg;
  x.className = type;
  setTimeout(function(){ x.className = x.className.replace(type, ""); }, 3000);
}

var url_string =  window.location.href;
var url = new URL(url_string);
var from = url.searchParams.get("from");
var onboarding_username = url.searchParams.get("username");
if (from == 'resume')
{
    close_summernote();
}
else
{
    open_summernote();
}



/* START HERE GET COUNTRY CODE */   

    function getCountryCode() {
          var json = {"get_country_code": true,"payload":[]};
          $.ajax({
              type: "get",
              url: php_function_url,
              data: json,
              dataType: 'json',
              async:false,
              success: function (response) {
                  try {
                      if (response.success) {
                          $.each( response.result, function( key, value ) {
                               $('#form-field-country_code').append(`<option value='`+value.code+`'>`+value.country+` (`+value.code+`) `+value.dial+`</option>`)
                            })
                      }
                      else {
                          if(!response.auth)
                          {
                              document.location.href="/";
                              snackbar('error',response.msg);
                          }
                          else{
                              snackbar('error',response.msg);
                          }
                      }
                  }
                  catch (e) {
                      snackbar('error',e);
                  }
              }
          });
      }
      getCountryCode();

/* END HERE GET COUNTRY CODE */  


 
/* START HERE PROFILE INFO */   

    function getProfileInfo() {
           showLoader();
           var json = {"get_profile_info": true,"payload":{"username":onboarding_username}};
           $.ajax({
               type: "get",
               url: php_function_url,
               data: json,
               dataType: 'json',
               success: function (response) {
                   hideLoader();
                   
                   try {
                       if (response.success) {
                           if(onboarding_username == null)
                           {
                               onboarding_username = response.result4.user_login;
                           }
                           if(response.result4.user_login != onboarding_username)
                           {
                               hideDiv();
                           }
                           else{
                               showDiv();
                           }
                           
                          $('#form-field-first_name').val(response.result1.first_name.replace(/&rsquo;/g, "'"));
                          $('#form-field-last_name').val(response.result1.last_name.replace(/&rsquo;/g, "'"));
                          $('#form-field-email').val(response.result2.user_email).attr('readonly',true).css("background-color","rgb(204 204 204 / 32%)");
                          $('#form-field-username').val(response.result2.user_login).attr('readonly',true).css("background-color","rgb(204 204 204 / 32%)");
                          $('#form-field-country_code').val(response.result1.peepso_user_field_247);
                          $('#form-field-phone').val(response.result1.peepso_user_field_2429);
                          $('#form-field-gender').val(response.result1.peepso_user_field_gender);
                          $('#form-field-dob').val(response.result1.peepso_user_field_birthdate).attr('readonly',true).css("background-color","rgb(204 204 204 / 32%)");
                           $('#form-field-current_location').val(response.result3.personal_info_current_location.replace(/\\/g, ""));

$('#cv_summary').prev().css("display","block");
 $('#cv_summary').next().css("display","block");

$('#cv_phone').prev().css("display","block");
 $('#cv_phone').next().css("display","block");
  $('#cv_profile_info_current_location').parent().prev().css("display","block");
                          $('#cv_profile_info_current_location').parent().next().next().css("display","block");
                          if(response.result3.personal_info_current_location == null)
                        {
                        response.result3.personal_info_current_location = '';
                        } 
                           if(response.result3.personal_info_current_location == '')
                      {
                          $('#cv_profile_info_current_location').parent().prev().css("display","none");
                          $('#cv_profile_info_current_location').parent().next().next().css("display","none");
                      }
                           $('#cv_profile_info_current_location').text(response.result3.personal_info_current_location.replace(/\\/g, ""));
                          $('#form-field-headline').val(response.result1.peepso_user_field_2428.replace(/&rsquo;/g, "'"));
                          $("#form-field-summary .ql-editor").html(response.result1.description.replace(/&rsquo;/g, "'"));
                          
                          
                          $('#display_name').text(response.result1.first_name.replace(/&rsquo;/g, "'"));
                          $('#cv_heading_title').text(response.result1.first_name.replace(/&rsquo;/g, "'")+' '+response.result1.last_name.replace(/&rsquo;/g, "'"));
                          $('#cv_subheading_title').text(response.result1.peepso_user_field_2428.replace(/&rsquo;/g, "'"));
                          
                          if(response.result1.description == '')
                      {
                          $('#cv_summary').prev().css("display","none");
                          $('#cv_summary').next().css("display","none");
                      }
                          if( response.result1.description.length > 300)
                          {
                          more = `... <a class="more" id="more" onclick="morestr('`+response.result1.description.replace(/\n|\r/g, " ").replace(/"/g, "\\'")+`')">more</a>`;
                          }
                          else
                          {
                              more = '';
                          }
                          $('#cv_summary').html(response.result1.description.substr(0, 300).replace(/&rsquo;/g, "'")+more);
 
 
 
$('#cv_user_profile_type').prev().css("display","block");
$('#cv_user_profile_type').next().css("display","block"); 
$('#cv_user_profile_type').html('');
if(response.result1.peepso_user_field_10877.length == 0)
{
	$('#cv_user_profile_type').prev().css("display","none");
	$('#cv_user_profile_type').next().css("display","none");
}
$.each( response.result1.peepso_user_field_10877, function( key, value ) {
if(value == 'option_10877_1')
{
$("#profile_field_10877-option_10877_1").attr("checked", true);
option = 'Pre University Student';
}
if(value == 'option_10877_2')
{
$("#profile_field_10877-option_10877_2").attr("checked", true);
option = 'University Student';
}
if(value == 'option_10877_3')
{
$("#profile_field_10877-option_10877_3").attr("checked", true);
option = 'Young Professional (less than 4 Years)';
}
if(value == 'option_10877_4')
{
$("#profile_field_10877-option_10877_4").attr("checked", true);
option = 'Experienced Professionals (more than 4 Years)';
}
$('#cv_user_profile_type').append(`<label class="cv_section_desc">`+option+`</label>`);
 });
 
 
 
 if(response.result1.peepso_user_field_2429 == null)
                        {
                        response.result1.peepso_user_field_2429 = '';
                        } 
                   if(response.result1.peepso_user_field_2429 == '')
                      {
                          $('#cv_phone').prev().css("display","none");
                          $('#cv_phone').next().css("display","none");
                      }
                          
                          $('#cv_phone, #new_cv_phone').text(response.result5.dial +' '+response.result1.peepso_user_field_2429);
                      
                      if(response.result2.user_email == null)
                        {
                        response.result2.user_email = '';
                        }     
                          if(response.result2.user_email == '')
                      {
                          $('#cv_email').prev().css("display","none");
                          $('#cv_email').next().css("display","none");
                      }
                          $('#cv_email, #new_cv_email').text(response.result2.user_email);
                          
                          $('#popup_fullname').text(response.result1.first_name.replace(/&rsquo;/g, "'")+' '+response.result1.last_name.replace(/&rsquo;/g, "'"));
                          $('#popup_firstname, .empty_cv_firstname').text(response.result1.first_name.replace(/&rsquo;/g, "'"));
                          $('#beta_info_popup_fullname').text(response.result1.first_name.replace(/&rsquo;/g, "'"));
                          
                          
                          $('#form-field-link_type').children('option').attr('disabled', false);
                          $('#profile_info_social_media_chip').html('');
                          
                          if(response.result3.personal_info_facebook_link == null)
                        {
                        response.result3.personal_info_facebook_link = '';
                        }
                        
                        if(response.result3.personal_info_twitter_link == null)
                        {
                        response.result3.personal_info_twitter_link = '';
                        }
                        
                        if(response.result3.personal_info_instagram_link == null)
                        {
                        response.result3.personal_info_instagram_link = '';
                        }
                        
                        if(response.result3.personal_info_linkedin_link == null)
                        {
                        response.result3.personal_info_linkedin_link = '';
                        }

                          
                          if(response.result3.personal_info_facebook_link != '')
                          {
                              $('#profile_info_social_media_chip').append(`<span class="chip"><a href="`+response.result3.personal_info_facebook_link+`" target="_blank">Facebook </a> <span onclick="deleteSocialMediaChip('facebook')">x</span></span>`);
                              $('#form-field-link_type').children('option[value="facebook"]').attr('disabled', true);
                          }
                          if(response.result3.personal_info_twitter_link != '')
                          {
                              $('#profile_info_social_media_chip').append(`<span class="chip"><a href="`+response.result3.personal_info_twitter_link+`" target="_blank">Twitter </a> <span onclick="deleteSocialMediaChip('twitter')">x</span></span>`);
                              $('#form-field-link_type').children('option[value="twitter"]').attr('disabled', true);
                          }
                        /*   if(response.result2.user_url != '')
                           {
                               $('#profile_info_social_media_chip').append(`<span class="chip"><a href="`+response.result2.user_url+`" target="_blank">Website</a> <span onclick="deleteSocialMediaChip('website')">x</span></span>`);
                               $('#form-field-link_type').children('option[value="website"]').attr('disabled', true);
                           } */
                          if(response.result3.personal_info_instagram_link != '')
                          {
                              $('#profile_info_social_media_chip').append(`<span class="chip"><a href="`+response.result3.personal_info_instagram_link+`" target="_blank">Instagram </a> <span onclick="deleteSocialMediaChip('instagram')">x</span></span>`);
                              $('#form-field-link_type').children('option[value="instagram"]').attr('disabled', true);
                          }
                          if(response.result3.personal_info_linkedin_link != '')
                          {
                              $('#profile_info_social_media_chip').append(`<span class="chip"><a href="`+response.result3.personal_info_linkedin_link+`" target="_blank">LinkedIn </a> <span onclick="deleteSocialMediaChip('linkedin')">x</span></span>`);
                              $('#form-field-link_type').children('option[value="linkedin"]').attr('disabled', true);
                          }
                          
                          hideCV($("#cv_my_skills_technical_chip").children().length,$("#cv_my_skills_personal_chip").children().length,$("#cv_my_skills_hobbies_chip").children().length,$("#cv_career_interests_job_role_chip").children().length,$("#cv_career_interests_industry_chip").children().length,$("#cv_career_interests_type_of_work_chip").children().length,$("#cv_profile_info_language_chip").children().length,$("#cv_profile_info_current_location").html() ? 1 : 0,$("#cv_phone").html() ? 1 : 0,$("#cv_education").children().length,$("#cv_work_experience").children().length,$("#cv_award_achievement").children().length,$("#cv_subheading_title").html() ? 1 : 0,$("#cv_summary").html() ? 1 : 0);
                         // setFormHeight();
                         // alert("From Get Profile Info Success");
                       }
                       else {
                           if(!response.auth)
                           {
                               document.location.href="/";
                           }
                           else{
                               snackbar('error',response.msg);
                           }
                       }
                   }
                   catch (e) {
                       snackbar('error',e);
                   }
               }
           });
       }
       
function morestr(str)
{
    less = ` <a class="more" id="less" onclick="lessstr('`+str.replace(/'/g, "\\'")+`')">less</a>`;
    $('#cv_summary').html(str+less);
}

function lessstr(str)
{
    more = `... <a class="more" id="more" onclick="morestr('`+str.replace(/'/g, "\\'")+`')">more</a>`;
    $('#cv_summary').html(str.substr(0, 300)+more);
}

function hideDiv()
{
    $('.elementor-heading-title, .elementor-element-a4f0d0a, #cv_viewer').remove();
    $('.elementor-element-e3f6dca').css({"display":"block"});
}

function showDiv()
{
    $('.elementor-heading-title, .elementor-element-a4f0d0a').css({"display":"block"});
}

function savePersonalInfo(callback = () => {})
{
    showLoader();
    var summary = $("#form-field-summary .ql-editor").html().trim();
    if(summary.replace(/<(.|\n)*?>/g, '') == 0)
    {
    	summary = '';
    }
    
    var languages_count = $("#profile_info_language_chip").children().length;
    
    
   var payload = {
       "first_name":$('#form-field-first_name').val().substring(0, 1).toUpperCase() + $('#form-field-first_name').val().substring(1),
       "last_name":$('#form-field-last_name').val().substring(0, 1).toUpperCase() + $('#form-field-last_name').val().substring(1),
       "country_code":$('#form-field-country_code').val(),
       "phone":$('#form-field-phone').val(),
       "gender":$('#form-field-gender').val(),
       "dob":$('#form-field-dob').val(),
       "current_location":$('#form-field-current_location').val(),
       "languages_count":languages_count,
       "headline":$('#form-field-headline').val(),
       "summary":summary
   };
   var json = {"update_profile_info":true, "payload":payload};
   $.ajax({
       type: "post",
       url: php_function_url,
       data: json,
       dataType: 'json',
       success: function (response) {
           hideLoader();
           try {
               if (response.success) {
                   getProfileInfo();
                    /* snackbar('success',response.msg); */
                    callback(true);
               }
               else {
                   if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                       callback(false);
                   }
                   else{
                       snackbar('error',response.msg);
                       callback(false);
                   }
               }
           }
           catch (e) {
               snackbar('error',e);
               callback(false);
           }
       }
   });
}


 /* auto save personal info */
 $("#form-field-first_name, #form-field-last_name, #form-field-phone, #form-field-headline").keyup(function(e){
  keyword = e.target.value;
  if(keyword.trim() != '') {
            self.clearTimeout(timer);
            timer = self.setTimeout(function () {
            savePersonalInfo();    
            }, 3000) /* time frame 3 seconds */
        }
});


$("#form-field-country_code, #form-field-gender, #form-field-current_location").change(function(e){
  keyword = e.target.value;
  if(keyword.trim() != '') {
            self.clearTimeout(timer);
            timer = self.setTimeout(function () {
            savePersonalInfo();    
            }, 3000) /* time frame 3 seconds */
        }
});


function updateSocialMediaLink()
{
    showLoader();
    var link_type = $('#form-field-link_type').val();
    var link = $('#form-field-link').val();
    var json = {"update_social_media_link": true,"payload":{"link_type": link_type,"link":link}};
   $.ajax({
       type: "post",
       url: php_function_url,
       data: json,
       dataType: 'json',
       success: function (response) {
           hideLoader();
           try {
               if (response.success) {
                   $('#form-field-link_type').val('');
                   $('#form-field-link').val('');
                   getProfileInfo();  
                    /* snackbar('success',response.msg); */
               }
               else {
                   if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                   }
                   else{
                       snackbar('error',response.msg);
                   }
               }
           }
           catch (e) {
               snackbar('error',e);
           }
       }
   });
}

 /*execute a function presses a key down on the keyboard:*/
    document.getElementById("form-field-link").addEventListener("keydown", function(e) {
      if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        var link = $('#form-field-link').val();
        if(link.trim() != '' )
        {
            updateSocialMediaLink();
        }
        e.preventDefault();
      }
    });

function deleteSocialMediaChip(link_type)
{
    showLoader();
    var json = {"delete_social_media_chip": true,"payload":{"link_type": link_type,"link":''}};
   $.ajax({
       type: "post",
       url: php_function_url,
       data: json,
       dataType: 'json',
       success: function (response) {
           hideLoader();
           try {
               if (response.success) {
                   $('#form-field-link_type').val('');
                   $('#form-field-link').val('');
                   getProfileInfo();  
                    /* snackbar('success',response.msg); */
               }
               else {
                   if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                   }
                   else{
                       snackbar('error',response.msg);
                   }
               }
           }
           catch (e) {
               snackbar('error',e);
           }
       }
   });
}


getProfileInfo();  
autocomplete("form-field-current_location","location","","");
autocomplete("form-field-location","location","personal_info_locations_json","profile_info_location_chip");
autocomplete("form-field-language","language","personal_info_languages_json","profile_info_language_chip");

/* END HERE PERSONAL INFO */



       
    /* START HERE AUTOCOMPLETE SEARCH */
       
    function autocomplete(id,master,json_name,parentId) {
    var inp = document.getElementById(id);
    var keyword = inp.value;
    /* alert(keyword) */
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:
    inp.addEventListener("input", function(e) {
      
    });*/
    
    /*execute a function presses a key down on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) {
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        /* alert(e.target.value) */
        if(json_name != '' && parentId != '')
        {
            addChip(json_name,parentId,id,master);
        }
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
    });
    
    /*execute a function presses a key up on the keyboard:*/
    inp.addEventListener("keyup", function(e) {
    
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      
       
      autoCompleteSearch(id,master,function(err,result){
    if(err){
       /* console.log("error:",result) */
        snackbar('error',result);
    }else{
        /* console.log(result) */
        var arr = [];
        if(master == 'location')
        {
            $.each( result, function( key, value ) {
            arr.push( value.city.replace(/\\/g, "") + ', ' + value.country.replace(/\\/g, ""));   
         })
        }
        else{
            $.each( result, function( key, value ) {
                arr.push( value.title.replace(/\\/g, "") );                   
             })
        }
        /* console.log(arr) */
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        
        
        /* if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) { */
        
        
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += '<input type="hidden" value="' + arr[i] + '">';
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /* alert(inp.value) */
              if(json_name != '' && parentId != '')
                {
                    addChip(json_name,parentId,id,master);
                }
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
          
          
        /* } */
      }
    }
    })
      
    });
    



// Higher order function (ajax call) for autocomplete //

    function autoCompleteSearch(id,master,callback) {
           /* showLoader(); */
           var keyword = document.getElementById(id).value;
           
           if(keyword.trim() != '' ) {
           self.clearTimeout(timer);
           timer = self.setTimeout(function () {
            
           var json = {"autocomplete_search": true,"payload":{"master": master,"keyword":keyword}};
           $.ajax({
           type: "get",
           url: php_autocomplete_url,
           data: json,
           dataType: 'json',
           success: function (response) {
               /* hideLoader(); */
               try {
                   if (response) {
                      callback(null,response.result);
                   }
                   else {
                       callback(true,response.msg);
                   }
               }
               catch (e) {
                 callback(true,e);
               }
           }
       });
            }, 400)
        }  
    }

// Higher order function (ajax call) for autocomplete //
  



  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }    
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/* END HERE AUTOCOMPLETE SEARCH */



/* START HERE LIST CHIP */

function listChip(json_name,parentId)
{
    var json = {"list_chip": true,"payload":{"username":onboarding_username,"json_name": json_name}};
   $.ajax({
       type: "get",
       url: php_autocomplete_url,
       data: json,
       dataType: 'json',
       success: function (response) {
           try {
               if (response.success) {
                   $('#' + parentId).html('');
                   $('#cv_' + parentId).html('');
                   $('#cv_'+parentId).prev().css("display","block");
                   $('#cv_'+parentId).next().next().css("display","block");
                   if(response.result == null)
                   {
                       response.result = [];
                   }
                   if(response.result.length == 0)
                      {
                          $('#cv_'+parentId).prev().css("display","none");
                          $('#cv_'+parentId).next().next().css("display","none");
                      }
                    if(json_name == 'personal_info_locations_json' || json_name == 'career_interests_locations_json' || json_name == 'higher_education_interests_locations_json')
                    {
                           $.each( response.result, function( key, value ) {
                               $('#'+parentId).prepend(`<span class="chip">`+ value.city.replace(/\\/g, "") +`, `+ value.country.replace(/\\/g, "") +`<span onclick=deleteChip("`+ json_name +`","`+ parentId +`",` + key + `)>x</span>
                              </span>`);
                              
                              $('#cv_'+parentId).prepend(`<span class="cv_chip">`+ value.city.replace(/\\/g, "") + `, `+ value.country.replace(/\\/g, "")+`</span>`);
                              
                            })
                    }
                    /* else if(json_name == 'my_skills_hobbies_json')
                    {
                        $.each( response.result, function( key, value ) {
                                   $('#'+parentId).prepend(`<span class="chip">`+ value.replace(/\\/g, "") +` <span onclick=deleteChip("`+ json_name +`","`+ parentId +`",` + key + `)>x</span>
                                  </span>`);

                                  $('#cv_'+parentId).prepend(`<span class="cv_chip" style="background-color:transparent; color:inherit">`+ value.replace(/\\/g, "") +`</span>`);

                                })
                    } */
                    else
                    {
                        $.each( response.result, function( key, value ) {
                               $('#'+parentId).prepend(`<span class="chip">`+ value.replace(/\\/g, "") +` <span onclick=deleteChip("`+ json_name +`","`+ parentId +`",` + key + `)>x</span>
                              </span>`);
                              
                              $('#cv_'+parentId).prepend(`<span class="cv_chip">`+ value.replace(/\\/g, "").trim() + `</span>`);
                              
                            })
                       hideCV($("#cv_my_skills_technical_chip").children().length,$("#cv_my_skills_personal_chip").children().length,$("#cv_my_skills_hobbies_chip").children().length,$("#cv_career_interests_job_role_chip").children().length,$("#cv_career_interests_industry_chip").children().length,$("#cv_career_interests_type_of_work_chip").children().length,$("#cv_profile_info_language_chip").children().length,$("#cv_profile_info_current_location").html() ? 1 : 0,$("#cv_phone").html() ? 1 : 0,$("#cv_education").children().length,$("#cv_work_experience").children().length,$("#cv_award_achievement").children().length,$("#cv_subheading_title").html() ? 1 : 0,$("#cv_summary").html() ? 1 : 0);  
                    
                        // ADDING NEW ATTRIBUTE IN THE PERSONAL INFO NEXT BUTTON & EDUCATION PREVIOUS BUTTON
                            var personal_info_next = $( $(".elementor-field-group-field_f2e3cc9").next().children()[0] ).children()[0]; 
                            $( personal_info_next ).attr('onclick','custom_personal_info_next()');
                            
                            var education_previous = $( $(".elementor-field-group-field_a6bbe86").next().children()[0] ).children()[0];
                            $( education_previous ).attr('id','custom_education_prev');
                        // ADDING NEW ATTRIBUTE IN THE PERSONAL INFO NEXT BUTTON & EDUCATION PREVIOUS BUTTON

                    }
                    
               }
               else {
                   if(!response.auth)
                   {
                       document.location.href="/";
                   }
                   else{
                       snackbar('error',response.msg);
                   }
               }
           }
           catch (e) {
               snackbar('error',e);
           }
       }
   });
}


/* END HERE LIST CHIP */


/* START HERE ADD CHIP */

function addChip(json_name,parentId,textFieldId,master)
{
   var keyword = $('#'+textFieldId).val();
   if((keyword.trim() != '') ) 
   {
            showLoader();
           var name = {name:keyword};
          if(master == 'location')
            {
                var nameArr = keyword.split(',');
                var name = {city:nameArr[0],country:nameArr[1]};
            }
            
            var json = {"add_chip": true,"payload":{"json_name": json_name,"name":name,"master":master}};
           $.ajax({
               type: "post",
               url: php_autocomplete_url,
               data: json,
               dataType: 'json',
               success: function (response) {
                   hideLoader();
                   try {
                       if (response.success) {
                           $('#' + textFieldId).val('');
                           listChip(json_name,parentId);
                            /* snackbar('success',response.msg); */
                            
                            // Saving all the personal info data after personal info locations and languages saved
                    if(json_name == 'personal_info_locations_json')
                    {
                    self.clearTimeout(timer);
                    timer = self.setTimeout(function () {
                    savePersonalInfo(); 
                    }, 3000) /* time frame 3 seconds */
                    }
                    if(json_name == 'personal_info_languages_json')
                    {
                    self.clearTimeout(timer);
                    timer = self.setTimeout(function () {
                    savePersonalInfo(); 
                    }, 3000) /* time frame 3 seconds */
                    }
                    // Saving all the personal info data after personal info locations and languages saved
                            
                       }
                       else {
                           if(!response.auth)
                           {
                               document.location.href="/";
                               snackbar('error',response.msg);
                           }
                           else{
                               snackbar('error',response.msg);
                           }
                       }
                   }
                   catch (e) {
                       snackbar('error',e);
                   }
               }
           });
   }
}


/* END HERE ADD CHIP */



/* START HERE DELETE CHIP */

function deleteChip(json_name,parentId,id)
{
    showLoader();
    var json = {"delete_chip": id,"payload":{"json_name": json_name}};
   $.ajax({
       type: "post",
       url: php_autocomplete_url,
       data: json,
       dataType: 'json',
       success: function (response) {
           hideLoader();
           try {
               if (response.success) {
                    listChip(json_name,parentId);  
                    /* snackbar('success',response.msg); */
               }
               else {
                   if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                   }
                   else{
                       snackbar('error',response.msg);
                   }
               }
           }
           catch (e) {
               snackbar('error',e);
           }
       }
   });
}

/* END HERE DELETE CHIP */





/* EDUCATION START */

function getEducation()
{
    var json = {"list_education": true,"payload": {"username":onboarding_username}};
    $.ajax({
    type: 'get',
    url: php_function_url,
    data: json,
    dataType: 'json',
    async:false,
    success: function(response){
        try {
            if(response.success)
            {
       $('#education_list').html('');
       $('#cv_education').html('');
       $('#cv_education').prev().css("display","block");
       $('#cv_education').next().next().css("display","block");
       if(response.result == null)
       {
           response.result = [];
       }
                   if(response.result.length == 0)
                      {
                          $('#cv_education').prev().css("display","none");
                          $('#cv_education').next().next().css("display","none");
                      }
       
                           $.each( response.result, function( key, value ) {
                               $('#education_list').prepend(`<li class="MuiListItem-root">
<div class="MuiListItemIcon-root">
<div class="MuiAvatar-root MuiAvatar-square">
<img src="/wp-content/themes/peepso-theme-gecko/assets/icons/education.png" class="MuiAvatar-img">
</div>
</div>
<div class="MuiListItemText-root MuiListItemText-multiline">
<span class="MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock">`+value.institution_name.replace(/\\/g, "")+`</span>
<p class="MuiTypography-root MuiTypography-body2 MuiTypography-colorTextSecondary">`+value.degree.replace(/\\/g, "")+`, `+value.specialisation+`<br>`+value.location.city.replace(/\\/g, "")+`, `+value.location.country.replace(/\\/g, "")+`<br>`+value.from_year+` - `+value.to_year+`<br><div class="ql-editor" style="padding:0px; height:auto">`+value.description.replace(/<(.|\n)*?>/g, '').replace(/\\/g, "")+`</div><br>
</p>
</div>
<div class="MuiListItemText-root" align="right">
<span class="MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock">

<button onclick="deleteEducation(`+key+`)" class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorSecondary" tabindex="0" type="button">
<span class="MuiIconButton-label">
<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></span><span class="MuiTouchRipple-root"></span>
</button>

<button onclick="editEducation('`+key+`','`+value.institution_name+`','`+value.degree+`','`+value.description.replace(/\n|\r/g, " ").replace(/"/g, "\'")+`','`+value.location.city+`, `+value.location.country+`','`+value.specialisation+`','`+value.from_year+`','`+value.to_year+`')" class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorSecondary" tabindex="0" type="button">
<span class="MuiIconButton-label">
<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></span>
<span class="MuiTouchRipple-root"></span>
</button>

</span>
</div>
</li>`);

$('#cv_education').prepend(`<p class="cv_list_head">`+value.institution_name.replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.degree.replace(/\\/g, "")+`, `+value.specialisation.replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.location.city.replace(/\\/g, "")+`, `+value.location.country.replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.from_year+` - `+value.to_year+`<br><div class="ql-editor cv_list" style="padding:0px; height:auto">`+value.description.replace(/\\/g, "")+`</div></p><br>`);
                            })


                $("#form-field-institution_from_year").bootstrapDP({
       format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
       autoclose: true,
   }).on('changeDate', function (selected) {
       var minDate = new Date(selected.date.valueOf());
       $('#form-field-institution_to_year').bootstrapDP('setStartDate', minDate);
   });

   $("#form-field-institution_to_year").bootstrapDP({
       format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
       autoclose: true,
   }).on('changeDate', function (selected) {
           var minDate = new Date(selected.date.valueOf());
           $('#form-field-institution_from_year').bootstrapDP('setEndDate', minDate);
   });    
   
   $('#form-field-institution_from_year').data("datepicker")._setDate(date);
   $('#form-field-institution_to_year').data("datepicker")._setDate(date);
   $('#form-field-institution_from_year').val('');
   $('#form-field-institution_to_year').val('');
   
   hideCV($("#cv_my_skills_technical_chip").children().length,$("#cv_my_skills_personal_chip").children().length,$("#cv_my_skills_hobbies_chip").children().length,$("#cv_career_interests_job_role_chip").children().length,$("#cv_career_interests_industry_chip").children().length,$("#cv_career_interests_type_of_work_chip").children().length,$("#cv_profile_info_language_chip").children().length,$("#cv_profile_info_current_location").html() ? 1 : 0,$("#cv_phone").html() ? 1 : 0,$("#cv_education").children().length,$("#cv_work_experience").children().length,$("#cv_award_achievement").children().length,$("#cv_subheading_title").html() ? 1 : 0,$("#cv_summary").html() ? 1 : 0);
                
            }
            else{
                if(!response.auth)
                   {
                       document.location.href="/";
                   }
                   else{
                       snackbar('error',response.msg);
                   }
            }
 }
                   catch (e) {
                       snackbar('error',e);
                   }
    }
    });
}


function addEducation(callback = () => {})
{
    showLoader();
    var description = $("#form-field-institution_description .ql-editor").html().trim();
    if(description.replace(/<(.|\n)*?>/g, '') == 0)
    {
    	description = '';
    }
    var location = $('#form-field-institution_location').val().split(',');
    var locationArr = {city:location[0],country:location[1]};
    
    var payload = {
        				"institution_name"	:	$('#form-field-institution_name').val().trim(),
                        "location"	:	locationArr,
                        "degree" :	$('#form-field-institution_degree').val().trim(),
                        "specialisation"	:	$('#form-field-institution_specialisation').val().trim(),
                        "from_year"	:	$('#form-field-institution_from_year').val().trim(),
                        "to_year"	:	$('#form-field-institution_to_year').val().trim(),
                        "description"	:	description
                      };
                      
        if($('#form-field-institution_id').val() != '' || $('#form-field-institution_id').val() != 0) 
        {
            var json = {"update_education": $('#form-field-institution_id').val(),"payload": payload};
        }
        else
        {
            var json = {"add_education": true,"payload": payload};
        }
        
        $.ajax({
        type: "post",
        url: php_function_url,
        data: json,
        dataType: 'json',
        success: function(response){
            hideLoader();
            try {
                if(response.success)
                {
        getEducation() ;
        resetEducationForm();
        callback(true);
        /* snackbar('success',response.msg); */
                }
                else{
                    if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                       callback(false);
                   }
                   else{
                       snackbar('error',response.msg);
                       callback(false);
                   }
                }
            }
            catch(e){
               snackbar('error',e);
               callback(false);
            }
        }
        });
}

function deleteEducation(key)
{
    showLoader();
        var json = {"delete_education": key,"payload": []};
        $.ajax({
        type: "post",
        url: php_function_url,
        data: json,
        dataType: 'json',
        success: function(response){
         hideLoader();   
        try {
                if(response.success)
                {
        getEducation(); 
        resetEducationForm();
        /* snackbar('success',response.msg); */
                }
                else{
                    if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                   }
                   else{
                       snackbar('error',response.msg);
                   }
                }
            }
            catch(e){
               snackbar('error',e);
            }
        }
        });
}

function editEducation(key,institution_name,degree,description,location,specialisation,from_year,to_year) {
    $('#form-field-institution_name').val(institution_name);
    $('#form-field-institution_location').val(location);
    $('#form-field-institution_specialisation').val(specialisation);
    $('#form-field-institution_degree').val(degree);
    $('#form-field-institution_from_year').val(from_year);
    $('#form-field-institution_to_year').val(to_year);
    $("#form-field-institution_description .ql-editor").html(description);
    $('#form-field-institution_id').val(key);
    $('#education_btn').html('Update');
}

function resetEducationForm() {
    $('#form-field-institution_name').val('');
    $('#form-field-institution_location').val('');
    $('#form-field-institution_specialisation').val('');
    $('#form-field-institution_degree').val('');
    
    $('#form-field-institution_from_year').data("datepicker")._setDate(date);
   $('#form-field-institution_to_year').data("datepicker")._setDate(date);
    
    $('#form-field-institution_from_year').val('');
    $('#form-field-institution_to_year').val(''); 
    $("#form-field-institution_description .ql-editor").html('');
    $('#form-field-institution_id').val('');
    $('#education_btn').html('Add more');
}

$('#form-field-institution_degree').change(function() {   
    if (this.value == 'High School') {
       $('#form-field-institution_specialisation_required').text('');
    } else {
       $('#form-field-institution_specialisation_required').text('*');
    }
});


autocomplete("form-field-institution_name","university","","");
autocomplete("form-field-institution_location","location","","");
autocomplete("form-field-institution_specialisation","specialisation","","");

getEducation(); 
 
/* EDUCATION END */
    


/* WORK EXPERIENCE START */

function getWorkExperience()
{
    var json = {"list_work_experience": true,"payload": {"username":onboarding_username}};
    $.ajax({
    type: 'get',
    url: php_function_url,
    data: json,
    dataType: 'json',
    success: function(response){
        try {
            if(response.success)
            {
       $('#work_experience_list').html('');
       $('#cv_work_experience').html('');
       $('#cv_work_experience').prev().css("display","block");
       $('#cv_work_experience').next().next().css("display","block");
       if(response.result == null)
       {
           response.result = [];
       }
                   if(response.result.length == 0)
                      {
                          $('#cv_work_experience').prev().css("display","none");
                          $('#cv_work_experience').next().next().css("display","none");
                      }
                           $.each( response.result, function( key, value ) {
                               $('#work_experience_list').prepend(`<li class="MuiListItem-root">
<div class="MuiListItemIcon-root">
<div class="MuiAvatar-root MuiAvatar-square">
<img src="/wp-content/themes/peepso-theme-gecko/assets/icons/work.png" class="MuiAvatar-img">
</div>
</div>
<div class="MuiListItemText-root MuiListItemText-multiline">
<span class="MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock">`+value.title.replace(/\\/g, "")+`</span>
<p class="MuiTypography-root MuiTypography-body2 MuiTypography-colorTextSecondary">`+value.employment_type.replace(/\\/g, "")+`, `+value.company_name.replace(/\\/g, "")+`<br>`+value.location.city.replace(/\\/g, "")+`, `+value.location.country.replace(/\\/g, "")+`<br>`+value.from_date+` - `+value.to_date+`<br><div class="ql-editor" style="padding:0px; height:auto">`+value.description.replace(/<(.|\n)*?>/g, '').replace(/\\/g, "")+`</div><br>
</p>
</div>
<div class="MuiListItemText-root" align="right">
<span class="MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock">

<button onclick="deleteWorkExperience(`+key+`)" class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorSecondary" tabindex="0" type="button">
<span class="MuiIconButton-label">
<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></span><span class="MuiTouchRipple-root"></span>
</button>

<button onclick="editWorkExperience('`+key+`','`+value.title+`','`+value.employment_type+`','`+value.company_name+`','`+value.location.city+`, `+value.location.country+`','`+value.description.replace(/\n|\r/g, " ").replace(/"/g, "\'")+`','`+value.from_date+`','`+value.to_date+`')" class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorSecondary" tabindex="0" type="button">
<span class="MuiIconButton-label">
<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></span>
<span class="MuiTouchRipple-root"></span>
</button>

</span>
</div>
</li>`);

$('#cv_work_experience').prepend(`<p class="cv_list_head">`+value.title.replace(/\\/g, "").replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.employment_type.replace(/\\/g, "")+`, `+value.company_name.replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.location.city.replace(/\\/g, "")+`, `+value.location.country.replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.from_date+` - `+value.to_date+`<br><div class="ql-editor cv_list" style="padding:0px; height:auto">`+value.description.replace(/\\/g, "")+`</div></p><br>`);
                            })
                            
                             $("#form-field-work_experience_from_date").bootstrapDP({
       format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
       autoclose: true,
   }).on('changeDate', function (selected) {
       var minDate = new Date(selected.date.valueOf());
       $('#form-field-work_experience_to_date').bootstrapDP('setStartDate', minDate);
   });

   $("#form-field-work_experience_to_date").bootstrapDP({
       format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
       autoclose: true,
    /*   todayHighlight: true, */
   }).on('changeDate', function (selected) {
           var minDate = new Date(selected.date.valueOf());
           $('#form-field-work_experience_from_date').bootstrapDP('setEndDate', minDate);
   });
   
   $('#form-field-work_experience_from_date').data("datepicker")._setDate(date);
   $('#form-field-work_experience_to_date').data("datepicker")._setDate(date);   
   $('#form-field-work_experience_from_date').val('');
   $('#form-field-work_experience_to_date').val('');
   
   hideCV($("#cv_my_skills_technical_chip").children().length,$("#cv_my_skills_personal_chip").children().length,$("#cv_my_skills_hobbies_chip").children().length,$("#cv_career_interests_job_role_chip").children().length,$("#cv_career_interests_industry_chip").children().length,$("#cv_career_interests_type_of_work_chip").children().length,$("#cv_profile_info_language_chip").children().length,$("#cv_profile_info_current_location").html() ? 1 : 0,$("#cv_phone").html() ? 1 : 0,$("#cv_education").children().length,$("#cv_work_experience").children().length,$("#cv_award_achievement").children().length,$("#cv_subheading_title").html() ? 1 : 0,$("#cv_summary").html() ? 1 : 0);
                            
            }
            else{
                if(!response.auth)
                   {
                       document.location.href="/";
                   }
                   else{
                       snackbar('error',response.msg);
                   }
            }
 }
                   catch (e) {
                       snackbar('error',e);
                   }
    }
    });
}


function addWorkExperience(callback = () => {})
{
    showLoader();
    var description = $("#form-field-work_experience_description .ql-editor").html().trim();
    if(description.replace(/<(.|\n)*?>/g, '') == 0)
    {
    	description = '';
    }
    var location = $('#form-field-work_experience_location').val().split(',');
    var locationArr = {city:location[0],country:location[1]};
    if($('#form-field-work_experience_current').is(":checked"))
    {
        var to_date = $('#form-field-work_experience_current').val().trim();
    }
    else if($('#form-field-work_experience_current').is(":not(:checked)")){
       var to_date = $('#form-field-work_experience_to_date').val().trim();
    }
    
    var payload = {
        				"title"	:	$('#form-field-work_experience_title').val().trim(),
                        "employment_type" :	$('#form-field-work_experience_employment_type').val().trim(),
                        "company_name"	:	$('#form-field-work_experience_company_name').val().trim(),
                        "location"	:	locationArr,
                        "from_date"	:	$('#form-field-work_experience_from_date').val().trim(),
                        "to_date"	:	to_date,
                        "description"	:	description
                      };
                      
        if($('#form-field-work_experience_id').val() != '' || $('#form-field-work_experience_id').val() != 0) 
        {
            var json = {"update_work_experience": $('#form-field-work_experience_id').val(),"payload": payload};
        }
        else
        {
            var json = {"add_work_experience": true,"payload": payload};
        }
        
        $.ajax({
        type: "post",
        url: php_function_url,
        data: json,
        dataType: 'json',
        success: function(response){
            hideLoader();
            try {
                if(response.success)
                {
        getWorkExperience(); 
        resetWorkExperienceForm();
        //snackbar('success',response.msg);
        callback(true);
                }
                else{
                    if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                       callback(false);
                   }
                   else{
                       snackbar('error',response.msg);
                       callback(false);
                   }
                }
            }
            catch(e){
                snackbar('error',e);
                callback(false);
            }
        }
        });
}

function deleteWorkExperience(key)
{
    showLoader();
        var json = {"delete_work_experience": key,"payload": []};
        $.ajax({
        type: "post",
        url: php_function_url,
        data: json,
        dataType: 'json',
        success: function(response){
         hideLoader()   
        try {
                if(response.success)
                {
        getWorkExperience(); 
        resetWorkExperienceForm();
       /* snackbar('success',response.msg); */
                }
                else{
                   if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                   }
                   else{
                       snackbar('error',response.msg);
                   }
                }
            }
            catch(e){
                snackbar('error',e);
            }
        }
        });
}

function editWorkExperience(key,title,employment_type,company_name,location,description,from_date,to_date) {
    $('#form-field-work_experience_title').val(title);
    $('#form-field-work_experience_employment_type').val(employment_type);
    $('#form-field-work_experience_company_name').val(company_name);
    $('#form-field-work_experience_location').val(location);
    $('#form-field-work_experience_from_date').val(from_date);
    if(to_date == 'current')
    {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth() + 1; /* Month from 0 to 11 */
        var y = date.getFullYear();
        var formated = m+'-'+y;
        $('#form-field-work_experience_to_date').val(formated).css({"background-color":"rgb(204 204 204 / 32%)","pointer-events":"none"});
        $('#form-field-work_experience_current').prop('checked',true);
    }
    else{
        $('#form-field-work_experience_to_date').val(to_date).css({"background-color":"transparent","pointer-events":"visible"});
        $('#form-field-work_experience_current').prop('checked',false);
    }
    $("#form-field-work_experience_description .ql-editor").html(description);
    $('#form-field-work_experience_id').val(key);
    $('#work_experience_btn').html('Update');
}

function resetWorkExperienceForm() {
    $('#form-field-work_experience_title').val('');
    $('#form-field-work_experience_employment_type').val('');
    $('#form-field-work_experience_company_name').val('');
    $('#form-field-work_experience_location').val('');
    
    $('#form-field-work_experience_from_date').data("datepicker")._setDate(date);
   $('#form-field-work_experience_to_date').data("datepicker")._setDate(date);
    
    $("#form-field-work_experience_from_date").val('');
    $("#form-field-work_experience_to_date").val('');
    $('#form-field-work_experience_current').prop('checked',false);
    $('#form-field-work_experience_to_date').css({"background-color":"transparent","pointer-events":"visible"});
    $("#form-field-work_experience_description .ql-editor").html('');
    $('#form-field-work_experience_id').val('');
    $('#work_experience_btn').html('Add more');
}

$('#form-field-work_experience_current').change(function() {
var date = new Date();
var d = date.getDate();
var m = date.getMonth() + 1; /* Month from 0 to 11 */
var y = date.getFullYear();
var formated = m+'-'+y;
    /* this will contain a reference to the checkbox   */ 
    if (this.checked) {
       $('#form-field-work_experience_to_date').val(formated).css({"background-color":"rgb(204 204 204 / 32%)","pointer-events":"none"});
    } else {
       $('#form-field-work_experience_to_date').val('').css({"background-color":"transparent","pointer-events":"visible"});
    }
});


listChip('personal_info_locations_json','profile_info_location_chip');
listChip('personal_info_languages_json','profile_info_language_chip');
autocomplete("form-field-work_experience_company_name","company","","");
autocomplete("form-field-work_experience_location","location","","");

getWorkExperience(); 
 
/* WORK EXPERIENCE END */



/* SKILLS START */

listChip('my_skills_technical_json','my_skills_technical_chip');
autocomplete("form-field-my_skills_technical","technical_skill","my_skills_technical_json","my_skills_technical_chip");

listChip('my_skills_personal_json','my_skills_personal_chip');
autocomplete("form-field-my_skills_personal","personal_skill","my_skills_personal_json","my_skills_personal_chip");

listChip('my_skills_hobbies_json','my_skills_hobbies_chip');
autocomplete("form-field-my_skills_hobbies","hobbies","my_skills_hobbies_json","my_skills_hobbies_chip");
 
 
 
listChip('skills_i_want_to_learn_technical_json','skills_i_want_to_learn_technical_chip');
autocomplete("form-field-skills_i_want_to_learn_technical","technical_skill","skills_i_want_to_learn_technical_json","skills_i_want_to_learn_technical_chip");

listChip('skills_i_want_to_learn_personal_json','skills_i_want_to_learn_personal_chip');
autocomplete("form-field-skills_i_want_to_learn_personal","personal_skill","skills_i_want_to_learn_personal_json","skills_i_want_to_learn_personal_chip");

listChip('skills_i_want_to_learn_hobbies_json','skills_i_want_to_learn_hobbies_chip');
autocomplete("form-field-skills_i_want_to_learn_hobbies","hobbies","skills_i_want_to_learn_hobbies_json","skills_i_want_to_learn_hobbies_chip");

/* SKILLS END */   



/* INTERESTS START */

listChip('higher_education_interests_locations_json','higher_education_interests_location_chip');
autocomplete("form-field-higher_education_interests_location","location","higher_education_interests_locations_json","higher_education_interests_location_chip");

$( "#form-field-higher_education_interests_degree" ).change(function() {
  addChip("higher_education_interests_degree_json","higher_education_interests_degree_chip","form-field-higher_education_interests_degree","degree");
})
listChip('higher_education_interests_degree_json','higher_education_interests_degree_chip');

listChip('higher_education_interests_specialisations_json','higher_education_interests_specialisation_chip');
autocomplete("form-field-higher_education_interests_specialisation","specialisation","higher_education_interests_specialisations_json","higher_education_interests_specialisation_chip");

listChip('higher_education_interests_universities_json','higher_education_interests_university_chip');
autocomplete("form-field-higher_education_interests_university","university","higher_education_interests_universities_json","higher_education_interests_university_chip");

listChip('career_interests_job_role_json','career_interests_job_role_chip');
autocomplete("form-field-career_interests_job_role","job_role","career_interests_job_role_json","career_interests_job_role_chip","form-field-career_interests_job_role");

listChip('career_interests_locations_json','career_interests_location_chip');
autocomplete("form-field-career_interests_location","location","career_interests_locations_json","career_interests_location_chip");

listChip('career_interests_industries_json','career_interests_industry_chip');
autocomplete("form-field-career_interests_industry","industry","career_interests_industries_json","career_interests_industry_chip");

$( "#form-field-career_interests_type_of_work" ).change(function() {
  addChip("career_interests_type_of_work_json","career_interests_type_of_work_chip","form-field-career_interests_type_of_work","type_of_work");
})
listChip('career_interests_type_of_work_json','career_interests_type_of_work_chip');

/* INTERESTS END */





/* AWARD ACHIEVEMENT START */

function getAwardAchievement()
{
    var json = {"list_award_achievement": true,"payload": {"username":onboarding_username}};
    $.ajax({
    type: 'get',
    url: php_function_url,
    data: json,
    dataType: 'json',
    success: function(response){
        try {
            if(response.success)
            {
       $('#award_achievement_list').html('');
       $('#cv_award_achievement').html('');
       $('#cv_award_achievement').prev().css("display","block");
       $('#cv_award_achievement').next().next().css("display","block");
       if(response.result == null)
       {
           response.result = [];
       }
                   if(response.result.length == 0)
                      {
                          $('#cv_award_achievement').prev().css("display","none");
                          $('#cv_award_achievement').next().next().css("display","none");
                      }
                           $.each( response.result, function( key, value ) {
                               $('#award_achievement_list').prepend(`<li class="MuiListItem-root">
<div class="MuiListItemIcon-root">
<div class="MuiAvatar-root MuiAvatar-square">
<img src="/wp-content/themes/peepso-theme-gecko/assets/icons/award.png" class="MuiAvatar-img">
</div>
</div>
<div class="MuiListItemText-root MuiListItemText-multiline">
<span class="MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock">`+value.title.replace(/\\/g, "")+`</span>
<p class="MuiTypography-root MuiTypography-body2 MuiTypography-colorTextSecondary">`+value.awarded_by.replace(/\\/g, "")+`, `+value.issue_date+`<br><a href="`+value.link+`" target="blank">`+value.link+`</a><br><div class="ql-editor" style="padding:0px; height:auto">`+value.description.replace(/<(.|\n)*?>/g, '').replace(/\\/g, "")+`</div>
</p>
</div>
<div class="MuiListItemText-root" align="right">
<span class="MuiTypography-root MuiListItemText-primary MuiTypography-body1 MuiTypography-displayBlock">

<button onclick="deleteAwardAchievement(`+key+`)" class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorSecondary" tabindex="0" type="button">
<span class="MuiIconButton-label">
<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></span><span class="MuiTouchRipple-root"></span>
</button>

<button onclick="editAwardAchievement('`+key+`','`+value.title+`','`+value.awarded_by+`','`+value.issue_date+`','`+value.link+`','`+value.description.replace(/\n|\r/g, " ").replace(/"/g, "\'")+`')" class="MuiButtonBase-root MuiIconButton-root MuiIconButton-colorSecondary" tabindex="0" type="button">
<span class="MuiIconButton-label">
<svg class="MuiSvgIcon-root" focusable="false" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg></span>
<span class="MuiTouchRipple-root"></span>
</button>

</span>
</div>
</li>`);

$('#cv_award_achievement').prepend(`<p class="cv_list_head">`+value.title.replace(/\\/g, "")+`</p>
            <p class="cv_list">`+value.awarded_by.replace(/\\/g, "")+`, `+value.issue_date+`</p>
            <p class="cv_list"><a href="`+value.link+`" target="blank">`+value.link+`</a></p><p class="cv_list"><div class="ql-editor cv_list" style="padding:0px; height:auto">`+value.description.replace(/\\/g, "")+`</div></p><br>`);
                            })
                            
                            $("#form-field-award_achievement_issue_date").bootstrapDP({
       format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
       autoclose: true,
    /*   todayHighlight: true, */
   })
   
   $('#form-field-award_achievement_issue_date').data("datepicker")._setDate(date);
   $('#form-field-award_achievement_issue_date').val('');
   
   hideCV($("#cv_my_skills_technical_chip").children().length,$("#cv_my_skills_personal_chip").children().length,$("#cv_my_skills_hobbies_chip").children().length,$("#cv_career_interests_job_role_chip").children().length,$("#cv_career_interests_industry_chip").children().length,$("#cv_career_interests_type_of_work_chip").children().length,$("#cv_profile_info_language_chip").children().length,$("#cv_profile_info_current_location").html() ? 1 : 0,$("#cv_phone").html() ? 1 : 0,$("#cv_education").children().length,$("#cv_work_experience").children().length,$("#cv_award_achievement").children().length,$("#cv_subheading_title").html() ? 1 : 0,$("#cv_summary").html() ? 1 : 0);
   
            }
            else{
                if(!response.auth)
                   {
                       document.location.href="/";
                   }
                   else{
                       snackbar('error',response.msg);
                   }
            }
 }
                   catch (e) {
                      snackbar('error',e);
                   }
    }
    });
}


function addAwardAchievement(callback = () => {})
{
    showLoader();
    var description = $("#form-field-award_achievement_description .ql-editor").html().trim();
    if(description.replace(/<(.|\n)*?>/g, '') == 0)
    {
    	description = '';
    }
    var payload = {
        				"title"	:	$('#form-field-award_achievement_title').val().trim(),
                        "awarded_by" :	$('#form-field-award_achievement_awarded_by').val().trim(),
                        "issue_date"	:	$('#form-field-award_achievement_issue_date').val().trim(),
                        "link"	:	$('#form-field-award_achievement_link').val().trim(),
                        "description"	:	description
                      };
                      
        if($('#form-field-award_achievement_id').val() != '' || $('#form-field-award_achievement_id').val() != 0) 
        {
            var json = {"update_award_achievement": $('#form-field-award_achievement_id').val(),"payload": payload};
        }
        else
        {
            var json = {"add_award_achievement": true,"payload": payload};
        }
        
        $.ajax({
        type: "post",
        url: php_function_url,
        data: json,
        dataType: 'json',
        success: function(response){
            hideLoader();
            try {
                if(response.success)
                {
        getAwardAchievement(); 
        resetAwardAchievementForm();
        /* snackbar('success',response.msg); */
        callback(true);
                }
                else{
                    if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                       callback(false);
                   }
                   else{
                       snackbar('error',response.msg);
                       callback(false);
                   }
                }
            }
            catch(e){
                snackbar('error',e);
                callback(false);
            }
        }
        });
}

function deleteAwardAchievement(key)
{
    showLoader();
        var json = {"delete_award_achievement": key,"payload": []};
        $.ajax({
        type: "post",
        url: php_function_url,
        data: json,
        dataType: 'json',
        success: function(response){
         hideLoader()   
        try {
                if(response.success)
                {
        getAwardAchievement(); 
        resetAwardAchievementForm();
        //snackbar('success',response.msg);
                }
                else{
                    if(!response.auth)
                   {
                       document.location.href="/";
                       snackbar('error',response.msg);
                   }
                   else{
                       snackbar('error',response.msg);
                   }
                }
            }
            catch(e){
                 snackbar('error',e);
            }
        }
        });
}

function editAwardAchievement(key,title,awarded_by,issue_date,link,description) {
    $('#form-field-award_achievement_title').val(title);
    $('#form-field-award_achievement_awarded_by').val(awarded_by);
    $('#form-field-award_achievement_issue_date').val(issue_date);
    $('#form-field-award_achievement_link').val(link);
    $("#form-field-award_achievement_description .ql-editor").html(description);
    $('#form-field-award_achievement_id').val(key);
    $('#award_achievement_btn').html('Update');
}

function resetAwardAchievementForm() {
    $('#form-field-award_achievement_title').val('');
    $('#form-field-award_achievement_awarded_by').val('');
    
    $('#form-field-award_achievement_issue_date').data("datepicker")._setDate(date);
    
    $('#form-field-award_achievement_issue_date').val('');
    $('#form-field-award_achievement_link').val('');
    $("#form-field-award_achievement_description .ql-editor").html('');
    $('#form-field-award_achievement_id').val('');
    $('#award_achievement_btn').html('Add more');
}

autocomplete("form-field-award_achievement_awarded_by","university","","");
getAwardAchievement(); 
 
/* AWARD ACHIEVEMENT END */




// CV Download in a PDF format 
$('.new_extract').click(function() {
     showLoader();
     //$('#download_msg').html('Your cv is downloading now ...')
     var fileName = document.getElementById("display_name").innerHTML;
     //var extra_space = 30;
     //var currentPosition = document.getElementById("content").scrollTop;
     var offsetHeight = document.getElementById('content').offsetHeight;
     

     document.getElementById("content").style.cssText = "overflow:auto; height: auto; border-radius:0px;";
     document.getElementById("cv_heading_id").style.cssText = "border-top-left-radius: 0px; border-top-right-radius: 0px";
     document.getElementById("cv_content_right").style.cssText = " border-bottom-right-radius: 0px;";
    //  document.getElementsByClassName("cv_content_right")[0].style.cssText = "border-bottom-right-radius: 0px;";
    //  document.getElementsByClassName("cv_body_wrapper")[0].style.cssText = "border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;";
     //document.getElementById("cv_content_right").style.cssText = "margin-bottom: -"+extra_space+"px";
     document.getElementById("extract").style.display="none";
     //document.getElementById("empty_cv").style.display="none";


     var is_dark_mode = false;
     if(document.getElementById("content").classList.contains("dark_cv_main_container"))
     {
        is_dark_mode = true;
        document.getElementById("content").classList.remove("dark_cv_main_container");
        document.getElementsByClassName("cv_heading")[0].classList.remove("dark_cv_heading");
        document.getElementById("cv_content_right").classList.remove("dark_cv_content_right");
        document.getElementById("cv_content_left_footer_id").classList.remove("dark_cv_content_left_footer");
        
        //document.getElementsByClassName("cv_section_desc")[0].style.cssText = "color: #535353";
        for (const [key, value] of Object.entries(document.getElementsByClassName("cv_section_heading"))) {
            value.classList.remove("dark_cv_section_heading");
        }

        // for (const [key, value] of Object.entries(document.getElementsByClassName("ql-editor"))) {
        //     value.style.cssText = "color: #535353 !important";
        // }
       

        //document.getElementsByClassName("cv_section_heading")).map(item => item.classList.remove("dark_cv_section_heading"));
     }

     $('#more').click();
     $('#less').hide();
     var w = document.getElementById("content").offsetWidth;
     var h = document.getElementById("content").offsetHeight;

    //  html2canvas(document.querySelector('#content'), {useCORS: true, dpi: 300, scale: 3}).then(function(canvas) {
    //   let img = new Image();
    //   img.src = canvas.toDataURL('image/png');
      
        // img.onload = function () {
        // let pdf = new jsPDF('P', 'mm', 'a4');
        // pdf.addImage(img, 'JPEG', 0, 0, '210', '297', undefined, 'FAST');
        // pdf.save(fileName+"_Bio.pdf");
        
        // var string = pdf.output('datauristring');
        // var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
        // var x = window.open();
        // x.document.open();
        // x.document.write(embed);
        // x.document.close();
        //   };

        // img.onload = function () {
        // let pdf = new jsPDF('P', 'px', [w, h]);
        // pdf.addImage(img, 'JPEG', 0, 0, w, h, undefined, 'FAST');
        // pdf.save(fileName+"_Bio.pdf");
        
        // var string = pdf.output('datauristring');
        // var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
        // var x = window.open();
        // x.document.open();
        // x.document.write(embed);
        // x.document.close();
        //     };
      
        /* img.onload = function () {
         let pdf = new jsPDF('landscape', 'mm', 'a4');
         pdf.addImage(img, 0, 0, pdf.internal.pageSize.width, pdf.internal.pageSize.height,undefined,'FAST');
         pdf.save('certificate.pdf');
       }; */

    // });



    var element = document.getElementById('content');
    var opt = {
        margin:       [10, 10, 10, 10],
        filename:     fileName+"_cv.pdf",
        image:        { type: 'jpeg',quality: 0.98 },
        html2canvas:  { dpi: 100, scale: 2, scrollX: 0, scrollY: 0, backgroundColor: '#FFF' },
        jsPDF:        { unit: 'pt', format: 'a4', orientation: 'p', footer: 'a' },
        enableLinks:  true,
        // pagebreak: { mode: ['avoid-all', 'css', 'legacy'], avoid: 'img' },
        pagebreak: { mode: ['avoid-all']}
    };

    html2pdf()
    .from(element)
    .set(opt)
    .toPdf()
    .get('pdf').then(function (pdf) {
        var totalPages = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);
        pdf.setFontSize(10);
        pdf.setTextColor(150);
        //pdf.text("my header text", (pdf.internal.pageSize.getWidth()/2), 10);
        //pdf.text(i+'/'+totalPages, (pdf.internal.pageSize.getWidth()/2), (pdf.internal.pageSize.getHeight() - 8));
        //pdf.html('<div>Test</div>', (pdf.internal.pageSize.getWidth()/2), (pdf.internal.pageSize.getHeight() - 8))
        } 
        window.open(pdf.output('bloburl'), '_blank');
    }).save();


    //  html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
    //  var totalPages = pdf.internal.getNumberOfPages(); 
    
    //  for (var i = 1; i <= totalPages; i++) {
    //    pdf.setPage(i);
    //    pdf.setFontSize(10);
    //    pdf.setTextColor(150);
    //    pdf.text('Page ' + i + ' of ' + totalPages, pdf.internal.pageSize.getWidth() - 100, 
    //    pdf.internal.pageSize.getHeight() - 30);
    //  } 
    //  }).save()

    //  html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
    //     var totalPages = pdf.internal.getNumberOfPages();
      
    //     for (i = 1; i <= totalPages; i++) {
    //       pdf.setPage(i);
    //       pdf.setFontSize(10);
    //       pdf.setTextColor(150);
    //       pdf.text(i+'/'+totalPages, (pdf.internal.pageSize.getWidth()/2), (pdf.internal.pageSize.getHeight() - 0.3));
    //     } 
    //   }).save();
    
    setTimeout(function(){ 
	document.getElementById("content").style.cssText = "height:"+offsetHeight+"px; overflow: hidden; ";
    
     document.getElementById("cv_content_right").style.cssText = "border-bottom-right-radius: 20px;";
    document.getElementById("cv_heading_id").style.cssText = "border-top-left-radius: 20px; border-top-right-radius: 20px";
    // document.getElementsByClassName("cv_body_wrapper")[0].style.cssText = "border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;";
    //document.getElementById("cv_content_right").style.cssText = "margin-bottom: 0px";
	document.getElementById("extract").style.display="block";
    //document.getElementById("empty_cv").style.display="block";
    //document.getElementById("content").scrollTop = currentPosition + extra_space;

    if(is_dark_mode)
    {
        document.getElementById("content").classList.add("dark_cv_main_container");
        document.getElementsByClassName("cv_heading")[0].classList.add("dark_cv_heading");
        document.getElementById("cv_content_right").classList.add("dark_cv_content_right");
        document.getElementById("cv_content_left_footer_id").classList.add("dark_cv_content_left_footer");
        //document.getElementsByClassName("cv_section_desc")[0].style.cssText = "color: inherit !important";
        for (const [key, value] of Object.entries(document.getElementsByClassName("cv_section_heading"))) {
            value.classList.add("dark_cv_section_heading");
        }

        // for (const [key, value] of Object.entries(document.getElementsByClassName("ql-editor"))) {
        //     value.style.cssText = "color: inherit !important";
        // }

        //document.getElementsByClassName("cv_section_heading")).map(item => item.classList.add("dark_cv_section_heading"));
    }

    $('#less').click();
    $('#more').show();
    hideLoader();
   }, 350); 


});

// CV Download in a PDF format 





// var window_location = '"'+window.location+'"';
// var origin = window.location.origin;
// var new_user_url = window_location.replace(origin, "");
// var new_user_url = new_user_url.replace('"', "");
// var new_user_url = new_user_url.replace('"', "");
// if(new_user_url == "/onboardingv2/")
// {
// $("#do_it_later").addClass("newuseronboard");
// $("#skip_to_home").addClass("newuseronboard");
// $(".custom-logo-link").attr("href", "/#");
// }

  
Size = Quill.import('attributors/style/size');
Size.whitelist = ['8px','10px','12px', '14px', '16px', '18px','20px','22px','24px','26px','28px','30px','32px'];
Quill.register(this.Size, true);

var max_character = 500;
var toolbarOptions1 = [
  ['bold', 'italic', 'underline','link'],
  [{ size: ['8px','10px','12px','14px', '16px','18px','20px','22px','24px','26px','28px','30px','32px'] },{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'align': [] }, { 'script': 'sub'}, { 'script': 'super' },{ 'indent': '-1'}, { 'indent': '+1' },{ 'color': [] }, { 'background': [] }],
];

var toolbarOptions2 = [
  ['bold', 'italic', 'underline','color','background',{ 'list': 'ordered'},'code-block'],        // toggled buttons
               
];
var toolbarOptions3 = [
  ['bold', 'italic', 'underline','color','background',{ 'list': 'ordered'},'code-block'],        // toggled buttons
  [ 'link', 'image'],             
];
var toolbarOptions4 = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  
  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],
  [ 'link', 'image'],          // add's image support
  ['clean']                                         // remove formatting button
];

var toolbarOptions5 = [
    ['bold', 'italic', 'underline','link'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'script': 'sub'}, { 'script': 'super' }],
  ];

var form_field_summary = new Quill('#form-field-summary', {
  modules: {
    toolbar: toolbarOptions5
  },
  theme: 'snow',
  placeholder: 'eg. A second year Business Administration undergraduate student at University of Michigan with an interest in Data Science…',
});

function hideCV(technical,personal,hobbies,jobrole,industry,typeofwork,language,location,phone,education,work,award,intro,about){
$('#cv_my_skills').css("display","block");
if(technical == 0 && personal == 0 && hobbies == 0)
{
$('#cv_my_skills').css("display","none");
}

$('#cv_career_interests').css("display","block");
if(jobrole == 0 && industry == 0 && typeofwork == 0)
{
$('#cv_career_interests').css("display","none");
}

$('.cv_body_wrapper').css("display","flex");
$('#extract').css("display","block");
$('.empty_cv').css("display","none");

if(technical == 0 || personal == 0 || hobbies == 0 || jobrole == 0 || industry == 0 || typeofwork == 0 || language == 0 || location == 0 || phone == 0 || education == 0 || work == 0 || award == 0 || intro == 0 || about == 0)
{
//$('.cv_body_wrapper, #extract').css("display","none");
//$('.empty_cv').css("display","block");
$('.skip_to_home, .custom-logo-link').attr('href','javascript:open_cv_empty_message()');
}
else{
    $('.skip_to_home, .custom-logo-link').attr('href','/');
}

(education == 0) ? $('#education_btn').html('Add') : $('#education_btn').html('Add more');
(work == 0) ? $('#work_experience_btn').html('Add') : $('#work_experience_btn').html('Add more');
(award == 0) ? $('#award_achievement_btn').html('Add') : $('#award_achievement_btn').html('Add more');

            }

function open_cv_empty_message()
{
	$('#cv_empty_message').css('opacity','1');
	$('#cv_empty_message').css('visibility','visible');
} 

function close_cv_empty_message()
{
	$('#cv_empty_message').css('opacity','0');
	$('#cv_empty_message').css('visibility','hidden');
} 

            
var form_field_institution_description = new Quill('#form-field-institution_description', {
  modules: {
    toolbar: toolbarOptions5
  },
  theme: 'snow',
  placeholder: 'Description',
});

form_field_institution_description.on('text-change', function(delta, oldDelta, source) {   
    if (form_field_institution_description.getLength() > max_character) {
        form_field_institution_description.deleteText(max_character, form_field_institution_description.getLength());
  }
});


var form_field_work_experience_description = new Quill('#form-field-work_experience_description', {
  modules: {
    toolbar: toolbarOptions5
  },
  theme: 'snow',
  placeholder: 'Description',
});

form_field_work_experience_description.on('text-change', function(delta, oldDelta, source) {   
    if (form_field_work_experience_description.getLength() > max_character) {
        form_field_work_experience_description.deleteText(max_character, form_field_work_experience_description.getLength());
  }
});

var form_field_award_achievement_description = new Quill('#form-field-award_achievement_description', {
  modules: {
    toolbar: toolbarOptions5
  },
  theme: 'snow',
  placeholder: 'Description',
});

form_field_award_achievement_description.on('text-change', function(delta, oldDelta, source) {   
    if (form_field_award_achievement_description.getLength() > max_character) {
        form_field_award_achievement_description.deleteText(max_character, form_field_award_achievement_description.getLength());
  }
});

function close_cvPreviewPopUp()
{
	$("#cvPreview").html('');
	$('#cvPreviewPopUp').css('opacity','0');
	$('#cvPreviewPopUp').css('visibility','hidden');
    $('.cv_content_right').css('border-bottom-right-radius','20px');
    $('#less').click();
    $('#more').show();
}

// End preview CV when click on finish button of onboarding last page



// Auto saving when text change about me rich text editor for personal info
self.clearTimeout(timer);
    timer = self.setTimeout(function () {
    form_field_summary.on('text-change', function(delta, oldDelta, source) {   
    if (form_field_summary.getLength() > max_character) {
    form_field_summary.deleteText(max_character, form_field_summary.getLength());
  }
    
    if (source == 'api') {
    //console.log("An API call triggered this change.");
    } else if (source == 'user') {
    keyword = $("#form-field-summary .ql-editor").html();
    if(keyword.trim() != '') {
    self.clearTimeout(timer);
    timer = self.setTimeout(function () {
    savePersonalInfo(); 
    }, 3000) /* time frame 3 seconds */
    }
    }
    });
}, 3000) /* time frame 3 seconds */
// Auto saving when text change about me rich text editor for personal info



//if(window.location.href == window.location.origin+window.location.pathname)
//{
//$(".custom-logo-link").attr("href","#");
//}




// Custom step form javascript

//DOM elements
const DOMstrings = {
    stepsBtnClass: 'multisteps-form__progress-btn',
    stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
    stepsBar: document.querySelector('.multisteps-form__progress'),
    stepsForm: document.querySelector('.multisteps-form__form'),
    stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
    stepFormPanelClass: 'multisteps-form__panel',
    stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
    stepPrevBtnClass: 'js-btn-prev',
    stepNextBtnClass: 'js-btn-next' };
  
  
  //remove class from a set of items
  const removeClasses = (elemSet, className) => {
  
    elemSet.forEach(elem => {
  
      elem.classList.remove(className);
  
    });
  
  };
  
  //return exect parent node of the element
  const findParent = (elem, parentClass) => {
  
    let currentNode = elem;
  
    while (!currentNode.classList.contains(parentClass)) {
      currentNode = currentNode.parentNode;
    }
  
    return currentNode;
  
  };
  
  //get active button step number
  const getActiveStep = elem => {
    return Array.from(DOMstrings.stepsBtns).indexOf(elem);
  };
  
  //set all steps before clicked (and clicked too) to active
  const setActiveStep = activeStepNum => {
  
    //remove active state from all the state
    removeClasses(DOMstrings.stepsBtns, 'js-active');
    removeClasses(DOMstrings.stepsBtns, 'cus-js-done');
    
  
    //set picked items to active
    DOMstrings.stepsBtns.forEach((elem, index) => {
  
      if (index <= activeStepNum) {
        elem.classList.add('js-active');
      }
      if (index < activeStepNum) {
        elem.classList.add('cus-js-done');
      }
  
  
    });
  };
  
  //get active panel
  const getActivePanel = () => {
  
    let activePanel;
  
    DOMstrings.stepFormPanels.forEach(elem => {
  
      if (elem.classList.contains('js-active')) {
  
        activePanel = elem;
  
      }
  
    });
  
    //console.log(activePanel);
    return activePanel;
  
  };
  
  //open active panel (and close unactive panels)
  const setActivePanel = activePanelNum => {
    //remove active class from all the panels
    removeClasses(DOMstrings.stepFormPanels, 'js-active');
  
    //show active panel
    DOMstrings.stepFormPanels.forEach((elem, index) => {
      if (index === activePanelNum) {
  
        elem.classList.add('js-active');

//console.log(activePanelNum);
        // set dynamic title here
switch(activePanelNum){
    case 0: {
       //statements;
       $('#dynamic_title').html(`All right, let’s start with the basics. `);
       $('#display_name').hide();
       break;
    }
    case 1: {
       //statements;
       $('#dynamic_title').html(`Knowledge is the key to success!`);
       $('#display_name').hide();
       break;
    }
    case 2: {
       //statements;
       $('#dynamic_title').html(`Every/Any experience matters, tell us about yours!`);
       $('#display_name').hide();
        break;
     }
     case 3: {
        //statements;
        $('#dynamic_title').html(`What are you good at, and want to be good at?`);
       $('#display_name').hide();
        break;
     }
     case 4: {
        //statements;
        $('#dynamic_title').html(`Dream big! What’s next?`);
       $('#display_name').hide();
        break;
     }
     case 5: {
        //statements;
        $('#dynamic_title').html(`Show the world how well you’ve done!`);
       $('#display_name').hide();
        break;
     }
    default: {
       //statements;
        break;
    }
 }

  
        setFormHeight(elem);
  
      }
    });
  
  };
  
  //set form height equal to current panel height
  const formHeight = activePanel => {
  
    const activePanelHeight = activePanel.offsetHeight;
  
   // DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;
   //console.log(activePanelHeight);
  
   //form_element  = document.querySelector('cv_heading');
    const form_element = document.getElementById('cv_heading_id');
    const form_height_value = form_element.offsetHeight;
    //console.log(form_height_value);
    //console.log(activePanelHeight-form_height_value);
    const cv_body_content =  document.getElementById('cv_body_wrapper_id');

    const cv_outer_body =  document.getElementById('content');
    cv_outer_body.style.height=activePanelHeight+"px";
    cv_outer_body.style.overflowY="hidden";
    cv_outer_body.style.overflowX="hidden";
    
    
    //cv_body_content.style.overflowY="auto";
    //cv_body_content.style.overflowX="hidden";

   // cv_body_content.style.height="auto !important";


    var cv_body_wrapper_height = document.getElementById('cv_body_wrapper_id').offsetHeight;
        /*
        console.log(activePanelHeight);
        console.log(form_height_value);
        console.log(cv_body_wrapper_height);
        */
    const cv_content_right =  document.getElementById('cv_content_right');
    //cv_content_right.style.minHeight=activePanelHeight-form_height_value+"px";
   //cv_content_right.style.height="min-content"
    
  //  cv_content_right.style.minHeight=cv_body_wrapper_height+"px";
    //cv_content_right.style.height=cv_body_wrapper_height+"px";
    

   // cv_body_content.style.height=activePanelHeight-form_height_value+"px";
    //cv_body_content.style.overflowY="auto";
  //  cv_body_content.style.overflowX="hidden";

  };
  
  const setFormHeight = () => {
    const activePanel = getActivePanel();
  
    formHeight(activePanel);
  };
  
  //STEPS BAR CLICK FUNCTION
  DOMstrings.stepsBar.addEventListener('click', e => {
  
    //check if click target is a step button
    const eventTarget = e.target;
    var bar_id = eventTarget.id;

    //console.log(bar_id);
  
    if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
      return;
    }
  
    //get active button step number
    const activeStep = getActiveStep(eventTarget);

    switch(activeStep){
    // case 0: {
    //    //statements;
    //    break;
    // }
    // case 1: {
    //    //statements;
    //    break;
    // }
    // case 2: {
    //     //statements;
    //     break;
    //  }
    //  case 3: {
    //     //statements;
    //     break;
    //  }
    //  case 4: {
    //     //statements;
    //     break;
    //  }
    //  case 5: {
    //     //statements;
    //     break;
    //  }
    default: {
       //statements;
        var first_name = $('#form-field-first_name').val();
        var last_name = $('#form-field-last_name').val();
        var email = $('#form-field-email').val();
        var dob = $('#form-field-dob').val();
        var current_location = $('#form-field-current_location').val();
        var languages_count = $("#profile_info_language_chip").children().length;
        if(first_name == '' || last_name == '' || email == '' || dob == '' || current_location == '' || languages_count == 0)
        {
            savePersonalInfo(success => {
            if(success) $('#personal_info_next').click();
            });
            //e.preventDefault();
            return false;
        }
        break;
    }
 }
  
    //set all steps before clicked (and clicked too) to active
    setActiveStep(activeStep);
  
    //open active panel
    setActivePanel(activeStep);
  });
  
  //PREV/NEXT BTNS CLICK
  DOMstrings.stepsForm.addEventListener('click', e => {
    const eventTarget = e.target;
    var btn_id = eventTarget.id;

    switch(btn_id){
        case "personal_info_next":
            var first_name = $('#form-field-first_name').val();
            var last_name = $('#form-field-last_name').val();
            var email = $('#form-field-email').val();
            var dob = $('#form-field-dob').val();
            var current_location = $('#form-field-current_location').val();
            var languages_count = $("#profile_info_language_chip").children().length;
            if(first_name == '' || last_name == '' || email == '' || dob == '' || current_location == '' || languages_count == 0)
            {
                savePersonalInfo();
                //e.preventDefault();
                return false;
            }
            break;


            case "education_next":
            var institution_name = $('#form-field-institution_name').val();
            var institution_location = $('#form-field-institution_location').val();
            var institution_specialisation = $('#form-field-institution_specialisation').val();
            var institution_degree = $('#form-field-institution_degree').val();
            var institution_from_year = $('#form-field-institution_from_year').val();
            var institution_to_year = $("#form-field-institution_to_year").val();
            var institution_description = $("#form-field-institution_description .ql-editor").html().trim();
            if(institution_description.replace(/<(.|\n)*?>/g, '') == 0) institution_description = '';

            if(institution_name != '' || institution_location != '' || institution_specialisation != '' || institution_degree != '' || institution_from_year != '' || institution_to_year != '' || institution_description != '')
            {
                addEducation(success => {
                if(success)
                {
                    $('#education_next').click();
                }
                });
                return false;              
            }
            break;


            case "work_experience_next":
            var work_experience_title = $('#form-field-work_experience_title').val();
            var work_experience_employment_type = $('#form-field-work_experience_employment_type').val();
            var work_experience_company_name = $('#form-field-work_experience_company_name').val();
            var work_experience_location = $('#form-field-work_experience_location').val();
            var work_experience_from_date = $('#form-field-work_experience_from_date').val();
            var work_experience_to_date = $("#form-field-work_experience_to_date").val();
            var work_experience_description = $("#form-field-work_experience_description .ql-editor").html().trim();
            if(work_experience_description.replace(/<(.|\n)*?>/g, '') == 0) work_experience_description = '';

            if(work_experience_title != '' || work_experience_employment_type != '' || work_experience_company_name != '' || work_experience_location != '' || work_experience_from_date != '' || work_experience_to_date != '' || work_experience_description != '')
            {
                addWorkExperience(success => {
                if(success)
                {
                    $('#work_experience_next').click();
                }
                });
                return false;              
            }
            break;


        case "award_achievement_finish":
            var award_achievement_title = $('#form-field-award_achievement_title').val();
            var award_achievement_awarded_by = $('#form-field-award_achievement_awarded_by').val();
            var award_achievement_issue_date = $('#form-field-award_achievement_issue_date').val();
            var award_achievement_link = $('#form-field-award_achievement_link').val();
            var award_achievement_description = $("#form-field-award_achievement_description .ql-editor").html().trim();
            if(award_achievement_description.replace(/<(.|\n)*?>/g, '') == 0) award_achievement_description = '';

            if(award_achievement_title != '' || award_achievement_awarded_by != '' || award_achievement_issue_date != '' || award_achievement_link != '' || award_achievement_description != '')
            {
                addAwardAchievement(success => {
                if(success)
                {
                    setTimeout(function(){
                    $('#award_achievement_finish').click();
                    }, 2000);
                }
                });
                return false;              
            }
            else
            {
                $('#more').click();
                $("#cvPreview").html($("#content").html());
                $("#cvPreview").append(`<script>// CV Download in a PDF format 
                $('#cvPreview #extract').attr('class','new_extract_preview');
$('.new_extract_preview').click(function() {
     showLoader();
     //$('#download_msg').html('Your cv is downloading now ...')
     var fileName = document.getElementById("display_name").innerHTML;
     //var extra_space = 30;
     //var currentPosition = document.getElementById("content").scrollTop;
     var offsetHeight = document.getElementById('content').offsetHeight;
     

     document.getElementById("content").style.cssText = "overflow:auto; height: auto; border-radius:0px;";
     document.getElementById("cv_heading_id").style.cssText = "border-top-left-radius: 0px; border-top-right-radius: 0px";
     document.getElementById("cv_content_right").style.cssText = " border-bottom-right-radius: 0px;";
    //  document.getElementsByClassName("cv_content_right")[0].style.cssText = "border-bottom-right-radius: 0px;";
    //  document.getElementsByClassName("cv_body_wrapper")[0].style.cssText = "border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;";
     //document.getElementById("cv_content_right").style.cssText = "margin-bottom: -"+extra_space+"px";
     document.getElementById("extract").style.display="none";
     //document.getElementById("empty_cv").style.display="none";


     var is_dark_mode = false;
     if(document.getElementById("content").classList.contains("dark_cv_main_container"))
     {
        is_dark_mode = true;
        document.getElementById("content").classList.remove("dark_cv_main_container");
        document.getElementsByClassName("cv_heading")[0].classList.remove("dark_cv_heading");
        document.getElementById("cv_content_right").classList.remove("dark_cv_content_right");
        document.getElementById("cv_content_left_footer_id").classList.remove("dark_cv_content_left_footer");
        
        //document.getElementsByClassName("cv_section_desc")[0].style.cssText = "color: #535353";
        for (const [key, value] of Object.entries(document.getElementsByClassName("cv_section_heading"))) {
            value.classList.remove("dark_cv_section_heading");
        }

        // for (const [key, value] of Object.entries(document.getElementsByClassName("ql-editor"))) {
        //     value.style.cssText = "color: #535353 !important";
        // }
       

        //document.getElementsByClassName("cv_section_heading")).map(item => item.classList.remove("dark_cv_section_heading"));
     }

     $('#more').click();
     $('#less').hide();
     var w = document.getElementById("content").offsetWidth;
     var h = document.getElementById("content").offsetHeight;

    //  html2canvas(document.querySelector('#content'), {useCORS: true, dpi: 300, scale: 3}).then(function(canvas) {
    //   let img = new Image();
    //   img.src = canvas.toDataURL('image/png');
      
        // img.onload = function () {
        // let pdf = new jsPDF('P', 'mm', 'a4');
        // pdf.addImage(img, 'JPEG', 0, 0, '210', '297', undefined, 'FAST');
        // pdf.save(fileName+"_Bio.pdf");
        
        // var string = pdf.output('datauristring');
        // var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
        // var x = window.open();
        // x.document.open();
        // x.document.write(embed);
        // x.document.close();
        //   };

        // img.onload = function () {
        // let pdf = new jsPDF('P', 'px', [w, h]);
        // pdf.addImage(img, 'JPEG', 0, 0, w, h, undefined, 'FAST');
        // pdf.save(fileName+"_Bio.pdf");
        
        // var string = pdf.output('datauristring');
        // var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
        // var x = window.open();
        // x.document.open();
        // x.document.write(embed);
        // x.document.close();
        //     };
      
        /* img.onload = function () {
         let pdf = new jsPDF('landscape', 'mm', 'a4');
         pdf.addImage(img, 0, 0, pdf.internal.pageSize.width, pdf.internal.pageSize.height,undefined,'FAST');
         pdf.save('certificate.pdf');
       }; */

    // });



    var element = document.getElementById('content');
    var opt = {
        margin:       [10, 10, 10, 10],
        filename:     fileName+"_cv.pdf",
        image:        { type: 'jpeg',quality: 0.98 },
        html2canvas:  { dpi: 100, scale: 2, scrollX: 0, scrollY: 0, backgroundColor: '#FFF' },
        jsPDF:        { unit: 'pt', format: 'a4', orientation: 'p', footer: 'a' },
        enableLinks:  true,
        // pagebreak: { mode: ['avoid-all', 'css', 'legacy'], avoid: 'img' },
        pagebreak: { mode: ['avoid-all']},
    };

    html2pdf()
    .from(element)
    .set(opt)
    .toPdf()
    .get('pdf').then(function (pdf) {
        var totalPages = pdf.internal.getNumberOfPages();
        for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);
        pdf.setFontSize(10);
        pdf.setTextColor(150);
        //pdf.text("my header text", (pdf.internal.pageSize.getWidth()/2), 10);
        //pdf.text(i+'/'+totalPages, (pdf.internal.pageSize.getWidth()/2), (pdf.internal.pageSize.getHeight() - 8));
        //pdf.html('<div>Test</div>', (pdf.internal.pageSize.getWidth()/2), (pdf.internal.pageSize.getHeight() - 8))
        } 
        window.open(pdf.output('bloburl'), '_blank');
    }).save();


    //  html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
    //  var totalPages = pdf.internal.getNumberOfPages(); 
    
    //  for (var i = 1; i <= totalPages; i++) {
    //    pdf.setPage(i);
    //    pdf.setFontSize(10);
    //    pdf.setTextColor(150);
    //    pdf.text('Page ' + i + ' of ' + totalPages, pdf.internal.pageSize.getWidth() - 100, 
    //    pdf.internal.pageSize.getHeight() - 30);
    //  } 
    //  }).save()

    //  html2pdf().from(element).set(opt).toPdf().get('pdf').then(function (pdf) {
    //     var totalPages = pdf.internal.getNumberOfPages();
      
    //     for (i = 1; i <= totalPages; i++) {
    //       pdf.setPage(i);
    //       pdf.setFontSize(10);
    //       pdf.setTextColor(150);
    //       pdf.text(i+'/'+totalPages, (pdf.internal.pageSize.getWidth()/2), (pdf.internal.pageSize.getHeight() - 0.3));
    //     } 
    //   }).save();
    
    setTimeout(function(){ 
	document.getElementById("content").style.cssText = "height:"+offsetHeight+"px; overflow: hidden; ";
    
     document.getElementById("cv_content_right").style.cssText = "border-bottom-right-radius: 20px;";
    document.getElementById("cv_heading_id").style.cssText = "border-top-left-radius: 20px; border-top-right-radius: 20px";
    // document.getElementsByClassName("cv_body_wrapper")[0].style.cssText = "border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;";
    //document.getElementById("cv_content_right").style.cssText = "margin-bottom: 0px";
	document.getElementById("extract").style.display="block";
    //document.getElementById("empty_cv").style.display="block";
    //document.getElementById("content").scrollTop = currentPosition + extra_space;

    if(is_dark_mode)
    {
        document.getElementById("content").classList.add("dark_cv_main_container");
        document.getElementsByClassName("cv_heading")[0].classList.add("dark_cv_heading");
        document.getElementById("cv_content_right").classList.add("dark_cv_content_right");
        document.getElementById("cv_content_left_footer_id").classList.add("dark_cv_content_left_footer");
        //document.getElementsByClassName("cv_section_desc")[0].style.cssText = "color: inherit !important";
        for (const [key, value] of Object.entries(document.getElementsByClassName("cv_section_heading"))) {
            value.classList.add("dark_cv_section_heading");
        }

        // for (const [key, value] of Object.entries(document.getElementsByClassName("ql-editor"))) {
        //     value.style.cssText = "color: inherit !important";
        // }

        //document.getElementsByClassName("cv_section_heading")).map(item => item.classList.add("dark_cv_section_heading"));
    }

    $('#less').click();
    $('#more').show();
    hideLoader();
   }, 350); 


});

// CV Download in a PDF format </script>`);
            //$("#cvPreview #extract").remove();
            $('#cvPreview #less').remove();
            $('#cvPreviewPopUp').css('opacity','1');
            $('#cvPreviewPopUp').css('visibility','visible');
            $('.cv_content_right').css('border-bottom-right-radius','0px');
            //e.preventDefault();
            return false;
        }
        default: {
            //statements;
            break;
         }
    }

  
    //check if we clicked on `PREV` or NEXT` buttons
    if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
    {
      return;
    }
  
    //find active panel
    const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);
  
    let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

    //set active step and active panel onclick
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
      activePanelNum--;
    } else {
      activePanelNum++;
    }
  
    setActiveStep(activePanelNum);
    setActivePanel(activePanelNum);
  
  });
  
  //SETTING PROPER FORM HEIGHT ONLOAD
  window.addEventListener('load', setFormHeight, false);
  
  //SETTING PROPER FORM HEIGHT ONRESIZE
  window.addEventListener('resize', setFormHeight, false);
  
  //changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)
  
  const setAnimationType = newType => {
    DOMstrings.stepFormPanels.forEach(elem => {
      elem.dataset.animation = newType;
    });
  };
  
  
  
  /*
  <!--animations form-->
        <form class="pick-animation my-4">
          <div class="form-row">
            <div class="col-5 m-auto">
              <select class="pick-animation__select form-control">
                <option value="scaleIn" selected="selected">ScaleIn</option>
                <option value="scaleOut">ScaleOut</option>
                <option value="slideHorz">SlideHorz</option>
                <option value="slideVert">SlideVert</option>
                <option value="fadeIn">FadeIn</option>
              </select>
            </div>
          </div>
        </form>
  */
  
  /*
  //selector onchange - changing animation
  const animationSelect = document.querySelector('.pick-animation__select');
  
  animationSelect.addEventListener('change', () => {
    //const newAnimationType = animationSelect.value;
  const newAnimationType='slideVert';
    setAnimationType(newAnimationType);
  });
  */
  setAnimationType("slideHorz");
  
  // Custom stem form javascript

      /*VIEW PROFILE SECTION*/
      function show_cv_viewer()
      {
          $("#cv_viewer").html("Close Profile");
          $('#cus_right_cv_view').show();
      
           $('#cv_viewer').removeAttr("onclick");
          
           $('#cus_left_cv_view').hide();
          
           $("#cv_viewer").attr("onclick","close_cv_viewer()");
          
           
      }
      
      function close_cv_viewer()
      {
           var element = document.getElementById('cus_right_cv_view');
           element.style.display = "none";
           document.getElementById("cv_viewer").removeAttribute("onclick");
          
          
           var element1 = document.getElementById('cus_left_cv_view');
           element1.style.display = "block";
           document.getElementById("cv_viewer").setAttribute("onclick","show_cv_viewer()");
           document.getElementById("cv_viewer").innerHTML = "View Profile";
      }
