<?php
// if($this->session->userdata('sesi_status')<>1) {
// $ceksul = $this->msubmit->cekpengusul($this->uri->segment(3),$this->session->userdata('sesi_id'));
// // echo $this->db->last_query();exit;
// if($ceksul==0)
// {
// redirect("submit");
// }
// }

?>
<style>
	pre {
		font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
		font-size: 1rem;
		font-weight: 400;
		line-height: 1.5;
		color: #858796;
	}

	.text-dosenluar {
		color: blueviolet;
	}
</style>
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Detail Usulan Penelitian</h1>
	</div>
	<?php
	if ($this->session->flashdata('result') <> '') {
		echo '<div class="alert alert-success" role="alert">' .
			$this->session->flashdata('result') . '
						</div>';
	}
	?>

	<!-- Content Row -->

	<div class="row">

		<div class="col-xl-4 col-lg-5">
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Usulan Penelitian</h6>
				</div>
				<!-- Card Body -->
				<div class="card-body">
					<div class="pt-2 pb-2">
						<div class="row">
							<div class="col-md-4">
								<label>Tanggal Mulai</label>
							</div>
							<div class="col-md-8">
								<p><?php echo tgl_indo($usulan['tglmulai'], 1); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Tanggal Akhir</label>
							</div>
							<div class="col-md-8">
								<p><?php echo tgl_indo($usulan['tglakhir'], 1); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Sumber Dana</label>
							</div>
							<div class="col-md-8">
								<p><?php echo $usulan['sumberdana']; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Jumlah Dana</label>
							</div>
							<div class="col-md-8">
								<p><?php
									$prodinya = $this->mdosen->dosennya($usulan['pengusul']);
									if ($usulan['sumberdana'] == 'Internal' && $usulan['totaldana'] <> 0 && $prodinya['prodi'] == 2) {
										echo 'Internal = ' . rupiah($usulan['totaldana']);
									} elseif ($usulan['sumberdana'] == 'Mandiri+Internal' && $usulan['totaldana'] <> 0 && $prodinya['prodi'] == 2) {
										echo 'Internal = ' . rupiah($usulan['totaldana']);
									} elseif ($usulan['sumberdana'] == 'Mandiri+Internal' && $usulan['totaldana'] <> 0) {
										$total = $this->msubmit->totalrab($usulan['id_usulan']);
										echo 'Total = ' . rupiah($usulan['totaldana']);
										echo '<br>Internal = ' . rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']);
										echo 'Mandiri = ' . rupiah($usulan['totaldana'] - ($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']));
									} else {
										$total = $this->msubmit->totalrab($usulan['id_usulan']);
										if ($total == '')
											echo rupiah(0);
										else
											echo rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']);
									}
									?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>RAB</label>
							</div>
							<div class="col-md-8">
								<p><a href="<?php echo base_url('submit/eksporab/') . $this->uri->segment(3); ?>">Download RAB</a></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Reviewer</label>
								<?php
								$is_dashboardpengusul = false;
								if ($this->session->userdata('sesi_id') == $usulan['pengusul'] || $this->msubmit->cekSesiDosenIsAnggota($usulan['id_usulan'])) {
									$is_dashboardpengusul = true;
								}

								if ($usulan['reviewer'] <> '') {
									$pisah = explode(',', $usulan['reviewer']);
									$hitpisah = count($pisah);
									echo '<ol>';
									$nrev = 1;
									for ($i = 0; $i < $hitpisah; $i++) {
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										if ($is_dashboardpengusul) {
											echo '<li>Reviewer Anonim ' . $nrev . '</li>';
											$nrev++;
										} else {
											echo '<li>' . $revnya['namalengkap'] . '</li>';
										}
									}
									echo '</ol>';
								} else
									echo '-';
								?>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>File Usulan</label>
							</div>
							<div class="col-md-8">
								<p><?php echo '<a href="' . base_url() . 'assets/uploadbox/' . urldecode($usulan['fileusulan']) . '" data-toggle="modal" data-target="#liatfile">Download File Usulan</a>'; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>File Revisi</label>
							</div>
							<div class="col-md-8">
								<?php if ($usulan['filerevisi'] <> '') { ?>
									<p><?php echo '<a href="' . base_url() . 'assets/uploadbox/' . $usulan['filerevisi'] . '" data-toggle="modal" data-target="#liatfilerevisi">Download File Revisi</a>'; ?></p>
								<?php } else {
									echo '-<br>';
								}

								if ($this->session->userdata('sesi_id') == $usulan['pengusul']) {
									echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#revisi-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Unggah Revisi</a>';
								}
								?>
							</div>
						</div>
						<!--<div class="row">
						<div class="col-md-4">
							<label>File Legalisir</label>
						</div>
						<div class="col-md-8">
						<?php
						// if($usulan['legalisir']<>'') { 
						?>
							<p>
						<?php
						// echo '<a href="'.base_url().'assets/uploadbox/'.$usulan['legalisir'].'" data-toggle="modal" data-target="#liatlegal">Download File Legalisir</a>'; 
						?></p>
							<?php
							// if($this->session->userdata('sesi_id')==$usulan['pengusul']) { 
							?>
							<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-legaldoc="" data-usulan="<?php //echo $this->uri->segment(3); 
																																		?>" data-toggle="modal" data-target="#legalisir-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Update Legalisir</a>
						<?php //} }
						// else 
						// {
						// if($this->session->userdata('sesi_id')==$usulan['pengusul']) { 
						// echo '<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-legaldoc="" data-usulan="'.$this->uri->segment(3).'" data-toggle="modal" data-target="#legalisir-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload Legalisir</a>';
						// }
						// }
						?>
						</div>
					</div>-->
						<?php if ($usulan['status'] == 'Usulan Dikirim') { ?>
							<div class="row">
								<div class="col-md-4">
									<label>Submit Tanggal</label>
								</div>
								<div class="col-md-8">
									<p><?php echo tgl_indo($usulan['modified'], 1); ?></p>
								</div>
							</div>
							<?php
						}
						if ($this->session->userdata('sesi_status') <> 1) {
							$id_dosen = $this->mdosen->ambildosen($this->session->userdata('sesi_id'));
							$cekcek = $this->mdosen->isreviewer($id_dosen['id_dosen']);

							$reviewernya = $this->mdosen->cekrevnya($this->session->userdata('sesi_dosen'), $this->uri->segment(3));

							$deal = $this->msubmit->hitanggotausulan($this->session->userdata('sesi_dosen'), $this->uri->segment(3));
							$nudeal = $this->msubmit->nudeal($this->session->userdata('sesi_dosen'), $this->uri->segment(3), "Penelitian");
							// echo 'cek : '.$this->db->last_query();exit;
							// echo $reviewernya;exit();
							$ang = array($usulan['anggotadosen']);
							$cekrevnya = $this->mdosen->cekrevnya($this->session->userdata('sesi_dosen'), $this->uri->segment(3));

							$nuang = $this->msubmit->nuhitanggota($this->session->userdata('sesi_dosen'), $usulan['id_usulan'], 'Penelitian');
							if ($cekcek > 0 && $reviewernya > 0 && $this->session->userdata('sesi_id') <> $usulan['pengusul'] && (!in_array($this->session->userdata('sesi_dosen'), $ang) || $nuang == 0)) {
								$hitrev = $this->msubmit->hitrev($this->uri->segment(3), $this->session->userdata('sesi_id'));
								if ($hitrev > 0) {
									$isianreview = $this->msubmit->lihatisianreview($this->uri->segment(3), $this->session->userdata('sesi_id'));
									echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="' . $this->uri->segment(3) . '" data-toggle="modal" data-catatan="' . $isianreview['hasilreview'] . '" data-skor="' . $isianreview['skor'] . '" data-file="' . $isianreview['filereview'] . '" data-rekomendasi="'.$isianreview['rekomendasi'].'" data-target="#perbaikan-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <?php echo $nomor; ?></a>';
								} else {
									if ($cekrevnya > 0) {
							?>
										<div class="row" style="margin-top:40px">
											<div class="col-md-6">
												<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3); ?>" data-toggle="modal" data-target="#reviewer-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Review Usulan</a>
											</div>
										</div>
							<?php
									}
								}
							} else {
								if ($this->session->userdata('sesi_id') <> $usulan['pengusul'] && ($deal == 0 || $nudeal == 0)) {
									echo '<div class="row" style="margin-top:40px">
								<div class="col-md-6">
									<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#anggota-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Persetujuan Anggota</a>
								</div>
							</div>';
								} elseif ($this->session->userdata('sesi_id') <> $usulan['pengusul'] && ($deal > 0 || $nudeal > 0)) {
									$okdeal = $this->msubmit->anggotausulan($this->session->userdata('sesi_dosen'), $this->uri->segment(3));

									echo '<br><b>Anda ' . $okdeal['setuju'] . ' Menjadi Anggota Penelitian</b>';
								} else {
								}
							}
						}
						$jmldeal = 0;
						$pisah = explode(',', $usulan['anggotadosen']);
						$hitpisah = count($pisah);
						$jmlanggota = $hitpisah;
						if ($usulan['anggotadosen'] <> '') {
							echo '<ol>';
							$okedeal = 0;
							for ($i = 0; $i < $hitpisah; $i++) {
								$okdeal = $this->msubmit->cekanggotasetuju($pisah[$i], $usulan['id_usulan']);

								if ($okdeal > 0) {
									$setok = 'Setuju';
									$jmldeal++;
								} else
									$setok = 'Belum Setuju';
								// $revnya = $this->mdosen->namadosen($pisah[$i]);
								// echo '<li>'.$revnya['namalengkap'].' ('.$setok.')</li>';
							}
							echo '</ol>';
						}

						$cekrab = $this->msubmit->cekrab($this->uri->segment(3));
						if ($usulan['status'] == 'Usulan Baru' && $this->session->userdata('sesi_status') <> 1 && $cekrab > 0 && $this->session->userdata('sesi_id') == $usulan['pengusul'] && $jmldeal == 2) {
							?>
							<div class="row" style="margin-top:40px">
								<div class="col-md-6">
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#kirim-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Kirim Usulan</a>
								</div>
							</div>
							<?php
						}
						if ((($usulan['status'] == 'Reviewed' || $usulan['status'] == 'Usulan Disetujui Reviewer 1' || $usulan['status'] == 'Usulan Disetujui Reviewer 2') && $this->session->userdata('sesi_status') <> 1 && $this->session->userdata('sesi_id') == $usulan['pengusul']) || $this->session->userdata('sesi_status') == 1) {

							$hasilreview = $this->msubmit->lihathasilreview($usulan['id_usulan']);
							$nomor = 1;
							echo '<div class="row" style="margin-top:40px">';
							$nrev = 1;
							$namarev = [];
							foreach ($hasilreview as $h) {
								if ($is_dashboardpengusul) {
									$namarev['namalengkap'] = 'Reviewer Anonimous ' . $nrev;
									$nrev++;
								} else {
									$namarev['namalengkap'] = $this->mdosen->dosennya($h->reviewer);
								}
							?>

								<div class="col-md-6">
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="<?php echo $this->uri->segment(3); ?>" data-toggle="modal" data-catatan="<?php echo $h->hasilreview; ?>" data-skor="<?php echo $h->skor; ?>" data-file="<?php echo $h->filereview; ?>" data-reviewer="<?php echo $namarev['namalengkap']; ?>" data-target="#perbaikan-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <?php echo $namarev['namalengkap']; ?></a>
								</div>

							<?php
								$nomor++;
							}
							echo '</div>';
						}
						if ($usulan['status'] == 'Usulan Disetujui Reviewer 1')
							$statrev = '<p>Reviewer 1 Telah Menyetujui Usulan</p>';
						elseif ($usulan['status'] == 'Usulan Tidak Disetujui Reviewer 1')
							$statrev = '<p>Reviewer 1 Tidak Menyetujui Usulan</p>';
						elseif ($usulan['status'] == 'Usulan Disetujui Reviewer 2')
							$statrev = '<p>Reviewer 2 Telah Menyetujui Usulan</p>';
						elseif ($usulan['status'] == 'Usulan Tidak Disetujui Reviewer 2')
							$statrev = '<p>Reviewer 2 Tidak Menyetujui Usulan</p>';
						else
							$statrev = '<p>Belum ada Persetujuan Reviewer</p>';

						$cekrev = $this->msubmit->lihatisianreview($usulan['id_usulan'], $this->session->userdata('sesi_id'));
						if ($cekrev)
							$namarev = $cekrev['reviewer'];
						else
							$namarev = '';
						// echo $this->db->last_query();
						$sudahcek = $this->msubmit->ceksetuju($usulan['id_usulan']);
						// echo $this->db->last_query();
						//tampilkan nama reviewer yang setuju
						$revsetuju1 = $this->msubmit->revisetuju_usulan($this->uri->segment(3), 'Usulan Disetujui Reviewer 1');
						$hitrevsetuju1 = count($revsetuju1);
						$revsetuju2 = $this->msubmit->revisetuju_usulan($this->uri->segment(3), 'Usulan Disetujui Reviewer 2');
						$hitrevsetuju2 = count($revsetuju2);

						if ($this->session->userdata('sesi_id') == $usulan['pengusul']) {
							//echo $statrev; 
							echo $hitrevsetuju1 > 0 ? '<p><br>Usulan Disetujui oleh : <b>' . $revsetuju1['namalengkap'] . '</b>' : '';
							echo $hitrevsetuju2 > 0 ? ' dan <b>' . $revsetuju2['namalengkap'] . '</b></p>' : '</p>';
						}

						if (($usulan['status'] == 'Reviewed' || $usulan['status'] == 'Usulan Disetujui Reviewer 1' || $usulan['status'] == 'Usulan Disetujui Reviewer 2' || $usulan['status'] == 'Usulan Tidak Disetujui Reviewer 1' || $usulan['status'] == 'Usulan Tidak Disetujui Reviewer 2') && $this->session->userdata('sesi_id') == $namarev && $usulan['filerevisi'] <> '') {
							?>
							<div class="row" style="margin-top:40px">
								<div class="col-md-12">
									<?php
									echo $statrev;
									echo $hitrevsetuju1 > 0 ? '<p>Usulan Disetujui oleh : <b>' . $revsetuju1['namalengkap'] . '</b>' : '';
									echo $hitrevsetuju2 > 0 ? ' dan <b>' . $revsetuju2['namalengkap'] . '</b></p>' : '</p>'
									?>
									<?php //if($statrev=='Usulan Disetujui Reviewer 2'||$statrev=='Usulan Tidak Disetujui Reviewer 2'){ 
									?>
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3); ?>" data-toggle="modal" data-target="#setuju-modal"><i class="fas fa-sticky-note fa-sm text-white"></i> Usulan Disetujui/Ditolak</a>
									<?php //} 
									?>
								</div>
							</div>
						<?php }
						if ($usulan['status'] == 'Usulan Disetujui Reviewer 2' && $this->session->userdata('sesi_status') == 1 && $usulan['filerevisi'] <> '') {
						?>
							<div class="row" style="margin-top:40px">
								<div class="col-md-12">
									<?php
									echo $statrev;
									echo $hitrevsetuju1 > 0 ? '<p>Usulan Disetujui oleh : <b>' . $revsetuju1['namalengkap'] . '</b>' : '';
									echo $hitrevsetuju2 > 0 ? ' dan <b>' . $revsetuju2['namalengkap'] . '</b></p>' : '</p>'
									?>
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3); ?>" data-toggle="modal" data-target="#setuju-modal"><i class="fas fa-sticky-note fa-sm text-white"></i> Usulan Disetujui/Ditolak</a>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Project Card Example -->
		<div class="col-xl-8 col-lg-7">
			<div class="card shadow mb-4">
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Detail Usulan Penelitian</h6>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<label>Judul Penelitian</label>
						</div>
						<div class="col-md-8">
							<p><?php echo ucwords(strtolower($usulan['judul'])); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Skema</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $usulan['skema']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Luaran</label>
						</div>
						<div class="col-md-8">
							<?php
							$pisah = explode(',', $usulan['luaran']);
							$n = count($pisah);
							echo '<ol style="margin-left:-23px;margin-top:-2dc px">';
							for ($i = 0; $i < $n; $i++) {
								echo '<li>' . $pisah[$i] . '</li>';
							}
							echo '</ol>';
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Nama Jurnal</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $usulan['namajurnal']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Ketua</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php
								$ketua = $this->mdosen->dosennya($usulan['pengusul']);
								echo $ketua['namalengkap'];
								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Anggota Dosen</label>
						</div>
						<div class="col-md-8">
							<span>
								<?php
								$angg = $this->msubmit->perananggota($usulan['id_usulan'], 'Penelitian');
								$hits = count($angg);

								$anggdosenluar = $this->msubmit->perananggotadosenluar($usulan['id_usulan'], 'Penelitian');
								$hitsdosenluar = count($anggdosenluar);
								if ($hits > 0 || $hitsdosenluar > 0) {
									echo '<ol>';
									foreach ($angg as $a) {
										if (($hits + $hitsdosenluar) == 1) {
											echo $a->namalengkap . '<br>';
											echo 'Peran : ' . $a->tugas;
										} else {
											echo '<li>' . $a->namalengkap . '<br>Peran : ' . $a->tugas . '</li>';
										}
									}
									foreach ($anggdosenluar as $adl) {
										if (($hits + $hitsdosenluar) == 1) {
											echo $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>';
											echo 'Peran : ' . $adl->tugas;
										} else {
											echo '<li class="text-dosenluar">' . $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>Peran : ' . $adl->tugas . '</li>';
										}
									}
									echo '</ol>';
								} else {


									$hit = 0;
									if ($usulan['anggotadosen'] <> '') {
										$posisi = strpos($usulan['anggotadosen'], ',');
										if ($posisi !== false) {
											$ambil = explode(',', $usulan['anggotadosen']);
										} else {
											$ambil[0] = $usulan['anggotadosen'];
										}
										$hit = count($ambil);
									}
									//$ambil = explode(',',$usulan['anggotadosen']);
									//$hit = count($ambil);
									$hitangg = $this->msubmit->hitangg($usulan['id_usulan']);

									if ($usulan['anggotadosen'] <> '' && $hitangg == 0) {
										if (($hit + $hitsdosenluar) > 1)
											echo '<ol style="margin-left:-23px;margin-top:-17px">';
										for ($i = 0; $i < $hit; $i++) {
											$dosen = $this->mdosen->namadosen($ambil[$i]);
											if ($hit > 1)
												echo '<li>' . $dosen['namalengkap'] . '</li>';
											else
												echo $dosen['namalengkap'];
										}

										foreach ($anggdosenluar as $adl) {
											if (($hit + $hitsdosenluar) == 1) {
												echo $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>';
												echo 'Peran : ' . $adl->tugas;
											} else {
												echo '<li class="text-dosenluar">' . $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>Peran : ' . $adl->tugas . '</li>';
											}
										}


										if (($hit + $hitsdosenluar) > 1)
											echo '</ol>';
									} elseif ($usulan['anggotadosen'] <> '' && $hitangg > 0) {
										$angg = $this->msubmit->perananggota($usulan['id_usulan'], 'Penelitian');
										$hits = count($angg);
										echo '<ol>';
										foreach ($angg as $a) {
											if (($hits + $hitsdosenluar) == 1) {
												echo $a->namalengkap . '<br>';
												echo 'Peran : ' . $a->tugas;
											} else {
												echo '<li>' . $a->namalengkap . '<br>Peran : ' . $a->tugas . '</li>';
											}
										}

										foreach ($anggdosenluar as $adl) {
											if (($hits + $hitsdosenluar) == 1) {
												echo $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>';
												echo 'Peran : ' . $adl->tugas;
											} else {
												echo '<li class="text-dosenluar">' . $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>Peran : ' . $adl->tugas . '</li>';
											}
										}

										echo '</ol>';
									} elseif ($usulan['anggotadosen'] == '' && $hitangg > 0) {
										$angg = $this->msubmit->perananggota($usulan['id_usulan'], 'Penelitian');
										$hits = count($angg);
										echo '<ol>';
										foreach ($angg as $a) {
											if (($hits + $hitsdosenluar) == 1) {
												echo $a->namalengkap . '<br>';
												echo 'Peran : ' . $a->tugas;
											} else {
												echo '<li>' . $a->namalengkap . '<br>Peran : ' . $a->tugas . '</li>';
											}
										}
										foreach ($anggdosenluar as $adl) {
											if (($hits + $hitsdosenluar) == 1) {
												echo $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>';
												echo 'Peran : ' . $adl->tugas;
											} else {
												echo '<li class="text-dosenluar">' . $adl->namalengkap . ' dari ' . $adl->namadepartmen . ', ' . $adl->namainstitusi . ' ' . $adl->negara_institusi . '<br>Peran : ' . $adl->tugas . '</li>';
											}
										}
										echo '</ol>';
									} else
										echo 'Tidak Ada Anggota Dosen';
								}
								?>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Anggota Mahasiswa</label>
						</div>
						<div class="col-md-8">
							<span>
								<?php
								$angg = $this->msubmit->peranmhs($usulan['id_usulan'], 'Penelitian');
								$hits = count($angg);
								if ($hits == 0) {
									$angg = $this->msubmit->peranmhsid($usulan['id_usulan'], 'Penelitian');
									$hits = count($angg);
								}

								if (count($angg) > 0) {
									echo '<ol>';
									foreach ($angg as $a) {
										if ($hits == 1) {
											echo $a->namamhs . '<br>';
											echo 'Peran : ' . $a->tugas;
										} else {
											echo '<li>' . $a->namamhs . '<br>Peran : ' . $a->tugas . '</li>';
										}
									}
									echo '</ol>';
								} else {


									$hit = 0;
									if ($usulan['anggotamhs'] <> '') {
										$posisi = strpos($usulan['anggotamhs'], ',');
										if ($posisi !== false) {
											$ambil = explode(',', $usulan['anggotamhs']);
										} else {
											$ambil[0] = $usulan['anggotamhs'];
										}
										$hit = count($ambil);
									}

									//$ambil = explode(',',$usulan['anggotamhs']);
									//$hit = count($ambil);
									$hitangg = $this->msubmit->hitangg($usulan['id_usulan'], "mhs");

									if ($usulan['anggotamhs'] <> '' && $hitangg == 0 && $hit > 0) {
										echo '<pre>' . $usulan['anggotamhs'] . '</pre>';
									} elseif ($usulan['anggotamhs'] <> '' && $hitangg == 0 && $hit > 0) {
										//$split = explode(',',$usulan['anggotamhs']);
										//$jumsplit = count($split);
										if ($hit > 0)
											echo '<ol style="margin-left:-23px">';
										for ($i = 0; $i < $hit; $i++) {
											$namamhs = $this->msubmit->namamhs($ambil[$i]);
											$prodi = $this->mdosen->namaprodi($namamhs['prodi']);
											if ($hit > 0)
												echo '<li>' . $namamhs['namamhs'] . ' ( ' . $prodi['prodi'] . ' )</li>';
											else
												echo $namamhs['namamhs'] . ' ( ' . $prodi['prodi'] . ' )';
										}
										if ($hit > 0)
											echo '</ol>';
									} elseif ($usulan['anggotamhs'] <> '' && $hitangg > 0 && $hit > 0) {
										$angg = $this->msubmit->peranmhs($usulan['id_usulan'], 'Penelitian');
										$hits = count($angg);
										if ($hits == 0) {
											$angg = $this->msubmit->peranmhsid($usulan['id_usulan'], 'Penelitian');
											$hits = count($angg);
										}
										echo '<ol>';
										foreach ($angg as $a) {
											if ($hits == 1) {
												echo $a->namamhs . '<br>';
												echo 'Peran : ' . $a->tugas;
											} else {
												echo '<li>' . $a->namamhs . '<br>Peran : ' . $a->tugas . '</li>';
											}
										}
										echo '</ol>';
									} else
										echo 'Tidak Ada Anggota Mahasiswa';
								}
								?>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Ringkasan</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $usulan['ringkasan']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Kata Kunci</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $usulan['katakunci']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="liatfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">File Usulan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<embed src="<?php echo base_url() . 'assets/uploadbox/' . $usulan['fileusulan']; ?>"
					frameborder="0" width="100%" height="400px">

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="liatfilerevisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">File Revisi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<embed src="<?php echo base_url() . 'assets/uploadbox/' . $usulan['filerevisi']; ?>"
					frameborder="0" width="100%" height="400px">

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Modal Persetujuan Anggota -->
<div class="modal fade" id="anggota-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Persetujuan Anggota Penelitian</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url() . 'submit/simpananggotasetuju/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Persetujuan Anggota Penelitian :</label>
						<input type="hidden" name="jenis" value="Penelitian">
						<input type="hidden" name="anggota" value="<?php echo $this->session->userdata('sesi_dosen'); ?>">
						<select name="setuju" class="form-control">
							<?php
							$jenis = array('Setuju', 'Tidak Setuju');

							$n = count($jenis);
							for ($i = 0; $i < $n; $i++) {
								echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
							}
							?>
						</select>
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

<!-- Modal -->
<div class="modal fade" id="liatlegal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">File Legalisir</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<embed src="<?php echo base_url() . 'assets/uploadbox/' . $usulan['legalisir']; ?>"
					frameborder="0" width="100%" height="400px">

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- Modal Perbaikan Baru -->
<div class="modal fade" id="perbaikan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Hasil Review</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Kriteria Penilaian</th>
							<th scope="col">Bobot</th>
							<th scope="col" width="14%">Skor (1-4)</th>
							<th scope="col">Nilai</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>
								Latar Belakang dan Perumusan Masalah :<br>
								<ol type="a">
									<li>Ketajaman Perumusan Masalah</li>
									<li>Tujuan Penelitian</li>
									<li>Spesifikasi keterkaitan topik penelitian dengan keunggulan PT (ketahanan nasional)</li>
								</ol>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Rumusan masalah tidak tajam dan tujuan penelitian tidak jelas</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Rumusan masalah kurang jelas dan kurang tajam, tujuan penelitian jelas</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Rumusan masalah jelas dan tajam akan tetapi tujuan jelas tetapi tidak terdapat uraian spesifikasi keterkaitan skema dengan bidang fokus atau renstra penelitian perguruan tinggi.</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Rumusan masalah jelas dan tajam akan tetapi tujuan jelas, serta terdapat uraian spesifikasi keterkaitan skema dengan bidang fokus atau renstra penelitian perguruan tinggi.</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor1"></b></td>
							<td><b class="revnilai1"></b></td>
						</tr>
						<tr>
							<td>2</td>
							<td>
								State of the art dan kebaruan :<br>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Tidak ada kebaruan dan tidak ada state of the art</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Kebaruan kurang signifikan namun ada state of the art</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Kebaruan cukup signifikan dan ada state of the art</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Kebaruan sangat signifikan dan ada state of the art</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor2"></b></td>
							<td><b class="revnilai2"></b></td>
						</tr>
						<tr>
							<td>3</td>
							<td>
								Kesesuaian dengan Roadmap Penelitian Program Studi dan Universitas
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Tidak ada roadmap</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Ada roadmap namun tidak jelas. Roadmap penelitian dosen tidak sesuai dengan roadmap program studi tetapi masih bisa dipayungi oleh roadmap universitas</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Roadmap jelas namun tidak ada penelitian sebelumnya yang mendasari, dan tidak ada keterkaitan antara milestone dengan usulan penelitian. Roadmap penelitian dosen tidak sesuai dengan roadmap program studi tetapi sesuai dengan keilmuan program studi</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Roadmap jelas, ada penelitian sebelumnya yang mendasari, dan ada keterkaitan antara milestone dengan usulan penelitian. Roadmap penelitian dosen sesuai dengan roadmap program studi dan universitas</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor3"></b></td>
							<td><b class="revnilai3"></b></td>
						</tr>
						<tr>
							<td>4</td>
							<td>
								Ketepatan dan kesesuaian metode yang digunakan
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Metode tidak tepat dan tidak sesuai dengan tujuan penelitian. Tidak terdapat diagram alir penelitian.</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Metode kurang tepat untuk menjawab tujuan penelitian. Diagram alir penelitian belum sesuai dengan tahapan penelitian.</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Metode tepat, diagram alir penelitian sesuai tahapan penelitian, tetapi belum mencantumkan tugas masing-masing anggota pengusul</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Metode tepat, diagram alir penelitian sesuai tahapan penelitian, dan mencantumkan tugas masing-masing anggota pengusul.</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor4"></b></td>
							<td><b class="revnilai4"></b></td>
						</tr>
						<tr>
							<td>5</td>
							<td>
								Kejelasan pembagian tugas tim peneliti dan keterlibatan mahasiswa MBKM<br>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Tidak ada pembagian tim</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Ada pembagian tim tapi tidak jelas</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Pembagian tim jelas tapi ada yang tidak sesuai dengan kepakaran.</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Pembagian tim jelas dan sesuai dengan kepakaran.</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor5"></b></td>
							<td><b class="revnilai5"></b></td>
						</tr>
						<tr>
							<td>6</td>
							<td>
								Kesesuaian metode dengan waktu, luaran dan anggaran<br>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Metode tidak sinkron dengan waktu, luaran, dan fasilitas</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Metode ada yang sinkron dengan 1 kondisi diantara waktu, luaran, dan fasilitas</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Metode ada yang sinkron dengan 2 kondisi diantara waktu, luaran, dan fasilitas</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Secara keseluruhan metode sinkron dengan waktu, luaran, dan fasilitas</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor6"></b></td>
							<td><b class="revnilai6"></b></td>
						</tr>
						<tr>
							<td>7</td>
							<td>
								Kesesuaian target TKT<br>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Penjelasan TKT tidak ada</td>
									</tr>
									<tr>
										<td>2</td>
										<td>TKT tidak sesuai</td>
									</tr>
									<tr>
										<td>3</td>
										<td>TKT kurang sesuai</td>
									</tr>
									<tr>
										<td>4</td>
										<td>TKT sesuai.</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor7"></b></td>
							<td><b class="revnilai7"></b></td>
						</tr>
						<tr>
							<td>8</td>
							<td>
								Kebaruan referensi<br>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Tidak ada pustaka primer</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Pustaka tergolong primer dan mutakhir kurang dari 50%</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Pustaka tergolong primer dan mutakhir sejumlah 51-80%</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Pustaka tergolong primer dan mutakhir lebih besar 80%</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor8"></b></td>
							<td><b class="revnilai8"></b></td>
						</tr>
						<tr>
							<td>9</td>
							<td>
								Relevansi dan kualitas referensi<br>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Referensi tidak relevan dan ada yang tidak disitasi dalam proposal</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Sebagian referensi tidak relevan</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Referensi relevan namun sebagian jurnal tidak bereputasi dan berdampak</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Referensi relevan dan dari jurnal bereputasi dan berdampak</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor9"></b></td>
							<td><b class="revnilai9"></b></td>
						</tr>
						<tr>
							<td>10</td>
							<td>
								Peluang luaran penelitian<br>
								<ol type="a">
									<li>Publikasi Ilmiah</li>
									<li>Pengembangan iptek Sosial Budaya</li>
									<li>Pengayaan Bahan Ajar</li>
									<li>HKI</li>
								</ol>
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Tidak terdapat rencana publikasi ilmiah, tidak terdapat pengembangan iptek sosial budaya, tidak terdapat pengayaan bahan ajar, dan HAKI</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Terdapat perencanaan publikasi ilmiah, tapi tidak terdapat perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan tidak terdapat HAKI</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Terdapat perencanaan publikasi ilmiah, perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan tidak terdapat perencanaan HAKI</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Terdapat perencanaan publikasi ilmiah, perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan HAKI.</td>
									</tr>
								</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor10"></b></td>
							<td><b class="revnilai10"></b></td>
						</tr>
						<tr>
							<td colspan="2">Jumlah Nilai</td>
							<td><b>100</b></td>
							<td></td>
							<td><b class="revtotalnilai"></b></td>
						</tr>
					</tbody>
				</table>
				<?php
				//if($this->session->userdata('sesi_status')==1) {
				echo '<b>Nama Reviewer :</b>';
				//}
				if ($usulan['reviewer'] <> '') {
					$pisah = explode(',', $usulan['reviewer']);
					$hitpisah = count($pisah);
					echo '<ol>';
					$nrev = 1;
					for ($i = 0; $i < $hitpisah; $i++) {
						$revnya = $this->mdosen->namadosen($pisah[$i]);
						if ($is_dashboardpengusul) {
							echo '<li>Reviewer Anonim ' . $nrev . '</li>';
							$nrev++;
						} else {
							echo '<li>' . $revnya['namalengkap'] . '</li>';
						}
					}
					echo '</ol>';
				} else
					echo '-';

				?>
				<b>Catatan dari Reviewer :</b>
				<pre><p class="catatan"></p></pre>
				<b>Rekomendasi dari Reviewer :</b>
				<pre><p class="rekomendasi"></p></pre>
				<b>Silakan Download File Hasil Review</b>
				<p id="tautanfile"></p>
				<form name="kirimrevisi" method="post" action="<?php echo base_url() . 'submit/simpanperbaikan/' . $usulan['id_usulan']; ?>" enctype="multipart/form-data">
					<?php if ($this->session->userdata('sesi_id') == $usulan['pengusul'] && ($usulan['filerevisi'] == '' || $usulan['status'] == 'Reviewed')) { ?>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Revisi:</label>
							<input type="file" name="revisi" class="form-control unggah">
						</div>
					<?php } ?>
			</div>
			<div class="modal-footer">
				<?php if ($this->session->userdata('sesi_id') == $usulan['pengusul'] && ($usulan['filerevisi'] == '' || $usulan['status'] == 'Reviewed')) { ?>
					<button type="submit" class="btn btn-primary kirim" style="color:white">Kirim Revisi</button>
				<?php
				}
				echo '</form>';
				$lihat = $this->msubmit->lihatisianreview($usulan['id_usulan'], $this->session->userdata('sesi_id'));
				$hitlihat = count($lihat);
				if ($hitlihat > 0 && $this->session->userdata('sesi_id') == $lihat['reviewer'] && ($usulan['status'] <> 'Usulan Disetujui' || $usulan['status'] <> 'Usulan Tidak Disetujui')) { ?>
					<a href="<?php echo base_url() . 'submit/editreview/' . $this->uri->segment(3); ?>" type="button" class="btn btn-warning" style="color:white">Edit Review</a>
				<?php } ?>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Persetujuan -->
<div class="modal fade" id="setuju-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Usulan Disetujui/Tidak</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url() . 'submit/simpansetuju/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Usulan Disetujui/Tidak :</label>
						<select name="setuju" class="form-control">
							<?php
							if ($this->session->userdata('sesi_status') == 1 && $usulan['status'] == 'Usulan Disetujui Reviewer 2')
								$jenis = array('Usulan Disetujui', 'Usulan Tidak Disetujui');
							elseif ($this->session->userdata('sesi_status') <> 1 && $usulan['status'] == 'Usulan Disetujui Reviewer 1')
								$jenis = array('Usulan Disetujui Reviewer 2', 'Usulan Tidak Disetujui Reviewer 2');
							else
								$jenis = array('Usulan Disetujui Reviewer 1', 'Usulan Tidak Disetujui Reviewer 1');

							$n = count($jenis);
							for ($i = 0; $i < $n; $i++) {
								echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
							}
							?>
						</select>
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

<!-- Modal Upload Revisi -->
<div class="modal fade" id="revisi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Unggah Revisi Usulan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form name="kirimrevisi" method="post" action="<?php echo base_url() . 'submit/simpanperbaikan/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">File Revisi:</label>
						<input type="file" name="revisi" class="form-control unggah">
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-success kirim" disabled>Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Reviewer -->
<div class="modal fade" id="reviewer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tuliskan Hasil Review Usulan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url() . 'submit/simpanreview/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Kriteria Penilaian</th>
								<th scope="col">Bobot</th>
								<th scope="col" width="14%">Skor (1-4)</th>
								<th scope="col">Nilai</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>
									Latar Belakang dan Perumusan Masalah :<br>
									<ol type="a">
										<li>Ketajaman Perumusan Masalah</li>
										<li>Tujuan Penelitian</li>
										<li>Spesifikasi keterkaitan topik penelitian dengan keunggulan PT (ketahanan nasional)</li>
									</ol>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Rumusan masalah tidak tajam dan tujuan penelitian tidak jelas</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Rumusan masalah kurang jelas dan kurang tajam, tujuan penelitian jelas</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Rumusan masalah jelas dan tajam akan tetapi tujuan jelas tetapi tidak terdapat uraian spesifikasi keterkaitan skema dengan bidang fokus atau renstra penelitian perguruan tinggi.</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Rumusan masalah jelas dan tajam akan tetapi tujuan jelas, serta terdapat uraian spesifikasi keterkaitan skema dengan bidang fokus atau renstra penelitian perguruan tinggi.</td>
										</tr>
									</table>
								</td>
								<td><b id="skor1">10</b></td>
								<td><input type="text" name="poinsatu" data-poin="10" onkeyup="satu(value)" class="form-control rev" required></td>
								<td><b id="nilai1">0</b></td>
							</tr>
							<tr>
								<td>2</td>
								<td>
									State of the art dan kebaruan :<br>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Tidak ada kebaruan dan tidak ada state of the art</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Kebaruan kurang signifikan namun ada state of the art</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Kebaruan cukup signifikan dan ada state of the art</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Kebaruan sangat signifikan dan ada state of the art</td>
										</tr>
									</table>
								</td>
								<td><b id="skor2">10</b></td>
								<td><input type="text" name="poindua" data-poin="10" onkeyup="dua(value)" class="form-control rev" required></td>
								<td><b id="nilai2">0</b></td>
							</tr>
							<tr>
								<td>3</td>
								<td>
									Kesesuaian dengan Roadmap Penelitian Program Studi dan Universitas
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Tidak ada roadmap</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Ada roadmap namun tidak jelas. Roadmap penelitian dosen tidak sesuai dengan roadmap program studi tetapi masih bisa dipayungi oleh roadmap universitas</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Roadmap jelas namun tidak ada penelitian sebelumnya yang mendasari, dan tidak ada keterkaitan antara milestone dengan usulan penelitian. Roadmap penelitian dosen tidak sesuai dengan roadmap program studi tetapi sesuai dengan keilmuan program studi</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Roadmap jelas, ada penelitian sebelumnya yang mendasari, dan ada keterkaitan antara milestone dengan usulan penelitian. Roadmap penelitian dosen sesuai dengan roadmap program studi dan universitas</td>
										</tr>
									</table>
								</td>
								<td><b id="skor3">10</b></td>
								<td><input type="text" name="pointiga" data-poin="10" onkeyup="tiga(value)" class="form-control rev" required></td>
								<td><b id="nilai3">0</b></td>
							</tr>
							<tr>
								<td>4</td>
								<td>
									Ketepatan dan kesesuaian metode yang digunakan
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Metode tidak tepat dan tidak sesuai dengan tujuan penelitian. Tidak terdapat diagram alir penelitian.</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Metode kurang tepat untuk menjawab tujuan penelitian. Diagram alir penelitian belum sesuai dengan tahapan penelitian.</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Metode tepat, diagram alir penelitian sesuai tahapan penelitian, tetapi belum mencantumkan tugas masing-masing anggota pengusul</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Metode tepat, diagram alir penelitian sesuai tahapan penelitian, dan mencantumkan tugas masing-masing anggota pengusul.</td>
										</tr>
									</table>
								</td>
								<td><b id="skor4">10</b></td>
								<td><input type="text" name="poinempat" data-poin="10" onkeyup="empat(value)" class="form-control rev" required></td>
								<td><b id="nilai4">0</b></td>
							</tr>
							<tr>
								<td>5</td>
								<td>
									Kejelasan pembagian tugas tim peneliti dan keterlibatan mahasiswa MBKM<br>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Tidak ada pembagian tim</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Ada pembagian tim tapi tidak jelas</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Pembagian tim jelas tapi ada yang tidak sesuai dengan kepakaran.</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Pembagian tim jelas dan sesuai dengan kepakaran.</td>
										</tr>
									</table>
								</td>
								<td><b id="skor5">10</b></td>
								<td><input type="text" name="poinlima" data-poin="10" onkeyup="lima(value)" class="form-control rev" required></td>
								<td><b id="nilai5">0</b></td>
							</tr>
							<tr>
								<td>6</td>
								<td>
									Kesesuaian metode dengan waktu, luaran dan anggaran<br>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Metode tidak sinkron dengan waktu, luaran, dan fasilitas</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Metode ada yang sinkron dengan 1 kondisi diantara waktu, luaran, dan fasilitas</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Metode ada yang sinkron dengan 2 kondisi diantara waktu, luaran, dan fasilitas</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Secara keseluruhan metode sinkron dengan waktu, luaran, dan fasilitas</td>
										</tr>
									</table>
								</td>
								<td><b id="skor6">10</b></td>
								<td><input type="text" name="poinenam" data-poin="10" onkeyup="enam(value)" class="form-control rev" required></td>
								<td><b id="nilai6">0</b></td>
							</tr>
							<tr>
								<td>7</td>
								<td>
									Kesesuaian target TKT<br>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Penjelasan TKT tidak ada</td>
										</tr>
										<tr>
											<td>2</td>
											<td>TKT tidak sesuai</td>
										</tr>
										<tr>
											<td>3</td>
											<td>TKT kurang sesuai</td>
										</tr>
										<tr>
											<td>4</td>
											<td>TKT sesuai.</td>
										</tr>
									</table>
								</td>
								<td><b id="skor7">10</b></td>
								<td><input type="text" name="pointujuh" data-poin="10" onkeyup="tujuh(value)" class="form-control rev" required></td>
								<td><b id="nilai7">0</b></td>
							</tr>
							<tr>
								<td>8</td>
								<td>
									Kebaruan referensi<br>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Tidak ada pustaka primer</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Pustaka tergolong primer dan mutakhir kurang dari 50%</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Pustaka tergolong primer dan mutakhir sejumlah 51-80%</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Pustaka tergolong primer dan mutakhir lebih besar 80%</td>
										</tr>
									</table>
								</td>
								<td><b id="skor8">10</b></td>
								<td><input type="text" name="poinlapan" data-poin="10" onkeyup="lapan(value)" class="form-control rev" required></td>
								<td><b id="nilai8">0</b></td>
							</tr>
							<tr>
								<td>9</td>
								<td>
									Relevansi dan kualitas referensi<br>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Referensi tidak relevan dan ada yang tidak disitasi dalam proposal</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Sebagian referensi tidak relevan</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Referensi relevan namun sebagian jurnal tidak bereputasi dan berdampak</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Referensi relevan dan dari jurnal bereputasi dan berdampak</td>
										</tr>
									</table>
								</td>
								<td><b id="skor9">10</b></td>
								<td><input type="text" name="poinsembilan" data-poin="10" onkeyup="sembilan(value)" class="form-control rev" required></td>
								<td><b id="nilai9">0</b></td>
							</tr>
							<tr>
								<td>10</td>
								<td>
									Peluang luaran penelitian<br>
									<ol type="a">
										<li>Publikasi Ilmiah</li>
										<li>Pengembangan iptek Sosial Budaya</li>
										<li>Pengayaan Bahan Ajar</li>
										<li>HKI</li>
									</ol>
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Tidak terdapat rencana publikasi ilmiah, tidak terdapat pengembangan iptek sosial budaya, tidak terdapat pengayaan bahan ajar, dan HAKI</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Terdapat perencanaan publikasi ilmiah, tapi tidak terdapat perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan tidak terdapat HAKI</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Terdapat perencanaan publikasi ilmiah, perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan tidak terdapat perencanaan HAKI</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Terdapat perencanaan publikasi ilmiah, perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan HAKI.</td>
										</tr>
									</table>
								</td>
								<td><b id="skor10">10</b></td>
								<td><input type="text" name="poinsepuluh" data-poin="10" onkeyup="sepuluh(value)" class="form-control rev" required></td>
								<td><b id="nilai10">0</b></td>
							</tr>
							<tr>
								<td colspan="2">Jumlah Nilai</td>
								<td><b>100</b></td>
								<td></td>
								<td><b id="jmlnilai">0</b></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Hasil Review:</label>
						<input type="hidden" name="id" class="form-control" id="idusulanya">
						<textarea rows="5" name="review" class="form-control" id="review" required></textarea>
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">File Review:</label>
						<input type="file" name="hasilreview" class="form-control unggah" id="hasilreview">
					</div>
					<div class="form-group">
						<label for="rekomendasi" class="col-form-label">Rekomendasi:</label>
						<select id="rekomendasi" name="rekomendasi" class="form-control rekomendasi">
							<option value="Direkomendasikan">Direkomendasikan</option>
							<option value="Direkomendasikan Turun skema">Direkomendasikan Turun skema</option>
							<option value="Tidak direkomendasikan">Tidak direkomendasikan</option>
						</select>
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
				<form method="post" action="<?php echo base_url() . 'submit/kirim/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
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

<!-- Modal Kirim Usulan Akhir dengan Pengesahan -->
<div class="modal fade" id="legalisir-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Usulan dengan Pengesahan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url() . 'submit/simpanlegalisir/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">File Usulan dangan Pengesahan (PDF) maksimal 20Mb :</label>
						<input type="hidden" id="idlegalisir" name="id">
						<input type="file" id="filelegalisir" name="fileupload" class="form-control" placeholder="File Usulan dengan Pengesahan(PDF)">
						<!--<label for="recipient-name" class="col-form-label">File Usulan dangan Pengesahan : 
			<b id="cekupload"></b></label>-->

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

	$(document).on('input', '.rev', function() {
    var value = $(this).val();
    this.value = this.value.replace(/[^0-9.]/g, '');

    // Paksa batas 1-4
    if (value !== "") {
        if (parseFloat(value) > 4) $(this).val(4);
        if (parseFloat(value) < 1) $(this).val(1);
    }
	});

	function satu(ish) {
		document.getElementById("nilai1").innerHTML = 10 * ish;
	}

	function dua(ish) {
		document.getElementById("nilai2").innerHTML = 10 * ish;
	}

	function tiga(ish) {
		document.getElementById("nilai3").innerHTML = 10 * ish;
	}

	function empat(ish) {
		document.getElementById("nilai4").innerHTML = 10 * ish;
	}

	function lima(ish) {
		document.getElementById("nilai5").innerHTML = 10 * ish;
	}

	function enam(ish) {
		document.getElementById("nilai6").innerHTML = 10 * ish;
	}

	function tujuh(ish) {
		document.getElementById("nilai7").innerHTML = 10 * ish;
	}

	function lapan(ish) {
		document.getElementById("nilai8").innerHTML = 10 * ish;
	}

	function sembilan(ish) {
		document.getElementById("nilai9").innerHTML = 10 * ish;
	}

	function sepuluh(ish) {
		document.getElementById("nilai10").innerHTML = 10 * ish;
	}

	$('.modal-body').on('input', function() {
		var totalSum = 0;

		$('.modal-body .rev').each(function() {
			var inputVal = $(this).val();
			var inputSkor = $(this).data('poin');
			var year = <?php echo date('Y', strtotime($usulan['modified'])); ?>;
			var month = <?php echo date('m', strtotime($usulan['modified'])); ?>;
			// if($.isNumeric(inputVal) && year>=2023 && month>9){
			if ($.isNumeric(inputVal) && (year >= 2023 && (year <= 2024 && month < 5))) {
				totalSum += parseFloat((inputVal * inputSkor) / 4);
			} else if ($.isNumeric(inputVal) && (year >= 2024 && month >= 5)) {
				totalSum += parseFloat((inputVal * inputSkor) / 4);
			} else if (year == 2025) {
				totalSum += parseFloat((inputVal * inputSkor) / 7);
			} else {
				totalSum += parseFloat((inputVal * inputSkor) / 4);
			}
		});
		document.getElementById("jmlnilai").innerHTML = totalSum.toFixed(4);
	});

	$(document).on("click", ".pencet", function() {
		var catatan = $(this).data('catatan');
		var reviewer = $(this).data('reviewer');
		var rekomendasi = $(this).data('rekomendasi');
		var file = $(this).data('file');
		var skor = $(this).data('skor');
		var skorarray = skor.split(',');
		var year = <?php echo date('Y', strtotime($usulan['modified'])); ?>;
		var month = <?php echo date('m', strtotime($usulan['modified'])); ?>;

		// if(year>=2023 && month>9)
		if (year >= 2023 && (year <= 2024 && month < 5))
			var total = ((skorarray[0] * 20) + (skorarray[1] * 15) + (skorarray[2] * 20) + (skorarray[3] * 15) + (skorarray[4] * 10) + (skorarray[5] * 20)) / 4;
		else if (year >= 2024 && month >= 5)
			var total = ((skorarray[0] * 10) + (skorarray[1] * 10) + (skorarray[2] * 10) + (skorarray[3] * 10) + (skorarray[4] * 10) + (skorarray[5] * 10) + (skorarray[6] * 10) + (skorarray[7] * 10) + (skorarray[8] * 10) + (skorarray[9] * 10)) / 4;
		else if (year == 2025){
			var total = ((skorarray[0] * 20) + (skorarray[1] * 15) + (skorarray[2] * 20) + (skorarray[3] * 15) + (skorarray[4] * 10) + (skorarray[5] * 20)) / 7;
		} else {
			var total = ((skorarray[0] * 10) + (skorarray[1] * 10) + (skorarray[2] * 10) + (skorarray[3] * 10) + (skorarray[4] * 10) + (skorarray[5] * 10) + (skorarray[6] * 10) + (skorarray[7] * 10) + (skorarray[8] * 10) + (skorarray[9] * 10)) / 4;			
		}
		
		$(".modal-body .revskor1").text(skorarray[0]);
		$(".modal-body .revnilai1").text(10 * skorarray[0]);
		$(".modal-body .revskor2").text(skorarray[1]);
		$(".modal-body .revnilai2").text(10 * skorarray[1]);
		$(".modal-body .revskor3").text(skorarray[2]);
		$(".modal-body .revnilai3").text(10 * skorarray[2]);
		$(".modal-body .revskor4").text(skorarray[3]);
		$(".modal-body .revnilai4").text(10 * skorarray[3]);
		$(".modal-body .revskor5").text(skorarray[4]);
		$(".modal-body .revnilai5").text(10 * skorarray[4]);
		$(".modal-body .revskor6").text(skorarray[5]);
		$(".modal-body .revnilai6").text(10 * skorarray[5]);
		$(".modal-body .revskor7").text(skorarray[6]);
		$(".modal-body .revnilai7").text(10 * skorarray[6]);
		$(".modal-body .revskor8").text(skorarray[7]);
		$(".modal-body .revnilai8").text(10 * skorarray[7]);
		$(".modal-body .revskor9").text(skorarray[8]);
		$(".modal-body .revnilai9").text(10 * skorarray[8]);
		$(".modal-body .revskor10").text(skorarray[9]);
		$(".modal-body .revnilai10").text(10 * skorarray[9]);
		$(".modal-body .revtotalnilai").text(total.toFixed(4));
		$(".modal-body .reviewer").text(reviewer);
		$(".modal-body .rekomendasi").text(rekomendasi);
		$(".modal-body .catatan").text(catatan);
		if (file == '') {
			var str = "Tidak Ada File";
			var result = str.link("");
		} else {
			var str = "Download File";
			var result = str.link("https://simlitabmas.unjaya.ac.id/assets/uploadbox/" + file);
		}
		document.getElementById("tautanfile").innerHTML = result;
	});

	$(document).ready(function() {
		$('#reviewer-modal').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
			var modal = $(this)

			// Isi nilai pada field
			modal.find('#idusulanya').attr("value", div.data('usulan'));
		});
	});

	$('.unggah').bind('change', function() {
		var ukuran = this.files[0].size / 1024 / 1024;
		var modal = $(this);
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);

		if (ukuran > 20) {
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			$(".kirim").attr('disabled', true);
		} else if (extension != 'pdf') {
			alert('Silakan upload file dengan ekstensi PDF!');
			$(".kirim").attr('disabled', true);
		} else if (extension == 'pdf' && ukuran > 20) {
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			$(".kirim").attr('disabled', true);
		} else {
			$(".kirim").attr('disabled', false);
		}
	});

	$(document).ready(function() {
		$('#legalisir-modal').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
			var modal = $(this)

			// Isi nilai pada field
			modal.find('#idlegalisir').attr("value", div.data('usulan'));
			modal.find('#cekupload').html(div.data('legaldoc'));
		});
	});
</script>