<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Validasi Kinerja Dosen - HKI</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Validasi Kinerja Dosen</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Dosen</th>
                      <th>Judul</th>
                      <th width="15%">HKI</th>
					  <th width="12%">Berkas HKI</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Dosen</th>
                      <th>Judul</th>
                      <th width="15%">HKI</th>
                      <th width="12%">Berkas HKI</th>
                    </tr>
                  </tfoot>
                  <tbody>
						<?php
					
						$no = 1;
						foreach($tambahan as $r)
						{
							if($r->catatan=='' && $r->validasi=='0')
								$warna = 'btn-success';
							else
								$warna = 'btn-danger';

							echo '<tr>
								<td>'.$no.'</td>
								<td>'.$r->namalengkap.'</td>
								<td>'.ucwords(strtolower($r->judul)).'
								<br>Sebagai Luaran : '.$r->sbgluaran.'
								<br>Berkas HKI : <a href="'.base_url().'assets/uploadbox/'.$r->file_hki.'" target="_blank" type="button" class="btn btn-info" title="Unduh File">unduh di sini</a>';
								if($r->catatan<>'' && $r->validasi==0)
										echo "<br><b style='color:red'>Catatan : ".$r->catatan."</b>";
								echo '</td>
								<td>';
								echo 'Jenis : '.$r->jenis_hki;
								echo '<br>Status : '.$r->status;
								echo '<br>No : '.$r->nomor_hki;
							echo "</td>
								<td><a href='#' data-usulan='".$r->id_hki."' data-catatan='".$r->catatan."' data-toggle='modal' data-target='#validasi-modal' type='button' class='btn ".$warna."'>validasi</a></td>
							</tr>";
							$no++;
						}
						
					
				  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>
        <!--</div> -->

<!-- Modal Validasi -->
<div class="modal fade" id="validasi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Validasi Jurnal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'validasi/updatehki'; ?>" enctype="multipart/form-data">
			<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Validasi :</label>
			<div class="col-sm-7">
			  <input type="hidden" name="usulan" id="usulan">
			  <select name="valid" class="form-control">
					<?php
						$jenis = array('DiTolak','DiTerima');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['validasi']==$i)
								echo '<option value="'.$i.'" selected>'.$jenis[$i].'</option>';
							else
								echo '<option value="'.$i.'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Catatan :</label>
			<div class="col-sm-7">
			<textarea name="catatan" class="form-control" id="catatan" placeholder="Catatan Penelitian Tambahan"></textarea>
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
	$(document).ready(function() {
        // Untuk sunting
        $('#validasi-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#usulan').attr("value",div.data('usulan'));
            modal.find('#catatan').val(div.data('catatan'));
        });
    });
</script>