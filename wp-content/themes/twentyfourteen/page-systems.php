<?php
/*
Template Name: Systems
*/
?>

<?php
define("THISPAGE", "systems");
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
	$result = $dbf_db->get_results("SELECT * FROM `systems` 
						LEFT JOIN customers ON systems.customer_id=customers.customer_id
						LEFT JOIN machines ON systems.machine_id=machines.machine_id
						LEFT JOIN manakins ON systems.manakin_id=manakins.manakin_id;");
	echo "<table id='sortableTable' class='tablesorter-grey'>";;
	echo "<thead>";
	echo "<tr>";
	echo "<th>Heartworks Identifier</th>";
	echo "<th>Customer</th>";
	echo "<th>Machine</th>";
	echo "<th>Manakin</th>";
	echo "</tr>";
	echo "<tbody>";
	foreach($result as $object){
		echo "<tr class='clickableRow' href='".get_permalink(434)."?csid=".$object->system_id."'>";
		echo "<td>".$object->heartworks_ident."</td>";
		echo "<td>".$object->license_name."</td>";
		echo "<td>".$object->service_tag."</td>";
		echo "<td>".$object->manakin_ident."</td>";
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
