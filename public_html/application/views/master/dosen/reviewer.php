<?php
	if($this->session->userdata('sesi_status')<>1)
		header('location:'.base_url());
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dosen Reviewer</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Dosen Reviewer</h6>
            </div>
			<?php
				if($this->session->flashdata('result')<>'')
				{
					echo '<div class="alert alert-success" role="alert">'.
						$this->session->flashdata('result').'
						</div>';
				}
			?>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Jabatan Akademik</th>
                      <th>Fakultas/Prodi</th>
                      <th>Reviewer</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Jabatan Akademik</th>
                      <th width="42%">Fakultas/Prodi</th>
                      <th width="15%">Reviewer</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
						foreach($dosen as $p)
						{
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							echo "<tr>
									  <td>".$p->namalengkap."</td>
									  <td>".$p->jabatanakademik."</td>
									  <td>".$fakultas['fakultas']."/".$prodi['prodi']."</td>
									  <td>";
									  if($p->reviewer==1)
										  echo "<a href='".base_url()."reviewer/unsetreviewer/".$p->id_dosen."' class='btn btn-success btn-icon-split' title='Nonaktifkan Reviewer'>
											<span class='icon text-white-50'>
											  <i class='fas fa-check'></i>
											</span>
											<span class='text'>Aktif</span>
										  </a>";
									  else
										  echo "<a href='".base_url()."reviewer/setreviewer/".$p->id_dosen."' class='btn btn-light btn-icon-split' title='Aktifkan Reviewer'>
											<span class='icon text-gray-600'>
											  <i class='fas fa-check'></i>
											</span>
											<span class='text'>Tidak Aktif</span>
										  </a>";
							echo "</td>
									</tr>";
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>