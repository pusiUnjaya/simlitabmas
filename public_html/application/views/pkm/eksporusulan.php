<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=data_usulan_pkm_$date.xls");
?>
<style>
table {
	font: 15px Arial, sans-serif;
}
pre {
	font: 15px Arial, sans-serif;
}
</style>

<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>No</th>
		  <th>Nama Ketua</th>
		  <th>Nama Anggota Dosen</th>
		  <th>Nama Anggota Mahasiswa</th>
		  <th>Judul PkM</th>
		  <th>Skema</th>
		  <th>Total Dana</th>
		  <th>Dana Internal</th>
		  <th>Dana Mandiri</th>
		  <th>Program Studi</th>
		  <th>Fakultas</th>
		  <th>Tahun</th>
		  <th>Status</th>
		  <th>Pelaksanaan</th>
		  <th>Reviewer</th>
		  <th>File Usulan</th>
		  <th>File Revisi</th>
		  <th>File Legalisir</th>
		  <th>File Kemajuan</th>
		  <th>File Laporan</th>
		  <th>File Revisi Laporan</th>
		  <th>File Laporan Akhir</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			foreach($usulan as $p)
			{
				$total = $this->mpengabdian->totalrab($p->id_usulan);
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
						  <td><pre>".$p->anggotamhs."</pre></td>
						  <td>".$p->judul."</td>
						  <td>".$p->skema."</td>
						  <td>".rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'])."</td>
						  <td>".rupiah($p->jmldana)."</td>
						  <td>".rupiah(($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'])-$p->jmldana)."</td>
						  <td>".$prodi['prodi']."</td>
						  <td>".$fakultas['fakultas']."</td>
						  <td>".date('Y',strtotime($p->tglmulai))."</td>
						  <td>".$p->status."</td>
						  <td>Semester ".$p->semester."</td>
						  <td>";
				$sudah = $this->msubmit->direviewoleh($p->id_usulan);
				// echo $this->db->last_query();exit;	
				$n = count($sudah);
				$i = 0;
				if($n>0)
				{
					foreach($sudah as $s)
					{
						echo $s->namalengkap;
						if($i<($n-1))
							echo ' dan ';
						$i++;
					}
				}
				else
					echo '<b style="color:red">-</b>';
				echo "</td>	
						  <td>".$p->fileusulan."</td>
						  <td>".$p->filerevisi."</td>
						  <td>".$p->legalisir."</td>
						  <td>".$p->lap_kemajuan."</td>
						  <td>".$p->file_laporan."</td>
						  <td>".$p->file_revisi."</td>
						  <td>".$p->file_laporan_akhir."</td>
						</tr>";
						$no++;
			}
		?>	
	  </tbody>
</table>
			 