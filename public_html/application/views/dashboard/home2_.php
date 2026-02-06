<?php
	if($this->session->userdata('sesi_user')=='')
	{
		header('location:'.base_url().'login');
	}
?>
<style>
	
.ui-menu .ui-menu-item a {
  font-size: 12px;
}
.ui-autocomplete {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1510 !important;
  float: left;
  display: none;
  min-width: 160px;
  width: 160px;
  padding: 4px 10px;
  margin: 2px 0 0 0;
  list-style: none;
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.2);
  border-style: solid;
  border-width: 1px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
}
.ui-state-hover, .ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
}
#modalIns{
    width: 500px;
}
</style>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard <?php echo $this->uri->segment(3); ?></h1>
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
		  <?php if($this->session->userdata('sesi_status')<>1) { ?>
		  <ul class="nav nav-tabs" id="myTab" role="tablist">
			<?php
				//pilihan tab
			
				$selectid = ($this->uri->segment(3)=='') ? 'true' : 'false';
				$activeid = ($this->uri->segment(3)=='') ? 'show active' : '';
				$activetabid = ($this->uri->segment(3)=='') ? 'active' : '';
				
				$selectsinta = ($this->uri->segment(3)=='sinta') ? 'true' : 'false';
				$activesinta = ($this->uri->segment(3)=='sinta') ? 'show active' : '';
				$activetabsinta = ($this->uri->segment(3)=='sinta') ? 'active' : '';
				
				$selecteliti = ($this->uri->segment(3)=='penelitian') ? 'true' : 'false';
				$activeteliti = ($this->uri->segment(3)=='penelitian') ? 'show active' : '';
				$activetabteliti = ($this->uri->segment(3)=='penelitian') ? 'active' : '';
				
				$selectabdi = ($this->uri->segment(3)=='pengabdian') ? 'true' : 'false';
				$activeabdi = ($this->uri->segment(3)=='pengabdian') ? 'show active' : '';
				$activetababdi = ($this->uri->segment(3)=='pengabdian') ? 'active' : '';
				
				$selectjurnal = ($this->uri->segment(3)=='jurnal') ? 'true' : 'false';
				$activejurnal = ($this->uri->segment(3)=='jurnal') ? 'show active' : '';
				$activetabjurnal = ($this->uri->segment(3)=='jurnal') ? 'active' : '';
				
				$selecthki = ($this->uri->segment(3)=='hki') ? 'true' : 'false';
				$activehki = ($this->uri->segment(3)=='hki') ? 'show active' : '';
				$activetabhki = ($this->uri->segment(3)=='hki') ? 'active' : '';
				
				$selectpros = ($this->uri->segment(3)=='prosiding') ? 'true' : 'false';
				$activepros = ($this->uri->segment(3)=='prosiding') ? 'show active' : '';
				$activetabpros = ($this->uri->segment(3)=='prosiding') ? 'active' : '';
				
				$selectbuku = ($this->uri->segment(3)=='buku') ? 'true' : 'false';
				$activebuku = ($this->uri->segment(3)=='buku') ? 'show active' : '';
				$activetabuku = ($this->uri->segment(3)=='buku') ? 'active' : '';
				
				$selectmon = ($this->uri->segment(3)=='karya') ? 'true' : 'false';
				$activemon = ($this->uri->segment(3)=='karya') ? 'show active' : '';
				$activetabmon = ($this->uri->segment(3)=='karya') ? 'active' : '';
				
				$selectnas = ($this->uri->segment(3)=='naskah') ? 'true' : 'false';
				$activenas = ($this->uri->segment(3)=='naskah') ? 'show active' : '';
				$activetabnas = ($this->uri->segment(3)=='naskah') ? 'active' : '';
			?>
		  
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabid; ?>" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="<?php echo $selectid; ?>">Identitas</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabsinta; ?>" id="sinta-tab" data-toggle="tab" href="#sinta" role="tab" aria-controls="sinta" aria-selected="<?php echo $selectsinta; ?>">Sinta</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabteliti; ?>" id="penelitian-tab" data-toggle="tab" href="#penelitian" role="tab" aria-controls="penelitian" aria-selected="<?php echo $selecteliti; ?>">Penelitian</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetababdi; ?>" id="pengabdian-tab" data-toggle="tab" href="#pengabdian" role="tab" aria-controls="pengabdian" aria-selected="<?php echo $selectabdi; ?>">Pengabdian</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabjurnal; ?>" id="jurnal-tab" data-toggle="tab" href="#jurnal" role="tab" aria-controls="jurnal" aria-selected="<?php echo $selectjurnal; ?>">Artikel Jurnal</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabhki; ?>" id="hki-tab" data-toggle="tab" href="#hki" role="tab" aria-controls="hki" aria-selected="<?php echo $selecthki; ?>">HKI</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabpros; ?>" id="prosiding-tab" data-toggle="tab" href="#prosiding" role="tab" aria-controls="prosiding" aria-selected="<?php echo $selectpros; ?>">Artikel Prosiding</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabuku; ?>" id="buku-tab" data-toggle="tab" href="#buku" role="tab" aria-controls="buku" aria-selected="<?php echo $selectbuku; ?>">Buku</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabmon; ?>" id="monumental-tab" data-toggle="tab" href="#monumental" role="tab" aria-controls="monumental" aria-selected="<?php echo $selectmon; ?>">Karya Monumental</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link <?php echo $activetabnas; ?>" id="naskah-tab" data-toggle="tab" href="#naskah" role="tab" aria-controls="naskah" aria-selected="false">Naskah Akademik/Urgensi</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			  <div class="tab-pane fade <?php echo $activeid; ?>" id="home" role="tabpanel" aria-labelledby="home-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-md-10">
						  <h6 class="m-0 font-weight-bold text-primary">Profil Peneliti</h6>
						</div>
						<div class="col-md-2 float-right">
						
						</div>
				</div>
				</div>
				<div class="card-body">
				<div class="row">

            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
			  <div class="card-body">
                  <div class="pt-2 pb-2">
                    <img width="300" class="rounded-circle" alt="<?php echo $profil['namalengkap']; ?>" src="
					<?php 
						echo base_url(); 
						if($profil['fotoprofil'] <> '')
							echo 'assets/profilebox/'.$profil['fotoprofil'];
						elseif($profil['fotoprofil'] == '' && $profil['jk'] == 'L')
							echo 'assets/profilebox/man.png';
						else
							echo 'assets/profilebox/woman.png';
					?>">
                  </div>
                </div>
              </div>
            </div>
			<!-- Project Card Example -->
			<div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<label>Nama Lengkap</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['namalengkap']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>NIDN/NPP</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['nidn']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Nomor KTP</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['ktp']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Tempat/Tanggal Lahir</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['tmplahir'].'/'.tgl_indo($profil['tglahir'],1); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jenis Kelamin</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php 
									if($profil['jk']=='L')
										echo 'Laki-Laki';
									else
										echo 'Perempuan'; 
								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Fakultas/Program Studi</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php 
									$fakultas = $this->mdosen->namafakultas($profil['fakultas']);
									$prodi = $this->mdosen->namaprodi($profil['prodi']);
									echo $fakultas['fakultas'].'/'.$prodi['prodi']; 
								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jenjang Pendidikan</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['jenjangpendidikan']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jabatan Akademik</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['jabatanakademik']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Alamat Rumah</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['alamat']; ?></p>
						</div>
					</div>
                </div>
              </div>
            </div>
          </div>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activesinta; ?>" id="sinta" role="tabpanel" aria-labelledby="sinta-tab">
				<div class="card shadow mb-3">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					  <h6 class="m-0 font-weight-bold text-primary">Skor Sinta</h6>
					  <div class="dropdown no-arrow">
						<a href="<?php echo base_url().'dashboard/getsinta'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-link fa-sm text-white-50"></i> Update Skor</a>
					  </div>
					</div>
					<div class="card-body">
						<table class='table'>
							<tr>
							<?php
								$skor1 = 0;
								$skor2 = 0;
								$skor3 = 0;
								if($cekskor>0)
								{
									$skor1 = $skor['kolom1'];
									$skor2 = $skor['kolom2'];
									$skor3 = $skor['kolom3'];
								}
								
							?>
								<td width="20%" rowspan="2"><img height="20px" src="<?php echo base_url().'assets/img/sinta_logo.png'; ?>" alt="sinta logo"></td>
								<td><?php echo $skor1; ?><br>Overall Score</td>
								<td><?php echo $skor2; ?><br>3 Years Score</td>
								<td><?php echo $skor3; ?><br>Books</td>
							</tr>
						</table>
					</div>
				</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activeteliti; ?>" id="penelitian" role="tabpanel" aria-labelledby="penelitian-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Riwayat Penelitian</h6>
				  <a href="<?php echo base_url().'dashboard/tambahpenelitian';?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Penelitian Tambahan</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" class="display" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>Penelitian</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th width="5%">No</th>
						  <th>Penelitian</th>
						  <th width="12%"></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							$no = 1;
							$peranku = '';
							foreach($riwayat as $p)
							{
								$pisah = explode(',',$p->anggotadosen);
								if($this->session->userdata('sesi_id')==$p->pengusul || in_array($this->session->userdata('sesi_dosen'),$pisah)){
								$dosen = $this->mdosen->dosennya($p->pengusul);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								$splityear = explode('-',$p->tglmulai);
								if($this->session->userdata('sesi_id')==$p->pengusul)
									$peranku = 'Ketua Peneliti';								
								elseif($this->session->userdata('sesi_id')<>$p->pengusul)
								{
									if(in_array($this->session->userdata('sesi_dosen'), $pisah))
										$peranku = 'Anggota Peneliti';
								}
								else
									$peranku = '';
								echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>Tahun : </b>".$splityear[0]." | <b>Peran : </b>".$peranku." | <b>Sumber Dana :</b> 
										  ".$p->sumberdana."
										  <br><b>Skema : ".$p->skema."</b></td>
										  <td>";
								if($p->id_usulan=='')
								{
									echo "<a href='".base_url()."dashboard/penelitian/".$p->id_penelitian."' class='shadow-sm' title='Edit Penelitian'><i class='fas fa-edit fa-sm'></i></a>";
								}
								echo "</td>
										</tr>";
								$no++;
								}
							}
							foreach($tambahan as $p)
							{
								$pisah = explode(',',$p->anggota);
								if($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$pisah)){
								$dosen = $this->mdosen->dosennya($p->ketua);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_dosen')==$p->ketua)
									$peranku = 'Ketua Peneliti';
								elseif($this->session->userdata('sesi_dosen')<>$p->ketua)
								{
									if(in_array($this->session->userdata('sesi_dosen'), $pisah))
										$peranku = 'Anggota Peneliti';
								}
								else
									$peranku = '';
								echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>Tahun : </b>".$p->tahun." | <b>Peran : </b>".$peranku." | <b>Sumber Dana :</b> 
										  ".$p->sumberdana."
										  <br><b>Skema : ".$p->jenis."</b></td>
										  <td>";
								if($this->session->userdata('sesi_id')==$p->user)
								{
									echo "<a href='".base_url()."dashboard/editpenelitian/".$p->id_penelitian."' class='shadow-sm' title='Edit Penelitian'><i class='fas fa-edit fa-sm'></i>edit</a>&nbsp;
									<a href='#' data-id='".$p->id_penelitian."' class='shadow-sm hapuspenelitian' title='Hapus Penelitian'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
								}
								echo "</td>
										</tr>";
								$no++;
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activeabdi; ?>" id="pengabdian" role="tabpanel" aria-labelledby="pengabdian-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengabdian</h6>
				  <a href="<?php echo base_url(); ?>dashboard/tambahpengabdian" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px" data-isianpengabdian=""><i class="fas fa-clone fa-sm text-white-50"></i> Pengabdian Tambahan</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>Pengabdian</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th width="5%">No</th>
						  <th>Pengabdian</th>
						  <th width="12%"></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							$no = 1;
							$peranku = '';
							foreach($riwayatpkm as $p)
							{
								$pisah = explode(',',$p->anggotadosen);
								if($this->session->userdata('sesi_id')==$p->pengusul || in_array($this->session->userdata('sesi_dosen'),$pisah)){
								$dosen = $this->mdosen->dosennya($p->pengusul);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_id')==$p->pengusul)
									$peranku = 'Ketua PkM';
								elseif($this->session->userdata('sesi_id')<>$p->pengusul)
								{
									if(in_array($this->session->userdata('sesi_dosen'), $pisah))
										$peranku = 'Anggota PkM';
								}
								else
									$peranku = '';
								$date = DateTime::createFromFormat("Y-m-d", $p->tglmulai);
								echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_laporan_akhir."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>Tahun : </b>".$date->format('Y')." | <b>Peran : </b>".$peranku." | <b>Sumber Dana :</b> 
										  ".$p->sumberdana."
										  <br><b>PkM ".$p->skema."</b></td>
										  <td>";
								if($p->id_usulan=='')
									echo "<a href='".base_url()."dashboard/pengabdian/' class='shadow-sm' title='Edit Pengabdian'><i class='fas fa-edit fa-sm'></i></a>";
								echo "</td>
										</tr>";
								$no++;
								}
							}
							foreach($tambahanpkm as $p)
							{
								$pisah = explode(',',$p->anggota);
								if($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$pisah)){
								$dosen = $this->mdosen->dosennya($p->ketua);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_dosen')==$p->ketua)
									$peranku = 'Ketua PkM';
								elseif($this->session->userdata('sesi_dosen')<>$p->ketua)
								{
									if(in_array($this->session->userdata('sesi_dosen'), $pisah))
										$peranku = 'Anggota PkM';
								}
								else
									$peranku = '';
								echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->filelaporan."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>Tahun : </b>".$p->tahun." | <b>Peran : </b>".$peranku." | <b>Sumber Dana :</b> 
										  ".$p->sumberdana."
										  <br><b>PkM ".$p->jenis."</b></td>
										  <td>";
								if($this->session->userdata('sesi_id')==$p->user)
								{
									echo "<a href='".base_url()."dashboard/editpengabdian/".$p->id_pengabdian."' class='shadow-sm' title='Edit Pengabdian'><i class='fas fa-edit fa-sm'></i>Edit</a>
									<a href='#' data-id='".$p->id_pengabdian."' class='shadow-sm hapuspengabdian' title='Hapus Pengabdian'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
								}
								echo "</td>
										</tr>";
								$no++;
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
				</div>
			</div>
			  <div class="tab-pane fade <?php echo $activejurnal; ?>" id="jurnal" role="tabpanel" aria-labelledby="jurnal-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Artikel Jurnal</h6>
				  <a href="<?php echo base_url(); ?>dashboard/tambahjurnal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Tambah Jurnal</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>Jurnal</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th width="5%">No</th>
						  <th>Jurnal</th>
						  <th width="12%"></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							$no = 1;
							foreach($listjurnal as $p)
							{
								$list = explode(',',$p->authorlain);
								if(($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$list)))
								{
								if($p->usulan<>'')
								{
								$penulisnya = $this->msubmitpribadi->caripenulisjurnal($p->usulan);
								// echo $this->db->last_query();exit;
								}
								//$fakultas = $this->mdosen->namafakultas($p->fakultas);
								//$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_id')==$p->user && $p->peran_penulis=='First Author')
									$peran = $p->peran_penulis;
								else
									$peran = 'Co-Author';
								 
								echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_jurnal."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>Jurnal : </b>".$p->nama_jurnal." | <b>Peran</b> : ".$peran."
										  <br><b>Tahun : </b>".$p->tahun_publikasi." | 
										  <b>Volume : </b>".$p->volume." | 
										  <b>ISSN : </b>".$p->issn."
										  <br><b>URL : </b><a href='".$p->url."' target='_blank'>".$p->url."</a>
										  <td>";
								if($this->session->userdata('sesi_id')==$p->user)
								{
									echo "<a href='".base_url()."dashboard/editjurnal/".$p->id_jurnal."' class='shadow-sm' title='Edit Jurnal'><i class='fas fa-edit fa-sm'></i>Edit</a>
								<a href='#' data-id='".$p->id_jurnal."' class='shadow-sm hapusjurnal' title='Hapus Jurnal'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
								}
								echo "</td>
										</tr>";
								
								if($p->usulan<>''){
								$listw = explode(',',$penulisnya['anggotadosen']);
								if(in_array($this->session->userdata('sesi_dosen'),$listw) || $this->session->userdata('sesi_id')==$penulisnya['pengusul'])
								{
									echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' title='Lihat Dokumen' data-toggle='modal' data-filenya='".$p->file_jurnal."' data-jenisfile='File Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>Jurnal : </b>".$p->nama_jurnal." | <b>Peran</b> : ".$peran."
										  <br><b>Tahun : </b>".$p->tahun_publikasi." | 
										  <b>Volume : </b>".$p->volume." | 
										  <b>ISSN : </b>".$p->issn."
										  <br><b>URL : </b><a href='".$p->url."' target='_blank'>".$p->url."</a>
										  <td></td>
										</tr>";
								}
								}
								$no++;
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activehki; ?>" id="hki" role="tabpanel" aria-labelledby="hki-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">HKI</h6>
				  <a href="<?php echo base_url(); ?>dashboard/tambahhki" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Tambah HKI</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="5%">No</th>
						  <th>HKI</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th width="5%">No</th>
						  <th>HKI</th>
						  <th width="12%"></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							$no = 1;
							foreach($listhki as $p)
							{
								$list = explode(',',$p->authorlain);
								if(($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$list)))
								{
								$namauthor = '';
								$ambil = explode(',',$p->authorlain);
								$hit = count($ambil);
								
								if($p->authorlain<>'') 
								{
									for($i=0;$i<$hit;$i++)
									{
										$dosen = $this->mdosen->namadosen($ambil[$i]);
										$namauthor .= $dosen['namalengkap'];
										if($i<($hit-1))
											$namauthor .= ' dan ';
									}
								}
								else
									$namauthor = 'Tidak Ada Author Lain'; 
								echo "<tr>
										  <td>".$no."</td>
										  <td><a href='' data-toggle='modal' data-filenya='".$p->file_hki."' data-jenisfile='File Dokumen' title='Lihat Dokumen' data-target='#liatfile'>".$p->judul."</a>
										  <br><b>".$p->jenis_hki."</b> | No. Pendaftaran : ".$p->nomor_pendaftaran." | Tahun Pelaksanaan : ".$p->tahun_pelaksanaan."
										  <br>Status : ".$p->status." | Nomor HKI : ".$p->nomor_hki."
										  </td><td>";
								if($this->session->userdata('sesi_id')==$p->user)
								{
									echo "<a href='".base_url()."dashboard/edithki/".$p->id_hki."' class='shadow-sm' title='Edit HKI'><i class='fas fa-edit fa-sm'></i>Edit</a>
								<a href='#' data-id='".$p->id_hki."' class='shadow-sm hapushki' title='Hapus HKI'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
								}
								echo "</td></tr>";
								$no++;
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			  </div>
			  </div>
			  <div class="tab-pane fade <?php echo $activepros; ?>" id="prosiding" role="tabpanel" aria-labelledby="prosiding-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Artikel Prosiding</h6>
				  <a href="<?php echo base_url()."dashboard/tambahprosiding"; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Tambah Prosiding</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Judul Prosiding</th>
						  <th>Tahun</th>
						  <th>URL</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th>Judul Prosiding</th>
						  <th>Tahun</th>
						  <th>URL</th>
						  <th></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							foreach($listpros as $p)
							{
								//$fakultas = $this->mdosen->namafakultas($p->fakultas);
								//$prodi = $this->mdosen->namaprodi($p->prodi);
								$list = explode(',',$p->authorlain);
								if($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$list))
								{
									echo "<tr>
										  <td>".$p->judul."</td>
										  <td>".$p->tahun."</td>
										  <td><a href='' data-toggle='modal' data-filenya='".$p->file_prosiding."' data-jenisfile='File Dokumen' data-target='#liatfile'>Lihat Dokumen</a></td><td>";
									if($this->session->userdata('sesi_id')==$p->user)
									{
										 echo "<a href='".base_url()."dashboard/editprosiding/".$p->id_prosiding."' class='shadow-sm' title='Edit Prosiding'><i class='fas fa-edit fa-sm'></i>Edit</a>
									 <a href='#' data-id='".$p->id_prosiding."' class='shadow-sm hapusprosiding' title='Hapus Prosiding'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
									}
									echo "</td></tr>";
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activebuku; ?>" id="buku" role="tabpanel" aria-labelledby="buku-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Buku</h6>
				  <a href="<?php echo base_url().'dashboard/tambahbuku'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Tambah Buku</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Judul Buku</th>
						  <th>Tahun Terbit</th>
						  <th>URL</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th>Judul Buku</th>
						  <th>Tahun Terbit</th>
						  <th>URL</th>
						  <th></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							foreach($listbuku as $p)
							{
								//$fakultas = $this->mdosen->namafakultas($p->fakultas);
								//$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$list))
								{
									echo "<tr>
										  <td>".$p->judul."</td>
										  <td>".$p->tahun_terbit."</td>
										  <td><a href='' data-toggle='modal' data-filenya='".$p->file_buku."' data-jenisfile='File Dokumen' data-target='#liatfile'>Lihat Dokumen</a></td><td>";
									if($this->session->userdata('sesi_id')==$p->user)
									{
										echo "<a href='".base_url()."dashboard/editbuku/".$p->id_buku."' class='shadow-sm' title='Edit Buku'><i class='fas fa-edit fa-sm'></i>Edit</a>
										<a href='#' data-id='".$p->id_buku."' class='shadow-sm hapusbuku' title='Hapus Buku'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
									}
									echo "</td></tr>";
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activemon; ?>" id="monumental" role="tabpanel" aria-labelledby="monumental-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Karya Monumental</h6>
				  <a href="<?php echo base_url().'dashboard/tambahkarya'; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Tambah Karya</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th width="50%">Jenis Karya Monumental</th>
						  <th>Tingkat Karya Monumental</th>
						  <th>Tahun</th>
						  <th>URL</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th width="50%">Jenis Karya Monumental</th>
						  <th>Tingkat Karya Monumental</th>
						  <th>Tahun</th>
						  <th>URL</th>
						  <th></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							foreach($listkarya as $p)
							{
								//$fakultas = $this->mdosen->namafakultas($p->fakultas);
								//$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$list))
								{	
									echo "<tr>
										  <td>".$p->jenis_karya."</td>
										  <td>".$p->level_karya."</td>
										  <td>".$p->tahun_pelaksanaan."</td>
										  <td><a href='' data-toggle='modal' data-filenya='".$p->dokumen."' data-jenisfile='File Dokumen' data-target='#liatfile'>Lihat Dokumen</a></td><td>";
									if($this->session->userdata('sesi_id')==$p->user)
									{
										echo "<a href='".base_url()."dashboard/editkarya/".$p->id_karya."' class='shadow-sm' title='Edit Karya Monumental'><i class='fas fa-edit fa-sm'></i>Edit</a>
										<a href='#' data-id='".$p->id_karya."' class='shadow-sm hapuskarya' title='Hapus Karya Monumental'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
									}
									echo "</td></tr>";
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			</div>
			  </div>
			  <div class="tab-pane fade <?php echo $activenas; ?>" id="naskah" role="tabpanel" aria-labelledby="naskah-tab">
			  <div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Naskah Akademik & Naskah Urgensi</h6>
				  <a href="<?php echo base_url(); ?>dashboard/tambahnaskah" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="float:right;margin-top:-25px"><i class="fas fa-clone fa-sm text-white-50"></i> Tambah Naskah</a>
				</div>
				<div class="card-body">
					<table class="table table-bordered display" id="" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Jenis Naskah</th>
						  <th>Tahun Naskah</th>
						  <th>Peruntukan Naskah</th>
						  <th>URL</th>
						  <th width="12%"></th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th>Jenis Naskah</th>
						  <th>Tahun Naskah</th>
						  <th>Peruntukan Naskah</th>
						  <th>URL</th>
						  <th width="12%"></th>
						</tr>
					  </tfoot>
					  <tbody>
						<?php
							foreach($listnaskah as $p)
							{
								//$fakultas = $this->mdosen->namafakultas($p->fakultas);
								//$prodi = $this->mdosen->namaprodi($p->prodi);
								if($this->session->userdata('sesi_id')==$p->user || in_array($this->session->userdata('sesi_dosen'),$list))
								{
									echo "<tr>
										  <td>".$p->jenis_naskah."</td>
										  <td>".$p->tahun_naskah."</td>
										  <td>".$p->peruntukan_naskah."</td>
										  <td><a href='' data-toggle='modal' data-filenya='".$p->dokumen."' data-jenisfile='File Dokumen' data-target='#liatfile'>Lihat Dokumen</a></td><td>";
									if($this->session->userdata('sesi_id')==$p->user)
									{
										echo "<a href='".base_url()."dashboard/editnaskah/".$p->id_naskah."' class='shadow-sm' title='Edit Naskah Akademik/Urgensi'><i class='fas fa-edit fa-sm'></i>Edit</a>
										<a href='#' data-id='".$p->id_naskah."' class='shadow-sm hapusnaskah' title='Hapus Naskah Akademik/Urgensi'><i class='fas fa-trash fa-sm'></i>Hapus</a>";
									}
									echo "</td></tr>";
								}
							}
						?>	
					  </tbody>
					</table>
				</div>
			</div>
			  </div>
			</div>
		  <?php } else { ?>
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
          </div>
		  <?php } ?>
        </div>

<!-- Modal Lihat Dokumen-->
<div class="modal fade" id="liatfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jenisfile">File Dokumen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">
				<embed id="filenya" src="" frameborder="0" width="100%" height="400px"/>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			  </div>
			</div>

		</div>
	</div>
</div>


	<?php
		$dosen = $this->mdosen->select();
		$datanama = array();
		foreach($dosen as $d)
		{
			$datanama[] = array(
			  'value' => $d->id_dosen,
			  'label' => $d->namalengkap); 
		}
		$anggota = json_encode($datanama);
	?>

<script>
	$('#liatfile').on('hidden.bs.modal', function (e) {
		$('#filenya').setAttribute('src','');
		//var sumber = document.getElementById("filenya");
			//sumber.setAttribute("src",""));
	});

	$(function () {
		//Date picker
		$('#tglserah').datepicker({
		  changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0',
			autoclose: true
		});
	});

	$(document).ready(function() {
	  $('table.display').DataTable();
	} );
	
	$(document).ready(function() {
        $('#liatfile').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
			var modal = $(this)
			
			var sumber = document.getElementById("filenya");
			sumber.setAttribute("src","https://simlitabmas.unjaya.ac.id/assets/uploadbox/"+div.data('filenya'));
			
			modal.find('#jenisfile').html(div.data('jenisfile'));
        });
    });
	
	$(".hapus").click(function(){
		var id = $(this).data('id');
		var tab = $(this).data('tab');
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
				window.location = "<?php echo base_url();?>dashboard/hapus/" + tab + "/" + id ;
			}
		})
	});
	
	//autocomplete dosen
	$(function() {
		function split( val ) {
		return val.split( /,\s*/ );
		}
		function extractLast( term ) {
		return split( term ).pop();
		}
		
		var projects = <?php echo $anggota; ?>;
			 
		$( "#authorlain" )
		 // don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
		if ( event.keyCode === $.ui.keyCode.TAB &&
		$( this ).autocomplete( "instance" ).menu.active ) {
		event.preventDefault();
		}
		})
		.autocomplete({
		minLength: 0,
		appendTo: "#tambahjurnal",
		source: function( request, response ) {
		// delegate back to autocomplete, but extract the last term
		response( $.ui.autocomplete.filter(
		projects, extractLast( request.term ) ) );
		},

		//    source:projects,    
		focus: function() {
		// prevent value inserted on focus
		return false;
		},
		select: function( event, ui ) {
		var terms = split( this.value );
		// remove the current input
		terms.pop();
		// add the selected item
		terms.push( ui.item.label );
		// add placeholder to get the comma-and-space at the end
		terms.push( "" );
		this.value = terms.join( ", " );
			
			var selected_label = ui.item.label;
			var selected_value = ui.item.value;
			
			var labels = $('#labels').val();
			var values = $('#values').val();
			
			if(labels == "")
			{
				$('#labels').val(selected_label);
				$('#valuesjurnal').val(selected_value);
			}
			else    
			{
				$('#labels').val(labels+","+selected_label);
				$('#values').val(values+","+selected_value);
			}   
			
		return false;
		}
		});

	}); 
	
	$(".hapuspenelitian").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapuspenelitian/" + id ;
		}
	})
	});
	
	$(".hapuspengabdian").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapuspengabdian/" + id ;
		}
	})
	});
	
	$(".hapusjurnal").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapusjurnal/" + id ;
		}
	})
	});
	
	$(".hapushki").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapushki/" + id ;
		}
	})
	});
	
	$(".hapusprosiding").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapusprosiding/" + id ;
		}
	})
	});
	
	$(".hapusbuku").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapusbuku/" + id ;
		}
	})
	});
	
	$(".hapuskarya").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapuskarya/" + id ;
		}
	})
	});
	
	$(".hapusnaskah").click(function(){
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
			window.location = "<?php echo base_url();?>dashboard/hapusnaskah/" + id ;
		}
	})
	});
</script>