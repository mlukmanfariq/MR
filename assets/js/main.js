(function($) {
	// fungsi dijalankan setelah seluruh dokumen ditampilkan
	$(document).ready(function(e) {
		// ketika tombol ubah/tambah di tekan
		$('.edit').live("click", function(){
			var url = "edit_user.php";
			// ambil nilai id dari tombol ubah
			id_user = this.id;
			$("#myModalLabel").html("Ubah Data User");
			$.post(url, {id:id_user} ,function(data) {
				// tampilkan mahasiswa.form.php ke dalam <div class="modal-body"></div>
				$(".modal-body").html(data).show();
			});
		});
	});
}) (jQuery);
