<h6 class="pt-1" style="color: blue;"><?php echo $bagian; ?></h6>
<table class="table table-bordered dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="85%">Judul</th>
			<th>File Dokumen</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($download as $p)
			{
				echo "<tr>
				<td style='color:green'>".$p->judul."
				<br><span style='color:gray'>Update Terakhir ".tgl_indo($p->modified,1)."
				</span></td>
				<td><a href='".base_url().'assets/uploadbox/'.$p->file."'>Download</a></td>
				<td width='10%'>
				<a href='#' data-toggle='modal' data-target='#edit-modal' data-dok='".$p->id_file.",".$p->judul.",".$p->keterangan.",".$p->file.",".$p->jenisdok.",".$p->katedok."' class='shadow-sm' title='Edit File'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
				<a href='#' data-id='".$p->id_file."' rel='tooltip' data-placement='top' title='Hapus Pengguna' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a>
				</td>
				</tr>";
			}
		?>	
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function () {
	$('.dataTable').DataTable({
		"ordering": false // false to disable sorting (or any other option)
	});
});
</script>