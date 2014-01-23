<?php

//IS NESTED?
$dbf_foundouter = false;
$dbf_outerid = '';

//DEFINITIONS
$dbf_sec_option = '';
$dbf_warning_enclosure 	= 	'<strong>Shortcode is not enclosed by "[db_form]".</strong>';
$dbf_warning_radio 		= 	'<strong>Label and Value count don\'t match.</strong>';
$dbf_wrong_fields 		=	array();
$dbf_last_fields		=	'';

//MESSAGES
$dbf_success 					= nl2br(get_option('dbf-0-redirect-message'));
$dbf_failure_input 				= nl2br(get_option('dbf-0-failure-input'));
$dbf_failure_db_connection 		= nl2br(get_option('dbf-0-failure-db-connection'));
$dbf_failure_db_insert 			= nl2br(get_option('dbf-0-failure-db-insert'));
$dbf_failure_mail 				= nl2br(get_option('dbf-0-failure-mail'));
$dbf_failure_mail_confirmation 	= nl2br(get_option('dbf-0-failure-mail-confirmation'));

//ENCLOSURE
function dbf_enclosure($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	global $dbf_success, $dbf_failure_input, $dbf_failure_db_connection, $dbf_failure_db_insert, $dbf_failure_mail, $dbf_failure_mail_confirmation;
	
	$inbetween = strlen(str_replace("<br />","",trim($content)));
	if($inbetween > 0){
		//__values
		extract( shortcode_atts( array(
			'id' => '00',
			'classes' => ''
		), $atts ) );
		
		//__secure
		$dbf_sec_option = 'dbf-'.$id.'-all-fields';
		$dbf_sec_value = array();
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__workwork
		//____eventuell message anzeigen
		$throwback = '';
		$dbf_hide_class = '';
		$dbf_foundouter = true;
		$dbf_outerid = $id;
		if(isset($_GET['message'])){
			$dbf_message_class = explode('-', $_GET['message']);
			$dbf_message_class = 'dbf_notice_'.$dbf_message_class[0];
			switch ($_GET['message']) {
				case 'success':
					if(get_option('dbf-0-redirect') == 'none'){
						$dbf_message = '';
					}else{
						$dbf_message = $dbf_success;
					}
					if(get_option('dbf-0-hide') == 'true'){
						$dbf_hide_class = 'dbf_form_hidden';
					}
					//______backup leeren
					update_option('dbf-'.$id.'-last-fields','');
					break;
				case 'warning-input':
					$dbf_message = $dbf_failure_input;
					$dbf_wrong_fields = explode(';',$_GET['fields']);
					break;
				case 'warning-dbins':
					$dbf_message = $dbf_failure_db_insert;
					break;
				case 'warning-dbcon':
					$dbf_message = $dbf_failure_db_connection;
					break;
				case 'warning-mail':
					$dbf_message = $dbf_failure_mail;
					break;
				case 'alert-mailcon':
					$dbf_message = $dbf_failure_mail_confirmation;	
					break;
				default:
					$dbf_message = '';
					//______backup leeren
					update_option('dbf-'.$id.'-last-fields','');
					break;
			}
			$throwback 	.= 	'<div id="dbf_complete_'.$id.'" >'
						.		'<div class="dbf_notice '.$dbf_message_class.'" >'
						.			'<span class="dbf_icon"></span>'
						.			'<span class="dbf_admin_message dbf_message">'
						.				$dbf_message
						.			'</span>'
						.		'</div>';
		}else{
			//______backup leeren
			update_option('dbf-'.$id.'-last-fields','');
		}
		//____backup
		$dbf_last_fields = get_option('dbf-'.$id.'-last-fields');
		
		//____form bauen
		$throwback	.=	'<div id="dbf_form_wrapper_'.$id.'" class="dbf_form_wrapper dbf_form_wrapper_'.$id.' '.$classes.' '.$dbf_hide_class.'" >'
					.		'<form name="dbf_form_'.$id.'" enctype="multipart/form-data" id="dbf_form_'.$id.'" class="db_form '.$classes.'" method="post" action="'.plugins_url('connector111.php', __FILE__).'" >'
					.			'<input type="hidden" name="dbf_submitted" value="'.$id.'" />'
					.			'<input type="hidden" name="dbf_'.$id.'_post_id" value="'.get_the_ID().'" />'
					.			do_shortcode($content)
					.		'</form>'	
					.	'</div><!--dbf_wrapper-->';		
		//____message klammer
		if(isset($_GET['message'])){ $throwback .= '</div><!--dbf_complete-->'; }
		
		//__throw! 
		return $throwback;
	}
	
}
add_shortcode( 'db_form', 'dbf_enclosure');

//INPUT TEXT
function dbf_field_text($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 	=> 	'',
			'name' 		=> 	'',
			'value'		=>	'',
			'required'	=>	'false'
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"text",
							"name"		=>	$name,
							"required"	=>	$required
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__backup
		if(isset($dbf_last_fields[$name])){$backup = $dbf_last_fields[$name];}else{$backup='';}
		
		//__workwork
		$additional = '';
		if(in_array($name,$dbf_wrong_fields)){$additional .= ' dbf_field_error';}
		$throwback	=	'<div class="dbf_text_wrapper dbf_wrapper">'
					.		'<div class="dbf_text_label dbf_label">'
					.			$label
					.		'</div>'
					.		'<div class="dbf_text_field dbf_field">'
					.			'<input type="text" class="dbf_text_field dbf_class_'.$name.' '.$additional.'" value="'.$backup.'" placeholder="'.$value.'" name="'.$name.'" data-required="'.$required.'" />'
					.		'</div>'
					.		'<div class="dbf-cleaner"></div>'
					.	'</div>';
		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'input', 'dbf_field_text');

//INPUT MAIL
function dbf_field_mail($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 	=> 	'',
			'name' 		=> 	'',
			'value'		=>	'',
			'required'	=>	'false'
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"mail",
									"name"		=>	$name,
									"required"	=>	$required
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__backup
		if(isset($dbf_last_fields[$name])){$backup = $dbf_last_fields[$name];}else{$backup='';}
		
		//__workwork
		$additional = '';
		if(in_array($name,$dbf_wrong_fields)){$additional .= ' dbf_field_error';}
		$throwback	=	'<div class="dbf_mail_wrapper dbf_wrapper">'
					.		'<div class="dbf_mail_label dbf_label">'
					.			$label
					.		'</div>'
					.		'<div class="dbf_mail_field dbf_field">'
					.			'<input type="text" class="dbf_mail_field dbf_class_'.$name.' '.$additional.'" value="'.$backup.'" placeholder="'.$value.'" name="'.$name.'" data-required="'.$required.'" />'
					.		'</div>'
					.		'<div class="dbf-cleaner"></div>'
					.	'</div>';
		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'mail', 'dbf_field_mail');

//INPUT HIDDEN
function dbf_field_hidden($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 	=> 	'',
			'name' 		=> 	'',
			'value'		=>	''
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"hidden",
									"name"		=>	$name
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__workwork
		$throwback	=	'<div class="dbf_hidden_wrapper dbf_wrapper">'
					.		'<div class="dbf_hidden_label dbf_label"></div>'
					.		'<div class="dbf_hidden_field dbf_field">'
					.			'<input type="hidden" class="dbf_hidden_field dbf_class_'.$name.'" value="'.$value.'" name="'.$name.'" />'
					.		'</div>'
					.	'</div>';
		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'hidden', 'dbf_field_hidden');

//TEXTAREA
function dbf_field_textarea($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 	=> 	'',
			'name' 		=> 	'',
			'value'		=>	'',
			'required'	=>	'false'
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"textarea",
									"name"		=>	$name,
									"required"	=>	$required
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__backup
		if(isset($dbf_last_fields[$name])){$backup = $dbf_last_fields[$name];}else{$backup='';}
		
		//__workwork
		$additional = '';
		if(in_array($name,$dbf_wrong_fields)){$additional .= ' dbf_field_error';}
		$throwback	=	'<div class="dbf_textarea_wrapper dbf_wrapper">'
					.		'<div class="dbf_textarea_label dbf_label">'
					.			$label
					.		'</div>'
					.		'<div class="dbf_textarea_field dbf_field">'
					.			'<textarea class="dbf_textarea_field dbf_class_'.$name.' '.$additional.'" name="'.$name.'" placeholder="'.$value.'" data-required="'.$required.'">'
					.				$backup
					.			'</textarea>'
					.		'</div>'
					.		'<div class="dbf-cleaner"></div>'
					.	'</div>';
		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'textarea', 'dbf_field_textarea');

//RADIO
function dbf_field_radio($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_radio, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 		=> 	'',
			'name' 			=> 	'',
			'value'			=>	'',
			'required'		=>	'false',
			'description'	=>	''
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"radio",
									"name"		=>	$name,
									"required"	=>	$required
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__workwork
		$additional = '';
		if(in_array($name,$dbf_wrong_fields)){$additional .= ' dbf_field_error';}
		$radios = Array();
		$labels = explode(';', $label);
		$values = explode(';', $value);
		if(count($labels) == count($values)){
			$i = 0;
			foreach ($labels as $label_single){
				$radios[] = array(	'label'	=>	$label_single,
									'value'	=>	$values[$i]
								);
				$i++;
			}
			
			$throwback	=	'<div class="dbf_radio_wrapper dbf_wrapper '.$additional.'">'
						.		'<div class="dbf_radio_before dbf_label">'
						.			'<div class="dbf_radio_description">'.$description.'</div>'
						.		'</div>'
						.		'<div class="dbf_radio_main dbf_field">';
			
			foreach ($radios as $radio){
			//____backup
			$backup = '';
			if(isset($dbf_last_fields[$name])){if($dbf_last_fields[$name] == $radio['value']){$backup='checked="checked"';}else{$backup='';}}else{$backup='';}
			
			$throwback	.=			'<div class="dbf_radio_radio dbf_class_'.$name.'">'
						.				'<input type="radio" name="'.$name.'" '.$backup.' value="'.$radio['value'].'" data-required="'.$required.'" >'
						.				'<span class="dbf_radio_label">'.$radio['label'].'</span>'						
						.			'</div>';
			}
									
			$throwback	.=		'</div>'
						.		'<div class="dbf-cleaner"></div>'
						.	'</div>';
		}else{
			$throwback 	= 	$dbf_warning_radio;
		}		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'radio', 'dbf_field_radio');

//SELECT
function dbf_field_select($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_radio, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 		=> 	'',
			'name' 			=> 	'',
			'value'			=>	'',
			'required'		=>	'false',
			'description'	=>	''
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"select",
									"name"		=>	$name,
									"required"	=>	$required
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__workwork
		$additional = '';
		if(in_array($name,$dbf_wrong_fields)){$additional .= ' dbf_field_error';}
		$options = Array();
		$labels = explode(';', $label);
		$values = explode(';', $value);
		if(count($labels) == count($values)){
			$i = 0;
			foreach ($labels as $label_single){
				$options[] = array(	'label'	=>	$label_single,
									'value'	=>	$values[$i]
								);
				$i++;
			}
			
			$throwback	=	'<div class="dbf_select_wrapper dbf_wrapper '.$additional.'">'
						.		'<div class="dbf_select_before dbf_label">'
						.			'<div class="dbf_select_description">'.$description.'</div>'
						.		'</div>'
						.		'<div class="dbf_select_main dbf_field">'
						.			'<select name="'.$name.'" data-required="'.$required.'" >';
			
			foreach ($options as $option){
			//____backup
			$backup = '';
			if(isset($dbf_last_fields[$name])){if($dbf_last_fields[$name] == $option['value']){$backup='selected="selected"';}else{$backup='';}}else{$backup='';}
			$throwback	.=				'<option value="'.$option['value'].'" '.$backup.' >'.$option['label'].'</option>';
			}
									
			$throwback	.=			'</select>'
						.		'</div>'
						.		'<div class="dbf-cleaner"></div>'
						.	'</div>';
		}else{
			$throwback 	= 	$dbf_warning_radio;
		}		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'select', 'dbf_field_select');

//CHECKBOX
function dbf_field_checkbox($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option, $dbf_wrong_fields, $dbf_last_fields;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 	=> 	'',
			'name' 		=> 	'',
			'value'		=>	'',
			'required'	=>	'false'
		), $atts ) );
		
		//__secure
		$dbf_sec_value = get_option($dbf_sec_option);
		$dbf_sec_value[] = array(	"type"		=>	"checkbox",
									"name"		=>	$name,
									"required"	=>	$required
						);
		update_option($dbf_sec_option, $dbf_sec_value);
		
		//__backup
		$backup = '';
		if(isset($dbf_last_fields[$name])){if($dbf_last_fields[$name] == $value){$backup = 'checked="checked"';}else{$backup='';}}else{$backup='';}
		
		//__workwork
		$additional = '';
		if(in_array($name,$dbf_wrong_fields)){$additional .= ' dbf_field_error';}
		if($label == ''){ $label = $content; }
		$throwback	=	'<div class="dbf_checkbox_wrapper dbf_wrapper '.$additional.'">'
					.		'<div class="dbf_checkbox_box">'
					.			'<input type="checkbox" '.$backup.' class="dbf_checkbox_box dbf_class_'.$name.'" value="'.$value.'" name="'.$name.'" data-required="'.$required.'" />'
					.		'</div>'
					.		'<div class="dbf_checkbox_label">'
					.			$label
					.		'</div>'
					.		'<div class="dbf-cleaner"></div>'
					.	'</div>';
		
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'checkbox', 'dbf_field_checkbox');

//SUBMIT
function dbf_field_submit($atts, $content=null){
	global $dbf_foundouter, $dbf_outerid, $dbf_warning_enclosure, $dbf_sec_option;
	
	if($dbf_foundouter){
		//__values
		extract( shortcode_atts( array(
			'label' 	=> 	'',
			'name' 		=> 	'',
			'value'		=>	'',
			'required'	=>	'false'
		), $atts ) );
		
		//__workwork
		$throwback 	=	'<div class="dbf_submit_wrapper dbf_wrapper">'
					.		'<div class="dbf_submit_label"></div>'
					.		'<div class="dbf_submit_button">'
					.			'<input type="submit" class="dbf_submit_button" value="'.$label.'" />'
					.		'</div>'
					.	'</div>';
					
	}else{
		$throwback = $dbf_warning_enclosure;
	}
	
	//__throw!
	return $throwback;
	
}
add_shortcode( 'submit', 'dbf_field_submit');


?>
