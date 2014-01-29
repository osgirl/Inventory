<?php
/*
Template Name: Edit Pathology
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
        $pathologies = $dbf_db->get_results("SELECT * FROM pathologies WHERE pathologies_id=$id;");
}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">


			<article class="post-309 page type-page status-publish hentry" id="post-309">
				<header class="entry-header"><h1 class="entry-title">Edit Pathology Pack</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_customers  " id="dbf_form_wrapper_pathologies">
						<form action="<?=plugins_url();?>/db-form/php/updater111.php" method="post" class="db_form " id="dbf_form_pathologies" enctype="multipart/form-data" name="dbf_form_pathologies">
							<input type="hidden" value="pathologies" name="dbf_submitted">
							<input type="hidden" value="231" name="dbf_pathologies_post_id"><br>
							<input type="hidden" value="<?=$pathologies[0]->pathologies_id;?>:<?=$pathologies[0]->pathologies_pid;?>" name="dbf_edit_id"><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Pack Name</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="pathologies_identifier" value="<?=$pathologies[0]->pathologies_identifier;?>" class="dbf_text_field dbf_class_pathologies_identifier ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Pack Number</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="pathologies_pack_number" value="<?=$pathologies[0]->pathologies_pack_number;?>" class="dbf_text_field dbf_class_pathologies_pack_number ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_mail_wrapper dbf_wrapper">
								<div class="dbf_mail_label dbf_label">Associated Build Number</div>
								<div class="dbf_mail_field dbf_field">
									<input type="text" data-required="true" name="pathologies_build_number" value="<?=$pathologies[0]->pathologies_build_number;?>" class="dbf_mail_field dbf_class_pathologies_build_number ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_radio_wrapper dbf_wrapper ">
								<div class="dbf_radio_before dbf_label">
									<div class="dbf_radio_description">Available Doppler P1</div>
								</div>
								<div class="dbf_radio_main dbf_field">
									<div class="dbf_radio_radio dbf_class_doppler_p1">
										<input type="radio" data-required="true" value="1" name="pathologies_doppler_p1" <?=($pathologies[0]->pathologies_doppler_p1)?"checked=\"checked\"":"";?>>
										<span class="dbf_radio_label">yes</span>
									</div>
									<div class="dbf_radio_radio dbf_class_doppler_p1">
										<input type="radio" data-required="true" value="0" name="pathologies_doppler_p1" <?=(!$pathologies[0]->pathologies_doppler_p1)?"checked=\"checked\"":"";?>>
										<span class="dbf_radio_label">no</span>
									</div>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_radio_wrapper dbf_wrapper ">
								<div class="dbf_radio_before dbf_label">
									<div class="dbf_radio_description">Available Doppler P2</div>
								</div>
								<div class="dbf_radio_main dbf_field">
									<div class="dbf_radio_radio dbf_class_doppler_p2">
										<input type="radio" data-required="true" value="1" name="pathologies_doppler_p2" <?=($pathologies[0]->pathologies_doppler_p2)?"checked=\"checked\"":"";?>>
										<span class="dbf_radio_label">yes</span>
									</div>
									<div class="dbf_radio_radio dbf_class_doppler_p2">
										<input type="radio" data-required="true" value="0" name="pathologies_doppler_p2" <?=(!$pathologies[0]->pathologies_doppler_p2)?"checked=\"checked\"":"";?>>
										<span class="dbf_radio_label">no</span>
									</div>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_radio_wrapper dbf_wrapper ">
								<div class="dbf_radio_before dbf_label">
									<div class="dbf_radio_description">Available Doppler P3</div>
								</div>
								<div class="dbf_radio_main dbf_field">
									<div class="dbf_radio_radio dbf_class_doppler_p3">
										<input type="radio" data-required="true" value="1" name="pathologies_doppler_p3" <?=($pathologies[0]->pathologies_doppler_p3)?"checked=\"checked\"":"";?>>
										<span class="dbf_radio_label">yes</span>
									</div>
									<div class="dbf_radio_radio dbf_class_doppler_p3">
										<input type="radio" data-required="true" value="0" name="pathologies_doppler_p3" <?=(!$pathologies[0]->pathologies_doppler_p3)?"checked=\"checked\"":"";?>>
										<span class="dbf_radio_label">no</span>
									</div>
								</div>
								<div class="dbf-cleaner"></div>
							</div>

							<div class="dbf_submit_wrapper dbf_wrapper">
								<div class="dbf_submit_label"></div>
								<div class="dbf_submit_button">
									<input type="submit" name="dbf_delete" value="Delete!" class="dbf_submit_button">
									<input type="submit" value="Update!" class="dbf_submit_button">
								</div>
							</div><br>
						</form>
					</div><!--dbf_wrapper-->
				</div><!-- .entry-content -->
<br><br><br>
				<header class="entry-header"><h1 class="entry-title">Pathology Pack History</h1></header>

<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM pathologies WHERE pathologies_pid=".$pathologies[0]->pathologies_pid);
        echo "<table id='sortableTable' class='tablesorter-grey'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Pack Name</th>";
        echo "<th>Pack Number</th>";
        echo "<th>Associated Build</th>";
        echo "<th>Last Modified</th>";
        echo "<th>Modified By</th>";
        echo "</tr>";
        echo "<tbody>";
        foreach($result as $object){
                echo "<tr class='clickableRow' href='".get_permalink(460)."?id=".$object->pathologies_id."'>";
                echo "<td>".$object->pathologies_identifier."</td>";
                echo "<td>".$object->pathologies_pack_number."</td>";
                echo "<td>".$object->pathologies_build_number."</td>";
                echo "<td>".$object->pathologies_last_modified."</td>";
                echo "<td>".$object->pathologies_modified_by."</td>";
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
