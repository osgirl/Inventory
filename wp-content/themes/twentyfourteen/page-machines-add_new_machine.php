<?php
/*
Template Name: Add New Machine
*/
?>

<?php
define("THISPAGE", "add-new-machine");
?>

<?php get_header(); ?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">

			<article id="post-313" class="post-313 page type-page status-publish hentry">
				<header class="entry-header"><h1 class="entry-title">Add New Machine</h1></header>
				<div class="entry-content">
<p><span class="code"></span></p>
					<div id="dbf_form_wrapper_00" class="dbf_form_wrapper dbf_form_wrapper_00  ">
						<form name="dbf_form_00" id="dbf_form_00" class="db_form " method="post" action="http://inventory/wp-content/themes/twentyfourteen/inc/connector.php">
							<input name="dbf_submitted" value="00" type="hidden">
							<input name="dbf_00_post_id" value="313" type="hidden"><br>
							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Service Tag *</div>
								<div class="dbf_text_field dbf_field">
									<input class="dbf_text_field dbf_class_service_tag " value="" placeholder="" name="service_tag" data-required="true" type="text">
								</div>
								<div class="dbf-cleaner"></div>
							</div>
							<br>
							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Other Hardware Info</div>
								<div class="dbf_text_field dbf_field">
									<input class="dbf_text_field dbf_class_other_hw_info " value="" placeholder="" name="other_hw_info" data-required="false" type="text">
								</div>
								<div class="dbf-cleaner"></div>
							</div>
							<br>
							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">OS Version</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select name="os_version" data-required="true">
										<option value="a">Windows XP SP2</option>
										<option value="b">Windows XP SP3</option>
										<option value="c">Windows 7 SP1</option>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>
							<br>
							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Login Username</div>
								<div class="dbf_text_field dbf_field">
									<input class="dbf_text_field dbf_class_username " value="" placeholder="" name="username" data-required="false" type="text">
								</div>
								<div class="dbf-cleaner"></div>
							</div>
							<br>
							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Login Password</div>
								<div class="dbf_text_field dbf_field">
									<input class="dbf_text_field dbf_class_password " value="" placeholder="" name="password" data-required="false" type="text">
								</div>
								<div class="dbf-cleaner">
							</div>
							<br>
							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Generated Fingerprint</div>
								<div class="dbf_text_field dbf_field">
									<input class="dbf_text_field dbf_class_fingerprint " name="fingerprint" type="file">
								</div>
								<div class="dbf-cleaner"></div>
							</div>
							<br>
							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Status</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select name="status" data-required="true">
										<option value="Configured">Configured</option>
										<option value="Allocated">Allocated</option>
										<option value="Fault Reported">Fault Reported</option>
										<option value="Being Repaired">Being Repaired</option>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>
							<br>
							<div class="dbf_submit_wrapper dbf_wrapper">
								<div class="dbf_submit_label"></div>
								<div class="dbf_submit_button">
									<input class="dbf_submit_button" value="Send!" type="submit">
								</div>
							</div>
							<br>
						</form>
					</div>
				</div>
			</article>


                </div><!-- #content -->
        </div><!-- #primary -->
        <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer(); 
?>
