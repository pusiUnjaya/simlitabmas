<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dokumen Klinik Proposal Pengabdian</h1>
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
			<h6 class="m-0 font-weight-bold text-primary">Daftar Klinik Proposal Pengabdian <?php echo $namaprodi['prodi']; ?></h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="20%">Nama Dosen</th>
							<th width="40%">Judul Proposal</th>
							<th width="11%">Status Upload</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 1;
							foreach($prodi as $d)
							{
								if($d->jenis=='Pengabdian' || $d->jenis==null)
								{
									echo '<tr>
										<td>'.$no.'</td>
										<td>'.$d->namalengkap.'</td>
										<td>Judul : '.$d->judul.'
										<br>Skema : '.$d->skema.'
										<br>Anggota : ';
									$ambil = explode(',',$d->anggota);
									$hit = count($ambil);
									
									if($d->anggota<>'') 
									{
										echo '<ol>';
										for($i=0;$i<$hit;$i++)
										{
											$dosen = $this->mdosen->namadosen($ambil[$i]);
											echo '<li>'.$dosen['namalengkap'].'</li>';
										}
										echo '</ol>';
									}
									else
										echo 'Tidak Ada Anggota Dosen<br>'; 
									echo 'RAB : '.rupiah($d->rab);
									echo '</td><td>';
									if($d->dokumen<>'')
										echo '<a href="'.base_url().'assets/uploadbox/'.$d->dokumen.'" target="_blank">Download</a>';
									else
										echo 'Belum Upload';
									echo '</td></tr>';
									$no++;
								}
							}
						?>
					</tbody>
				</table>
			</div>
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