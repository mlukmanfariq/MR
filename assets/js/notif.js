(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		var notif_index = "notif_problem.php";
		var notif = "../../admin/notif_problem.php";
		$("#notif_problem_index").load(notif_index);
		$("#notif_problem").load(notif);
	});
}) (jQuery);