<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>
		  
			<?php
				if($this->session->flashdata('result')<>'')
				{
					echo '<div class="alert alert-danger" role="alert">'.
						$this->session->flashdata('result').'
						</div>';
				}
			?>

          <!-- Content Row -->

          <div class="row">

            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">LPPM Unjani Yogyakarta</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <img width="300" src="<?php echo base_url(); ?>assets/img/lppm_transp.png">
                  </div>
                </div>
              </div>
            </div>
			<!-- Project Card Example -->
			<?php if($this->session->userdata('sesi_status')==2) { ?>
			<div class="col-lg-8">
			  <!-- Basic Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Notifikasi</h6>
                </div>
                <div class="card-body">
					<div class="row">
					<div class="col-lg-4 mb-4">
						<a href="<?php echo base_url(); ?>pengguna" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Verifikasi Akun
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->mdosen->hitakunbaru();
								?>
								Pengguna Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-4 mb-4">
						<a href="<?php echo base_url(); ?>dashboard/verifikasi/2" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Verifikasi Usulan
								<div class="text-white-50 small">Ada 7 Usulan Baru</div>
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-4 mb-4">
						<a href="<?php echo base_url(); ?>submit/laporan" style="text-decoration:none">
						<div class="card bg-gradient-info text-white shadow">
							<div class="card-body">
								Review Laporan Akhir 
								<div class="text-white-50 small">Ada 
								<?php
									echo $this->msubmit->hitdireview();
								?>
								Laporan Akhir</div>
							</div>
						</div>
						</a>
					</div>
					</div>
                </div>
              </div>
			  
              <!-- Default Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Skor Penelitian Dosen</h6>
                  <div class="dropdown no-arrow">
                    <a href="<?php echo base_url().'dashboard/getsinta'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-link fa-sm text-white-50"></i> Update Skor</a>
                  </div>
                </div>
                <div class="card-body">
					<table class='table'>
						<tr>
						<?php
							if($cekskor>0)
							{
								$skor1 = $skor['kolom1'];
								$skor2 = $skor['kolom2'];
								$skor3 = $skor['kolom3'];
							}
							else
							{
								$skor1 = 0;
								$skor2 = 0;
								$skor3 = 0;
							}
						?>
							<td width="20%"><img height="20px" src="<?php echo base_url().'assets/img/sinta_logo.png'; ?>" alt="sinta logo"></td>
							<td><?php echo $skor1; ?><br>Overall Score</td>
							<td><?php echo $skor2; ?><br>Overall Score V2</td>
							<td><?php echo $skor3; ?><br>Books</td>
						</tr>
					</table>
                </div>
              </div>

            </div>
			<?php } elseif($this->session->userdata('sesi_status')==3) { ?>
			<div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Skor Penelitian Dosen</h6>
                  <div class="dropdown no-arrow">
                    <a href="<?php echo base_url().'dashboard/getsinta'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-link fa-sm text-white-50"></i> Update Skor</a>
                  </div>
                </div>
                <div class="card-body">
					<table class='table'>
						<tr>
						<?php
							if($cekskor>0)
							{
								$skor1 = $skor['kolom1'];
								$skor2 = $skor['kolom2'];
								$skor3 = $skor['kolom3'];
							}
							else
							{
								$skor1 = 0;
								$skor2 = 0;
								$skor3 = 0;
							}
						?>
							<td width="20%"><img height="20px" src="<?php echo base_url().'assets/img/sinta_logo.png'; ?>" alt="sinta logo"></td>
							<td><?php echo $skor1; ?><br>Overall Score</td>
							<td><?php echo $skor2; ?><br>Overall Score V2</td>
							<td><?php echo $skor3; ?><br>Books</td>
						</tr>
					</table>
                </div>
              </div>
            </div>
			<?php } else { ?>
			<div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Buka Tutup Usulan Baru</h6>
                  <div class="dropdown no-arrow">
                    
                  </div>
                </div>
                <div class="card-body">
					<div class="row">
                <div class="col-lg-4 mb-4">
					<?php
						$ftti = $this->mdosen->cekbuka(2);
						if($ftti['status']==0) {
					?>
					<a href="<?php echo base_url(); ?>dashboard/open/2" style="text-decoration:none">
					<div class="card bg-danger text-white shadow">
						<div class="card-body">
							Buka Usulan
							<div class="text-white-50 small">FTTI</div>
						</div>
					</div>
					</a>
						<?php } else { ?>
					<a href="<?php echo base_url(); ?>dashboard/close/2" style="text-decoration:none">
					<div class="card bg-success text-white shadow">
						<div class="card-body">
							Tutup Usulan
							<div class="text-white-50 small">FTTI</div>
						</div>
					</div>
					</a>
						<?php } ?>
                </div>
				<div class="col-lg-4 mb-4">
					<?php
						$ftti = $this->mdosen->cekbuka(3);
						if($ftti['status']==0) {
					?>
					<a href="<?php echo base_url(); ?>dashboard/open/3" style="text-decoration:none">
					<div class="card bg-danger text-white shadow">
						<div class="card-body">
							Buka Usulan
							<div class="text-white-50 small">FES</div>
						</div>
					</div>
					</a>
						<?php } else { ?>
					<a href="<?php echo base_url(); ?>dashboard/close/3" style="text-decoration:none">
					<div class="card bg-success text-white shadow">
						<div class="card-body">
							Tutup Usulan
							<div class="text-white-50 small">FES</div>
						</div>
					</div>
					</a>
						<?php } ?>
                </div>
				<div class="col-lg-4 mb-4">
					<?php
						$ftti = $this->mdosen->cekbuka(1);
						if($ftti['status']==0) {
					?>
					<a href="<?php echo base_url(); ?>dashboard/open/1" style="text-decoration:none">
					<div class="card bg-danger text-white shadow">
						<div class="card-body">
							Buka Usulan
							<div class="text-white-50 small">FKES</div>
						</div>
					</div>
					</a>
						<?php } else { ?>
					<a href="<?php echo base_url(); ?>dashboard/close/1" style="text-decoration:none">
					<div class="card bg-success text-white shadow">
						<div class="card-body">
							Tutup Usulan
							<div class="text-white-50 small">FKES</div>
						</div>
					</div>
					</a>
						<?php } ?>
                </div>
                </div>
                </div>
              </div>
            </div>
			<?php } ?>
          </div>
        </div>