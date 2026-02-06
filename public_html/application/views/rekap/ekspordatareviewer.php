<?php
	header("Content-Type: application/vnd.ms-excel; name='excel'");
	header("Content-Disposition: attachment; filename=rekap_reviewer_$date.xls");
?>
<h2>Rekap Reviewer Tahun <?php echo $this->session->userdata('tahunfase').' - '.$this->session->userdata('fasenya');?></h2>
<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Nama Lengkap</th>
      <th width="42%">Fakultas/Prodi</th>
      <th width="15%">Penelitian</th>
      <th width="15%">Pengabdian</th>
    </tr>
  </thead>
  <tbody>
    <?php
			foreach($dosen as $p)
			{
				if($fasenya=='Usulan')
				{
					$hitpenelitian = $this->mrekap->hitrevusulanpenelitian($p->user,$thn);
					// echo $this->db->last_query();exit;
					$hitpkm = $this->mrekap->hitrevusulanpkm($p->user,$thn);
				}
				else
				{
					$hitpenelitian = $this->mrekap->hitrevlappenelitian($p->user,$thn);
					$hitpkm = $this->mrekap->hitrevlappkm($p->user,$thn);
				}

				if($p->fakultas<>'')
				{
					$fakultas = $this->mdosen->namafakultas($p->fakultas);
					$prodi = $this->mdosen->namaprodi($p->prodi);
					$dom = $fakultas['fakultas']."/".$prodi['prodi'];
				}
				else
				{
					$fakultas = 'Reviewer Eksternal';
					$prodi['prodi'] = '';
					$dom = $fakultas;
				}
												
				echo "<tr>
						  <td>".$p->namalengkap."</td>
						  <td>".$dom."</td>
						  <td style='text-align:center !important'>".$hitpenelitian."</td>";
				echo "<td style='text-align:center !important'>".$hitpkm."</td>
						</tr>";
			}
		?>	
  </tbody>
</table>