<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_penelitian_$date.xls");
?>
	<h2>Rekap Penelitian</h2>
	<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	  <thead>
		<tr>
		  <th>No</th>
		  <th>NIDN Ketua</th>
		  <th>Nama Ketua</th>
		  <th>NIDN Anggota Dosen 1</th>
		  <th>Nama Anggota Dosen 1</th>
		  <th>Prodi Anggota Dosen 1</th>
		  <th>NIDN Anggota Dosen 2</th>
		  <th>Nama Anggota Dosen 2</th>
		  <th>Prodi Anggota Dosen 2</th>
		  <th>Nama Anggota Mahasiswa</th>
		  <th>Judul Penelitian</th>
		  <th>Skema</th>
		  <th>Jumlah Dana Internal</th>
		  <th>Jumlah Dana Eksternal</th>
		  <th>Jumlah Dana Mandiri</th>
		  <th>Sumber Dana</th>
		  <th>Fakultas</th>
		  <th>Program Studi</th>
		  <th>Tahun</th>
		  <th>File Laporan</th>
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
			foreach($penelitian as $p)
			{
				$total = $this->msubmit->totalrab($p->id_usulan);
				$fakultas = $this->mdosen->namafakultas($p->fakultas);
				$prodi = $this->mdosen->namaprodi($p->prodi);
				if($p->pengusul<>'')
				{
					$getketua = $this->mdosen->dosennya($p->pengusul);
					$ketua = $getketua['namalengkap'];
					$nidnketua = $getketua['nidn'];
				}
				else
					$ketua = '';
				
				$ad = '';
				
				$ambil = explode(',',$p->anggotadosen);
				$hit = count($ambil);
				$nidn = array();
				$namadosen = array();
				$getprodi = array();
				
				if($p->anggotadosen<>'') 
				{
					// $ad = '<ol>';
					for($i=0;$i<$hit;$i++)
					{
						$dosen = $this->mdosen->namadosen($ambil[$i]);
						if($hit>1)
							$ad .= ($i+1).'. ';
					
						$ad .= $dosen['namalengkap'].'<br>';
						array_push($nidn,$dosen['nidn']);
						array_push($namadosen,$dosen['namalengkap']);
						$namaprodi = $this->mdosen->namaprodi($dosen['prodi']);
						array_push($getprodi,isset($namaprodi['prodi'])?$namaprodi['prodi']:'');
					}
					// $ad .= '</ol>';
				}
				else
					$ad = 'Tidak Ada Anggota Dosen';  
				
				// $hit==1?print_r($nidn):'';
				echo "<tr>
						  <td>".$no."</td>
						  <td>".$nidnketua."</td>
						  <td>".$ketua."</td>";
				if($p->anggotadosen<>'' && $hit==1)
				{
					echo "<td>".$nidn[0]."</td>";
					echo "<td>".$namadosen[0]."</td>";
					echo "<td>".$getprodi[0]."</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
				}
				elseif($p->anggotadosen<>'' && $hit==2)
				{
					echo "<td>".$nidn[0]."</td>";
					echo "<td>".$namadosen[0]."</td>";
					echo "<td>".$getprodi[0]."</td>";
					echo "<td>".$nidn[1]."</td>";
					echo "<td>".$namadosen[1]."</td>";
					echo "<td>".$getprodi[1]."</td>";
				}
				else
				{
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
				}

				// echo "<td><si><t>".str_replace("\n", '<br>', str_replace("\r\n", '<br>', $p->anggotamhs))."<t></si></td>";
				echo "<td>";
				$ambil = explode(',',$p->anggotamhs);
				$hit = count($ambil);
				$uppercase = preg_match('@[A-Z]@', $p->anggotamhs);
				$lowercase = preg_match('@[a-z]@', $p->anggotamhs);
				$number    = preg_match('@[0-9]@', $p->anggotamhs);
				$hitangg = $this->msubmit->hitangg($p->id_usulan);
				
				if($p->anggotamhs<>'' && $hitangg==0 && ($uppercase || $lowercase)) 
				{
					echo '<pre>'.$p->anggotamhs.'</pre>';
				}
				elseif($p->anggotamhs<>'' && $hitangg==0 && $number) 
				{
					$split = explode(',',$p->anggotamhs);
					$jumsplit = count($split);
					if($jumsplit>1)
						echo '<ol style="margin-left:-23px">';
					for($i=0;$i<$jumsplit;$i++)
					{
							$namamhs = $this->msubmit->namamhs($split[$i]);
							if(count($namamhs)>0)
							{
								$prodi = $this->mdosen->namaprodi($namamhs['prodi']);
								if($jumsplit>1)
									echo '<li>'.$namamhs['namamhs'].' ( '.$prodi['prodi'].' )</li>';
								else
									echo $namamhs['namamhs'].' ( '.$prodi['prodi'].' )';
							}
							else
								echo '<pre>'.$p->anggotamhs.'</pre>';
					}
					if($jumsplit>1)
						echo '</ol>';
				}
				elseif($p->anggotamhs=='' && $hitangg>0)
				{
					$angg = $this->msubmit->peranmhs($p->id_usulan,'Penelitian');
					$hits = count($angg);
					echo '<ol>';
					foreach($angg as $a)
					{
						if($hits==1)
						{
							echo $a->namamhs.'<br>';
							echo 'Peran : '.$a->tugas;
						}
						else
						{
							echo '<li>'.$a->namamhs.'<br>Peran : '.$a->tugas.'</li>';
						}
					}
					echo '</ol>';
				}
				else
					echo 'Tidak Ada Anggota Mahasiswa'; 

				if($total=='')
					$tot = 0;
				else
					$tot = $total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'];
				echo 	"</td><td>".ucwords(strtolower($p->judul))."</td>
						  <td>".$p->skema."</td>
						  <td>".rupiah($p->jmldana)."</td>
						  <td>".rupiah($p->danaeks)."</td>
						  <td>".rupiah($p->danamandiri)."</td>
						  <td>".$p->sumberdana."</td>
						  <td>".$fakultas['fakultas']."</td>
						  <td>".$prodi['prodi']."</td>
						  <td>".date('Y',strtotime($p->tglmulai))."</td>
						  <td><a href='https://simlitabmas.unjaya.ac.id/assets/uploadbox/".$p->file_laporan_akhir."' target='_blank'>".$p->file_laporan_akhir."</a></td>";

				// $luaran = $this->mrekap->luaranriset($p->id_usulan);
				// echo $this->db->last_query();exit();

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
					<td><a href='".base_url()."surat/tugaspenelitian/".$p->id_usulan."'>".$p->nomortugas."</a></td>
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
					$nidnketua = $ketua['nidn'];
					$ketua = $ketua['namalengkap'];
				}
				else
					$ketua = '';
				
				$ad = '';
				
				$ambil = explode(',',$p->anggota);
				$hit = count($ambil);
				$nidn = array();
				$namadosen = array();
				$getprodi = array();
				
				if($p->anggota<>'') 
				{
					// $ad = '<ol>';
					for($i=0;$i<$hit;$i++)
					{
						$dosen = $this->mdosen->namadosenprodi($ambil[$i]);
						if($hit>1)
							$ad .= ($i+1).'. ';
					
						$ad .= $dosen['namalengkap'].'<br>';
						array_push($nidn,$dosen['nidn']);
						array_push($namadosen,$dosen['namalengkap']);
						$namaprodi = $this->mdosen->namaprodi($dosen['prodi']);
						array_push($getprodi,$namaprodi['prodi']);
					}
					// $ad .= '</ol>';
				}
				else
					$ad = 'Tidak Ada Anggota Dosen';  
				
				echo "<tr>
						  <td>".$no."</td>
						  <td>".$nidnketua."</td>
						  <td>".$ketua."</td>";
				if($p->anggota<>'' && $hit==1)
				{
					echo "<td>".$nidn[0]."</td>";
					echo "<td>".$namadosen[0]."</td>";
					echo "<td>".$getprodi[0]."</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
				}
				elseif($p->anggota<>'' && $hit==2)
				{
					echo "<td>".$nidn[0]."</td>";
					echo "<td>".$namadosen[0]."</td>";
					echo "<td>".$getprodi[0]."</td>";
					echo "<td>".$nidn[1]."</td>";
					echo "<td>".$namadosen[1]."</td>";
					echo "<td>".$getprodi[1]."</td>";
				}
				else
				{
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
					echo "<td>Tidak Ada</td>";
				}
				echo "<td>-</td>
						  <td>".ucwords(strtolower($p->judul))."</td>
						  <td>".$p->jenis."</td>
						  <td>".rupiah($total)."</td>
						  <td>".$p->sumberdana."</td>
						  <td>".$fakultas['fakultas']."</td>
						  <td>".$prodi['prodi']."</td>
						  <td>".$p->tahun."</td>
						  <td><a href='https://simlitabmas.unjaya.ac.id/assets/uploadbox/".$p->file_laporan_akhir."' target='_blank'>".$p->file_laporan_akhir."</a></td>
						</tr>";
						$no++;
			}
		?>	
	  </tbody>
</table>