<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Kinerja Dosen - HKI</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
				<div class="row">
					<div class="col-md-8">
						<h6 class="m-0 font-weight-bold text-primary">Rekap Kinerja Dosen - HKI</h6>
					</div>
					<div class="col-md-4 float-right">
					<?php if($this->session->userdata('sesi_status')==1) { ?>
						<a href="<?php echo base_url().'rekap/eksporhki/semua'; ?>" class="btn btn-sm btn-success shadow-sm" title="Daftar Usulan" style="margin-left: 1em;color:white"><i class="fas fa-file-excel fa-sm text-white-50"></i> Ekspor Semua HKI</a>&nbsp;
					<?php if($this->input->post('periode')<>'') { ?>
						<a href="<?php echo base_url().'rekap/eksporhki/'.$this->input->post('periode').'/'.$this->input->post('prodi').'/'.urldecode($this->input->post('sebagai')); ?>" class="btn btn-sm btn-success shadow-sm" title="Daftar Usulan" style="margin-left: 1em;color:white"><i class="fas fa-file-excel fa-sm text-white-50"></i> Ekspor HKI</a>
					<?php }} ?>
					</div>
				</div>
            </div>
            <div class="card-body">
				<form class="user" action="<?php echo base_url(); ?>rekap/hki" method="post" enctype="multipart/form-data">
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
					<label>Sebagai Luaran</label>
					<select name="sebagai" class="form-control">
						<option value="">-- Pilih --</option>
						<?php
							$jenis = array('Luaran Penelitian','Luaran PkM','Luaran Pengajaran');
							$n = count($jenis);
							if(empty($this->input->post('sebagai')))
								$luaran = 'Luaran Penelitian';
							else
								$luaran = $this->input->post('sebagai');
							for($i=0;$i<$n;$i++)
							{
								if($luaran==$jenis[$i])
									echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
								else
									echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
						?>
					</select>
                  </div>
                <?php if($this->session->userdata('sesi_status')==1) { ?>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Program Studi</label>
					<select name="prodi" id="prodi" class="form-control" required>
						<option value="">-- Pilih --</option>
						<?php
							if($this->input->post('prodi')=='Semua' || $this->input->post('prodi')=='')
								echo '<option value="Semua" selected>Semua Program Studi</option>';
								else
								echo '<option value="Semua">Semua Program Studi</option>';
							foreach($prodi as $p)
							{
								if($this->input->post('prodi')<>'' && $this->input->post('prodi')==$p->id_prodi)
									echo '<option value="'.$p->id_prodi.'" selected>'.$p->prodi.'</option>';
								else
									echo '<option value="'.$p->id_prodi.'">'.$p->prodi.'</option>';
							}
						?>
					</select>
					<?php 
						} 
						else
						{
							echo '<div class="col-sm-6 mb-3 mb-sm-0">
								<label>Program Studi</label>
								<select name="prodi" id="prodi" class="form-control" required>';
							foreach($prodi as $p)
							{
								if($this->session->userdata('sesi_prodi')==$p->id_prodi)
								{
									$getprodi = '<option value="'.$p->id_prodi.'" selected>'.$p->prodi.'</option>';
								}
							}
							echo $getprodi;
							echo '</select>';
						}
					?>
                  </div>
				  </div>
				<div class="col-sm-6 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="submit" value="Rekap" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>
            
              </form>
            </div>
          </div>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Rekap Kinerja Dosen</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Dosen</th>
                      <th>Judul</th>
                      <th width="15%">HKI</th>
					  <th width="12%">Berkas HKI</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Dosen</th>
                      <th>Judul</th>
                      <th width="15%">HKI</th>
                      <th width="12%">Berkas HKI</th>
                    </tr>
                  </tfoot>
                  <tbody>
						<?php
					
						$no = 1;
						foreach($rekaphki as $r)
						{
							if($r->sbgluaran=='Luaran Penelitian')
								$getusulan = $this->mrekap->getinfodosenriset($r->usulan);
							else
								$getusulan = $this->mrekap->getinfodosenpkm($r->usulan);
							$hit = count($getusulan);
							if($hit>0)
							{
							echo '<tr>
								<td>'.$no.'</td>
								<td>'.$getusulan['namalengkap'].'</td>
								<td>'.ucwords(strtolower($r->judul)).'
								<br>Sebagai Luaran : '.$r->sbgluaran.'
								</td>
								<td>';
								echo 'Jenis : '.$r->jenis_hki;
								echo '<br>Status : '.$r->statushki;
								echo '<br>No : '.$r->nomor_hki;
							echo '</td>
								<td><a href="'.base_url().'assets/uploadbox/'.$r->file_hki.'" target="_blank" class="shadow-sm" title="Download File"><i class="fas fa-file-pdf" style="font-size:48px;color:red"></i></a></td>
							</tr>';
							$no++;
						}
						}
						
						foreach($rekapan as $r)
						{
							echo '<tr>
								<td>'.$no.'</td>
								<td>'.$r->namalengkap.'</td>
								<td>'.ucwords(strtolower($r->judul)).'
								<br>Sebagai Luaran : '.$r->sbgluaran.'
								</td>
								<td>';
								echo 'Jenis : '.$r->jenis_hki;
								echo '<br>Status : '.$r->statushki;
								echo '<br>No : '.$r->nomor_hki;
							echo '</td>
								<td><a href="'.base_url().'assets/uploadbox/'.$r->file_hki.'" target="_blank" class="shadow-sm" title="Download File"><i class="fas fa-file-pdf" style="font-size:48px;color:red"></i></a></td>
							</tr>';
							$no++;
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
