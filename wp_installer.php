<?php 
                                
  if(file_exists('wp-config.php')){                              
                                
   function wp_backup_get_config_db_name() {
                               $filepath='wp-config.php';
                               $config_file = @file_get_contents("$filepath", true);
                               preg_match("/'DB_NAME',\s*'(.*)?'/", $config_file, $matches);
                               return $matches[1];
}

function wp_backup_get_config_data($key) {
        $filepath='wp-config.php';
        $config_file = @file_get_contents("$filepath", true);
	switch($key) {
		case 'DB_NAME':
			preg_match("/'DB_NAME',\s*'(.*)?'/", $config_file, $matches);
			break;
		case 'DB_USER':
			preg_match("/'DB_USER',\s*'(.*)?'/", $config_file, $matches);
			break;
		case 'DB_PASSWORD':
			preg_match("/'DB_PASSWORD',\s*'(.*)?'/", $config_file, $matches);
			break;
		case 'DB_HOST':
			preg_match("/'DB_HOST',\s*'(.*)?'/", $config_file, $matches);
			break;
	}
	return $matches[1];
}

function wp_backup_installer_serialize_callback($match) { 
    return 's:'.strlen($match[2]); 
} 

function wpbk_update_wp_config($dbname, $dbuser, $dbpassword, $dbhost) {
	$config_file = @file_get_contents('wp-config.php', true);
	$patterns = array("/'DB_NAME',\s*'.*?'/", "/'DB_USER',\s*'.*?'/", "/'DB_PASSWORD',\s*'.*?'/", "/'DB_HOST',\s*'.*?'/");					   
	$replace = array("'DB_NAME', ".'\''.$dbname.'\'', "'DB_USER', ".'\''.$dbuser.'\'', "'DB_PASSWORD', ".'\''.$dbpassword.'\'', "'DB_HOST', ".'\''.$dbhost.'\'');	
	$config_file = preg_replace($patterns, $replace, $config_file);
	file_put_contents('wp-config.php', $config_file);
        
}

                                $database_name=wp_backup_get_config_db_name();
				$database_user=wp_backup_get_config_data('DB_USER');				
				$datadase_password=wp_backup_get_config_data('DB_PASSWORD');
				$database_host=wp_backup_get_config_data('DB_HOST');
                                $old_url = 'http://d1oa08zxy46bmk.cloudfront.net';
                                $database_file="Dojoko_Beta_2020_11_11_1605133347_5ac5d3d_wpall.sql";
				$backup_zip_file="Dojoko_Beta_2020_11_11_1605133347_5ac5d3d_wpall.zip";
                                $duplicate_flag=0;
                                

                ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>WordPress &rsaquo; Setup Configuration File</title>
	<link rel='stylesheet' id='buttons-css'  href='wp-includes/css/buttons.min.css?ver=4.0' type='text/css' media='all' />
<link rel='stylesheet' id='open-sans-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext&#038;ver=4.0' type='text/css' media='all' />
<link rel='stylesheet' id='install-css'  href='wp-admin/css/install.min.css?ver=4.0' type='text/css' media='all' />
</head>
<body class="wp-core-ui">
    <?php 
     if(isset($_POST['submit'])){
                                $database_name=trim($_POST['dbname']);
				$database_user=$_POST['uname'];
				$datadase_password=$_POST['pwd'];
				$database_host=$_POST['dbhost'];
                    if($_POST['submit']=='Test Database Connection'){
                        if((trim((string)$database_name) != '') && (trim((string)$database_user) != '') && (trim((string)$datadase_password) != '') && (trim((string)$database_host) != '') && ($conn = @mysqli_connect((string)$database_host, (string)$database_user, (string)$datadase_password))) {                    
                        echo '<script>alert("Suscessfull Database connection!")</script>';
                    }else{
                         echo '<script>alert("Database connection error. Be sure these database parameters are correct.")</script>';
                    }
                    }
                     if($_POST['submit']=='Restore'){                        
                        if(file_exists($database_file)){            
                        if((trim((string)$database_name) != '') && (trim((string)$database_user) != '') && (trim((string)$datadase_password) != '') && (trim((string)$database_host) != '') && ($conn = @mysqli_connect((string)$database_host, (string)$database_user, (string)$datadase_password))) {                    
                                ini_set("max_execution_time", "5000"); 
				ini_set("max_input_time",     "5000");
				ini_set('memory_limit', '1000M');
				set_time_limit(0);
                                
                                	/*BEGIN: Select the Database*/
                                        if(!mysqli_select_db((string)$database_name, $conn)) {
                                                $sql = "CREATE DATABASE IF NOT EXISTS `".(string)$database_name."`";
                                                mysqli_query($sql, $conn);
                                                mysqli_select_db((string)$database_name, $conn);
                                        }
                                        /*END: Select the Database*/
		
                                        /*BEGIN: Remove All Tables from the Database*/
                                        $found_tables = null;
                                        if($result = mysqli_query("SHOW TABLES FROM `{".(string)$database_name."}`", $conn)){
                                                while($row = mysqli_fetch_row($result)){
                                                        $found_tables[] = $row[0];
                                                }
                                                if (count($found_tables) > 0) {
                                                        foreach($found_tables as $table_name){
                                                                mysqli_query("DROP TABLE `{".(string)$database_name."}`.{$table_name}", $conn);
                                                        }
                                                }
                                        }
                                        /*END: Remove All Tables from the Database*/

                                        /*BEGIN: Restore Database Content*/
                                        
                                        if(isset($database_file))
                                        {                                           
                                            $sql_file = @file_get_contents($database_file, true);
                                           
                                            if(trim((string)$_POST['new_url']) != '') {
                                                           $sql_file = str_replace($old_url, (string)$_POST['new_url'], $sql_file);
                                                           $url=(string)$_POST['new_url'];
                                                  }else{
                                                      $url=$old_url;
                                                  }

                                            $sql_queries = explode(";\n", $sql_file);


                                            for($i = 0; $i < count($sql_queries); $i++) {
                                                    mysqli_query($sql_queries[$i], $conn);
                                            }
                                             wpbk_update_wp_config($database_name, $database_user, $datadase_password, $database_host);
                                             $duplicate_flag=1;
                                             echo "<p style='text-align:center'>Your Site is successfully restored Click <a href='$url'>Here </a>for visit site.</p>";
                                             @unlink('wp_installer.php');
                                             @unlink($database_file);
					     @unlink($backup_zip_file);
                                             
                                        }
                                            }else{


                                            }
                         }else{
                             echo 'Database file missing';exit;
                         }
                                                }
                                            
                }?>
<h1 id="logo"><a href="https://wordpress.org/" tabindex="-1">WordPress</a></h1>
<div style="font-size:22px; padding:5px 0px 0px 0px;text-align: center;">WP ALL Backup Plus - Installer
				</div>
<?php if ($duplicate_flag==0) {?>
<form method="post" action="">
	<p>Below you should enter your database connection details.</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">Database Name</label></th>
			<td><input name="dbname" id="dbname" type="text" required value="<?php echo $database_name?>" /></td>
			<td>The name of the database you want to run WP in.</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">User Name</label></th>
			<td><input name="uname" id="uname" type="text"  required value="<?php echo $database_user?>" /></td>
			<td>Your MySQL username</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">Password</label></th>
			<td><input name="pwd" id="pwd" type="text" required value="<?php echo $datadase_password?>" autocomplete="off" /></td>
			<td>&hellip;and your MySQL password.</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">Database Host</label></th>
			<td><input name="dbhost" id="dbhost" type="text" required value="<?php echo $database_host?>" /></td>
			<td>You should be able to get this info from your web host, if <code>localhost</code> does not work.</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">New URL</label></th>
			<td><input name="new_url" id="prefix" type="text" value="" /></td>
			<td>Leave Bank for Restore. If you are moving site from site1 to site2 then enter New URL<br>Note: Do not put a forward slash at the end of the URL</td>
		</tr>
	</table>
        <div id="dup-step1-warning" style="height:90px;overflow-y: scroll;border: 1px solid;padding:5px;margin:5px">
    	    <b>WARNINGS &amp; NOTICES</b> 
    	    <p>
				<b>Disclaimer:</b> 
				This plugin require above average technical knowledge. Please use it at your own risk and always back up your database and files beforehand using another backup
				system besides the WP ALL Backup. If you're not sure about how to use this tool then please enlist the guidance of a technical professional.  <u>Always</u> test 
				this installer in a sandbox environment before trying to deploy into a production setting.
			</p>    
    	    <p>
				<b>Database:</b>
				Do not connect to an existing database unless you are 100% sure you want to remove all of it's data. Connecting to a database 
				that already exists will permanently DELETE all data in that database. This tool is designed to populate and fill a database with NEW data from a duplicated
				database using the SQL script in the package name above.
			</p>    
    	</div>
        <div>
    	    <input type="checkbox" name="accpet-warnings"> <label for="accept-warnings">I have read all warnings &amp; notices</label><br>
			
    	</div>
		<input type="hidden" name="language" value="" />                
	<p class="step">
        <input name="submit" type="submit" value="Test Database Connection" class="button button-large" />
        <input name="submit" type="submit" value="Restore" class="button button-large" />
        </p>
</form>
<p style="float:right">
    <a href="www.wpseeds.com/wp-all-backup#restore" target="_blank" title="How to restore/duplicate site">Documentation</a> 
    <a href="www.wpseeds.com/support/" target="_blank" title="Support">Help</a>
</p>
<script type='text/javascript' src='wp-includes/js/jquery/jquery.js?ver=1.11.1'></script>
<script type='text/javascript' src='wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='wp-admin/js/language-chooser.min.js?ver=4.0'></script>
<?php } 
?>
</body>
</html>
<?php
                               
} else{
    echo "Config file not exist. Please contact support";    
}
                ?>
