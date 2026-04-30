<?php
if ($this->session->userdata('sesi_user') == '') {
	header('location:' . base_url() . 'login');
}
?>
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Daftar Usulan Baru</h1>
		<?php
		//cek skema
		$skemapkm = array();
		$angka_skor_sinta = (int) str_replace('.', '', $this->session->userdata('sesi_sinta'));

		if (($this->session->userdata('sesi_jafung') == 'Tenaga Pengajar' || $this->session->userdata('sesi_jafung') == 'Asisten Ahli')
			&& $this->session->userdata('sesi_sinta') >= 0 && ($this->session->userdata('sesi_jenjang') == 'S2'
				|| $this->session->userdata('sesi_jenjang') == 'S3')
		) {
			// echo '<li>Riset Pemula (RisLa)</li>';
			array_push($skemapkm, 'Pemberdayaan Masyarakat Pemula (PMP)');
		}
		if (($this->session->userdata('sesi_jafung') == 'Asisten Ahli' || $this->session->userdata('sesi_jafung') == 'Lektor'
				|| $this->session->userdata('sesi_jafung') == 'Lektor Kepala' || $this->session->userdata('sesi_jafung') == 'Profesor')
			&& ($angka_skor_sinta >= 25) && ($this->session->userdata('sesi_jenjang') == 'S2'
				|| $this->session->userdata('sesi_jenjang') == 'S3')
		) {
			// echo '<li>Riset Fundamental (RisFun)</li>';
			array_push($skemapkm, 'Pemberdayaan Kemitraan Masyarakat (PKM)');
		}
		if (($this->session->userdata('sesi_jafung') == 'Asisten Ahli' || $this->session->userdata('sesi_jafung') == 'Lektor'
				|| $this->session->userdata('sesi_jafung') == 'Lektor Kepala' || $this->session->userdata('sesi_jafung') == 'Profesor')
			&& ($angka_skor_sinta >= 25) && ($this->session->userdata('sesi_jenjang') == 'S2'
				|| $this->session->userdata('sesi_jenjang') == 'S3')
		) {
			//echo '<li>Riset Kejuangan (RisJuang)</li>';
			array_push($skemapkm, 'Pemberdayaan Masyarakat oleh Mahasiswa (PMM)');
		}
		if (($this->session->userdata('sesi_jafung') == 'Lektor' || $this->session->userdata('sesi_jafung') == 'Lektor Kepala'
			|| $this->session->userdata('sesi_jafung') == 'Profesor') && (($this->session->userdata('sesi_fakultas') <> 3
			&& $angka_skor_sinta >= 50) || ($this->session->userdata('sesi_fakultas') == 3
			&& $angka_skor_sinta >= 25)) && ($this->session->userdata('sesi_jenjang') == 'S2'
			|| $this->session->userdata('sesi_jenjang') == 'S3')) {
			// echo '<li>Riset Kerjasama (RisKer)</li>';
			array_push($skemapkm, 'Kewirausahaan berbasis Mahasiswa (KBM)');
		}

		if (($this->session->userdata('sesi_jafung') == 'Lektor' || $this->session->userdata('sesi_jafung') == 'Lektor Kepala'
			|| $this->session->userdata('sesi_jafung') == 'Profesor') && (($this->session->userdata('sesi_fakultas') <> 3
			&& $angka_skor_sinta >= 50) || ($this->session->userdata('sesi_fakultas') == 3
			&& $angka_skor_sinta >= 25)) && ($this->session->userdata('sesi_jenjang') == 'S2'
			|| $this->session->userdata('sesi_jenjang') == 'S3')) {
			// echo '<li>Riset Terapan Hilirisasi (Risterasi)</li>';
			array_push($skemapkm, 'Pemberdayaan Mitra Usaha Produk Unggulan Daerah (PM-UPUD)');
		}
		if (($this->session->userdata('sesi_jafung') == 'Lektor' || $this->session->userdata('sesi_jafung') == 'Lektor Kepala'
			|| $this->session->userdata('sesi_jafung') == 'Profesor') && (($this->session->userdata('sesi_fakultas') <> 3
			&& $angka_skor_sinta >= 50) || ($this->session->userdata('sesi_fakultas') == 3
			&& $angka_skor_sinta >= 25)) && ($this->session->userdata('sesi_jenjang') == 'S2'
			|| $this->session->userdata('sesi_jenjang') == 'S3')) {
			// echo '<li>Riset Mandatory (RisMa)</li>';
			array_push($skemapkm, 'Pemberdayaan Berbasis Desa Binaan (PDB)');
		}

		if (($this->session->userdata('sesi_jafung') == 'Lektor' || $this->session->userdata('sesi_jafung') == 'Lektor Kepala'
			|| $this->session->userdata('sesi_jafung') == 'Profesor') && (($this->session->userdata('sesi_fakultas') <> 3
			&& $angka_skor_sinta >= 50) || ($this->session->userdata('sesi_fakultas') == 3
			&& $angka_skor_sinta >= 25)) && ($this->session->userdata('sesi_jenjang') == 'S2'
			|| $this->session->userdata('sesi_jenjang') == 'S3')) {
			// echo '<li>Riset Pengembangan (Risbang)</li>';
			array_push($skemapkm, 'Pemberdayaan Berbasis Lembaga');
		}
		if (($this->session->userdata('sesi_jenjang') == 'S2' || $this->session->userdata('sesi_jenjang') == 'S3')) {
			// echo '<li>Riset Pengembangan (Risbang)</li>';
			array_push($skemapkm, 'Pemberdayaan Berbasis Mandiri');
		}
		$hitskema = count($skemapkm);
		$this->session->set_userdata('sesi_skema', $skemapkm);

		$cek = $this->mpengabdian->cekbuka($this->session->userdata('sesi_id'));
		if (!$cek && $this->session->userdata('sesi_status') <> 3)
			$cek['status'] = 0;
		// if($cek['status']==1) {
		?>
		<a href="<?php
					$hitque = $this->mpengabdian->sudahisibelum();
					$hitlampau = $this->mpengabdian->hitketualampau();
					$hitgenap = $this->mpengabdian->hitketua('Genap');
					$hitgasal = $this->mpengabdian->hitketua('Gasal');
					if ($this->session->userdata('sesi_status') <> 1 && $hitque == 0 && $cekusulan == 0)
						echo base_url() . 'kuesioner';
					elseif ($hitgenap > 0 || $hitgasal > 0) {
						echo base_url() . 'pengabdian/';
						$this->session->set_flashdata('alert', 'Dalam Semester Aktif Hanya Boleh Mengusulkan Satu Usulan');
					} elseif ($hitskema == 0) {
						echo base_url() . 'pengabdian/';
						$this->session->set_flashdata('alert', 'Tidak Eligibel di semua Skema');
					} else
						echo base_url() . 'pengabdian/tambahusulan';
					?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Usulan</a>

		<?php //} 
		?>
	</div>
	<?php
	if ($this->session->flashdata('result') <> '') {
		echo '<div class="alert alert-success" role="alert">' .
			$this->session->flashdata('result') . '
						</div>';
	}
	if ($this->session->flashdata('alert') <> '') {
		echo '<div class="alert alert-danger" role="alert">' . $this->session->flashdata('alert') . '</div>';
	}
	?>
	<div class="alert alert-info" role="alert">
		<b>Info Eligibilitas</b>
		<p>
			<?php
			echo 'Sinta Score Overall : <b>' . $this->session->userdata('sesi_sinta') . '</b>';
			echo '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Jabatan Fungsional : <b>' . $this->session->userdata('sesi_jafung') . '</b>';
			echo '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; Jenjang Pendidikan : <b>' . $this->session->userdata('sesi_jenjang') . '</b>';
			echo '<br>Berdasarkan eligibilitas yang tercantum, Anda dapat mengusulkan dengan Skema berikut : ';
			//skema penelitian dasar
			echo '<ol>';
			for ($i = 0; $i < $hitskema; $i++) {
				echo '<li>' . $skemapkm[$i] . '</li>';
			}
			echo '</ol>';
			?>
		</p>
	</div>
	<?php
	$yes = $this->mdosen->lihatreviewer($this->session->userdata('sesi_id'));
	if ($this->session->userdata('sesi_status') <> 1 && $yes > 0) {
	?>
		<!-- Usulan Untuk direview -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<div class="row">
					<div class="col-md-10">
						<h6 class="m-0 font-weight-bold text-primary">Daftar Usulan PkM untuk DiReview</h6>
					</div>
					<div class="col-md-2 float-right">
						<form class="user" action="<?php echo base_url(); ?>pengabdian" method="post">
							<select name="periode" class="form-control" onchange="this.form.submit()" style="margin-top:-7px">
								<?php
								$tahun = 2018;
								$aktif = date('Y');
								$selisih = $aktif - $tahun;

								if ($this->input->post('periode') == '')
									$pilih = date('Y');
								else
									$pilih = $this->input->post('periode');
								for ($i = 0; $i <= $selisih; $i++) {
									if ($pilih == ($aktif - $i))
										echo '<option value="' . ($aktif - $i) . '" selected>' . ($aktif - $i) . '</option>';
									else
										echo '<option value="' . ($aktif - $i) . '">' . ($aktif - $i) . '</option>';
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
								<th width="10%"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sudah = '';
							if ($hit > 0) {
								foreach ($review as $p) {
									$thn = date('Y', strtotime($p->tglmulai));
									if ($thn == $masa) {
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										$fakultas = $this->mdosen->namafakultas($p->fakultas);
										$prodi = $this->mdosen->namaprodi($p->prodi);
										$cekreview = $this->mpengabdian->cekreview($this->session->userdata('sesi_id'), $p->id_usulan);

										if ($cekreview > 0)
											$sudah = "class='table-info'";
										else
											$sudah = '';
										if ($p->status == 'Reviewed') {
											$sudah = "class='table-warning'";
											$set = ' - Reviewed';
										} elseif ($p->status == 'Usulan Disetujui Reviewer') {
											$sudah = "class='table-info'";
											$set = 'Usulan Disetujui Reviewer';
										} elseif ($p->status == 'Usulan Tidak Disetujui Reviewer') {
											$sudah = "class='table-danger'";
											$set = 'Usulan Tidak Disetujui Reviewer';
										} elseif ($p->status == 'Usulan Disetujui Prodi') {
											$sudah = "class='table-info'";
											$set = 'Usulan Disetujui Prodi';
										} elseif ($p->status == 'Usulan Baru' && $p->roadmap == 'Tidak Sesuai') {
											$sudah = "class='table-danger'";
											$set = 'Usulan DiTolak dan Tidak Sesuai Roadmap Prodi';
										} elseif ($p->status == 'Usulan Disetujui Prodi' && $p->roadmap == 'Sesuai') {
											$sudah = "class='table-info'";
											$set = 'Usulan DiSetujui dan Sesuai dengan Roadmap Program Studi';
										} elseif ($p->status == 'Usulan Disetujui Prodi' && $p->roadmap == 'Tidak Sesuai') {
											$sudah = "class='table-danger'";
											$set = 'Usulan DiSetujui Tapi Tidak Sesuai dengan Roadmap Program Studi';
										} elseif ($p->status == 'Usulan Tidak Disetujui') {
											$sudah = "class='table-danger'";
											$set = 'Usulan Tidak Disetujui';
										} elseif ($p->status == 'Usulan Dikirim') {
											$sudah = "";
											$set = 'Usulan Dikirim';
										} else {
											$sudah = '';
											$set = 'Usulan Belum Dikirim';
										}
										$ketua = $this->mdosen->dosennya($p->pengusul);

										echo "<tr " . $sudah . ">
										  <td>" . ucwords(strtolower($p->judul)) . " (" . date('Y', strtotime($p->tglmulai)) . ")";
										echo "<br><b>Status : " . $set . "</b>
										<br><b>Pelaksanaan : Semester " . $p->semester . "</b>
										  <br>Ketua : " . $ketua['namalengkap'] . " | Prodi : " . $prodi['prodi'] . " | Skema : " . $p->skema . "
										  <br>Anggota : ";
										$angg = $this->msubmit->perananggota($p->id_usulan, 'Pengabdian');
										$hits = count($angg);

										$anggdosenluar = $this->msubmit->perananggotadosenluar($p->id_usulan, 'Pengabdian');
										$hitsdosenluar = count($anggdosenluar);
										if ($hits > 0 || $hitsdosenluar > 0) {
											$num = 1;
											echo '<ol>';
											foreach ($angg as $a) {
												if (($hits + $hitsdosenluar) == 1)
													echo $a->namalengkap;
												else {
													echo '<li>' . $a->namalengkap . '</li>';
												}
											}
											if ($hitsdosenluar > 0) {
												foreach ($anggdosenluar as $a) {
													if (($hits + $hitsdosenluar) == 1)
														echo $a->namalengkap;
													else {
														echo '<li>' . $a->namalengkap . '</li>';
													}
												}
											}
											echo '</ol>';
										} else {
											$pisah = explode(',', $p->anggotadosen);
											$hitpisah = count($pisah);
											if ($p->anggotadosen <> '') {
												echo '<ol>';
												for ($i = 0; $i < $hitpisah; $i++) {
													$revnya = $this->mdosen->namadosen($pisah[$i]);
													echo '<li>' . $revnya['namalengkap'] . '</li>';
												}


												if ($hitsdosenluar > 0) {
													foreach ($anggdosenluar as $a) {
														echo '<li>' . $a->namalengkap . '</li>';
													}
												}
												echo '</ol>';
											} else {
												echo 'Tidak Ada<br>';
											}
										}
										echo "RAB : ";
										$prodinya = $this->mdosen->dosennya($p->pengusul);
										if ($p->sumberdana == 'Internal' && $p->totaldana <> 0 && $prodinya['prodi'] == 2) {
											echo rupiah($p->totaldana);
										} elseif ($p->sumberdana == 'Mandiri+Internal' && $p->totaldana <> 0 && $prodinya['prodi'] == 2) {
											echo rupiah($p->totaldana);
										} elseif ($p->sumberdana == 'Mandiri+Internal' && $p->totaldana <> 0) {
											$total = $this->mpengabdian->totalrab($p->id_usulan);
											echo rupiah($p->totaldana);
										} else {
											$total = $this->mpengabdian->totalrab($p->id_usulan);
											echo rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']);
										}

										echo "<br><b>Sudah direview oleh : </b>";
										$sudah = $this->mpengabdian->direviewoleh($p->id_usulan);
										// echo $this->db->last_query();exit;	
										$n = count($sudah);
										$i = 0;
										$nrev = 0;
										if ($n > 0) {
											foreach ($sudah as $s) {
												$nrev++;
												if ($s->id_dosen == $this->session->userdata('sesi_dosen')) {
													echo '<b style="color:blue">Anda</b>';
												} else {
													echo '<b style="color:green">Reviewer ' . $nrev . '</b>';
												}
												if ($i < ($n - 1))
													echo ' dan ';
												$i++;
											}
										} else
											echo '<b style="color:red">-</b>';
										echo "</td><td>";
										if ($p->status == 'Usulan Baru') {
											echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;<a href='" . base_url() . "pengabdian/rab/" . $p->id_usulan . "' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>&nbsp;&nbsp;<a href='" . base_url() . "pengabdian/edit/" . $p->id_usulan . "' class='shadow-sm' title='Edit Usulan'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
									  <a href='#' data-id='" . $p->id_usulan . "' class='shadow-sm hapus' title='Hapus Usulan'><i class='fas fa-trash fa-sm'></i></a>";
										} elseif ($p->status == 'Usulan Dikirim') {
											echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
										} else {
											echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
										}
										echo "</td>
									</tr>";
									}
								}
							} else {
								echo '<tr><td colspan="3" align="center">No data available in table</td></tr>';
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
			<h6 class="m-0 font-weight-bold text-primary">Daftar Usulan PkM</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Data PkM</th>
							<th width="11%"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($usulan as $p) {
							$total = $this->mpengabdian->totalrab($p->id_usulan);
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							if ($p->status == 'Reviewed') {
								$sudah = "class='table-warning'";
								$set = ' - Reviewed';
							} elseif ($p->status == 'Usulan Disetujui Reviewer') {
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui Reviewer';
							} elseif ($p->status == 'Usulan Tidak Disetujui Reviewer') {
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui Reviewer';
							} elseif ($p->status == 'Usulan Disetujui Prodi') {
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui Prodi';
							} elseif ($p->status == 'Usulan Baru' && $p->roadmap == 'Tidak Sesuai') {
								$sudah = "class='table-danger'";
								$set = 'Usulan DiTolak dan Tidak Sesuai Roadmap Prodi';
							} elseif ($p->status == 'Usulan Disetujui Prodi' && $p->roadmap == 'Sesuai') {
								$sudah = "class='table-info'";
								$set = 'Usulan DiSetujui dan Sesuai dengan Roadmap Program Studi';
							} elseif ($p->status == 'DiTolak' && ($p->roadmap == 'Tidak Sesuai' || $p->multi == 'Belum') && $p->filerevisi_kaprodi <> '') {
								$sudah = "class='table-danger'";
								$set = "Usulan DiTolak karena" . $p->roadmap . "dengan Roadmap Program Studi dan " . $p->multi . " Multi Disiplin Beda Prodi &nbsp;<a href='#' data-idusul='" . $p->id_usulan . "' data-toggle='modal' data-target='#kirim-modal' type='button' class='btn btn-success px-3' title='Kirim Usulan'><i class='fas fa-upload fa-sm'></i>&nbsp;Kirim Usulan</a>";
							} elseif ($p->status == 'DiTolak' && ($p->roadmap == 'Tidak Sesuai' || $p->multi == 'Belum') && $p->filerevisi_kaprodi == '') {
								$sudah = "class='table-danger'";
								$set = "Usulan DiTolak karena" . $p->roadmap . "dengan Roadmap Program Studi dan " . $p->multi . " Multi Disiplin Beda Prodi &nbsp;<a href='#' data-idusul='" . $p->id_usulan . "' data-toggle='modal' data-target='#kirimrevisi-modal' type='button' class='btn btn-success px-3' title='Upload Revisi'><i class='fas fa-upload fa-sm'></i>&nbsp;Upload Revisi</a>";
							} elseif ($p->status == 'Usulan Disetujui Prodi' && $p->roadmap == 'Tidak Sesuai') {
								$sudah = "class='table-danger'";
								$set = 'Usulan DiSetujui Tapi Tidak Sesuai dengan Roadmap Program Studi';
							} elseif ($p->status == 'Usulan Tidak Disetujui') {
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui';
							} elseif ($p->status == 'Usulan Dikirim') {
								$sudah = "";
								$set = 'Usulan Dikirim';
							} elseif ($p->status == 'Usulan Dikirim' && ($p->roadmap == 'Tidak Sesuai' || $p->multi == 'Belum')) {
								$sudah = "";
								$set = 'Revisi Usulan';
							} else {
								$sudah = '';
								$set = 'Usulan Belum Dikirim';
							}

							$ketua = $this->mdosen->dosennya($p->pengusul);

							echo "<tr " . $sudah . ">
										  <td>" . ucwords(strtolower($p->judul)) . " (" . date('Y', strtotime($p->tglmulai)) . ")";
							echo "<br><b>Status : " . $set . "</b>
										<br><b>Pelaksanaan : Semester " . $p->semester . "</b>
										  <br>Ketua : " . $ketua['namalengkap'] . " | Prodi : " . $prodi['prodi'] . " | Skema : " . $p->skema . "
										  <br>Anggota : ";

							$jmldeal = 0;
							$angg = $this->msubmit->perananggota($p->id_usulan, 'Pengabdian');
							$hitpisah = count($angg);

							$anggdosenluar = $this->msubmit->perananggotadosenluar($p->id_usulan, 'Pengabdian');
							$hitsdosenluar = count($anggdosenluar);
							if ($hitpisah > 0 || $hitsdosenluar > 0) {
								$num = 1;
								echo '<ol>';
								foreach ($angg as $a) {
									$okdeal = $this->mpengabdian->cekanggotasetuju($a->id_dosen, $p->id_usulan);

									if ($okdeal > 0) {
										$setok = 'Setuju';
										$jmldeal++;
									} else {
										$setok = '<span class="badge badge-warning">Belum Setuju</span>';

										//cek apakah id_dosen samaa dengan sesi_dosen, jika sama maka tampilkan tombol setuju
										if ($a->id_dosen == $this->session->userdata('sesi_dosen') && $p->status == 'Usulan Baru') {
											$setok = '<span class="badge badge-warning">Anda Belum Setujui</span>' . " &nbsp;<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' data-id='" . $p->id_usulan . "' class='btn btn-success btn-sm setuju' title='Setujui Keanggotaan'><i class='fas fa-check fa-sm'></i></a>";
										}
									}
									if (($hitpisah + $hitsdosenluar) == 1)
										echo $a->namalengkap . ' (' . $setok . ')';
									else {
										echo '<li>' . $a->namalengkap . ' (' . $setok . ')</li>';
									}
								}
								if ($hitsdosenluar > 0) {
									foreach ($anggdosenluar as $a) {
										if (($hitpisah + $hitsdosenluar) == 1)
											echo $a->namalengkap;
										else {
											echo '<li>' . $a->namalengkap . '</li>';
										}
									}
								}

								echo '</ol>';
							} else {
								$pisah = explode(',', $p->anggotadosen);
								$hitpisah = count($pisah);
								$hitangg = $this->msubmit->hitangg($p->id_usulan);

								if ($p->anggotadosen <> '' && $hitangg == 0) {
									echo '<ol>';
									for ($i = 0; $i < $hitpisah; $i++) {
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										$okdeal = $this->mpengabdian->cekanggotasetuju($pisah[$i], $p->id_usulan);

										if ($okdeal > 0) {
											$setok = 'Setuju';
											$jmldeal++;
										} else {
											$setok = '<span class="badge badge-warning">Belum Setuju</span>';
											if ($pisah[$i] == $this->session->userdata('sesi_dosen') && $p->status == 'Usulan Baru') {
												$setok = '<span class="badge badge-warning">Anda Belum Setujui</span>' . " &nbsp;<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' data-id='" . $p->id_usulan . "' class='btn btn-success btn-sm setuju' title='Setujui Keanggotaan'><i class='fas fa-check fa-sm'></i></a>";
											}
										}

										if (($hitpisah + $hitsdosenluar) == 1) {
											echo $revnya['namalengkap'] . ' (' . $setok . ')';
										} else {
											echo '<li>' . $revnya['namalengkap'] . ' (' . $setok . ')</li>';
										}
									}

									if ($hitsdosenluar > 0) {
										foreach ($anggdosenluar as $a) {
											if (($hitpisah + $hitsdosenluar) == 1)
												echo $a->namalengkap;
											else {
												echo '<li>' . $a->namalengkap . '</li>';
											}
										}
									}
									echo '</ol>';
								} elseif ($p->anggotadosen == '' && $hitangg > 0) {
									$angg = $this->msubmit->perananggota($p->id_usulan, 'Pengabdian');
									$hitpisah = count($angg);
									$num = 1;
									echo '<ol>';
									foreach ($angg as $a) {
										$okdeal = $this->mpengabdian->cekanggotasetuju($a->id_dosen, $p->id_usulan);

										if ($okdeal > 0) {
											$setok = 'Setuju';
											$jmldeal++;
										} else {
											$setok = '<span class="badge badge-warning">Belum Setuju</span>';

											//cek apakah id_dosen samaa dengan sesi_dosen, jika sama maka tampilkan tombol setuju
											if ($a->id_dosen == $this->session->userdata('sesi_dosen') && $p->status == 'Usulan Baru') {
												$setok = '<span class="badge badge-warning">Anda Belum Setujui</span>' . " &nbsp;<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' data-id='" . $p->id_usulan . "' class='btn btn-success btn-sm setuju' title='Setujui Keanggotaan'><i class='fas fa-check fa-sm'></i></a>";
											}
										}
										if (($hitpisah + $hitsdosenluar) == 1)
											echo $a->namalengkap . ' (' . $setok . ')';
										else {
											echo '<li>' . $a->namalengkap . ' (' . $setok . ')</li>';
										}
									}
									if ($hitsdosenluar > 0) {
										foreach ($anggdosenluar as $a) {
											if (($hitpisah + $hitsdosenluar) == 1)
												echo $a->namalengkap;
											else {
												echo '<li>' . $a->namalengkap . '</li>';
											}
										}
									}
									echo '</ol>';
								} else {
									echo 'Tidak Ada<br>';
								}
							}
							echo "RAB : ";
							$prodinya = $this->mdosen->dosennya($p->pengusul);
							if ($p->sumberdana == 'Internal' && $p->totaldana <> 0 && $prodinya['prodi'] == 2) {
								echo rupiah($p->totaldana);
							} elseif ($p->sumberdana == 'Mandiri+Internal' && $p->totaldana <> 0 && $prodinya['prodi'] == 2) {
								echo rupiah($p->totaldana);
							} elseif ($p->sumberdana == 'Mandiri+Internal' && $p->totaldana <> 0) {
								$total = $this->mpengabdian->totalrab($p->id_usulan);
								echo rupiah($p->totaldana);
							} else {
								$total = $this->mpengabdian->totalrab($p->id_usulan);
								if ($total == '')
									echo rupiah(0);
								else
									echo rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']);
							}

							echo "<br><b>Sudah direview oleh : </b>";
							$sudah = $this->mpengabdian->direviewoleh($p->id_usulan);
							// echo $this->db->last_query();exit;	
							$n = count($sudah);
							$i = 0;
							$nrev = 1;
							if ($n > 0) {
								foreach ($sudah as $s) {
									echo '<b style="color:green">Reviewer ' . $nrev . ' </b>';
									if ($i < ($n - 1))
										echo ' dan ';
									$i++;
									$nrev++;
								}
							} else
								echo '<b style="color:red">-</b>';

							echo '<br>';

							if ($this->session->userdata('sesi_id') == $p->pengusul && $jmldeal == $hitpisah && $p->status == 'Usulan Baru') {
								$cekrab = $this->mpengabdian->cekrab($p->id_usulan);
								if ($cekrab > 0) {
									echo "<a href='#' data-idusul='" . $p->id_usulan . "' data-toggle='modal' data-target='#kirim-modal' type='button' class='btn btn-success px-3' title='Kirim Usulan'><i class='fas fa-upload fa-sm'></i>&nbsp;Kirim Usulan</a>";
								} else {
									echo '<b class="badge badge-danger">RAB Belum Dibuat, Tidak Bisa Mengirim Usulan</b>';
								}
							} else {
								if ($jmldeal < $hitpisah)
									echo '<b class="badge badge-warning">Masih ada Anggota Dosen yang belum Menyetujui Keanggotaan</b>';
								else
									echo '';
							}
							echo "</td><td>";
							$up = '';
							if ($this->session->userdata('sesi_id') == $p->pengusul && $p->status == 'Usulan Baru') {
								echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;<a href='" . base_url() . "pengabdian/rab/" . $p->id_usulan . "' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>&nbsp;&nbsp;<a href='" . base_url() . "pengabdian/edit/" . $p->id_usulan . "' class='shadow-sm' title='Edit Usulan'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
									  <a href='#' data-id='" . $p->id_usulan . "' class='shadow-sm hapus' title='Hapus Usulan'><i class='fas fa-trash fa-sm'></i></a><br><br>";
								echo $up;
							} elseif ($p->status == 'Usulan Dikirim') {
								echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
							} elseif ($p->status == 'Reviewed' || $p->status == 'Usulan Disetujui Reviewer') {
								echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;";
								if ($this->session->userdata('sesi_id') == $p->pengusul) {
									echo "<a href='" . base_url() . "pengabdian/rab/" . $p->id_usulan . "' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>";
								}
							} else {
								echo "<a href='" . base_url() . "pengabdian/detail/" . $p->id_usulan . "' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>";
							}
							echo "</td>
									</tr>";
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
				<form method="post" action="<?php echo base_url() . 'pengabdian/kirim'; ?>" enctype="multipart/form-data">
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
				<form method="post" action="<?php echo base_url() . 'pengabdian/simpanrevisikaprodi/' . $this->uri->segment(3); ?>" enctype="multipart/form-data">
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
		$('#kirim-modal').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
			var modal = $(this)

			// Isi nilai pada field
			modal.find('.idusul').attr("value", div.data('idusul'));
		});
	});

	$(document).ready(function() {
		// Untuk sunting
		$('#kirimrevisi-modal').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
			var modal = $(this)

			// Isi nilai pada field
			modal.find('#idrevusulan').attr("value", div.data('idusul'));
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

	$(".hapus").click(function() {
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
			callback: function(result) {
				if (result)
					window.location = "<?php echo base_url(); ?>pengabdian/hapus/" + id;
			}
		})
	});
</script>