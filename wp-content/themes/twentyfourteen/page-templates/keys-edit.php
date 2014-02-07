<?php
/*
Template Name: Edit License Key
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
	$key = $dbf_db->get_results("SELECT * FROM `keys` WHERE keys_id=$id;");
	$systems = $dbf_db->get_results("SELECT * FROM (SELECT * FROM systems as x1 order by systems_id desc) as x2 group by systems_pid order by systems_identifier;");
	$pathologies = $dbf_db->get_results("SELECT * FROM (SELECT * FROM pathologies as x1 ORDER BY pathologies_id desc) as x2 group by pathologies_pid order by pathologies_identifier;");

}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">


			<article class="post-466 page type-page status-publish hentry" id="post-466">
				<header class="entry-header"><h1 class="entry-title">Edit License Key</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_keys " id="dbf_form_wrapper_keys">
						<form action="<?=plugins_url();?>/db-form/php/updater111.php" method="post" class="db_form " id="dbf_form_keys" enctype="multipart/form-data" name="dbf_form_keys">
							<input type="hidden" value="keys" name="dbf_submitted">
							<input type="hidden" value="233" name="dbf_keys_post_id"><br>
							<input type="hidden" value="<?=$key[0]->keys_id;?>:<?=$key[0]->keys_pid;?>" name="dbf_edit_id"><br>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">System ID</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="systems_pid">
<?php
foreach($systems as $system){
?>
                                                                                <option <?=(($system->systems_pid == $key[0]->systems_pid) ? "selected=\"selected\"" : "");?>value="<?=$system->systems_pid;?>"><?=$system->systems_identifier;?></option>
<?php
}
?>
                                                                        </select>
                                                                </div>
                                                                <div class="dbf-cleaner"></div>
                                                        </div>

                                                        <div class="dbf_select_wrapper dbf_wrapper ">
                                                                <div class="dbf_select_before dbf_label">
                                                                        <div class="dbf_select_description">Pathology Pack</div>
                                                                </div>
                                                                <div class="dbf_select_main dbf_field">
                                                                        <select data-required="true" name="pathologies_pid">
<?php
foreach($pathologies as $pathology){
?>
                                                                                <option <?=(($pathology->pathologies_pid == $key[0]->pathologies_pid) ? "selected=\"selected\"" : "");?>value="<?=$pathology->pathologies_pid;?>"><?=$pathology->pathologies_identifier;?></option>
<?php
}
?>
                                                                        </select>
                                                                </div>
                                                                <div class="dbf-cleaner"></div>
                                                        </div>

                                                        <div class="dbf_textarea_wrapper dbf_wrapper">
                                                                <div class="dbf_textarea_label dbf_label">License Key XML *</div>
                                                                <div class="dbf_textarea_field dbf_field">
                                                                        <textarea data-required="true" placeholder="" name="keys_xml" class="dbf_textarea_field dbf_class_key "><?=stripslashes($key[0]->keys_xml);?></textarea>
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
					</div><!--dbf_wrapper--><p></p>
				</div><!-- .entry-content -->
<br><br><br>
                                <header class="entry-header"><h1 class="entry-title">System History</h1></header>

<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM `keys` WHERE keys_pid=".$key[0]->keys_pid);
        echo "<table id='sortableTable' class='tablesorter-grey'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Key Identifier</th>";
        echo "<th>Last Modified</th>";
        echo "<th>Modified By</th>";
        echo "</tr>";
        echo "<tbody>";
        foreach($result as $object){
                echo "<tr class='clickableRow' href='".get_permalink(466)."?id=".$object->keys_id."'>";
                echo "<td>".$object->keys_identifier."</td>";
                echo "<td>".$object->keys_last_modified."</td>";
                echo "<td>".$object->keys_modified_by."</td>";
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
