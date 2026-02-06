<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_laporan_kemajuan_pengabdian_$date.xls");
?>
<h2>Rekap Laporan Kemajuan Pengabdian</h2>
<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Ketua</th>
			<th>Nama Anggota Dosen</th>
			<th>Jumlah Anggota Mahasiswa</th>
			<th>Nama Anggota Mahasiswa</th>
			<th>Judul Penelitian</th>
			<th>Skema</th>
			<th>Fakultas</th>
			<th>Program Studi</th>
			<th>Kumpul Berkas</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			foreach($lapkemajuan as $p)
			{
				$y = date('Y');
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

				if($p->lap_kemajuan=='')
					$sudah = 'Belum Upload'; 
				else
					$sudah = 'Sudah Upload'; 

				$am = '';
				$ambil = explode(',',$p->anggotamhs);
				$hit = count($ambil);
				$hitangg = $this->mpengabdian->hitangg($p->id_usulan);
				
				if($p->anggotamhs<>'' && $hitangg==0 && $hit==1) 
				{
					$am = '<pre>'.$p->anggotamhs.'</pre>';
				}
				elseif($p->anggotamhs<>'' && $hitangg==0 && $hit>1) 
				{
					$split = explode(',',$p->anggotamhs);
					$jumsplit = count($split);
					if($jumsplit>1)
						$am = '<ol style="margin-left:-23px">';
					for($i=0;$i<$jumsplit;$i++)
					{
							$namamhs = $this->msubmit->namamhs($split[$i]);
							$prodi = $this->mdosen->namaprodi($namamhs['prodi']);
							if($jumsplit>1)
								$am .= '<li>'.$namamhs['namamhs'].' ( '.$prodi['prodi'].' )</li>';
							else
								$am .= $namamhs['namamhs'].' ( '.$prodi['prodi'].' )';
					}
					if($jumsplit>1)
						$am .= '</ol>';
				}
				elseif($p->anggotamhs=='' && $hitangg>0)
				{
					$angg = $this->msubmit->peranmhs($usulan['id_usulan'],'Pengabdian');
					$hits = count($angg);
					$am = '<ol>';
					foreach($angg as $a)
					{
						if($hits==1)
						{
							$am .= $a->namamhs;
						}
						else
						{
							$am .= '<li>'.$a->namamhs.'</li>';
						}
					}
					$am .= '</ol>';
				}
				else
					$am = 'Tidak Ada Anggota Mahasiswa'; 
				
				echo "<tr>
				<td>".$no."</td>
				<td>".$ketua."</td>
				<td>".$ad."</td>
				<td>".$p->jumlahmhs."</td>
				<td>".$am."</td>
				</td><td>".ucwords(strtolower($p->judul))."</td>
				<td>".$p->skema."</td>
				<td>".$fakultas['fakultas']."</td>
				<td>".$prodi['prodi']."</td>
				<td>".$sudah."</td>
				</tr>";
				$no++;
			}
		?>	
	</tbody>
</table>