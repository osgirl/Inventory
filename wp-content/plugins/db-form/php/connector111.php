<?php

include_once('../../../../wp-load.php');




if(isset($_POST['dbf_submitted'])){

//	$thetitle = $_POST['dbf_submitted'];
	$table = mysql_real_escape_string($_POST['dbf_submitted']);
	$identifier = $table.'_id';
	$pidentifier = $table.'_pid';

	$dbf_sec_fields = get_option('dbf-'.$_POST["dbf_submitted"].'-all-fields');
	$dbf_fields_wrong = array();
	foreach ($dbf_sec_fields as $field){
		if(isset($_POST[$field['name']])){
			if(str_replace(' ','',$_POST[$field['name']]) == '' && $field['required'] == 'true'){
				$dbf_fields_wrong[] = $field;
			}else if($field['type'] == 'mail' && $field['required'] == 'true'){
				if(!check_email($_POST[$field['name']])){
					$dbf_fields_wrong[] = $field;
				}
			}
		}else{
			if($field['required'] == 'true'){
				$dbf_fields_wrong[] = $field;
			}
		}
	}
	$dbf_backup_array = '';
	foreach ($dbf_sec_fields as $field){
		if(isset($_POST[$field['name']])){
			$dbf_backup_array[$field['name']] = $_POST[$field['name']];
		}else{
			$dbf_backup_array[$field['name']] = '';
		}
	}
	update_option('dbf-'.$_POST["dbf_submitted"].'-last-fields', $dbf_backup_array);
	
	if(count($dbf_fields_wrong) <= 99){
		if(get_option('dbf-0-main-function') == 'mail'){
			$dbf_mail_content = nl2br(get_option('dbf-0-mail-content'));
			preg_match_all('/%(.*)%/U', $dbf_mail_content , $matches);
			foreach ($matches[0] as $match){
				if(isset($_POST[substr($match, 1, -1)])){
					$dbf_mail_content = str_replace($match, nl2br($_POST[substr($match, 1, -1)]), $dbf_mail_content);
				}
			}
			$dbf_mail_header = "From: ".get_bloginfo('name')." < ".get_bloginfo('admin_email')." >\n";
			$dbf_mail_header .= "Content-Type: text/html\n";
			$dbf_mail_header .= "Content-Transfer-Encoding: 8bit\n";
			
			if(mail(get_option('dbf-0-admin-mail'), get_option('dbf-0-mail-subject'), $dbf_mail_content, $dbf_mail_header)){
				if(get_option('dbf-0-confirmation') == 'true'){
					echo "hello";
					if(get_option('dbf-0-confirmation-function') == 'custom'){
						preg_match_all('/%(.*)%/U', get_option('dbf-0-confirmation-recipient') , $matches);
						if(count($matches[0]) == 1){$dbf_confirmation_recipient = $_POST[$matches[1][0]];}else{$dbf_confirmation_recipient = get_option('dbf-0-confirmation-recipient');}
					}else{$dbf_confirmation_recipient = get_option('dbf-0-admin-mail');}
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
					
					if(mail($dbf_confirmation_recipient, get_option('dbf-0-confirmation-subject'), $dbf_confirmation_content, $dbf_confirmation_header)){
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
						$returns = array(	'message'	=>	'alert-mailcon'	);
						$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
						header("Location: ".add_query_arg($returns, $dbf_prev_url));
						exit;
					}
				}else{
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
				$returns = array(	'message'	=>	'warning-mail'	);
				$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
				header("Location: ".add_query_arg($returns, $dbf_prev_url));
				exit;
			}
		
		}elseif(get_option('dbf-0-main-function') == 'data'){
			$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
			if($dbf_db){
				$dbf_insert = array();
				foreach($_POST['arr'] as $column => $array) {
					$dbf_insert[$column] = json_encode($array);
				}
				foreach($dbf_sec_fields as $field){
					$dbf_column = $field['name'];
					if(isset($_POST[$dbf_column])){
						$dbf_insert[$dbf_column] = $_POST[$dbf_column];
					}
				}
				$dbf_insert[$table.'_modified_by'] = $current_user->user_login;

				if($dbf_db->insert($table, $dbf_insert)){
					$edit_id = $dbf_db->insert_id;
					$dbf_insert[$pidentifier] = $edit_id;
					$dbf_db->update($table, $dbf_insert, array( $identifier => $edit_id ));
					if(get_option('dbf-0-confirmation') == 'true'){
						if(get_option('dbf-0-confirmation-function') == 'custom'){
							preg_match_all('/%(.*)%/U', get_option('dbf-0-confirmation-recipient') , $matches);
							if(count($matches[0]) == 1){$dbf_confirmation_recipient = $_POST[$matches[1][0]];}else{$dbf_confirmation_recipient = get_option('dbf-0-confirmation-recipient');}
						}else{$dbf_confirmation_recipient = get_option('dbf-0-admin-mail');}
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
						
						if(mail($dbf_confirmation_recipient, get_option('dbf-0-confirmation-subject'), $dbf_confirmation_content, $dbf_confirmation_header)){
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
							$returns = array(	'message'	=>	'alert-mailcon'	);
							$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
							header("Location: ".add_query_arg($returns, $dbf_prev_url));
							exit;
						}
					}else{
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
					$returns = array(	'message'	=>	'warning-dbins'	);
					$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
					header("Location: ".add_query_arg($returns, $dbf_prev_url));
					exit;
				}
				
			}else{
				$returns = array(	'message'	=>	'warning-dbcon'	);
				$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
				header("Location: ".add_query_arg($returns, $dbf_prev_url));
				exit;
			}
		}
	}else{
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
}else{
	echo 'Huh, what are you doing here? *PUNCH* <br />';
	header('Refresh: 1;url='.get_bloginfo('siteurl').'');
	exit;
}


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
