<?php
/*
Template Name: Pending Keys
*/
?>

<?php
define("THISPAGE", "pending-keys");
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

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">

                        <?php
                                // Start the Loop.
                                while ( have_posts() ) : the_post();

                                        // Include the page content template.
                                        get_template_part( 'content', 'page' );

                                endwhile;
                        ?>

<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){

//	$result = $dbf_db->get_results("SELECT tmpKeys.keys_id, tmpKeys.keys_pid, tmpKeys.keys_identifier, tmpSystems.systems_id, tmpSystems.systems_pid, tmpSystems.systems_identifier, tmpPathologies.pathologies_id, tmpPathologies.pathologies_pid, tmpPathologies.pathologies_identifier FROM ( SELECT * FROM (SELECT * FROM `keys` ORDER BY keys_id desc ) as master GROUP BY keys_pid ORDER BY keys_identifier ) as tmpKeys INNER JOIN ( SELECT * FROM ( SELECT * FROM systems ORDER BY systems_id DESC ) as systems GROUP BY systems_pid ) as tmpSystems ON tmpKeys.systems_pid = tmpSystems.systems_pid INNER JOIN ( SELECT * FROM ( SELECT * FROM pathologies ORDER BY pathologies_id DESC ) as pathologies GROUP BY pathologies_pid ) as tmpPathologies on tmpKeys.pathologies_pid = tmpPathologies.pathologies_pid;");
	$result = $dbf_db->get_results("select keys_id, systems_identifier, customers_identifier,
    systems_software_version, systems_build_number,
    systems_software_features, requested_pathology_packs,
    machines_identifier,machines_fingerprint, systems_use_combined_licence_name
    from v_latest_systems  LS
    join v_latest_customers LC using (customers_pid)
    join v_latest_machines LM using (machines_pid)
    left join v_latest_keys LK using (systems_id)
    where keys_id IS NULL
    and LS.systems_software_version IN ('TOE', 'TTE', 'DUAL', 'LEGACY')
    and LS.systems_build_number IN ('1.4.5.0', '1.4.6.0', '1.5.6.0', '1.5.7.0', '1.6.3.0')
    and CHAR_LENGTH(LS.requested_pathology_packs) > 7;");
	echo "<table id='sortableTable' class='tablesorter-grey'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Key ID</th>";
	echo "<th>System ID</th>";
	echo "<th>Customer ID</th>";
	echo "<th>SW version</th>";
	echo "<th>Build</th>";
	echo "<th>Features</th>";
	echo "<th>Patholgies</th>";
	echo "<th>Machines ID</th>";
	echo "<th>Fingerprint</th>";
	echo "<th>Combined</th>";
	echo "</tr>";
	echo "<tbody>";
	foreach($result as $object){
		echo "<tr>"; // class='clickableRow' href='".get_permalink(466)."?id=".$object->keys_id."'>";
		echo "<td>".$object->keys_id."</td>";
		echo "<td>".$object->systems_identifier."</td>";
		echo "<td>".$object->customers_identifier."</td>";
		echo "<td>".$object->systems_software_version."</td>";
		echo "<td>".$object->systems_build_number."</td>";
		echo "<td>".$object->systems_software_features."</td>";
		echo "<td>".$object->requested_pathology_packs."</td>";
		echo "<td>".$object->machines_identifier."</td>";
		echo "<td>".(($object->machines_fingerprint != NULL) ? "fingerprint" : "")."</td>";
		echo "<td>".$object->systems_use_combined_licence_name."</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}
?>
                </div><!-- #content -->
        </div><!-- #primary -->

        <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer(); 
?>
