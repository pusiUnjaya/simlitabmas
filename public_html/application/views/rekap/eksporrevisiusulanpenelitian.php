<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_revisi_usulan_penelitian_$date.xls");
?>
<h2>Rekap Revisi Usulan Penelitian</h2>
<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Ketua</th>
			<th>Judul Penelitian</th>
			<th>Skema</th>
			<th>Fakultas</th>
			<th>Program Studi</th>
			<th>Tahun</th>
			<th>Unggah Revisi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 1;
			$review = '';
			$skor = '';
			foreach($penelitian as $p)
			{
				$total = $this->msubmit->totalrab($p->id_usulan);
				$fakultas = $this->mdosen->namafakultas($p->fakultas);
				$prodi = $this->mdosen->namaprodi($p->prodi);
				if($p->pengusul<>'')
				{
					$ketua = $this->mdosen->dosennya($p->pengusul);
					$ketua = $ketua['namalengkap'];
				}
				else
				$ketua = '';
				
				echo "<tr>
				<td>".$no."</td>
				<td>".$ketua."</td>";
				echo "<td>".ucwords(strtolower($p->judul))."</td>
				<td>".$p->skema."</td>
				<td>".$fakultas['fakultas']."</td>
				<td>".$prodi['prodi']."</td>
				<td>".date('Y',strtotime($p->tglmulai))."</td>
				<td>".($p->filerevisi<>''?'Sudah':'Belum')."</td>
				</tr>";
				$no++;
			}
		?>	
	</tbody>
</table>