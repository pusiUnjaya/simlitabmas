<?php
	if($this->session->userdata('sesi_status')<>1)
	header('location:'.base_url());
?>
<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">LPPM Award</h1>
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
						<h6 class="m-0 font-weight-bold text-primary">Daftar Dosen</h6>
					</div>
					<div class="col-md-2 float-right">
						<form class="user" action="<?php echo base_url(); ?>award" method="post">
							<select name="periode" class="form-control" onchange="this.form.submit()" style="margin-top:-7px">
								<?php
									$tahun = 2018;
									$aktif = $tahunan;
									$selisih = $aktif - $tahun;
									
									if($this->input->post('periode')=='')
									$pilih = $tahunan;
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Nama Lengkap</th>
							<th>Jabatan Akademik</th>
							<th>Fakultas/Prodi</th>
							<th>Skor</th>
							<th>Validasi</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$n = 1;
							foreach($dosen as $d)
							{
								$fakultas = $this->mdosen->namafakultas($d->fakultas);
								$prodi = $this->mdosen->namaprodi($d->prodi);
								
								$skor = 0;
								//Penelitian
								$skorpenelitian = 0;
								$jmlpenelitianek = 0;
								$jmlpenelitianin = 0;
								foreach($riwayat as $p)
								{
									$date = DateTime::createFromFormat("Y-m-d", $p->tglmulai);
									if($date->format("Y")==$tahunan)
									{
										$pisah = explode(',',$p->anggotadosen);
										$hit = count($pisah);
										if($d->user==$p->pengusul || in_array($d->id_dosen,$pisah)){
											$dosen = $this->mdosen->dosennya($p->pengusul);
											$prodi = $this->mdosen->namaprodi($p->prodi);
											$splityear = explode('-',$p->tglmulai);
											if($d->user==$p->pengusul)
											{
												$peranku = 'Ketua Peneliti';
												if(in_array($p->sumberdana,array('Mandiri','Mandiri+Internal','Internal')))
												{
													$skorpenelitian = 20*60/100;
													$skor += $skorpenelitian;
												}
												else
												{
													$skorpenelitian = 40*60/100;
													$skor += $skorpenelitian;
												}
											}
											elseif(in_array($d->id_dosen, $pisah))
											{
												if($hit==0)
												$anggota = 1;
												else
												$anggota = $hit;
												$peranku = 'Anggota Peneliti';
												if(in_array($p->sumberdana,array('Mandiri','Mandiri+Internal','Internal')))
												{
													$skorpenelitian = (20*60/100)/$anggota;
													$skor += $skorpenelitian;
												}	
												else
												$skorpenelitian = (40*60/100)/$anggota;
												$skor += $skorpenelitian;
											}
											else
											$peranku = '';
											
										}
									}
								}
								foreach($tambahan as $p)
								{
									if($p->tahun==$tahunan)
									{
										$pisah = explode(',',$p->anggota);
										$hit = count($pisah);
										if($d->user==$p->user || in_array($d->id_dosen,$pisah)){
											$dosen = $this->mdosen->dosennya($p->ketua);
											$prodi = $this->mdosen->namaprodi($p->prodi);
											if($d->id_dosen==$p->ketua)
											{
												$peranku = 'Ketua Peneliti';
												if(in_array($p->sumberdana,array('Mandiri','Mandiri+Internal','Internal')))
												{
													$skorpenelitian = 20*60/100;
													$skor += $skorpenelitian;
												}
												else
												{
													$skorpenelitian = 40*60/100;
													$skor += $skorpenelitian;
												}
											}
											elseif(in_array($d->id_dosen, $pisah))
											{
												if($hit==0)
												$anggota = 1;
												else
												$anggota = $hit;
												$peranku = 'Anggota Peneliti';
												if(in_array($p->sumberdana,array('Mandiri','Mandiri+Internal','Internal')))
												{
													$skorpenelitian = (20*60/100)/$anggota;
													$skor += $skorpenelitian;
												}	
												else
												$skorpenelitian = (40*60/100)/$anggota;
												$skor += $skorpenelitian;
											}
											else
											$peranku = '';
											
										}
									}
								}	
								
								//Pengabdian
								$skorpengabdian = 0;
								$jmlpengabdianek = 0;
								$jmlpengabdianin = 0;
								foreach($riwayatpkm as $r)
								{
									$date = DateTime::createFromFormat("Y-m-d", $r->tglmulai);
									if($date->format("Y")==$tahunan)
									{
										$pisah = explode(',',$r->anggotadosen);
										$hit = count($pisah);
										if($d->user==$r->pengusul)
										{
											if($r->sumberdana=='Kerjasama' || $r->sumberdana=='DIKTI' || $r->sumberdana=='Kopertis')
											{
												$skorpengabdian = (40*60/100);
												$skor += $skorpengabdian;
												$jmlpengabdianek++;
												
												
											}
											elseif($r->sumberdana=='Internal' || $r->sumberdana=='Mandiri+Internal' || $r->sumberdana=='Mandiri')
											{
												$skorpengabdian = (20*60/100);
												$skor += $skorpengabdian;
												$jmlpengabdianin++;
												
											}
											else{}
										}
										elseif($d->user<>$r->pengusul && in_array($d->id_dosen, $pisah))
										{
											if($r->sumberdana=='Kerjasama' || $r->sumberdana=='DIKTI' || $r->sumberdana=='Kopertis')
											{
												if($hit==0)
												$anggota = 1;
												else
												$anggota = $hit;
												$skorpengabdian = (40*60/100)/$anggota;
												$skor += $skorpengabdian;
												$jmlpengabdianek++;
												
												
											}
											elseif($r->sumberdana=='Internal' || $r->sumberdana=='Mandiri+Internal' || $r->sumberdana=='Mandiri')
											{
												if($hit==0)
												$anggota = 1;
												else
												$anggota = $hit;
												$skorpengabdian = (20*60/100)/$anggota;
												$skor += $skorpengabdian;
												$jmlpengabdianin++;
												
											}
											else{}
										}
									}
								}
								foreach($tambahanpkm as $r)
								{
									if($r->tahun==$tahunan)
									{
										$pisah = explode(',',$r->anggota);
										if($d->id_dosen==$r->ketua)
										{
											if($r->sumberdana<>'Internal PT')
											{
												$skorpengabdian = (40*60/100);
												$skor += $skorpengabdian;
												$jmlpengabdianek++;
												
												
											}
											elseif($r->sumberdana=='Internal PT')
											{
												$skorpengabdian = (20*60/100);
												$skor += $skorpengabdian;
												$jmlpengabdianin++;
												
											}
											else{}
										}
										elseif($d->id_dosen<>$r->ketua && in_array($d->id_dosen, $pisah))
										{
											if($r->sumberdana<>'Internal PT')
											{
												if($r->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $r->jmlanggota;
												$skorpengabdian = (40*60/100)/$anggota;
												$skor += $skorpengabdian;
												$jmlpengabdianek++;
												
												
											}
											elseif($r->sumberdana=='Internal PT')
											{
												if($r->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $r->jmlanggota;
												$skorpengabdian = (20*60/100)/$anggota;
												$skor += $skorpengabdian;
												$jmlpengabdianin++;
												
											}
											else{}
										}
										else{}
									}
								}
								
								//Nilai Jurnal
								$skorjurnalq12 = 0;
								$skorjurnalq34 = 0;
								$skorjurnals12 = 0;
								$skorjurnals36 = 0;
								$skorjurnalissn = 0;
								$jmljurnalq12 = 0;
								$jmljurnalq34 = 0;
								$jmljurnals12 = 0;
								$jmljurnals36 = 0;
								$jmljurnalissn = 0;
								$listjurnal = $this->msubmitpribadi->selectjurnalaward($d->user,$d->id_dosen);
								foreach($listjurnal as $p)
								{
									$list = explode(',',$p->authorlain);
									if($d->user==$p->user && $p->status_jurnal=='Published' && $p->tahun_publikasi==$tahunan)
									{
										if($p->jenis_publikasi=='Jurnal Internasional Bereputasi')
										{
											$skorjurnalq12 = (40*60/100);
											$skor += $skorjurnalq12;
											$jmljurnalq12++;
											
										}		
										elseif($p->jenis_publikasi=='Jurnal Internasional')
										{
											$skorjurnalq34 = (30*60/100);
											$skor += $skorjurnalq34;
											$jmljurnalq34++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1-2' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 2')
										{
											$skorjurnals12 = (25*60/100);
											$skor += $skorjurnals12;
											$jmljurnals12++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3-6' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 4' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 5' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 6')
										{
											$skorjurnals36 = (20*60/100);
											$skor += $skorjurnals36;
											$jmljurnals36++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Nasional BerISSN')
										{
											$skorjurnalissn = (10*60/100);
											$skor += $skorjurnalissn;
											$jmljurnalissn++;
											
										}
										else{}
									}
									
									elseif(in_array($d->id_dosen,$list) && $p->status_jurnal=='Published' && $p->tahun_publikasi==$tahunan)
									{
										if($p->jenis_publikasi=='Jurnal Internasional Bereputasi')
										{
											if($p->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $p->jmlanggota;
											$skorjurnalq12 = (40*60/100)/$anggota;
											$skor += $skorjurnalq12;
											$jmljurnalq12++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Internasional')
										{
											if($p->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $p->jmlanggota;
											$skorjurnalq34 = (30*60/100)/$anggota;
											$skor += $skorjurnalq34;
											$jmljurnalq34++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1-2' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 2')
										{
											if($p->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $p->jmlanggota;
											$skorjurnals12 = (25*60/100)/$anggota;
											$skor += $skorjurnals12;
											$jmljurnals12++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3-6' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 4' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 5' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 6')
										{
											if($p->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $p->jmlanggota;
											$skorjurnals36 = (20*60/100)/$anggota;
											$skor += $skorjurnals36;
											$jmljurnals36++;
											
										}
										elseif($p->jenis_publikasi=='Jurnal Nasional BerISSN')
										{
											if($p->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $p->jmlanggota;
											$skorjurnalissn = (10*60/100)/$anggota;
											$skor += $skorjurnalissn;
											$jmljurnalissn++;
											
										}
										else{}
									}
									else{}
								}
																
								//Nilai HKI
								$skorhki = 0;
								$jmlhki = 0;
								$listhki = $this->msubmitpribadi->selecthkiaward($d->user,$d->id_dosen);
								foreach($listhki as $p)
								{
									$list = explode(',',$p->authorlain);
									if($d->user==$p->user && $p->status=='Granted' && $p->tahun_pelaksanaan==$tahunan)
									{
										$skorhki = (20*60/100);
										$skor += $skorhki;
										$jmljurnalq12++;
										
									}

									elseif($p->usulan<>'' && $p->status=='Granted' && $p->tahun_pelaksanaan==$tahunan)
									{
										if($p->sbgluaran=='Luaran Penelitian')
										{
											$lihatusulan = $this->msubmit->detailusulan($p->usulan);
											$listu = explode(',',$lihatusulan['anggotadosen']);
											if($d->user==$lihatusulan['pengusul'])
											{
												$skorhki = (20*60/100);
												$skor += $skorhki;
												$jmljurnalq12++;
											}
											elseif(in_array($d->id_dosen,$listu))
											{
												$getanggota = explode(',',$lihatusulan['anggotadosen']);
												$hitanggota = count($getanggota);
												if($hitanggota==0)
													$anggota = 1;
												else
													$anggota = $hitanggota;
												$skorhki = (20*60/100)/$anggota;
												$skor += $skorhki;
												$jmlhki++;
											}
											else
											{}
										}
										else
										{
											$lihatusulanpkm = $this->mpengabdian->detailusulan($p->usulan);
											$listu = explode(',',$lihatusulan['anggotadosen']);
											if($d->user==$lihatusulanpkm['pengusul'])
											{
												$skorhki = (20*60/100);
												$skor += $skorhki;
												$jmljurnalq12++;
											}
											elseif(in_array($d->id_dosen,$listu))
											{
												$getanggota = explode(',',$lihatusulanpkm['anggotadosen']);
												$hitanggota = count($getanggota);
												if($hitanggota==0)
													$anggota = 1;
												else
													$anggota = $hitanggota;
												$skorhki = (20*60/100)/$anggota;
												$skor += $skorhki;
												$jmlhki++;
											}
											else
											{}
										}
									}
									
									elseif(in_array($d->id_dosen,$list) && $p->status=='Granted' && $p->tahun_pelaksanaan==$tahunan)
									{
										if($p->jmlanggota==0)
										$anggota = 1;
										else
										$anggota = $p->jmlanggota;
										$skorhki = (20*60/100)/$anggota;
										$skor += $skorhki;
										$jmlhki++;
										
									}
									else {}
								}
								
								//nilai buku
								$jmlbuku = 0;
								$jmlbukulain = 0;
								foreach($buku as $b)
								{
									if($b->user==$d->user)
									{
										$skorbuku = (40*60/100);
										$skor += $skorbuku;
										$jmlbuku++;
										
									}
									$break = explode(',',$b->authorlain);
									if(in_array($d->id_dosen,$break))
									{
										if($b->jmlanggota==0)
										$anggota = 1;
										else
										$anggota = $b->jmlanggota;
										$skorbukulain = (40*40/100)/$anggota;
										$skor += $skorbukulain;
										$jmlbukulain++;
										
									}
								}
								
								//nilai prosiding
								$jmlprosiding = 0;
								$jmlprosidinglain = 0;
								foreach($prosiding as $b)
								{
									if($b->user==$d->user)
									{
										$skorpro = (10*60/100);
										$skor += $skorpro;
										$jmlprosiding++;
										
									}
									$break = explode(',',$b->authorlain);
									if(in_array($d->id_dosen,$break))
									{
										if($b->jmlanggota==0)
										$anggota = 1;
										else
										$anggota = $b->jmlanggota;
										$skorprolain = (10*40/100)/$anggota;
										$skor += $skorprolain;
										$jmlprosidinglain++;
										
									}
								}

								//Hasil Validasi
								
								
								echo "<tr>
								<td>".$d->namalengkap."</td>
								<td>".$d->jabatanakademik."</td>
								<td>".$fakultas['fakultas']."/".$prodi['prodi']."</td>
								<td><a href='".base_url()."award/detail/".$d->user."/".$d->id_dosen."/".$skor."/".$pilih."'>".number_format($skor,2)."</a></td>
								<td></td>
								</tr>";
								$n++;
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#dataTable').DataTable( {
			"order": [[ 3, "desc" ]]
		} );
	} );
</script>
