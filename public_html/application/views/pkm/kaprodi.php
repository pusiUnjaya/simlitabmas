<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Persetujuan Kaprodi</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
					<div class="col-md-10">
						<h6 class="m-0 font-weight-bold text-primary">Persetujuan Kaprodi</h6>
					</div>
					<div class="col-md-2 float-right">
						<form class="user" action="<?php echo base_url(); ?>pengabdian/kaprodi" method="post">
							<select name="periode" class="form-control" onchange="this.form.submit()" style="margin-top:-7px">
							<?php
								$tahun = 2018;
								$aktif = date('Y');
								$selisih = $aktif - $tahun;
								
								if($this->input->post('periode')=='')
									$pilih = date('Y');
								else
									$pilih = $this->input->post('periode');
								for($i=0;$i<=$selisih;$i++)
								{
									if($pilih==($aktif-$i))
										echo '<option value="'.($aktif-$i).'" selected>'.($aktif-$i).'</option>';
									else
										echo '<option value="'.($aktif-$i).'">'.($aktif-$i).'</option>';
								}
							?>
						</select>
						</form>
					</div>
				</div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Judul Pengabdian</th>
                      <th>Fakultas/Prodi</th>
                      <th width="15%">RAB</th>
					  <th width="25%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						if($hit>0){
						foreach($kaprodi as $p)
						{
							$namadosen = $this->mdosen->namadosen($p->pengusul);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$total = $this->mpengabdian->totalrab($p->id_usulan);
																			
							echo "<tr>
									  <td><a href='".base_url()."/pengabdian/kaprodicek/".$p->id_usulan."'>".$p->judul."</a></td>
									  <td>".$prodi['prodi']."</td>
									  <td>".rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'])."</td>";
							echo "<td>";
								echo "<a href='' class='btn btn-success btn-icon-split' data-usulan='".$p->id_usulan."' data-roadmap='".$p->roadmap."' data-multi='".$p->multi."'  data-toggle='modal' data-target='#setuju-modal' title='Usulan Disetujui'>
									<span class='icon text-white-50'>
									<i class='fas fa-check'></i>
									</span>
									<span class='text'>Persetujuan Kaprodi</span>
									</a>";
							echo "</td></tr>";
						}
						}
						else
						{
							echo '<tr><td colspan="4" align="center">Data Tidak Ditemukan...</td></tr>';
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Riwayat Persetujuan Kaprodi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Judul Penelitian</th>
                      <th>Fakultas/Prodi</th>
                      <th width="15%">RAB</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						foreach($histori as $p)
						{
							$namadosen = $this->mdosen->namadosen($p->pengusul);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$total = $this->mpengabdian->totalrab($p->id_usulan);
																			
							echo "<tr>
									  <td><a href='".base_url()."pengabdian/kaprodicek/".$p->id_usulan."'>".$p->judul."</a></td>
									  <td>".$prodi['prodi']."</td>
									  <td>".rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'])."</td>";
							echo "</tr>";
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <!--</div> -->
<!-- Modal Persetujuan -->
<div class="modal fade" id="setuju-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usulan Disetujui/Tidak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'pengabdian/setuju'; ?>" enctype="multipart/form-data">
			<div class="form-group row">
			<label for="inputEmail3" class="col-sm-8 col-form-label">Penelitian Minimal 80% Sesuai dengan Roadmap Program Studi :</label>
			<div class="col-sm-4">
			  <input type="hidden" name="usulan" id="usulan">
            <select name="sesuai" id="kesesuaian" class="form-control">
				<?php
					$jenis = array('Sesuai','Tidak Sesuai');
					
					$n = count($jenis);
					for($i=0;$i<$n;$i++)
					{
						echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
					}
				?>
			</select>
			</div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-8 col-form-label">Multi Disiplin Beda Program Studi :</label>
			<div class="col-sm-4">
            <select name="multi" id="multidisiplin" class="form-control">
				<?php
					$multi = array('Sudah','Belum');
					
					$n = count($multi);
					for($i=0;$i<$n;$i++)
					{
						echo '<option value="'.$multi[$i].'">'.$multi[$i].'</option>';
					}
				?>
			</select>
			</div>
		  </div>
		  <!--<div class="form-group row">
			<label class="col-sm-8 col-form-label">Proposal di Setujui Program Studi :</label>
			<div class="col-sm-4">
			  <select name="setuju" class="form-control">
				<?php
					// $jenis = array('Setuju','DiTolak');
					// $status = array('Usulan Disetujui Prodi','Usulan Baru');
					
					// $n = count($jenis);
					// for($i=0;$i<$n;$i++)
					// {
						// echo '<option value="'.$status[$i].'">'.$jenis[$i].'</option>';
					// }
				?>
			</select>
			</div>
		  </div>-->
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		<button type="submit" class="btn btn-success">Simpan</button>
	  </div>
	  </form>
    </div>
  </div>
</div> 
	
<script>
	$(document).ready(function() {
        $('#setuju-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#usulan').attr("value",div.data('usulan'));
            modal.find('#kesesuaian').attr("option",div.data('roadmap'));
            modal.find('#multidisiplin').attr("value",div.data('multi'));
        });
    });
</script>
