<div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Setting Tanggal Surat</h1>
			</div>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-md-12">
						  <h6 id="daftarpenelitian" class="m-0 font-weight-bold text-primary">Tanggal surat</h6>
						  <div class="col-sm-12 col-md-4 float-right" style="margin-top:-25px;margin-right: -200px;">
								  <a href="<?php echo base_url(); ?>surat/tambahtanggal" type="button" class="btn btn-primary"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
							</div>
						</div>
				</div>
				</div>
				<div class="card-body">
				  <div class="table-responsive">
					<table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Tahun</th>
						  <th>Jenis Aktivitas</th>
						  <th>Semester</th>
						  <th>Surat Tugas</th>
						  <th>Surat Kontrak</th>
						  <th>Aksi</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							foreach($dasar as $p)
							{
								echo "<td>".$p->teks."</td>";
								echo "<td>".$p->jenis."</td>";
								echo "<td>".$p->tahun."</td>";
								echo "<td>".$p->urutan."</td>";
								echo "<td align='center'>";
								if($p->status==0)
										echo '<a href="'.base_url().'surat/pakaidasar/'.$p->iddasar.'" class="btn btn-secondary" title="Pakai Dasar Hukum"><i class="fas fa-window-close fa-sm"></i> nonaktif</a>';
								else
										echo '<a href="'.base_url().'surat/tidakdasar/'.$p->iddasar.'" class="btn btn-success" title="Pakai Dasar Hukum"><i class="fas fa-check fa-sm"></i> aktif</a>';
								echo "</td>
										  <td align='center'><a href='".base_url()."surat/editdasar/".$p->iddasar."' class='btn btn-warning' title='Edit Dasar Hukum'><i class='fas fa-edit fa-sm'></i></a>
										  	<a href='#' data-id='".$p->iddasar."' class='btn btn-danger hapus' title='Hapus Dasar Hukum'><i class='fas fa-trash fa-sm'></i></a>
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

<script>
	$(document).ready(function () { 
		$('table.display').DataTable({
			 "order" : []
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
			window.location = "<?php echo base_url();?>surat/hapusdasar/" + id ;
		}
	})
	});
</script>