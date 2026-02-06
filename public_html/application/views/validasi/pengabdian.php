<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Validasi Kinerja Dosen - Pengabdian</h1>
            
          </div>
          <!-- DataTales Example -->
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Validasi Kinerja Dosen</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" class="display" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>Pengabdian</th>
						  <th>Validasi</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
					
						$no = 1;
							$peranku = '';
							foreach($tambahan as $p)
							{
								$pisah = explode(',',$p->anggota);
								
								$dosen = $this->mdosen->dosennya($p->ketua);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								
								$ketua = $this->mdosen->namadosenprodi($p->ketua);
								$ambil = explode(',',$p->anggota);
								$hit = count($ambil);
								$anggota = '';
								
								if($p->anggota<>'') 
								{
									for($i=0;$i<$hit;$i++)
									{
										$dosen = $this->mdosen->namadosenprodi($ambil[$i]);
										$anggota.=$dosen['namalengkap'];
											if($i<($hit-1))
												$anggota .=', ';
									}
								}
								else
									$anggota = 'Tidak Ada Anggota Dosen'; 
								echo "<tr>
										  <td>".$no."</td>
										  <td>".ucwords(strtolower($p->judul))."
										  <br><b>Tahun : </b>".$p->tahun." | <b>Ketua :</b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
										  ".$p->sumberdana."
										  <br><b>Anggota : </b>".$anggota."
										  <br><b>Skema : ".$p->jenis."</b>";
									if($p->catatan<>'' && $p->validasi==0)
										echo "<br><b style='color:red'>Catatan : ".$p->catatan."</b>";
									
									echo "</td>
										  <td><a href='".base_url()."validasi/detailpengabdian/".$p->id_pengabdian."' type='button' class='btn btn-success'>validasi</a></td>
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

<script>
	$(document).ready(function(){
	$("#fakultas").change(function (){
		var url = "<?php echo site_url('rekap/load_prodi');?>/"+$(this).val();
		$('#prodi').load(url);
		return false;
	});	
	});
</script>
