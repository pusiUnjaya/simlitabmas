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
						  <th>Akhir Kontrak</th>
						  <th>SKep Kontrak</th>
						  <th>Aksi</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							foreach($terbit as $p)
							{
								//echo "<tr";
								echo "<td>".$p->tahun."</td>";
								echo "<td>".$p->jenis."</td>";
								echo "<td>".$p->semester."</td>";
								echo "<td>".$p->surat_tugas."</td>";
								echo "<td>".$p->surat_kontrak."</td>";
								echo "<td>".$p->akhirkontrak."</td>";
								echo "<td>".$p->skepkontrak."</td>";
								echo "<td align='center'>";
								/*if($p->status==0)
										echo '<a href="'.base_url().'surat/pakaidasar/'.$p->iddasar.'" class="btn btn-secondary" title="Pakai Dasar Hukum"><i class="fas fa-window-close fa-sm"></i> nonaktif</a>';
								else
										echo '<a href="'.base_url().'surat/tidakdasar/'.$p->iddasar.'" class="btn btn-success" title="Pakai Dasar Hukum"><i class="fas fa-check fa-sm"></i> aktif</a>';
								echo "</td>
										  <td align='center'><a href='".base_url()."surat/editdasar/".$p->iddasar."' class='btn btn-warning' title='Edit Dasar Hukum'><i class='fas fa-edit fa-sm'></i></a>
										  	<a href='#' data-id='".$p->iddasar."' class='btn btn-danger hapus' title='Hapus Dasar Hukum'><i class='fas fa-trash fa-sm'></i></a>
										  </td>
										</tr>";*/
								echo " <a href='".base_url()."surat/editterbit/".$p->idsurat."' class='btn btn-warning' title='Edit Tanggal'><i class='fas fa-edit fa-sm'></i></a>
									   <a href='#' data-id='".$p->idsurat."' class='btn btn-danger hapus' title='Hapus Tanggal'><i class='fas fa-trash fa-sm'></i></a>
										  </td>
										</tr>";
								//echo "</td></tr>";		
							}
						?>	
					  </tbody>
					</table>
				  </div>
				</div>
				</div>
</div>

<!-- Modal Edit Surat -->
<div class="modal fade" id="surat-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'surat/simpanterbit'; ?>" enctype="multipart/form-data">
			<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Tahun :</label>
			<div class="col-sm-7">
			  <input type="hidden" name="idsurat" id="idsurat">
			  <input type="text" name="tahun" class="form-control" id="tahun">
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Surat Tugas :</label>
			<div class="col-sm-7">
			<input type="date" name="surattugas" class="form-control" id="surattugas">
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Surat Kontrak :</label>
			<div class="col-sm-7">
			<input type="date" name="suratkontrak" class="form-control" id="suratkontrak">
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Akhir Kontrak :</label>
			<div class="col-sm-7">
			<input type="date" name="akhirkontrak" class="form-control" id="akhirkontrak">
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">S.Kep Kontrak :</label>
			<div class="col-sm-7">
			<input type="text" name="skepkontrak" class="form-control" id="skepkontrak">
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Jenis Kontrak :</label>
			<div class="col-sm-7">
			<select name="jenis" id="jenis" class="form-control">
				<option value="1">Penelitian</option>
				<option value="2">Pengabdian</option>
			</select>
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Pelaksanaan Semester :</label>
			<div class="col-sm-7">
			<select name="jenis" id="jenis" class="form-control">
				<option value="1">Ganjil</option>
				<option value="2">Genap</option>
			</select>
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