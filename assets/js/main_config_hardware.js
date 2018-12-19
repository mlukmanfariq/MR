(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		var data_config_hardware = "../../admin/hardware_configuration/data_config_hardware.php";
		$("#data_config_hardware").load(data_config_hardware);
	});
}) (jQuery);
