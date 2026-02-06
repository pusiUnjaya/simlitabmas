<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_review_usulan_penelitian_$date.xls");
?>
<h2>Rekap Review Usulan Penelitian</h2>
<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Ketua</th>
			<th>Nama Anggota Dosen</th>
			<th>Nama Anggota Mahasiswa</th>
			<th>Judul Penelitian</th>
			<th>Skema</th>
			<th>Fakultas</th>
			<th>Program Studi</th>
			<th>Tahun</th>
			<th>Nama Reviewer 1</th>
			<th>Nilai Reviewer 1</th>
			<th>Catatan Reviewer 1</th>
			<th>Nama Reviewer 2</th>
			<th>Nilai Reviewer 2</th>
			<th>Catatan Reviewer 2</th>
			<th>Nilai Rata-Rata</th>
			<th>Target Luaran</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			$review = '';
			$skor = '';
			foreach($penelitian as $p)
			{
				$total = $this->msubmit->totalrab($p->id_usulan);
				$fakultas = $this->mdosen->namafakultas($p->fakultas);
				$prodi = $this->mdosen->namaprodi($p->prodi);
				if($p->pengusul<>'')
				{
					$ketua = $this->mdosen->dosennya($p->pengusul);
					$ketua = $ketua['namalengkap'];
				}
				else
				$ketua = '';
				
				$ad = '';
				
				$ambil = explode(',',$p->anggotadosen);
				$hit = count($ambil);
				
				if($p->anggotadosen<>'') 
				{
					// $ad = '<ol>';
					for($i=0;$i<$hit;$i++)
					{
						$dosen = $this->mdosen->namadosen($ambil[$i]);
						if($hit>1)
						$ad .= ($i+1).'. ';
						
						$ad .= $dosen['namalengkap'].'<br>';
					}
					// $ad .= '</ol>';
				}
				else
				$ad = 'Tidak Ada Anggota Dosen';  
				
				echo "<tr>
				<td>".$no."</td>
				<td>".$ketua."</td>
				<td>".$ad."</td>
				<td><pre>".$p->anggotamhs."</pre></td>";
				//reviewer
				if($p->revnya<>'')
				{
					$pisah = explode(',',$p->revnya);
					$reviewer1 = $this->mdosen->namadosen($pisah[0]);
					$reviewer2 = $this->mdosen->namadosen($pisah[1]);
				
				//Nilai reviewer
					$nilai1 = $this->mrekap->nilaiusulanreviewer($p->id_usulan,$reviewer1['user']);
					
					if(empty($nilai1['skor']))
					{
						$skor =',,,,,';
						$review = explode(',',$skor);
						$nilai = 0;
					}	
					else
					{
						$skor = $nilai1['skor'];
						$review = explode(',',$skor);
						$skor1 = ((intval($review[0])*20)+(intval($review[1])*15)+(intval($review[2])*20)+(intval($review[3])*15)+(intval($review[4])*10)+(intval($review[5])*20))/4;
					}
					
					$nilai2 = $this->mrekap->nilaiusulanreviewer($p->id_usulan,$reviewer2['user']);
					if(empty($nilai2['skor']))
					{
						$skor =',,,,,';
						$review = explode(',',$skor);
						$nilai = 0;
					}	
					else
					{
						$skor = $nilai2['skor'];
						$review = explode(',',$skor);
						$skor2 = ((intval($review[0])*20)+(intval($review[1])*15)+(intval($review[2])*20)+(intval($review[3])*15)+(intval($review[4])*10)+(intval($review[5])*20))/4;
					}
				}
				
				echo "<td>".$p->judul."</td>
				<td>".$p->skema."</td>
				<td>".$fakultas['fakultas']."</td>
				<td>".$prodi['prodi']."</td>
				<td>".date('Y',strtotime($p->tglmulai))."</td>
				<td>".@$reviewer1['namalengkap']."</td>
				<td>".@number_format($skor1,2)."</td>
				<td>".@$nilai1['hasilreview']."</td>
				<td>".@$reviewer2['namalengkap']."</td>
				<td>".@number_format($skor2,2)."</td>
				<td>".@$nilai2['hasilreview']."</td>
				<td>".@number_format(($skor1+$skor2)/2,2)."</td>
				<td>".$p->luaran."</td>
				</tr>";
				$no++;
			}
		?>	
	</tbody>
</table>