<?php
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=rekap_Kontrak_penelitian_$date.xls");
?>
<h2>Surat Kontrak Penelitian</h2>
<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>No</th>
			<th>NIDN Ketua</th>
			<th>Nama Ketua</th>
			<th>Judul Penelitian</th>
			<th>Skema</th>
			<th>Jumlah Dana</th>
			<th>Sumber Dana</th>
			<th>Fakultas</th>
			<th>Program Studi</th>
			<th>Tahun</th>
			<th>Surat Kontrak</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach ($penelitian as $p) {
			$filekontrak = 'surat_kontrak_pkm_' . $p->id_usulan . '.pdf';
			$total = $this->msubmit->totalrab($p->id_usulan);
			$fakultas = $this->mdosen->namafakultas($p->fakultas);
			$prodi = $this->mdosen->namaprodi($p->prodi);
			if ($p->pengusul <> '') {
				$getketua = $this->mdosen->dosennya($p->pengusul);
				$ketua = $getketua['namalengkap'];
				$nidnketua = $getketua['nidn'];
			} else
				$ketua = '';

			$ad = '';

			$nidn = array();
			$namadosen = array();

			// $hit==1?print_r($nidn):'';
			echo "<tr>
						  <td>" . $no . "</td>
						  <td>" . $nidnketua . "</td>
						  <td>" . $ketua . "</td>";
			echo "<td>" . ucwords(strtolower($p->judul)) . "</td>
						  <td>" . $p->skema . "</td>
						  <td>" . rupiah($total['bahan'] + $total['kumpul'] + $total['sewa'] + $total['analis'] + $total['lapor']) . "</td>
						  <td>" . $p->sumberdana . "</td>
						  <td>" . $fakultas['fakultas'] . "</td>
						  <td>" . $prodi['prodi'] . "</td>
						  <td>" . date('Y', strtotime($p->tglmulai)) . "</td>
						  <td>" . ($p->suratkontrak <> '' ? '<a href="' . base_url() . '/assets/uploadbox/' . $filekontrak . '">Unduh</a>' : 'Belum Dibuat') . "</td>
						</tr>";
			$no++;
		}
		?>
	</tbody>
</table>