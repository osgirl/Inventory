<?php
/*
Template Name: Edit Manakin
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
        $manakin = $dbf_db->get_results("SELECT * FROM manakins WHERE manakins_id=$id;");
}
?>

<div id="main-content" class="main-content">
        <div id="primary" class="content-area">
                <div id="content" class="site-content" role="main">


			<article class="post-409 page type-page status-publish hentry" id="post-409">
				<header class="entry-header"><h1 class="entry-title">Edit Manakin</h1></header>
				<div class="entry-content">
					<p><span class="code"></span></p>
					<div class="dbf_form_wrapper dbf_form_wrapper_manakins  " id="dbf_form_wrapper_manakins">
						<form action="<?=plugins_url();?>/db-form/php/updater111.php" method="post" class="db_form " id="dbf_form_manakins" enctype="multipart/form-data" name="dbf_form_manakins">
							<input type="hidden" value="manakins" name="dbf_submitted">
							<input type="hidden" value="227" name="dbf_manakins_post_id"><br>
							<input type="hidden" value="<?=$manakin[0]->manakins_id;?>:<?=$manakin[0]->manakins_pid;?>" name="dbf_edit_id"><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">Manakin Identifier</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="manakins_identifier" value="<?=$manakin[0]->manakins_identifier;?>" class="dbf_text_field dbf_class_manakins_identifier ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">minDepth</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="minDepth" value="<?=$manakin[0]->minDepth;?>" class="dbf_text_field dbf_class_minDepth ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>
							
							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">maxDepth</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="maxDepth" value="<?=$manakin[0]->maxDepth;?>" class="dbf_text_field dbf_class_maxDepth ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">minTwist</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="minTwist" value="<?=$manakin[0]->minTwist;?>" class="dbf_text_field dbf_class_minTwist ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">maxTwist</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="maxTwist" value="<?=$manakin[0]->maxTwist;?>" class="dbf_text_field dbf_class_maxTwist ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">minFlex</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="minFlex" value="<?=$manakin[0]->minFlex;?>" class="dbf_text_field dbf_class_minFlex ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">maxFlex</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="maxFlex" value="<?=$manakin[0]->maxFlex;?>" class="dbf_text_field dbf_class_maxFlex ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEPowerLineFreq</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEPowerLineFreq" value="<?=$manakin[0]->TTEPowerLineFreq;?>" class="dbf_text_field dbf_class_TTEPowerLineFreq ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEPressure</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEPressure" value="<?=$manakin[0]->TTEPressure;?>" class="dbf_text_field dbf_class_TTEPressure ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEProbeTipPOS</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEProbeTipPOS" value="<?=$manakin[0]->TTEProbeTipPOS;?>" class="dbf_text_field dbf_class_TTEProbeTipPOS ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEAscensionRollCorrect</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEAscensionRollCorrect" value="<?=$manakin[0]->TTEAscensionRollCorrect;?>" class="dbf_text_field dbf_class_TTEAscensionRollCorrect ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEAscenscionTRANS</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEAscenscionTRANS" value="<?=$manakin[0]->TTEAscenscionTRANS;?>" class="dbf_text_field dbf_class_TTEAscenscionTRANS ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEAscenscionROT</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEAscenscionROT" value="<?=$manakin[0]->TTEAscenscionROT;?>" class="dbf_text_field dbf_class_TTEAscenscionROT ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEReal2XSI_R0</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEReal2XSI_R0" value="<?=$manakin[0]->TTEReal2XSI_R0;?>" class="dbf_text_field dbf_class_TTEReal2XSI_R0 ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEReal2XSI_R1</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEReal2XSI_R1" value="<?=$manakin[0]->TTEReal2XSI_R1;?>" class="dbf_text_field dbf_class_TTEReal2XSI_R1 ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEReal2XSI_R2</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEReal2XSI_R2" value="<?=$manakin[0]->TTEReal2XSI_R2;?>" class="dbf_text_field dbf_class_TTEReal2XSI_R2 ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_text_wrapper dbf_wrapper">
								<div class="dbf_text_label dbf_label">TTEReal2XSI_R3</div>
								<div class="dbf_text_field dbf_field">
									<input type="text" data-required="false" name="TTEReal2XSI_R3" value="<?=$manakin[0]->TTEReal2XSI_R3;?>" class="dbf_text_field dbf_class_TTEReal2XSI_R3 ">
								</div>
								<div class="dbf-cleaner"></div>
							</div><br>

							<div class="dbf_submit_wrapper dbf_wrapper">
								<div class="dbf_submit_label"></div>
								<div class="dbf_submit_button">
									<input type="submit" name="dbf_delete" value="Delete!" class="dbf_submit_button hideDelete">
									<input type="submit" value="Update!" class="dbf_submit_button hideEdit">
								</div>
							</div><br>
						</form>
					</div><!--dbf_wrapper-->
				</div><!-- .entry-content -->
<br><br><br>
                                <header class="entry-header"><h1 class="entry-title">Manakin History</h1></header>

<?php
$dbf_db = new wpdb(get_option('dbf-0-db-user'),get_option('dbf-0-db-password'),get_option('dbf-0-db-name'),get_option('dbf-0-db-host'));
if($dbf_db){
        $result = $dbf_db->get_results("SELECT * FROM manakins WHERE manakins_pid=".$manakin[0]->manakins_pid);
        echo "<table id='sortableTable' class='tablesorter-grey'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Manakin Identifier</th>";
        echo "<th>Last Modified</th>";
        echo "<th>Modified By</th>";
        echo "</tr>";
        echo "<tbody>";
        foreach($result as $object){
                echo "<tr class='clickableRow' href='".get_permalink(409)."?id=".$object->manakins_id."'>";
                echo "<td>".$object->manakins_identifier."</td>";
                echo "<td>".$object->manakins_last_modified."</td>";
                echo "<td>".$object->manakins_modified_by."</td>";
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
