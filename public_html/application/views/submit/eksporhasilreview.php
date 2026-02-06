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
		  <th>No</th>
		  <th>Nama Dosen</th>
		  <th>NIDN</th>
		  <th>Fakultas</th>
		  <th>Program Studi</th>
		  <th>Judul Usulan</th>
		  <th>Link Dokumen Usulan</th>
		  <th>Nilai per Komponen</th>
		  <th>Nilai Akhir</th>
		  <th>Isian Revisi</th>
		  <th>Link Dokumen Reviewer</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			$fakultas = '';
			$prodi = '';
			foreach($hasilreview as $p)
			{
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
				
				$skor = explode(',',$p->skor);
				$hitskor = count($skor);
				if($p->skor<>'' && $skor[0]<>'' && $hitskor>0)
				{
					$poin1 = $skor[0];
					$poin2 = $skor[1];
					$poin3 = $skor[2];
					$poin4 = $skor[3];
					$poin5 = $skor[4];
					$poin6 = $skor[5];
					$final = (($skor[0]*20)+($skor[1]*15)+($skor[2]*20)+($skor[3]*15)+($skor[4]*10)+($skor[5]*20))/7;
				}
				else
				{
					$poin1 = 0;
					$poin2 = 0;
					$poin3 = 0;
					$poin4 = 0;
					$poin5 = 0;
					$poin6 = 0;
					$final = 0;
				}
				
				if($p->usulan<>'')
					$fileusulan = 'https://simlitabmas.unjaya.ac.id/assets/uploadbox/'.$p->fileusulan;
				else
					$fileusulan = '';
				
				if($p->filereview<>'')
					$filereview = 'https://simlitabmas.unjaya.ac.id/assets/uploadbox/'.$p->filereview;
				else
					$filereview = '';
				
				
				echo "<tr>
						  <td>".$no."</td>
						  <td>".$ketua."</td>
						  <td>".$p->nidn."</td>
						  <td>".$fakultas['fakultas']."</td>
						  <td>".$prodi['prodi']."</td>
						  <td>".$p->judul."</td>
						  <td>".$fileusulan."</td>
						  <td>
							1. Perumusan Masalah : ".$poin1."
									a. Ketajaman Perumusan Masalah
									b. Tujuan Penelitian
							2. Kesesuaian dengan Renstra Penelitian Unjani Yogyakarta : ".$poin2."
							3. Metode Penelitian : ".$poin3."<br>
									Ketepatan dan kesesuaian metode yang digunakan
							4. Tinjauan Pustaka : ".$poin4."
									a. Relevansi
									b. Kemutakhiran
									c. Penyusunan Daftar Pustaka
							5. Kelayakan Penelitian : ".$poin5."
									a. Kesesuaian Waktu
									b. Kesesuaian Biaya
							6. Peluang Luaran Penelitian : ".$poin6."
									a. Publikasi Ilmiah
									b. Pengembangan iptek Sosial Budaya
									c. Pengayaan Bahan Ajar
						  </td>
						  <td>".number_format($final,4)."</td>
						  <td>".$p->hasilreview."</td>
						  <td>".$filereview."</td>
						</tr>";
						$no++;
			}
		?>	
	  </tbody>
</table>
			 