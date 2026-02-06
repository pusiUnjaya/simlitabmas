<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=kuesioner_$jenis-$date.xls"); 
?>
<h2>Data Kuesioner <?php echo strtoupper($jenis); ?></h2>
<table class="table table-bordered" border="1" width="100%" cellspacing="0">
<thead>
	<tr>
	  <th rowspan="2" width="5%">No</th>
	  <th rowspan="2">Koresponden</th>
	  <th rowspan="2">Fakultas</th>
	  <th rowspan="2">Program Studi</th>
	<?php
		if($this->uri->segment(4)>=2024 || $this->uri->segment(4)=='')
		{
			echo '<th colspan="16">Pertanyaan Kuesioner</th>';
		}
		else
		{
			echo '<th colspan="11">Pertanyaan Kuesioner</th>';
		}
	?>
	  <th rowspan="2">Nilai Rata-Rata</th>
	  <th rowspan="2">Hasil</th>
	  <th rowspan="2">Saran</th>
	  <th rowspan="2">Tahun</th>
	</tr>
	<tr>
	  <th>1</th>
	  <th>2</th>
	  <th>3</th>
	  <th>4</th>
	  <th>5</th>
	  <th>6</th>
	  <th>7</th>
	  <th>8</th>
	  <th>9</th>
	  <th>10</th>
	  <th>11</th>
	  <?php
	  	if($this->uri->segment(4)>=2024 || $this->uri->segment(4)=='')
	  	{
	  		echo '
	  			<th>12</th>
				<th>13</th>
				<th>14</th>
				<th>15</th>
				<th>16</th>
	  		';
	  	}
	  ?>
	</tr>
</thead>
<tbody>
<?php
	$no = 1;
	foreach($lppm as $l)
	{
		if($this->uri->segment(4)>=2024)
	  	{
			$rata = ($l->ans1+$l->ans2+$l->ans3+$l->ans4+$l->ans5+$l->ans6+$l->ans7+$l->ans8+$l->ans9+$l->ans10+$l->ans11+$l->ans12+$l->ans13+$l->ans14+$l->ans15+$l->ans16)/16;
		}
		else
		{
			$rata = ($l->ans1+$l->ans2+$l->ans3+$l->ans4+$l->ans5+$l->ans6+$l->ans7+$l->ans8+$l->ans9+$l->ans10+$l->ans11)/11;
		}
		
		$nilai = $rata*25;
		$fakultas = $this->mdosen->namafakultas($l->fakultas);
		$prodi = $this->mdosen->namaprodi($l->prodi);
		$ambilTahun = date('Y', strtotime($l->kirim));
		echo '<tr>
			<th>'.$no.'</th>
			<th>'.$l->namalengkap.'</th>
			<th>'.$fakultas['fakultas'].'</th>
			<th>'.$prodi['prodi'].'</th>
			<th>'.$l->ans1.'</th>
			<th>'.$l->ans2.'</th>
			<th>'.$l->ans3.'</th>
			<th>'.$l->ans4.'</th>
			<th>'.$l->ans5.'</th>
			<th>'.$l->ans6.'</th>
			<th>'.$l->ans7.'</th>
			<th>'.$l->ans8.'</th>
			<th>'.$l->ans9.'</th>
			<th>'.$l->ans10.'</th>
			<th>'.$l->ans11.'</th>';
		if($this->uri->segment(4)>=2024 || $ambilTahun>=2024)
	  	{
	  		echo '<th>'.$l->ans12.'</th>';
	  		echo '<th>'.$l->ans13.'</th>';
	  		echo '<th>'.$l->ans14.'</th>';
	  		echo '<th>'.$l->ans15.'</th>';
	  		echo '<th>'.$l->ans16.'</th>';
	  	}
	  	elseif($this->uri->segment(4)=='')
	  	{
	  		echo '<th></th>';
	  		echo '<th></th>';
	  		echo '<th></th>';
	  		echo '<th></th>';
	  		echo '<th></th>';
	  	}
	  	else
	  	{
	  		
	  	}	

		echo '<th>'.number_format($rata, 2, '.', '').'</th>
			<th>'.number_format($nilai, 2, '.', '').'</th>
			<th>'.$l->saran.'</th>
			<th>'.substr($l->kirim, 0, 4).'</th>
		</tr>';
		$no++;
	}
?>
</tbody>
</table>