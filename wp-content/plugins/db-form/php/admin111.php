<?php

//BACKEND BAUEN
//__menüs anlegen
add_action('admin_menu','register_dbf_backend');
function register_dbf_backend() {
	add_menu_page('DB Form', 'DB Form', 'add_users', 'dbf_settings', 'dbf_layout', '', 100);
	add_submenu_page('dbf_settings', 'Error Messages', 'Error Messages', 'add_users', 'dbf-error-messages', 'dbf_messages_layout');
	add_action('admin_init','dbf_settings');
	add_action('admin_init','dbf_messages');
}

//__push update message
function dbf_1_0_notice() {
	if($_GET['dbf_got_notice'] == 'true'){
		update_option('dbf-got-notice','true');
	}else if(get_option('dbf-got-notice') != 'true'){
		?>
		<div class="error">
		    <p><strong>DB FORM:</strong><br />
		    Important Update!<br />
		    Rewritten HTML output, rewritten configuration pages.<br />
		    This requires you to update your settings and eventually complete change/rewrite your CSS files<br />
		    which you use to style the plugIn.<br />
		    <a href="admin.php?page=dbf_settings&dbf_got_notice=true">Update settings &amp; hide this message.</a>
		    </p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'dbf_1_0_notice' );

//__settings speichern
function dbf_settings() {
	register_setting('dbf-settings-group', 'dbf-0-main-function');
	register_setting('dbf-settings-group', 'dbf-0-admin-mail');
	
	register_setting('dbf-settings-group', 'dbf-0-db-host');
	register_setting('dbf-settings-group', 'dbf-0-db-user');
	register_setting('dbf-settings-group', 'dbf-0-db-password');
	register_setting('dbf-settings-group', 'dbf-0-db-name');
	register_setting('dbf-settings-group', 'dbf-0-db-table');
	
	register_setting('dbf-settings-group', 'dbf-0-mail-subject');
	register_setting('dbf-settings-group', 'dbf-0-mail-content');
	
	register_setting('dbf-settings-group', 'dbf-0-confirmation');
	register_setting('dbf-settings-group', 'dbf-0-confirmation-function');
	register_setting('dbf-settings-group', 'dbf-0-confirmation-recipient');
	register_setting('dbf-settings-group', 'dbf-0-confirmation-subject');
	register_setting('dbf-settings-group', 'dbf-0-confirmation-content');
	
	register_setting('dbf-settings-group', 'dbf-0-hide');
	register_setting('dbf-settings-group', 'dbf-0-redirect');
	register_setting('dbf-settings-group', 'dbf-0-redirect-url');
	register_setting('dbf-settings-group', 'dbf-0-redirect-message');
	
	register_setting('dbf-settings-group', 'dbf-0-stylesheet');
}
//__messages speichern
function dbf_messages(){
	register_setting('dbf-messages-group', 'dbf-0-failure-input');
	register_setting('dbf-messages-group', 'dbf-0-failure-db-connection');
	register_setting('dbf-messages-group', 'dbf-0-failure-db-insert');
	register_setting('dbf-messages-group', 'dbf-0-failure-mail');
	register_setting('dbf-messages-group', 'dbf-0-failure-mail-confirmation');
}

//backend messages layouten
function dbf_messages_layout(){
	//ALERT
	if($_GET['settings-updated'] == 'true'){
		echo 	'<div class="dbf_admin_alert dbf_notice_alert dbf_notice">'
			.		'<span class="dbf_icon"></span>'
			.		'<span class="dbf_admin_message dbf_message">'
			.			'Settings successfully updated.'
			.		'</span>'
			.		'<span class="dbf_alert_dismiss">'
			.			'<a onclick="jQuery(this).parent().parent().fadeOut()" >Dismiss message</a>'
			.		'</span>'
			.	'</div>';	
	}
	?>
	<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>DB Form Error Messages</h2>
	
	<form name="form-00" method="post" action="options.php">
	
	<?php
	settings_fields('dbf-messages-group');
	?>
	
	<!--CONFIRMATION-->
	<h3>Error Message Settings</h3>
	<p>In this part of the plugin you are able to setup different error messages
	<br />for each type of error that may be visible to your users.
	</p>
	<table class="form-table">
		<?php
		$throwback	=	'<tr valign="top">'
					.		'<th scope="row">Wrong Input'
					.			'<p class="description"><br />The most common error message. Will be displayed whenever a user gives wrong or no input in required fields.</p>'
					.		'</th>'
					.		'<td>'
					.			'<textarea name="dbf-0-failure-input" style="width:450px; height:100px; resize:none;" >'
					.			get_option('dbf-0-failure-input')
					.			'</textarea>'
					.		'</td>'
					.	'</tr>';
		$throwback	.=	'<tr valign="top">'
					.		'<th scope="row">Database Connection'
					.			'<p class="description"><br />Message will pop up if there\'s a problem connecting to your database.</p>'
					.		'</th>'
					.		'<td>'
					.			'<textarea name="dbf-0-failure-db-connection" style="width:450px; height:100px; resize:none;" >'
					.			get_option('dbf-0-failure-db-connection')
					.			'</textarea>'
					.		'</td>'
					.	'</tr>';
		$throwback	.=	'<tr valign="top">'
					.		'<th scope="row">Database Write'
					.			'<p class="description"><br />This text will be displayed if there is a problem writing the user\'s input to the database.</p>'
					.		'</th>'
					.		'<td>'
					.			'<textarea name="dbf-0-failure-db-insert" style="width:450px; height:100px; resize:none;" >'
					.			get_option('dbf-0-failure-db-insert')
					.			'</textarea>'
					.		'</td>'
					.	'</tr>';
		$throwback	.=	'<tr valign="top">'
					.		'<th scope="row">Mail Delivery'
					.			'<p class="description"><br />In case the e-mail function fails this message will be visible.</p>'
					.		'</th>'
					.		'<td>'
					.			'<textarea name="dbf-0-failure-mail" style="width:450px; height:100px; resize:none;" >'
					.			get_option('dbf-0-failure-mail')
					.			'</textarea>'
					.		'</td>'
					.	'</tr>';
		$throwback	.=	'<tr valign="top">'
					.		'<th scope="row">Confirmation Mail Delivery'
					.			'<p class="description"><br />This will be a visible notice if the plugin is not able to send out your confirmation mail.</p>'
					.		'</th>'
					.		'<td>'
					.			'<textarea name="dbf-0-failure-mail-confirmation" style="width:450px; height:100px; resize:none;" >'
					.			get_option('dbf-0-failure-mail-confirmation')
					.			'</textarea>'
					.		'</td>'
					.	'</tr>';						
		echo $throwback;
		?>
	</table>
	
	<!--SUBMIT-->
	<?php submit_button(null,'primary','btn_submit'); ?>
	</form>
	</div>
	<?php
}

//backend settings layouten
function dbf_layout() {
	//ALERT
	if($_GET['settings-updated'] == 'true'){
		echo 	'<div class="dbf_admin_alert dbf_notice_alert dbf_notice">'
			.		'<span class="dbf_icon"></span>'
			.		'<span class="dbf_admin_message dbf_message">'
			.			'Settings successfully updated.'
			.		'</span>'
			.		'<span class="dbf_alert_dismiss">'
			.			'<a onclick="jQuery(this).parent().parent().fadeOut()" >Dismiss message</a>'
			.		'</span>'
			.	'</div>';	
	}
	?>
	<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2>DB Form Settings</h2>
	
	<form name="form-00" method="post" action="options.php">
	
	<?php
	settings_fields('dbf-settings-group');
	?>
	
	<!--GENERAL-->
	<h3>General Setup</h3>
	<p>Down below you setup the basic function of this form.
	<br />All of the fields shown below are mandatory.
	</p>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Function</th>
			<td>
				<select name="dbf-0-main-function">
					<option value="data" <?php selected( get_option('dbf-0-main-function'), 'data'); ?> >write to database</option>
					<option value="mail"<?php selected( get_option('dbf-0-main-function'), 'mail'); ?> >send e-mail</option>
				</select>
			</td>
		</tr>
		
		<?php 
		if(get_option('dbf-0-main-function') == 'mail'){
			$throwback 	= 	'<th scope="row">DB Form E-Mail</th>'
						.	'<td>'
						.		'<input type="text" name="dbf-0-admin-mail" value="'.get_option('dbf-0-admin-mail').'" />'
						.	'</td>';
		}
		else if(get_option('dbf-0-main-function') == 'data'){
			$throwback	=	'<tr valign="top">'
						.		'<th scope="row">DB Form E-Mail</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-admin-mail" value="'.get_option('dbf-0-admin-mail').'" />'
						.		'</td>'
						.	'</tr>'
						
						.	'<tr valign="top">'
						.		'<th scope="row">DB Host</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-db-host" value="'.get_option('dbf-0-db-host').'" />'
						.		'</td>'	
						.	'</tr>'
						.	'<tr valign="top">'
						.		'<th scope="row">DB User</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-db-user" value="'.get_option('dbf-0-db-user').'" />'
						.		'</td>'
						.	'</tr>'	
						.	'<tr valign="top">'
						.		'<th scope="row">DB Password</th>'
						.		'<td>'
						.			'<input type="password" name="dbf-0-db-password" value="'.get_option('dbf-0-db-password').'" />'
						.		'</td>'
						.	'</tr>'	
						.	'<tr valign="top">'
						.		'<th scope="row">DB Name</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-db-name" value="'.get_option('dbf-0-db-name').'" />'
						.		'</td>'
						.	'</tr>'
						.	'<tr valign="top">'
						.		'<th scope="row">DB Table</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-db-table" value="'.get_option('dbf-0-db-table').'" />'
						.		'</td>'
						.	'</tr>';	
		}else{
			$throwback = '';
		}
		echo $throwback;
		?>
	</table>
		
	<!--MAIL-->
	<?php
	if(get_option('dbf-0-main-function') == 'mail'){
		$throwback	=	'<h3>Mail Configuration</h3>'
					.	'<p>Setup your mail content in this section</p>'
					.	'<table class="form-table">'
					.		'<tr valign="top">'
					.			'<th scope="row">E-Mail Subject</th>'
					.			'<td>'
					.				'<input type="text" name="dbf-0-mail-subject" value="'.get_option('dbf-0-mail-subject').'" />'
					.			'</td>'
					.		'</tr>'
					.		'<tr valign="top">'
					.			'<th scope="row">E-Mail Content</th>'
					.			'<td>'
					.				'<textarea name="dbf-0-mail-content" style="width:450px; height:250px; resize:none;" >'
					.				get_option('dbf-0-mail-content')
					.				'</textarea>'
					.				'<p class="description">You can use your "name-attributes" as variables in this section. <br /> Use %name-attribute%</p>'
					.			'</td>'
					.		'</tr>'
					.	'</table>';
	}else{
		$throwback = '';
	}
	echo $throwback;
	?>
		
	<!--CONFIRMATION-->
	<h3>Confirmation Mail Configuration</h3>
	<p>Use this function to get a confirmation mail each time someone uses this form.
	<br />Especially useful for database submissions
	</p>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Send E-Mail Confirmation</th>
			<td>
				<input type="checkbox" name="dbf-0-confirmation" value="true" <?php checked( get_option('dbf-0-confirmation'), 'true'); ?> />
			</td>
		</tr>
		<?php
		if(get_option('dbf-0-confirmation') == 'true'){
			$throwback	=	'<tr valign="top">'
						.		'<th scope="row">E-Mail Confirmation Recipient</th>'
						.		'<td>'
						.			'<select name="dbf-0-confirmation-function">'
						.				'<option value="admin" '.selected( get_option('dbf-0-confirmation-function'), 'admin').' >DB Form E-Mail (configured above)</option>'
						.				'<option value="custom" '.selected( get_option('dbf-0-confirmation-function'), 'custom').' >Custom E-Mail</option>'
						.			'</select>'
						.		'</td>'
						.	'</tr>';
						if(get_option('dbf-0-confirmation-function') == 'custom'){
			$throwback 	.=	'<tr valign="top">'
						.		'<th scope="row"></th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-confirmation-recipient" value="'.get_option('dbf-0-confirmation-recipient').'" />'
						.			'<p class="description">You can use the name-attribute of your mail field here. <br /> Example: %form-mail%</p>'
						.		'</td>'
						.	'</tr>';
						}
			$throwback	.=	'<tr valign="top">'
						.		'<th scope="row">E-Mail Confirmation Subject</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-confirmation-subject" value="'.get_option('dbf-0-confirmation-subject').'" />'
						.		'</td>'
						.	'</tr>'
						.	'<tr valign="top">'
						.		'<th scope="row">E-Mail Confirmation Text</th>'
						.		'<td>'
						.			'<textarea name="dbf-0-confirmation-content" style="width:450px; height:250px; resize:none;" >'
						.			get_option('dbf-0-confirmation-content')
						.			'</textarea>'
						.			'<p class="description">You can use your "name-attributes" as variables in this section. <br /> Use %name-attribute%</p>'
						.		'</td>'
						.	'</tr>';	
		}else{
			$throwback = '';
		}
		echo $throwback;
		?>
	</table>
	
	<!--REDIRECTION-->
	<h3>Action after submission</h3>
	<p>You don't want the form to just show up a message?
	<br />Enter an URL to your own confirmation page
	</p>
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Hide form after submission</th>
			<td>
				<input type="checkbox" name="dbf-0-hide" value="true" <?php checked( get_option('dbf-0-hide'), 'true'); ?> />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Redirect to</th>
			<td>
				<select name="dbf-0-redirect">
					<option value="message" <?php selected( get_option('dbf-0-redirect'), 'message'); ?> >the same page and display a message</option>
					<option value="none" <?php selected( get_option('dbf-0-redirect'), 'none'); ?> >the same page and DONT display a message</option>
					<option value="custom" <?php selected( get_option('dbf-0-redirect'), 'custom'); ?> >a custom page</option>
				</select>
			</td>
		</tr>
		<?php
		if(get_option('dbf-0-redirect') == 'custom'){
			$throwback	=	'<tr valign="top">'
						.		'<th scope="row">Redirect to URL</th>'
						.		'<td>'
						.			'<input type="text" name="dbf-0-redirect-url" value="'.get_option('dbf-0-redirect-url').'" />'
						.		'</td>'
						.	'</tr>';
		}
		elseif(get_option('dbf-0-redirect') == 'message'){
			$throwback	=	'<tr valign="top">'
						.		'<th scope="row">Display message</th>'
						.		'<td>'
						.			'<textarea name="dbf-0-redirect-message" style="width:450px; height:250px; resize:none;" >'
						.			get_option('dbf-0-redirect-message')
						.			'</textarea>'
						.		'</td>'
						.	'</tr>';
		}else{
			$throwback = '';
		}
		echo $throwback;
		?>
	</table>
	
	<!--STYLING-->
	<h3>Styling</h3>
	<?php
	//__assets check
	$dbf_assets = '../wp-content/plugins/db-form-assets';
	if(!is_dir($dbf_assets)){
		echo 	'<div class="dbf_admin_alert dbf_alert dbf_notice_alert dbf_notice">'
			.		'<span class="dbf_icon"></span>'
			.		'<span class="dbf_admin_message">'
			.			'Folder "db-form-assets" does not exist. Please create it inside the wordpress plugin directory.'
			.		'</span>'
			.	'</div>';	
	}	
	?>
	<p>Select which stylesheet should be used.
	<!--<br />You can upload stylesheets to the "db-form-assets" folder within your plugin directory.-->
	</p>	
	<table class="form-table">
		<tr valign="top">
			<th scope="row">Stylesheet</th>
			<td>
				<select name="dbf-0-stylesheet">
					<option value="db-form/css/basics111.css" <?php selected(get_option('dbf-0-stylesheet'),'dbf/css/basics.css'); ?> >basics.css</option>
					<option value="none" <?php selected(get_option('dbf-0-stylesheet'),'none'); ?> >none</option>
				</select>
			</td>
		</tr>
	</table>
	
	<!--SUBMIT-->
	<?php submit_button(null,'primary','btn_submit'); ?>
	</form>
	</div>
	<?php
}

?>