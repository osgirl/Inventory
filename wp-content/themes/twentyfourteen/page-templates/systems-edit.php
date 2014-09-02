<?php
/*
Template Name: Edit System
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


$features['default'] = array ( 'MMode', 'Doppler' );
$software_versions['default'] = array ( '-- none --', 'TOE', 'TTE', 'Dual', 'Legacy', 'Mobile' );

$id = mysql_real_escape_string($_GET[id]);
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM `systems`
                                                LEFT JOIN customers ON systems.customers_pid=customers.customers_pid
                                                LEFT JOIN machines ON systems.machines_pid=machines.machines_pid
                                                LEFT JOIN manakins ON systems.manakins_pid=manakins.manakins_pid
						WHERE systems_id=$id;");
#	$customers = $dbf_db->get_results("SELECT * FROM (SELECT * FROM customers as x1 order by customers_id desc) as x2 group by customers_pid order by customers_identifier;");
	$customers = $dbf_db->get_results("SELECT * FROM v_latest_customers ORDER BY customers_identifier;");
#	$machines = $dbf_db->get_results("SELECT * FROM (SELECT * FROM (SELECT * FROM machines as x1 order by machines_id desc) as x2 group by machines_pid order by machines_identifier) as x3 WHERE x3.machines_pid NOT IN (SELECT machines_pid FROM (SELECT * FROM systems ORDER BY systems_id DESC) as x GROUP BY systems_pid);");
	$machines = $dbf_db->get_results("SELECT * FROM v_latest_machines WHERE machines_pid NOT IN (SELECT machines_pid FROM v_latest_systems);");
#	$manakins = $dbf_db->get_results("SELECT * FROM (SELECT * FROM (SELECT * FROM manakins as x1 order by manakins_id desc) as x2 group by manakins_pid order by manakins_identifier) as x3 WHERE x3.manakins_pid NOT IN (SELECT manakins_pid FROM (SELECT * FROM systems ORDER BY systems_id DESC) as x GROUP BY systems_pid);");
	$manakins = $dbf_db->get_results("SELECT * FROM v_latest_manakins WHERE manakins_pid NOT IN (SELECT manakins_pid FROM v_latest_systems) ORDER BY manakins_identifier ASC;");
        $pathologies = $dbf_db->get_results("SELECT * FROM v_latest_pathologies ORDER BY pathologies_pack_number ASC;");
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
							<input type="hidden" value="<?=$result[0]->systems_id;?>:<?=$result[0]->systems_pid;?>" name="dbf_edit_id"><br>

                                                        <div class="dbf_text_wrapper dbf_wrapper">
                                                                <div class="dbf_text_label dbf_label">Heartworks ID</div>
                                                                <div class="dbf_text_field dbf_field">
                                                                        <input type="text" data-required="true" name="systems_identifier" value="<?=$result[0]->systems_identifier;?>" class="dbf_text_field dbf_class_systems_identifier ">
                                                                </div>
                                                                <div class="dbf-cleaner"></div>
                                                        </div><br>

							<div class="dbf_select_wrapper dbf_wrapper ">
								<div class="dbf_select_before dbf_label">
									<div class="dbf_select_description">Customer</div>
								</div>
								<div class="dbf_select_main dbf_field">
									<select data-required="true" name="customers_pid">
                                                                                <option value="0">-- Unassigned --</option>
<?php
foreach($customers as $customer) {
?>
                                                                                <option <?=(($customer->customers_pid == $result[0]->customers_pid) ? "selected=\"selected\" " : "");?>value="<?=$customer->customers_pid;?>"><?=$customer->customers_identifier;?></option>
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
                                                                                 <option value="0">-- Unassigned --</option>
<?php
if(!$result[0]->machines_pid=='') {
?>
										<option selected="selected" value="<?=$result[0]->machines_pid;?>"><?=$result[0]->machines_identifier;?></option>
<?php
}
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
                                                                                 <option value="0">-- Unassigned --</option>
<?php
if(!$result[0]->manakins_pid=='') {
?>
										<option selected="selected" value="<?=$result[0]->manakins_pid;?>"><?=$result[0]->manakins_identifier;?></option>
<?php
}
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
<?php
foreach($software_versions['default'] as $version) {
?>
										<option <?=(($version == $result[0]->systems_software_version) ? "selected=\"selected\" " : "");?>value="<?=$version;?>"><?=$version;?></option>
<?php
}
?>
									</select>
								</div>
								<div class="dbf-cleaner"></div>
							</div>


							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Software Build Number</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="systems_build_number" value="<?=$result[0]->systems_build_number;?>" class="dbf_text_field dbf_class_systems_build_number ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>


                                                        <div class="dbf_select_wrapper dbf_wrapper ">
                                                                <div class="dbf_select_before dbf_label">
                                                                        <div class="dbf_select_description">Software Features</div>
                                                                </div>
                                                                <div class="dbf_select_main dbf_field">
                                                                        <select data-required="true" multiple="multiple" name="arr[systems_software_features][]">
<?php
$features['selected'] = json_decode($result[0]->systems_software_features);

foreach($features['default'] as $feature) {
	if(in_array($feature, $features['selected'])) {
?>
										<option selected="selected" value="<?=$feature;?>"><?=$feature;?></option>
<?php
	}else{
?>
										<option value="<?=$feature;?>"><?=$feature;?></option>
<?php
	}
}
?>
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
                                                                                <option <?=((in_array($pathology->pathologies_identifier, json_decode($result[0]->requested_pathology_packs))) ? "selected=\"selected\"" : "");?>value="<?=$pathology->pathologies_identifier;?>"><?=$pathology->pathologies_identifier;?></option>
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
        $result = $dbf_db->get_results("SELECT * FROM systems WHERE systems_pid=".$result[0]->systems_pid);
        echo "<table id='sortableTable' class='tablesorter-grey'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>HW Identifier</th>";
        echo "<th>Last Modified</th>";
        echo "<th>Modified By</th>";
        echo "</tr>";
        echo "<tbody>";
        foreach($result as $object){
                echo "<tr class='clickableRow' href='".get_permalink(434)."?id=".$object->systems_id."'>";
                echo "<td>".$object->systems_identifier."</td>";
                echo "<td>".$object->systems_last_modified."</td>";
                echo "<td>".$object->systems_modified_by."</td>";
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
