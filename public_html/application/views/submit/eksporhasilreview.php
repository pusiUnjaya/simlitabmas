<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=hasil_review_$date.xls");
?>
<style>
table {
	font: 15px Arial, sans-serif;
}
pre {
	font: 15px Arial, sans-serif;
}
</style>
<h2>Daftar Hasil Reviewer Usulan Penelitian Dosen</h2>
<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
			<th width="30%">Judul Penelitian</th>
			<th width="10%">Tim Peneliti</th>
			<th width="30%">Hasil Review</th>
			<th width="15%">Rekomendasi</th>
			<th width="15%">Nilai</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			foreach($hasilreview as $p)
			{
				echo "<tr><td>$p->judul</td><td>Ketua :".$p->namapengusul."
						<br>Anggota :<br>";
						$anggotadosen = $this->msubmit->perananggota($p->id_usulan,'Penelitian');
						$hitangg = count($anggotadosen);
						if($hitangg>0)
						{
							echo '<ol>';
							for($i=0;$i<$hitangg;$i++)
							{
								$revnya = $anggotadosen[$i]->namalengkap;
								echo '<li>'.$revnya.'</li>';
							}
							echo '</ol>';			
						}
				$dosenluar = $this->msubmit->perananggotadosenluar($p->id_usulan,'Penelitian');
				$hitangg = count($dosenluar);
				if($hitangg>0)
				{
					echo '<ol>';
					for($i=0;$i<$hitangg;$i++)
					{
						$revnya = $dosenluar[$i]->namalengkap;
						echo '<li>'.$revnya.'</li>';
					}
					echo '</ol>';			
				}
				else {
					echo '-';
				}

				echo "</td><td>";
				$hasilreview = $this->msubmit->rekaphasilreview($p->id_usulan);
				$hitangg = count($hasilreview);
				echo '<ol>';
				for($i=0;$i<$hitangg;$i++)
				{
					$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
					echo '<li>'.$revnya.'<br>'.$hasilreview[$i]->hasilreview.'</li>';
				}
				echo '</ol></td><td><ol>';			

				for($i=0;$i<$hitangg;$i++)
				{
					$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
					echo '<li>'.$revnya.'<br>'.$hasilreview[$i]->rekomendasi.'</li>';
				}
				echo '</ol></td><td><ol>';			

				for($i=0;$i<$hitangg;$i++)
				{
					$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
					if ($hasilreview[$i]->skor<>''){

						$skor = explode(',',$hasilreview[$i]->skor);
						echo '<li>'.$revnya.'<br>';

						$poin1 = (float) $skor[0];
						$poin2 = (float) $skor[1];
						$poin3 = (float) $skor[2];
						$poin4 = (float) $skor[3];
						$poin5 = (float) $skor[4];
						$poin6 = (float) $skor[5];
						$poin7 = (float) $skor[6];
						$poin8 = (float) $skor[7];
						$poin9 = (float) $skor[8];
						$poin10 = (float) $skor[9];
						$tahun = date('Y',strtotime($hasilreview[$i]->modified));
						$bulan = date('m',strtotime($hasilreview[$i]->modified));
						if ($tahun>=2023 && ($tahun<=2024 && $bulan<5)){
							$final = (($poin1*20)+($poin2*15)+($poin3*20)+($poin4*15)+($poin5*10)+($poin6*20))/4;
							$poin1 = 20*(float) $skor[0];
							$poin2 = 15*(float) $skor[1];
							$poin3 = 20*(float) $skor[2];
							$poin4 = 15*(float) $skor[3];
							$poin5 = 10*(float) $skor[4];
							$poin6 = 20*(float) $skor[5];
							
							echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6;
						}else if($tahun>=2024 && $bulan>=5){
							$final = (($poin1*10)+($poin2*10)+($poin3*10)+($poin4*10)+($poin5*10)+($poin6*10)+($poin7*10)+($poin8*10)+($poin9*10)+($poin10*10))/4;
							$poin1 = 10*(float) $skor[0];
							$poin2 = 10*(float) $skor[1];
							$poin3 = 10*(float) $skor[2];
							$poin4 = 10*(float) $skor[3];
							$poin5 = 10*(float) $skor[4];
							$poin6 = 10*(float) $skor[5];
							$poin7 = 10*(float) $skor[6];
							$poin8 = 10*(float) $skor[7];
							$poin9 = 10*(float) $skor[8];
							$poin10 = 10*(float) $skor[9];
							echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6.','.$poin7.','.$poin8.','.$poin9.','.$poin10;
						}else if ($tahun==2025){
							$final = (($poin1*20)+($poin2*15)+($poin3*20)+($poin4*15)+($spoin5*10)+($poin6*20))/7;
							$poin1 = 20*(float) $skor[0];
							$poin2 = 15*(float) $skor[1];
							$poin3 = 20*(float) $skor[2];
							$poin4 = 15*(float) $skor[3];
							$poin5 = 10*(float) $skor[4];
							$poin6 = 20*(float) $skor[5];
							echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6;
						}else {
							$final = (($poin1*10)+($poin2*10)+($poin3*10)+($poin4*10)+($poin5*10)+($poin6*10)+($poin7*10)+($poin8*10)+($poin9*10)+($poin10*10))/4;
							$poin1 = 10*(float) $skor[0];
							$poin2 = 10*(float) $skor[1];
							$poin3 = 10*(float) $skor[2];
							$poin4 = 10*(float) $skor[3];
							$poin5 = 10*(float) $skor[4];
							$poin6 = 10*(float) $skor[5];
							$poin7 = 10*(float) $skor[6];
							$poin8 = 10*(float) $skor[7];
							$poin9 = 10*(float) $skor[8];
							$poin10 = 10*(float) $skor[9];
							echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6.','.$poin7.','.$poin8.','.$poin9.','.$poin10;
						}
						
						echo '<br>Skor : '.$final.'</li>';
					}else{
						$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
						echo '<li>'.$revnya.'<br>-</li>';
					}
				}
				echo '</ol></td>';			

				echo "</tr>";
			}
		?>	
	  </tbody>
</table>
			 