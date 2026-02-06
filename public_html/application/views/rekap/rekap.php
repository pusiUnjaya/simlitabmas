<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Kinerja Dosen</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Rekap Kinerja Dosen</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Judul Penelitian</th>
                      <th>Fakultas/Prodi</th>
                      <th width="15%">RAB</th>
					  <th width="6%"></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Judul Penelitian</th>
                      <th>Fakultas/Prodi</th>
					  <th width="15%">RAB</th>
                      <th width="20%"></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
						foreach($kaprodi as $p)
						{
							$namadosen = $this->mdosen->namadosen($p->pengusul);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$total = $this->msubmit->totalrab($p->id_usulan);
																			
							echo "<tr>
									  <td><a href='".base_url()."submit/kaprodicek/".$p->id_usulan."'>".$p->judul."</a></td>
									  <td>".$prodi['prodi']."</td>
									  <td>".rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'])."</td>";
							echo "<td>";
								echo "<a href='".base_url()."submit/setuju/".$p->id_usulan."' class='btn btn-success btn-icon-split' title='Usulan Disetujui'>
								<span class='icon text-white-50'>
								    <i class='fas fa-check'></i>
								</span>
								<span class='text'>Setuju</span>
								</a>
								<a href='".base_url()."submit/tolak/".$p->id_usulan."' class='btn btn-secondary btn-icon-split' title='Usulan Ditolak'>
								<span class='icon text-white-50''>
								    <i class='fas fa-times'></i>
								</span>
								<span class='text'>Tolak</span>
								</a>";
							echo "</td></tr>";
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <!--</div> -->

