<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_prosiding_$date.xls");
?>
	<h2>Rekap Prosiding</h2>
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
		  <th>Nama Prosiding</th>
		  <th>Jenis Prosiding</th>
		  <th>Sebagai Luaran</th>
		  <th>Peran Penulis</th>
		  <th>Status</th>
		  <th>Tahun</th>
		  <th>Volume</th>
		  <th>Nomor</th>
		  <th>ISBN/ISSN</th>
		  <th>URL UNJAYA</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			foreach($prosiding as $r)
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
						<td>'.$r->nama_prosiding.'</td>
						<td>'.$r->jenis_prosiding.'</td>
						<td>'.$r->sbgluaran.'</td>
						<td>'.$r->peran_penulis.'</td>
						<td>'.$r->statuspro.'</td>
						<td>'.$r->tahun.'</td>
						<td>'.$r->volume.'</td>
						<td>'.$r->nomor.'</td>
						<td>'.$r->isbn_issn.'</td>
						<td>'.base_url().'assets/uploadbox/'.$r->file_prosiding.'</td>
				</tr>';
				$no++;
			}
	  ?>
	  </tbody>
	</table>