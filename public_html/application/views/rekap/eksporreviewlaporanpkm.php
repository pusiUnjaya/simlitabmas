<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_review_laporan_pkm_$date.xls");
?>
<h2>Rekap Review Laporan Pengabdian</h2>
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
			<th>Nama Reviewer</th>
			<th>Nilai Rata-rata</th>
			<th>Catatan Reviewer</th>
			<th>Target Luaran</th>
			<th>Realisasi Luaran</th>
			<th>Relevansi Mata Kuliah</th>
			<th>Relevansi Bentuk Integrasi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			$review = '';
			$skor = '';
			foreach($penelitian as $p)
			{
				$y = date('Y');
				if(date('Y',strtotime($p->tglmulai))<$y){
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
				$skor1=0;
				$skor2=0;
				if($p->revnya<>'')
				{
					$pisah = explode(',',$p->revnya);
					$reviewer1 = $this->mdosen->namadosen($pisah[0]);
				
				//Nilai reviewer
					$nilai1 = $this->mrekap->nilailaporanreviewerpkm($p->id_usulan,$reviewer1['user']);
					
					if($nilai1['skor']=='')
					{
						$skor =',,,,,';
						$review = explode(',',$skor);
						$nilai = 0;
					}	
					else
					{
						$skor = $nilai1['skor'];
						$review = explode(',',$skor);
						$skor1 = ((intval($review[0])*10)+(intval($review[1])*20)+(intval($review[2])*20)+(intval($review[3])*20)+(intval($review[4])*30))/7;
					}
				}
				
				//realisasi
				$real = $this->mrekap->realisasijurnalpkm($p->id_usulan);
				
				//realisasi
				$realhki = $this->mrekap->realisasihkipkm($p->id_usulan);
				
				//relevansi
				$rele = $this->mrekap->relevansipkm($p->id_usulan);
				
				echo "<td>".$p->judul."</td>
				<td>".$p->skema."</td>
				<td>".$fakultas['fakultas']."</td>
				<td>".$prodi['prodi']."</td>
				<td>".date('Y',strtotime($p->tglmulai))."</td>
				<td>".$reviewer1['namalengkap']."</td>
				<td>".number_format($skor1,2)."</td>
				<td>".$nilai1['hasilreview_laporan']."</td>
				<td>".$p->luaran."</td>
				<td>";
				if(count($real)>0)
					echo 'Jurnal : <b>'.$real['status_jurnal'].'</b>, '.$real['nama_jurnal'];
				else
					echo 'Jurnal Belum Terealisasi';
				
				echo '<br><br>';
				
				if(count($realhki)>0)
					echo 'HKI : <b>'.$realhki['status'].'</b>, '.$realhki['judul'];
				else
					echo '';
				
			echo "</td>
				<td>";
				if(count($rele)>0)
					echo $rele['matakuliah'];
			echo "</td>
				<td>";
				if(count($rele)>0)
					echo $rele['bentuk_integrasi'];
			echo "</td>
				</tr>";
				$no++;
			}
			}
		?>	
	</tbody>
</table>