<?php
	// header("Content-Type: application/vnd.ms-excel; name='excel'");
	// header("Content-Disposition: attachment; filename=data_roadmapdosen_$date.xls");
?>

<table class="table" border="1" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Lengkap</th>
                      <th>Jabatan Akademik</th>
                      <th>Fakultas</th>
                      <th>Prodi</th>
                      <th>Roadmap</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$n = 1;
						$sudah = '';
						foreach($dosen as $p)
						{
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							if($p->file<>'' && $p->verifikasi==1)
								$sudah = 'Sudah Unggah dan Verifikasi';
							elseif($p->file<>'' && $p->verifikasi==0)
								$sudah = 'Sudah Unggah dan Belum Verifikasi';
							else
								$sudah = 'Belum Unggah';	
							
							echo "<tr>
									  <td>".$n."</td>
									  <td>".$p->namalengkap."</td>
									  <td>".$p->jabatanakademik."</td>
									  <td>".$fakultas['fakultas']."</td><td>".$prodi['prodi']."</td>
									  <td>".$sudah."</td>
									</tr>";
							$n++;
						}
					?>	
                  </tbody>
                </table>