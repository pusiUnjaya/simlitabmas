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
				<div class="col-sm-8">
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
								echo "<div class='col-sm-4'>Skor: <p style='margin-left:50px;margin-top:-50px;font-size:70px'>".number_format($this->uri->segment(5),3)."</p></div>";
							}
						}
					?>
					<div class="table-responsive">
						<table class="table table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Rekap Kinerja Dosen</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$skor = 0;
									//Penelitian
									$skorpenelitian = 0;
									$jmlpenelitianek = 0;
									$jmlpenelitianin = 0;
									echo "<tr><td>Penelitian :<ol>";
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
												echo "<li><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
												| Skor : ".$skorpenelitian."
												</li>";
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
												if($this->uri->segment(4)==$p->ketua)
												{
													$peranku = 'Ketua Peneliti';
													if(in_array($p->sumberdana,array('Mandiri','Mandiri+Internal','Internal')))
													{
														$skorpenelitian = 20*60/100;
														if($skorpenelitian>20)
														$skorpenelitian=8;
														$skor += $skorpenelitian;
													}
													else
													{
														$skorpenelitian = 40*60/100;
														if($skorpenelitian>20)
														$skorpenelitian=24;
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
														if($skorpenelitian>5)
														$skorpenelitian=6;
														$skor += $skorpenelitian;
													}	
													else
													$skorpenelitian = (40*60/100)/$anggota;
													if($skorpenelitian>5)
														$skorpenelitian=6;
													$skor += $skorpenelitian;
												}
												else
												$peranku = '';
												echo "<li><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a> | Skor : ".$skorpenelitian."</li>";
											}
										}
									}	
									
									//Pengabdian
									$skorpengabdian = 0;
									$jmlpengabdianek = 0;
									$jmlpengabdianin = 0;
									echo "<tr><td>Pengabdian :<ol>";
									foreach($riwayatpkm as $r)
									{
										$date = DateTime::createFromFormat("Y-m-d", $r->tglmulai);
										if($date->format("Y")==$tahunan)
										{
											$pisah = explode(',',$r->anggotadosen);
											$hit = count($pisah);
											if($this->uri->segment(3)==$r->pengusul)
											{
												if($r->sumberdana=='Kerjasama' || $r->sumberdana=='DIKTI' || $r->sumberdana=='Kopertis')
												{
													$skorpengabdian = (40*60/100);
													if($skorpengabdian>10)
														$skorpengabdian=4;
													$skor += $skorpengabdian;
													
													$jmlpengabdianek++;
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian.'</li>';
													
												}
												elseif($r->sumberdana=='Internal' || $r->sumberdana=='Mandiri+Internal' || $r->sumberdana=='Mandiri')
												{
													$skorpengabdian = (20*60/100);
													if($skorpengabdian>10)
														$skorpengabdian=12;
													$skor += $skorpengabdian;
													$jmlpengabdianin++;
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian.'</li>';
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
													if($skorpengabdian>10)
														$skorpengabdian=4;
													$skor += $skorpengabdian;
													$jmlpengabdianek++;
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian.'</li>';
													
												}
												elseif($r->sumberdana=='Internal' || $r->sumberdana=='Mandiri+Internal' || $r->sumberdana=='Mandiri')
												{
													if($hit==0)
													$anggota = 1;
													else
													$anggota = $hit;
													$skorpengabdian = (20*60/100)/$anggota;
													if($skorpengabdian>10)
														$skorpengabdian=3;
													$skor += $skorpengabdian;
													$jmlpengabdianin++;
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->file_laporan_akhir.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian.'</li>';
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
											if($this->uri->segment(4)==$r->ketua)
											{
												if($r->sumberdana<>'Internal PT')
												{
													$skorpengabdian = (40*60/100);
													if($skorpengabdian>10)
														$skorpengabdian=11.3335;
													$skor += $skorpengabdian;
													$jmlpengabdianek++;
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian.'</li>';
													
												}
												elseif($r->sumberdana=='Internal PT')
												{
													$skorpengabdian = (20*60/100);
													if($skorpengabdian>10)
														$skorpengabdian=3;
													$skor += $skorpengabdian;
													$jmlpengabdianin++;
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian.'</li>';
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
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Eksternal</a> | Skor : '.$skorpengabdian.'</li>';
													
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
													echo '<li><a href="" data-toggle="modal" data-filenya="'.$r->filelaporan.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$r->judul.' | Internal</a> | Skor : '.$skorpengabdian.'</li>';
												}
												else{}
											}
											else{}
										}
									}
									echo "</ol></td></tr>";
									
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
									echo "<tr><td>Jurnal :<ol>";
									foreach($listjurnal as $p)
									{
										$list = explode(',',$p->authorlain);
										if($this->uri->segment(3)==$p->user && $p->status_jurnal=='Published' && $p->tahun_publikasi==$tahunan)
										{
											if($p->jenis_publikasi=='Jurnal Internasional Bereputasi')
											{
												$skorjurnalq12 = (40*60/100);
												if($skorjurnalq12>5)
														$skorjurnalq12=12;
												$skor += $skorjurnalq12;
												$jmljurnalq12++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq12.'</li>';
											}		
											elseif($p->jenis_publikasi=='Jurnal Internasional')
											{
												$skorjurnalq34 = (30*60/100);
												if($skorjurnalq34>5)
														$skorjurnalq34=6;
												$skor += $skorjurnalq34;
												$jmljurnalq34++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq34.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1-2')
											{
												$skorjurnals12 = (25*60/100);
												// if($skorjurnals12>5)
														// $skorjurnals12=10;
												$skor += $skorjurnals12;
												$jmljurnals12++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals12.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3-6')
											{
												$skorjurnals36 = (20*60/100);
												if($skorjurnals36>10)
														$skorjurnals36=3;
												$skor += $skorjurnals36;
												$jmljurnals36++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals36.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional BerISSN')
											{
												$skorjurnalissn = (10*60/100);
												if($skorjurnalissn>5)
														$skorjurnalissn=4;
												$skor += $skorjurnalissn;
												$jmljurnalissn++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalissn.'</li>';
											}
											else{}
										}
										
										elseif(in_array($this->uri->segment(4),$list) && $p->status_jurnal=='Published' && $p->tahun_publikasi==$tahunan)
										{
											if($p->jenis_publikasi=='Jurnal Internasional Bereputasi')
											{
												if($p->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $p->jmlanggota;
												$skorjurnalq12 = (40*60/100)/$anggota;
												if($skorjurnalq12>5)
														$skorjurnalq12=4;
												$skor += $skorjurnalq12;
												$jmljurnalq12++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq12.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Internasional')
											{
												if($p->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $p->jmlanggota;
												$skorjurnalq34 = (30*60/100)/$anggota;
												if($skorjurnalq34>5)
														$skorjurnals12=4;
												$skor += $skorjurnalq34;
												$jmljurnalq34++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalq34.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 1-2')
											{
												if($p->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $p->jmlanggota;
												$skorjurnals12 = (25*60/100)/$anggota;
												if($skorjurnals12>5)
														$skorjurnals12=4;
												$skor += $skorjurnals12;
												$jmljurnals12++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals12.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional Terakreditasi 3-6')
											{
												if($p->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $p->jmlanggota;
												$skorjurnals36 = (20*60/100)/$anggota;
												if($skorjurnals36>5)
														$skorjurnals36=4;
												$skor += $skorjurnals36;
												$jmljurnals36++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnals36.'</li>';
											}
											elseif($p->jenis_publikasi=='Jurnal Nasional BerISSN')
											{
												if($p->jmlanggota==0)
												$anggota = 1;
												else
												$anggota = $p->jmlanggota;
												$skorjurnalissn = (10*60/100)/$anggota;
												if($skorjurnalissn>5)
														$skorjurnalissn=4;
												$skor += $skorjurnalissn;
												$jmljurnalissn++;
												echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_jurnal.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorjurnalissn.'</li>';
											}
											else{}
										}
										else{}
									}
									echo "</ol></td></tr>";
									
									//Nilai HKI
									$skorhki = 0;
									$jmlhki = 0;
									echo "<tr><td>HKI :<ol>";
									foreach($listhki as $p)
									{
										$list = explode(',',$p->authorlain);
										if($this->uri->segment(3)==$p->user && $p->status=='Granted' && $p->tahun_pelaksanaan==$tahunan)
										{
											$skorhki = (20*60/100);
											if($skorhki>5)
												$skorhki=10;
											$skor += $skorhki;
											$jmljurnalq12++;
											echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_hki.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorhki.'</li>';
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
											echo '<li><a href="" data-toggle="modal" data-filenya="'.$p->file_hki.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$p->judul.'</a> | Skor : '.$skorhki.'</li>';
										}
										else {}
									}
									echo "</ol></td></tr>";
									
									//nilai buku
									$jmlbuku = 0;
									$jmlbukulain = 0;
									echo "<tr><td>Buku :<ol>";
									foreach($buku as $b)
									{
										if($b->user==$this->uri->segment(3))
										{
											$skorbuku = (40*60/100);
											$skor += $skorbuku;
											$jmlbuku++;
											echo '<li><a href="" data-toggle="modal" data-filenya="'.$b->file_buku.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$b->judul.'</a> | Skor : '.$skorbuku.'</li>';
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
											echo '<li><a href="" data-toggle="modal" data-filenya="'.$b->file_buku.'" data-jenisfile="File Jurnal" data-target="#liatfile">'.$b->judul.'</a> | Skor : '.$skorbukulain.'</li>';
										}
									}
									echo "</ol></td></tr>";
									
									//nilai prosiding
									$jmlprosiding = 0;
									$jmlprosidinglain = 0;
									echo "<tr><td>Prosiding :<ol>";
									foreach($prosiding as $b)
									{
										if($b->user==$this->uri->segment(3))
										{
											$skorpro = (10*60/100);
											if($skorpro>3)
												$skorpro=3;
											$skor += $skorpro;
											$jmlprosiding++;
											echo '<li><a href="" data-toggle="modal" data-filenya="'.$b->file_prosiding.'" data-jenisfile="File Prosiding" data-target="#liatfile">'.$b->judul.' </a> | Skor : '.$skorpro.'</li>';
										}
										$break = explode(',',$b->authorlain);
										if(in_array($this->uri->segment(4),$break))
										{
											if($b->jmlanggota==0)
											$anggota = 1;
											else
											$anggota = $b->jmlanggota;
											$skorprolain = (10*40/100)/$anggota;
											if($skorprolain>3)
												$skorprolain=9.667;
											$skor += $skorprolain;
											$jmlprosidinglain++;
											echo '<li><a href="" data-toggle="modal" data-filenya="'.$b->file_prosiding.'" data-jenisfile="File Prosiding" data-target="#liatfile">'.$b->judul.'</a> | Skor : '.$skorprolain.'</li>';
										}
									}
									echo "</ol></td></tr>";
									
									
								?>	
							</tbody>
						</table>
						<?php //echo 'Skor : '.($skor-$this->uri->segment(5));?>
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
		