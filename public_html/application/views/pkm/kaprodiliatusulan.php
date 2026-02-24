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
									$total = $this->mpengabdian->totalrab($usulan['id_usulan']);
									echo rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor'])
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
								if ($usulan['reviewer'] <> '') {
									$pisah = explode(',', $usulan['reviewer']);
									$hitpisah = count($pisah);
									echo '<ol>';
									for ($i = 0; $i < $hitpisah; $i++) {
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										echo '<li>' . $revnya['namalengkap'] . '</li>';
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
								<?php if ($usulan['filerevisi_kaprodi'] <> '') { ?>
									<p><?php echo '<a href="' . base_url() . 'assets/uploadbox/' . $usulan['filerevisi_kaprodi'] . '" data-toggle="modal" data-target="#liatfilerevisi">Download File Revisi</a>'; ?></p>
								<?php } else
									echo '-';
								?>
							</div>
						</div>
						<?php if ($usulan['status'] == 'Usulan Dikirim') { ?>
							<div class="row">
								<div class="col-md-4">
									<label>Submit Tanggal</label>
								</div>
								<div class="col-md-8">
									<p><?php echo tgl_indo($usulan['modified'], 1); ?></p>
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
							<p><?php echo $usulan['judul']; ?></p>
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
							<p>
								<?php
								$id_usulan = $this->uri->segment(3);
								$angg = $this->msubmit->perananggota($id_usulan, 'Pengabdian');
								$hits = count($angg);

								$anggdosenluar = $this->msubmit->perananggotadosenluar($p->id_usulan, 'Pengabdian');
								$hitsdosenluar = count($anggdosenluar);
								if ($hits > 0) {
									echo '<ol>';
									foreach ($angg as $a) {
										//cek persetujuan
										$deal = $this->mpengabdian->hitanggotausulan($a->id, $id_usulan);
										$okdeal = $this->mpengabdian->anggotausulan($a->id, $id_usulan);
										if ($deal > 0)
											$setuju = '<span class="badge badge-success">' . $okdeal['setuju'] . '</span>';
										else
											$setuju = '<span class="badge badge-warning">Belum Respon</span>';

										if (($hits + $hitsdosenluar) == 1) {
											echo $a->namalengkap . '( <b>' . $setuju . '</b> )<br>';
											echo 'Peran : ' . $a->tugas;
										} else {
											echo '<li>' . $a->namalengkap . ' ( <b>' . $setuju . '</b> )<br>Peran : ' . $a->tugas . '</li>';
										}
									}
									if ($hitsdosenluar > 0) {
										foreach ($anggdosenluar as $a) {
											if (($hits + $hitsdosenluar) == 1) {
												echo $a->namalengkap . ' dari ' . $a->namadepartmen . ', ' . $a->namainstitusi . ' ' . $a->negara_institusi . '<br>';
												echo 'Peran : ' . $a->tugas;
											} else {
												echo '<li class="text-dosenluar">' . $a->namalengkap . ' dari ' . $a->namadepartmen . ', ' . $a->namainstitusi . ' ' . $a->negara_institusi . '<br>Peran : ' . $a->tugas . '</li>';
											}
										}
									}
									echo '</ol>';
								} else {

									$ambil = explode(',', $usulan['anggotadosen']);
									$hit = count($ambil);

									if ($usulan['anggotadosen'] <> '') {
										echo '<ol style="margin-left:-23px;margin-top:-17px">';
										$setuju = '';
										$okdeal = '';
										for ($i = 0; $i < $hit; $i++) {
											//cek persetujuan
											$deal = $this->mpengabdian->hitanggotausulan($ambil[$i], $this->uri->segment(3));
											$okdeal = $this->mpengabdian->anggotausulan($ambil[$i], $this->uri->segment(3));
											if ($deal > 0)
												$setuju = '<span class="badge badge-success">' . $okdeal['setuju'] . '</span>';
											else
												$setuju = '<span class="badge badge-warning">Belum Respon</span>';

											$dosen = $this->mdosen->namadosen($ambil[$i]);
											echo '<li>' . $dosen['namalengkap'] . ' ( <b>' . $setuju . '</b> )</li>';
										}
										if ($hitsdosenluar > 0) {
											foreach ($anggdosenluar as $a) {
												echo '<li class="text-dosenluar">' . $a->namalengkap . ' dari ' . $a->namadepartmen . ', ' . $a->namainstitusi . ' ' . $a->negara_institusi . '<br>Peran : ' . $a->tugas . '</li>';
											}
										}
										echo '</ol>';
									} else
										echo 'Tidak Ada Anggota Dosen';
								}

								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Anggota Mahasiswa</label>
						</div>
						<div class="col-md-8">
							<pre><p><?php echo $usulan['anggotamhs']; ?></p></pre>
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
				<h5 class="modal-title" id="exampleModalLabel">File Usulan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<embed src="<?php echo base_url() . 'assets/uploadbox/' . $usulan['filerevisi_kaprodi']; ?>"
					frameborder="0" width="100%" height="400px">

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>

		</div>
	</div>
</div>