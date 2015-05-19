<?php
/*
Template Name: Test Systems
*/
?>

<?php
define("THISPAGE", "test-systems");
?>

<?php get_header(); ?>
<link rel="stylesheet" href="<?=get_template_directory_uri();?>/css/jquery.dataTables.css">
<script type="text/javascript" src="<?=get_template_directory_uri();?>/js/jquery.dataTables.js"></script>

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
<script>
var eSystem = '<?=get_permalink(434)."?id=";?>'
var eCustomer = '<?=get_permalink(395)."?id=";?>'
var eMachine = '<?=get_permalink(406)."?id=";?>'
var eManakin = '<?=get_permalink(409)."?id=";?>'
var dataSet = [
<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
	$result = $dbf_db->get_results("SELECT * FROM v_latest_systems as systems LEFT JOIN v_latest_customers as customers ON systems.customers_pid=customers.customers_pid LEFT JOIN v_latest_machines AS machines ON systems.machines_pid=machines.machines_pid LEFT JOIN v_latest_manakins as manakins ON systems.manakins_pid=manakins.manakins_pid ORDER BY systems_identifier asc;");
	foreach($result as $object){
		echo "\t\t['" . addslashes($object->systems_identifier)
			. "', '" . addslashes($object->customers_identifier)
			. "', '" . addslashes($object->machines_identifier)
			. "', '" . addslashes($object->manakins_identifier)
			. "', '" . $object->systems_id
			. "', '" . $object->customers_id
			. "', '" . $object->machines_id
			. "', '" . $object->manakins_id
			. "'],\n";
	}
?>
];
$(document).ready(function() {
    oTable = $('#systems_datatable').dataTable({
//        "ajax":"../db/db_query.php?page=systems",
        "data": dataSet,
        "columns": [
                { "title": "Heartworks Identifier", "width" : "20%" },
                { "title": "Customer" },
                { "title": "Machine", "width" : "15%" },
                { "title": "Manakin" }],
        "order": [0, 'asc'],
        "pageLength": 25,
	"rowCallback": function( row, data ) {
		$('td:eq(0)', row).html( '<a href=\'' + eSystem + data[4] + '\'>' + data[0] + '</a>');
		$('td:eq(1)', row).html( '<a href=\'' + eCustomer + data[5] + '\'>' + data[1] + '</a>');
		$('td:eq(2)', row).html( '<a href=\'' + eMachine + data[6] + '\'>' + data[2] + '</a>');
		$('td:eq(3)', row).html( '<a href=\'' + eManakin + data[7] + '\'>' + data[3] + '</a>');
	}
    });
    // Array to track the ids of the details displayed rows
    var detailRows = [];
});
</script>

	<table id='systems_datatable' class="display\" cellspacing="0" width="100%">
	</table>
<?php } ?>
                </div><!-- #content -->
        </div><!-- #primary -->

        <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer(); 
?>
