<?php
/*
Template Name: Edit Machine
*/
?>

<?php get_header(); ?>

<link rel="stylesheet" href="<?=get_template_directory_uri();?>/css/theme.grey.css">
<script type="text/javascript" src="<?=get_template_directory_uri();?>/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#sortableTable").tablesorter();
	$(".clickableRow").click(function() {
		window.document.location = $(this).attr("href");
      });
});
</script>

<?php
$id = mysql_real_escape_string($_GET[id]);
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $machines = $dbf_db->get_results("SELECT * FROM machines WHERE machines_id=$id;");
}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">


			<article class="post-406 page type-page status-publish hentry" id="post-406">
				<header class="entry-header"><h1 class="entry-title">Edit Machine</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_machines  " id="dbf_form_wrapper_machines">
						<form action="<?=plugins_url();?>/db-form/php/updater111.php" method="post" class="db_form " id="dbf_form_machines" enctype="multipart/form-data" name="dbf_form_machines">
							<input type="hidden" value="machines" name="dbf_submitted">
							<input type="hidden" value="225" name="dbf_machines_post_id"><br>
							<input type="hidden" value="<?=$machines[0]->machines_id;?>:<?=$machines[0]->machines_pid;?>" name="dbf_edit_id"><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Service Tag *</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="machines_identifier" value="<?=$machines[0]->machines_identifier;?>" class="dbf_text_field dbf_class_machines_identifier ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Other Hardware Info</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="machines_other_hw_info" value="<?=$machines[0]->machines_other_hw_info;?>" class="dbf_text_field dbf_class_machines_other_hw_info ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">OS Version</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="machines_os_version">
										<option value="<?=$machines[0]->machines_os_version;?>"><?=$machines[0]->machines_os_version;?></option>
										<option value="Windows XP SP2">Windows XP SP2</option>
										<option value="Windows XP SP3">Windows XP SP3</option>
										<option value="Windows 7 SP1">Windows 7 SP1</option>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

                                                        <div class="dbf_mail_wrapper dbf_wrapper">
                                                                <div class="dbf_mail_label dbf_label">OS License Key</div>
                                                                <div class="dbf_mail_field dbf_field">
                                                                        <input type="text" data-required="true" name="machines_os_license" value="<?=$machines[0]->machines_os_license;?>" class="dbf_mail_field dbf_class_machines_os_license ">
                                                                </div>
                                                                <div class="dbf-cleaner"></div>
                                                        </div><br>

							<div class="dbf_mail_wrapper dbf_wrapper">
								<div class="dbf_mail_label dbf_label">Login Username</div>
								<div class="dbf_mail_field dbf_field">
									<input type="text" data-required="true" name="machines_username" value="<?=$machines[0]->machines_username;?>" class="dbf_mail_field dbf_class_machines_username ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Password</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="machines_password" value="<?=$machines[0]->machines_password;?>" class="dbf_text_field dbf_class_machines_password ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Generated Fingerprint</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" disabled="disabled" name="machines_fingerprint" value="<?=(($machines[0]->machines_fingerprint != NULL) ? "attached" : "none");?>"class="dbf_text_field dbf_class_machines_fingerprint ">
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Status</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="machines_status">
										<option value="<?=$machines[0]->machines_status;?>"><?=$machines[0]->machines_status;?></option>
										<option value="Configured">Configured</option>
										<option value="Allocated">Allocated</option>
										<option value="Fault Reported">Fault Reported</option>
										<option value="Being Repaired">Being Repaired</option>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_submit_wrapper dbf_wrapper">
								<div class="dbf_submit_label"></div>
								<div class="dbf_submit_button">
									<input type="submit" name="dbf_delete" value="Delete!" class="dbf_submit_button hideDelete">
									<input type="submit" value="Update!" class="dbf_submit_button hideEdit">
								</div>
							</div><br>
						</form>
					</div><!--dbf_wrapper-->
				</div><!-- .entry-content -->

<br><br><br>
                                <header class="entry-header"><h1 class="entry-title">Machine History</h1></header>

<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM machines WHERE machines_pid=".$machines[0]->machines_pid);
        echo "<table id='sortableTable' class='tablesorter-grey'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Service Tag</th>";
        echo "<th>OS Version</th>";
        echo "<th>Status</th>";
        echo "<th>Last Modified</th>";
        echo "<th>Modified By</th>";
        echo "</tr>";
        echo "<tbody>";
        foreach($result as $object){
                echo "<tr class='clickableRow' href='".get_permalink(406)."?id=".$object->machines_id."'>";
                echo "<td>".$object->machines_identifier."</td>";
                echo "<td>".$object->machines_os_version."</td>";
                echo "<td>".$object->machines_status."</td>";
                echo "<td>".$object->machines_last_modified."</td>";
                echo "<td>".$object->machines_modified_by."</td>";
                echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
}

?>




			</article>
                </div><!-- #content -->
        </div><!-- #primary -->

        <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer(); 
?>
