<?php
// if($this->session->userdata('sesi_status')<>1) {
// $ceksul = $this->mpengabdian->cekpengusul($this->uri->segment(3),$this->session->userdata('sesi_id'));
// // echo $this->db->last_query();exit;
// if($ceksul==0)
// {
// redirect("pengabdian");
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
		<h1 class="h3 mb-0 text-gray-800">Detail Usulan PkM</h1>
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
					<h6 class="m-0 font-weight-bold text-primary">Usulan PkM</h6>
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
									} elseif ($usulan['sumberdana'] == 'Mandiri+Internal' && $usulan['jmldana'] <> 0) {
										$total = $this->mpengabdian->totalrab($usulan['id_usulan']);
										echo 'Total = ' . rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']);
										echo '<br>Internal = ' . rupiah($usulan['jmldana']);
										echo 'Mandiri = ' . rupiah(($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']) - $usulan['jmldana']);
									} elseif ($usulan['sumberdana'] == 'Mandiri+Internal' && $usulan['totaldana'] <> 0 && $prodinya['prodi'] == 2) {
										echo 'Internal = ' . rupiah($usulan['totaldana']);
									} else {
										$total = $this->mpengabdian->totalrab($usulan['id_usulan']);
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
								<p><a href="<?php echo base_url('pengabdian/eksporab/') . $this->uri->segment(3); ?>">Download RAB</a></p>
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
										$nrev++;
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
								<p><?php echo '<a href="' . base_url() . 'assets/uploadbox/' . $usulan['fileusulan'] . '" data-toggle="modal" data-target="#liatfile">Download File Usulan</a>'; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>File Revisi</label>
							</div>
							<div class="col-md-8">
								<?php if ($usulan['filerevisi'] <> '') { ?>
									<p><?php echo '<a href="' . base_url() . 'assets/uploadbox/' . $usulan['filerevisi'] . '" data-toggle="modal" data-target="#liatfilerevisi">Download File Revisi</a>'; ?></p>
								<?php } else
									echo '-';
								?>
							</div>
						</div>
						<!--<div class="row">
							<div class="col-md-4">
								<label>File Legalisir</label>
							</div>
							<div class="col-md-8">
								<?php //if($usulan['legalisir']<>'') { 
								?>
									<p><?php //echo '<a href="'.base_url().'assets/uploadbox/'.$usulan['legalisir'].'" data-toggle="modal" data-target="#liatlegal">Download File Legalisir</a>'; 
										?></p>
									<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-legaldoc="" data-usulan="<?php //echo $this->uri->segment(3);
																																				?>" data-toggle="modal" data-target="#legalisir-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Update Legalisir</a>
									<?php //}
									//elseif($usulan['legalisir']=='' && $usulan['filerevisi']<>'') 
									//{
									//echo '<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-legaldoc="" data-usulan="'.$this->uri->segment(3).'" data-toggle="modal" data-target="#legalisir-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload Legalisir</a>';
									// }
									// else 
									// {
									// echo '<a href="" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" data-legaldoc="" data-usulan="'.$this->uri->segment(3).'" data-toggle="modal" data-target="#"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload Legalisir</a>';
									//}
									?>
							</div>
						</div>-->
						<?php if ($usulan['status'] == 'Usulan Dikirim') { ?>
							<div class="row">
								<div class="col-md-4">
									<label>pengabdian Tanggal</label>
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

							$reviewernya = $this->mdosen->reviewernya($this->session->userdata('sesi_id'));
							$deal = $this->mpengabdian->hitanggotausulan($this->session->userdata('sesi_dosen'), $this->uri->segment(3));

							if ($cekcek > 0 && $reviewernya == 0 && $this->session->userdata('sesi_id') <> $usulan['pengusul']) {
								$getidrev = $this->mpengabdian->getidrev($usulan['reviewer']);
								if ((count($getidrev)) > 0) {
									$readrev = $this->mpengabdian->hitrev($this->uri->segment(3), $getidrev['user']);

									$hitrev = $this->mpengabdian->hitrev($this->uri->segment(3), $this->session->userdata('sesi_id'));
									if ($hitrev > 0 || $readrev > 0) {
										$isianreview = $this->mpengabdian->lihatisianreview($this->uri->segment(3), $getidrev['user']);
										echo '<br><a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="' . $this->uri->segment(3) . '" data-toggle="modal" data-catatan="' . $isianreview['hasilreview'] . '" data-skor="' . $isianreview['skor'] . '" data-file="' . $isianreview['filereview'] . '" data-target="#perbaikan-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <?php echo $nomor; ?></a>';
									} elseif ($hitrev == 0 && $this->session->userdata('sesi_dosen') == $usulan['reviewer']) {
							?>
										<div class="row" style="margin-top:40px">
											<div class="col-md-6">
												<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3); ?>" data-toggle="modal" data-target="#reviewer-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Review Usulan</a>
											</div>
										</div>
								<?php
									}
								}
							}
						}

						$cekrab = $this->mpengabdian->cekrab($this->uri->segment(3));
						if ($usulan['status'] == 'Usulan Baru' && $this->session->userdata('sesi_status') <> 1 && $cekrab > 0) {
							//cek apakah semua anggota sudah menyetujui untuk menjadi anggota penelitian, jika ini dashboard pengusul maka kirim usulan hanya bisa dilakukan ketika semua anggota sudah menyetujui untuk menjadi anggota penelitian, jika ini dashboard anggoa, maka anggota hanya bisa menyetujui untuk menjadi anggota penelitian jika belum menyetujui dan belum menolak, jika sudah menyetujui atau sudah menolak maka tidak bisa menyetujui atau menolak lagi
							$getAllanggota = $this->mpengabdian->getAllanggota($this->uri->segment(3), 'Dosen', 'Pengabdian');
							$jumlahanggotasetuju = 0;
							if (count($getAllanggota) > 0) {
								foreach ($getAllanggota as $anggota) {
									if ($anggota->setuju == 'Setuju') {
										$jumlahanggotasetuju++;
									}
								}
							}


							if ($this->session->userdata('sesi_id') == $usulan['pengusul']) {
								if ($jumlahanggotasetuju == count($getAllanggota)) {
									echo '
									<div class="row" style="margin-top:40px">
										<div class="col-md-6">
											<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#kirim-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Kirim Usulan</a>
										</div>
									</div>
									';
								} else {
									echo '<div class="row" style="margin-top:40px">
										<div class="col-md-6">
											<p>Menunggu Persetujuan Anggota Dosen</p>
										</div>
									</div>';
								}
							} else {
								if ($this->session->userdata('sesi_id') <> $usulan['pengusul']) {
									if (count($getAllanggota) > 0) {
										foreach ($getAllanggota as $anggota) {
											if ($anggota->anggota == $this->session->userdata('sesi_dosen')) {
												//echo '<h1>' . $anggota->anggota . ' - = - ' . $this->session->userdata('sesi_dosen') . '</h1><br>';
												if ($anggota->setuju == 'Setuju') {
													echo '<div class="row" style="margin-top:40px">
														<div class="col-md-12">
															<p>Anda Telah Menyetujui untuk Menjadi Anggota pada ' . tgl_indo($anggota->modifsetuju, 1) . '</p>
														</div>
													</div>';
												} elseif ($anggota->setuju == 'Tidak Setuju') {
													echo '<div class="row" style="margin-top:40px">
														<div class="col-md-6">
															<p>Anda Telah Menolak untuk Menjadi Anggota pada ' . tgl_indo($anggota->modifsetuju, 1) . '</p>
														</div>
														<div class="col-md-6">
																<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#anggota-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Persetujuan Anggota</a>
														</div>
													</div>';
												} else {
													echo '<div class="row" style="margin-top:40px">
															<div class="col-md-12">
																<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#anggota-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Persetujuan Anggota</a>
															</div>
														</div>';
												}
											}
										}
									}
								}
							}
						}
						if ((($usulan['status'] == 'Reviewed' || $usulan['status'] == 'Usulan Disetujui Reviewer') && $this->session->userdata('sesi_status') <> 1 && $this->session->userdata('sesi_id') == $usulan['pengusul']) || $this->session->userdata('sesi_status') == 1) {

							$hasilreview = $this->mpengabdian->lihathasilreview($usulan['id_usulan']);
							$nomor = 1;
							echo '<div class="row" style="margin-top:40px">';
							$nrev = 1;
							foreach ($hasilreview as $h) {
								if ($is_dashboardpengusul) {
									$namarev = [];
									$namarev['namalengkap'] = 'Reviewer Anonim ' . $nrev;
									$nrev++;
								} else {
									$namarev = $this->mdosen->dosennya($h->reviewer);
								}
								?>
								<div class="col-md-6">
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="<?php echo $this->uri->segment(3); ?>" data-toggle="modal" data-catatan="<?php echo $h->hasilreview; ?>" data-skor="<?php echo $h->skor; ?>" data-file="<?php echo $h->filereview; ?>" data-reviewer="<?php echo $namarev['namalengkap']; ?>" data-target="#perbaikan-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <br><?php echo $namarev['namalengkap']; ?></a>
								</div>

							<?php
								$nomor++;
							}
							echo '</div>';
						}
						if ($usulan['status'] == 'Usulan Disetujui Reviewer')
							$statrev = '<p>Reviewer Telah Menyetujui Usulan</p>';
						elseif ($usulan['status'] == 'Usulan Tidak Disetujui Reviewer')
							$statrev = '<p>Reviewer Tidak Menyetujui Usulan</p>';
						else
							$statrev = '<p>Belum ada Persetujuan Reviewer</p>';

						$cekrev = $this->mpengabdian->lihatisianreview($usulan['id_usulan'], $this->session->userdata('sesi_id'));
						if ($cekrev)
							$namarev = $cekrev['reviewer'];
						else
							$namarev = '';
						// echo $this->db->last_query();
						$sudahcek = $this->mpengabdian->ceksetuju($usulan['id_usulan']);
						// echo $this->db->last_query();
						if (($usulan['status'] == 'Reviewed' || $usulan['status'] == 'Usulan Disetujui Reviewer' || $usulan['status'] == 'Usulan Tidak Disetujui Reviewer') && $this->session->userdata('sesi_id') == $namarev && $usulan['filerevisi'] <> '') {
							?>
							<div class="row" style="margin-top:40px">
								<div class="col-md-12">
									<?php echo $statrev; ?>
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
					<h6 class="m-0 font-weight-bold text-primary">Detail Usulan PkM</h6>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<label>Judul PkM</label>
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
								$angg = $this->msubmit->perananggota($usulan['id_usulan'], 'Pengabdian');
								$hits = count($angg);

								$anggdosenluar = $this->msubmit->perananggotadosenluar($usulan['id_usulan'], 'Pengabdian');
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

									$ambil = explode(',', $usulan['anggotadosen']);
									$hit = count($ambil);
									$hitangg = $this->msubmit->hitangg($usulan['id_usulan']);

									if ($usulan['anggotadosen'] <> '' && $hitangg == 0) {
										if (($hit + $hitsdosenluar) > 1)
											echo '<ol style="margin-left:-23px;margin-top:-17px">';
										for ($i = 0; $i < $hit; $i++) {
											$dosen = $this->mdosen->namadosen($ambil[$i]);
											if (($hit + $hitsdosenluar) > 1)
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
									} elseif ($usulan['anggotadosen'] == '' && $hitangg > 0) {
										$angg = $this->msubmit->perananggota($usulan['id_usulan'], 'Pengabdian');
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
								$angg = $this->msubmit->peranmhs($usulan['id_usulan'], 'Pengabdian');
								$hits = count($angg);
								if ($hits > 0) {
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
									$ambil = explode(',', $usulan['anggotamhs']);
									$hit = count($ambil);
									$hitangg = $this->mpengabdian->hitangg($usulan['id_usulan']);

									if ($usulan['anggotamhs'] <> '' && $hitangg == 0 && $hit == 1) {
										echo '<pre>' . $usulan['anggotamhs'] . '</pre>';
									} elseif ($usulan['anggotamhs'] <> '' && $hitangg == 0 && $hit > 1) {
										$split = explode(',', $usulan['anggotamhs']);
										$jumsplit = count($split);
										if ($jumsplit > 1)
											echo '<ol style="margin-left:-23px">';
										for ($i = 0; $i < $jumsplit; $i++) {
											$namamhs = $this->msubmit->namamhs($split[$i]);
											$prodi = $this->mdosen->namaprodi($namamhs['prodi']);
											if ($jumsplit > 1)
												echo '<li>' . $namamhs['namamhs'] . ' ( ' . $prodi['prodi'] . ' )</li>';
											else
												echo $namamhs['namamhs'] . ' ( ' . $prodi['prodi'] . ' )';
										}
										if ($jumsplit > 1)
											echo '</ol>';
									} elseif ($usulan['anggotamhs'] == '' && $hitangg > 0) {
										$angg = $this->msubmit->peranmhs($usulan['id_usulan'], 'Pengabdian');
										$hits = count($angg);
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
					<div class="row">
						<div class="col-md-4">
							<label>Sumber Penelitian</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php
								if ($usulan['sumberpkm'] == '' || $usulan['sumberpkm'] == 'Tidak Ada')
									echo 'Tidak Ada';
								else {
									$judulriset = $this->mpengabdian->judulriset($usulan['sumberpkm']);
									echo $judulriset['judul'];
								}
								?>
							</p>
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
<div class="modal fade" id="liatlegal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">File Usulan</h5>
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

<!-- Modal Perbaikan -->
<div class="modal fade" id="perbaikan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
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
								Analisis Situasi (masalah yang diangkat sebagai latar belakang)
								<table class="table table-bordered">
									<tr>
										<th>Skor</th>
										<th>Keterangan</th>
									</tr>
									<tr>
										<td>1</td>
										<td>Latar belakang masalah yang diuraikan tidak menggambarkan analisis situasi yang ada pada lokasi pengabdian</td>
									</tr>
									<tr>
										<td>2</td>
										<td>Latar belakang masalah yang diuraikan kurang menggambarkan analisis situasi yang ada pada lokasi pengabdian</td>
									</tr>
									<tr>
										<td>3</td>
										<td>Latar belakang masalah yang diuraikan cukup menggambarkan analisis situasi yang ada pada lokasi pengabdian</td>
									</tr>
									<tr>
										<td>4</td>
										<td>Latar belakang masalah yang diuraikan sudah menggambarkan analisis situasi yang ada pada lokasi pengabdian.</td>
									</tr>
								</table>
							</td>
							<td><b>20</b></td>
							<td><b class="revskor1"></b></td>
							<td><b class="revnilai1"></b></td>
						</tr>
						<tr>
							<td>2</td>
							<td>
								Kecocokan permasalahan dengan program serta kompetensi tim
							</td>
							<td><b>15</b></td>
							<td><b class="revskor2"></b></td>
							<td><b class="revnilai2"></b></td>
						</tr>
						<tr>
							<td>3</td>
							<td>
								Solusi yang ditawarkan (Ketepatan Metode pendekatan untuk mengatasi permasalahan, Rencana kegiatan, kontribusi partisipasi tim)
							</td>
							<td><b>20</b></td>
							<td><b class="revskor3"></b></td>
							<td><b class="revnilai3"></b></td>
						</tr>
						<tr>
							<td>4</td>
							<td>
								Target Luaran (Jenis luaran dan spesifikasinya sesuai kegiatan yang diusulkan)
							</td>
							<td><b>15</b></td>
							<td><b class="revskor4"></b></td>
							<td><b class="revnilai4"></b></td>
						</tr>
						<tr>
							<td>5</td>
							<td>
								Kesesuaian dengan fokus unggulan road map unggulan program studi
							</td>
							<td><b>10</b></td>
							<td><b class="revskor5"></b></td>
							<td><b class="revnilai5"></b></td>
						</tr>
						<tr>
							<td>6</td>
							<td>
								Pengabdian merupakan tindak lanjut dari hasil penelitian
							</td>
							<td><b>10</b></td>
							<td><b class="revskor6"></b></td>
							<td><b class="revnilai6"></b></td>
						</tr>
						<tr>
							<td>7</td>
							<td>
								Keterkaitan dengan proses pembelajaran
							</td>
							<td><b>10</b></td>
							<td><b class="revskor7"></b></td>
							<td><b class="revnilai7"></b></td>
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
				echo '<b>Nama Reviewer :</b><p class="reviewer"></p>';
				//}
				?>
				<b>Catatan dari Reviewer :</b>
				<pre><p class="catatan"></p></pre>
				<b>Silakan Download File Hasil Review</b>
				<p id="tautanfile"></p>
				<form name="kirimrevisi" method="post" action="<?php echo base_url() . 'pengabdian/simpanperbaikan/' . $usulan['id_usulan']; ?>" enctype="multipart/form-data">
					<?php if ($this->session->userdata('sesi_id') == $usulan['pengusul'] && ($usulan['filerevisi'] == '' || $usulan['status'] == 'Reviewed')) { ?>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Revisi * : <b style="color:red" id="rednotis"></b></label>
							<input type="file" name="revisi" id="inputrevisi" class="form-control unggah" required>
						</div>
					<?php } ?>
			</div>
			<div class="modal-footer">
				<?php if ($this->session->userdata('sesi_id') == $usulan['pengusul'] && ($usulan['filerevisi'] == '' || $usulan['status'] == 'Reviewed')) { ?>
					<button type="button" id="tombolrevisi" onclick="cekup()" class="btn btn-primary" style="color:white">Kirim Revisi</button>
				<?php
				}
				echo '</form>';
				$lihat = $this->mpengabdian->lihatisianreview($usulan['id_usulan'], $this->session->userdata('sesi_id'));
				$hitlihat = count($lihat);
				if ($hitlihat > 0 && $this->session->userdata('sesi_id') == $lihat['reviewer'] && ($usulan['status'] <> 'Usulan Disetujui' || $usulan['status'] <> 'Usulan Tidak Disetujui')) { ?>
					<a href="<?php echo base_url() . 'pengabdian/editreview/' . $this->uri->segment(3); ?>" type="button" class="btn btn-warning" style="color:white">Edit Review</a>
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
				<form method="post" action="<?php echo base_url() . 'pengabdian/simpansetuju/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Usulan Disetujui/Tidak :</label>
						<select name="setuju" class="form-control">
							<?php
							if ($this->session->userdata('sesi_status') == 1 && $usulan['status'] == 'Usulan Disetujui Reviewer')
								$jenis = array('Usulan Disetujui', 'Usulan Tidak Disetujui');
							else
								$jenis = array('Usulan Disetujui Reviewer', 'Usulan Tidak Disetujui Reviewer');

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

<!-- Modal Persetujuan Anggota -->
<div class="modal fade" id="anggota-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Persetujuan Anggota Pengabdian</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url() . 'pengabdian/simpananggotasetuju/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">Persetujuan Anggota Pengabdian :</label>
						<input type="hidden" name="jenis" value="Pengabdian">
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

<!-- Modal Reviewer -->
<div class="modal fade" id="reviewer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tuliskan Hasil Review Usulan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url() . 'pengabdian/simpanreview/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
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
									Analisis Situasi (masalah yang diangkat sebagai latar belakang)
									<table class="table table-bordered">
										<tr>
											<th>Skor</th>
											<th>Keterangan</th>
										</tr>
										<tr>
											<td>1</td>
											<td>Latar belakang masalah yang diuraikan tidak menggambarkan analisis situasi yang ada pada lokasi pengabdian</td>
										</tr>
										<tr>
											<td>2</td>
											<td>Latar belakang masalah yang diuraikan kurang menggambarkan analisis situasi yang ada pada lokasi pengabdian</td>
										</tr>
										<tr>
											<td>3</td>
											<td>Latar belakang masalah yang diuraikan cukup menggambarkan analisis situasi yang ada pada lokasi pengabdian</td>
										</tr>
										<tr>
											<td>4</td>
											<td>Latar belakang masalah yang diuraikan sudah menggambarkan analisis situasi yang ada pada lokasi pengabdian.</td>
										</tr>
									</table>
								</td>
								<td><b id="skor1">20</b></td>
								<td><input type="text" name="poinsatu" data-poin="20" onkeyup="satu(value)" class="form-control rev" required></td>
								<td><b id="nilai1">0</b></td>
							</tr>
							<tr>
								<td>2</td>
								<td>
									Kecocokan permasalahan dengan program serta kompetensi tim
								</td>
								<td><b id="skor2">15</b></td>
								<td><input type="text" name="poindua" data-poin="15" onkeyup="dua(value)" class="form-control rev" required></td>
								<td><b id="nilai2">0</b></td>
							</tr>
							<tr>
								<td>3</td>
								<td>
									Solusi yang ditawarkan (Ketepatan Metode pendekatan untuk mengatasi permasalahan, Rencana kegiatan, kontribusi partisipasi tim)
								</td>
								<td><b id="skor3">20</b></td>
								<td><input type="text" name="pointiga" data-poin="20" onkeyup="tiga(value)" class="form-control rev" required></td>
								<td><b id="nilai3">0</b></td>
							</tr>
							<tr>
								<td>4</td>
								<td>
									Target Luaran (Jenis luaran dan spesifikasinya sesuai kegiatan yang diusulkan)
								</td>
								<td><b id="skor4">15</b></td>
								<td><input type="text" name="poinempat" data-poin="15" onkeyup="empat(value)" class="form-control rev" required></td>
								<td><b id="nilai4">0</b></td>
							</tr>
							<tr>
								<td>5</td>
								<td>
									Kesesuaian dengan fokus unggulan road map unggulan program studi
								</td>
								<td><b id="skor5">10</b></td>
								<td><input type="text" name="poinlima" data-poin="10" onkeyup="lima(value)" class="form-control rev" required></td>
								<td><b id="nilai5">0</b></td>
							</tr>
							<tr>
								<td>6</td>
								<td>
									Pengabdian merupakan tindak lanjut dari hasil penelitian
								</td>
								<td><b id="skor6">10</b></td>
								<td><input type="text" name="poinenam" data-poin="10" onkeyup="enam(value)" class="form-control rev" required></td>
								<td><b id="nilai6">0</b></td>
							</tr>
							<tr>
								<td>7</td>
								<td>
									Keterkaitan dengan proses pembelajaran
								</td>
								<td><b id="skor7">10</b></td>
								<td><input type="text" name="pointujuh" data-poin="10" onkeyup="tujuh(value)" class="form-control rev" required></td>
								<td><b id="nilai7">0</b></td>
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
				<form method="post" action="<?php echo base_url() . 'pengabdian/kirim/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
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
				<form method="post" action="<?php echo base_url() . 'pengabdian/simpanlegalisir/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
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
	function satu(ish) {
		document.getElementById("nilai1").innerHTML = 20 * ish;
	}

	function dua(ish) {
		document.getElementById("nilai2").innerHTML = 15 * ish;
	}

	function tiga(ish) {
		document.getElementById("nilai3").innerHTML = 20 * ish;
	}

	function empat(ish) {
		document.getElementById("nilai4").innerHTML = 15 * ish;
	}

	function lima(ish) {
		document.getElementById("nilai5").innerHTML = 10 * ish;
	}

	function enam(ish) {
		document.getElementById("nilai6").innerHTML = 10 * ish;
		var six = document.getElementById("nilai6").innerHTML = 10 * ish;
	}

	function tujuh(ish) {
		document.getElementById("nilai7").innerHTML = 10 * ish;
		var seven = document.getElementById("nilai7").innerHTML = 10 * ish;
	}

	function cekup() {
		var notif = document.getElementById('rednotis');
		var file = document.getElementById("inputrevisi");

		if (file.files.length == 0) {
			document.getElementById("tombolrevisi").type = 'button';
			notif.innerHTML = "Anda Belum Menginputkan File Revisi";
		} else {
			notif.innerHTML = "";
			document.getElementById("tombolrevisi").type = 'submit';
		}
	}

	$('.modal-body').on('input', function() {
		var totalSum = 0;

		$('.modal-body .rev').each(function() {
			var inputVal = $(this).val();
			var inputSkor = $(this).data('poin');
			var year = <?php echo date('Y', strtotime($usulan['modified'])); ?>;
			var month = <?php echo date('m', strtotime($usulan['modified'])); ?>;
			if ($.isNumeric(inputVal) && year >= 2024) {
				totalSum += parseFloat((inputVal * inputSkor) / 4);
			} else {
				totalSum += parseFloat((inputVal * inputSkor) / 7);
			}
		});
		document.getElementById("jmlnilai").innerHTML = totalSum.toFixed(4);
	});

	$(document).on("click", ".pencet", function() {
		var catatan = $(this).data('catatan');
		var reviewer = $(this).data('reviewer');
		var file = $(this).data('file');
		var skor = $(this).data('skor');
		var skorarray = skor.split(',');
		var year = <?php echo date('Y', strtotime($usulan['modified'])); ?>;
		var month = <?php echo date('m', strtotime($usulan['modified'])); ?>;

		if (year >= 2024)
			var total = ((skorarray[0] * 20) + (skorarray[1] * 15) + (skorarray[2] * 20) + (skorarray[3] * 15) + (skorarray[4] * 10) + (skorarray[5] * 10) + (skorarray[6] * 10)) / 4;
		else
			var total = ((skorarray[0] * 20) + (skorarray[1] * 15) + (skorarray[2] * 20) + (skorarray[3] * 15) + (skorarray[4] * 10) + (skorarray[5] * 10) + (skorarray[6] * 10)) / 7;

		$(".modal-body .revskor1").text(skorarray[0]);
		$(".modal-body .revnilai1").text(20 * skorarray[0]);
		$(".modal-body .revskor2").text(skorarray[1]);
		$(".modal-body .revnilai2").text(15 * skorarray[1]);
		$(".modal-body .revskor3").text(skorarray[2]);
		$(".modal-body .revnilai3").text(20 * skorarray[2]);
		$(".modal-body .revskor4").text(skorarray[3]);
		$(".modal-body .revnilai4").text(15 * skorarray[3]);
		$(".modal-body .revskor5").text(skorarray[4]);
		$(".modal-body .revnilai5").text(10 * skorarray[4]);
		$(".modal-body .revskor6").text(skorarray[5]);
		$(".modal-body .revnilai6").text(10 * skorarray[5]);
		$(".modal-body .revskor7").text(skorarray[6]);
		$(".modal-body .revnilai7").text(10 * skorarray[6]);
		$(".modal-body .revtotalnilai").text(total.toFixed(4));
		$(".modal-body .reviewer").text(reviewer);
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
		fileName = document.querySelector('.unggah').value;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if (ukuran > 20)
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
		if (extension != 'pdf')
			alert('Silakan upload file dengan ekstensi PDF!');
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