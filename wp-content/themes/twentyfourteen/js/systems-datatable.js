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
	"pageLength": 25
    });
    // Array to track the ids of the details displayed rows
    var detailRows = [];
});
