<?php
	if($this->session->userdata('sesi_user')=='')
	{
		header('location:'.base_url().'login');
	}
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Usulan Baru</h1>
            <?php
				$cek = $this->msubmit->cekbuka($this->session->userdata('sesi_id'));
				if(!$cek && $this->session->userdata('sesi_status')<>3)
					$cek['status'] = 0;
				if($cek['status']==1) { 
			?>
			<a href="<?php echo base_url(); ?>submit/tambahusulan" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Usulan</a>
			
			<?php } ?>
          </div>
		  <?php
				if($this->session->flashdata('result')<>'')
				{
					echo '<div class="alert alert-success" role="alert">'.
						$this->session->flashdata('result').'
						</div>';
				}
			?>
          <!-- DataTales Example -->
		  <ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" id="dasar-tab" data-toggle="tab" href="#dasar" role="tab" aria-controls="dasar" aria-selected="false">Dasar</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" id="terapan-tab" data-toggle="tab" href="#terapan" role="tab" aria-controls="terapan" aria-selected="false">Terapan</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" id="pengembangan-tab" data-toggle="tab" href="#pengembangan" role="tab" aria-controls="pengembangan" aria-selected="false">Pengembangan</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" id="kejuangan-tab" data-toggle="tab" href="#kejuangan" role="tab" aria-controls="kejuangan" aria-selected="false">Kejuangan</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-md-8">
						  <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan Penelitian</h6>
						</div>
						<div class="col-md-4 float-right">
						<?php if($this->session->userdata('sesi_status')==1) { ?>
						<!--<a href="<?php echo base_url().'submit/eksporhasilreview'; ?>" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-file-excel fa-sm text-white-50"></i> Review</a>-->
						  <a href="<?php echo base_url().'submit/eksporusulan/'.$this->input->post('periode'); ?>" class="btn btn-sm btn-success shadow-sm" title="Daftar Usulan"><i class="fas fa-file-excel fa-sm text-white-50"></i> Ekspor Usulan</a>
						<form class="user col-md-4 float-right" action="<?php echo base_url(); ?>submit" method="post">
							<select name="periode" class="form-control"  onchange="this.form.submit()">
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
						<?php } ?>
						</div>
				</div>
				</div>
				<div class="card-body">
				  <div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Data Usulan</th>
						  <th width="10%"></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							
							foreach($usulan as $p)
							{
								$sudah = '';
								$total = $this->msubmit->totalrab($p->id_usulan);
								$fakultas = $this->mdosen->namafakultas($p->fakultas);
								$prodi = $this->mdosen->namaprodi($p->prodi);
							if($p->status=='Reviewed')
							{
								$sudah = "class='table-warning'";
								$set = ' - Reviewed';
							}
							elseif($p->status=='Usulan Disetujui Reviewer 1')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui 1 Reviewer';
							}
							elseif($p->status=='Usulan Disetujui Reviewer 2')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui 2 Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer 1')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui 1 Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer 2')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui 2 Reviewer';
							}
							elseif($p->status=='Usulan Disetujui Prodi')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui Prodi';
							}
							elseif($p->status=='Usulan Baru' && $p->roadmap=='Tidak Sesuai')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan DiTolak dan Tidak Sesuai dengan Roadmap Program Studi';
							}
							elseif($p->status=='Usulan Disetujui Prodi' && $p->roadmap=='Sesuai')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan DiSetujui dan Sesuai dengan Roadmap Program Studi';
							}
							elseif($p->status=='Usulan Disetujui Prodi' && $p->roadmap=='Tidak Sesuai')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan DiSetujui Tapi Tidak Sesuai dengan Roadmap Program Studi';
							}
							elseif($p->status=='Usulan Tidak Disetujui')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui';
							}
							elseif($p->status=='Usulan Dikirim')
							{
								$sudah = "";
								$set = 'Usulan Dikirim';
							}
							else
							{
								$sudah = '';
								$set = 'Usulan Belum Dikirim';
							}
							
								$ketua = $this->mdosen->dosennya($p->pengusul);
								
								echo "<tr ".$sudah.">
										  <td>".$p->judul." (".date('Y',strtotime($p->tglmulai)).")";
								echo "<br><b>Status : ".$set."</b>
										  <br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
										  <br>Anggota : ";
								$pisah = explode(',',$p->anggotadosen);
								$hitpisah = count($pisah);
								if($p->anggotadosen<>'')
								{
									echo '<ol>';
									for($i=0;$i<$hitpisah;$i++)
									{
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										echo '<li>'.$revnya['namalengkap'].'</li>';
									}
									echo '</ol>';
								}
								else
								{
									echo 'Tidak Ada<br>';
								}
								echo "RAB : ";
										  $prodinya = $this->mdosen->dosennya($p->pengusul);
									if($p->sumberdana=='Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0)
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah($p->totaldana);
									}
									else
									{
										$total = $this->msubmit->totalrab($p->id_usulan);
										echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
									}
										 
								echo "<br><b>Sudah direview oleh : </b>";
								$sudah = $this->msubmit->direviewoleh($p->id_usulan);
								// echo $this->db->last_query();exit;	
								$n = count($sudah);
								$i = 0;
								if($n>0)
								{
									foreach($sudah as $s)
									{
										echo '<b style="color:green">'.$s->namalengkap.'</b>';
										if($i<($n-1))
											echo ' dan ';
										$i++;
									}
								}
								else
									echo '<b style="color:red">-</b>';
								echo "</td>
										  <td><a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/rab/".$p->id_usulan."' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."submit/edit/".$p->id_usulan."' class='shadow-sm' title='Edit Usulan'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
										  <a href='#' data-id='".$p->id_usulan."' class='shadow-sm hapus' title='Hapus Usulan'><i class='fas fa-trash fa-sm'></i></a>
										  </td>
										</tr>";
							}
						?>	
					  </tbody>
					</table>
				  </div>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade" id="dasar" role="tabpanel" aria-labelledby="dasar-tab">
			  <div class="card shadow mb-3">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Skema Penelitian Dasar</h6>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/dasar/1" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Usulan Baru
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitdasarusulanbaru();
								?>
								Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/dasar/2" style="text-decoration:none">
						<div class="card bg-gradient-primary text-white shadow">
							<div class="card-body">
								Usulan Dikirim
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitdasarusulandikirim();
								?>
								Usulan Dikirim</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/dasar/3" style="text-decoration:none">
						<div class="card bg-gradient-success text-white shadow">
							<div class="card-body">
								Usulan Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitdasarusulandisetujui();
								?>
								Usulan Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/dasar/4" style="text-decoration:none">
						<div class="card bg-gradient-danger text-white shadow">
							<div class="card-body">
								Usulan Tidak Disetujui
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitdasarusulantidakdisetujui();
								?>
								Usulan Tidak Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					</div>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade" id="terapan" role="tabpanel" aria-labelledby="terapan-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Skema Penelitian Terapan</h6>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/terapan/1" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Usulan Baru
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitterapanusulanbaru();
								?>
								Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/terapan/2" style="text-decoration:none">
						<div class="card bg-gradient-primary text-white shadow">
							<div class="card-body">
								Usulan Dikirim
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitterapanusulandikirim();
								?>
								Usulan Dikirim</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/terapan/3" style="text-decoration:none">
						<div class="card bg-gradient-success text-white shadow">
							<div class="card-body">
								Usulan Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitterapanusulandisetujui();
								?>
								Usulan Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/terapan/4" style="text-decoration:none">
						<div class="card bg-gradient-danger text-white shadow">
							<div class="card-body">
								Usulan Tidak Disetujui
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitterapanusulantidakdisetujui();
								?>
								Usulan Tidak Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					</div>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade" id="pengembangan" role="tabpanel" aria-labelledby="pengembangan-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Skema Penelitian Pengembangan</h6>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/pengembangan/1" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Usulan Baru
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitkembangusulanbaru();
								?>
								Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/pengembangan/2" style="text-decoration:none">
						<div class="card bg-gradient-primary text-white shadow">
							<div class="card-body">
								Usulan Dikirim
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitkembangusulandikirim();
								?>
								Usulan Dikirim</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/pengembangan/3" style="text-decoration:none">
						<div class="card bg-gradient-success text-white shadow">
							<div class="card-body">
								Usulan Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitkembangusulandisetujui();
								?>
								Usulan Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/pengembangan/4" style="text-decoration:none">
						<div class="card bg-gradient-danger text-white shadow">
							<div class="card-body">
								Usulan Tidak Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitkembangusulantidakdisetujui();
								?>
								Usulan Tidak Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					</div>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade" id="kejuangan" role="tabpanel" aria-labelledby="kejuangan-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Skema Penelitian Kejuangan</h6>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/kejuangan/1" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Usulan Baru
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitjuangusulanbaru();
								?>
								Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/kejuangan/2" style="text-decoration:none">
						<div class="card bg-gradient-primary text-white shadow">
							<div class="card-body">
								Usulan Dikirim
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitjuangusulandikirim();
								?>
								Usulan Dikirim</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/kejuangan/3" style="text-decoration:none">
						<div class="card bg-gradient-success text-white shadow">
							<div class="card-body">
								Usulan Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitjuangusulandisetujui();
								?>
								Usulan Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>submit/kejuangan/4" style="text-decoration:none">
						<div class="card bg-gradient-danger text-white shadow">
							<div class="card-body">
								Usulan Tidak Disetujui
								<div class="text-white-50 small">Ada
								<?php
									echo $this->msubmit->hitjuangusulantidakdisetujui();
								?>
								Usulan Tidak Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					</div>
				</div>
			</div>
			  </div>
			</div>
          
        </div>

<script>
	$(".hapus").click(function(){
    var id = $(this).data('id');
    bootbox.confirm({
	    title: "Hapus Data?",
		message: "Anda Yakin Ingin Menghapus Data Sekarang? Setelah Hapus, Data Tidak Dapat Diperbaiki.",
		closeButton: false,
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Batal'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Hapus'
			}
		},
		callback: function (result)
		{
			if(result)
			window.location = "<?php echo base_url();?>submit/hapus/" + id ;
		}
	})
	});
</script>