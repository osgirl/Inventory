<?php
/*
Template Name: Edit Customer
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
        $customers = $dbf_db->get_results("SELECT * FROM customers WHERE customers_id=$id;");
}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">


			<article class="post-309 page type-page status-publish hentry" id="post-309">
				<header class="entry-header"><h1 class="entry-title">Edit Customer</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_customers  " id="dbf_form_wrapper_customers">
						<form action="<?=plugins_url();?>/db-form/php/updater111.php" method="post" class="db_form " id="dbf_form_customers" enctype="multipart/form-data" name="dbf_form_customers">
							<input type="hidden" value="customers" name="dbf_submitted">
							<input type="hidden" value="229" name="dbf_customers_post_id"><br>
							<input type="hidden" value="<?=$customers[0]->customers_id;?>:<?=$customers[0]->customers_pid;?>" name="dbf_edit_id"><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Licensee</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="customers_identifier" value="<?=$customers[0]->customers_identifier;?>" class="dbf_text_field dbf_class_customers_identifier ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Customer Name</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="customers_name" value="<?=$customers[0]->customers_name;?>" class="dbf_text_field dbf_class_customers_name ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_mail_wrapper dbf_wrapper">
								<div class="dbf_mail_label dbf_label">Email Address</div>
								<div class="dbf_mail_field dbf_field">
									<input type="text" data-required="true" name="customers_email" value="<?=$customers[0]->customers_email;?>" class="dbf_mail_field dbf_class_customers_email ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Telephone Number</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="true" name="customers_telephone" value="<?=$customers[0]->customers_telephone;?>" class="dbf_text_field dbf_class_customers_telephone ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_textarea_wrapper dbf_wrapper">
								<div class="dbf_textarea_label dbf_label">Delivery Address</div>
								<div class="dbf_textarea_field dbf_field">
									<textarea data-required="true" name="customers_address" class="dbf_textarea_field dbf_class_customers_address "><?=$customers[0]->customers_address;?></textarea>
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

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
				<header class="entry-header"><h1 class="entry-title">Customer History</h1></header>

<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM customers WHERE customers_pid=".$customers[0]->customers_pid);
        echo "<table id='sortableTable' class='tablesorter-grey'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Licensee</th>";
        echo "<th>Customer Name</th>";
        echo "<th>Email Address</th>";
        echo "<th>Last Modified</th>";
        echo "<th>Modified By</th>";
        echo "</tr>";
        echo "<tbody>";
        foreach($result as $object){
                echo "<tr class='clickableRow' href='".get_permalink(395)."?id=".$object->customers_id."'>";
                echo "<td>".$object->customers_identifier."</td>";
                echo "<td>".$object->customers_name."</td>";
                echo "<td>".$object->customers_email."</td>";
                echo "<td>".$object->customers_last_modified."</td>";
                echo "<td>".$object->customers_modified_by."</td>";
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
