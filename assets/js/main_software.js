(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		var data_software = "../../admin/software/data_software.php";
		$("#data_software").load(data_software);
	});
}) (jQuery);