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
				$cek = $this->mpengabdian->cekbuka($this->session->userdata('sesi_id'));
				if(!$cek && $this->session->userdata('sesi_status')<>3)
					$cek['status'] = 0;
				if($cek['status']==1) { 
			?>
			<a href="<?php echo base_url(); ?>pengabdian/tambahusulan" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Usulan</a>
			
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
				<a class="nav-link" id="insidental-tab" data-toggle="tab" href="#insidental" role="tab" aria-controls="insidental" aria-selected="false">Insidental</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" id="noninsidental-tab" data-toggle="tab" href="#noninsidental" role="tab" aria-controls="noninsidental" aria-selected="false">Noninsidental</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-md-8">
						  <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan PkM</h6>
						</div>
						<div class="col-md-4 float-right">
						<?php if($this->session->userdata('sesi_status')==1) { ?>
						  <!--<a href="<?php echo base_url().'pengabdian/eksporhasilreview'; ?>" class="btn btn-sm btn-success shadow-sm" style="color:white"><i class="fas fa-file-excel fa-sm text-white-50"></i> Review</a>-->
						  <a href="<?php echo base_url().'pengabdian/eksporusulan/'.$masa; ?>" class="btn btn-sm btn-success shadow-sm" title="Daftar Usulan" style="margin-left: 1em;color:white"><i class="fas fa-file-excel fa-sm text-white-50"></i> Ekspor Usulan</a>
						  <form class="user col-md-4 float-right" style="width:30%" action="<?php echo base_url(); ?>pengabdian" method="post">
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
								$total = $this->mpengabdian->totalrab($p->id_usulan);
								$fakultas = $this->mdosen->namafakultas($p->fakultas);
								$prodi = $this->mdosen->namaprodi($p->prodi);
							if($p->status=='Reviewed')
							{
								$sudah = "class='table-warning'";
								$set = ' - Reviewed';
							}
							elseif($p->status=='Usulan Disetujui Reviewer')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui Reviewer';
							}
							elseif($p->status=='Usulan Tidak Disetujui Reviewer')
							{
								$sudah = "class='table-danger'";
								$set = 'Usulan Tidak Disetujui Reviewer';
							}
							elseif($p->status=='Usulan Disetujui Prodi')
							{
								$sudah = "class='table-info'";
								$set = 'Usulan Disetujui Prodi';
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
										<br><b>Pelaksanaan : Semester ".$p->semester."</b>
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
									if($p->sumberdana=='Internal' && $p->jmldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->jmldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->jmldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->jmldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->jmldana<>0)
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah(($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']));
									}
									else
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
									}
										 
								echo "<br><b>Sudah direview oleh : </b>";
								$sudah = $this->mpengabdian->direviewoleh($p->id_usulan);
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
										  <td><a href='".base_url()."pengabdian/detail/".$p->id_usulan."' class='shadow-sm' title='Lihat Detail'><i class='fas fa-folder-open fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."pengabdian/rab/".$p->id_usulan."' class='shadow-sm' title='Buat RAB'><i class='fas fa-dollar-sign fa-sm'></i></a>&nbsp;&nbsp;<a href='".base_url()."pengabdian/edit/".$p->id_usulan."' class='shadow-sm' title='Edit Usulan'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
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
			  <div class="tab-pane fade" id="insidental" role="tabpanel" aria-labelledby="insidental-tab">
			  <div class="card shadow mb-3">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Skema PkM Insidental</h6>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/insidental/1" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Usulan Baru
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->mpengabdian->hitinsidentalusulanbaru();
								?>
								Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/insidental/2" style="text-decoration:none">
						<div class="card bg-gradient-primary text-white shadow">
							<div class="card-body">
								Usulan Dikirim
								<div class="text-white-50 small">Ada
								<?php
									echo $this->mpengabdian->hitinsidentalusulandikirim();
								?>
								Usulan Dikirim</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/insidental/3" style="text-decoration:none">
						<div class="card bg-gradient-success text-white shadow">
							<div class="card-body">
								Usulan Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->mpengabdian->hitinsidentalusulandisetujui();
								?>
								Usulan Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/insidental/4" style="text-decoration:none">
						<div class="card bg-gradient-danger text-white shadow">
							<div class="card-body">
								Usulan Tidak Disetujui
								<div class="text-white-50 small">Ada
								<?php
									echo $this->mpengabdian->hitinsidentalusulantidakdisetujui();
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
			  <div class="tab-pane fade" id="noninsidental" role="tabpanel" aria-labelledby="noninsidental-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Skema PkM Noninsidental</h6>
				</div>
				<div class="card-body">
				  <div class="row">
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/noninsidental/1" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Usulan Baru
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->mpengabdian->hitnoninsidentalusulanbaru();
								?>
								Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/noninsidental/2" style="text-decoration:none">
						<div class="card bg-gradient-primary text-white shadow">
							<div class="card-body">
								Usulan Dikirim
								<div class="text-white-50 small">Ada
								<?php
									echo $this->mpengabdian->hitnoninsidentalusulandikirim();
								?>
								Usulan Dikirim</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/noninsidental/3" style="text-decoration:none">
						<div class="card bg-gradient-success text-white shadow">
							<div class="card-body">
								Usulan Disetujui
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->mpengabdian->hitnoninsidentalusulandisetujui();
								?>
								Usulan Disetujui</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 mb-3">
						<a href="<?php echo base_url(); ?>pengabdian/noninsidental/4" style="text-decoration:none">
						<div class="card bg-gradient-danger text-white shadow">
							<div class="card-body">
								Usulan Tidak Disetujui
								<div class="text-white-50 small">Ada
								<?php
									echo $this->mpengabdian->hitnoninsidentalusulantidakdisetujui();
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
			window.location = "<?php echo base_url();?>pengabdian/hapus/" + id ;
		}
	})
	});
</script>