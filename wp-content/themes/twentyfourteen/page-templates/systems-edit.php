<?php
/*
Template Name: Edit System
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
$csid = mysql_real_escape_string($_GET[csid]);
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM `systems`
                                                LEFT JOIN customers ON systems.customer_id=customers.customer_id
                                                LEFT JOIN machines ON systems.machine_id=machines.machine_id
                                                LEFT JOIN manakins ON systems.manakin_id=manakins.manakin_id
						WHERE system_id=$csid;");
        $customers = $dbf_db->get_results("SELECT customers.* FROM customers WHERE customers.customer_id NOT IN (SELECT systems.customer_id FROM systems);");
        $machines = $dbf_db->get_results("SELECT machines.* FROM machines WHERE machines.machine_id NOT IN (SELECT systems.machine_id FROM systems);");
        $manakins = $dbf_db->get_results("SELECT manakins.* FROM manakins WHERE manakins.manakin_id NOT IN (SELECT systems.manakin_id FROM systems);");
}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">


			<article class="post-434 page type-page status-publish hentry" id="post-434">
				<header class="entry-header"><h1 class="entry-title">Edit System</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_systems  " id="dbf_form_wrapper_systems">
						<form action="<?=plugins_url();?>/db-form/php/updater111.php" method="post" class="db_form " id="dbf_form_systems" enctype="multipart/form-data" name="dbf_form_systems">
							<input type="hidden" value="systems" name="dbf_submitted">
							<input type="hidden" value="235" name="dbf_systems_post_id"><br>
							<input type="hidden" value="<?=$csid;?>" name="dbf_edit_id"><br>

                                                        <div class="dbf_text_wrapper dbf_wrapper">
                                                                <div class="dbf_text_label dbf_label">Heartworks ID</div>
                                                                <div class="dbf_text_field dbf_field">
                                                                        <input type="text" data-required="true" name="heartworks_ident" value="<?=$result[0]->heartworks_ident;?>" class="dbf_text_field dbf_class_build_number ">
                                                                </div>
                                                                <div class="dbf-cleaner"></div>
                                                        </div><br>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Customer ID</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="customer_id">
										<option value="<?=$result[0]->customer_id;?>"><?=$result[0]->license_name;?></option>
<?php
foreach($customers as $customer){
?>
										<option value="<?=$customer->customer_id;?>"><?=$customer->license_name;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Allocated Machine ID</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="machine_id">
										<option value="<?=$result[0]->machine_id;?>"><?=$result[0]->service_tag;?></option>
<?php
foreach($machines as $machine){
?>
                                                                                <option value="<?=$machine->machine_id;?>"><?=$machine->service_tag;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Allocated Manakin ID</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="manakin_id">
										<option value="<?=$result[0]->manakin_id;?>"><?=$result[0]->manakin_ident;?></option>
<?php
foreach($manakins as $manakin){
?>
                                                                                <option value="<?=$manakin->manakin_id;?>"><?=$manakin->manakin_ident;?></option>
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
									<select data-required="true" name="software_version">
										<option value="<?=$result[0]->software_version;?>"><?=$result[0]->software_version;?></option>
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
									<input type="text" data-required="true" name="build_number" placeholder="" value="<?=$result[0]->build_number;?>" class="dbf_text_field dbf_class_build_number ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Software Features</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="software_features" placeholder="" value="<?=$result[0]->software_features;?>" class="dbf_text_field dbf_class_software_features ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Requested Pathology Packs</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="req_pathology_packs" placeholder="" value="<?=$result[0]->req_pathology_packs;?>" class="dbf_text_field dbf_class_req_pathology_packs ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

                                                        <div class="dbf_submit_wrapper dbf_wrapper">
                                                                <div class="dbf_submit_label"></div>
                                                                <div class="dbf_submit_button">
                                                                        <input type="submit" name="dbf_delete" value="Delete!" class="dbf_submit_button">
                                                                        <input type="submit" value="Update!" class="dbf_submit_button">
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
