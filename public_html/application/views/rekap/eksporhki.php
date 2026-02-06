<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_hki_$date.xls");
?>
	<h2>Rekap HKI</h2>
	<table class="table table-bordered" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>No</th>
		  <th>NIDN</th>
		  <th>Nama Dosen</th>
		  <th>Author Lain</th>
		  <th>Fakultas</th>
		  <th>Prodi</th>
		  <th>Judul</th>
		  <th>Tahun</th>
		  <th>Sebagai Luaran</th>
		  <th>Jenis HKI</th>
		  <th>No. Pendaftaran</th>
		  <th>Status HKI</th>
		  <th>No. HKI</th>
		  <th>URL</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			$getusulan = '';
			foreach($hkiusulan as $r)
			{
				if($r->sbgluaran=='Luaran Penelitian')
					$getusulan = $this->mrekap->getinfodosenriset($r->usulan);
				else
					$getusulan = $this->mrekap->getinfodosenpkm($r->usulan);
				
				// echo $this->db->last_query();exit;

				$hit = count($getusulan);
				if($hit>0)
				{
				$fakultas = $this->mdosen->namafakultas($getusulan['fakultas']);
				$prodi = $this->mdosen->namaprodi($getusulan['prodi']);
			
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.$getusulan['nidn'].'</td>
					<td>'.$getusulan['namalengkap'].'</td><td>';
					$ambil = explode(',',$getusulan['anggotadosen']);
					$hit = count($ambil);
					
					if($getusulan['anggotadosen']<>'') 
					{
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							echo $dosen['namalengkap'].'<br>';
						}
					}
					else
						echo 'Tidak Ada Author Lain';
				echo '</td><td>'.$fakultas['fakultas'].'</td>
						<td>'.$prodi['prodi'].'</td>
						<td>'.ucwords(strtolower($r->judul)).'</td>
						<td>'.$r->tahun_pelaksanaan.'</td>
						<td>'.$r->sbgluaran.'</td>
						<td>'.$r->jenis_hki.'</td>
						<td>'.$r->nomor_pendaftaran.'</td>
						<td>'.$r->statushki.'</td>
						<td>'.$r->nomor_hki.'</td>
						<td>'.$r->url_dokumen.'</td>
				</tr>';
				$no++;
			}
			}
			
			foreach($hki as $r)
			{
				$fakultas = $this->mdosen->namafakultas($r->fakultas);
				$prodi = $this->mdosen->namaprodi($r->prodi);
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.$r->nidn.'</td>
					<td>'.$r->namalengkap.'</td><td>';
					$ambil = explode(',',$r->authorlain);
					$hit = count($ambil);
					
					if($r->authorlain<>'') 
					{
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							echo $dosen['namalengkap'].'<br>';
						}
					}
					else
						echo 'Tidak Ada Author Lain';
				echo '</td><td>'.$fakultas['fakultas'].'</td>
					<td>'.$prodi['prodi'].'</td>
					<td>'.ucwords(strtolower($r->judul)).'</td>
					<td>'.$r->tahun_pelaksanaan.'</td>
					<td>'.$r->sbgluaran.'</td>
					<td>'.$r->jenis_hki.'</td>
					<td>'.$r->nomor_pendaftaran.'</td>
					<td>'.$r->statushki.'</td>
					<td>'.$r->nomor_hki.'</td>
					<td>'.$r->url_dokumen.'</td>
				</tr>';
				$no++;
			}
	  ?>
	  </tbody>
	</table>