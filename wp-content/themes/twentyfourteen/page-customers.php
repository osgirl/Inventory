<?php
/*
Template Name: Customers
*/
?>

<?php
define("THISPAGE", "customers");
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
	$result = $dbf_db->get_results("SELECT * FROM (SELECT * FROM customers order by customers_id desc) as test group by customers_pid order by customers_identifier;");
	echo "<table id='sortableTable' class='tablesorter-grey'>";;
	echo "<thead>";
	echo "<tr>";
	echo "<th>Licensee</th>";
	echo "<th>Customer&nbsp;Name</th>";
	echo "<th>Email Address</th>";
	echo "<th>Telephone Number</th>";
	echo "<th>Address</th>";
	echo "</tr>";
	echo "<tbody>";
	foreach($result as $object){
		echo "<tr class='clickableRow' href='".get_permalink(395)."?id=".$object->customers_id."'>";
		echo "<td>".$object->customers_identifier."</td>";
		echo "<td>".$object->customers_name."</td>";
		echo "<td>".$object->customers_email."</td>";
		echo "<td>".$object->customers_telephone."</td>";
		echo "<td>".$object->customers_address."</td>";
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
