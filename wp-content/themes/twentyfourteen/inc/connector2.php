<?php

include_once('../../../../wp-load.php');

if(isset($_POST['dbf_submitted'])){

	$thetitle = $_POST['dbf_post_name'];

	$dbf_sec_fields = get_option('dbf-'.$_POST["dbf_submitted"].'-all-fields');
	$dbf_fields_wrong = array();
	foreach ($dbf_sec_fields as $field){
		if(isset($_POST[$field['name']])){
			//____leer&required = bad
			if(str_replace(' ','',$_POST[$field['name']]) == '' && $field['required'] == 'true'){
				$dbf_fields_wrong[] = $field;
			}else if($field['type'] == 'mail' && $field['required'] == 'true'){
				if(!check_email($_POST[$field['name']])){
					$dbf_fields_wrong[] = $field;
				}
			}
		}else{
			//____undefined&required = bad
			if($field['required'] == 'true'){
				$dbf_fields_wrong[] = $field;
			}
		}
	}
	//__backup Array bauen
	$dbf_backup_array = '';
	foreach ($dbf_sec_fields as $field){
		if(isset($_POST[$field['name']])){
			$dbf_backup_array[$field['name']] = $_POST[$field['name']];
		}else{
			$dbf_backup_array[$field['name']] = '';
		}
	}
	update_option('dbf-'.$_POST["dbf_submitted"].'-last-fields', $dbf_backup_array);
	
	//__weiter/zurück
	if(count($dbf_fields_wrong) <= 0){
		//____mail
		if(get_option('dbf-0-main-function') == 'mail'){
			//______ausdrücke ersetzen
			$dbf_mail_content = nl2br(get_option('dbf-0-mail-content'));
			preg_match_all('/%(.*)%/U', $dbf_mail_content , $matches);
			foreach ($matches[0] as $match){
				if(isset($_POST[substr($match, 1, -1)])){
					$dbf_mail_content = str_replace($match, nl2br($_POST[substr($match, 1, -1)]), $dbf_mail_content);
				}
			}
			//______mail bauen
			$dbf_mail_header = "From: ".get_bloginfo('name')." < ".get_bloginfo('admin_email')." >\n";
			$dbf_mail_header .= "Content-Type: text/html\n";
			$dbf_mail_header .= "Content-Transfer-Encoding: 8bit\n";
			
			//______mail throw!
			if(mail(get_option('dbf-0-admin-mail'), get_option('dbf-0-mail-subject'), $dbf_mail_content, $dbf_mail_header)){
				//________confirmation
				if(get_option('dbf-0-confirmation') == 'true'){
					echo "hello";
					//________confirmation bauen
					//__________recipient
					if(get_option('dbf-0-confirmation-function') == 'custom'){
						preg_match_all('/%(.*)%/U', get_option('dbf-0-confirmation-recipient') , $matches);
						if(count($matches[0]) == 1){$dbf_confirmation_recipient = $_POST[$matches[1][0]];}else{$dbf_confirmation_recipient = get_option('dbf-0-confirmation-recipient');}
					}else{$dbf_confirmation_recipient = get_option('dbf-0-admin-mail');}
					//__________content
					$dbf_confirmation_content = nl2br(get_option('dbf-0-confirmation-content'));
					preg_match_all('/%(.*)%/U', $dbf_confirmation_content , $matches);
					foreach ($matches[0] as $match){
						if(isset($_POST[substr($match, 1, -1)])){
							$dbf_confirmation_content = str_replace($match, nl2br($_POST[substr($match, 1, -1)]), $dbf_confirmation_content);
						}
					}
					$dbf_confirmation_header = "From: ".get_bloginfo('name')." < ".get_bloginfo('admin_email')." >\n";
					$dbf_confirmation_header .= "Content-Type: text/html\n";
					$dbf_confirmation_header .= "Content-Transfer-Encoding: 8bit\n";
					
					//________confirmation throw!
					if(mail($dbf_confirmation_recipient, get_option('dbf-0-confirmation-subject'), $dbf_confirmation_content, $dbf_confirmation_header)){
						//________zurück/woanders
						if(get_option('dbf-0-redirect') != 'custom' ){
							$returns = array(	'message'	=>	'success'	);
							$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
							header("Location: ".add_query_arg($returns, $dbf_prev_url));
							exit;
						}else{
							header("Location: ".get_option('dbf-0-redirect-url'));
							exit;
						}
					}else{
						//________zurück+meldung
						$returns = array(	'message'	=>	'alert-mailcon'	);
						$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
						header("Location: ".add_query_arg($returns, $dbf_prev_url));
						exit;
					}
				}else{
					//________zurück/woanders
					if(get_option('dbf-0-redirect') != 'custom' ){
						$returns = array(	'message'	=>	'success'	);
						$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
						header("Location: ".add_query_arg($returns, $dbf_prev_url));
						exit;
					}else{
						header("Location: ".get_option('dbf-0-redirect-url'));
						exit;
					}
				}
			}else{
				//________zurück+meldung
				$returns = array(	'message'	=>	'warning-mail'	);
				$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
				header("Location: ".add_query_arg($returns, $dbf_prev_url));
				exit;
			}
		
		//____data	
		}elseif(get_option('dbf-0-main-function') == 'data'){
			//______datenbank connect
			$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
			if($dbf_db){
			
				//______string vorbereiten
				$dbf_insert = array();
				foreach($dbf_sec_fields as $field){
					$dbf_column = $field['name'];
					if(isset($_POST[$dbf_column])){
						$dbf_insert[$dbf_column] = $_POST[$dbf_column];
					}
				}
				
				//______push!
//				if($dbf_db->insert(get_option('dbf-0-db-table'), $dbf_insert)){
				if($dbf_db->insert($thetitle, $dbf_insert)){
					//________confirmation
					if(get_option('dbf-0-confirmation') == 'true'){
						//________confirmation bauen
						//__________recipient
						if(get_option('dbf-0-confirmation-function') == 'custom'){
							preg_match_all('/%(.*)%/U', get_option('dbf-0-confirmation-recipient') , $matches);
							if(count($matches[0]) == 1){$dbf_confirmation_recipient = $_POST[$matches[1][0]];}else{$dbf_confirmation_recipient = get_option('dbf-0-confirmation-recipient');}
						}else{$dbf_confirmation_recipient = get_option('dbf-0-admin-mail');}
						//__________content
						$dbf_confirmation_content = nl2br(get_option('dbf-0-confirmation-content'));
						preg_match_all('/%(.*)%/U', $dbf_confirmation_content , $matches);
						foreach ($matches[0] as $match){
							if(isset($_POST[substr($match, 1, -1)])){
								$dbf_confirmation_content = str_replace($match, nl2br($_POST[substr($match, 1, -1)]), $dbf_confirmation_content);
							}
						}
						$dbf_confirmation_header = "From: ".get_bloginfo('name')." < ".get_bloginfo('admin_email')." >\n";
						$dbf_confirmation_header .= "Content-Type: text/html\n";
						$dbf_confirmation_header .= "Content-Transfer-Encoding: 8bit\n";
						
						//________confirmation throw!
						if(mail($dbf_confirmation_recipient, get_option('dbf-0-confirmation-subject'), $dbf_confirmation_content, $dbf_confirmation_header)){
							//________zurück/woanders
							if(get_option('dbf-0-redirect') != 'custom' ){
								$returns = array(	'message'	=>	'success'	);
								$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
								header("Location: ".add_query_arg($returns, $dbf_prev_url));
								exit;
							}else{
								header("Location: ".get_option('dbf-0-redirect-url'));
								exit;
							}
						}else{
							//________zurück+meldung
							$returns = array(	'message'	=>	'alert-mailcon'	);
							$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
							header("Location: ".add_query_arg($returns, $dbf_prev_url));
							exit;
						}
					}else{
						//________zurück/woanders
						if(get_option('dbf-0-redirect') != 'custom' ){
							$returns = array(	'message'	=>	'success'	);
							$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
							header("Location: ".add_query_arg($returns, $dbf_prev_url));
							exit;
						}else{
							header("Location: ".get_option('dbf-0-redirect-url'));
							exit;
						}
					}
				}else{
					//______zurück+meldung
					$returns = array(	'message'	=>	'warning-dbins'	);
					$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
					header("Location: ".add_query_arg($returns, $dbf_prev_url));
					exit;
				}
				
			}else{
				//______zurück+meldung
				$returns = array(	'message'	=>	'warning-dbcon'	);
				$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
//				header("Location: ".add_query_arg($returns, $dbf_prev_url));
var_dump($_POST);

				exit;
			}
		}
	}else{
		//____zurück+meldung
		$returns = array(	'message'	=>	'warning-input',
							'fields'	=>	''
						);
		foreach ($dbf_fields_wrong as $field){
			$returns['fields'] .= $field['name'].';';
		}
		$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
		header("Location: ".add_query_arg($returns, $dbf_prev_url));
		exit;
	}
//ODER NICHT?
}else{
	echo 'Huh, what are you doing here? *PUNCH* <br />';
	header('Refresh: 1;url='.get_bloginfo('siteurl').'');
	exit;
}


//ALLGEMEINE FUNKTIONEN
function check_email($email) {
    if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        return false;
    }
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            return false;
        }
    }
    if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
        $domain_array = explode(".", $email_array[1]);
        if(sizeof($domain_array) < 2) {
            return false;
        }
        for($i = 0; $i < sizeof($domain_array); $i++) {
            if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}

?>
