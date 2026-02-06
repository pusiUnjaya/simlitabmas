<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Rekap Kinerja Dosen - Pengabdian</h1>
	</div>

	<form class="user" action="<?php echo base_url('rekap/pengabdian') ?>" method="post">
		<div class="card shadow mb-4">
			<div class="card-body">
				<div class="form-group row">
					<div class="col-sm-6">
						<label>Periode</label>
						<select name="periode" class="form-control">
							<?php foreach (range(+date('Y'), 2018, -1) as $i): ?>
								<option <?php echo ($i == $periode) ? 'selected' : '' ?>><?php echo $i ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Program Studi</label>
						<select name="prodi" id="prodi" class="form-control" required>
							<option value="Semua">Semua Program Studi</option>
							<?php foreach ($daftar_prodi as $p): ?>
								<option value="<?php echo $p->id_prodi ?>"
									<?php echo ($p->id_prodi == $prodi) ? 'selected' : '' ?>>
									<?php echo $p->prodi ?>
								</option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary btn-user" style="width:200px">Rekap</button>
			</div>
		</div>
	</form>

	<div class="card shadow mb-4">
		<div class="card-header text-right">
			<?php if ($this->session->userdata('sesi_status') == 1): ?>
				<div class="dropdown">
					<a class="btn btn-sm btn-success dropdown-toggle" href="#" role="button"
						data-toggle="dropdown" aria-expanded="false">
						<i class="fas fa-file-excel fa-sm text-white-50"></i>
						Ekspor Data ke Excel
					</a>

					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?php echo base_url("rekap/eksporrevisiusulanpkm/$periode") ?>">Revisi Usulan</a>
						<a class="dropdown-item" href="<?php echo base_url("rekap/eksporreviewusulanpkm/$periode/$prodi") ?>">Review Usulan</a>
						<a class="dropdown-item" href="<?php echo base_url("rekap/eksporreviewlaporanpkm/$periode/$prodi") ?>">Review Laporan</a>
						<a class="dropdown-item" href="<?php echo base_url("rekap/eksporlapkemajuanpkm/$periode/$prodi") ?>">Laporan Kemajuan</a>
						<a class="dropdown-item" href="<?php echo base_url("rekap/eksporpengabdian/$periode/$prodi") ?>">Pengabdian</a>
						<a class="dropdown-item" href="<?php echo base_url("rekap/eksporpengabdian/semua/semua") ?>">Semua Pengabdian</a>
					</div>
				</div>
			<?php endif ?>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered display" id="dataTable" class="display" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th width="95%">Pengabdian</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>No</th>
							<th width="95%">Pengabdian</th>
						</tr>
					</tfoot>
					<tbody>
						<?php foreach ($data as $no => $item): ?>
							<tr>
								<td><?php echo $no + 1 ?></td>
								<td>
								<table class="table table-sm table-borderless">
									<?php foreach ($item as $key => $value): ?>
										<tr>
											<th class="p-0 pr-3" nowrap><?php echo $key ?></th>
											<td class="p-0" width="95%"><?php echo !empty($value) ? $value : '-' ?></td>
										</tr>
									<?php endforeach ?>
								</table>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--</div> -->

	<script>
		$(document).ready(function () {
			$("#fakultas").change(function () {
				var url = "<?php echo site_url('rekap/load_prodi'); ?>/" + $(this).val();
				$('#prodi').load(url);
				return false;
			});
		});
	</script>