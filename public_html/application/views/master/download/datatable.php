
<h6 class="pt-1" style="color: blue;"><?php echo $bagian; ?></h6>
<table class="table table-bordered dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="85%">Judul</th>
			<th>Unduh</th>
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
				<td><a href='".base_url().'assets/uploadbox/'.$p->file."'>Unduh</a></td>
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