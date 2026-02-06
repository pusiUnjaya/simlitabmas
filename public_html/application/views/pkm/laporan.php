<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Laporan Akhir</h1>
		
	</div>
	<!-- Usulan Untuk direview -->
	<?php 
		$reviewer = $this->mdosen->lihatreviewer($this->session->userdata('sesi_id'));
		if($reviewer>0) {
		?>
		
		<div class="card shadow mb-4">
            <div class="card-header py-3">
				<div class="row">
					<div class="col-md-10">
						<h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Akhir PkM untuk DiReview</h6>
					</div>
					<div class="col-md-2 float-right">
						<form class="user" action="<?php echo base_url(); ?>pengabdian/laporan" method="post">
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
								<th>Data PkM</th>
								<th width="3%"></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$yes = $this->mpengabdian->cekreviewernya($this->session->userdata('sesi_id'));
								//echo $this->db->last_query();exit;
								$none = '';
								if($yes>0) 
								{
									$warna = '';
									$filelaporan = '';
									$sumber = '';
									$proposal = '';
									$n = 0;
									if($hitdireview>0)
									{
										foreach($direview as $p)
										{
											$namadosen = $this->mdosen->namadosen($p->pengusul);
											$prodi = $this->mdosen->namaprodi($p->prodi);
											$sudahlapor = $this->mpengabdian->sudahlaporan($p->id_usulan);
											$proposal = base_url()."assets/uploadbox/".$p->filerevisi;
											
											$namarev1 = '';
											$namarev2 = '';
											$boxrev = explode(',',$p->revnya);
											$iddosen = $this->mpengabdian->cekidrev($this->session->userdata('sesi_id'));
											$hitboxrev = count($boxrev);
											if($hitboxrev==1)
											{
												$namarev1 = $boxrev[0];
												$namarev2 = '';
											}
											elseif($hitboxrev==2)
											{
												$namarev1 = $boxrev[0];
												$namarev2 = $boxrev[1];
											}
											else
											{
												$namarev1 = '';
												$namarev2 = '';
											}
											
											if($iddosen['id_dosen']==$namarev1 || $iddosen['id_dosen']==$namarev2){
												if($sudahlapor > 0)
												{
													$warna = "class='table-success'";
													$ceklaporan = $this->mpengabdian->liatfilelaporan($p->id_usulan);
													if($ceklaporan['file_laporan_akhir']=='' && $ceklaporan['file_revisi']=='')
													{
														$filelaporan = $ceklaporan['file_laporan'];
														$step = '(awal)';
													}
													elseif($ceklaporan['file_laporan_akhir']=='' && $ceklaporan['file_revisi']<>'')
													{
														$filelaporan = $ceklaporan['file_revisi'];
														$step = '(revisi)';
													}
													else
													{
														$filelaporan = $ceklaporan['file_laporan_akhir'];
														$step = '(pengesahan)';
													}
													$upload = "Sudah Upload, <a href='".base_url()."assets/uploadbox/".$filelaporan."' target='_blank'>Lihat Laporan Akhir ".$step."</a>";
													$sumber = base_url()."assets/uploadbox/".$upload;
												}
												else
												{
													$warna = '';
													$upload = 'Belum Pernah Upload File';
													$sumber = '';
												}
												
												
												$ketua = $this->mdosen->dosennya($p->pengusul);
												
												echo "<tr ".$warna.">
												<td>".ucwords(strtolower($p->judul))." (".date('Y',strtotime($p->tglmulai)).")";
												echo "<br><b>Status Laporan : ".$upload."</b>
												<br><b>Semester Pelaksanaan : ".$p->semester."</b>
												<br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
												<br>Anggota : ";
												$pisah = explode(',',$p->anggotadosen);
												$hitpisah = count($pisah);
												if($p->anggotadosen<>'')
												{
													echo '<ol>';
													for($i=0;$i<$hitpisah;$i++)
													{
														$revnya = $this->mdosen->namadosen($pisah[$i]);
														echo '<li>'.$revnya['namalengkap'].'</li>';
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
													$total = $this->mpengabdian->totalrab($p->id_usulan);
													echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
												}
												
												if($p->status=='Laporan Disetujui Reviewer')
													echo '<br><b>Sudah disetujui oleh : </b>';
												else
													echo "<br><b>Sudah direview oleh : </b>";
												$sudah = $this->mpengabdian->lapdireviewoleh($p->id_usulan);
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
												
												echo "<a href='".base_url()."pengabdian/detaillaporan/".$p->id_usulan."' class='shadow-sm' title='Proses Laporan Akhir'><i class='fas fa-archive fa-sm'></i></a>";
												
												echo "</td></tr>";
												reset($boxrev);
												$none = '';
												$n++;
											}
											else
											{
												if($n==0)
												$none = '<tr><td colspan="5" align="center">Data Tidak Ditemukan...</td></tr>';
											}						
										}
									}
									else
									{
										$none = '<tr><td colspan="5" align="center">Data Tidak Ditemukan...</td></tr>';
									}
									
								}
								
								else
								{
									echo '<tr><td colspan="4" align="center">Tidak Ada Laporan yang perlu direview</td></tr>';
								}
								echo $none;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } ?>
	
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<div class="row">
				<div class="col-md-10">
					<h6 class="m-0 font-weight-bold text-primary">Laporan Akhir PkM</h6>
				</div>
				<?php
					if($this->session->userdata('sesi_status')<>'') {
					?>
					<div class="col-md-2 float-right">
						<form class="user" action="<?php echo base_url(); ?>pengabdian/laporan" method="post">
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
				<?php } ?>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Data PkM</th>
							<th width="3%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$warna = '';
							$filelaporan = '';
							$sumber = '';
							$proposal = '';
							foreach($usulan as $p)
							{
								$namadosen = $this->mdosen->namadosen($p->pengusul);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								$sudahlapor = $this->mpengabdian->sudahlaporan($p->id_usulan);
								$proposal = base_url()."assets/uploadbox/".$p->filerevisi;
								
								if($sudahlapor > 0)
								{
									$warna = "class='table-success'";
									$ceklaporan = $this->mpengabdian->liatfilelaporan($p->id_usulan);
									if($ceklaporan['file_laporan_akhir']=='' && $ceklaporan['file_revisi']=='')
									{
										$filelaporan = $ceklaporan['file_laporan'];
										$step = '(awal)';
									}
									elseif($ceklaporan['file_laporan_akhir']=='' && $ceklaporan['file_revisi']<>'')
									{
										$filelaporan = $ceklaporan['file_revisi'];
										$step = '(revisi)';
									}
									else
									{
										$filelaporan = $ceklaporan['file_laporan_akhir'];
										$step = '(pengesahan)';
									}
									$upload = "Sudah Upload, <a href='".base_url()."assets/uploadbox/".$filelaporan."' target='_blank'>Lihat Laporan Akhir ".$step."</a>";
									$sumber = base_url()."assets/uploadbox/".$upload;
								}
								else
								{
									$warna = '';
									$upload = 'Belum Pernah Upload File';
									$sumber = '';
								}
								
								
								$ketua = $this->mdosen->dosennya($p->pengusul);
								
								echo "<tr ".$warna.">
								<td>".ucwords(strtolower($p->judul))." (".date('Y',strtotime($p->tglmulai)).")";
								echo "<br><b>Status Laporan : ".$upload."</b>";
								echo "<br><b>Semester Pelaksanaan : ".$p->semester."</b>
								<br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
								<br>Anggota : ";
								$pisah = explode(',',$p->anggotadosen);
								$hitpisah = count($pisah);
								if($p->anggotadosen<>'')
								{
									echo '<ol>';
									for($i=0;$i<$hitpisah;$i++)
									{
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										echo '<li>'.$revnya['namalengkap'].'</li>';
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
									$total = $this->mpengabdian->totalrab($p->id_usulan);
									echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
								}
								
								if($p->status=='Laporan Disetujui Reviewer')
									echo '<br><b>Sudah disetujui oleh : </b>';
								else
									echo "<br><b>Sudah direview oleh : </b>";
								$sudah = $this->mpengabdian->lapdireviewoleh($p->id_usulan);
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
								
								echo "<a href='".base_url()."pengabdian/detaillaporan/".$p->id_usulan."' class='shadow-sm' title='Proses Laporan Akhir'><i class='fas fa-archive fa-sm'></i></a>";
								
								echo "</td></tr>";
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>