<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_buku_$date.xls");
?>
	<h2>Rekap Buku</h2>
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
		  <th>Penerbit</th>
		  <th>Tahun Terbit</th>
		  <th>ISSN</th>
		  <th>Jumlah Halaman</th>
		  <th>Sebagai Luaran</th>
		  <th>URL UNJAYA</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			foreach($buku as $r)
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
						<td>'.$r->judul.'</td>
						<td>'.$r->penerbit.'</td>
						<td>'.$r->tahun_terbit.'</td>
						<td>'.$r->isbn.'</td>
						<td>'.$r->jml_halaman.'</td>
						<td>'.$r->sbgluaran.'</td>
						<td>'.base_url().'assets/uploadbox/'.$r->file_buku.'</td>
				</tr>';
				$no++;
			}
	  ?>
	  </tbody>
	</table>