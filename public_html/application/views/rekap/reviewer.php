<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Reviewer</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
				<div class="row">
					<!-- <div class="col-md-8">
						<h6 class="m-0 font-weight-bold text-primary">Rekap Reviewer</h6>
					</div> -->
					<div class="col-md-12 float-right">
							<a href="<?php echo base_url().'rekap/ekspordatareviewer'; ?>" target="_blank" class="btn btn-sm btn-success shadow-sm float-right" title="Ekspor Data Reviewer" style="margin-left: 1em;color:white"><i class="fas fa-file-excel fa-sm text-white-50"></i> Ekspor Reviewer</a>
					</div>
				</div>
            </div>
            <div class="card-body">
						<form class="user" action="<?php echo base_url(); ?>rekap/reviewer" method="post" enctype="multipart/form-data">
                <div class="form-group row">
					<div class="col-sm-6">
						<label>Periode</label>
						<select name="periode" class="form-control">
							<?php
								$tahun = 2018;
								$aktif = date('Y');
								$selisih = $aktif - $tahun;
								for($i=0;$i<=$selisih;$i++)
								{
									if($this->input->post('periode')<>'' && $this->input->post('periode')==($aktif-$i))
									echo '<option value="'.($aktif-$i).'" selected>'.($aktif-$i).'</option>';
									else
									echo '<option value="'.($aktif-$i).'">'.($aktif-$i).'</option>';
								}
							?>
						</select>
					</div>
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>Fase</label>
						<select name="fase" class="form-control">
							<?php
								$fase = array('Usulan', 'Laporan');
								$j = count($fase);
								for($i=0;$i<$j;$i++)
								{
									if($this->input->post('fase')<>'' && $this->input->post('fase')==$fase[$i])
									echo '<option value="'.$fase[$i].'" selected>'.$fase[$i].'</option>';
									else
									echo '<option value="'.$fase[$i].'">'.$fase[$i].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="col-sm-6 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="submit" value="Rekap" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>
				
			</form>
            </div>
          </div>
		  <div class="card shadow mb-4">
            <!-- <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Rekap Kinerja Dosen</h6>
            </div> -->
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
														  <td style='text-align:center !important'><a href='".base_url()."rekap/detailrevriset/".$fasenya."/".$p->user."'>".$hitpenelitian."</a></td>";
												echo "<td style='text-align:center !important'><a href='".base_url()."rekap/detailrevpkm/".$fasenya."/".$p->user."'>".$hitpkm."</a></td>
														</tr>";
											}
										?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <!--</div> -->

<script>
	$(document).ready(function(){
	$("#fakultas").change(function (){
		var url = "<?php echo site_url('rekap/load_prodi');?>/"+$(this).val();
		$('#prodi').load(url);
		return false;
	});	
	});
</script>
