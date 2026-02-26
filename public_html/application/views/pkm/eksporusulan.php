<?php
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=data_usulan_pkm_$date.xls");
?>
<style>
	table {
		font: 15px Arial, sans-serif;
	}

	pre {
		font: 15px Arial, sans-serif;
	}
</style>

<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Ketua</th>
			<th>Nama Anggota Dosen</th>
			<th>Nama Anggota Mahasiswa</th>
			<th>Judul PkM</th>
			<th>Skema</th>
			<th>Total Dana</th>
			<th>Dana Internal</th>
			<th>Dana Mandiri</th>
			<th>Program Studi</th>
			<th>Fakultas</th>
			<th>Tahun</th>
			<th>Status</th>
			<th>Pelaksanaan</th>
			<th>Reviewer</th>
			<th>File Usulan</th>
			<th>File Revisi</th>
			<th>File Legalisir</th>
			<th>File Kemajuan</th>
			<th>File Laporan</th>
			<th>File Revisi Laporan</th>
			<th>File Laporan Akhir</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach ($usulan as $p) {
			$total = $this->mpengabdian->totalrab($p->id_usulan);
			// Antisipasi error jika $total null atau key tidak ada
			$total_bahan = isset($total['bahan']) ? $total['bahan'] : 0;
			$total_kumpul = isset($total['kumpul']) ? $total['kumpul'] : 0;
			$total_sewa = isset($total['sewa']) ? $total['sewa'] : 0;
			$total_analis = isset($total['analis']) ? $total['analis'] : 0;
			$total_lapor = isset($total['lapor']) ? $total['lapor'] : 0;
			$fakultas = $this->mdosen->namafakultas($p->fakultas);
			$prodi = $this->mdosen->namaprodi($p->prodi);
			if ($p->pengusul <> '') {
				$ketua = $this->mdosen->dosennya($p->pengusul);
				$ketua = $ketua['namalengkap'];
			} else
				$ketua = '';

			$ad = '';
			$adl = '';
			$adm = '';

			$ambil = explode(',', $p->anggotadosen);
			$hit = count($ambil);

			if ((count($p->anggota)) > 0) {
				$anggota = $p->anggota;
				foreach ($anggota as $a) {
					$jenis_anggota = $a->jenis_anggota;
					if ($jenis_anggota == 'Dosen') {
						$nmdosen = $this->mdosen->namadosen($a->anggota);
						if ((count($nmdosen)) > 0 && array_key_exists('namalengkap', $nmdosen)) {
							$ad .= '- ' . $nmdosen['namalengkap'] . '<br>';
						}
					} else if ($jenis_anggota == 'Mahasiswa') {
						$nmmhs = $this->msubmit->allnamamhsfromnpm($a->anggota);
						if ((count($nmmhs)) > 0 && array_key_exists('namamhs', $nmmhs)) {
							$adm .= '- ' . $nmmhs['namamhs'] . ' * ' . $nmmhs['prodi'] . '<br>';
						}
					} else if ($jenis_anggota == 'Dosen Luar') {

						$nmdosenluar = $this->mdosenluar->namadosenluar($a->anggota);

						if ((count($nmdosenluar)) > 0 && array_key_exists('namalengkap', $nmdosenluar)) {
							$adl .= '- [' . $nmdosenluar['kode_negara'] . '] ' . $nmdosenluar['namalengkap'] . ' dari ' . $nmdosenluar['namadepartmen'] . ', ' . $nmdosenluar['namainstitusi'] . ' ' . $nmdosenluar['negara_institusi'] . '<br>';
						}
					}
				}
			} else {
				if ($p->anggotadosen <> '') {
					// $ad = '<ol>';
					for ($i = 0; $i < $hit; $i++) {
						$dosen = $this->mdosen->namadosen($ambil[$i]);
						if ($hit > 1)
							$ad .= ($i + 1) . '. ';

						$ad .= $dosen['namalengkap'] . '<br>';
					}
					// $ad .= '</ol>';
				} else
					$ad = 'Tidak Ada Anggota Dosen';
			}

			if ($adm == '') {
				if ($p->anggotamhs <> '') {
					$arr_angg = explode(',', $p->anggotamhs);
					foreach ($arr_angg as $angg) {
						$namamhs = $this->msubmit->namamhs($angg);
						$prodi = $this->mdosen->namaprodi($namamhs['prodi']);

						$adm .= '- ' . $namamhs['namamhs'] . ' * ' . $prodi['prodi'] . '<br>';
					}
				} else {
					$adm = 'Tidak Ada Anggota Mahasiswa';
				}
			}
			echo "<tr>
						  <td>" . $no . "</td>
						  <td>" . $ketua . "</td>
						  <td>" . $ad . "</td>
						  <td>" . $adm . "</td>
						  <td>" . $p->judul . "</td>
						  <td>" . $p->skema . "</td>
						  <td>" . rupiah($total_bahan + $total_kumpul + $total_sewa + $total_analis + $total_lapor) . "</td>
						  <td>" . rupiah($p->jmldana) . "</td>
						  <td>" . rupiah(($total_bahan + $total_kumpul + $total_sewa + $total_analis + $total_lapor) - $p->jmldana) . "</td>
						  <td>" . $prodi['prodi'] . "</td>
						  <td>" . $fakultas['fakultas'] . "</td>
						  <td>" . date('Y', strtotime($p->tglmulai)) . "</td>
						  <td>" . $p->status . "</td>
						  <td>Semester " . $p->semester . "</td>
						  <td>";
			$sudah = $this->msubmit->direviewoleh($p->id_usulan);
			// echo $this->db->last_query();exit;	
			$n = count($sudah);
			$i = 0;
			if ($n > 0) {
				foreach ($sudah as $s) {
					echo $s->namalengkap;
					if ($i < ($n - 1))
						echo ' dan ';
					$i++;
				}
			} else
				echo '<b style="color:red">-</b>';
			echo "</td>
						  <td>" . ($p->fileusulan <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->fileusulan) . '" target="_blank">' . $p->fileusulan . '</a>' : '-') . "</td>
						  <td>" . ($p->filerevisi <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->filerevisi) . '" target="_blank">' . $p->filerevisi . '</a>' : '-') . "</td>
						  <td>" . ($p->legalisir <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->legalisir) . '" target="_blank">' . $p->legalisir . '</a>' : '-') . "</td>
						  <td>" . ($p->lap_kemajuan <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->lap_kemajuan) . '" target="_blank">' . $p->lap_kemajuan . '</a>' : '-') . "</td>
						  <td>" . ($p->file_laporan <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->file_laporan) . '" target="_blank">' . $p->file_laporan . '</a>' : '-') . "</td>
						  <td>" . ($p->file_revisi <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->file_revisi) . '" target="_blank">' . $p->file_revisi . '</a>' : '-') . "</td>
						  <td>" . ($p->file_laporan_akhir <> '' ? '<a href="' . base_url('assets/uploadbox/' . $p->file_laporan_akhir) . '" target="_blank">' . $p->file_laporan_akhir . '</a>' : '-') . "</td>
						</tr>";
			$no++;
		}
		?>
	</tbody>
</table>