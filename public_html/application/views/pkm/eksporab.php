<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=Ekspor_RAB_$date.xls");
?>
<style>
	table {
	font: 15px Arial, sans-serif;
	}
	pre {
	font: 15px Arial, sans-serif;
	}
</style>
<h2 class="m-0 font-weight-bold text-primary">Total RAB</h2>
<table border="1" class="table table-bordered" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th width="5%">#</th>
			<th>Kelompok</th>
			<th>Komponen</th>
			<th>Satuan</th>
			<th>Volume</th>
			<th>Harga Satuan</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			$totalan = 0;
			foreach($bahan as $p)
			{
				echo "<tr>
				<td>".$no."</td>
				<td>Bahan</td>
				<td>".$p->item."</td>
				<td>".$p->satuan."</td>
				<td>".$p->volume."</td>
				<td>".rupiah($p->hargasatuan)."</td>
				<td>".rupiah($p->hargasatuan*$p->volume)."</td>
				</tr>";
				$no++;
				$totalan += ($p->hargasatuan*$p->volume);
			}
			foreach($kumpul as $p)
			{
				echo "<tr>
				<td>".$no."</td>
				<td>Pengumpulan Data</td>
				<td>".$p->item."</td>
				<td>".$p->satuan."</td>
				<td>".$p->volume."</td>
				<td>".rupiah($p->hargasatuan)."</td>
				<td>".rupiah($p->hargasatuan*$p->volume)."</td>
				</tr>";
				$no++;
				$totalan += ($p->hargasatuan*$p->volume);
			}
			foreach($sewa as $p)
			{
				echo "<tr>
				<td>".$no."</td>
				<td>Sewa Peralatan</td>
				<td>".$p->item."</td>
				<td>".$p->satuan."</td>
				<td>".$p->volume."</td>
				<td>".rupiah($p->hargasatuan)."</td>
				<td>".rupiah($p->hargasatuan*$p->volume)."</td>
				</tr>";
				$no++;
				$totalan += ($p->hargasatuan*$p->volume);
			}
			foreach($analis as $p)
			{
				echo "<tr>
				<td>".$no."</td>
				<td>Analisis Data</td>
				<td>".$p->item."</td>
				<td>".$p->satuan."</td>
				<td>".$p->volume."</td>
				<td>".rupiah($p->hargasatuan)."</td>
				<td>".rupiah($p->hargasatuan*$p->volume)."</td>
				</tr>";
				$no++;
				$totalan += ($p->hargasatuan*$p->volume);
			}
			foreach($lapor as $p)
			{
				echo "<tr>
				<td>".$no."</td>
				<td>Pelaporan dan Luaran</td>
				<td>".$p->item."</td>
				<td>".$p->satuan."</td>
				<td>".$p->volume."</td>
				<td>".rupiah($p->hargasatuan)."</td>
				<td>".rupiah($p->hargasatuan*$p->volume)."</td>
				</tr>";
				$no++;
				$totalan += ($p->hargasatuan*$p->volume);
			}
			echo "<tr><td colspan='6' align='right'><b>Total</b></td><td><b>".rupiah($totalan)."</b></td></tr>";
		?>	
	</tbody>
</table>
