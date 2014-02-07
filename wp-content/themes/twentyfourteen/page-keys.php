<?php
/*
Template Name: Generated Keys
*/
?>

<?php
define("THISPAGE", "generated-keys");
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

	$result = $dbf_db->get_results("SELECT tmpKeys.keys_id, tmpKeys.keys_pid, tmpKeys.keys_identifier, tmpSystems.systems_id, tmpSystems.systems_pid, tmpSystems.systems_identifier, tmpPathologies.pathologies_id, tmpPathologies.pathologies_pid, tmpPathologies.pathologies_identifier FROM ( SELECT * FROM (SELECT * FROM `keys` ORDER BY keys_id desc ) as master GROUP BY keys_pid ORDER BY keys_identifier ) as tmpKeys INNER JOIN ( SELECT * FROM ( SELECT * FROM systems ORDER BY systems_id DESC ) as systems GROUP BY systems_pid ) as tmpSystems ON tmpKeys.systems_pid = tmpSystems.systems_pid INNER JOIN ( SELECT * FROM ( SELECT * FROM pathologies ORDER BY pathologies_id DESC ) as pathologies GROUP BY pathologies_pid ) as tmpPathologies on tmpKeys.pathologies_pid = tmpPathologies.pathologies_pid;");
	echo "<table id='sortableTable' class='tablesorter-grey'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Key Identifier</th>";
	echo "<th>System</th>";
	echo "<th>Pathology</th>";
	echo "</tr>";
	echo "<tbody>";
	foreach($result as $object){
		echo "<tr class='clickableRow' href='".get_permalink(466)."?id=".$object->keys_id."'>";
		echo "<td>".$object->keys_identifier."</td>";
		echo "<td>".$object->systems_identifier."</td>";
		echo "<td>".$object->pathologies_identifier."</td>";
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
