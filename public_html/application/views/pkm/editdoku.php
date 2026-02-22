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
			<h6 class="m-0 font-weight-bold text-primary">Form Edit Usulan PkM</h6>
		</div>
		<div class="card-body">
			<form class="user" action="<?php echo base_url(); ?>pengabdian/update" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $usulan['id_usulan']; ?>">
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Judul PkM</label>
						<input type="text" name="judul" value="<?php echo ucwords(strtolower($usulan['judul'])); ?>" class="form-control" placeholder="Judul PkM" required>
					</div>
					<div class="col-sm-6">
						<label>Skema PkM</label>
						<select name="skema" class="form-control">
							<?php
							//$jenis = array('Insidental','Non Insidental');
							if ($this->session->userdata('sesi_status') == 1) {
								$jenis = array('Pemberdayaan Masyarakat Pemula (PMP)', 'Pemberdayaan Kemitraan Masyarakat (PKM)', 'Pemberdayaan Masyarakat oleh Mahasiswa (PMM)', 'Kewirausahaan berbasis Mahasiswa (KBM)', 'Pemberdayaan Mitra Usaha Produk Unggulan Daerah (PM-UPUD)', 'Pemberdayaan Berbasis Desa Binaan (PDB)', 'Pemberdayaan Berbasis Lembaga');
							} else
								$jenis = $this->session->userdata('sesi_skema');
							$n = count($jenis);
							for ($i = 0; $i < $n; $i++) {
								if ($usulan['skema'] == $jenis[$i])
									echo '<option value="' . $jenis[$i] . '" selected>' . $jenis[$i] . '</option>';
								else
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
							<?php
							$out = explode(',', $usulan['luaran']);
							$hitn = count($out);

							$issn = in_array('Jurnal Nasinal BerISSN', $out) ? 'Checked' : '';
							$enam = in_array('Jurnal Nasional Terakreditasi 6', $out) ? 'Checked' : '';
							$lima = in_array('Jurnal Nasional Terakreditasi 5', $out) ? 'Checked' : '';
							$empat = in_array('Jurnal Nasional Terakreditasi 4', $out) ? 'Checked' : '';
							$tiga = in_array('Jurnal Nasional Terakreditasi 3', $out) ? 'Checked' : '';
							$dua = in_array('Jurnal Nasional Terakreditasi 2', $out) ? 'Checked' : '';
							$satu = in_array('Jurnal Nasional Terakreditasi 1', $out) ? 'Checked' : '';
							$inter = in_array('Jurnal Internasional', $out) ? 'Checked' : '';
							$interep = in_array('Jurnal Internasional Bereputasi', $out) ? 'Checked' : '';
							$paten = in_array('Paten', $out) ? 'Checked' : '';
							$hki = in_array('HKI', $out) ? 'Checked' : '';
							$bahanajar = in_array('Bahan Ajar', $out) ? 'Checked' : '';
							$prosiding = in_array('Prosiding', $out) ? 'Checked' : '';

							?>
							<div class="col-sm-12 row">
								<div class="col-sm-4">
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $issn; ?> value="Jurnal Nasinal BerISSN">Jurnal Nasional BerISSN</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $enam; ?> value="Jurnal Nasional Terakreditasi 6">Jurnal Nasional Terakreditasi 6</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $lima; ?> value="Jurnal Nasional Terakreditasi 5">Jurnal Nasional Terakreditasi 5</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $empat; ?> value="Jurnal Nasional Terakreditasi 4">Jurnal Nasional Terakreditasi 4</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $tiga; ?> value="Jurnal Nasional Terakreditasi 3">Jurnal Nasional Terakreditasi 3</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $dua; ?> value="Jurnal Nasional Terakreditasi 2">Jurnal Nasional Terakreditasi 2</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $satu; ?> value="Jurnal Nasional Terakreditasi 1">Jurnal Nasional Terakreditasi 1</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $inter; ?> value="Jurnal Internasional">Jurnal Internasional</label>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $interep; ?> value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $paten; ?> value="Paten">Paten</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $hki; ?> value="HKI">HKI</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $bahanajar; ?> value="Bahan Ajar">Bahan Ajar</label>
									</div>
									<div class="form-check form-check-inline">
										<label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $prosiding; ?> value="Prosiding">Prosiding</label>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label>Nama Jurnal</label>
						<input type="text" name="namajurnal" class="form-control" value="<?php echo $usulan['namajurnal']; ?>" placeholder="Nama Jurnal" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label for="select2SinglePlaceholder">PkM dari Sumber Penelitian?</label>
						<select class="select2-single-placeholder form-control" name="sumberpkm" id="select2SinglePlaceholder">
							<option value="">Select</option>
							<option value="Tidak Ada" <?php echo ($usulan['sumberpkm'] == '' || $usulan['sumberpkm'] == 'Tidak Ada') ? 'selected' : ''; ?>>Tidak Ada</option>
							<?php
							foreach ($riset as $r) {
								if ($usulan['sumberpkm'] == $r->id_usulan)
									echo '<option value="' . $r->id_usulan . '" selected>' . $r->judul . '</option>';
								else
									echo '<option value="' . $r->id_usulan . '">' . $r->judul . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Sumber Dana</label>
						<select name="sumberdana" class="form-control">
							<?php
							$jenis = array('Mandiri', 'Internal', 'Mandiri+Internal', 'Kerjasama', 'Dikti', 'Kopertis');
							$n = count($jenis);
							for ($i = 0; $i < $n; $i++) {
								if ($usulan['sumberdana'] == $jenis[$i])
									echo '<option value="' . $jenis[$i] . '" selected>' . $jenis[$i] . '</option>';
								else
									echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="col-sm-6">
						<label>Jumlah Dana Internal</label>
						<input type="text" id="jmldana" name="jmldana" value="<?php echo $usulan['jmldana']; ?>" class="form-control" placeholder="Jumlah Dana Internal" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<label>Anggota Dosen</label>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%">No</th>
									<th width="15%">NIDN/NPP</th>
									<th>Nama</th>
									<th>Tugas</th>
									<th width="5%" class="text-right">
										<button type="button" class="btn btn-sm btn-outline-success addAnggota" data-jenis="dosen" data-toggle="modal" data-target="#m-modal">
											<i class="fas fa-plus fa-sm"></i>
										</button>
									</th>
								</tr>
							</thead>
							<tbody id="anggotadosenterpilih">
								<tr class="m-no-data">
									<td colspan="5" align="center">Belum ada anggota dosen yang didata</td>
								</tr>
							</tbody>
						</table>
					</div>


					<div class="col-sm-12">
						<label>Anggota Mahasiswa</label>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th width="5%">No</th>
									<th width="15%">NPM</th>
									<th>Nama</th>
									<th>Tugas</th>
									<th width="5%" class="text-right">
										<button type="button" class="btn btn-sm btn-outline-success addAnggota" data-jenis="mahasiswa" data-toggle="modal" data-target="#p-modal">
											<i class="fas fa-plus fa-sm"></i>
										</button>
									</th>
								</tr>
							</thead>
							<tbody id="anggotamahasiswaperpilih">
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
						<textarea name="ringkasan" rows="5" class="form-control"><?php echo $usulan['ringkasan']; ?></textarea>
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Kata Kunci</label>
						<textarea name="katakunci" class="form-control"><?php echo $usulan['katakunci']; ?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label>Tanggal Mulai</label>
						<input type="text" name="tglmulai" class="form-control" id="tglmulai" placeholder="Tanggal Mulai" required value="<?php echo $usulan['tglmulai']; ?>">
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Tanggal Akhir</label>
						<input type="text" name="tglakhir" class="form-control" id="tglakhir" placeholder="Tanggal Akhir" required value="<?php echo $usulan['tglakhir']; ?>">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<label>File Usulan (PDF) maksimal 20Mb - Biarkan Kosong Jika tidak ada Perubahan</label>
						<input type="file" name="fileupload" class="form-control unggah" placeholder="File Usulan (PDF)">
						<p><?php echo $usulan['fileusulan']; ?></p>
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
									if ($usulan['semester'] == $sem[$i])
										echo '<option value="' . $sem[$i] . '" selected>Semester ' . $sem[$i] . '</option>';
									else
										echo '<option value="' . $sem[$i] . '">Semester ' . $sem[$i] . '</option>';
								}
								?>
							</select>
						</div>
						<?php
						if ($this->session->userdata('sesi_status') == 1) {
						?>
							<label>Status Usulan</label>
							<select name="statususulan" class="form-control">
								<?php
								$jenis = array('Usulan Baru', 'Usulan Dikirim', 'Reviewed', 'Usulan Disetujui Reviewer', 'Usulan Tidak Disetujui Reviewer', 'Usulan Disetujui', 'Usulan Tidak Disetujui');
								$n = count($jenis);
								for ($i = 0; $i < $n; $i++) {
									if ($usulan['status'] == $jenis[$i])
										echo '<option value="' . $jenis[$i] . '" selected>' . $jenis[$i] . '</option>';
									else
										echo '<option value="' . $jenis[$i] . '">' . $jenis[$i] . '</option>';
								}
								?>
							</select>
						<?php } ?>
					</div>
				</div>
				<div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" id="tmbsimpan" value="Simpan" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
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
				<h5 class="modal-title"><span id="m-modal-title">Tambah</span> Anggota Dosen</h5>
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
				<button type="button" class="btn btn-primary btSimpanAnggota" data-jenis="dosen" id="m-simpan">Simpan</button>
			</div>
		</div>
	</div>
</div>

<div id="p-modal" class="modal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><span id="p-modal-title">Tambah</span> Anggota Mahasiswa</h5>
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
				<button type="button" class="btn btn-primary btSimpanAnggota" data-jenis="mahasiswa" id="p-simpan">Simpan</button>
			</div>
		</div>
	</div>
</div>
<?php
$dosen = $this->mdosen->anggotadosen();
$datanama = array();
foreach ($dosen as $d) {
	if ($d->user <> '')
		$max = $this->mpengabdian->hitambilmax($d->user, $d->id_dosen);
	else
		$max = 0;
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
		} else {
			document.getElementById("tmbsimpan").disabled = false;
		}
		if (extension != 'pdf') {
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
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
	var nilai = document.getElementById('jmldana');
	var tanpa_rupiah = document.getElementById('jmldana');

	if (nilai.value != "")
		tanpa_rupiah.value = formatRupiah(nilai.value);

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
		var currAnggotaDosen = [];
		var currAnggotaMhs = [];
		var currAksiAnggota = 'add';
		var currIdPeran = '';


		load_anggota_dosen();
		load_anggota_mhs();

		function load_anggota_dosen() {
			$.ajax({
				url: "<?php echo site_url('pengabdian/load_anggota_dosen/' . $this->uri->segment(3)); ?>",
				method: "POST",
				success: function(data) {
					hsl = data;
				},
				complete: function() {
					htmlbody = '';
					if (hsl.status) {
						if (hsl.data.length > 0) {
							currAnggotaDosen = hsl.data;
							$.each(hsl.data, function(i, v) {
								htmlbody += '<tr>';
								htmlbody += '<td>' + (i + 1) + '</td>';
								htmlbody += '<td>' + v.nidn + '</td>';
								htmlbody += '<td>' + v.namalengkap + '</td>';
								htmlbody += '<td>' + v.tugas + '</td>';
								htmlbody += '<td class="text-right"><button type="button" class="btn btn-sm btn-outline-warning editAnggota" data-jenis="dosen" data-id="' + v.id + '"><i class="fas fa-pencil-alt fa-sm"></i></button><button type="button" class="btn btn-sm btn-outline-danger hapusAnggota" data-jenis="dosen" data-id="' + v.id + '"><i class="fas fa-trash fa-sm"></i></button></td>';
								htmlbody += '</tr>';
							});
							$('#anggotadosenterpilih').html(htmlbody);
						} else {
							$('#anggotadosenterpilih').html('<tr class="m-no-data"><td colspan="5" align="center">Belum ada anggota dosen yang didata</td></tr>');

						}
					} else {
						alert(hsl.message);
					}
				}
			});
		}

		function load_anggota_mhs() {
			$.ajax({
				url: "<?php echo site_url('pengabdian/load_anggota_mhs/' . $this->uri->segment(3)); ?>",
				method: "POST",
				success: function(data) {
					hsl = data;
				},
				complete: function() {
					htmlbody = '';
					if (hsl.status) {
						if (hsl.data.length > 0) {
							currAnggotaMhs = hsl.data;
							$.each(hsl.data, function(i, v) {
								htmlbody += '<tr>';
								htmlbody += '<td>' + (i + 1) + '</td>';
								htmlbody += '<td>' + v.npm + '</td>';
								htmlbody += '<td>' + v.namamhs + '</td>';
								htmlbody += '<td>' + v.tugas + '</td>';
								htmlbody += '<td class="text-right"><button type="button" class="btn btn-sm btn-outline-warning editAnggota" data-jenis="mahasiswa" data-id="' + v.id + '"><i class="fas fa-pencil-alt fa-sm"></i></button><button type="button" class="btn btn-sm btn-outline-danger hapusAnggota" data-jenis="mahasiswa" data-id="' + v.id + '"><i class="fas fa-trash fa-sm"></i></button></td>';
								htmlbody += '</tr>';
							});
							$('#anggotamahasiswaperpilih').html(htmlbody);
						} else {
							$('#anggotamahasiswaperpilih').html('<tr class="p-no-data"><td colspan="5" align="center">Belum ada anggota mahasiswa yang didata</td></tr>');
						}
					} else {
						alert(hsl.message);
					}
				}
			});
		}

		$(document).on('click', '.addAnggota', function() {
			var jenis = $(this).data('jenis');
			currAksiAnggota = 'add';
			if (jenis == 'dosen') {
				$('#m-id').val('').trigger('change');
				$('#m-tugas').val('');
				$('#m-simpan').removeData('edit');
				$('#m-simpan').data('jenis', jenis);
				$('#m-modal-title').text('Tambah');
				$('#m-modal').modal('show');
			} else {
				$('#p-id').val('').trigger('change');
				$('#p-tugas').val('');
				$('#p-simpan').removeData('edit');
				$('#p-simpan').data('jenis', jenis);
				$('#p-modal-title').text('Tambah');
				$('#p-modal').modal('show');
			}
		});


		var currSelectedAnggotaMhs = '';
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


		$(document).on('click', '.editAnggota', function() {
			var jenis = $(this).data('jenis');
			var id = $(this).data('id');
			currAksiAnggota = 'edit';
			currIdPeran = id;
			if (jenis == 'dosen') {
				var anggota = currAnggotaDosen.find(x => x.id == id);
				$('#m-id').val(anggota.id_dosen).trigger('change');
				$('#m-tugas').val(anggota.tugas);
				$('#m-simpan').data('edit', id);
				$('#m-simpan').data('jenis', jenis);
				$('#m-modal-title').text('Edit');
				$('#m-modal').modal('show');
			} else {
				var anggota = currAnggotaMhs.find(x => x.id == id);
				// Pastikan value dan text terisi agar select2 langsung tampil
				formatSelectedMhs(anggota.npm, anggota.namamhs);
				$('#p-tugas').val(anggota.tugas);
				$('#p-simpan').data('edit', id);
				$('#p-simpan').data('jenis', jenis);
				$('#p-modal-title').text('Edit');
				$('#p-modal').modal('show');
			}
		});

		$(document).on('click', '.hapusAnggota', function() {
			var jenis = $(this).data('jenis');
			var id = $(this).data('id');
			if (confirm("Apakah Anda yakin ingin menghapus anggota ini?")) {
				$.ajax({
					url: "<?php echo site_url('pengabdian/simpan_anggota'); ?>",
					method: "POST",
					data: {
						id: id,
						aksi: 'delete',
						jenis: jenis,
						id_usulan: "<?php echo $this->uri->segment(3); ?>"
					},
					success: function(data) {
						hsl = data;
					},
					complete: function() {
						if (hsl.status) {
							if (jenis == 'dosen') {
								load_anggota_dosen();
							} else {
								load_anggota_mhs();
							}
						}
						alert(hsl.message);
					}
				});
			}
		});


		$(document).on('click', '.btSimpanAnggota', function() {
			if (confirm("Apakah Anda yakin ingin menyimpan data anggota ini?")) {
				var jenis = $(this).data('jenis');
				var edit = $(this).data('edit');
				var id = currIdPeran;
				var anggota = (jenis == 'dosen') ? $('#m-id').val() : $('#p-id').val();
				var tugas = (jenis == 'dosen') ? $('#m-tugas').val() : $('#p-tugas').val();

				if (currAksiAnggota == 'add') {
					if (anggota == "" || tugas == "") {
						alert("Semua field harus diisi!");
						return;
					}
				} else {
					if (id == "" || tugas == "" || anggota == "") {
						alert("Semua field harus diisi!");
						return;
					}
				}
				$.ajax({
					url: "<?php echo site_url('pengabdian/simpan_anggota'); ?>",
					method: "POST",
					data: {
						id: id,
						anggota: anggota,
						tugas: tugas,
						jenis: jenis,
						aksi: currAksiAnggota,
						id_usulan: "<?php echo $this->uri->segment(3); ?>"
					},
					success: function(data) {
						hsl = data;
					},
					complete: function() {
						if (hsl.status) {
							if (jenis == 'dosen') {
								load_anggota_dosen();
								$('#m-modal').modal('hide');
							} else {
								load_anggota_mhs();
								$('#p-modal').modal('hide');
							}
						}
						alert(hsl.message);

					}
				});

			}
		});
	});
</script>