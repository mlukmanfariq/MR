(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		var data_hardware = "../../admin/hardware/data_hardware.php";
		$("#data_hardware").load(data_hardware);
	});
}) (jQuery);
