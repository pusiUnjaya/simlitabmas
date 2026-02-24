<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<link href="<?php echo base_url(); ?>assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">

<style>
	.select2-container--default .select2-selection--single {
		height: 38px;
		padding: 6px 12px;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 24px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 36px;
		right: 10px;
	}

	.select2-container--default .select2-selection--single .select2-selection__arrow b {
		border-color: #888 transparent transparent transparent;
		border-style: solid;
		border-width: 5px 4px 0 4px;
		height: 0;
		left: 50%;
		margin-left: -4px;
		margin-top: -2px;
		position: absolute;
		top: 50%;
	}

	/* Agar modal #tambahDosenLuarModal bisa discroll seluruhnya tanpa max-height */
	#tambahDosenLuarModal .modal-dialog {
		display: flex;
		flex-direction: column;
		height: 90%;
	}

	#tambahDosenLuarModal .modal-content {
		flex: 1 1 auto;
		overflow-y: auto;
		height: 100%;
	}

	#btnChangeModalDosenLuar {
		padding: 0;
		font-size: 0.875rem;
		font-weight: 400;
		line-height: 1.5;
		letter-spacing: 0.00938em;
		text-decoration: underline;
	}
</style>
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Submit Usulan Baru</h1>
	</div>

	<?php
	if ($this->session->flashdata('result') <> '') {
		echo '<div class="alert alert-success" role="alert">' .
			$this->session->flashdata('result') . '
						</div>';
	}
	?>

	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Form Submit PkM</h6>
		</div>
		<div class="card-body">
			<form class="user" action="<?php echo base_url(); ?>pengabdian/simpan" method="post" enctype="multipart/form-data">
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Judul PkM</label>
						<input type="text" name="judul" class="form-control" placeholder="Judul PkM" required>
					</div>
					<div class="col-sm-6">
						<label>Skema PkM</label>
						<select name="skema" class="form-control">
							<?php
							//$jenis = array('Insidental','Non Insidental');
							$jenis = $this->session->userdata('sesi_skema');
							$n = count($jenis);
							for ($i = 0; $i < $n; $i++) {
								echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label>Luaran</label><br>
						<div class="col-sm-12 row">
							<div class="col-sm-4">
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasinal BerISSN">Jurnal Nasional BerISSN</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional Terakreditasi 6">Jurnal Nasional Terakreditasi 6</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional Terakreditasi 5">Jurnal Nasional Terakreditasi 5</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional Terakreditasi 4">Jurnal Nasional Terakreditasi 4</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional Terakreditasi 3">Jurnal Nasional Terakreditasi 3</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional Terakreditasi 2">Jurnal Nasional Terakreditasi 2</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional Terakreditasi 1">Jurnal Nasional Terakreditasi 1</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Internasional">Jurnal Internasional</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Paten">Paten</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="HKI">HKI</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Bahan Ajar">Bahan Ajar</label>
								</div>
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Prosiding">Prosiding</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label>Nama Jurnal</label>
						<input type="text" name="namajurnal" class="form-control" placeholder="Nama Jurnal" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label for="select2SinglePlaceholder">PkM dari Sumber Penelitian?</label>
						<select class="select2-single-placeholder form-control" name="sumberpkm" id="select2SinglePlaceholder">
							<option value="">Select</option>
							<option value="Tidak Ada">Tidak Ada</option>
							<?php
							foreach ($riset as $r) {
								echo '<option value="' . $r->id_usulan . '">' . $r->judul . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<!-- <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Ketua</label>
					<input type="text" class="form-control" value="<?php //echo $this->session->userdata('sesi_nama');
																	?>" readonly>
                  </div>
                  <div class="col-sm-6">
                    <label>uraian tugas dalam pengabdian kepada masyarakat *</label>
					<textarea id="uraiantugas" name="uraiantugas" class="form-control" placeholder="" required></textarea>
                  </div>
                </div> -->
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Sumber Dana</label>
						<select name="sumberdana" class="form-control">
							<?php
							$jenis = array('Mandiri', 'Internal', 'Mandiri+Internal', 'Kerjasama', 'Dikti', 'Kopertis');
							$n = count($jenis);
							for ($i = 0; $i < $n; $i++) {
								echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="col-sm-6">
						<label>Jumlah Dana Internal</label>
						<input type="text" id="jmldana" name="jmldana" class="form-control" placeholder="Jumlah Dana Internal" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						Anggota Dosen
						<table class="table">
							<thead>
								<tr>
									<th>No</th>
									<th>NIDN/NPP</th>
									<th>Nama</th>
									<th>Tugas</th>
									<th class="text-right">
										<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#m-modal">
											<i class="fas fa-plus fa-sm"></i>
										</button>
									</th>
								</tr>
							</thead>
							<tbody id="m-data">
								<tr class="m-no-data">
									<td colspan="5" align="center">Belum ada anggota dosen yang didata</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group row" id="frm_dosenluar">
					<div class="col-sm-12">
						Anggota Dosen Luar
						<table class="table">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>NIDN/NPP</th>
									<th>Institusi</th>
									<th>Tugas</th>
									<th class="text-right">
										<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#dosenluar-modal">
											<i class="fas fa-plus fa-sm"></i>
										</button>
									</th>
								</tr>
							</thead>
							<tbody id="dosenluar-data">
								<tr class="dosenluar-no-data">
									<td colspan="6" align="center">Belum ada anggota dosen luar yang didata</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						Anggota Mahasiswa
						<table class="table">
							<thead>
								<tr>
									<th>No</th>
									<th>NPM</th>
									<th>Nama</th>
									<th>Tugas</th>
									<th class="text-right">
										<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#p-modal">
											<i class="fas fa-plus fa-sm"></i>
										</button>
									</th>
								</tr>
							</thead>
							<tbody id="p-data">
								<tr class="p-no-data">
									<td colspan="5" align="center">Belum ada anggota mahasiswa yang didata</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label>Ringkasan</label>
						<textarea name="ringkasan" class="form-control" required></textarea>
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Kata Kunci</label>
						<textarea name="katakunci" class="form-control" required></textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label>Tanggal Mulai</label>
						<input type="text" name="tglmulai" class="form-control" id="tglmulai" placeholder="Tanggal Mulai" required>
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Tanggal Akhir</label>
						<input type="text" name="tglakhir" class="form-control" id="tglakhir" placeholder="Tanggal Akhir" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label>File Usulan (PDF) maksimal 20MB</label>
						<input type="file" name="fileupload" class="form-control unggah" placeholder="File Usulan (PDF)" required>
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<div class="col-sm-12">
							<label>Pelaksanaan</label>
							<select name="sem" class="form-control">
								<option value="">Akan dilaksanakan Semester?</option>
								<?php
								$sem = array('Gasal', 'Genap');
								$n = count($sem);
								for ($i = 0; $i < $n; $i++) {
									echo '<option value="' . $sem[$i] . '">Semester ' . $sem[$i] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" value="Simpan" id="tmbsimpan" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>

			</form>
		</div>
	</div>
</div>

<!-- Modal Tambah Mahasiswa -->
<div class="modal fade" id="modal_mhs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Mahasiswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" id="addmhs" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">NPM :</label>
						<input type="text" id="npm" name="npm" class="form-control" placeholder="NPM" required>
						<label for="recipient-name" class="col-form-label">Nama Mahasiswa :</label>
						<input type="text" id="namamhs" name="namamhs" class="form-control" placeholder="Nama Lengkap Mahasiswa" required>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<label>Fakultas</label>
							<select name="fakultas" id="fakultas" class="form-control">
								<option>-- Pilih Fakultas --</option>
								<?php
								foreach ($fakultas as $p) {
									if ($dosen['fakultas'] == $p->id_fak)
										echo '<option value="' . $p->id_fak . '" selected>' . $p->fakultas . '</option>';
									else
										echo '<option value="' . $p->id_fak . '">' . $p->fakultas . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-sm-6 mb-3 mb-sm-0">
							<label>Program Studi</label>
							<select name="prodi" id="prodi" class="form-control">
								<?php
								$namaprodi = $this->mdosen->namaprodi($dosen['prodi']);
								echo '<option value="' . $dosen['prodi'] . '">' . $namaprodi['prodi'] . '</option>';
								?>
							</select>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<button type="button" id="btnSavemhs" disabled onclick="save()" class="btn btn-success">Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div id="m-modal" class="modal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Anggota Dosen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="m-id" class="form-label">Nama Dosen</label>
					<select id="m-id" class="form-control" style="width: 100%;">
						<option value="">-- Pilih salah satu --</option>
						<?php foreach ($dosen as $d): ?>
							<option value="<?php echo $d->id_dosen ?>">
								<?php echo $d->namalengkap ?> (<?php echo $d->nidn ?>)
							</option>
						<?php endforeach ?>
					</select>
				</div>
				<label for="recipient-name" class="col-form-label">Tugas Dalam Penelitian * :</label>
				<textarea id="m-tugas" name="tugas" class="form-control" required></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" id="m-simpan">Tambahkan</button>
			</div>
		</div>
	</div>
</div>

<div id="p-modal" class="modal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Anggota Mahasiswa</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row-fluid">
					<label for="p-id" class="form-label">Nama Mahasiswa</label>
					<select id="p-id" class="form-control" style="width: 100%;"></select>
				</div>
				<label for="recipient-name" class="col-form-label">Tugas Dalam Penelitian * :</label>
				<textarea id="p-tugas" name="tugas" class="form-control" required></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" id="p-simpan">Tambahkan</button>
			</div>
		</div>
	</div>
</div>

<div id="dosenluar-modal" class="modal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Anggota Dosen Luar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmPilihanDosenLuar">
					<div class="form-group row-fluid">
						<label for="dosenluar-id" class="form-label">Nama Dosen Luar</label>
						<select id="dosenluar-id" class="form-control" style="width: 100%;"></select>
						<!-- Jika dosen belum terdaftar, tawarkan untuk menambahkan terlebih dahulu menggunakan modal, ganti modal ini menjadi modal dosen luar master -->
						<i class="small" style="color:#b37272">Dosen luar tidak terdafar ? <button type="button" class="btn btn-link" id="btnChangeModalDosenLuar" data-toggle="modal" data-target="#tambahDosenLuarModal">Tambahkan</button></i>
					</div>
					<label for="recipient-name" class="col-form-label">Tugas Dalam Penelitian * :</label>
					<textarea id="dosenluar-tugas" name="tugas" class="form-control" required></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary" id="dosenluar-simpan">Tambahkan</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="tambahDosenLuarModal" class="modal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Dosen Luar</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form-tambah-dosenluar">
					<div class="form-group row-fluid">
						<label for="dosenluar-nama" class="form-label">Nama Lengkap * </label>
						<input type="text" id="dosenluar-nama" name="namalengkap" class="form-control" required>
					</div>
					<div class="form-group row-fluid">
						<label for="dosenluar-nidn" class="form-label">NIDN/NPP * </label>
						<input type="text" id="dosenluar-nidn" name="nidn" class="form-control" required>
					</div>
					<div class="form-group row-fluid">
						<label for="dosenluar-idnegara" class="form-label">Negara Asal * </label>
						<select id="dosenluar-idnegara" name="id_negara" class="form-control" required>
							<option value="">-- Pilih Negara --</option>
							<?php foreach ($negara as $n): ?>
								<option value="<?php echo $n->id_negara ?>"><?php echo $n->kode_negara . ' - ' . $n->nama_negara ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group row-fluid">
						<label for="dosenluar-departmen" class="form-label">Nama Departemen/Prodi * </label>
						<input type="text" id="dosenluar-departmen" name="namadepartmen" class="form-control" required>
					</div>
					<div class="form-group row-fluid">
						<label for="dosenluar-institusi" class="form-label">Nama Institusi * </label>
						<input type="text" id="dosenluar-institusi" name="namainstitusi" class="form-control" required>
					</div>
					<div class="form-group row-fluid">
						<label for="dosenluar-idnegara-institusi" class="form-label">Negara Institusi * </label>
						<select id="dosenluar-idnegara-institusi" name="id_negara_institusi" class="form-control" required>
							<option value="">-- Pilih Negara --</option>
							<?php foreach ($negara as $n): ?>
								<option value="<?php echo $n->id_negara ?>"><?php echo $n->kode_negara . ' - ' . $n->nama_negara ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="form-group row-fluid">
						<label for="dosenluar-tugas-master" class="col-form-label">Tugas Dalam Penelitian * :</label>
						<textarea id="dosenluar-tugas-master" name="tugas" class="form-control" required></textarea>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary" id="dosenluar-simpanmaster">Tambahkan</button>

				</form>
			</div>
		</div>
	</div>
</div>

<?php
$dosen = $this->mdosen->anggotadosen();
$datanama = array();
foreach ($dosen as $d) {
	if ($d->user <> '')
		$max = $this->msubmit->hitambilmax($d->user, $d->id_dosen);
	else
		$max = 1;
	if ($max < 2) {
		$datanama[] = array(
			'value' => $d->id_dosen,
			'label' => $d->namalengkap
		);
	}
}
$anggota = json_encode($datanama);

//anggota mhs
$mhs = $this->mpengabdian->anggotamhs();
$datamhs = array();
foreach ($mhs as $d) {
	$datamhs[] = array(
		'value' => $d->idmhs,
		'label' => $d->namamhs
	);
}
$anggotamhs = json_encode($datamhs);
?>

<script src="<?php echo base_url(); ?>assets/vendor/select2/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('#m-id').select2({
			dropdownParent: $("#m-modal")
		});
	});


	$('#u-pilih').on('click', ev => {
		let idVal = $('#u-id').val();
		if (idVal == '') {
			alert('Mohon dipilih salah satu');
			return;
		}
		let judul = $('#u-id :selected').text().trim();
		let jenis = idVal.substr(0, 3);
		let id = idVal.substr(4);

		$('#u-modal').modal('hide');

		$('#judul').val(judul);
		$('#jenis').val(jenis);
	});

	$('.u-hapus').on('click', ev => {
		if (!confirm('Anda benar-benar mau menghapus data ini?')) {
			return false;
		}
	});

	function hapusAnggota(el) {
		if (!confirm('Data ini benar-benar akan dihapus?')) return;

		$(el).parent().parent().remove();
		if ($('#m-data tr').length == 1) {
			$('.m-no-data').show();
		} else {
			$('.m-item td:first-child').each(function(i) {
				$(this).text(i + 1);
			});
		}
	}

	// $(function () {
	//     $('#p-id').selectpicker();
	// });

	function tambahAnggota(id, nidn, nama, tugas) {
		$('.m-no-data').hide();

		let no = $('#m-data tr').length;
		$('#m-data').append(`<tr class="m-item">
	        <input type="hidden" name="m_id[]" value="${id}">
	        <td>${no}</td>
	        <td>${nidn}<input type="hidden" name="m_nidn[]" value="${nidn}"></td>
	        <td>${nama}<input type="hidden" name="m_nama[]" value="${nama}"></td>
	        <td>${tugas}<input type="hidden" name="m_tugas[]" value="${tugas}"></td>
	        <td class="text-right">
	            <button type="button" class="btn btn-sm" onclick="hapusAnggota(this)">
	                <i class="fa fa-trash"></i>
	            </button>
	        </td>
	    </tr>`);
	}

	$('#m-simpan').on('click', ev => {
		let id = $('#m-id').val();
		if (id == '') {
			alert('Mohon dipilih salah satu');
			return;
		}
		let namaID = $('#m-id :selected').text().trim();
		let tugas = $('#m-tugas').val();
		let nama = namaID.substr(0, namaID.indexOf(' ('));
		let nidn = namaID.substring(namaID.indexOf(' (') + 2, namaID.length - 1);

		$('#m-modal').modal('hide');
		tambahAnggota(id, nidn, nama, tugas);
	});

	$(document).ready(function() {
		$('#m-modal').on('shown.bs.modal', function() {
			$('#m-id').trigger('focus');
		});
		setTimeout(() => $('.alert').hide(), 3000);
		<?php if (!empty($prev_input = $this->session->flashdata('input'))): ?>
			let prevInput = <?php echo json_encode($prev_input) ?>;
			$('#judul').val(prevInput.judul);
			$('#jenis').val(prevInput.jenis);
			$('#tertuju').val(prevInput.tertuju);
			$('#tempat').val(prevInput.tempat);
			$('#lokasi').val(prevInput.lokasi);
			for (const i in prevInput.m_id) {
				tambahAnggota(prevInput.m_id[i], prevInput.m_nidn[i], prevInput.m_nama[i]);
			}
		<?php endif ?>
	});


	$('.select2-single-placeholder').select2({
		placeholder: "Pilih Judul Penelitian sebagai sumber pelaksanaan Pengabdian",
		allowClear: true
	});

	$('.unggah').bind('change', function() {
		var ukuran = this.files[0].size / 1024 / 1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if (ukuran > 20) {
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			document.getElementById("tmbsimpan").disabled = true;
		} else if (extension != 'pdf') {
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			document.getElementById("tmbsimpan").disabled = true;
			return false;
		} else if (extension == 'pdf' && ukuran > 20) {
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			document.getElementById("tmbsimpan").disabled = true;
		} else {
			document.getElementById("tmbsimpan").disabled = false;
		}
	});

	$(function() {
		//Date picker
		$('#tglmulai').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:+0',
			autoclose: true
		});
	});

	$(function() {
		//Date picker
		$('#tglakhir').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:+0',
			autoclose: true
		});
	});

	$(document).ready(function() {
		$("#fakultas").change(function() {
			var url = "<?php echo site_url('dosen/load_prodi'); ?>/" + $(this).val();
			$('#prodi').load(url);
			return false;
		});
	});

	//autocomplete dosen
	$(function() {
		function split(val) {
			return val.split(/,\s*/);
		}

		function extractLast(term) {
			return split(term).pop();
		}

		var projects = <?php echo $anggota; ?>;

		$("#anggotadosen")
			// don't navigate away from the field on tab when selecting an item
			.bind("keydown", function(event) {
				if (event.keyCode === $.ui.keyCode.TAB &&
					$(this).autocomplete("instance").menu.active) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function(request, response) {
					// delegate back to autocomplete, but extract the last term
					response($.ui.autocomplete.filter(
						projects, extractLast(request.term)));
				},

				//    source:projects,    
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function(event, ui) {
					var terms = split(this.value);
					if (terms.length <= 5) {
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push(ui.item.label);
						// add placeholder to get the comma-and-space at the end
						terms.push("");
						this.value = terms.join(", ");

						var selected_label = ui.item.label;
						var selected_value = ui.item.value;

						var labels = $('#labels').val();
						var values = $('#values').val();

						if (labels == "") {
							$('#labels').val(selected_label);
							$('#values').val(selected_value);
						} else {
							$('#labels').val(labels + "," + selected_label);
							$('#values').val(values + "," + selected_value);
						}

						return false;
					} else {
						var last = terms.pop();
						$(this).val(this.value.substr(0, this.value.length - last.length - 1)); // removes text from input
						$(this).effect("highlight", {}, 1000);
						$(this).addClass("red");
						$("#warnings").html("<span style='color:red;'>Maks Jumlah Anggota 2</span>");
						return false;
					}
				}
			});

	});

	//autocomplete mhs
	$(function() {
		function split(val) {
			return val.split(/,\s*/);
		}

		function extractLast(term) {
			return split(term).pop();
		}

		var projects = <?php echo $anggotamhs; ?>;

		$("#anggotamhs")
			// don't navigate away from the field on tab when selecting an item
			.bind("keydown", function(event) {
				if (event.keyCode === $.ui.keyCode.TAB &&
					$(this).autocomplete("instance").menu.active) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function(request, response) {
					// delegate back to autocomplete, but extract the last term
					response($.ui.autocomplete.filter(
						projects, extractLast(request.term)));
				},

				//    source:projects,    
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function(event, ui) {
					var terms = split(this.value);
					if (terms.length <= $('#jumlahmhs').val()) {
						// remove the current input
						terms.pop();
						// add the selected item
						terms.push(ui.item.label);
						// add placeholder to get the comma-and-space at the end
						terms.push("");
						this.value = terms.join(", ");

						var selected_label = ui.item.label;
						var selected_value = ui.item.value;

						var labels = $('#labelmhs').val();
						var values = $('#valuemhs').val();

						if (labels == "") {
							$('#labelmhs').val(selected_label);
							$('#valuemhs').val(selected_value);
						} else {
							$('#labelmhs').val(labels + "," + selected_label);
							$('#valuemhs').val(values + "," + selected_value);
						}

						return false;
					} else {
						var last = terms.pop();
						$(this).val(this.value.substr(0, this.value.length - last.length - 1)); // removes text from input
						$(this).effect("highlight", {}, 1000);
						$(this).addClass("red");
						$("#warningmhs").html("<span style='color:red;'>Maks Jumlah Anggota Mahasiswa " + $('#jumlahmhs').val() + "</span>");
						return false;
					}
				}
			});

	});

	/* Tanpa Rupiah */
	var tanpa_rupiah = document.getElementById('jmldana');
	tanpa_rupiah.addEventListener('keyup', function(e) {
		tanpa_rupiah.value = formatRupiah(this.value);
	});

	tanpa_rupiah.addEventListener('keydown', function(event) {
		limitCharacter(event);
	});

	function formatRupiah(bilangan, prefix) {
		var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

	function limitCharacter(event) {
		key = event.which || event.keyCode;
		if (key != 188 // Comma
			&&
			key != 8 // Backspace
			&&
			key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
			&&
			(key < 48 || key > 57) // Non digit
			// Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
		) {
			event.preventDefault();
			return false;
		}
	}

	$(document).ready(function() {
		$("#npm").on("input", function(e) {
			if ($('#npm').val() == null || $('#npm').val() == "") {
				// $('#hitung').show();
				// $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
				document.getElementById("btnSavemhs").disabled = true;
			} else {
				// $('#hitung').hide();
				$("#namamhs").on("input", function(e) {
					if ($('#namamhs').val() == null || $('#namamhs').val() == "") {
						// $('#hitung').show();
						// $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
						document.getElementById("btnSavemhs").disabled = true;
					} else {
						// $('#hitung').hide();
						$("#prodi").on("input", function(e) {
							if ($('#prodi').val() == null || $('#prodi').val() == "") {
								// $('#hitung').show();
								// $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
								document.getElementById("btnSavemhs").disabled = true;
							} else {
								// $('#hitung').hide();
								document.getElementById("btnSavemhs").disabled = false;
							}
						});
					}
				});
			}
		});
	});

	function save() {
		$('#btnSavemhs').text('saving...'); //change button text
		$('#btnSavemhs').attr('disabled', true); //set button disable 
		var url;

		url = "<?php echo site_url('submit/mhs_add') ?>";

		// ajax adding data to database
		$.ajax({
			url: url,
			type: "POST",
			data: $('#addmhs').serialize(),
			dataType: "JSON",
			success: function(data) {

				if (data.status) //if success close modal and reload ajax table
				{
					$('#modal_mhs').modal('hide');
					location.reload();
				}

				$('#btnSavemhs').text('save'); //change button text
				$('#btnSavemhs').attr('disabled', false); //set button enable 


			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
				$('#btnSavemhs').text('save'); //change button text
				$('#btnSavemhs').attr('disabled', false); //set button enable 

			}
		});
	}


	$(document).ready(function() {
		$('#p-id').select2({
			dropdownParent: $("#p-modal")
		});


		var currSelectedAnggotaMhs = '';
		var objCurrSelectedAnggotaMhs = {};

		var currSelectedAnggotaDosenLuar = '';
		var objCurrSelectedAnggotaDosenLuar = {};
		formatSelectedMhs('');

		function formatSelectedMhs(selected = '', selectedText = '') {
			// Destroy previous select2 instance if exists
			if ($('#p-id').data('select2')) {
				$('#p-id').select2('destroy');
			}
			$('#p-id').empty();
			if (selected && selectedText) {
				// Tambahkan option terpilih secara manual agar langsung muncul
				var option = new Option(selectedText, selected, true, true);
				console.log(option);
				$('#p-id').append(option).trigger('change');
			}
			$('#p-id').select2({
				dropdownParent: $("#p-modal"),
				ajax: {
					url: '<?php echo site_url('submit/search_mahasiswa'); ?>',
					dataType: 'json',
					type: 'POST',
					delay: 250,
					data: function(params) {
						return {
							q: params.term,
							page: params.page || 1
						};
					},
					processResults: function(data, params) {
						params.page = params.page || 1;
						if (data.status) {
							return {
								results: data.data,
								pagination: {
									more: (params.page * 20) < data.total_count
								}
							};
						} else {
							alert(data.message);
						}
					},
					cache: true
				},
				minimumInputLength: 2,
				templateResult: function(item) {
					if (item.loading) return item.namamhs;
					return item.namamhs || 'Tidak ditemukan';
				},
				templateSelection: function(item) {
					objCurrSelectedAnggotaMhs = item;
					if (selected && selectedText && item.status == undefined) {
						currSelectedAnggotaMhs = selected;
						return selectedText;
					} else {
						currSelectedAnggotaMhs = item.npm;
						return item.namamhs || 'Tidak ditemukan';
					}

				}
			});
		}

		$(document).on('click', '.hapusAnggotaMhs', function() {
			if (!confirm('Data ini benar-benar akan dihapus?')) return;

			$(this).parent().parent().remove();
			if ($('#p-data tr').length == 1) {
				$('.p-no-data').show();
			} else {
				$('.p-item td:first-child').each(function(i) {
					$(this).text(i + 1);
				});
			}
		});

		function tambahAnggotaMhs(id, npm, nama, tugas) {
			$('.p-no-data').hide();

			let no = $('#p-data tr').length;
			$('#p-data').append(`<tr class="p-item">
	        <input type="hidden" name="p_id[]" value="${id}">
	        <td>${no}</td>
	        <td>${npm}<input type="hidden" name="p_npm[]" value="${npm}"></td>
	        <td>${nama}<input type="hidden" name="p_nama[]" value="${nama}"></td>
	        <td>${tugas}<input type="hidden" name="p_tugas[]" value="${tugas}"></td>
	        <td class="text-right">
	            <button type="button" class="btn btn-sm hapusAnggotaMhs">
	                <i class="fa fa-trash"></i>
	            </button>
	        </td>
	    </tr>`);
		}

		$('#p-simpan').on('click', ev => {
			let id = $('#p-id').val();
			if (id == '' || !objCurrSelectedAnggotaMhs.id) {
				alert('Mohon dipilih salah satu');
				return;
			}

			let namaID = objCurrSelectedAnggotaMhs.namamhs;
			let tugas = $('#p-tugas').val();
			let nama = namaID;
			let npm = $('#p-id').val();
			// let npm = namaID.substring(namaID.indexOf(' (') + 2, namaID.length - 1);

			$('#p-modal').modal('hide');
			tambahAnggotaMhs(id, npm, nama, tugas);
		});


		load_pilihan_dosenluar();

		function load_pilihan_dosenluar() {
			$('#dosenluar-id').select2({
				dropdownParent: $("#dosenluar-modal"),
				ajax: {
					url: '<?php echo site_url('submit/search_dosenluar'); ?>',
					dataType: 'json',
					type: 'POST',
					delay: 250,
					data: function(params) {
						return {
							q: params.term,
							page: params.page || 1,
							selected: currSelectedAnggotaDosenLuar
						};
					},
					processResults: function(data, params) {
						params.page = params.page || 1;
						if (data.status) {
							return {
								results: data.data,
								pagination: {
									more: (params.page * 20) < data.total_count
								}
							};
						} else {
							alert(data.message);
						}
					},
					cache: true
				},
				minimumInputLength: 2,
				templateResult: function(item) {
					if (item.loading) return item.namalengkap;
					return '[' + item.kode_negara + '] ' + item.namalengkap + ' - ' + item.namadepartmen + ', ' + item.namainstitusi + ' ' + item.negara_institusi || 'Tidak ditemukan';
				},
				templateSelection: function(item) {
					objCurrSelectedAnggotaDosenLuar = item;
					if (!item.namalengkap) {
						return item.text;
					}
					return '[' + item.kode_negara + '] ' + item.namalengkap + ' - ' + item.namadepartmen + ', ' + item.namainstitusi + ' ' + item.negara_institusi;
				}
			});
		}


		function initselect2negara() {
			$('#dosenluar-idnegara').select2({
				dropdownParent: $("#tambahDosenLuarModal")
			});
			$('#dosenluar-idnegara-institusi').select2({
				dropdownParent: $("#tambahDosenLuarModal")
			});
		}
		$(document).on('click', '#btnChangeModalDosenLuar', function() {
			$('#dosenluar-modal').modal('hide');
			$('#form-tambah-dosenluar')[0].reset();
			$('#tambahDosenLuarModal').modal('show');
			initselect2negara();
			$('#dosenluar-idnegara').val('103').trigger('change');
			$('#dosenluar-idnegara-institusi').val('103').trigger('change');
		});

		$(document).on('click', '.hapusAnggotaDosenLuar', function() {
			if (!confirm('Data ini benar-benar akan dihapus?')) return;

			$(this).parent().parent().remove();
			if ($('#dosenluar-data tr').length == 1) {
				$('.dosenluar-no-data').show();
			} else {
				$('.dosenluar-item td:first-child').each(function(i) {
					$(this).text(i + 1);
				});
			}
		});

		function tambahAnggotaDosenLuar(id, nidn, nama, tugas, prodi) {
			$('.dosenluar-no-data').hide();

			let no = $('#dosenluar-data tr').length;
			$('#dosenluar-data').append(`<tr class="dosenluar-item">
						<input type="hidden" name="dosenluar_id[]" value="${id}">
						<td>${no}</td>
						<td>${nama}<input type="hidden" name="dosenluar_nama[]" value="${nama}"></td>
						<td>${nidn}<input type="hidden" name="dosenluar_nidn[]" value="${nidn}"></td>
						<td>${prodi}<input type="hidden" name="dosenluar_prodi[]" value="${prodi}"></td>
						<td>${tugas}<input type="hidden" name="dosenluar_tugas[]" value="${tugas}"></td>
						<td class="text-right">
							<button type="button" class="btn btn-sm btn-outline-warning hapusAnggotaDosenLuar">
								<i class="fa fa-trash"></i>
							</button>
						</td>
					</tr>`);
		}



		$(document).on('submit', '#form-tambah-dosenluar', function(e) {
			e.preventDefault();
			if (!confirm('Apakah Anda yakin ingin menambahkan dosen luar ini?')) return;

			var url = "<?php echo site_url('submit/dosenluar_add'); ?>";
			var namalengkap = $('#dosenluar-nama').val();
			var nidn = $('#dosenluar-nidn').val();
			var id_negara = $('#dosenluar-idnegara').val();
			var namadepartmen = $('#dosenluar-departmen').val();
			var namainstitusi = $('#dosenluar-institusi').val();
			var id_negara_institusi = $('#dosenluar-idnegara-institusi').val();
			var tugas = $('#dosenluar-tugas-master').val();
			$.ajax({
				url: url,
				type: "POST",
				dataType: "JSON",
				data: {
					id_usulan: '',
					namalengkap: namalengkap,
					nidn: nidn,
					id_negara: id_negara,
					namadepartmen: namadepartmen,
					namainstitusi: namainstitusi,
					id_negara_institusi: id_negara_institusi,
					tugas: tugas
				},
				success: function(response) {
					// Handle success response
					hsl = response;

				},
				complete: function() {
					if (hsl.status) {
						tambahAnggotaDosenLuar(hsl.data.id_dosenluar, hsl.data.nidn, hsl.data.namalengkap, hsl.data.tugas, hsl.data.prodi);

						$('#tambahDosenLuarModal').modal('hide');
						$('#dosenluar-modal').modal('hide');
					}
					alert(hsl.message);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Handle error response
					alert('Error adding dosen luar');
				}
			});
		});

		$(document).on('submit', '#frmPilihanDosenLuar', function(e) {
			e.preventDefault();
			if (!confirm('Apakah Anda yakin ingin menambahkan dosen luar ini?')) return;

			var id = objCurrSelectedAnggotaDosenLuar.id;
			var tugas = $('#dosenluar-tugas').val();
			var nama = objCurrSelectedAnggotaDosenLuar.namalengkap + '<br/>' + objCurrSelectedAnggotaDosenLuar.negara;
			var nidn = objCurrSelectedAnggotaDosenLuar.nidn;
			var prodi = objCurrSelectedAnggotaDosenLuar.namadepartmen + ', ' + objCurrSelectedAnggotaDosenLuar.namainstitusi + ' ' + objCurrSelectedAnggotaDosenLuar.negara_institusi;
			$('#dosenluar-modal').modal('hide');
			tambahAnggotaDosenLuar(id, nidn, nama, tugas, prodi);
		});


	});
</script>