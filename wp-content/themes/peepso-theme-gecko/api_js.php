<?php
require_once ('../../../wp-config.php');
$similartites_url = Similartites_URL;
if(isset($similartites_url) && $similartites_url != null)
{
    $remote_server_url = $similartites_url;
}
else
{
    $remote_server_url = 'https://127.0.0.1:3000';
}

// Onboarding started - Written by William Thoudam

/**
 * Template Name: Onboarding Custom PHP Function
 */
 
 //header("Access-Control-Allow-Origin: *");
 header("Access-Control-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
 
 
// Handle AJAX request (start)



///// COUNTRY CODE START /////

if( isset($_GET['get_country_code']) ){
	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $table_name = $wpdb->prefix . 'country_code_master';
    $result = $wpdb->get_results("SELECT * FROM $table_name");
        $result = json_decode(json_encode($result), true);
        
        $output = array('success'=>true,'auth'=>true,'result'=>$result);
    }
 	echo json_encode($output);
 	exit;
}

///// COUNTRY CODE START /////


///// PERSONAL INFO START /////

if( isset($_GET['get_profile_info']) ){
	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    	$users = $wpdb->prefix . 'users';
        $usermeta = $wpdb->prefix . 'usermeta';
        $country_code_master = $wpdb->prefix . 'country_code_master';
        
        $username1 = $wpdb->get_row("SELECT user_login FROM $users WHERE ID = 
        $current_user_id");
        $username1 = json_decode(json_encode($username1), true)['user_login'];
        if($username1 == $_GET['payload']['username'] || $_GET['payload']['username'] == '')
        {
        	$current_user_id = get_current_user_id();
            $query1 = "SELECT * FROM $usermeta WHERE user_id = 
        $current_user_id AND meta_key IN ('first_name','last_name','description','peepso_user_field_2429','peepso_user_field_2428','peepso_user_field_247','peepso_user_field_birthdate','peepso_user_field_gender','peepso_user_field_10877')";
        $query2 = "SELECT user_email,user_login,user_url,display_name FROM $users WHERE ID = 
        $current_user_id";
        }
        else
        {
        $username2 = $wpdb->get_row("SELECT ID FROM $users WHERE user_login = 
        '".$_GET['payload']['username']."'");
        $current_user_id = json_decode(json_encode($username2), true)['ID'];
        if(empty($current_user_id))
    {
    	$output = array('success'=>false,'auth'=>true,'msg'=>'username not found.');
        echo json_encode($output);
 		exit;
    }
        
        $query1 = "SELECT * FROM $usermeta WHERE user_id = 
        $current_user_id AND meta_key IN ('first_name','last_name','description','peepso_user_field_2428','peepso_user_field_247','peepso_user_field_birthdate','peepso_user_field_gender','peepso_user_field_10877')";
        $query2 = "SELECT id,user_login,user_url,display_name FROM $users WHERE ID = 
        $current_user_id";
        }
    
        	
        $result1 = $wpdb->get_results($query1);

        $result1 = json_decode(json_encode($result1), true);
        $arr = array();
        foreach($result1 as $row)
        {
       $arr[$row['meta_key']] = $row['meta_value'];
        }
        
        $result2 = $wpdb->get_row($query2);

        $result2 = json_decode(json_encode($result2), true);
        
        $onboarding = $wpdb->prefix . 'onboarding';
        $result3 = $wpdb->get_row("SELECT personal_info_current_location,personal_info_facebook_link,personal_info_twitter_link,personal_info_instagram_link,personal_info_linkedin_link FROM $onboarding WHERE user_id = 
        $current_user_id");
        
        $result3 = json_decode(json_encode($result3), true);
        
        if(!$result3['personal_info_current_location'])
        {
        	$result3['personal_info_current_location'] = '';
        }
        if(!$result3['personal_info_facebook_link'])
        {
        	$result3['personal_info_facebook_link'] = '';
        }
        if(!$result3['personal_info_instagram_link'])
        {
        	$result3['personal_info_instagram_link'] = '';
        }
        if(!$result3['personal_info_linkedin_link'])
        {
        	$result3['personal_info_linkedin_link'] = '';
        }
        if(!$result3['personal_info_twitter_link'])
        {
        	$result3['personal_info_twitter_link'] = '';
        }
        
        $current_user_id = get_current_user_id();
        $result4 = $wpdb->get_row("SELECT user_login FROM $users WHERE ID = $current_user_id
        ");
    $result4 = json_decode(json_encode($result4), true);
    
    //$arr['first_name'] = explode(" ",$result2['display_name'])[0] ? explode(" ",$result2['display_name'])[0] : '';
    //$arr['last_name'] = explode(" ",$result2['display_name'])[1] ? explode(" ",$result2['display_name'])[1] : '';
    
    if(!$arr['peepso_user_field_2427'])
    {
    	$arr['peepso_user_field_2427'] = '';
    }
    
    if(!$arr['peepso_user_field_2428'])
    {
    	$arr['peepso_user_field_2428'] = '';
    }
    
    if(!$arr['peepso_user_field_2429'])
    {
    	$arr['peepso_user_field_2429'] = '';
    }
    
     if(!$arr['peepso_user_field_10877'])
    {
    	$arr['peepso_user_field_10877'] = 'a:0:{}';
    }
    
    $arr['peepso_user_field_10877'] = unserialize($arr['peepso_user_field_10877']);

    $country_code = $arr['peepso_user_field_247'];
    $result5 = $wpdb->get_row("SELECT dial FROM $country_code_master WHERE code = '".$country_code."'");
    if(!$result5)
    {
        $result5['dial'] = '';
    }
    
        $output = array('success'=>true,'auth'=>true,'result1'=>$arr,'result2'=>$result2,'result3'=>$result3,'result4'=>$result4,'result5'=>$result5);
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['update_profile_info']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $payload = $_POST['payload'];
    
    $onboarding = $wpdb->prefix . 'onboarding';
    $usermeta = $wpdb->prefix . 'usermeta';
    $users = $wpdb->prefix . 'users';
    
    ////// validation start //////
    
    if($payload['first_name'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'First name is required !');
        echo json_encode($output);
        exit;
    }
    
    if($payload['last_name'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Last name is required!');
        echo json_encode($output);
        exit;
    }

    if(strlen($payload['phone']) != 0)
    {
        if($payload['country_code'] == '')
            {
                $output = array('success' => false,'auth'=>true,'msg' => 'Country code is required!');
                echo json_encode($output);
                exit;
            }
    }

    if(strlen($payload['country_code']) != '')
    {
        if(strlen($payload['phone']) == 0)
    	{
        $output = array('success' => false,'auth'=>true,'msg' => 'Phone number is required!');
        echo json_encode($output);
        exit;
        }
        else if(strlen($payload['phone']) < 4 || strlen($payload['phone']) > 15)
        {
            if(strlen($payload['phone']) != 0)
            {
                    $output = array('success' => false,'auth'=>true,'msg' => 'Invalid phone number !');
                    echo json_encode($output);
                    exit;
            }
        }
    }
    
    if(strlen($payload['phone']) < 4 || strlen($payload['phone']) > 15)
    {
    	if(strlen($payload['phone']) != 0)
    	{
                $output = array('success' => false,'auth'=>true,'msg' => 'Invalid phone number !');
                echo json_encode($output);
                exit;
        }
    }   
   else
   {
            $phoneNumber = $wpdb->get_results("SELECT user_id FROM ".$usermeta." WHERE user_id != $current_user_id AND meta_key = 'peepso_user_field_2429' AND meta_value = '".$payload['phone']."'");
            $phoneNumber = json_decode(json_encode($phoneNumber), true);
            if(sizeof($phoneNumber) > 0)
            { 
                $countryCode = $wpdb->get_results("SELECT user_id FROM ".$usermeta." WHERE user_id = ".$phoneNumber[0]['user_id']." AND meta_key = 'peepso_user_field_247' AND meta_value = '".$payload['country_code']."'");
                $countryCode = json_decode(json_encode($countryCode), true);   
                if(sizeof($countryCode) > 0)
                {
                    $output = array('success' => false,'auth'=>true,'msg' => ' Phone number is already in use.');
                    echo json_encode($output);
                    exit;
                }
            }
    }
    
     if($payload['current_location'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Current location is required!');
        echo json_encode($output);
        exit;
    }
    
    if($payload['languages_count'] == 0)
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Atleast one language is required!');
        echo json_encode($output);
        exit;
    }
   
    
    
    ////// validation end //////
    
    $country_code = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_247'");
    $country_code = json_decode(json_encode($country_code), true);
    if(sizeof($country_code) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => $payload['country_code']), array("umeta_id" => $country_code['umeta_id']), array("%s"), array("%d") );
    }
   else
   {
        $sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %s)", $current_user_id, 'peepso_user_field_247', $payload['country_code'] );
        $wpdb->query($sql5);
        
        $sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_247_acc', 10 );
        $wpdb->query($sql6);
    }
    
    $phone = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_2429'");
    $phone = json_decode(json_encode($phone), true);
    if(sizeof($phone) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => $payload['phone']), array("umeta_id" => $phone['umeta_id']), array("%s"), array("%d") );
    }
   else
   {
        $sql1 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_2429', $payload['phone'] );
        $wpdb->query($sql1);
        
        $sql2 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_2429_acc', 10 );
        $wpdb->query($sql2);
    }
    
    
    $headline = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_2428'");
    $headline = json_decode(json_encode($headline), true);
    if(sizeof($headline) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => str_replace("\\", '', str_replace("'", '&rsquo;', $payload['headline']))), array("umeta_id" => $headline['umeta_id']), array("%s"), array("%d") );
    }
   else
   {
        $sql3 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %s)", $current_user_id, 'peepso_user_field_2428', str_replace("\\", '', str_replace("'", '&rsquo;', $payload['headline'])) );
        $wpdb->query($sql3);
        
        $sql4 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_2428_acc', 10 );
        $wpdb->query($sql4);
    }
    
    $first_name = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'first_name'");
    $first_name = json_decode(json_encode($first_name), true);
    if(sizeof($first_name) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => str_replace("\\", '', str_replace("'", '&rsquo;', $payload['first_name']))), array("umeta_id" => $first_name['umeta_id']), array("%s"), array("%d") );
    }
    
    $last_name = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'last_name'");
    $last_name = json_decode(json_encode($last_name), true);
    if(sizeof($last_name) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => str_replace("\\", '', str_replace("'", '&rsquo;', $payload['last_name']))), array("umeta_id" => $last_name['umeta_id']), array("%s"), array("%d") );
    }
    
    
    
    $wpdb->update($users, array("display_name" => str_replace("\\", '', str_replace("'", '&rsquo;', $payload['first_name'])).' '.str_replace("\\", '', str_replace("'", '&rsquo;', $payload['last_name']))), array("ID" => $current_user_id), array("%s"), array("%d") );
    
    
    
    $gender = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_gender'");
    $gender = json_decode(json_encode($gender), true);
    if(sizeof($gender) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => $payload['gender']), array("umeta_id" => $gender['umeta_id']), array("%s"), array("%d") );
    }
    
    $dob = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_birthdate'");
    $dob = json_decode(json_encode($dob), true);
    if(sizeof($dob) > 0)
    { 
        //$wpdb->update($usermeta, array("meta_value" => $payload['dob']), array("umeta_id" => $dob['umeta_id']), array("%s"), array("%d") );
    }
    
    $current_location = $wpdb->get_row("SELECT id FROM ".$onboarding." WHERE user_id = $current_user_id");
        $current_location = json_decode(json_encode($current_location), true);
        if(sizeof($current_location) > 0)
        { 
            $wpdb->update($onboarding, array("personal_info_current_location" => $payload['current_location']), array("id" => $current_location['id']), array("%s"), array("%d") );
        }
       else
       {
            $current_location_sql = $wpdb->prepare( "INSERT INTO ".$onboarding." (user_id,personal_info_current_location) VALUES ( %d, %s)", $current_user_id, $payload['current_location'] );
            $wpdb->query($current_location_sql);
        }
    
    
    $summary = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'description'");
    $summary = json_decode(json_encode($summary), true);
    if(sizeof($summary) > 0)
    { 
        $wpdb->update($usermeta, array("meta_value" => str_replace("\\", '', str_replace("'", '&rsquo;', $payload['summary']))), array("umeta_id" => $summary['umeta_id']), array("%s"), array("%d") );
    }

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully saved.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['update_social_media_link_old']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $payload = $_POST['payload'];
    
    
    ////// validation start //////
    
    if($payload['link_type'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Social media is required !');
        echo json_encode($output);
        exit;
    }
    
    if($payload['link'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Link is required!');
        echo json_encode($output);
        exit;
    }
    
    ////// validation end //////
    
    
	$users = $wpdb->prefix . 'users';
    $usermeta = $wpdb->prefix . 'usermeta';
       
    if($payload['link_type'] == 'facebook')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3039'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3039', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3039_acc', 10 );
            //$wpdb->query($sql6);
        }
    }
    
    if($payload['link_type'] == 'twitter')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3040'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3040', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3040_acc', 10 );
            //$wpdb->query($sql6);
        }
    }
    
    // if($payload['link_type'] == 'website')
// {
//     $link = $wpdb->get_row("SELECT ID FROM ".$users." WHERE ID = $current_user_id");
//     $link = json_decode(json_encode($link), true);
//     if(sizeof($link) > 0)
//     {
//         $wpdb->update($users, array("user_url" => $payload['link']), array("ID" => $link['ID']), array("%s"), array("%d") );
//     }
// }
    
    if($payload['link_type'] == 'instagram')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3041'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3041', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3041_acc', 10 );
            //$wpdb->query($sql6);
        }
    }
    
    if($payload['link_type'] == 'linkedin')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3042'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3042', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3042_acc', 10 );
            //$wpdb->query($sql6);
        }
    }

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['delete_social_media_chip_old']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $payload = $_POST['payload'];
    
    
	$users = $wpdb->prefix . 'users';
    $usermeta = $wpdb->prefix . 'usermeta';
       
    if($payload['link_type'] == 'facebook')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3039'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3039', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3039_acc', 10 );
            //$wpdb->query($sql6);
        }
    }
    
    if($payload['link_type'] == 'twitter')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3040'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3040', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3040_acc', 10 );
            //$wpdb->query($sql6);
        }
    }
    
    // if($payload['link_type'] == 'website')
// {
//     $link = $wpdb->get_row("SELECT ID FROM ".$users." WHERE ID = $current_user_id");
//     $link = json_decode(json_encode($link), true);
//     if(sizeof($link) > 0)
//     {
//         $wpdb->update($users, array("user_url" => $payload['link']), array("ID" => $link['ID']), array("%s"), array("%d") );
//     }
// }
    
    if($payload['link_type'] == 'instagram')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3041'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3041', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3041_acc', 10 );
            //$wpdb->query($sql6);
        }
    }
    
    if($payload['link_type'] == 'linkedin')
    {
        $link = $wpdb->get_row("SELECT umeta_id FROM ".$usermeta." WHERE user_id = $current_user_id AND meta_key = 'peepso_user_field_3042'");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($usermeta, array("meta_value" => $payload['link']), array("umeta_id" => $link['umeta_id']), array("%s"), array("%d") );
        }
       else
       {
            //$sql5 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3042', $payload['link'] );
            //$wpdb->query($sql5);

            //$sql6 = $wpdb->prepare( "INSERT INTO ".$usermeta." (user_id,meta_key,meta_value) VALUES ( %d, %s, %d)", $current_user_id, 'peepso_user_field_3042_acc', 10 );
            //$wpdb->query($sql6);
        }
    }

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully deleted.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['update_social_media_link']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $payload = $_POST['payload'];
    
    
    ////// validation start //////
    
    if($payload['link_type'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Social media is required !');
        echo json_encode($output);
        exit;
    }
    
    if($payload['link'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Link is required!');
        echo json_encode($output);
        exit;
    }
    
    ////// validation end //////
    
    
	$onboarding = $wpdb->prefix . 'onboarding';
       
    if($payload['link_type'] == 'facebook')
    {
        $link = $wpdb->get_row("SELECT id FROM ".$onboarding." WHERE user_id = $current_user_id");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($onboarding, array("personal_info_facebook_link" => $payload['link']), array("id" => $link['id']), array("%s"), array("%d") );
        }
       else
       {
            $sql5 = $wpdb->prepare( "INSERT INTO ".$onboarding." (user_id,personal_info_facebook_link) VALUES ( %d, %s)", $current_user_id, $payload['link'] );
            $wpdb->query($sql5);
        }
    }
    
    if($payload['link_type'] == 'twitter')
    {
        $link = $wpdb->get_row("SELECT id FROM ".$onboarding." WHERE user_id = $current_user_id");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($onboarding, array("personal_info_twitter_link" => $payload['link']), array("id" => $link['id']), array("%s"), array("%d") );
        }
       else
       {
            $sql5 = $wpdb->prepare( "INSERT INTO ".$onboarding." (user_id,personal_info_twitter_link) VALUES ( %d, %s)", $current_user_id, $payload['link'] );
            $wpdb->query($sql5);
        }
    }
    
    // if($payload['link_type'] == 'website')
// {
//     $link = $wpdb->get_row("SELECT ID FROM ".$users." WHERE ID = $current_user_id");
//     $link = json_decode(json_encode($link), true);
//     if(sizeof($link) > 0)
//     {
//         $wpdb->update($users, array("user_url" => $payload['link']), array("ID" => $link['ID']), array("%s"), array("%d") );
//     }
// }
    
    if($payload['link_type'] == 'instagram')
    {
        $link = $wpdb->get_row("SELECT id FROM ".$onboarding." WHERE user_id = $current_user_id");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($onboarding, array("personal_info_instagram_link" => $payload['link']), array("id" => $link['id']), array("%s"), array("%d") );
        }
       else
       {
            $sql5 = $wpdb->prepare( "INSERT INTO ".$onboarding." (user_id,personal_info_instagram_link) VALUES ( %d, %s)", $current_user_id, $payload['link'] );
            $wpdb->query($sql5);
        }
    }
    
    if($payload['link_type'] == 'linkedin')
    {
        $link = $wpdb->get_row("SELECT id FROM ".$onboarding." WHERE user_id = $current_user_id");
        $link = json_decode(json_encode($link), true);
        if(sizeof($link) > 0)
        { 
            $wpdb->update($onboarding, array("personal_info_linkedin_link" => $payload['link']), array("id" => $link['id']), array("%s"), array("%d") );
        }
       else
       {
            $sql5 = $wpdb->prepare( "INSERT INTO ".$onboarding." (user_id,personal_info_linkedin_link) VALUES ( %d, %s)", $current_user_id, $payload['link'] );
            $wpdb->query($sql5);
        }
    }

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['delete_social_media_chip']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $payload = $_POST['payload'];
    
    
	$onboarding = $wpdb->prefix . 'onboarding';
       
    if($payload['link_type'] == 'facebook')
    {
           $wpdb->update($onboarding, array("personal_info_facebook_link" => $payload['link']), array("user_id" => $current_user_id), array("%s"), array("%d") );       
    }
    
    if($payload['link_type'] == 'twitter')
    {
        $wpdb->update($onboarding, array("personal_info_twitter_link" => $payload['link']), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }
    
    // if($payload['link_type'] == 'website')
// {
//     $link = $wpdb->get_row("SELECT ID FROM ".$users." WHERE ID = $current_user_id");
//     $link = json_decode(json_encode($link), true);
//     if(sizeof($link) > 0)
//     {
//         $wpdb->update($users, array("user_url" => $payload['link']), array("ID" => $link['ID']), array("%s"), array("%d") );
//     }
// }
    
    if($payload['link_type'] == 'instagram')
    {
        $wpdb->update($onboarding, array("personal_info_instagram_link" => $payload['link']), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }
    
    if($payload['link_type'] == 'linkedin')
    {
        $wpdb->update($onboarding, array("personal_info_linkedin_link" => $payload['link']), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}

///// PERSONAL INFO END //////




///// EDUCATION START /////

if( isset($_GET['list_education']) ){
	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {   
    	$users = $wpdb->prefix . 'users';      
        $username1 = $wpdb->get_row("SELECT user_login FROM $users WHERE ID = 
        $current_user_id");
        $username1 = json_decode(json_encode($username1), true)['user_login'];
        if($username1 == $_GET['payload']['username'] || $_GET['payload']['username'] == '')
        {
        	$current_user_id = get_current_user_id();
        }
        else
        {
        $username2 = $wpdb->get_row("SELECT ID FROM $users WHERE user_login = 
        '".$_GET['payload']['username']."'");
        $current_user_id = json_decode(json_encode($username2), true)['ID'];
        }
    
        $table_name = $wpdb->prefix . 'onboarding';	
        $result = $wpdb->get_row("SELECT education_json FROM $table_name WHERE user_id = 
        $current_user_id");

        $result = json_decode(json_encode($result), true);
        $result['education_json'] = json_decode($result['education_json']);
        $output = array('success'=>true,'auth'=>true,'result'=>$result['education_json']);
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['add_education']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $_POST['payload']['location']['city'] = trim($_POST['payload']['location']['city']);
    $_POST['payload']['location']['country'] = trim($_POST['payload']['location']['country']);
    
    if(!isset($_POST['payload']['location']['country']))
    {
    	$_POST['payload']['location']['country'] = '';
    }
    
    
    ////// validation start //////
    
    if($_POST['payload']['institution_name'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Institution name is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['location']['city'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Location is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['degree'] != 'High School')
    {
        if($_POST['payload']['specialisation'] == '')
        {
            $output = array('success' => false,'auth'=>true,'msg' => 'Program is required !');
            echo json_encode($output);
            exit;
        }
    }
    
    if($_POST['payload']['degree'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Degree is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['from_year'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Start date is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['to_year'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'End date is required !');
        echo json_encode($output);
        exit;
    }
    
    ////// validation end //////
    
    
    
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT education_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    if(sizeof($result) > 0)
    {    
    $new_payload = array();
    $arr = json_decode(json_encode(json_decode(($result['education_json']))), true);  
    foreach($arr as $row)
    {
    	array_push($new_payload,$row);
    }
     
    array_push($new_payload,$_POST['payload']);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("education_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }
   else
   {
        $sql = $wpdb->prepare( "INSERT INTO ".$table_name." (user_id,education_json) VALUES ( %d, %s)", $current_user_id, $payload );
        $wpdb->query($sql);
        $meta_id = $wpdb->insert_id;
    }
    
    //start adding new data to the master tables
        $new_data = $_POST['payload'];

        $result1 = $wpdb->get_results("SELECT id FROM ".$wpdb->prefix . 'university_master'." WHERE LOWER(name) = '".strtolower($new_data['institution_name'])."'");
        $result1 = json_decode(json_encode($result1), true);
        if(sizeof($result1) == 0)
        {
        $sql1 = $wpdb->prepare( "INSERT INTO ".$wpdb->prefix . 'university_master'." (name) VALUES (%s)", $new_data['institution_name'] );
            $wpdb->query($sql1);
        }
        
        
        
        $result2 = $wpdb->get_results("SELECT id FROM ".$wpdb->prefix . 'specialisation_master'." WHERE LOWER(name) = '".strtolower($new_data['specialisation'])."'");
        $result2 = json_decode(json_encode($result2), true);
        if(sizeof($result2) == 0)
        {
        $sql2 = $wpdb->prepare( "INSERT INTO ".$wpdb->prefix . 'specialisation_master'." (name) VALUES (%s)", $new_data['specialisation'] );
            $wpdb->query($sql2);
        }
    //end adding new data to the master tables 

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['update_education']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $_POST['payload']['location']['city'] = trim($_POST['payload']['location']['city']);
    $_POST['payload']['location']['country'] = trim($_POST['payload']['location']['country']);
    
    if(!isset($_POST['payload']['location']['country']))
    {
    	$_POST['payload']['location']['country'] = '';
    }
    
    ////// validation start //////
    
    if($_POST['payload']['institution_name'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Institution name is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['location']['city'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Location is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['degree'] != 'High School')
    {
        if($_POST['payload']['specialisation'] == '')
        {
            $output = array('success' => false,'auth'=>true,'msg' => 'Program is required !');
            echo json_encode($output);
            exit;
        }
    }
    
    if($_POST['payload']['degree'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Degree is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['from_year'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'Start date is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['to_year'] == '')
    {
        $output = array('success' => false,'auth'=>true,'msg' => 'End date is required !');
        echo json_encode($output);
        exit;
    }
    
    
    ////// validation end //////
    
	$key = $_POST['update_education'];
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT education_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result['education_json']))), true);  
    $old_payload[$key] = $_POST['payload'];
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("education_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );


//start adding new data to the master tables
        $new_data = $_POST['payload'];

        $result1 = $wpdb->get_results("SELECT id FROM ".$wpdb->prefix . 'university_master'." WHERE LOWER(name) = '".strtolower($new_data['institution_name'])."'");
        $result1 = json_decode(json_encode($result1), true);
        if(sizeof($result1) == 0)
        {
        $sql1 = $wpdb->prepare( "INSERT INTO ".$wpdb->prefix . 'university_master'." (name) VALUES (%s)", $new_data['institution_name'] );
            $wpdb->query($sql1);
        }
        
        
        
        $result2 = $wpdb->get_results("SELECT id FROM ".$wpdb->prefix . 'specialisation_master'." WHERE LOWER(name) = '".strtolower($new_data['specialisation'])."'");
        $result2 = json_decode(json_encode($result2), true);
        if(sizeof($result2) == 0)
        {
        $sql2 = $wpdb->prepare( "INSERT INTO ".$wpdb->prefix . 'specialisation_master'." (name) VALUES (%s)", $new_data['specialisation'] );
            $wpdb->query($sql2);
        }
    //end adding new data to the master tables 
    
    
	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully updated.');
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['delete_education']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
	$key = $_POST['delete_education'];
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT education_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result['education_json']))), true);  
    unset($old_payload[$key]);
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("education_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );

	$output = array('success' => true,'auth'=>true,'msg' => 'Successfully deleted.');
    }
 	echo json_encode($output);
 	exit;
}

////// EDUCATION END //////



////// WORK EXPERIENCE START ///////

if( isset($_GET['list_work_experience']) ){
	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    	$users = $wpdb->prefix . 'users';      
        $username1 = $wpdb->get_row("SELECT user_login FROM $users WHERE ID = 
        $current_user_id");
        $username1 = json_decode(json_encode($username1), true)['user_login'];
        if($username1 == $_GET['payload']['username'] || $_GET['payload']['username'] == '')
        {
        	$current_user_id = get_current_user_id();
        }
        else
        {
        $username2 = $wpdb->get_row("SELECT ID FROM $users WHERE user_login = 
        '".$_GET['payload']['username']."'");
        $current_user_id = json_decode(json_encode($username2), true)['ID'];
        }
    
        $table_name = $wpdb->prefix . 'onboarding';	
        $result = $wpdb->get_row("SELECT work_experience_json FROM $table_name WHERE user_id = 
        $current_user_id");

        $result = json_decode(json_encode($result), true);
        $result['work_experience_json'] = json_decode($result['work_experience_json']);
        $output = array('success'=>true,'auth'=>true,'result'=>$result['work_experience_json']);
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['add_work_experience']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $_POST['payload']['location']['city'] = trim($_POST['payload']['location']['city']);
    $_POST['payload']['location']['country'] = trim($_POST['payload']['location']['country']);
    
    if(!isset($_POST['payload']['location']['country']))
    {
    	$_POST['payload']['location']['country'] = '';
    }
    
    
    ////// validation start //////
    
    if($_POST['payload']['title'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Title is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['employment_type'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Employment type is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['company_name'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Company name is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['location']['city'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Location is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['from_date'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'From date is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['to_date'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'To date is required !');
        echo json_encode($output);
        exit;
    }
    
    
    ////// validation end //////
    
    
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT work_experience_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    if(sizeof($result) > 0)
    {    
    $new_payload = array();
    $arr = json_decode(json_encode(json_decode(($result['work_experience_json']))), true);  
    foreach($arr as $row)
    {
    	array_push($new_payload,$row);
    }
     
    array_push($new_payload,$_POST['payload']);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("work_experience_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }
   else
   {
        $sql = $wpdb->prepare( "INSERT INTO ".$table_name." (user_id,work_experience_json) VALUES ( %d, %s)", $current_user_id, $payload );
        $wpdb->query($sql);
        $meta_id = $wpdb->insert_id;
    }
    
    //start adding new data to the master tables
        $new_data = $_POST['payload'];

        $result1 = $wpdb->get_results("SELECT id FROM ".$wpdb->prefix . 'company_master'." WHERE LOWER(name) = '".strtolower($new_data['company_name'])."'");
        $result1 = json_decode(json_encode($result1), true);
        if(sizeof($result1) == 0)
        {
        $sql1 = $wpdb->prepare( "INSERT INTO ".$wpdb->prefix . 'company_master'." (name) VALUES (%s)", $new_data['company_name'] );
            $wpdb->query($sql1);
        }
    //end adding new data to the master tables 

	$output = array('success' => true, 'auth'=>true,'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['update_work_experience']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $_POST['payload']['location']['city'] = trim($_POST['payload']['location']['city']);
    $_POST['payload']['location']['country'] = trim($_POST['payload']['location']['country']);
    
    if(!isset($_POST['payload']['location']['country']))
    {
    	$_POST['payload']['location']['country'] = '';
    }
    
    ////// validation start //////
    
    if($_POST['payload']['title'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Title is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['employment_type'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Employment type is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['company_name'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Company name is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['location']['city'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Location is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['from_date'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'From date is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['to_date'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'To date is required !');
        echo json_encode($output);
        exit;
    }
    
    
    ////// validation end //////
    
	$key = $_POST['update_work_experience'];
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT work_experience_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result['work_experience_json']))), true);  
    $old_payload[$key] = $_POST['payload'];
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("work_experience_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );


//start adding new data to the master tables
        $new_data = $_POST['payload'];

        $result1 = $wpdb->get_results("SELECT id FROM ".$wpdb->prefix . 'company_master'." WHERE LOWER(name) = '".strtolower($new_data['company_name'])."'");
        $result1 = json_decode(json_encode($result1), true);
        if(sizeof($result1) == 0)
        {
        $sql1 = $wpdb->prepare( "INSERT INTO ".$wpdb->prefix . 'company_master'." (name) VALUES (%s)", $new_data['company_name'] );
            $wpdb->query($sql1);
        }
    //end adding new data to the master tables 
    
    
	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully updated.');
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['delete_work_experience']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
	$key = $_POST['delete_work_experience'];
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT work_experience_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result['work_experience_json']))), true);  
    unset($old_payload[$key]);
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("work_experience_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );

	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully deleted.');
    }
 	echo json_encode($output);
 	exit;
}

///// WORK EXPERIENCE END /////



///// AWARD ACHIEVEMENT START /////

if( isset($_GET['list_award_achievement']) ){
	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
        $users = $wpdb->prefix . 'users';      
        $username1 = $wpdb->get_row("SELECT user_login FROM $users WHERE ID = 
        $current_user_id");
        $username1 = json_decode(json_encode($username1), true)['user_login'];
        if($username1 == $_GET['payload']['username'] || $_GET['payload']['username'] == '')
        {
        	$current_user_id = get_current_user_id();
        }
        else
        {
        $username2 = $wpdb->get_row("SELECT ID FROM $users WHERE user_login = 
        '".$_GET['payload']['username']."'");
        $current_user_id = json_decode(json_encode($username2), true)['ID'];
        }
    
        $table_name = $wpdb->prefix . 'onboarding';
        $result = $wpdb->get_row("SELECT awards_and_achievements_json FROM $table_name WHERE user_id = 
        $current_user_id");

        $result = json_decode(json_encode($result), true);
        $result['awards_and_achievements_json'] = json_decode($result['awards_and_achievements_json']);
        $output = array('success'=>true,'auth'=>true,'result'=>$result['awards_and_achievements_json']);
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['add_award_achievement']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    
    ////// validation start //////
    
    if($_POST['payload']['title'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Title is required !');
        echo json_encode($output);
        exit;
    }
    
    
    if($_POST['payload']['awarded_by'] == '')
    {
        $output = array('success' => false,'auth'=>true, 'msg' => 'Institution is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['issue_date'] == '')
    {
        $output = array('success' => false, 'auth'=>true,'msg' => 'Issue date is required !');
        echo json_encode($output);
        exit;
    }
    
    
    ////// validation end //////
    
    
    
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT awards_and_achievements_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    if(sizeof($result) > 0)
    {    
    $new_payload = array();
    $arr = json_decode(json_encode(json_decode(($result['awards_and_achievements_json']))), true);  
    foreach($arr as $row)
    {
    	array_push($new_payload,$row);
    }
     
    array_push($new_payload,$_POST['payload']);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("awards_and_achievements_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }
   else
   {
        $sql = $wpdb->prepare( "INSERT INTO ".$table_name." (user_id,awards_and_achievements_json) VALUES ( %d, %s)", $current_user_id, $payload );
        $wpdb->query($sql);
        $meta_id = $wpdb->insert_id;
    }

	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['update_award_achievement']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    
    ////// validation start //////
    
    if($_POST['payload']['title'] == '')
    {
        $output = array('success' => false,'auth'=>true, 'msg' => 'Title is required !');
        echo json_encode($output);
        exit;
    }
    
    
    if($_POST['payload']['awarded_by'] == '')
    {
        $output = array('success' => false,'auth'=>true, 'msg' => 'Institution is required !');
        echo json_encode($output);
        exit;
    }
    
    if($_POST['payload']['issue_date'] == '')
    {
        $output = array('success' => false,'auth'=>true, 'msg' => 'Issue date is required !');
        echo json_encode($output);
        exit;
    }
    
    
    ////// validation end //////
    
	$key = $_POST['update_award_achievement'];
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT awards_and_achievements_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result['awards_and_achievements_json']))), true);  
    $old_payload[$key] = $_POST['payload'];
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("awards_and_achievements_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );
      
	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully updated.');
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['delete_award_achievement']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
	$key = $_POST['delete_award_achievement'];
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT awards_and_achievements_json FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result['awards_and_achievements_json']))), true);  
    unset($old_payload[$key]);
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("awards_and_achievements_json" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );

	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully deleted.');
    }
 	echo json_encode($output);
 	exit;
}

////// AWARD ACHIEVEMENT END //////



/**
 * Template Name: Onboarding Autocomplete PHP Function
 */
 
 //header("Access-Control-Allow-Origin: *");
 //header("Access-Control-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
 
 
// Handle AJAX request (start)
if( isset($_GET['autocomplete_search']) ){

	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    
    $payload = $_GET['payload'];
    $master = $payload['master'];
    $keyword = $payload['keyword'];
	$table_name = $wpdb->prefix . $master .'_master';
    
    if($master != 'location'){
        	$result = $wpdb->get_results("SELECT name FROM $table_name WHERE name LIKE '%{$keyword}%'");

        	$result = json_decode(json_encode($result), true);
        
        	$option = array();
            foreach($result as $row)
            {
                array_push($option,array('title'=>$row['name']));
            }
        }
        else
        {
        	$result = $wpdb->get_results("SELECT city,country FROM $table_name WHERE city LIKE '%{$keyword}%' OR country LIKE '{$keyword}%'");

        	$result = json_decode(json_encode($result), true);
        
        	$option = array();
            foreach($result as $row)
            {
                array_push($option,array('city'=>$row['city'], 'country'=>$row['country']));
            }
        }
        
        $output = array('success'=>true,'auth'=>true,'result'=>$option);
    }
 	echo json_encode($output);
 	exit;
}


///// CHIP START /////

if( isset($_GET['list_chip']) ){
	$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
        $users = $wpdb->prefix . 'users';      
        $username1 = $wpdb->get_row("SELECT user_login FROM $users WHERE ID = 
        $current_user_id");
        $username1 = json_decode(json_encode($username1), true)['user_login'];
        if($username1 == $_GET['payload']['username'] || $_GET['payload']['username'] == '')
        {
        	$current_user_id = get_current_user_id();
        }
        else
        {
        $username2 = $wpdb->get_row("SELECT ID FROM $users WHERE user_login = 
        '".$_GET['payload']['username']."'");
        $current_user_id = json_decode(json_encode($username2), true)['ID'];
        }
    
        $table_name = $wpdb->prefix . 'onboarding';	
        $result = $wpdb->get_row("SELECT ".$_GET['payload']['json_name']." FROM $table_name WHERE user_id = 
        $current_user_id");

        $result = json_decode(json_encode($result), true);
        $result[$_GET['payload']['json_name']] = json_decode($result[$_GET['payload']['json_name']]);
        $output = array('success'=>true,'auth'=>true,'result'=>$result[$_GET['payload']['json_name']]);
    }
 	echo json_encode($output);
 	exit;
}

if( isset($_POST['add_chip']) ){

$current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    
    if($_POST['payload']['master'] == 'location')
    {
        $_POST['payload']['name']['city'] = trim($_POST['payload']['name']['city']);
        $_POST['payload']['name']['country'] = trim($_POST['payload']['name']['country']);

        if(!isset($_POST['payload']['name']['country']))
        {
            $_POST['payload']['name']['country'] = '';
        }
        
        $city = $_POST['payload']['name']['city'];
        $country = $_POST['payload']['name']['country'];
        
        $payload = json_encode(array(array('city' => $city, 'country' => $country)));
        $new_added = $_POST['payload']['name'];
        
        if($new_added['city'] == '')
        {
            $output = array('success' => false, 'auth'=>true,'msg' => $_POST['payload']['master'].' is required !');
            echo json_encode($output);
            exit;
        }
    }
    else
    {
    	$payload = json_encode(array($_POST['payload']['name']['name']));
        $new_added = $_POST['payload']['name']['name'];
        
        if($new_added == '')
        {
            $output = array('success' => false, 'auth'=>true,'msg' => $_POST['payload']['master'].' is required !');
            echo json_encode($output);
            exit;
        }
    }
    
	
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT ".$_POST['payload']['json_name']." FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    if(sizeof($result) > 0)
    {    
    $new_payload = array();
    $arr = json_decode(json_encode(json_decode(($result[$_POST['payload']['json_name']]))), true);  
    foreach($arr as $row)
    {
    	array_push($new_payload,$row);
    }
     
    array_push($new_payload,$new_added);
    if($_POST['payload']['master'] != 'location')
    {
    	$new_payload = array_unique($new_payload);
    }
    else
    {
    	$new_payload = array_intersect_key($new_payload, array_unique(array_map('serialize', $new_payload)));
    }
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array($_POST['payload']['json_name'] => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );
    }
   else
   {
        $sql = $wpdb->prepare( "INSERT INTO ".$table_name." (user_id,".$_POST['payload']['json_name'].") VALUES ( %d, %s)", $current_user_id, $payload );
        $wpdb->query($sql);
        $meta_id = $wpdb->insert_id;
    }
    
    //start adding new data to the master tables
    if($_POST['payload']['master'] != 'location')
    {
        $new_data = $_POST['payload']['name'];
        $master_table = $wpdb->prefix.$_POST['payload']['master'].'_master';
        $result1 = $wpdb->get_results("SELECT id FROM ".$master_table." WHERE LOWER(name) = '".strtolower($new_data['name'])."'");
        $result1 = json_decode(json_encode($result1), true);
        if(sizeof($result1) == 0)
        {
        $sql1 = $wpdb->prepare( "INSERT INTO ".$master_table." (name) VALUES (%s)", $new_data['name'] );
            $wpdb->query($sql1);
        }
     }
    //end adding new data to the master tables 

	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully added.');
    }
 	echo json_encode($output);
 	exit;
}


if( isset($_POST['delete_chip']) ){

$current_user_id = get_current_user_id();
if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
	$key = $_POST['delete_chip'];
	$payload = json_encode(array($_POST['payload']));
	$table_name = $wpdb->prefix . 'onboarding';
    
    $result = $wpdb->get_row("SELECT ".$_POST['payload']['json_name']." FROM ".$table_name." WHERE user_id = $current_user_id");
    $result = json_decode(json_encode($result), true);
    
    $old_payload = json_decode(json_encode(json_decode(($result[$_POST['payload']['json_name']]))), true);  
    unset($old_payload[$key]);
    $new_payload = array_values($old_payload);
    $new_payload = json_encode($new_payload);
        $wpdb->update($table_name, array("".$_POST['payload']['json_name']."" => $new_payload), array("user_id" => $current_user_id), array("%s"), array("%d") );

	$output = array('success' => true,'auth'=>true, 'msg' => 'Successfully deleted.');
    }
 	echo json_encode($output);
 	exit;
}

////// CHIP END //////

// Handle AJAX request (end)


// Onboarding ended
















///// START SHOW COMMON INTERESTS BETWEEN LOGGED IN AND ANOTHER USER /////



if(isset($_GET['compare_user_id']))
{
	$current_user_id = get_current_user_id();
    $common = array();  
    $table_name = $wpdb->prefix . 'onboarding';	
    
    
// Current Login User Calculation Start Here -- written by William Thoudam //

        $myResult = $wpdb->get_row("SELECT * FROM $table_name WHERE user_id = 
        $current_user_id");
        
        $myResult = json_decode(json_encode($myResult), true);
        
        //$my_higher_education_interests_degree_json = json_decode($myResult['higher_education_interests_degree_json']) ? array_map('trim',json_decode($myResult['higher_education_interests_degree_json'])) : array();
 
        //$my_higher_education_interests_specialisations_json = json_decode($myResult['higher_education_interests_specialisations_json']) ? array_map('trim',json_decode($myResult['higher_education_interests_specialisations_json'])) : array();
        
        //$my_higher_education_interests_universities_json = json_decode($myResult['higher_education_interests_universities_json']) ? array_map('trim',json_decode($myResult['higher_education_interests_universities_json'])) : array();
        
        // $my_career_interests_job_role_json = json_decode($myResult['career_interests_job_role_json']) ? array_map('trim',json_decode($myResult['career_interests_job_role_json'])) : array();
        
        // $my_career_interests_industries_json = json_decode($myResult['career_interests_industries_json']) ? array_map('trim',json_decode($myResult['career_interests_industries_json'])) : array();
        
        
        // $my_career_interests_type_of_work_json = json_decode($myResult['career_interests_type_of_work_json']) ? array_map('trim',json_decode($myResult['career_interests_industries_json'])) : array();
        
        
        
        
        $my_my_skills_technical_json = json_decode($myResult['my_skills_technical_json']) ? array_map('trim',json_decode($myResult['my_skills_technical_json'])) : array();
        
        $my_my_skills_personal_json = json_decode($myResult['my_skills_personal_json']) ? array_map('trim',json_decode($myResult['my_skills_personal_json'])) : array();
        
        $my_my_skills_hobbies_json = json_decode($myResult['my_skills_hobbies_json']) ? array_map('trim',json_decode($myResult['my_skills_hobbies_json'])) : array();
        
        $my_skills_i_want_to_learn_technical_json = json_decode($myResult['skills_i_want_to_learn_technical_json']) ? array_map('trim',json_decode($myResult['skills_i_want_to_learn_technical_json'])) : array();
        
        $my_skills_i_want_to_learn_personal_json = json_decode($myResult['skills_i_want_to_learn_personal_json']) ? array_map('trim',json_decode($myResult['skills_i_want_to_learn_personal_json'])) : array();
        
        $my_skills_i_want_to_learn_hobbies_json = json_decode($myResult['skills_i_want_to_learn_hobbies_json']) ? array_map('trim',json_decode($myResult['skills_i_want_to_learn_hobbies_json'])) : array();
        


        // My Education Start //
        $my_education_json = json_decode(json_encode(json_decode($myResult['education_json'])), true) ? json_decode(json_encode(json_decode($myResult['education_json'])), true) : array();
        
        $my_education_institutions_json = array();
        $my_education_specialisations_json = array();
        $my_education_degrees_json = array();
        $my_education_locations_json = array();
        if(sizeof($my_education_json) > 0)
        {
            foreach($my_education_json as $row)
            {
                $my_education_institutions_json[] = $row['institution_name'];
                $my_education_specialisations_json[] = $row['specialisation'];
                $my_education_degrees_json[] = $row['degree'];
                $my_education_locations_json[] = $row['location'];
            }
        }

        $my_higher_education_interests_degree_json = json_decode($myResult['higher_education_interests_degree_json']) ? array_map('trim',json_decode($myResult['higher_education_interests_degree_json'])) : array();  
        $my_higher_education_interests_specialisations_json = json_decode($myResult['higher_education_interests_specialisations_json']) ? array_map('trim',json_decode($myResult['higher_education_interests_specialisations_json'])) : array();
        $my_higher_education_interests_universities_json = json_decode($myResult['higher_education_interests_universities_json']) ? array_map('trim',json_decode($myResult['higher_education_interests_universities_json'])) : array(); 
        // My Education End //




        // My Career Start //
        $my_work_experience_json = json_decode(json_encode(json_decode($myResult['work_experience_json'])), true) ? json_decode(json_encode(json_decode($myResult['work_experience_json'])), true) : array();
        
        $my_work_experience_companies_json = array();
        $my_work_experience_locations_json = array();
        if(sizeof($my_work_experience_json) > 0)
        {
            foreach($my_work_experience_json as $row)
            {
                $my_work_experience_companies_json[] = $row['company_name'];
                $my_work_experience_locations_json[] = $row['location'];
            }
        }

        $my_career_interests_job_role_json = json_decode($myResult['career_interests_job_role_json']) ? array_map('trim',json_decode($myResult['career_interests_job_role_json'])) : array();
        $my_career_interests_industries_json = json_decode($myResult['career_interests_industries_json']) ? array_map('trim',json_decode($myResult['career_interests_industries_json'])) : array();
        $my_career_interests_type_of_work_json = json_decode($myResult['career_interests_type_of_work_json']) ? array_map('trim',json_decode($myResult['career_interests_type_of_work_json'])) : array();
        // My Career End //





        $my_personal_info_locations_json = json_decode(json_encode(json_decode($myResult['personal_info_locations_json'])), true); 
  
        $my_personal_info_locations_json = $my_personal_info_locations_json ? $my_personal_info_locations_json : array();
        
        // Combine together current and previous locations
        $my_personal_info_current_location = array('city'=>explode (",", $myResult['personal_info_current_location'])[0], 'country'=>explode (",", $myResult['personal_info_current_location'])[1]);
        array_push($my_personal_info_locations_json,$my_personal_info_current_location);
        // Combine together current and previous locations

        // push higher education interests location to personal info location array
        $my_higher_education_interests_locations_json = json_decode(json_encode(json_decode($myResult['higher_education_interests_locations_json'])), true) ? json_decode(json_encode(json_decode($myResult['higher_education_interests_locations_json'])), true) : array(); 
        if(sizeof($my_higher_education_interests_locations_json) > 0)
        {
            foreach($my_higher_education_interests_locations_json as $row)
            {
                array_push($my_personal_info_locations_json,$row);
            }
        }
        // push higher education interests location to personal info location array


        // push career interests location to personal info location array
        $my_career_interests_locations_json = json_decode(json_encode(json_decode($myResult['career_interests_locations_json'])), true) ? json_decode(json_encode(json_decode($myResult['career_interests_locations_json'])), true) : array(); 
        if(sizeof($my_career_interests_locations_json) > 0)
        {
            foreach($my_career_interests_locations_json as $row)
            {
                array_push($my_personal_info_locations_json,$row);
            }
        }
        // push career interests location to personal info location array


        // push education location to personal info location array
        // if(sizeof($my_education_locations_json) > 0)
        // {
        //     foreach($my_education_locations_json as $row)
        //     {
        //         array_push($my_personal_info_locations_json,$row);
        //     }
        // }
        // push education location to personal info location array


        // push work experience location to personal info location array
        // if(sizeof($my_work_experience_locations_json) > 0)
        // {
        //     foreach($my_work_experience_locations_json as $row)
        //     {
        //         array_push($my_personal_info_locations_json,$row);
        //     }
        // }
        // push work experience location to personal info location array

         
 array_walk_recursive($my_personal_info_locations_json,function(&$v){$v=ltrim($v);});
 
 $myLocations = array_map("unserialize", array_unique(array_map("serialize", $my_personal_info_locations_json)));
 
 
   $myLanguages = json_decode($myResult['personal_info_languages_json']) ? array_map('trim',json_decode($myResult['personal_info_languages_json'])) : array();
   
   //$myInterest = array_unique(array_merge($my_higher_education_interests_degree_json,$my_higher_education_interests_specialisations_json,$my_higher_education_interests_universities_json,$my_career_interests_job_role_json,$my_career_interests_industries_json,$my_career_interests_type_of_work_json));
   //$myInterest = array_unique(array_merge($my_career_interests_job_role_json,$my_career_interests_industries_json,$my_career_interests_type_of_work_json));

   $mySkill = array_unique(array_merge($my_skills_i_want_to_learn_technical_json,$my_skills_i_want_to_learn_personal_json,$my_skills_i_want_to_learn_hobbies_json,$my_my_skills_technical_json,$my_my_skills_personal_json,$my_my_skills_hobbies_json));
 
   $myEducation = array_unique(array_merge($my_education_institutions_json,$my_education_specialisations_json,$my_education_degrees_json,$my_higher_education_interests_degree_json,$my_higher_education_interests_specialisations_json,$my_higher_education_interests_universities_json)); 
   
   //$myCareer = array_unique(array_merge($my_work_experience_companies_json,$my_career_interests_job_role_json,$my_career_interests_industries_json,$my_career_interests_type_of_work_json)); 
   $myCareer = array_unique(array_merge($my_work_experience_companies_json,$my_career_interests_job_role_json,$my_career_interests_industries_json));  

// Current Login User Calculation End Here -- written by William Thoudam //




// Another User Calculation Start Here -- written by William Thoudam //

   $userResult = $wpdb->get_row("SELECT * FROM $table_name WHERE user_id = 
        '".$_GET['compare_user_id']."'");
 $userResult = json_decode(json_encode($userResult), true);
        
        // $user_higher_education_interests_degree_json = json_decode($userResult['higher_education_interests_degree_json']) ? json_decode($userResult['higher_education_interests_degree_json']) : array();
        
        // $user_higher_education_interests_specialisations_json = json_decode($userResult['higher_education_interests_specialisations_json']) ? json_decode($userResult['higher_education_interests_specialisations_json']) : array();
        
        // $user_higher_education_interests_universities_json = json_decode($userResult['higher_education_interests_universities_json']) ? json_decode($userResult['higher_education_interests_universities_json']) : array();
        
        // $user_career_interests_job_role_json = json_decode($userResult['career_interests_job_role_json']) ? json_decode($userResult['career_interests_job_role_json']) : array();
        
        // $user_career_interests_industries_json = json_decode($userResult['career_interests_industries_json']) ? json_decode($userResult['career_interests_industries_json']) : array();
        
        // $user_career_interests_type_of_work_json = json_decode($userResult['career_interests_type_of_work_json']) ? array_map('trim',json_decode($userResult['career_interests_type_of_work_json'])) : array();
 
 
 
        $user_my_skills_technical_json = json_decode($userResult['my_skills_technical_json']) ? array_map('trim',json_decode($userResult['my_skills_technical_json'])) : array();
 
        
        $user_my_skills_personal_json = json_decode($userResult['my_skills_personal_json']) ? array_map('trim',json_decode($userResult['my_skills_personal_json'])) : array();
        
        $user_my_skills_hobbies_json = json_decode($userResult['my_skills_hobbies_json']) ? array_map('trim',json_decode($userResult['my_skills_hobbies_json'])) : array();
        
        $user_skills_i_want_to_learn_technical_json = json_decode($userResult['skills_i_want_to_learn_technical_json']) ? array_map('trim',json_decode($userResult['skills_i_want_to_learn_technical_json'])) : array();
        
        $user_skills_i_want_to_learn_personal_json = json_decode($userResult['skills_i_want_to_learn_personal_json']) ? array_map('trim',json_decode($userResult['skills_i_want_to_learn_personal_json'])) : array();
        
        $user_skills_i_want_to_learn_hobbies_json = json_decode($userResult['skills_i_want_to_learn_hobbies_json']) ? array_map('trim',json_decode($userResult['skills_i_want_to_learn_hobbies_json'])) : array();
 
 
        // User Education Start //
        $user_education_json = json_decode(json_encode(json_decode($userResult['education_json'])), true) ? json_decode(json_encode(json_decode($userResult['education_json'])), true) : array();
                
        $user_education_institutions_json = array();
        $user_education_specialisations_json = array();
        $user_education_degrees_json = array();
        $my_education_locations_json = array();
        if(sizeof($user_education_json) > 0)
        {
            foreach($user_education_json as $row)
            {
                $user_education_institutions_json[] = $row['institution_name'];
                $user_education_specialisations_json[] = $row['specialisation'];
                $user_education_degrees_json[] = $row['degree'];
                $user_education_locations_json = $row['location'];
            }
        }

        $user_higher_education_interests_degree_json = json_decode($userResult['higher_education_interests_degree_json']) ? array_map('trim',json_decode($userResult['higher_education_interests_degree_json'])) : array();  
        $user_higher_education_interests_specialisations_json = json_decode($userResult['higher_education_interests_specialisations_json']) ? array_map('trim',json_decode($userResult['higher_education_interests_specialisations_json'])) : array();
        $user_higher_education_interests_universities_json = json_decode($userResult['higher_education_interests_universities_json']) ? array_map('trim',json_decode($userResult['higher_education_interests_universities_json'])) : array(); 
        // User Education End //



        // User Career Start //
        $user_work_experience_json = json_decode(json_encode(json_decode($userResult['work_experience_json'])), true) ? json_decode(json_encode(json_decode($userResult['work_experience_json'])), true) : array();
        
        $user_work_experience_companies_json = array();
        $user_work_experience_locations_json = array();
        if(sizeof($user_work_experience_json) > 0)
        {
            foreach($user_work_experience_json as $row)
            {
                $user_work_experience_companies_json[] = $row['company_name'];
                $user_work_experience_locations_json[] = $row['location'];
            }
        }

        $user_career_interests_job_role_json = json_decode($userResult['career_interests_job_role_json']) ? array_map('trim',json_decode($userResult['career_interests_job_role_json'])) : array();
        $user_career_interests_industries_json = json_decode($userResult['career_interests_industries_json']) ? array_map('trim',json_decode($userResult['career_interests_industries_json'])) : array();
        $user_career_interests_type_of_work_json = json_decode($userResult['career_interests_type_of_work_json']) ? array_map('trim',json_decode($userResult['career_interests_type_of_work_json'])) : array();
        // User Career End //


 
        $user_personal_info_locations_json = json_decode(json_encode(json_decode($userResult['personal_info_locations_json'])), true); 
  
        $user_personal_info_locations_json = $user_personal_info_locations_json ? $user_personal_info_locations_json : array();
        
        // Combine together current and previous locations
        $user_personal_info_current_location = array('city'=>explode (",", $userResult['personal_info_current_location'])[0], 'country'=>explode (",", $userResult['personal_info_current_location'])[1]);
        array_push($user_personal_info_locations_json,$user_personal_info_current_location);
        // Combine together current and previous locations

        // push higher education interests location to personal info location array
        $user_higher_education_interests_locations_json = json_decode(json_encode(json_decode($userResult['higher_education_interests_locations_json'])), true) ? json_decode(json_encode(json_decode($userResult['higher_education_interests_locations_json'])), true) : array(); 
        if(sizeof($user_higher_education_interests_locations_json) > 0)
        {
            foreach($user_higher_education_interests_locations_json as $row)
            {
                array_push($user_personal_info_locations_json,$row);
            }
        }
        // push higher education interests location to personal info location array


        // push career interests location to personal info location array
        $user_career_interests_locations_json = json_decode(json_encode(json_decode($userResult['career_interests_locations_json'])), true) ? json_decode(json_encode(json_decode($userResult['career_interests_locations_json'])), true) : array(); 
        if(sizeof($user_career_interests_locations_json) > 0)
        {
            foreach($user_career_interests_locations_json as $row)
            {
                array_push($user_personal_info_locations_json,$row);
            }
        }
        // push career interests location to personal info location array


        // push education location to personal info location array
        // if(sizeof($user_education_locations_json) > 0)
        // {
        //     foreach($user_education_locations_json as $row)
        //     {
        //         array_push($user_personal_info_locations_json,$row);
        //     }
        // }
        // push education location to personal info location array


        // push work experience location to personal info location array
        // if(sizeof($user_work_experience_locations_json) > 0)
        // {
        //     foreach($user_work_experience_locations_json as $row)
        //     {
        //         array_push($user_personal_info_locations_json,$row);
        //     }
        // }
        // push work experience location to personal info location array

 array_walk_recursive($user_personal_info_locations_json,function(&$v){$v=ltrim($v);});
 
 $userLocations = array_map("unserialize", array_unique(array_map("serialize", $user_personal_info_locations_json)));
 
 
 
   $userLanguages = json_decode($userResult['personal_info_languages_json']) ? array_map('trim',json_decode($userResult['personal_info_languages_json'])) : array();
   
   //$userInterest = array_unique(array_merge($user_higher_education_interests_degree_json,$user_higher_education_interests_specialisations_json,$user_higher_education_interests_universities_json,$user_career_interests_job_role_json,$user_career_interests_industries_json,$user_career_interests_type_of_work_json));
   //$userInterest = array_unique(array_merge($user_career_interests_job_role_json,$user_career_interests_industries_json,$user_career_interests_type_of_work_json));
   
   $userSkill = array_unique(array_merge($user_skills_i_want_to_learn_technical_json,$user_skills_i_want_to_learn_personal_json,$user_skills_i_want_to_learn_hobbies_json,$user_my_skills_technical_json,$user_my_skills_personal_json,$user_my_skills_hobbies_json));
 
   $userEducation = array_unique(array_merge($user_education_institutions_json,$user_education_specialisations_json,$user_education_degrees_json,$user_higher_education_interests_degree_json,$user_higher_education_interests_specialisations_json,$user_higher_education_interests_universities_json));  
 
   //$userCareer = array_unique(array_merge($user_work_experience_companies_json,$user_career_interests_job_role_json,$user_career_interests_industries_json,$user_career_interests_type_of_work_json));  
   $userCareer = array_unique(array_merge($user_work_experience_companies_json,$user_career_interests_job_role_json,$user_career_interests_industries_json));  

// Another User Calculation End Here -- written by William Thoudam // 
 
$usermeta = $wpdb->prefix . 'usermeta';

// Set dynamic meta_key and option value according to environment
$meta_key = 'peepso_user_field_11542';
$option = array('option_11542_1', 'option_11542_2', 'option_11542_3', 'option_11542_4', 'option_11542_5');

$profile_type_query = "SELECT * FROM $usermeta WHERE user_id = 
'".$_GET['compare_user_id']."' AND meta_key IN ('$meta_key')";   

$profile_type_result = $wpdb->get_results($profile_type_query);
$profile_type_result = json_decode(json_encode($profile_type_result), true);

$arr = array();
foreach($profile_type_result as $row)
{
$arr[$row['meta_key']] = $row['meta_value'];
}

$profile_type = null;
switch ($arr[$meta_key]) {
    case $option[0]:
    $profile_type = 'High School student';
    break;
    case $option[1]:
    $profile_type = 'University student (Undergrad)';
    break;
    case $option[2]:
    $profile_type = 'University student (Postgrad)';
    break;
    case $option[3]:
    $profile_type = 'Young professional (0-5 years)';
    break;
    case $option[4]:
    $profile_type = 'Experienced professional (5+ years)';
    break;
    default:
    $profile_type = null;
  }

 
$PeepSoUser = PeepSoUser::get_instance($_GET['compare_user_id']);
$compare_user_info = array(
'id' => $PeepSoUser->get_id(),
'username' => $PeepSoUser->get_username(),
'fullname' => $PeepSoUser->get_fullname(),
'avatar' => $PeepSoUser->get_avatar(),
'url' => $PeepSoUser->get_profileurl(),
'profile_type' => $profile_type
);
 
$common['compare_user_info'] = $compare_user_info;
 
 
//$common['common_interests'] = array_values(array_intersect($myInterest,$userInterest));
   
$common['common_languages'] = array_values(array_intersect($myLanguages,$userLanguages));
   
$common['common_skills'] = array_values(array_intersect($mySkill,$userSkill));

$common['common_educations'] = array_values(array_intersect($myEducation,$userEducation));

$common['common_careers'] = array_values(array_intersect($myCareer,$userCareer));
   

$bothLocations = array_merge($myLocations,$userLocations);

//print_r($bothLocations);
    
// first : get all data, if the data same / duplicate take only one data
$unique = array_unique($bothLocations, SORT_REGULAR);

// then, get the data which duplicate with
$common['common_locations'] = array_values(array_diff_key($bothLocations, $unique));

$common['common_locations'] = array_map('array_filter', $common['common_locations']);
$common['common_locations'] = array_filter($common['common_locations']);


if($myLocations[0]['city'] == '' || $myLocations[0]['country'] == '')
{
$myLocationsCount = 0;
}
else{
$myLocationsCount = sizeof($myLocations);
}


$my_record_found = sizeof($myLanguages) + sizeof($mySkill) + sizeof($myEducation) + sizeof($myCareer) + $myLocationsCount;

$common_record_found = sizeof($common['common_languages']) + sizeof($common['common_skills']) + sizeof($common['common_educations']) + sizeof($common['common_careers']) + sizeof($common['common_locations']);

$common['current_login_user_record_found'] = $my_record_found;
$common['common_record_found'] = $common_record_found;

if($my_record_found == 0)
{
$common['similarity_pc'] = 100;
}
else{
$common['similarity_pc'] = round(($common_record_found/$my_record_found)*100, 2);
}

echo json_encode($common);
exit;     
}

///// END SHOW COMMON INTERESTS BETWEEN LOGGED IN AND ANOTHER USER /////


// Handle AJAX request (end)







///// START COMMON INTERESTS SUGESSTIONS /////

if(isset($_GET['user_id']))
{
    $current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
        echo json_encode($output);
    }
    else
    {
        #$command = escapeshellcmd('python pyapi_js.py '.$_GET['user_id']);
        #$data = shell_exec($command);
        #echo(gettype($data));
        #$data = str_replace("{u'data': u'", '', str_replace("'}", '', $data));
        #$data = json_decode($data);
        #$data = json_decode(json_encode($data), true);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $remote_server_url."/member_matches?userid=".$_GET['user_id'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));
        $actual_response = curl_exec($curl);

        // $actual_response = '{
        //     "data": [
        //       {
        //         "matched_member_id": 0,
        //         "similarity": 4
        //       },
        //       {
        //         "matched_member_id": 9,
        //         "similarity": 3
        //       },
        //       {
        //         "matched_member_id": 25,
        //         "similarity": 2
        //       },
        //       {
        //         "matched_member_id": 60,
        //         "similarity": 1
        //       },
        //       {
        //         "matched_member_id": 5,
        //         "similarity": 1
        //       },
        //       {
        //         "matched_member_id": 20,
        //         "similarity": 1
        //       },
        //       {
        //         "matched_member_id": 21,
        //         "similarity": 1
        //       },
        //       {
        //         "matched_member_id": 7,
        //         "similarity": 1
        //       }
        //     ]
        //   }';

        $actual_response = $actual_response ? $actual_response : '{"data":[]}';
        $data = json_decode($actual_response, true);
        $data = json_decode(json_encode($data), true)['data'];

        $matched_member_id = array();
        $similarity = array();
        foreach($data as $key => $value)
        {
        $matched_member_id[$key] = $value['matched_member_id'];
        $similarity[$key] = $value['similarity'];
        }

        $data = array('matched_member_id' => $matched_member_id,'similarity' => $similarity);
        
    
        
        /// Remove unwanted user from port 3000 response - Written by William Thoudam ///
        
        // Connected users
        $peepso_friends = PeepSoFriendsPlugin::get_instance();
        $remove = $peepso_friends->model->get_friends($_GET['user_id']);
        $remove = json_decode(json_encode($remove), true);
        
        // Added logged-in user to the remove array
        // $remove[] = $_GET['user_id'];
        

        // Added blocked users to the remove array
        $table_name = $wpdb->prefix . 'peepso_blocks';
        $block_users = $wpdb->get_results("SELECT blk_blocked_id FROM $table_name WHERE blk_user_id = 
        '".$_GET['user_id']."'");
        $block_users = json_decode(json_encode($block_users), true);

        foreach($block_users as $row)
        {
            $remove[] = $row['blk_blocked_id'];
        }

        // Removing unwanted users from port 3000 response
        foreach($remove as $row)
        {
            $key = array_search ($row, $data['matched_member_id']);
            unset($data['matched_member_id'][$key]);
            unset($data['similarity'][$key]);
        }
        
        /// Remove unwanted user from port 3000 response - Written by William Thoudam ///
        
        
        // Requested users
        $table_name = $wpdb->prefix . 'peepso_friend_requests';
        $friend_request_results = $wpdb->get_results("SELECT freq_id, freq_friend_id FROM $table_name WHERE freq_user_id = 
        '".$_GET['user_id']."'");
        $friend_request_results = json_decode(json_encode($friend_request_results), true);

        // Restructure array
        $requested_users = array();
        $friend_request_id = array();
        foreach ($friend_request_results as $row) {
            $requested_users[] = $row['freq_friend_id'];
            $friend_request_id[] = $row['freq_id'];
        }
        //$requested_users = array_unique($requested_users);

        
        // Adding user information to the port 3000 response //

        $mutual_friends_count = array();
        $manipulated_matched_full_name = array();
        $matched_login_id = array();
        $matched_profile = array();
        $matched_avatar = array();
        $is_requested = array();
        $requested_id = array();
        
        // $peepso_friends = PeepSoFriendsPlugin::get_instance();
        foreach($data['matched_member_id'] as $key=>$value)
        {
            $matched_login_id[$key] = PeepSoUser::get_instance($value)->get_username();
            $matched_profile[$key] = PeepSoUser::get_instance($value)->get_profileurl();
            $matched_avatar[$key] = PeepSoUser::get_instance($value)->get_avatar();
            $mutual_friends_count[$key] = count($peepso_friends->model->get_mutual_friends($_GET['user_id'], $value));
            $manipulated_matched_full_name[$key] = PeepSoUser::get_instance($value)->get_fullname();
            
            
            if (in_array($value, $requested_users))
            {
                // Already requested
                $is_requested[$key] = true;
                $extract_key = array_search ($value, $requested_users);
                $requested_id[$key] = $friend_request_id[$extract_key];
            }
            else
            {
                // Not requested yet
                $is_requested[$key] = false;
                $requested_id[$key] = false;
            }

        }
        
        $data['matched_login_id'] = $matched_login_id;
        $data['matched_full_name'] =  $manipulated_matched_full_name;
        $data['matched_profile'] =  $matched_profile;
        $data['matched_avatar'] =  $matched_avatar;
        $data['mutual_friends_count'] =  $mutual_friends_count;
        $data['is_requested'] =  $is_requested;
        $data['requested_id'] =  $requested_id;
            
        // Adding user information to the port 3000 response //
    
    
        // Removing blank user 
        // foreach($data['matched_login_id'] as $row)
        // {
        //     if($row == false)
        //     {
        //         $key = array_search ($row, $data['matched_login_id']);
        //         unset($data['matched_member_id'][$key]);
        //         unset($data['similarity'][$key][$key]);
        //         unset($data['matched_login_id'][$key]);
        //         unset($data['matched_full_name'][$key]);
        //         unset($data['matched_profile'][$key]);
        //         unset($data['matched_avatar'][$key]);
        //         unset($data['mutual_friends_count'][$key]);
        //         unset($data['is_requested'][$key]);
        //         unset($data['requested_id'][$key]);
        //     }
            
        // }  
       // Removing blank user   
    
        #print_r($peepso_friends->model->get_friends($_GET['user_id']));
        #echo $actual_response;
        echo json_encode(array_map('array_values', $data));
    }
}

///// END COMMON INTERESTS SUGESSTIONS /////






/**
 * Simple string encryption/decryption function.
 * CHANGE $secret_key and $secret_iv !!!
**/

// function stringEncryption($action, $string){

//     $wp_open_ssl_key = $wpdb->prefix . 'open_ssl_key';

//     // Retrieving OPENSSL iv and key from the table
//     $open_ssl_secret_key = $wpdb->get_row("SELECT options, enc_iv, enc_key, ciphermethod FROM ".$wp_open_ssl_key." WHERE id = 1");
//     $open_ssl_secret_key = json_decode(json_encode($open_ssl_secret_key), true);

//     $output = false;
    
//     $encrypt_method = $open_ssl_secret_key['ciphermethod'];                // Default
//     // Non-NULL Initialization Vector for encryption 
//     $secret_iv = $open_ssl_secret_key['enc_iv']; 
    
//     // Store the encryption key 
//     $secret_key = $open_ssl_secret_key['enc_key'];
    
//     // hash
//     $key = hash('sha256', $secret_key);
    
//     // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
//     $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
//     if( $action == 'encrypt' ) {
//         $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
//         $output = base64_encode($output);
//     }
//     else if( $action == 'decrypt' ){
//         $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
//     }
    
//     return $output;
//   }






// START BULK INVITE //

if( isset($_GET['bulk_invite']) ){
    $current_user_id = get_current_user_id();
    if($current_user_id == null)
    {
        $output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    { 
        $main_domain = str_replace("/wp-content/themes/peepso-theme-gecko","",get_template_directory_uri());
        $current_email = PeepSoUser::get_instance($current_user_id)->get_email();
        $current_display_name = PeepSoUser::get_instance($current_user_id)->get_firstname();
        $to_emails = array_unique(preg_split ("/\,/",strtolower($_GET['to_emails'])));
        //$to_emails = json_decode(json_decode('"'.$_GET['to_emails'].'"'));
        $group_id = $_GET['group_id'];

        $already_member = array();
        $already_invited = array();
        $invalid_email = array();
        $your_email = array();
        $success_email = array();

        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
        {
            $http = "https://"; 
        }
        else
        {
            $http = "http://";
        }

        // Tables declaration
        $wp_users = $wpdb->prefix . 'users';
        $wp_peepso_users = $wpdb->prefix . 'peepso_users';
        $wp_peepso_group_members = $wpdb->prefix . 'peepso_group_members';
        $wp_peepso_notifications = $wpdb->prefix . 'peepso_notifications';
        $wp_bulk_invite = $wpdb->prefix . 'bulk_invite';
        $wp_open_ssl_key = $wpdb->prefix . 'open_ssl_key';

        // Retrieving OPENSSL iv and key from the table
        $secret_key = $wpdb->get_row("SELECT options, enc_iv, enc_key, ciphermethod FROM ".$wp_open_ssl_key." WHERE id = 1");
        $secret_key = json_decode(json_encode($secret_key), true);

        // check group id 
        if($group_id == null)
        {
            $output = array('success' => false, 'auth'=>true, 'already_member' => $already_member, 'already_invited' => $already_invited, 'invalid_email' => $invalid_email, 'your_email' => $your_email, 'success_email' => $success_email, 'msg' => 'Group ID is required!');
        }
        else
        {
            // create group page link 
            $wp_posts = $wpdb->prefix . 'posts';
            $post_title = $wpdb->get_row("SELECT post_title, post_name FROM ".$wp_posts." WHERE ID = $group_id AND post_type = 'peepso-group'");
            $post_title = json_decode(json_encode($post_title), true);
            $group_page_link = $main_domain."/groups/?".$post_title['post_name']."/";
            $group_name = $post_title['post_title'];
            $subject = "You have been invited to a group";
        
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: Dojoko';
            
            $success = 0;
            
            // filtering valid email
            $counter = 0;
            foreach($to_emails as $value)
            {  
                //if (!filter_var($value, FILTER_VALIDATE_EMAIL)) 
                //{
                    // remove invalid email
                    // $invalid_email[] = $value;
                    // unset($to_emails[$counter]);
                //}

                if($current_email == $value)
                {
                    // remove current loggedin email
                    $your_email[] = $value;
                    unset($to_emails[$counter]);
                }

                $counter++;
             }
            
            
            // maximum number of email check
            $count_email = sizeof($to_emails);
            $max = 50;
            $recipient_first_name = "";
            if( $count_email <= $max )
            {
                foreach($to_emails as $value)
                {   
                        // checking existing email or not
                
                        $is_exist = $wpdb->get_row("SELECT id, display_name, user_login, user_activation_key FROM ".$wp_users." WHERE user_email = '".$value."'");
                        $is_exist = json_decode(json_encode($is_exist), true);
                        $exist_user_id = $is_exist['id'];
                        $user_activation_key = $is_exist['user_activation_key'];
                        $recipient_first_name = explode(" ",$is_exist['display_name'])[0];
                        $username = $is_exist['user_login'];

                        // checking verified user or not
                        if($exist_user_id)
                        {
                            $is_verify_email = $wpdb->get_row("SELECT usr_id FROM ".$wp_peepso_users." WHERE usr_id = $exist_user_id AND usr_role = 'register'");
                            $is_verify_email = json_decode(json_encode($is_verify_email), true);
                            $verify_user = $is_verify_email['usr_id'];
                            

                            // not verified user
                            if($verify_user)
                            {
                                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                                {
                                    $http = "https://"; 
                                }
                                else
                                {
                                    $http = "http://";
                                }
                                
                                // check already invitation sent or not
                                $pending_user = $wpdb->get_row("SELECT gm_user_status FROM ".$wp_peepso_group_members." WHERE gm_user_id = $exist_user_id AND gm_group_id = $group_id AND gm_user_status = 'pending_user' AND gm_invited_by_id = $current_user_id");
                                $pending_user = json_decode(json_encode($pending_user), true);
                                $pending_user = $pending_user['gm_user_status'];

                                if(!$pending_user)
                                {
                                $sql1 = $wpdb->prepare( "INSERT INTO ".$wp_peepso_group_members." (gm_user_id,gm_group_id,gm_user_status,gm_invited_by_id) VALUES ( %d, %d, %s, %d)", $exist_user_id, $group_id, 'pending_user', $current_user_id );
                                    $wpdb->query($sql1);
                                }
                                else
                                {
                                    //$already_invited[] = $value;
                                }
                                
                                // push notification
                                $sql2 = $wpdb->prepare( "INSERT INTO ".$wp_peepso_notifications." (not_user_id,not_from_user_id,not_module_id,not_external_id,not_type,not_message) VALUES ( %d, %d, %d, %d, %s, %s)", $exist_user_id, $current_user_id, 8, $group_id, 'groups_user_invitation_send', 'invited you to join a group' );
                                $wpdb->query($sql2);
                                
                                // check already added to the link table or not
                                $encryptedEmailID = base64_encode(openssl_encrypt($value, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16)));
                                $link = $wpdb->get_row("SELECT id FROM ".$wp_bulk_invite." WHERE sender_user_id = $current_user_id AND recipient_email_id = '".$encryptedEmailID."' AND group_id = $group_id");
                                $link = json_decode(json_encode($link), true);
                                $link = $link['id'];
                                if(!$link)
                                {
                                    $sql3 = $wpdb->prepare( "INSERT INTO ".$wp_bulk_invite." (sender_user_id,recipient_email_id,group_id) VALUES ( %d, %s, %d)", $current_user_id, $encryptedEmailID, $group_id );
                                    $wpdb->query($sql3);
                                    $link = $wpdb->insert_id;
                                }


                                //$plain_email = "email-id=".$value."&bulk-invite-id=".$link;
                                $plain_email = "invite-from=".$current_user_id."&email-id=".$value."&group-id=".$group_id."&bulk-invite-id=".$link;
                                // Use OpenSSl Encryption method 
                                //$iv_length = openssl_cipher_iv_length($secret_key['ciphermethod']); 
                                //$options = 0; 
                                // Use openssl_encrypt() function to encrypt the data 
                                $encrypted_email_id = base64_encode(openssl_encrypt($plain_email, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16))); 
                                //$encrypted_email_id = stringEncryption('encrypt', $plain_email);

                                //$decrypted_email_id = openssl_decrypt (base64_decode($encrypted_email_id), $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16));

                                $verify_link = $main_domain."/register/?community_activate&community_activation_code=".$user_activation_key."&group_join_params=".$encrypted_email_id;

                                //$message = $current_display_name." has invited you to join the dojoko. Use the mention link to verify your account ".$verify_link." then join the group ".$group_page_link."&".$encrypted_email_id;


                                $message = '<!DOCTYPE html>
                                <html>
                                <head>
                                </head>
                                <body style="display:flex;align-items:center;justify-content:center;height:100vh">
                                
                                
                                
                                   <div style="width:550px;">
                                      <table style="max-width: 750.0px;font-family: Arial, Helvetica, sans-serif;margin: 0;" border="0" cellspacing="0" cellpadding="0" width="100%">
                                         <tbody>
                                           <tr style="background-color: rgb(235,237,240)">
                                               <td align="center" >
                                               <img style="display:block; width:30%" src="'.$main_domain.'/wp-content/themes/peepso-theme-gecko/assets/images/beta-logo.png" class="custom-logo" alt="Dojoko" loading="lazy">
                                            </td>
                                           </tr>
                                            <tr>
                                               <td style="background-color: rgb(255,255,255);border-bottom: 1.0px solid rgb(238,238,238);border-top: 0;margin: 0;">
                                                  <div style="font-size: 14.0px;line-height: 20.0px;color: rgb(51,51,51);padding: 30.0px;">
                                                     <p>Hi '.$recipient_first_name.',<br></p>
                                                     <p>
                                                     '.$current_display_name.' has invited you to join <b>'.$group_name.'</b>
                                                     </p>
                                                    
                                                     
                                                  
                                                     <p>Check it out <a href='.$verify_link.' target="_blank">here</a><br></p>
                                                     <!-- <p>Check it out here <a href='.$group_page_link."&".$encrypted_email_id.' target="_blank">'.$group_page_link."&".$encrypted_email_id.'</a><br></p> -->
                                                     <br>
                                                     <p>Thank you,<br> Team Dojoko</p>
                                                  </div>
                                               </td>
                                            </tr>
                                            <tr>
                                               <td style="background-color: rgb(51,53,56);border-top: 0;padding: 30.0px;margin: 0;text-align: center;">
                                                  <p style="margin: 0.0px;"><span class="x_489249844colour" style="color: rgb(128,132,138);"><span  style="font-size: 12.0px;margin: 0.0px;">This email was sent to '.$recipient_first_name.' (<a href="mailto:'.$value.'" target="_blank" style="color:#00acc1;">'.$value.'</a>).</span></span><br></p>
                                                  <p style="margin: 0.0px;"><span class="x_489249844colour" style="color: rgb(128,132,138);"><span  style="font-size: 12.0px;margin: 0.0px;">If you do not wish to receive these emails from Dojoko, you can <a href="'.$main_domain.'"/profile/?'.$username.'/about/notifications/" target="_blank" style="color:#00acc1;" rel="noreferrer">manage your preferences</a> here.</span><br></p>
                                                  <p style="margin: 10.0px 0.0px 0.0px;"><span  style="color: rgb(98,103,110);"><span  style="font-size: 12.0px;margin: 10.0px 0.0px 0.0px;">Copyright (c) 2021 Dojoko</span></span><br></p>
                                               </td>
                                            </tr>
                                         </tbody>
                                      </table>
                                   </div>
                                
                                </body>
                                </html>';


                                $send = wp_mail( $value, $subject, $message, $headers, array( '' ) );
                                $wpdb->update($wp_bulk_invite, array("invite_link" => $group_page_link."&".$encrypted_email_id, "account_verify_link" => $verify_link), array("id" =>$link), array("%s"), array("%d") );
                                // count number of successfully sent
                                $success++;
                                $success_email[] = $value;
                            }
                            // varified user
                            else
                            {
                                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                                {
                                    $http = "https://"; 
                                }
                                else
                                {
                                    $http = "http://";
                                }

                                $is_group_member = $wpdb->get_row("SELECT gm_user_status FROM ".$wp_peepso_group_members." WHERE gm_user_id = $exist_user_id AND gm_group_id = $group_id");
                                $is_group_member = json_decode(json_encode($is_group_member), true);
                                $user_status = $is_group_member['gm_user_status'];

                                // user already in the group
                                if($user_status)
                                {
                                    // no action
                                    if($user_status == "member")
                                    {
                                        $already_member[] = $value;
                                    }
                                    else if($user_status == "pending_user")
                                    {
                                        $already_invited[] = $value;
                                    }
                                }  
                                else
                                {
                                    // check already invitation sent or not
                                    $pending_user = $wpdb->get_row("SELECT gm_user_status FROM ".$wp_peepso_group_members." WHERE gm_user_id = $exist_user_id AND gm_group_id = $group_id AND gm_user_status = 'pending_user' AND gm_invited_by_id = $current_user_id");
                                    $pending_user = json_decode(json_encode($pending_user), true);
                                    $pending_user = $pending_user['gm_user_status'];

                                    if(!$pending_user)
                                    {
                                    $sql1 = $wpdb->prepare( "INSERT INTO ".$wp_peepso_group_members." (gm_user_id,gm_group_id,gm_user_status,gm_invited_by_id) VALUES ( %d, %d, %s, %d)", $exist_user_id, $group_id, 'pending_user', $current_user_id );
                                        $wpdb->query($sql1);
                                    }
                                    else
                                    {
                                        //$already_invited[] = $value;
                                    }

                                    // push notification
                                    $sql2 = $wpdb->prepare( "INSERT INTO ".$wp_peepso_notifications." (not_user_id,not_from_user_id,not_module_id,not_external_id,not_type,not_message) VALUES ( %d, %d, %d, %d, %s, %s)", $exist_user_id, $current_user_id, 8, $group_id, 'groups_user_invitation_send', 'invited you to join a group' );
                                    $wpdb->query($sql2);

                                    // check already added to the link table or not
                                    $encryptedEmailID = base64_encode(openssl_encrypt($value, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16)));
                                    $link = $wpdb->get_row("SELECT id FROM ".$wp_bulk_invite." WHERE sender_user_id = $current_user_id AND recipient_email_id = '".$encryptedEmailID."' AND group_id = $group_id");
                                    $link = json_decode(json_encode($link), true);
                                    $link = $link['id'];
                                    if(!$link)
                                    {
                                        $sql3 = $wpdb->prepare( "INSERT INTO ".$wp_bulk_invite." (sender_user_id,recipient_email_id,group_id,account_verify_link) VALUES ( %d, %s, %d, %s)", $current_user_id, $encryptedEmailID, $group_id, 'verified user' );
                                        $wpdb->query($sql3);
                                        $link = $wpdb->insert_id;
                                    }


                                    $plain_email = "email-id=".$value."&bulk-invite_id=".$link;
                                    // Use OpenSSl Encryption method 
                                    //$iv_length = openssl_cipher_iv_length($secret_key['ciphermethod']); 
                                    //$options = 0; 
                                    // Use openssl_encrypt() function to encrypt the data 
                                    $encrypted_email_id = base64_encode(openssl_encrypt($plain_email, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16))); 
                                    //$encrypted_email_id = stringEncryption('encrypt', $plain_email);

                                    //$message = $current_display_name." has invited you to join the group. Use the mention link to join the group ".$group_page_link."&".$encrypted_email_id; 

                                    $message = '<!DOCTYPE html>
                                <html>
                                <head>
                                </head>
                                <body style="display:flex;align-items:center;justify-content:center;height:100vh">
                                
                                
                                
                                   <div style="width:550px;">
                                      <table style="max-width: 750.0px;font-family: Arial, Helvetica, sans-serif;margin: 0;" border="0" cellspacing="0" cellpadding="0" width="100%">
                                         <tbody>
                                           <tr style="background-color: rgb(235,237,240)">
                                               <td align="center" >
                                               <img style="display:block; width:30%" src="'.$main_domain.'/wp-content/themes/peepso-theme-gecko/assets/images/beta-logo.png" class="custom-logo" alt="Dojoko" loading="lazy">
                                            </td>
                                           </tr>
                                            <tr>
                                               <td style="background-color: rgb(255,255,255);border-bottom: 1.0px solid rgb(238,238,238);border-top: 0;margin: 0;">
                                                  <div style="font-size: 14.0px;line-height: 20.0px;color: rgb(51,51,51);padding: 30.0px;">
                                                     <p>Hi '.$recipient_first_name.',<br></p>
                                                     <p>
                                                     '.$current_display_name.' has invited you to join <b>'.$group_name.'</b>
                                                     </p>
                                                    
                                                     
                                                  
                                                     
                                                     <p>Check it out <a href='.$group_page_link."&".$encrypted_email_id.' target="_blank">here</a><br></p>
                                                     <br>
                                                     <p>Thank you,<br> Team Dojoko</p>
                                                  </div>
                                               </td>
                                            </tr>
                                            <tr>
                                               <td style="background-color: rgb(51,53,56);border-top: 0;padding: 30.0px;margin: 0;text-align: center;">
                                                  <p style="margin: 0.0px;"><span class="x_489249844colour" style="color: rgb(128,132,138);"><span  style="font-size: 12.0px;margin: 0.0px;">This email was sent to '.$recipient_first_name.' (<a href="mailto:'.$value.'" target="_blank" style="color:#00acc1;">'.$value.'</a>).</span></span><br></p>
                                                  <p style="margin: 0.0px;"><span class="x_489249844colour" style="color: rgb(128,132,138);"><span  style="font-size: 12.0px;margin: 0.0px;">If you do not wish to receive these emails from Dojoko, you can <a href="'.$main_domain.'"/profile/?'.$username.'/about/notifications/" target="_blank" style="color:#00acc1;" rel="noreferrer">manage your preferences</a> here.</span><br></p>
                                                  <p style="margin: 10.0px 0.0px 0.0px;"><span  style="color: rgb(98,103,110);"><span  style="font-size: 12.0px;margin: 10.0px 0.0px 0.0px;">Copyright (c) 2021 Dojoko</span></span><br></p>
                                               </td>
                                            </tr>
                                         </tbody>
                                      </table>
                                   </div>
                                
                                </body>
                                </html>';

                                    $send = wp_mail( $value, $subject, $message, $headers, array( '' ) );
                                    $wpdb->update($wp_bulk_invite, array("invite_link" => $group_page_link."&".$encrypted_email_id), array("id" =>$link), array("%s"), array("%d") );
                                    // count number of successfully sent
                                    $success++;
                                    $success_email[] = $value;
                                }                                   
                            }
                        }
                        else
                        { 
                            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                            {
                                $http = "https://"; 
                            }
                            else
                            {
                                $http = "http://";
                            }

                            // for new user - send registration link

                            // check already added to the link table or not
                            $encryptedEmailID = base64_encode(openssl_encrypt($value, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16)));
                            $link = $wpdb->get_row("SELECT id FROM ".$wp_bulk_invite." WHERE sender_user_id = $current_user_id AND recipient_email_id = '".$encryptedEmailID."' AND group_id = $group_id");
                            $link = json_decode(json_encode($link), true);
                            $link = $link['id'];
                            if(!$link)
                            {
                                $sql3 = $wpdb->prepare( "INSERT INTO ".$wp_bulk_invite." (sender_user_id,recipient_email_id,group_id,account_verify_link) VALUES ( %d, %s, %d, %s)", $current_user_id, $encryptedEmailID, $group_id, 'need registration' );
                                $wpdb->query($sql3);
                                $link = $wpdb->insert_id;
                            }


                            $plain_params = "invite-from=".$current_user_id."&email-id=".$value."&group-id=".$group_id."&bulk-invite-id=".$link;
                            // Use OpenSSl Encryption method 
                            //$iv_length = openssl_cipher_iv_length($secret_key['ciphermethod']); 
                            //$options = 0; 
                            // Use openssl_encrypt() function to encrypt the data 
                            $encrypted_params = base64_encode(openssl_encrypt($plain_params, $secret_key['ciphermethod'], hash('sha256', $secret_key['enc_key']), $secret_key['options'], substr(hash('sha256', $secret_key['enc_key']), 0, 16))); 
                            //$encrypted_params = stringEncryption('encrypt', $plain_params);

                            //$invitation_link = $http.$_SERVER['SERVER_NAME']."/register?".$encrypted_params;
                            $invitation_link = $main_domain."/register?".$encrypted_params;
                            //$message = $current_display_name." has invited you to join the dojoko. Use the mention link to sign up your account and get started ".$invitation_link; 

                            $message = '<!DOCTYPE html>
                            <html>
                            <head>
                            </head>
                            <body style="display:flex;align-items:center;justify-content:center;height:100vh">
                            
                            
                            
                               <div style="width:550px;">
                                  <table style="max-width: 750.0px;font-family: Arial, Helvetica, sans-serif;margin: 0;" border="0" cellspacing="0" cellpadding="0" width="100%">
                                     <tbody>
                                       <tr style="background-color: rgb(235,237,240)">
                                           <td align="center" >
                                           <img style="display:block; width:30%" src="'.$main_domain.'/wp-content/themes/peepso-theme-gecko/assets/images/beta-logo.png" class="custom-logo" alt="Dojoko" loading="lazy">
                                        </td>
                                       </tr>
                                        <tr>
                                           <td style="background-color: rgb(255,255,255);border-bottom: 1.0px solid rgb(238,238,238);border-top: 0;margin: 0;">
                                              <div style="font-size: 14.0px;line-height: 20.0px;color: rgb(51,51,51);padding: 30.0px;">
                                                 <p>Hi '.$recipient_first_name.',<br></p>
                                                 <p>
                                                 '.$current_display_name.' has invited you to join <b>'.$group_name.'</b>
                                                 </p>
                                                
                                                 
                                              
                                                 <p>Check it out <a href='.$invitation_link.' target="_blank">here</a><br></p>
                                                 <br>
                                                 <p>Thank you,<br> Team Dojoko</p>
                                              </div>
                                           </td>
                                        </tr>
                                        <tr>
                                           <td style="background-color: rgb(51,53,56);border-top: 0;padding: 30.0px;margin: 0;text-align: center;">
                                              <p style="margin: 0.0px;"><span class="x_489249844colour" style="color: rgb(128,132,138);"><span  style="font-size: 12.0px;margin: 0.0px;">This email was sent to '.$recipient_first_name.' (<a href="mailto:'.$value.'" target="_blank" style="color:#00acc1;">'.$value.'</a>).</span></span><br></p>
                                             
                                              <p style="margin: 10.0px 0.0px 0.0px;"><span  style="color: rgb(98,103,110);"><span  style="font-size: 12.0px;margin: 10.0px 0.0px 0.0px;">Copyright (c) 2021 Dojoko</span></span><br></p>
                                           </td>
                                        </tr>
                                     </tbody>
                                  </table>
                               </div>
                            
                            </body>
                            </html>';

                            $send = wp_mail( $value, $subject, $message, $headers, array( '' ) );
                            $wpdb->update($wp_bulk_invite, array("invite_link" => $invitation_link), array("id" =>$link), array("%s"), array("%d") );
                            // count number of successfully sent
                            $success++;
                            $success_email[] = $value;
                        }
                }
                if($success > 0)
                {
                    //$s = ($success > 1) ? "s" : "";
                    $output = array('success' => true, 'auth'=>true, 'already_member' => $already_member, 'already_invited' => $already_invited, 'invalid_email' => $invalid_email, 'your_email' => $your_email, 'success_email' => $success_email, 'msg' => 'Your invitation has been successfully sent to', 'link' => $group_page_link);
                }
                else
                {
                    $output = array('success' => false, 'auth'=>true, 'already_member' => $already_member, 'already_invited' => $already_invited, 'invalid_email' => $invalid_email, 'your_email' => $your_email, 'success_email' => $success_email, 'msg' => 'No invitation send', 'link' => $group_page_link);
                }
            }
            else
            {
                $output = array('success' => false, 'auth'=>true, 'already_member' => $already_member, 'already_invited' => $already_invited, 'invalid_email' => $invalid_email, 'your_email' => $your_email, 'success_email' => $success_email, 'msg' => 'Max allow is '.$max.' but you have entered '.$count_email.' emails');
            }
        }   
    }
    
    echo json_encode($output);
    }

///// END BULK INVITE /////



///// EMPTY CV NOTIFICATION SEND CODE START /////

if( isset($_GET['send_cv_notification']) ){
	$current_user_id = get_current_user_id();
    $recipient_user_id = $_GET['payload']['recipient_user_id'];
    if($current_user_id == null)
    {
    	$output = array('success'=>false,'auth'=>false,'msg'=>'You are not authorized to perform this action.');
    }
    else
    {
    $table_name = $wpdb->prefix . 'peepso_notifications';
    $sql1 = $wpdb->prepare( "INSERT INTO ".$table_name." (not_user_id,not_from_user_id,not_module_id,not_external_id,not_type,not_message,not_read) VALUES ( %d, %d, %d, %d, %s, %s, %d)", $recipient_user_id, $current_user_id, 3, 0, 'friends_requests', 'is encouraging you to create your CV!', 0 );
    $wpdb->query($sql1);
    $output = array('success'=>true,'msg'=>'Notification sent successfully!','auth'=>true,'result'=>$result);
    }
 	echo json_encode($output);
 	exit;
}

///// EMPTY CV NOTIFICATION SEND CODE END /////

?>