<div class="container-fluid">
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Setting Tanggal Surat</h1>
	</div>
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<div class="row">
				<div class="col-md-12">
					<h6 id="daftarpenelitian" class="m-0 font-weight-bold text-primary">Tanggal surat :</h6>
					<div class="col-sm-12 col-md-4 float-right" style="margin-top:-25px;margin-right: -200px;" data-toggle='modal' data-target='#surat-modal'>
						<button type="button" class="btn btn-primary" name="tambah" id="tambah"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</button>
					</div>
					<div class="col-sm-12 col-md-12 style=" background-color: rgba(255, 192, 203, 0.5); padding: 15px; border-radius: 5px;">
						<p>1. Surat Terbit Penelitian per tahun hanya perlu 1 surat terbit.
							2. Surat Terbit PKM per tahun perlu 2, Sem Ganjil dan Genap.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Tahun</th>
							<th>Jenis Aktivitas</th>
							<th>Semester</th>
							<th>Surat Tugas</th>
							<th>Surat Kontrak</th>
							<th>Akhir Kontrak</th>
							<th>SKep Kontrak</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($terbit as $p) {
							//echo "<tr";
							echo "<td>" . $p->tahun . "</td>";
							echo "<td>" . $p->jenis . "</td>";
							echo "<td>" . $p->semester . "</td>";
							echo "<td>" . $p->surat_tugas . "</td>";
							echo "<td>" . $p->surat_kontrak . "</td>";
							echo "<td>" . $p->akhirkontrak . "</td>";
							echo "<td>" . $p->skepkontrak . "</td>";
							echo "<td align='center'>";
							/*if($p->status==0)
										echo '<a href="'.base_url().'surat/pakaidasar/'.$p->iddasar.'" class="btn btn-secondary" title="Pakai Dasar Hukum"><i class="fas fa-window-close fa-sm"></i> nonaktif</a>';
								else
										echo '<a href="'.base_url().'surat/tidakdasar/'.$p->iddasar.'" class="btn btn-success" title="Pakai Dasar Hukum"><i class="fas fa-check fa-sm"></i> aktif</a>';
								echo "</td>
										  <td align='center'><a href='".base_url()."surat/editdasar/".$p->iddasar."' class='btn btn-warning' title='Edit Dasar Hukum'><i class='fas fa-edit fa-sm'></i></a>
										  	<a href='#' data-id='".$p->iddasar."' class='btn btn-danger hapus' title='Hapus Dasar Hukum'><i class='fas fa-trash fa-sm'></i></a>
										  </td>
										</tr>";*/
							echo " <button class='btn btn-warning editsurat' title='Edit Tanggal' data-toggle='modal' data-target='#surat-modal'  
								        data-idsurat='" . $p->idsurat . "' data-jenis='" . $p->jenis . "' data-tahun='" . $p->tahun . "' data-semester='" . $p->semester . "' data-surat_tugas='" . $p->surat_tugas . "' 
										data-surat_kontrak='" . $p->surat_kontrak . "' data-akhirkontrak='" . $p->akhirkontrak . "' data-skepkontrak='" . $p->skepkontrak . "'>
										<i class='fas fa-edit fa-sm'></i></button>
									   <button data-id='" . $p->idsurat . "' class='btn btn-danger hapus' title='Hapus Tanggal'><i class='fas fa-trash fa-sm'></i></button>
										  </td>
										</tr>";
							//echo "</td></tr> data-toggle='modal' data-target='#surat-modal'";		
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Edit Surat -->
<div class="modal fade" id="surat-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Data Surat</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form method="post" name="form-surat" id="form-surat" enctype="multipart/form-data">
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Tahun :</label>
						<div class="col-sm-7">
							<input type="hidden" name="action" id="action">
							<input type="hidden" name="idsurat" id="idsurat">
							<input type="text" name="tahun" class="form-control" id="tahun">
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Surat Tugas :</label>
						<div class="col-sm-7">
							<input type="date" name="surat_tugas" class="form-control" id="surat_tugas">
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Surat Kontrak :</label>
						<div class="col-sm-7">
							<input type="date" name="surat_kontrak" class="form-control" id="surat_kontrak">
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Tanggal Akhir Kontrak :</label>
						<div class="col-sm-7">
							<input type="date" name="akhirkontrak" class="form-control" id="akhirkontrak">
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">S.Kep Kontrak :</label>
						<div class="col-sm-7">
							<input type="text" name="skepkontrak" class="form-control" id="skepkontrak">
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Jenis Kontrak :</label>
						<div class="col-sm-7">
							<select name="jenis" id="jenis" class="form-control">
								<option value="Penelitian">Penelitian</option>
								<option value="Pengabdian">Pengabdian</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-5 col-form-label">Pelaksanaan Semester :</label>
						<div class="col-sm-7">
							<select name="semester" id="semester" class="form-control">
								<option value="Ganjil">Ganjil</option>
								<option value="Genap">Genap</option>
							</select>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-success" name="simpan" id="simpan">Simpan</button>
			</div>
			</form>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('table.display').DataTable({
			"order": []
		});

		$('.editsurat').click(function() {
			var idsurat = '';
			var tahun = '';
			var jenis = '';
			var semester = '';
			var surat_tugas = '';
			var surat_kontrak = '';
			var akhirkontrak = '';
			var skepkontrak = '';

			idsurat = $(this).data('idsurat');
			tahun = $(this).data('tahun');
			jenis = $(this).data('jenis');
			semester = $(this).data('semester');
			surat_tugas = $(this).data('surat_tugas');
			surat_kontrak = $(this).data('surat_kontrak');
			akhirkontrak = $(this).data('akhirkontrak');
			skepkontrak = $(this).data('skepkontrak');

			$('#action').val('edit');
			$('#idsurat').val(idsurat);
			$('#tahun').val(tahun);
			$('#jenis').val(jenis).trigger('change');
			$('#semester').val(semester).trigger('change');
			$('#surat_tugas').val(surat_tugas);
			$('#surat_kontrak').val(surat_kontrak);
			$('#akhirkontrak').val(akhirkontrak);
			$('#skepkontrak').val(skepkontrak);
		});

		$('#tambah').click(function() {
			var tahun = new Date().getFullYear();

			$('#action').val('add');
			$('#idsurat').val('');
			$('#tahun').val(tahun);
			$('#jenis').val('Peneliltian').trigger('change');
			$('#semester').val('Ganjil').trigger('change');
			$('#surat_tugas').val('');
			$('#surat_kontrak').val(surat_kontrak);
			$('#akhirkontrak').val(akhirkontrak);
			$('#skepkontrak').val('');
		});

		$('#simpan').click(function(e) {
			e.preventDefault();

			$('#surat-modal').modal('hide');
			$.ajax({
				url: "<?php echo base_url('surat/simpanterbit'); ?>",
				type: "POST",
				data: $('#form-surat').serialize(),
				dataType: "JSON",
				success: function(response) {
					if (response.status) {
						alert("Penyimpanan Sukses");
						location.reload(); // Refresh halaman
					} else {
						alert("Gagal menyimpan: " + response.message);
					}
					location.reload();
				},
				error: function(xhr, status, error) {
					console.log(xhr.responseText);
					alert("Terjadi kesalahan server. Periksa konsol browser.");
					$('#simpan').attr('disabled', false).text('Simpan');
					location.reload();
				}
			});

		});

		$(".hapus").click(function() {
			var id = $(this).data('id');
		});

	});
</script>