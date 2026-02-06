<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_jurnal_$date.xls");
?>
	<h2>Rekap Jurnal</h2>
	<table class="table table-bordered" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>No</th>
		  <th>Judul</th>
		  <th>Ketua</th>
		  <th>Anggota</th>
		  <th>Fakultas</th>
		  <th>Prodi</th>
		  <th>Jurnal</th>
		  <th>Status</th>
		  <th>Peran Penulis</th>
		  <th>Jenis Publikasi</th>
		  <th>Sebagai Luaran</th>
		  <th>Tahun Publikasi</th>
		  <th>Volume</th>
		  <th>Nomor</th>
		  <th>ISSN</th>
		  <th>Hal. Awal</th>
		  <th>Hal. Akhir</th>
		  <th>URL Jurnal</th>
		  <th>URL Dokumen</th>
		  <th>Status Verifikasi</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			foreach($jurnalriset as $r)
			{
				$fakultas = $this->mdosen->namafakultas($r->fakultas);
				$prodi = $this->mdosen->namaprodi($r->prodi);
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.ucwords(strtolower($r->juduljurnal)).'</td>
					<td>';
				$ketua = $this->mdosen->dosennya($r->pengusul);
					echo $ketua['namalengkap'].'</td><td>';
				$ambil = explode(',',$r->anggotadosen);
					$hit = count($ambil);
					
					if($r->anggotadosen<>'') 
					{
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							echo $dosen['namalengkap'].'<br>';
						}
					}
					else
						echo 'Tidak Ada Anggota Dosen'; 
				echo '</td>
					<td>'.$fakultas['fakultas'].'</td>
					<td>'.$prodi['prodi'].'</td>
					<td>'.$r->nama_jurnal.'</td>
					<td>'.$r->status_jurnal.'</td>
					<td>'.$r->peran_penulis.'</td>
					<td>'.$r->jenis_publikasi.'</td>
					<td>'.$r->sbgluaran.'</td>
					<td>'.$r->tahun_publikasi.'</td>
					<td>'.$r->volume.'</td>
					<td>'.$r->nomor.'</td>
					<td>'.$r->issn.'</td>
					<td>'.$r->hal_awal.'</td>
					<td>'.$r->hal_akhir.'</td>
					<td>'.$r->url.'</td>
					<td>'.base_url().'assets/uploadbox/'.$r->file_jurnal.'</td>
					<td>'.($r->validasi==0?'Belum diverifikasi':'SUdah diverifikasi').'</td>
				</tr>';
				$no++;
			}

			foreach($jurnalpkm as $r)
			{
				$fakultas = $this->mdosen->namafakultas($r->fakultas);
				$prodi = $this->mdosen->namaprodi($r->prodi);
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.ucwords(strtolower($r->juduljurnal)).'</td>
					<td>';
				$ketua = $this->mdosen->dosennya($r->pengusul);
					echo $ketua['namalengkap'].'</td><td>';
				$ambil = explode(',',$r->anggotadosen);
					$hit = count($ambil);
					
					if($r->anggotadosen<>'') 
					{
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							echo $dosen['namalengkap'].'<br>';
						}
					}
					else
						echo 'Tidak Ada Anggota Dosen'; 
				echo '</td>
					<td>'.$fakultas['fakultas'].'</td>
					<td>'.$prodi['prodi'].'</td>
					<td>'.$r->nama_jurnal.'</td>
					<td>'.$r->status_jurnal.'</td>
					<td>'.$r->peran_penulis.'</td>
					<td>'.$r->jenis_publikasi.'</td>
					<td>'.$r->sbgluaran.'</td>
					<td>'.$r->tahun_publikasi.'</td>
					<td>'.$r->volume.'</td>
					<td>'.$r->nomor.'</td>
					<td>'.$r->issn.'</td>
					<td>'.$r->hal_awal.'</td>
					<td>'.$r->hal_akhir.'</td>
					<td>'.$r->url.'</td>
					<td>'.base_url().'assets/uploadbox/'.$r->file_jurnal.'</td>
					<td>'.($r->validasi==0?'Belum divalidasi':'SUdah divalidasi').'</td>
				</tr>';
				$no++;
			}
			
			foreach($jurnal as $r)
			{
				if($r->fakultas<>'')
				{
					$fak = $this->mdosen->namafakultas($r->fakultas);
					$fakultas = $fak['fakultas'];
					$pro = $this->mdosen->namaprodi($r->prodi);
					$prodi = $pro['prodi'];
				}
				else
				{
					$fakultas = '';
					$prodi = '';
				}
				echo '<tr>
					<td>'.$no.'</td>
					<td>'.ucwords(strtolower($r->judul)).'</td>
					<td>';
				$ketua = $this->mdosen->dosennya($r->user);
					echo $ketua['namalengkap'].'</td><td>';
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
						echo 'Tidak Ada Anggota Dosen'; 
				echo '</td>
					<td>'.$fakultas.'</td>
					<td>'.$prodi.'</td>
					<td>'.$r->nama_jurnal.'</td>
					<td>'.$r->status_jurnal.'</td>
					<td>'.$r->peran_penulis.'</td>
					<td>'.$r->jenis_publikasi.'</td>
					<td>'.$r->sbgluaran.'</td>
					<td>'.$r->tahun_publikasi.'</td>
					<td>'.$r->volume.'</td>
					<td>'.$r->nomor.'</td>
					<td>'.$r->issn.'</td>
					<td>'.$r->hal_awal.'</td>
					<td>'.$r->hal_akhir.'</td>
					<td>'.base_url().'assets/uploadbox/'.$r->file_jurnal.'</td>
					<td></td>
					<td>'.($r->validasi==0?'Belum divalidasi':'SUdah divalidasi').'</td>
				</tr>';
				$no++;
			}
	  ?>
	  </tbody>
	</table>