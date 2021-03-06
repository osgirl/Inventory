<?php
/*
Template Name: Pathologies
*/
?>

<?php
define("THISPAGE", "pathologies");
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
	$result = $dbf_db->get_results("SELECT * FROM (SELECT * FROM pathologies order by pathologies_id desc) as test group by pathologies_pid order by pathologies_identifier;");
	echo "<table id='sortableTable' class='tablesorter-grey'>";;
	echo "<thead>";
	echo "<tr>";
	echo "<th>Pack Name</th>";
	echo "<th>Pack Number</th>";
	echo "<th>Associated Build Number</th>";
	echo "</tr>";
	echo "<tbody>";
	foreach($result as $object){
		echo "<tr class='clickableRow' href='".get_permalink(460)."?id=".$object->pathologies_id."'>";
		echo "<td>".$object->pathologies_identifier."</td>";
		echo "<td>".$object->pathologies_pack_number."</td>";
		echo "<td>".$object->pathologies_build_number."</td>";
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
