<?php
/*
Template Name: Manakins
*/
?>

<?php
define("THISPAGE", "manakins");
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
	$result = $dbf_db->get_results("SELECT * FROM (SELECT * FROM manakins order by manakins_id desc) as test group by manakins_pid order by manakins_identifier;");
	echo "<table id='sortableTable' class='tablesorter-grey'>";;
	echo "<thead>";
	echo "<tr>";
	echo "<th>Manakin Identifier</th>";
	echo "<th>minDepth</th>";
	echo "<th>maxDepth</th>";
	echo "<th>minTwist</th>";
	echo "<th>maxTwist</th>";
	echo "<th>minFlex</th>";
	echo "<th>maxFlex</th>";
	echo "</tr>";
	echo "<tbody>";
	foreach($result as $object){
		echo "<tr class='clickableRow' href='".get_permalink(409)."?id=".$object->manakins_id."'>";
		echo "<td>".$object->manakins_identifier."</td>";
		echo "<td>".$object->minDepth."</td>";
		echo "<td>".$object->maxDepth."</td>";
		echo "<td>".$object->minTwist."</td>";
		echo "<td>".$object->maxTwist."</td>";
		echo "<td>".$object->minFlex."</td>";
		echo "<td>".$object->maxFlex."</td>";
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
