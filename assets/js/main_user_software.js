(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		var data_user_software = "../../admin/software/data_user_software.php";
		$("#data_user_software").load(data_user_software);
	});
}) (jQuery);