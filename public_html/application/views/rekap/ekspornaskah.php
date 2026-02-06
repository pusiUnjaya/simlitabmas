<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_naskah_$date.xls");
?>
	<h2>Rekap Naskah</h2>
	<table class="table table-bordered" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>No</th>
		  <th>NIDN</th>
		  <th>Nama Dosen</th>
		  <th>Author Lain</th>
		  <th>Fakultas</th>
		  <th>Prodi</th>
		  <th>Judul Naskah</th>
		  <th>Jenis Naskah</th>
		  <th>Tahun Naskah</th>
		  <th>Peruntukan</th>
		  <th>Peran Penyusun</th>
		  <th>Tgl Penyerahan</th>
		  <th>Pejabat Penerima</th>
		  <th>Sebagai Luaran</th>
		  <th>URL UNJAYA</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			foreach($naskah as $r)
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
						<td>'.$r->jenis_naskah.'</td>
						<td>'.$r->tahun_naskah.'</td>
						<td>'.$r->peruntukan_naskah.'</td>
						<td>'.$r->peran_penyusun.'</td>
						<td>'.$r->tgl_serah.'</td>
						<td>'.$r->pejabat_penerima.'</td>
						<td>'.$r->sbgluaran.'</td>
						<td>'.base_url().'assets/uploadbox/'.$r->dokumen.'</td>
				</tr>';
				$no++;
			}
	  ?>
	  </tbody>
	</table>