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
		  <div class="row">
				<div class="col-md-10">
					<h6 class="m-0 font-weight-bold text-primary">Statistik Kinerja Dosen Prodi <?php echo $namaprodi['prodi']; ?></h6>
				</div>
				<div class="col-md-2 float-right">
					<form class="user" action="<?php echo base_url()."rekap/statprodi/".$this->uri->segment(3);?>" method="post">
						<select name="periode" class="form-control" onchange="this.form.submit()" style="margin-top:-7px">
						<?php
							$tahun = 2018;
							$aktif = date('Y');
							$selisih = $aktif - $tahun;
							
							if($this->input->post('periode')=='')
								$pilih = date('Y');
							else
								$pilih = $this->input->post('periode');
							for($i=0;$i<=$selisih;$i++)
							{
								if($pilih==($aktif-$i))
									echo '<option value="'.($aktif-$i).'" selected>'.($aktif-$i).'</option>';
								else
									echo '<option value="'.($aktif-$i).'">'.($aktif-$i).'</option>';
							}
						?>
					</select>
					</form>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">Nama Dosen</th>
							<th colspan="2">Penelitian</th>
							<th colspan="2">Pengabdian</th>
						</tr>
							<tr>
								<th>Ketua</th>
								<th>Anggota</th>
								<th>Ketua</th>
								<th>Anggota</th>
							</tr>
					</thead>
					<tbody>
						<?php
							$no = 1;
							foreach($namadosen as $d)
							{
								$jmlketuariset = 0;
								$jmlanggotariset = 0;
								$jmlketuapkm = 0;
								$jmlanggotapkm = 0;
								$judulriset = [];
								
								foreach($usulan as $u)
								{
									$list = explode(',',$u->anggotadosen);
									if($d->user==$u->user)
										$jmlketuariset++;
									if(in_array($d->id_dosen,$list))
									{
										$jmlanggotariset++;
										array_push($judulriset,$u->judul);
									}
								}
								foreach($abdi as $a)
								{
									$list = explode(',',$a->anggotadosen);
									if($d->user==$a->user)
										$jmlketuapkm++;
									if(in_array($d->id_dosen,$list))
										$jmlanggotapkm++;
								}
								
								echo '<tr>
									<td>'.$no.'</td>
									<td>'.$d->namadosen.'</td>';
								
								echo '<td><a href="'.base_url().'rekap/detailrisetdosen/ketua/'.$d->user.'/'.$pilih.'">'.$jmlketuariset.'</a></td>';
								echo '<td><a href="'.base_url().'rekap/detailrisetdosen/anggota/'.$d->id_dosen.'/'.$pilih.'">'.$jmlanggotariset.'</a><br>';
								// print_r($judulriset);
								echo '</td>';
								echo '<td><a href="'.base_url().'rekap/detailpkmdosen/ketua/'.$d->user.'/'.$pilih.'">'.$jmlketuapkm.'</a></td>';
								echo '<td><a href="'.base_url().'rekap/detailpkmdosen/anggota/'.$d->id_dosen.'/'.$pilih.'">'.$jmlanggotapkm.'</a></td>';
								echo '</tr>';
								$no++;
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