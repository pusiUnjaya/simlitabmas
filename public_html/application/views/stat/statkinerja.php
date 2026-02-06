<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Statistik Kinerja Dosen</h1>
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
			<h6 class="m-0 font-weight-bold text-primary">Statistik Kinerja Dosen</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="50%">Fakultas</th>
							<th width="50%">Program Studi</th>
						</tr>
					</thead>
					<tbody>
					<?php if(($this->session->userdata('sesi_wadek')==1 && $this->session->userdata('sesi_id')==109) || $this->session->userdata('sesi_status')==1){ ?>
						<tr>
							<td>Fakultas Teknik dan Teknologi Informasi</td>
							<td>
								<?php
									$prodi = $this->mroadmap->prodi(2);
									echo '<ol>';
									foreach($prodi as $d)
									{
										$jml = $this->mroadmap->jumlahdosen($d->id_prodi);
										if($d->prodi<>'Sistem Informasi (D-3)')
											echo '<li><a href="'.base_url().'rekap/statprodi/'.$d->id_prodi.'">'.$d->prodi.' - '.$jml.' Dosen</a></li>';
									}
									echo '</ol>';
								?>
							</td>
						</tr>
					<?php 
						} 
						if(($this->session->userdata('sesi_wadek')==1 && $this->session->userdata('sesi_id')==95) || $this->session->userdata('sesi_status')==1){
					?>
						<tr>
							<td>Fakultas Ekonomi dan Sosial</td>
							<td>
								<?php
									$prodi = $this->mroadmap->prodi(3);
									echo '<ol>';
									foreach($prodi as $d)
									{
										$jml = $this->mroadmap->jumlahdosen($d->id_prodi);
										echo '<li><a href="'.base_url().'rekap/statprodi/'.$d->id_prodi.'">'.$d->prodi.' - '.$jml.' Dosen</a></li>';
									}
									echo '</ol>';
								?>
							</td>
						</tr>
					<?php
						}
						if(($this->session->userdata('sesi_wadek')==1 && $this->session->userdata('sesi_id')==38) || $this->session->userdata('sesi_status')==1){
					?>
						<tr>
							<td>Fakultas Kesehatan</td>
							<td>
								<?php
									$prodi = $this->mroadmap->prodi(1);
									echo '<ol>';
									foreach($prodi as $d)
									{
										$jml = $this->mroadmap->jumlahdosen($d->id_prodi);
										echo '<li><a href="'.base_url().'rekap/statprodi/'.$d->id_prodi.'">'.$d->prodi.' - '.$jml.' Dosen</a></li>';
									}
									echo '</ol>';
								?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- modal tambah dokumen -->
<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Dokumen Roadmap</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'roadmap/simpan'; ?>" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Judul</label>
						<div class="col-sm-10">
							<textarea name="judul" cols="10" class="form-control" placeholder="Judul File"></textarea>
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
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'roadmap/update'; ?>" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Judul</label>
						<div class="col-sm-10">
							<input type="hidden" name="id" id="id_file">
							<textarea name="judul" id="judul" cols="10" class="form-control" placeholder="Judul File"></textarea>
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
</script>	