<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_pengabdian_$date.xls");
?>
	<h2>Rekap Pengabdian</h2>
	<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>No</th>
		  <th>Nama Ketua</th>
		  <th>Nama Anggota Dosen</th>
		  <th>Nama/Jumlah Mhs</th>
		  <th>Judul Pengabdian</th>
		  <th>Skema</th>
		  <th>Jumlah Dana</th>
		  <th>Sumber Dana</th>
		  <th>Fakultas</th>
		  <th>Program Studi</th>
		  <th>Tahun</th>
		  <th>File Laporan dengan Pengesahan</th>
		  <th>Jurnal</th>
		  <th>Link Jurnal</th>
		  <th>HKI</th>
		  <th>Link HKI</th>
		  <th>Prosiding</th>
		  <th>Link Prosiding</th>
		  <th>Buku</th>
		  <th>Link Buku</th>
		  <th>Relevansi MK</th>
		  <th>Bentuk Integrasi</th>
		  <th>Kerjasama</th>
		  <th>Surat Tugas</th>
		  <th>Surat Kontrak</th>
		</tr>
	  </thead>
	  <tbody>
		<?php
			$no = 1;
			foreach($pengabdian as $p)
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
				
				$unduhlaporan = '';
				$laporansah = '';
				if($p->file_revisi<>'')
					$unduhlaporan = $p->file_revisi;
				else
					$unduhlaporan = 'Belum Upload';
				
				if($p->file_laporan_akhir<>'')
					$laporansah = $p->file_laporan_akhir;
				else
					$laporansah = 'Belum Upload';

				$totaldana = count($total)>0?($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']):0;
				
				echo "<tr>
						  <td>".$no."</td>
						  <td>".$ketua."</td>
						  <td>".$ad."</td>
						  <td>".str_replace("\n", '<br>', str_replace("\r\n", '<br>', $p->anggotamhs))."</td>
						  <td>".$p->judul."</td>
						  <td>".$p->skema."</td>
						  <td>".rupiah($totaldana)."</td>
						  <td>".$p->sumberdana."</td>
						  <td>".$fakultas['fakultas']."</td>
						  <td>".$prodi['prodi']."</td>
						  <td>".date('Y',strtotime($p->tglmulai))."</td>
						  <td><a href='https://simlitabmas.unjaya.ac.id/assets/uploadbox/".$laporansah."' target='_blank'> ".$laporansah."</a></td>";
						
						$jurnal = $p->status_jurnal==''?'Tidak Ada':$p->status_jurnal;
				$linkjurnal = $p->file_jurnal==''?'Tidak Ada':base_url()."assets/uploadbox/".$p->file_jurnal;
				$hki = $p->statushki==''?'Tidak Ada':$p->statushki;
				$linkhki = $p->file_hki==''?'Tidak Ada':base_url()."assets/uploadbox/".$p->file_hki;
				$pros = $p->statuspro==''?'Tidak Ada':$p->statuspro;
				$linkpros = $p->file_prosiding==''?'Tidak Ada':base_url()."assets/uploadbox/".$p->file_prosiding;
				$buku = $p->isbn==''?'Tidak Ada':$p->isbn;
				$linkbuku = $p->file_buku==''?'Tidak Ada':base_url()."assets/uploadbox/".$p->file_buku;
				$relmk = $p->matakuliah==''?'Tidak Ada':$p->matakuliah;
				$integrasi = $p->bentuk_integrasi==''?'Tidak Ada':$p->bentuk_integrasi;

						echo "<td>".$jurnal."</td>
							<td>".$linkjurnal."</td>
							<td>".$hki."</td>
							<td>".$linkhki."</td>
							<td>".$pros."</td>
							<td>".$linkpros."</td>
							<td>".$buku."</td>
							<td>".$linkbuku."</td>
							<td>".$relmk."</td>
							<td>".$integrasi."</td>
							<td>".$p->nomorkerjasama."</td>
							<td><a href='".base_url()."surat/tugaspkm/".$p->id_usulan."'>".$p->nomortugas."</a></td>
					<td><a href='".base_url()."assets/uploadbox/".$p->suratkontrak."'>".$p->nomorkontrak."</a></td>
						</tr>";
						$no++;
			}
			
			foreach($tambahan as $p)
			{
				$total = $p->dana;
				$fakultas = $this->mdosen->namafakultas($p->fakultas);
				$prodi = $this->mdosen->namaprodi($p->prodi);
				if($p->ketua<>'')
				{
					$ketua = $this->mdosen->namadosenprodi($p->ketua);
					$ketua = $ketua['namalengkap'];
				}
				else
					$ketua = '';
				
				$ad = '';
				
				$ambil = explode(',',$p->anggota);
				$hit = count($ambil);
				
				if($p->anggota<>'') 
				{
					// $ad = '<ol>';
					for($i=0;$i<$hit;$i++)
					{
						$dosen = $this->mdosen->namadosenprodi($ambil[$i]);
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
						  <td><pre>".$p->mhs."</pre></td>
						  <td>".$p->judul."</td>
						  <td>".$p->jenis."</td>
						  <td>".rupiah($p->dana)."</td>
						  <td>".$p->sumberdana."</td>
						  <td>".$fakultas['fakultas']."</td>
						  <td>".$prodi['prodi']."</td>
						  <td>".date('Y',strtotime($p->tglmulai))."</td>
						  <td><a href='https://simlitabmas.unjaya.ac.id/assets/uploadbox/".$p->filelaporan."' target='_blank'>".$p->filelaporan."</a></td>
						</tr>";
						$no++;
			}
		?>	
	  </tbody>
</table>