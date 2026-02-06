<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dokumen Klinik Proposal</h1>
		<a type="button" href="<?php echo base_url().'klinik/uploadpenelitian';?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="nambah"><i class="fas fa-file fa-sm text-white-50"></i> Upload Proposal</a>
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
			<h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen Klinik Proposal Penelitian</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th width="50%">Judul</th>
							<th>File Dokumen</th>
							<th>Update Terakhir</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$n = 1;
							foreach($klinik as $k)
							{
								echo '<tr><td>'.$n.'</td>
								<td>';
									echo 'Judul : '.$k->judul;
									echo '<br>Skema : '.$k->skema;
									echo '<br>RAB : '.rupiah($k->rab);
								echo '</td>
								<td><a href="'.base_url().'assets/uploadbox/'.$k->dokumen.' " target="_blank">File Proposal</a></td>
								<td>'.tgl_indo($k->modified,2).'</td>
								<td>';
								echo "<a href='".base_url()."klinik/editpenelitian/".$k->idklinik."' class='shadow-sm' title='Edit Proposal'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
								<a href='#' data-id='".$k->idklinik."' class='shadow-sm hapus' title='Hapus Proposal'><i class='fas fa-trash fa-sm'></i></a>";
								echo '</td></tr>';
								$n++;
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
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
				window.location = "<?php echo base_url();?>klinik/hapuspenelitian/" + id ;
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