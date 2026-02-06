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
		$romap = $this->mroadmap->rmprodi();
		// echo $this->db->last_query();exit;
		$hitrom = count($romap);
		if($this->session->userdata('sesi_status')=='2')
		{
			if($hitprodi==0 && $hitdosen==0)
			{
				echo '<div class="alert alert-danger" role="alert">
				Anda Belum Mengunggah Roadmap Prodi dan Dosen
				</div>';
			}
			elseif($hitprodi==1 && $hitdosen==0)
			{
				echo '<div class="alert alert-danger" role="alert">
				Anda Belum Mengunggah Roadmap Dosen
				</div>';
			}
			elseif(($hitprodi==0 && $hitrom==0) && $hitdosen==1)
			{
				echo '<div class="alert alert-danger" role="alert">
				Anda Belum Mengunggah Roadmap Prodi
				</div>';
			}
			elseif(($hitprodi>0 || $hitrom>0) && $hitdosen>1)
			{
				echo '<div class="alert alert-success" role="alert">
				Anda Sudah Mengunggah Roadmap Prodi dan Dosen
				</div>';
			}
			else
			{
				echo '<div class="alert alert-danger" role="alert">
				Anda Belum Mengunggah Roadmap Prodi dan Dosen
				</div>';
			}
		}
		
		if($this->session->userdata('sesi_status')=='3')
		{
			if($hitdosen==0)
			{
				echo '<div class="alert alert-danger" role="alert">
				Anda Belum Mengunggah Roadmap Dosen
				</div>';
			}
			else
			{
				echo '<div class="alert alert-success" role="alert">
				Anda Sudah Mengunggah Roadmap Dosen
				</div>';
			}
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
							<th width="30%">Jenis Roadmap</th>
							<th>File Dokumen</th>
							<th>Status</th>
							<th>Update Terakhir</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$hitrm = $this->mroadmap->hitroadmapprodi();
							if($this->session->userdata('sesi_jenis')==3 || $hitrm==0)
							{
								$rm = $this->mroadmap->rmprodi();
								foreach($rm as $p)
								{
									echo "<tr>
									<td>".$p->jenis."</td>
									<td><a href='".base_url().'assets/uploadbox/'.$p->file."' target='_blank'>Download</a></td>
									<td>";
									if($p->verifikasi==1)
										echo 'Terverifikasi';
									else
										echo 'Belum Terverifikasi';
									echo "</td>
									<td width='25%'>".tgl_indo($p->modified,1)."</td>
									<td width='10%'>";
									if($p->verifikasi==0)
									{
									echo "<a href='#' data-toggle='modal' data-target='#edit-modal' data-dok='".$p->idroadmap.",".$p->jenis.",".$p->file."' class='shadow-sm' title='Edit File'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
									<a href='#' data-id='".$p->idroadmap."' rel='tooltip' data-placement='top' title='Hapus Dokumen' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a>";
									}
									echo "</td>
									</tr>";
								}
							}
							foreach($roadmap as $p)
							{
								echo "<tr>
								<td>".$p->jenis."</td>
								<td><a href='".base_url().'assets/uploadbox/'.$p->file."' target='_blank'>Download</a></td>
								<td>";
								if($p->verifikasi==1)
									echo 'Terverifikasi';
								else
									echo 'Belum Terverifikasi';
								echo "</td>
								<td width='25%'>".tgl_indo($p->modified,1)."</td>
								<td width='10%'>";
								if($p->verifikasi==0)
								{
								echo "<a href='#' data-toggle='modal' data-target='#edit-modal' data-dok='".$p->idroadmap.",".$p->jenis.",".$p->file."' class='shadow-sm' title='Edit File'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
								<a href='#' data-id='".$p->idroadmap."' rel='tooltip' data-placement='top' title='Hapus Dokumen' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a>";
								}
								echo "</td>
								</tr>";
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Data Roadmap Dosen Prodi -->
	<?php if($this->session->userdata('sesi_status')=='2') { ?>
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Roadmap Dosen Prodi</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="40%">Nama Dosen</th>
							<th>Status</th>
							<th>Dokumen</th>
							<th>Verifikasi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// foreach($roadmapdosen as $p)
							// {
							// 	$dosen = $this->mdosen->namadosennya($p->user);
							// 	echo "<tr>
							// 	<td>".$dosen['namalengkap']."</td>
							// 	<td><a href='".base_url().'assets/uploadbox/'.$p->file."'>Download</a></td>
							// 	<td width='25%'>".tgl_indo($p->modified,1)."</td>
							// 	<td width='10%'>";
							// 	if($p->verifikasi==0)
							// 	{
							// 		echo "<a href='".base_url()."roadmap/verifikasi/".$p->idroadmap."' class='btn btn-success btn-icon-split' title='Verifikasi'><span class='icon text-white-50'>
							// 		<i class='fas fa-check'></i>
							// 		</span>
							// 		<span class='text'>Verifikasi</span></a>";
							// 	}
							// 	else
							// 	{
							// 		echo "<a href='#' class='btn btn-secondary btn-icon-split' title='Verifikasi'><span class='icon text-white-50'>
							// 		<i class='fas fa-check'></i>
							// 		</span>
							// 		<span class='text'>TerVerifikasi</span></a>";
							// 	}
							// 	echo "</td></tr>";
							// }
							$prodi = $this->mroadmap->namadosen($this->session->userdata('sesi_prodi'));
							$no = 1;
							foreach($prodi as $d)
							{
								// if(($d->jenis<>'Roadmap Prodi' && $d->jenis<>'') || $d->prodi==$this->uri->segment(3))
								$dok = $this->mroadmap->dokumen($d->user);
								$hitdok = $this->mroadmap->hitdokumen($d->user);
								// echo $this->db->last_query();exit;
								if($hitdok>0)
								{
									foreach($dok as $p)
									{
										echo '<tr>
											<td>'.$no.'</td>
											<td>'.$d->namadosen.'</td>
											<td>';
										if($p->verifikasi==1 && $p->jenis=='Roadmap Dosen')
											echo 'Terverifikasi';
										else
											echo 'Belum Terverifikasi';
										echo '</td><td>';
										
										if($p->file<>'' && $p->jenis=='Roadmap Dosen')
											echo '<a target="_blank" href="'.base_url().'assets/uploadbox/'.$p->file.'">Download</a>';
										else
											echo 'Belum Upload';
										echo '</td><td>';
										if($p->verifikasi==0)
										{
											echo "<a href='".base_url()."roadmap/verifikasi/".$p->idroadmap."' class='btn btn-warning btn-icon-split' title='Verifikasi'><span class='icon text-white-50'>
											<i class='fas fa-check'></i>
											</span>
											<span class='text'>Verifikasi</span></a>";
										}
										else
										{
											echo "<a href='#' class='btn btn-success btn-icon-split' title='Verifikasi'><span class='icon text-white-50'>
											<i class='fas fa-check'></i>
											</span>
											<span class='text'>TerVerifikasi</span></a>";
										}
										echo '</td></tr>';
										$no++;
									}
								}
								else
								{
									echo '<tr>
										<td>'.$no.'</td>
										<td>'.$d->namadosen.'</td>
										<td>';
									echo 'Belum Terverifikasi';
									echo '</td><td>';
									echo 'Belum Upload';
									echo '</td><td></td></tr>';
									$no++;
								}
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php } ?>
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
						<label class="col-sm-4 col-form-label">Jenis Roadmap</label>
						<div class="col-sm-8">
							<select name="jenis" class="form-control">
								<?php
									if($this->session->userdata('sesi_status')==2)
									$jenis = array('Roadmap Prodi','Roadmap Dosen');
									else
									$jenis = array('Roadmap Dosen');
									
									$n = count($jenis);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">File</label>
						<div class="col-sm-8">
						<input type="file" name="dokumen" class="form-control unggah" placeholder="Upload Dokumen"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-success tmbsimpan">Simpan</button>
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
						<label class="col-sm-2 col-form-label">Jenis Roadmap</label>
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
				<button type="submit" class="btn btn-success tmbsimpan">Simpan</button>
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
				window.location = "<?php echo base_url();?>roadmap/hapus/" + id ;
			}
		})
	});
	
	$(document).ready(function () {
		$('#dataTable').DataTable({
			"ordering": false // false to disable sorting (or any other option)
		});
		$('.dataTables_length').addClass('bs-select');
	});
	
	$('.unggah').bind('change', function() {
			var ukuran = this.files[0].size/1024/1024;
			fileName = document.querySelector('.unggah').value;
			regex = new RegExp('[^.]+$');
			extension = fileName.match(regex);
			if(ukuran>10)
			{
				alert('Ukuran File Lebih dari batas maksimal 10MB: ' + ukuran.toFixed(2) + "MB");
				$(".tmbsimpan").attr('disabled', true);
			}
			else
			{
				$(".tmbsimpan").attr('disabled', false);
			}
			if(extension!='pdf'){
				alert('Silakan upload file yang memiliki ekstensi .pdf ');
				$(".tmbsimpan").attr('disabled', true);
				return false;
			}
			else
			{
				$(".tmbsimpan").attr('disabled', false);
			}
		});
</script>	