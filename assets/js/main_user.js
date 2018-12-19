(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		
		var data_user = "../../admin/user_comp/data_user.php";
		$("#data_user").load(data_user);
	});
	$('.add').live("click", function(){
		var url = "../../admin/user_comp/user_form2.php";
		$("#myModalLabel").html("Add Data Computer User");

		$.post(url, function(data) {
			// tampilkan mahasiswa.form.php ke dalam <div class="modal-body"></div>
			$(".modal-body").html(data).show();
		});
	});
}) (jQuery);
