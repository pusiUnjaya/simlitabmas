<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Validasi Kinerja Dosen - Karya</h1>
            
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
                      <th>Judul Naskah</th>
                      <th>Peruntukan</th>
					  <th>Berkas Naskah</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Dosen</th>
                      <th>Judul Naskah</th>
                      <th>Peruntukan</th>
					  <th>Berkas Karya</th>
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
							echo '</td><td><b>'.$r->deskripsi.'</b><br>Author Lain : <br>';
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
							
							echo '<br>URL : '.$r->url;
							echo '</td>';
							echo '<td>';
								echo 'Jenis Karya : '.$r->jenis_karya;
								echo '<br>Level Karya : '.$r->level_karya;
								echo '<br>Tahun Pelaksanaan : '.$r->tahun_pelaksanaan;
								echo '<br>Sebagai Luaran : '.$r->sbgluaran;
								echo '<br>Berkas Karya Monumental : <a href="'.base_url().'assets/uploadbox/'.$r->dokumen.'" target="_blank" class="shadow-sm" title="Unduh File"> unduh di sini</a>';
							echo '</td>
								<td><a href="'.base_url().'validasi/updatekarya/'.$r->id_karya.'" type="button" class="btn btn-success">validasi</a></td>
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
