<?php
	if($this->session->userdata('sesi_status')<>1)
	header('location:'.base_url());
?>
<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Upload Dokumen</h1>
		<a href="#" data-toggle="modal" data-target="#upload-modal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Tambah Dokumen</a>
	</div>
	<?php
		if($this->session->flashdata('result')<>'')
		{
			echo '<div class="alert alert-success" role="alert">'.
			$this->session->flashdata('result').'
			</div>';
		}
	?>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="50%">Judul</th>
							<th>File Dokumen</th>
							<th>Update Terakhir</th>
							<th></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Judul</th>
							<th>File Dokumen</th>
							<th>Update Terakhir</th>
							<th></th>
						</tr>
					</tfoot>
					<tbody>
						<?php
							foreach($download as $p)
							{
								echo "<tr>
								<td>".$p->judul."</td>
								<td><a href='".base_url().'assets/uploadbox/'.$p->file."'>Download</a></td>
								<td width='25%'>".tgl_indo($p->modified,1)."</td>
								<td width='10%'>
								<a href='#' data-toggle='modal' data-target='#edit-modal' data-dok='".$p->id_file.",".$p->judul.",".$p->keterangan.",".$p->file.",".$p->jenisdok.",".$p->katedok."' class='shadow-sm' title='Edit File'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
								<a href='#' data-id='".$p->id_file."' rel='tooltip' data-placement='top' title='Hapus Pengguna' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a>
								</td>
								</tr>";
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- modal tambah dokumen -->
<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'dokumen/simpan'; ?>" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Judul</label>
						<div class="col-sm-10">
							<textarea name="judul" cols="10" class="form-control" placeholder="Judul File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis Dokumen</label>
						<div class="col-sm-10">
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio1" value="Penelitian" onClick="toggleKate();" />
							  <label class="form-check-label" for="inlineRadio1">Penelitian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio2" value="Pengabdian" onClick="toggleKate();" />
							  <label class="form-check-label" for="inlineRadio2">Pengabdian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio3" value="Dokumen LPPM" onClick="toggleLppm();" />
							  <label class="form-check-label" for="inlineRadio3">Dokumen LPPM</label>
							</div>
						</div>
					</div>
					<div class="form-group row" id="katedok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="katedok" cols="10" class="form-control">
								<option value="Surat Tugas">Surat Tugas</option>
								<option value="Surat Kontrak">Surat Kontrak</option>
								<option value="Ijin Penelitian">Ijin Penelitian</option>
								<option value="Template - Usulan">Template - Usulan</option>
								<option value="Template - Kemajuan">Template - Laporan Kemajuan</option>
								<option value="Template - Akhir">Template - Laporan Akhir</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="lppmdok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="lppmdok" cols="10" class="form-control">
								<option value="Pedoman">Pedoman</option>
								<option value="SOP">SOP</option>
								<option value="Kebijakan">Kebijakan</option>
								<option value="Sentra HKI">Sentra HKI</option>
								<option value="Unjaya Press">Unjaya Press</option>
								<option value="Etik Penelitian">Etik Penelitian</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<textarea name="keterangan" cols="10" class="form-control" placeholder="Keterangan File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">File</label>
						<div class="col-sm-10">
						<input type="file" name="dokumen" class="form-control" placeholder="Upload Dokumen"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
		</form>
	</div>
</div>
</div>

<!-- modal edit dokumen -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'dokumen/update'; ?>" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Judul</label>
						<div class="col-sm-10">
							<input type="hidden" name="id" id="id_file">
							<textarea name="judul" id="judul" cols="10" class="form-control" placeholder="Judul File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis Dokumen</label>
						<div class="col-sm-10">
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio4" value="Penelitian" onClick="toggleKate();" />
							  <label class="form-check-label" for="inlineRadio4">Penelitian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio5" value="Pengabdian" onClick="etoggleKate();" />
							  <label class="form-check-label" for="inlineRadio5">Pengabdian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio6" value="Dokumen LPPM" onClick="etoggleLppm();" />
							  <label class="form-check-label" for="inlineRadio6">Dokumen LPPM</label>
							</div>
						</div>
					</div>
					<div class="form-group row" id="ekatedok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="katedok" cols="10" class="form-control">
								<option value="Surat Tugas">Surat Tugas</option>
								<option value="Surat Kontrak">Surat Kontrak</option>
								<option value="Ijin Penelitian">Ijin Penelitian</option>
								<option value="Template - Usulan">Template - Usulan</option>
								<option value="Template - Kemajuan">Template - Laporan Kemajuan</option>
								<option value="Template - Akhir">Template - Laporan Akhir</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="elppmdok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="lppmdok" id="ekatedok" cols="10" class="form-control">
								<option value="Pedoman">Pedoman</option>
								<option value="SOP">SOP</option>
								<option value="Kebijakan">Kebijakan</option>
								<option value="Sentra HKI">Sentra HKI</option>
								<option value="Unjaya Press">Unjaya Press</option>
								<option value="Etik Penelitian">Etik Penelitian</option>
								<option value="Lain-Lain">Lain-Lain</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<textarea name="keterangan" id="keterangan" cols="10" class="form-control" placeholder="Keterangan File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">File</label>
						<div class="col-sm-10">
						<input type="file" name="dokumen" class="form-control" placeholder="Upload Dokumen"></textarea>
						<br><p id="filenya"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-success">Simpan</button>
			</div>
		</form>
	</div>
</div>
</div>

<script>
	$(function () {
		$('#edit-modal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var company = button.data('dok'); // Extract info from data-* attributes
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			var modal = $(this);
			var pisah = company.split(',');
			document.getElementById("id_file").value = pisah[0];
			modal.find('#judul').text(pisah[1]);
			modal.find('#keterangan').text(pisah[2]);
			modal.find('#filenya').text(pisah[3]);
			modal.find('#ekatedok').val(pisah[4]);
		});
	});
	
	
	$(".hapus").click(function(){
		var id = $(this).data('id');
		bootbox.confirm({
			title: "Hapus Data?",
			message: "Anda Yakin Ingin Menghapus Data Sekarang? Setelah Hapus, Data Tidak Dapat Diperbaiki.",
			closeButton: false,
			buttons: {
				cancel: {
					label: '<i class="fa fa-times"></i> Batal'
				},
				confirm: {
					label: '<i class="fa fa-check"></i> Hapus'
				}
			},
			callback: function (result)
			{
				if(result)
				window.location = "<?php echo base_url();?>dokumen/hapus/" + id ;
			}
		})
	});
	
	$(document).ready(function () {
		$('#dataTable').DataTable({
			"ordering": false // false to disable sorting (or any other option)
		});
		$('.dataTables_length').addClass('bs-select');
	});

	var s = document.getElementById("katedok");               // Show katedok
	var h = document.getElementById("lppmdok");               // Hide lppmdok

	function toggleKate() {
	    h.style.display = 'none';
	    s.style.display = '';
	}

	function toggleLppm() {
	    s.style.display = 'none';
	    h.style.display = '';
	}

	var es = document.getElementById("ekatedok");               // Show katedok
	var eh = document.getElementById("elppmdok");               // Hide lppmdok

	function etoggleKate() {
	    eh.style.display = 'none';
	    es.style.display = '';
	}

	function etoggleLppm() {
	    es.style.display = 'none';
	    eh.style.display = '';
	}
</script>	