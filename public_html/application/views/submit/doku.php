<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<!-- <link rel="stylesheet" href="<?php //echo base_url(); 
									?>assets/css/bootstrap-select.min.css"> -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.min.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/vendor/select2/dist/js/select2.min.js"></script>

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
			<h6 class="m-0 font-weight-bold text-primary">Form Submit Penelitian</h6>
		</div>
		<div class="card-body">
			<form class="user" action="<?php echo base_url(); ?>submit/simpan" method="post" enctype="multipart/form-data">
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Judul Penelitian</label>
						<input type="text" name="judul" class="form-control" placeholder="Judul Penelitian" required>
					</div>
					<div class="col-sm-6">
						<label>Skema Penelitian</label>
						<select name="skema" class="form-control">
							<?php
							//$jenis = array('Dasar','Terapan','Pengembangan','Kejuangan');
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
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Kategori Indikator TKT</label>
						<select name="kategoritkt" class="form-control">
							<?php
							$jenistkt = $this->mtkt->jenistkt();
							foreach ($jenistkt as $j) {
								if ($this->session->userdata('tkt')['jenis'] == $j->id)
									echo '<option value="' . $j->id . '" selected>' . $j->nama . '</option>';
								else
									echo '<option value="' . $j->id . '">' . $j->nama . '</option>';
							}
							?>
						</select>
					</div>
					<div class="col-sm-6">
						<div class="form-group row">
							<div class="col-sm-9">
								<label>Capaian TKT</label>
								<select name="capaiantkt" class="form-control">
									<?php
									$jenis = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
									$n = count($jenis);
									$hasiltkt = $this->mtkt->ukur_tkt($this->session->userdata('tkt')['capaian']);
									for ($i = 0; $i < $n; $i++) {
										if ($hasiltkt == $jenis[$i])
											echo '<option value="' . $jenis[$i] . '" selected>' . $jenis[$i] . '</option>';
										else
											echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
									}
									?>
								</select>
							</div>
							<div class="col-sm-3">
								<label> </label>
								<input type="button" onclick="location.href='<?php echo base_url(); ?>submit/tkt/new'" value="Ukur TKT" style="margin-top: 10px;" class="btn-sm btn-primary btn-block">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label>Luaran</label><br>
						<div class="col-sm-12 row">
							<div class="col-sm-4">
								<div class="form-check form-check-inline">
									<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" value="Jurnal Nasional BerISSN">Jurnal Nasional BerISSN</label>
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
						<label>Kerjasama</label>
						<input type="text" name="kerjasama" class="form-control" placeholder="Nomor Kerjasama" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Sumber Dana</label>
						<input type="text" name="sumberdana" value="Dana Internal" class="form-control" readonly>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<label>Jumlah Dana</label>
							<input type="text" id="danaint" name="danaint" value="0" class="form-control" placeholder="Jumlah Dana Internal" required>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<input type="text" name="sumberdana" value="Dana Mandiri" class="form-control" readonly>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="text" id="danaman" name="danaman" value="0" class="form-control" placeholder="Jumlah Dana Mandiri" required>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<input type="text" name="sumberdana" value="Dana Eksternal" class="form-control" readonly>
					</div>
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="text" id="danaeks" name="danaeks" value="0" class="form-control" placeholder="Jumlah Dana Eksternal" required>
						</div>
					</div>
				</div>
				<!-- <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Ketua</label>
					<input type="text" class="form-control" value="<?php //echo $this->session->userdata('sesi_nama');
																	?>" readonly>
                  </div>
                  <div class="col-sm-6">
                    <label>uraian tugas dalam penelitian *</label>
					<textarea id="uraiantugas" name="uraiantugas" class="form-control" placeholder="" required></textarea>
                  </div>
                </div>
        <div class="form-group row">
            <div class="col-sm-12">
            	<label>Anggota Dosen</label>&nbsp;&nbsp;&nbsp;<input type="button" data-toggle="modal" data-target="#modal-dosen" value="+ Tambah" class="d-sm-inline-block col-sm-1 btn-sm btn-primary btn-block">
            	<table class="table table-bordered" width="100%" cellspacing="0">
            		<tr>
            				<td width="5%">No</td>
            				<td>NIDN</td>
            				<td>Nama</td>
            				<td>Peran</td>
            				<td>Tugas</td>
            				<td>Aksi</td>
            		</tr>
            		<div id="isidosen">
            			<tr>
            				<td colspan="6" align="center">Belum Ada Anggota Dosen</td>
            			</tr>
            		</div>
            	</table>
            </div>
        </div> -->
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
					<!-- <div class="col-sm-6">
                    <label>Anggota Dosen</label>
					<input type="text" name="anggotadosen" id="anggotadosen" class="form-control" required>
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" id="values">
					<span id="warnings"></span>
                  </div> -->
					<!-- <div class="col-sm-2 mb-3 mb-sm-0">
                    <label>Jumlah Mahasiswa</label>
					<input name="jumlahmhs" id="jumlahmhs" type="number" value="1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="Jml Mahasiswa" required>
                  </div -->
					<!-- <div class="col-sm-4 mb-3 mb-sm-0">
                    <label>Anggota Mahasiswa &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modal_mhs" type="button" class="btn-xs btn-primary">+ mhs</a></label> -->
					<!-- <textarea name="anggotamhs_" rows="3" class="form-control" placeholder="1. NIM/Mahasiswa" required></textarea> -->

					<!-- <input type="text" name="anggotamhs" id="anggotamhs" class="form-control" required>
					<input type="hidden" id="labelmhs">
					<input type="hidden" name="idmhs" id="valuemhs">
					<span id="warningmhs"></span> -->

					<!-- </div> -->
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
<?php
//anggota dosen
$dosen = $this->mdosen->anggotadosen();
$datanama = array();
foreach ($dosen as $d) {
	if ($d->user <> '')
		$max = $this->msubmit->hitambilmax($d->user, $d->id_dosen);
	else
		$max = 1;
	if ($max < 3) {
		$datanama[] = array(
			'value' => $d->id_dosen,
			'label' => $d->namalengkap
		);
	}
}
$anggota = json_encode($datanama);


//anggota mhs
$mhs = $this->msubmit->anggotamhs();
$datamhs = array();
foreach ($mhs as $d) {
	$datamhs[] = array(
		'value' => $d->idmhs,
		'label' => $d->namamhs
	);
}
$anggotamhs = json_encode($datamhs);
?>

<!-- Modal Tambah Mahasiswa -->
<div class="modal fade" id="modal_mhs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
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
						<label for="recipient-name" class="col-form-label">NPM : &nbsp;<b for="ceknpm" class="form-label" id="ceknpm" style="display:none"></b></label>
						<input type="text" id="npm" maxlength="9" name="npm" class="form-control" placeholder="Masukkan NPM" required>
						<label for="recipient-name" class="col-form-label">Nama Mahasiswa :</label>
						<input type="text" id="namamhs" name="namamhs" class="form-control" placeholder="Masukkan Nama Lengkap Mahasiswa" required>
						<label for="recipient-name" class="col-form-label">Nomor HP :</label>
						<input type="text" id="nomorhp" name="nomorhp" class="form-control" placeholder="Masukkan Nomor HP" required>
						<label for="recipient-name" class="col-form-label">Email Mahasiswa:</label>
						<input type="email" id="emailmhs" name="emailmhs" class="form-control" placeholder="Masukkan Email Mahasiswa" required>
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
					<select id="m-id" class="form-control" style="width: 700px;">
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
					<select id="p-id" class="form-control" style="width: 700px;">
						<option value="">-- Pilih salah satu --</option>
						<?php foreach ($mahasiswa as $p): ?>
							<?php if ($p->status == 'Aktif'): ?>
								<option value="<?php echo $p->npm ?>">
									<?php echo $p->namamhs ?> (<?php echo $p->namafak . '/' . $p->namaprodi ?>)
								</option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
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

<script>
	$(document).ready(function() {
		$('#m-id').select2({
			dropdownParent: $("#m-modal")
		});
	});

	$(document).ready(function() {
		$('#p-id').select2({
			dropdownParent: $("#p-modal")
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

	//anggota mahasiswa
	function hapusAnggotaMhs(el) {
		if (!confirm('Data ini benar-benar akan dihapus?')) return;

		$(el).parent().parent().remove();
		if ($('#p-data tr').length == 1) {
			$('.p-no-data').show();
		} else {
			$('.p-item td:first-child').each(function(i) {
				$(this).text(i + 1);
			});
		}
	}

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
	            <button type="button" class="btn btn-sm" onclick="hapusAnggotaMhs(this)">
	                <i class="fa fa-trash"></i>
	            </button>
	        </td>
	    </tr>`);
	}

	$('#p-simpan').on('click', ev => {
		let id = $('#p-id').val();
		if (id == '') {
			alert('Mohon dipilih salah satu');
			return;
		}
		let namaID = $('#p-id :selected').text().trim();
		let tugas = $('#p-tugas').val();
		let nama = namaID.substr(0, namaID.indexOf(' ('));
		let npm = $('#p-id').val();;
		// let npm = namaID.substring(namaID.indexOf(' (') + 2, namaID.length - 1);

		$('#p-modal').modal('hide');
		tambahAnggotaMhs(id, npm, nama, tugas);
	});


	$(document).ready(function() {
		// Untuk sunting
		$('#modal-dosen').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
			var modal = $(this)

			// Isi nilai pada field
			modal.find('.idusul').attr("value", div.data('idusul'));
		});
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
			return false;
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

	//cek nidn
	$(document).ready(function() {
		$("#nidn").on("input", function(e) {
			$('#ceknidn').hide();
			regex = /^[0-9]+$/;
			if ($('#nidn').val() == null || $('#nidn').val() == "" || $('#nidn').val().length < 10) {
				$('#ceknidn').show();
				$("#ceknidn").html("Masukkan NIDN dengan 10 angka.").css("color", "red");
				document.getElementById("btnDosen").disabled = true;
			} else if (regex.exec($('#nidn').val()) == null) {
				$('#nidn').show();
				$("#ceknidn").html("Masukkan NIDN dengan 10 angka.").css("color", "red");
				document.getElementById("btnDOsen").disabled = true;
			} else {
				$('#ceknidn').hide();
				document.getElementById("btnDosen").disabled = false;
				document.getElementById("tugas").disabled = false;
				var url = "<?php echo site_url('dosen/datadosen'); ?>/" + $(this).val();
				$('#datadosen').load(url);
			}
		});
	});

	//tambah mhs
	// $(document).ready(function(){
	// 	$("#addmhs").submit(function (){
	// 		var url = "<?php echo site_url('submit/addmhs'); ?>";
	// 		$('#p-id').load(url);
	// 		return false;
	// 	});
	// });

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
	var nominaleks = document.getElementById('danaeks');
	nominaleks.addEventListener('keyup', function(e) {
		nominaleks.value = formatRupiah(this.value);
	});

	nominaleks.addEventListener('keydown', function(event) {
		limitCharacter(event);
	});

	var nominalint = document.getElementById('danaint');
	nominalint.addEventListener('keyup', function(e) {
		nominalint.value = formatRupiah(this.value);
	});

	nominalint.addEventListener('keydown', function(event) {
		limitCharacter(event);
	});

	var danaman = document.getElementById('danaman');
	danaman.addEventListener('keyup', function(e) {
		danaman.value = formatRupiah(this.value);
	});

	danaman.addEventListener('keydown', function(event) {
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
			regex = /^[0-9]+$/;
			if ($('#npm').val() == null || $('#npm').val() == "") {
				$('#ceknpm').show();
				$("#ceknpm").html("Masukkan NPM dengan 9 angka.").css("color", "red");
				document.getElementById("btnSavemhs").disabled = true;
			} else {
				//cek mhs
				if ($('#npm').val() == null || $('#npm').val() == "" || $('#npm').val().length < 9) {
					$('#ceknpm').show();
					$("#ceknpm").html("Masukkan NPM dengan 9 angka.").css("color", "red");
					document.getElementById("btnSavemhs").disabled = true;
				} else if (regex.exec($('#npm').val()) == null) {
					$('#ceknpm').show();
					$("#ceknpm").html("Masukkan NPM dengan 9 angka.").css("color", "red");
					document.getElementById("btnSavemhs").disabled = true;
				} else {
					$('#ceknpm').show();
					document.getElementById("btnSavemhs").disabled = false;
					var url = "<?php echo site_url('dosen/datamhs'); ?>/" + $('#npm').val();
					$('#ceknpm').load(url);
				}

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
					$('#p-id').load(url);
					return false;
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

	function saveDosen() {
		var url = "<?php echo site_url('submit/dosen_add'); ?>";
		var nidn = $('#nidn').val();
		var peran = $('#peran').val();
		var tugas = $('#tugas').val();
		$.ajax({
			url: url,
			type: "POST",
			data: {
				nidn: nidn,
				peran: peran,
				tugas: tugas
			},
			success: function(data) {
				$('#isidosen').html(data);
			}
		});
	}
</script>