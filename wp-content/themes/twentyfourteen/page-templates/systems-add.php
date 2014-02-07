<?php
/*
Template Name: Add System
*/
?>

<?php get_header(); ?>

<script type="text/javascript">
jQuery(document).ready(function($) {
      $(".clickableRow").click(function() {
            window.document.location = $(this).attr("href");
      });
});
</script>

<?php

$features['default'] = array ( 'MMode', 'Doppler' );
$software_versions['default'] = array ( 'TOE', 'TEE', 'Dual', 'Legacy' );


$id = mysql_real_escape_string($_GET[id]);
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
//	$customers = $dbf_db->get_results("SELECT * FROM (SELECT * FROM (SELECT * FROM customers as x1 order by customers_id desc) as x2 group by customers_pid order by customers_identifier) as x3 WHERE x3.customers_pid NOT IN (SELECT systems.customers_pid FROM systems);");
	$customers = $dbf_db->get_results("SELECT * FROM (SELECT * FROM customers as x1 order by customers_id desc) as x2 group by customers_pid order by customers_identifier;");
	$machines = $dbf_db->get_results("SELECT * FROM (SELECT * FROM (SELECT * FROM machines as x1 order by machines_id desc) as x2 group by machines_pid order by machines_identifier) as x3 WHERE x3.machines_pid NOT IN (SELECT systems.machines_pid FROM systems);");
	$manakins = $dbf_db->get_results("SELECT * FROM (SELECT * FROM (SELECT * FROM manakins as x1 order by manakins_id desc) as x2 group by manakins_pid order by manakins_identifier) as x3 WHERE x3.manakins_pid NOT IN (SELECT systems.manakins_pid FROM systems);");
	$pathologies = $dbf_db->get_results("SELECT * FROM (SELECT * FROM pathologies as x1 ORDER BY pathologies_id desc) as x2 group by pathologies_pid order by pathologies_identifier;");
}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">
<?php
if ( !current_user_can('add_iml') ) {
	echo "<p class=\"restricted\">Sorry, but you do not have permission to view this content.</p>\n";
?>
                </div><!-- #content -->
        </div><!-- #primary -->

        <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
exit;
}
?>
			<article class="post-357 page type-page status-publish hentry" id="post-357">
				<header class="entry-header"><h1 class="entry-title">Add System</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_systems  " id="dbf_form_wrapper_systems">
						<form action="<?=plugins_url();?>/db-form/php/connector111.php" method="post" class="db_form " id="dbf_form_systems" enctype="multipart/form-data" name="dbf_form_systems">
							<input type="hidden" value="systems" name="dbf_submitted">
							<input type="hidden" value="357" name="dbf_systems_post_id"><br>

                                                        <div class="dbf_text_wrapper dbf_wrapper">
                                                                <div class="dbf_text_label dbf_label">Heartworks ID</div>
                                                                <div class="dbf_text_field dbf_field">
                                                                        <input type="text" data-required="true" placeholder="i.e. HW00001" name="systems_identifier" value="" class="dbf_text_field dbf_class_systems_identifier ">
                                                                </div>
                                                                <div class="dbf-cleaner"></div>
                                                        </div><br>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Customer</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="customers_pid">
										<option value="">- Select -</option>
<?php
foreach($customers as $customer){
?>
										<option value="<?=$customer->customers_pid;?>"><?=$customer->customers_identifier;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Allocated Machine</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="machines_pid">
										<option value="">- Select -</option>
<?php
foreach($machines as $machine){
?>
                                                                                <option value="<?=$machine->machines_pid;?>"><?=$machine->machines_identifier;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Allocated Manakin</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="manakins_pid">
										<option value="">- Select -</option>
<?php
foreach($manakins as $manakin){
?>
                                                                                <option value="<?=$manakin->manakins_pid;?>"><?=$manakin->manakins_identifier;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Heartworks Software</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="systems_software_version">
										<option value="">- Select -</option>
										<option value="TOE">TOE</option>
										<option value="TEE">TEE</option>
										<option value="Dual">Dual</option>
										<option value="Legacy">Legacy</option>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>


							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Software Build Number</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="systems_build_number" value="" class="dbf_text_field dbf_class_build_number ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>


							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Software Features</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" multiple="multiple" name="arr[systems_software_features][]">
										<option value="MMode">MMode</option>
										<option value="Doppler">Doppler</option>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Requested Pathology Packs</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" multiple="multiple" name="arr[requested_pathology_packs][]">
<?php
foreach($pathologies as $pathology) {
?>
										<option value="<?=$pathology->pathologies_identifier;?>"><?=$pathology->pathologies_identifier;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_submit_wrapper dbf_wrapper">
								<div class="dbf_submit_label"></div>
								<div class="dbf_submit_button">
									<input type="submit" value="Add!" class="dbf_submit_button">
								</div>
							</div><br>

						</form>
					</div><!--dbf_wrapper--><p></p>
				</div><!-- .entry-content -->
			</article>
                </div><!-- #content -->
        </div><!-- #primary -->

        <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer(); 
?>
