<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Validasi Kinerja Dosen - Prosiding</h1>
            
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
                      <th>Judul Makalah</th>
                      <th>Prosiding</th>
					  <th>Berkas Makalah</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Dosen</th>
                      <th>Judul Makalah</th>
                      <th>Prosiding</th>
					  <th>Berkas Makalah</th>
                    </tr>
                  </tfoot>
                  <tbody>
						<?php
						$no = 1;
						foreach($tambahan as $r)
						{
							echo '<tr>
								<td>'.$no.'</td>
								<td><b>'.$r->namalengkap;
							echo '</b><br>NIDN : '.$r->nidn;	
							echo '<br>Status : '.$r->statuspro;	
							echo '</td><td><b>'.ucwords(strtolower($r->judul)).'</b><br>Author Lain : <br>';
							$ambil = explode(',',$r->authorlain);
							$hit = count($ambil);
							
							if($r->authorlain<>'') 
							{
								for($i=0;$i<$hit;$i++)
								{
									$dosen = $this->mdosen->namadosen($ambil[$i]);
									echo $dosen['namalengkap'].'<br>';
								}
							}
							else
								echo 'Tidak Ada Author Lain';
							echo '<br>Sebagai Luaran : '.$r->sbgluaran;
							echo '</td>';
							echo '<td>';
								echo $r->nama_prosiding;
								echo '<br>ISBN/ISSN : '.$r->isbn_issn;
								echo '<br>Volume : '.$r->volume;
								echo '<br>Nomor : '.$r->nomor;
								echo '<br>Tahun : '.$r->tahun;
								echo '<br>Berkas Makalah : <a href="'.base_url().'assets/uploadbox/'.$r->file_prosiding.'" target="_blank" class="shadow-sm" title="Unduh File"> unduh di sini</a>';
							echo '</td>
								<td><a href="'.base_url().'validasi/updateprosiding/'.$r->id_prosiding.'" type="button" class="btn btn-success">validasi</a></td>
							</tr>';
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

<script>
	$(document).ready(function(){
	$("#fakultas").change(function (){
		var url = "<?php echo site_url('rekap/load_prodi');?>/"+$(this).val();
		$('#prodi').load(url);
		return false;
	});	
	});
</script>
