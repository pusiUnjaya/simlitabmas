<div class="container-fluid">
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dokumen</h1>
	</div>
	
	<!-- Content Row -->
	
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="60%">Judul</th>
							<th>File Dokumen</th>
							<th>Update Terakhir</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Judul</th>
							<th>File Dokumen</th>
							<th>Update Terakhir</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
							foreach($download as $p)
							{
								echo "<tr>
								<td>".$p->judul."</td>
								<td><a href='".base_url().'assets/uploadbox/'.$p->file."' target='_blank'>Download</a></td>
								<td width='25%'>".tgl_indo($p->modified,1)."</td>
								</tr>";
							}
						?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#dataTable').DataTable({
			"ordering": false // false to disable sorting (or any other option)
		});
		$('.dataTables_length').addClass('bs-select');
	});
</script>