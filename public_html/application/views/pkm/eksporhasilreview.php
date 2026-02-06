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
<h2>Daftar Hasil Reviewer Usulan PkM Dosen</h2>
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
					if(array_key_exists("6",$skor))
						$poin7 = $skor[6];
					else
						$poin7 = 0;
					$final = (($poin1*20)+($poin2*15)+($poin3*20)+($poin4*15)+($poin5*10)+($poin6*10)+($poin7*10))/7;
				}
				else
				{
					$poin1 = 0;
					$poin2 = 0;
					$poin3 = 0;
					$poin4 = 0;
					$poin5 = 0;
					$poin6 = 0;
					$poin7 = 0;
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
							1. Analisis Situasi (masalah yang diangkat sebagai latar belakang) : ".$poin1."<br>
							2. Kecocokan permasalahan dengan program serta kompetensi tim : ".$poin2."
							3. Solusi yang ditawarkan (Ketepatan Metode pendekatan untuk mengatasi permasalahan, Rencana kegiatan, kontribusi partisipasi tim) : ".$poin3."<br>
							4. Target Luaran (Jenis luaran dan spesifikasinya sesuai kegiatan yang diusulkan) : ".$poin4."<br>
							5. Kesesuaian dengan fokus unggulan road map unggulan program studi  : ".$poin5."<br>
							6. Pengabdian merupakan tindak lanjut dari hasil penelitian : ".$poin6."<br>
							6. Keterkaitan dengan proses pembelajaran : ".$poin7."<br>
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
			 