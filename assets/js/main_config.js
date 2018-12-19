(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		var data_config = "../../admin/system_configuration/data_config.php";
		$("#data_config").load(data_config);
	});
}) (jQuery);
