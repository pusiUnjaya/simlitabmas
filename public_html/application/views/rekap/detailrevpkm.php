<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Judul Pengabdian yang Direview</h1>
            
          </div>
          <!-- DataTales Example -->
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Rekap Judul Pengabdian yang Direview</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" class="display" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>Pengabdian</th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th width="5%">No</th>
						  <th>Pengabdian</th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
					
						$no = 1;
							$peranku = '';
							foreach($review as $p)
							{
								$pisah = explode(',',$p->anggotadosen);
								$dosen = $this->mdosen->dosennya($p->pengusul);
								// $prodi = $this->mdosen->namaprodi($p->prodi);
								$splityear = explode('-',$p->tglmulai);
								$ketua = $this->mdosen->dosennya($p->pengusul);
								$ambil = explode(',',$p->anggotadosen);
								$hit = count($ambil);
								$anggota = '';
								
								if($p->anggotadosen<>'') 
								{
									for($i=0;$i<$hit;$i++)
									{
										$dosen = $this->mdosen->namadosen($ambil[$i]);
										$anggota.=$dosen['namalengkap'];
											if($i<($hit-1))
												$anggota .=', ';
									}
								}
								else
									$anggota = 'Tidak Ada Anggota Dosen';
								
								$unduhlaporan = '';
								$laporansah = '';
								
								echo "<tr>
										  <td>".$no."</td>
										  <td>".ucwords(strtolower($p->judul))."
										  <br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
										  ".$p->sumberdana."
										  <br><b>Anggota : </b>".$anggota."
										  <br><b>Skema : ".$p->skema."</b><br>";
										  if($this->session->userdata('fasenya')=='Laporan')
										  {
										  		if($p->file_revisi<>'')
														$unduhlaporan = $p->file_revisi;
													else
														$unduhlaporan = 'Belum Upload';
													
													if($p->file_laporan_akhir<>'')
														$laporansah = $p->file_laporan_akhir;
													else
														$laporansah = 'Belum Upload';
										  		echo "<b>File Laporan :</b><a href='".base_url()."assets/uploadbox/".$unduhlaporan."' target='_blank'> ".$unduhlaporan."</a>
													  <br><b>File Pengesahan :</b><a href='".base_url()."assets/uploadbox/".$laporansah."' target='_blank'> ".$laporansah."</a></td>
													</tr>";
											}
											else
											{
													if($p->filerevisi<>'')
														$unduhlaporan = $p->fileusulan;
													else
														$unduhlaporan = $p->filerevisi;

													echo "<b>File Usulan : </b><a href='".base_url()."assets/uploadbox/".$unduhlaporan."' target='_blank'>unduh di sini</a></td>
													</tr>";
											}
								$no++;
								
							}	
				  ?>
                  </tbody>
                </table>
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
