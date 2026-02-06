<?php
	if($this->session->userdata('sesi_user')=='')
	{
		header('location:'.base_url().'login');
	}
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Usulan Baru</h1>
      <?php
      	//cek skema
      	$skema = array();
      	if(($this->session->userdata('sesi_jafung')=='Tenaga Pengajar' || $this->session->userdata('sesi_jafung')=='Asisten Ahli') && $this->session->userdata('sesi_sinta')>=0 && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					// echo '<li>Riset Pemula (RisLa)</li>';
					array_push($skema,'Riset Pemula (RisLa)');
				}
				if(($this->session->userdata('sesi_jafung')=='Asisten Ahli' || $this->session->userdata('sesi_jafung')=='Lektor') && ($this->session->userdata('sesi_sinta')>=25) && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					// echo '<li>Riset Fundamental (RisFun)</li>';
					array_push($skema,'Riset Fundamental (RisFun)');
				}
				if(($this->session->userdata('sesi_jafung')=='Lektor' || $this->session->userdata('sesi_jafung')=='Lektor Kepala' || $this->session->userdata('sesi_jafung')=='Profesor') && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					//echo '<li>Riset Kejuangan (RisJuang)</li>';
					array_push($skema,'Riset Kejuangan (RisJuang)');
				}
				if(($this->session->userdata('sesi_jafung')=='Lektor' || $this->session->userdata('sesi_jafung')=='Lektor Kepala' || $this->session->userdata('sesi_jafung')=='Profesor') && ($this->session->userdata('sesi_sinta')>=50) && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					// echo '<li>Riset Kerjasama (RisKer)</li>';
					array_push($skema,'Riset Kerjasama (RisKer)');
				}
				//skema terapan
				if(($this->session->userdata('sesi_jafung')=='Lektor' || $this->session->userdata('sesi_jafung')=='Lektor Kepala' || $this->session->userdata('sesi_jafung')=='Profesor') && (($this->session->userdata('sesi_fakultas')<>3 && $this->session->userdata('sesi_sinta')>=150) || ($this->session->userdata('sesi_fakultas')==3 && $this->session->userdata('sesi_sinta')>=50)) && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					// echo '<li>Riset Terapan Hilirisasi (Risterasi)</li>';
					array_push($skema,'Riset Terapan Hilirisasi (Risterasi)');
				}
				if(($this->session->userdata('sesi_jafung')=='Asisten Ahli' || $this->session->userdata('sesi_jafung')=='Lektor' || $this->session->userdata('sesi_jafung')=='Lektor Kepala' || $this->session->userdata('sesi_jafung')=='Profesor') && (($this->session->userdata('sesi_fakultas')<>3 && $this->session->userdata('sesi_sinta')>=100) || ($this->session->userdata('sesi_fakultas')==3 && $this->session->userdata('sesi_sinta')>=50)) && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					// echo '<li>Riset Mandatory (RisMa)</li>';
					array_push($skema,'Riset Mandatory (RisMa)');
				}
				//skema pengembangan
				if(($this->session->userdata('sesi_jafung')=='Lektor' || $this->session->userdata('sesi_jafung')=='Lektor Kepala' || $this->session->userdata('sesi_jafung')=='Profesor') && (($this->session->userdata('sesi_fakultas')<>3 && $this->session->userdata('sesi_sinta')>=150) || ($this->session->userdata('sesi_fakultas')==3 && $this->session->userdata('sesi_sinta')>=50)) && ($this->session->userdata('sesi_jenjang')=='S2' || $this->session->userdata('sesi_jenjang')=='S3'))
				{
					// echo '<li>Riset Pengembangan (Risbang)</li>';
					array_push($skema,'Riset Pengembangan (Risbang)');
				}
				$hitskema = count($skema);
				$this->session->set_userdata('sesi_skema', $skema);

				$cek = $this->msubmit->cekbuka($this->session->userdata('sesi_id'));
				if(!$cek && $this->session->userdata('sesi_status')<>3)
					$cek['status'] = 0;
				// if($cek['status']==1) {
			?>
			<a href="<?php 
				$hitque = $this->msubmit->sudahisibelum();
				if($this->session->userdata('sesi_status')<>1 && $hitque==0 && $cekusulan==0)
					echo base_url().'kuesioner'; 
				elseif($cekusulan>=1)
					echo '';
				elseif($hitskema==0)
					echo '';
				else
					echo base_url().'submit/tambahusulan'; 
				?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Usulan</a>
			
				<?php// } ?>
          </div>
		  <?php
				if($this->session->flashdata('result')<>'')
				{
					echo '<div class="alert alert-success" role="alert">'.
						$this->session->flashdata('result').'
						</div>';
				}
				
				if($this->session->flashdata('error')<>'')
				{
					echo '<div class="alert alert-danger" role="alert">'.
						$this->session->flashdata('error').'
						</div>';
				}
				
				if($cekusulan>=1)
				{
					echo '<div class="alert alert-danger" role="alert">
						Dalam Tahun Aktif Hanya Boleh Mengusulkan Satu Usulan</div>';
				}
				?>
<div class="alert alert-info" role="alert">
						<b>Info Eligibilitas</b>
						<p>
							<?php
								echo 'Sinta Score Overall : <b>'.$this->session->userdata('sesi_sinta').'</b>';
								echo '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Jabatan Fungsional : <b>'.$this->session->userdata('sesi_jafung').'</b>';
								echo '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Jenjang Pendidikan : <b>'.$this->session->userdata('sesi_jenjang').'</b>';
								echo '<br>Berdasarkan eligibilitas yang tercantum, Anda dapat mengusulkan dengan Skema berikut : ';
								//skema penelitian dasar
								echo '<ol>';
								for($i=0;$i<$hitskema;$i++)
								{
									echo '<li>'.$skema[$i].'</li>';
								}
								echo '</ol>';
							?>
						</p>
			</div>
				<?php
				
				$yes = $this->mdosen->lihatreviewer($this->session->userdata('sesi_id'));
				if($this->session->userdata('sesi_status')<>1 && $yes>0) {
			?>
		  <!-- Usulan Untuk direview -->
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
					<div class="col-md-10">
						<h6 class="m-0 font-weight-bold text-primary">Daftar Usulan Penelitian untuk DiReview</h6>
					</div>
					<div class="col-md-2 float-right">
						<form class="user" action="<?php echo base_url(); ?>submit" method="post">
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
                      <th>No</th>
                      <th>Data Penelitian</th>
					  <th width="10%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$sudah = '';
						$no = 1;
						if($hit>0) {
						foreach($review as $p)
						{
							$total = $this->msubmit->totalrab($p->id_usulan);
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$cekreview = $this->msubmit->cekreview($this->session->userdata('sesi_id'),$p->id_usulan);
														
							if($cekreview>0)
								$sudah = "class='table-info'";
							else
								$sudah = '';
							if($p->status=='Reviewed')
							{
								$sudah = "class='table-warning'";
								$set = ' - Reviewed';
							}
							elseif($p->status=='Usulan Disetujui Reviewer 1')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui 1 Reviewer';
							}
							elseif($p->status=='Usulan Disetujui Reviewer 2')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui 2 Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer 1')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui 1 Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer 2')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui 2 Reviewer';
							}
							elseif($p->status=='Usulan Disetujui Prodi')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui Prodi';
							}
							elseif($p->status=='Usulan Baru' && $p->roadmap=='Tidak Sesuai')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan DiTolak dan Tidak Sesuai Roadmap Prodi';
							}
							elseif($p->status=='Usulan Disetujui Prodi' && $p->roadmap=='Sesuai')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan DiSetujui dan Sesuai dengan Roadmap Program Studi';
							}
							elseif($p->status=='Usulan Disetujui Prodi' && $p->roadmap=='Tidak Sesuai')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan DiSetujui Tapi Tidak Sesuai dengan Roadmap Program Studi';
							}
							elseif($p->status=='Usulan Tidak Disetujui')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui';
							}
							elseif($p->status=='Usulan Dikirim')
							{
								$sudah = "";
								$set = 'Usulan Dikirim';
							}
							else
							{
								$sudah = '';
								$set = 'Usulan Belum Dikirim';
							}
							
							$ketua = $this->mdosen->dosennya($p->pengusul);
								
								echo "<tr ".$sudah.">
										  <td>".$no."</td>
										  <td>".ucwords(strtolower($p->judul))." (".date('Y',strtotime($p->tglmulai)).")";
								echo "<br><b>Status : ".$set."</b>
										  <br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
										  <br>Anggota : ";
								$pisah = explode(',',$p->anggotadosen);
								$hitpisah = count($pisah);
								$hitangg = $this->msubmit->hitangg($p->id_usulan);
								
								if($p->anggotadosen<>'' && $hitangg==0)
								{
									echo '<ol>';
									for($i=0;$i<$hitpisah;$i++)
									{
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										echo '<li>'.$revnya['namalengkap'].'</li>';
									}
									echo '</ol>';
								}
								elseif($p->anggotadosen=='' && $hitangg>0)
								{
									$angg = $this->msubmit->perananggota($p->id_usulan,'Penelitian');
									$hits = count($angg);
									$num = 1;
									echo '<ol>';
									foreach($angg as $a)
									{
										if($hits==1)
											echo $a->namalengkap;
										else
										{
											echo '<li>'.$a->namalengkap.'</li>';
										}
									}
									echo '</ol>';
								}
								else
								{
									echo 'Tidak Ada<br>';
								}

								echo "RAB : ";
										  $prodinya = $this->mdosen->dosennya($p->pengusul);
									if($p->sumberdana=='Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0)
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah($p->totaldana);
									}
									else
									{
										$total = $this->msubmit->totalrab($p->id_usulan);
										echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
									}
										 
								echo "<br><b>Sudah direview oleh : </b>";
								$sudah = $this->msubmit->direviewoleh($p->id_usulan);
								// echo $this->db->last_query();exit;	
								$n = count($sudah);
								$i = 0;
								if($n>0)
								{
									foreach($sudah as $s)
									{
										echo '<b style="color:green">'.$s->namalengkap.'</b>';
										if($i<($n-1))
											echo ' dan ';
										$i++;
									}
								}
								else
									echo '<b style="color:red">-</b>';
								echo "</td><td>";
								if($p->status=='Usulan Baru')
								{
									  echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/rab/".$p->id_usulan."' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/edit/".$p->id_usulan."' class='shadow-sm' title='Edit Usulan'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
									  <a href='#' data-id='".$p->id_usulan."' class='shadow-sm hapus' title='Hapus Usulan'><i class='fas fa-trash fa-sm'></i></a>";
								}
								elseif($p->status=='Usulan Dikirim')
								{
									echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
								}
								else
								{
									echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
								}
									  echo "</td>
									</tr>";
								$no++;
						}
						}
						else {
							echo '<tr><td colspan="4" align="center">Data Tidak Ditemukan...</td></tr>';
						}
					?>	
                  </tbody>
                </table>
				
				<?php 
				  
				// Store the file name into variable 
				// $file = base_url().'assets/uploadbox/inii.doc'; 
				// $filename = 'iniitu.doc'; 
				  
				// // Header content type 
				// header('Content-type: application/pdf'); 
				  
				// header('Content-Disposition: inline; filename="' . $filename . '"'); 
				  
				// header('Content-Transfer-Encoding: binary'); 
				  
				// header('Accept-Ranges: bytes'); 
				  
				// // Read the file 
				// @readfile($file); 
				  
				?> 

              </div>
            </div>
          </div>
				<?php } ?>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan Penelitian</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
					<tr>
                      <th>No</th>
                      <th>Data Penelitian</th>
					  <th width="13%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						$set = '';
						
						$jmlanggota = 0;
						foreach($usulan as $p)
						{
							$jmldeal = 0;
							$total = $this->msubmit->totalrab($p->id_usulan);
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$deal = $this->msubmit->cekanggotasetuju($this->session->userdata('sesi_dosen'),$p->id_usulan);
							if($p->status=='Usulan Baru' && $p->roadmap=='' && $p->multi=='')
							{
								$cekrab = $this->msubmit->cekrab($p->id_usulan);
								if($this->session->userdata('sesi_id')<>$p->pengusul && $cekrab>0 && $deal==0)
								{
									$set = '<b style="color:red">Silakan Setujui Sebagai Anggota di Detail Usulan</b>';
								}
								elseif($this->session->userdata('sesi_id')==$p->pengusul && $cekrab>0 && $deal==0) { 
									$set = "Belum dikirim &nbsp;";
									  }
								elseif($this->session->userdata('sesi_id')==$p->pengusul && $cekrab==0 && $deal==0) { 
									$set = "Silakan Tambahkan RAB Penelitian &nbsp;";
									  }
								else {
									$set = '<b style="color:green">Anda telah Setuju Sebagai Anggota</b>';
								}
								$sudah = "class='table-danger'";
							}
							elseif($p->status=='Usulan Baru' && $p->roadmap=='Tidak Sesuai')
							{
								$sudah = "class='table-danger'";
								$set = "Usulan DiTolak dan Tidak Sesuai Roadmap Prodi &nbsp;<a href='#' data-idusul='".$p->id_usulan."' data-toggle='modal' data-target='#kirim-modal' type='button' class='btn btn-success px-3' title='Kirim Usulan'><i class='fas fa-upload fa-sm'></i>&nbsp;Kirim Usulan</a>";
							}
							elseif($p->status=='Usulan Disetujui Prodi' && $p->roadmap=='Sesuai')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan DiSetujui, Sesuai dengan Roadmap Program Studi dan Sudah Multi Disiplin Beda Prodi';
							}
							elseif($p->status=='DiTolak' && ($p->roadmap=='Tidak Sesuai' || $p->multi=='Belum') && $p->filerevisi_kaprodi<>'')
							{
								$sudah = "class='table-danger'";
								$set = "Usulan DiTolak karena".$p->roadmap."dengan Roadmap Program Studi dan ".$p->multi." Multi Disiplin Beda Prodi &nbsp;<a href='#' data-idusul='".$p->id_usulan."' data-toggle='modal' data-target='#kirim-modal' type='button' class='btn btn-success px-3' title='Kirim Usulan'><i class='fas fa-upload fa-sm'></i>&nbsp;Kirim Usulan</a>";
							}
							elseif($p->status=='DiTolak' && ($p->roadmap=='Tidak Sesuai' || $p->multi=='Belum') && $p->filerevisi_kaprodi=='')
							{
								$sudah = "class='table-danger'";
								$set = "Usulan DiTolak karena".$p->roadmap."dengan Roadmap Program Studi dan ".$p->multi." Multi Disiplin Beda Prodi &nbsp;<a href='#' data-idusul='".$p->id_usulan."' data-toggle='modal' data-target='#kirimrevisi-modal' type='button' class='btn btn-success px-3' title='Upload Revisi'><i class='fas fa-upload fa-sm'></i>&nbsp;Upload Revisi</a>";
							}
							elseif($p->status=='Reviewed')
							{
								$sudah = "class='table-warning'";
								$set = ' Reviewed';
							}
							elseif($p->status=='Usulan Disetujui Reviewer 1')
							{
								$sudah = "class='table-info'";
								$set = ' Usulan Disetujui 1 Reviewer';
							}
							elseif($p->status=='Usulan Disetujui Reviewer 2')
							{
								$sudah = "class='table-info'";
								$set = ' Usulan Disetujui 2 Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer 1')
							{
								$sudah = "class='table-info'";
								$set = ' Usulan Tidak Disetujui 1 Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer 2')
							{
								$sudah = "class='table-info'";
								$set = ' Usulan Tidak Disetujui 2 Reviewer';
							}
							elseif($p->status=='Usulan Disetujui')
							{
								$sudah = "class='table-success'";
								$set = ' Usulan Disetujui';
							}
							elseif($p->status=='Usulan Tidak Disetujui')
							{
								$sudah = "class='table-danger'";
								$set = ' Usulan Tidak Disetujui';
							}
							elseif($p->status=='Usulan Dikirim' && ($p->roadmap=='Tidak Sesuai' || $p->multi=='Belum'))
							{
								$sudah = "";
								$set = 'Revisi Usulan';
							}
							else
							{
								$sudah = '';
								$set = 'Sudah Dikirim';
							}
							
							$ketua = $this->mdosen->dosennya($p->pengusul);
								
								echo "<tr ".$sudah.">
										  <td>".$no."</td>
										  <td>".ucwords(strtolower($p->judul))." (".date('Y',strtotime($p->tglmulai)).")";
								echo "<br><b>Status : ".$set."</b>
										  <br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
										  <br>Anggota : ";
								$pisah = explode(',',$p->anggotadosen);
								if($p->anggotadosen<>'')
									$hitpisah = count($pisah);
								else
									$hitpisah = $this->msubmit->hitanggotabaru($p->id_usulan,'Penelitian');

								$jmlanggota = $hitpisah;
								$hitangg = $this->msubmit->hitanggotabaru($p->id_usulan,'Penelitian');
								if($p->anggotadosen<>'' && $hitangg==0)
								{
									echo '<ol>';
									$okedeal = 0;
									for($i=0;$i<$hitpisah;$i++)
									{
										$okdeal = $this->msubmit->cekanggotasetuju($pisah[$i],$p->id_usulan);
										
										if($okdeal>0)
										{
											$setok = 'Setuju';
											$jmldeal++;
										}
										else
											$setok = 'Belum Setuju';
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										echo '<li>'.$revnya['namalengkap'].' ('.$setok.')</li>';
									}
									echo '</ol>';
								}
								elseif($p->anggotadosen=='' && $hitangg>0)
								{
									$angg = $this->msubmit->perananggota($p->id_usulan,'Penelitian');
									$hits = count($angg);
									echo '<ol>';
									foreach($angg as $a)
									{
										$okdeal = $this->msubmit->cekanggotasetuju($a->id_dosen,$p->id_usulan);
										
										if($okdeal>0)
										{
											$setok = 'Setuju';
											$jmldeal++;
										}
										else
											$setok = 'Belum Setuju';

										if($hits==1)
											echo $a->namalengkap.' ('.$setok.')';
										else
										{
											echo '<li>'.$a->namalengkap.' ('.$setok.')</li>';
										}
									}
									echo '</ol>';
								}
								else
								{
									echo 'Tidak Ada<br>';
								}

								echo "RAB : ";
										  $prodinya = $this->mdosen->dosennya($p->pengusul);
									if($p->sumberdana=='Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0)
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo $total==''?(rupiah(0)):(rupiah($p->totaldana));
									}
									else
									{
										$total = $this->msubmit->totalrab($p->id_usulan);
										echo $total==''?(rupiah(0)):(rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']));
									}
										 
								echo "<br><b>Sudah direview oleh : </b>";
								$sudah = $this->msubmit->direviewoleh($p->id_usulan);
								// echo $this->db->last_query();exit;	
								$n = count($sudah);
								$i = 0;
								if($n>0)
								{
									foreach($sudah as $s)
									{
										echo '<b style="color:green">'.$s->namalengkap.'</b>';
										if($i<($n-1))
											echo ' dan ';
										$i++;
									}
								}
								else
									echo '<b style="color:red">-</b>';
								echo '<br>';
								
								if($this->session->userdata('sesi_id')==$p->pengusul && $jmldeal==$hitpisah && $p->status=='Usulan Baru')
									echo "<a href='#' data-idusul='".$p->id_usulan."' data-toggle='modal' data-target='#kirim-modal' type='button' class='btn btn-success px-3' title='Kirim Usulan'><i class='fas fa-upload fa-sm'></i>&nbsp;Kirim Usulan</a>";
								else
								{
									if($jmldeal<$hitpisah)
										echo '<b>Masih ada Anggota Dosen yang belum Menyetujui Keanggotaan</b>';
									else
										echo '';
								}
								
								echo "</td><td>";
								if($this->session->userdata('sesi_id')==$p->pengusul && $p->status=='Usulan Baru')
								{
									  echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/rab/".$p->id_usulan."' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/tkt/".$p->id_usulan."' class='shadow-sm' title='Hitung TKT'><i class='fas fa-tasks fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/edit/".$p->id_usulan."' class='shadow-sm' title='Edit Usulan'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
									  <a href='#' data-id='".$p->id_usulan."' class='shadow-sm hapus' title='Hapus Usulan'><i class='fas fa-trash fa-sm'></i></a>";
								}
								elseif($deal>1 && $p->status=='Usulan Baru')
								{
									  echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
								}
								elseif($p->status=='Usulan Dikirim')
								{
									echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
								}
								elseif($p->status=='Reviewed' || $p->status=='Usulan Disetujui Reviewer 1')
								{
									echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;";
									if($this->session->userdata('sesi_id')==$p->pengusul)
										echo "<a href='".base_url()."submit/rab/".$p->id_usulan."' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>";
								}
								else
								{
									echo "<a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
								}
									  echo "</td>
									</tr>";
							$no++;
						}
					?>	
                  </tbody>
                </table>
				
				<?php 
				  
				// Store the file name into variable 
				// $file = base_url().'assets/uploadbox/inii.doc'; 
				// $filename = 'iniitu.doc'; 
				  
				// // Header content type 
				// header('Content-type: application/pdf'); 
				  
				// header('Content-Disposition: inline; filename="' . $filename . '"'); 
				  
				// header('Content-Transfer-Encoding: binary'); 
				  
				// header('Accept-Ranges: bytes'); 
				  
				// // Read the file 
				// @readfile($file); 
				  
				?> 

              </div>
            </div>
          </div>
        </div>

<!-- Modal Kirim -->
<div class="modal fade" id="kirim-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'submit/kirim'; ?>" enctype="multipart/form-data">
		<input type="hidden" name="idusul" class="idusul">
        <p>Usulan tidak dapat diedit setelah terkirim, lanjutkan???</p>  
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-success">Kirim</button>
	  </div>
	  </form>
    </div>
  </div>
</div> 

<!-- Modal Revisi -->
<div class="modal fade" id="kirimrevisi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Revisi Usulan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'submit/simpanrevisikaprodi/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">File Revisi Usulan (PDF) maksimal 20Mb :</label>
			<input type="hidden" id="idrevusulan" name="id">
			<input type="file" id="filelegalisir" name="fileupload" class="form-control unggah" placeholder="File Revisi Usulan (PDF)">            
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
        $('#kirim-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('.idusul').attr("value",div.data('idusul'));
        });
    });
	
	$(document).ready(function() {
        // Untuk sunting
        $('#kirimrevisi-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#idrevusulan').attr("value",div.data('idusul'));
        });
    });
	
	$('.unggah').bind('change', function() {
			var ukuran = this.files[0].size/1024/1024;
			fileName = document.querySelector('.unggah').value;
			regex = new RegExp('[^.]+$');
			extension = fileName.match(regex);
			if(ukuran>20)
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			if(extension!='pdf')
			alert('Silakan upload file dengan ekstensi PDF!');
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
			window.location = "<?php echo base_url();?>submit/hapus/" + id ;
		}
	})
	});
</script>