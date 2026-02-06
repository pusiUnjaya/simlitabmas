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
			<h6 class="m-0 font-weight-bold text-primary">Data Dosen</h6>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-sm-9">
					<?php
						$tahunan = $this->uri->segment(6);
						foreach($dosen as $p)
						{
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							if($this->uri->segment(4)==$p->id_dosen)
							{
								echo "<p>Nama Dosen : ".$p->namalengkap."</p>";
								echo "<p>Fakultas/Prodi : ".$fakultas['fakultas']."/".$prodi['prodi']."</p></div>";
								echo "<div class='col-sm-3'>Skor: <p style='margin-left:50px;margin-top:-50px;font-size:60px'>".number_format($this->uri->segment(5),2)."</p></div>";
							}
						}
					?>
					<div class="table-responsive">
						<table class="table table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<form action="<?php echo base_url(); ?>award/validasi" method="post">
									<th>Rekap Kinerja Dosen
									<input type="submit" value="Validasi" style="float:right">
									<input type='hidden' name="user" value='<?php echo $this->uri->segment(3); ?>'>
									<input type='hidden' name="dosen" value='<?php echo $this->uri->segment(4); ?>'>
									<input type='hidden' name="skor" value='<?php echo $this->uri->segment(5); ?>'>
									<input type='hidden' name="tahun" value='<?php echo $this->uri->segment(6); ?>'>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$skor = 0;
									//Penelitian
									$skorpenelitian = 0;
									$jmlpenelitianek = 0;
									$jmlpenelitianin = 0;
									$no = 1;
									echo "<tr><td>Penelitian :";
									echo '<table class="table table-bordered" width="100%" cellspacing="0">';
									foreach($riwayat as $p)
									{
										$date = DateTime::createFromFormat("Y-m-d", $p->tglmulai);
										if($date->format("Y")==$tahunan)
										{
											$pisah = explode(',',$p->anggotadosen);
											$hit = count($pisah);
											if($this->uri->segment(3)==$p->pengusul || in_array($this->uri->segment(4),$pisah)){
												$dosen = $this->mdosen->dosennya($p->pengusul);
												$prodi = $this->mdosen->namaprodi($p->prodi);
												$splityear = explode('-',$p->tglmulai);
												$ketua = $this->mdosen->dosennya($p->pengusul);
									$ambil = explode(',',$p->anggotadosen);
									$hit = count($ambil);
									$anggotadosen = '';
									
									if($p->anggotadosen<>'') 
									{
										for($i=0;$i<$hit;$i++)
										{
											$dosen = $this->mdosen->namadosen($ambil[$i]);
											$anggotadosen.=$dosen['namalengkap'];
											if($i<($hit-1))
											$anggotadosen .=', ';
										}
									}
									else
									$anggotadosen = 'Tidak Ada Anggota Dosen';
												if($this->uri->segment(3)==$p->pengusul)
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
												elseif(in_array($this->uri->segment(4), $pisah))
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
												echo '<tr><td>'.$no++.'</td>';
												echo "<td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
												| Skor : ".$skorpenelitian."
												<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
												".$p->sumberdana."
												<br><b>Anggota : </b>".$anggotadosen."
												| <b>Skema : ".$p->skema."</b>
												</td><input type='hidden' name='skorsis[]' value='".number_format($skorpenelitian, 2, '.', '')."' size='3' maxlength='4'>
												<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpenelitian, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
										}
									}
									foreach($tambahan as $p)
									{
										if($p->tahun==$tahunan)
										{
											$pisah = explode(',',$p->anggota);
											$hit = count($pisah);
											if($this->uri->segment(3)==$p->user || in_array($this->uri->segment(4),$pisah)){
												$dosen = $this->mdosen->dosennya($p->ketua);
												$prodi = $this->mdosen->namaprodi($p->prodi);
												$ketua = $this->mdosen->dosennya($p->user);
												$ambil = explode(',',$p->anggota);
												$hit = count($ambil);
												$anggotadosen = '';
												
												if($p->anggota<>'') 
												{
													for($i=0;$i<$hit;$i++)
													{
														$dosen = $this->mdosen->namadosen($ambil[$i]);
														$anggotadosen.=$dosen['namalengkap'];
														if($i<($hit-1))
														$anggotadosen .=', ';
													}
												}
												else
												$anggotadosen = 'Tidak Ada Anggota Dosen';
												if($this->uri->segment(4)==$p->ketua)
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
												elseif(in_array($this->uri->segment(4), $pisah))
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
												echo "<tr><td>".$no++."</td><td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a> | <b>Skor :</b> ".$skorpenelitian."
												<br><b>Tahun : </b>".$p->tahun." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
												".$p->sumberdana."
												<br><b>Anggota : </b>".$anggotadosen."
												| <b>Skema : ".$p->jenis."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpenelitian, 2, '.', '')."' size='3' maxlength='4'>
												<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpenelitian, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
										}
									}	
									echo '</table>';

									//Pengabdian
									$skorpengabdian = 0;
									$jmlpengabdianek = 0;
									$jmlpengabdianin = 0;
									$no = 1;
									echo "<tr><td>Pengabdian :";
									echo '<table class="table table-bordered" width="100%" cellspacing="0">';
									foreach($riwayatpkm as $r)
									{
										$date = DateTime::createFromFormat("Y-m-d", $r->tglmulai);
										$dosen = $this->mdosen->dosennya($r->pengusul);
										$prodi = $this->mdosen->namaprodi($r->prodi);
										$splityear = explode('-',$r->tglmulai);
										$ketua = $this->mdosen->dosennya($r->pengusul);
										$ambil = explode(',',$r->anggotadosen);
										$hit = count($ambil);
										$anggotadosen = '';
										
										if($r->anggotadosen<>'') 
										{
											for($i=0;$i<$hit;$i++)
											{
												$dosen = $this->mdosen->namadosen($ambil[$i]);
												$anggotadosen.=$dosen['namalengkap'];
													if($i<($hit-1))
														$anggotadosen .=', ';
											}
										}
										else
											$anggotadosen = 'Tidak Ada Anggota Dosen';
										if($date->format("Y")==$tahunan)
										{
											$pisah = explode(',',$r->anggotadosen);
											$hit = count($pisah);
											if($this->uri->segment(3)==$r->pengusul)
											{
												if($r->sumberdana=='Kerjasama' || $r->sumberdana=='DIKTI' || $r->sumberdana=='Kopertis')
												{
													$skorpengabdian = (40*60/100);
													$skor += $skorpengabdian;
													$jmlpengabdianek++;
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->skema."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpenelitian, 2, '.', '')."' size='3' maxlength='4'>
													<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpenelitian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";	
												}
												elseif($r->sumberdana=='Internal' || $r->sumberdana=='Mandiri+Internal' || $r->sumberdana=='Mandiri')
												{
													$skorpengabdian = (20*60/100);
													$skor += $skorpengabdian;
													$jmlpengabdianin++;
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->skema."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
												}
												else{}
											}
											elseif($this->uri->segment(3)<>$r->pengusul && in_array($this->uri->segment(4), $pisah))
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
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->skema."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
													
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
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->skema."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
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
											$dosen = $this->mdosen->dosennya($r->user);
											$prodi = $this->mdosen->namaprodi($r->prodi);
											$splityear = explode('-',$r->tglmulai);
											$ketua = $this->mdosen->dosennya($r->user);
											$ambil = explode(',',$r->anggota);
											$hit = count($ambil);
											$anggotadosen = '';
											
											if($r->anggota<>'') 
											{
												for($i=0;$i<$hit;$i++)
												{
													$dosen = $this->mdosen->namadosen($ambil[$i]);
													$anggotadosen.=$dosen['namalengkap'];
														if($i<($hit-1))
															$anggotadosen .=', ';
												}
											}
											else
												$anggotadosen = 'Tidak Ada Anggota Dosen';
											if($this->uri->segment(4)==$r->ketua)
											{
												if($r->sumberdana<>'Internal PT')
												{
													$skorpengabdian = (40*60/100);
													$skor += $skorpengabdian;
													$jmlpengabdianek++;
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->jenis."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
													
												}
												elseif($r->sumberdana=='Internal PT')
												{
													$skorpengabdian = (20*60/100);
													$skor += $skorpengabdian;
													$jmlpengabdianin++;
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->jenis."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
												}
												else{}
											}
											elseif($this->uri->segment(4)<>$r->ketua && in_array($this->uri->segment(4), $pisah))
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
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->jenis."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
													
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
													echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian;
													echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
													".$p->sumberdana."
													<br><b>Anggota : </b>".$anggotadosen."
													<br><b>Skema : ".$r->jenis."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'>
													<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpengabdian, 2, '.', '')."' size='3' maxlength='4'></td>
													</tr>";
												}
												else{}
											}
											else{}
										}
									}
									echo "</table></td></tr>";
									
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
									$no = 1;
									echo "<tr><td>Jurnal :";
									echo '<table class="table table-bordered" width="100%" cellspacing="0">';
									$listjurnal = $this->msubmitpribadi->selectjurnalaward($this->uri->segment(3),$this->uri->segment(4));
									// echo $this->db->last_query();exit;

									foreach($listjurnal as $p)
									{
										if($p->user==$this->uri->segment(3) && $p->authorlain=='')
										{
											$list = explode(',',$p->authorlain);
											$cek = '';
											$hit = '';
											$ketua = $this->mdosen->dosennya($p->user);
										}
										elseif($p->usulan<>'' && $p->usul<>null && $p->sbg_luaran='Luaran Penelitian')
										{
											$list = explode(',',$p->udosen);
											if($p->usul==$this->uri->segment(3) && $p->udosen=='')
											{
												$hit='';
												$cek='';
											}
											else
											{
												$cek = in_array($this->uri->segment(4),$list);
												$hit = count($list);
											}
											
											$ketua = $this->mdosen->dosennya($p->usul);
										}
										elseif($p->usulan<>'' && $p->musul<>null)
										{
											$list = explode(',',$p->mdosen);
											if($p->musul==$this->uri->segment(3) && $p->mdosen=='')
											{
												$hit='';
												$cek='';
											}
											elseif($p->musul<>$this->uri->segment(3) && $p->mdosen<>'')
											{
												$cek = in_array($this->uri->segment(4),$list);
												$hit = count($list);
											}
											else
											{
												$cek = in_array($this->uri->segment(4),$list);
												$hit = count($list);
											}
											
											if($p->usul==$this->uri->segment(3) && $sbg_luaran=='Luaran Penelitian')
												$ketua = $this->mdosen->dosennya($p->usul);
											else
												$ketua = $this->mdosen->dosennya($p->musul);
										}
										elseif($p->user<>$this->uri->segment(3) && $p->authorlain<>'')
										{
											$list = explode(',',$p->authorlain);
											$cek = in_array($this->uri->segment(4),$list);
											$hit = count($list);
											$ketua = $this->mdosen->dosennya($p->user);
										}
										else {
											$list = explode(',',$p->authorlain);
											$cek = '';
											$hit = '';
											$ketua = $this->mdosen->dosennya($p->user);
										}

										$anggotadosen = '';
										
										if($hit>0) 
										{
											for($i=0;$i<$hit;$i++)
											{
												$dosen = $this->mdosen->namadosen($list[$i]);
												$anggotadosen.=$dosen['namalengkap'];
													if($i<($hit-1))
														$anggotadosen .=', ';
											}
										}
										else
											$anggotadosen = 'Tidak Ada Anggota Dosen';
										 
									if($hit==0)
									{
										if($p->jenis_publikasi=='Jurnal Internasional Bereputasi')
											{
												$skorjurnalq12 = (40*60/100);
												$skor += $skorjurnalq12;
												$jmljurnalq12++;
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq12;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnalq12, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnalq12, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}		
											elseif($p->jenis_publikasi=='Jurnal Internasional')
											{
												$skorjurnalq34 = (30*60/100);
												$skor += $skorjurnalq34;
												$jmljurnalq34++;
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq34;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnalq34, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnalq34, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1-2' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 2')
											{
												$skorjurnals12 = (25*60/100);
												$skor += $skorjurnals12;
												$jmljurnals12++;
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals12;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnals12, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnals12, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3-6' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 4' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 5' || $p->jenis_publikasi=='Jurnal Nasional Terakreditasi 6')
											{
												$skorjurnals36 = (20*60/100);
												$skor += $skorjurnals36;
												$jmljurnals36++;
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals36;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnals36, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnals36, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional BerISSN')
											{
												$skorjurnalissn = (10*60/100);
												$skor += $skorjurnalissn;
												$jmljurnalissn++;
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalissn;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnalissn, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnalissn, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
											else{}
										}
									
										else
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
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq12;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnalq12, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnalq12, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
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
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq34;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnalq34, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnalq34, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
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
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals12;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnals12, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnals12, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
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
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals36;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnals36, 2, '.', '')."' size='3' maxlength='4'>
												<td><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnals36, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
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
												echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalissn;
												echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
												".$p->sbgluaran."
												<br><b>Anggota : </b>".$anggotadosen."
												<br><b>Jenis Publikasi : ".$p->jenis_publikasi."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorjurnalissn, 2, '.', '')."' size='3' maxlength='4'>
												<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorjurnalissn, 2, '.', '')."' size='3' maxlength='4'></td>
												</tr>";
											}
										}
									}	
									echo "</table></td></tr>";
									
									//Nilai HKI
									$skorhki = 0;
									$jmlhki = 0;
									$no = 1;
									echo "<tr><td>HKI :";
									echo '<table class="table table-bordered" width="100%" cellspacing="0">';
									$listhki = $this->msubmitpribadi->selecthkiaward($this->uri->segment(3),$this->uri->segment(4));
									// echo $this->db->last_query();exit;
									echo $this->session->userdata('sesi_id');
									foreach($listhki as $p)
									{
										if($p->user==$this->uri->segment(3) && $p->authorlain<>'')
										{
											$list = explode(',',$p->authorlain);
											$hit = count($list);
											$ketua = $this->mdosen->dosennya($p->user);
										}
										elseif($p->usulan<>'' && $p->usul<>'')
										{
											$list = explode(',',$p->udosen);
											$hit = count($list);
											$ketua = $this->mdosen->dosennya($p->usul);
										}
										elseif($p->usulan<>'' && $p->musul<>'')
										{
											$list = explode(',',$p->mdosen);
											$hit = count($list);
											$ketua = $this->mdosen->dosennya($p->musul);
										}
										elseif($p->user==$this->uri->segment(3) && $p->authorlain=='')
										{
											$list = explode(',',$p->authorlain);
											$hit = '';
											$ketua = $this->mdosen->dosennya($p->user);
										}
										else
										{
											$list = explode(',',$p->authorlain);
											$hit = count($list);
											$ketua = $this->mdosen->dosennya($p->user);
										}

										$anggotadosen = '';
										
										if($hit>0) 
										{
											for($i=0;$i<$hit;$i++)
											{
												$dosen = $this->mdosen->namadosen($list[$i]);
												$anggotadosen.=$dosen['namalengkap'];
													if($i<($hit-1))
														$anggotadosen .=', ';
											}
										}
										else
											$anggotadosen = 'Tidak Ada Anggota Dosen';

										if($this->uri->segment(3)==$p->user && $p->status=='Granted' && $p->tahun_pelaksanaan==$tahunan)
										{
											$skorhki = (20*60/100);
											$skor += $skorhki;
											$jmljurnalq12++;
											echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_hki.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorhki;
											echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
											".$p->sbgluaran."
											<br><b>Anggota : </b>".$anggotadosen."
											<br><b>Jenis Publikasi : ".$p->jenis_hki."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorhki, 2, '.', '')."' size='3' maxlength='4'>
											<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorhki, 2, '.', '')."' size='3' maxlength='4'></td>
											</tr>";
										}
										
										elseif(in_array($this->uri->segment(4),$list) && $p->status=='Granted' && $p->tahun_pelaksanaan==$tahunan)
										{
											if($p->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $p->jmlanggota;
											$skorhki = (20*60/100)/$anggota;
											$skor += $skorhki;
											$jmlhki++;
											echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$p->file_hki.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorhki;
											echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
											".$p->sbgluaran."
											<br><b>Anggota : </b>".$anggotadosen."
											<br><b>Jenis Publikasi : ".$p->jenis_hki."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorhki, 2, '.', '')."' size='3' maxlength='4'>
											<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorhki, 2, '.', '')."' size='3' maxlength='4'></td>
											</tr>";
										}
										else {}
									}
									echo "</table></td></tr>";
									
									//nilai buku
									$jmlbuku = 0;
									$jmlbukulain = 0;
									$no = 1;
									echo "<tr><td>Buku :";
									echo '<table class="table table-bordered" width="100%" cellspacing="0">';
									foreach($buku as $b)
									{
										$ketua = $this->mdosen->dosennya($b->user); 
										if($b->user==$this->uri->segment(3))
										{
											$skorbuku = (40*60/100);
											$skor += $skorbuku;
											$jmlbuku++;
											echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$b->file_buku.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$b->judul.'</a> | Skor : '.$skorbuku;
											echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
											".$p->sbgluaran."
											<br><b>Anggota : </b>".$anggotadosen."
											<br><b>Jenis Publikasi : ".$p->sbgluaran."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorbuku, 2, '.', '')."' size='3' maxlength='4'>
											<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorbuku, 2, '.', '')."' size='3' maxlength='4'></td>
											</tr>";
										}
										$break = explode(',',$b->authorlain);
										if(in_array($this->uri->segment(4),$break))
										{
											if($b->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $b->jmlanggota;
											$skorbukulain = (40*40/100)/$anggota;
											$skor += $skorbukulain;
											$jmlbukulain++;
											echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$b->file_buku.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$b->judul.'</a> | Skor : '.$skorbukulain;
											echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
											".$p->sbgluaran."
											<br><b>Anggota : </b>".$anggotadosen."
											<br><b>Jenis Publikasi : ".$p->jenis_hki."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorbukulain, 2, '.', '')."' size='3' maxlength='4'>
											<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorbukulain, 2, '.', '')."' size='3' maxlength='4'></td>
											</tr>";
										}
									}
									echo "</table></td></tr>";
									
									//nilai prosiding
									$jmlprosiding = 0;
									$jmlprosidinglain = 0;
									$no = 1;
									echo "<tr><td>Prosiding :";
									echo '<table class="table table-bordered" width="100%" cellspacing="0">';
									foreach($prosiding as $b)
									{
										$ketua = $this->mdosen->dosennya($b->user); 
										if($b->user==$this->uri->segment(3))
										{
											$skorpro = (10*60/100);
											$skor += $skorpro;
											$jmlprosiding++;
											echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$b->file_prosiding.'" data-jenisfile="File Prosiding" data-target="#liatfile">'.$b->judul.' </a> | Skor : '.$skorpro;
											echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
											".$p->sbgluaran."
											<br><b>Anggota : </b>".$anggotadosen."
											<br><b>Jenis Publikasi : ".$p->jenis_hki."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorpro, 2, '.', '')."' size='3' maxlength='4'>
											<td width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorpro, 2, '.', '')."' size='3' maxlength='4'></td>
											</tr>";
										}
										$break = explode(',',$b->authorlain);
										if(in_array($this->uri->segment(4),$break))
										{
											if($b->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $b->jmlanggota;
											$skorprolain = (10*40/100)/$anggota;
											$skor += $skorprolain;
											$jmlprosidinglain++;
											echo '<tr><td>'.$no++.'</td><td><a href="" data-toggle="modal" data-filenya="'.$b->file_prosiding.'" data-jenisfile="File Prosiding" data-target="#liatfile">'.$b->judul.'</a> | Skor : '.$skorprolain;
											echo "<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sebagai Luaran :</b> 
											".$p->sbgluaran."
											<br><b>Anggota : </b>".$anggotadosen."
											<br><b>Jenis Publikasi : ".$p->jenis_hki."</b></td><input type='hidden' name='skorsis[]' value='".number_format($skorprolain, 2, '.', '')."' size='3' maxlength='4'>
											<td  width='20'><sub>Validasi</sub><input type='text' name='skorval[]' value='".number_format($skorprolain, 2, '.', '')."' size='3' maxlength='4'></td>
											</tr>";
										}
									}
									echo "</table></td></tr>";
								?>	
								<tr><td><input type="submit" value="Validasi" style="float:right"></td></tr>
							</tbody>
							</form>
						</table>
						<?php //echo 'Skor : '.$skor;?>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="liatfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="jenisfile">File Laporan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<embed id="filenya" src="" frameborder="0" width="100%" height="400px"/>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<script>
			$(document).ready(function() {
				$('#liatfile').on('show.bs.modal', function (event) {
					var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
					var modal = $(this)
					
					var sumber = document.getElementById("filenya");
					sumber.setAttribute("src","https://simlitabmas.unjaya.ac.id/assets/uploadbox/"+div.data('filenya'));
					
					modal.find('#jenisfile').html(div.data('jenisfile'));
				});
			});
		</script>
		