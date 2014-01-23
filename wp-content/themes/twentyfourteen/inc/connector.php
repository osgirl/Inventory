<?php

include_once('../../../../wp-load.php');

if(isset($_POST['dbf_submitted'])){

	$postid = $_POST['dbf_00_post_id'];
	$thetitle = strtolower(get_the_title($postid));

	$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));

	// Test Database Connection
	if($dbf_db){
		$dbf_insert = array();
		foreach($dbf_sec_fields as $field){
			$dbf_column = $field['name'];
			if(isset($_POST[$dbf_column])){
				$dbf_insert[$dbf_column] = $_POST[$dbf_column];
			}
		}
				
		if($dbf_db->insert($thetitle, $dbf_insert)){
					$returns = array(	'message'	=>	'success'	);
					$dbf_prev_url = get_permalink($_POST['dbf_'.$_POST['dbf_submitted'].'_post_id']);
					header("Location: ".add_query_arg($returns, $dbf_prev_url));
					exit;
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

?>
