<?php
	if(!$this->session->userdata('sesi_user'))
	{
		redirect("login");
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LPPM - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url();?>assets/css/font-google.css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/img/favicon.ico" type="image/x-icon" rel="icon"/>

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url();?>assets/css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="<?php echo base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/jquery-1.10.2.js"></script>
  <script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
  
  <!-- Datepicker -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datetimepicker.css">
  
  <!--<script src="<?php //echo base_url(); ?>assets/js/chart.min.js"></script>-->
  <script src="<?php echo base_url(); ?>assets/js/utils.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php 
		// if($this->session->userdata('sesi_status')==1)
			// echo base_url();
		// elseif($this->session->userdata('sesi_nama')<>'' || $this->session->userdata('sesi_verified')==1)
		// elseif($this->session->userdata('sesi_nama')<>'')
			// echo base_url().'dosen/tambah';
		// else
			echo base_url();
		?>">
        <div class="sidebar-brand-icon">
          <img height="36" src="<?php echo base_url(); ?>assets/img/logo_unjani.png">
        </div>
        <div class="sidebar-brand-text mx-3">LPPM UNJANI
			<sup>Yogyakarta</sup>
		</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if($this->uri->segment(1)=='' || $this->uri->segment(1)=='dashboard' || $this->uri->segment(1)=='profil') echo $active; ?>">
        <a class="nav-link" href="<?php 
			// if($this->session->userdata('sesi_status')==1)
				// echo base_url();
			//elseif($this->session->userdata('sesi_nama')<>'' || $this->session->userdata('sesi_verified')==1)
			// elseif($this->session->userdata('sesi_nama')<>'')
				// echo base_url().'dosen/tambah';
			// else
				echo base_url();
			
			?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
	  <!-- Heading -->
		<?php 
			if($this->session->userdata('sesi_status')==1) {
		?>
      
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Data Master</span>
        </a>
        <div id="collapseTwo" class="collapse <?php if($this->uri->segment(1)=='pengguna' || $this->uri->segment(1)=='dosen' || $this->uri->segment(1)=='reviewer' || $this->uri->segment(1)=='kuesioner' || $this->uri->segment(1)=='dokumen') echo $show; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='pengguna') echo $active; ?> " href="<?php echo base_url(); ?>pengguna">
          <i class="fas fa-fw fa-users"></i>
          <span>Pengguna</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='dosen'&& $this->uri->segment(2)=='keprodi') echo $active; ?>" href="<?php echo base_url(); ?>dosen/keprodi">
          <i class="fas fa-fw fa-user"></i>
          <span>Keprodi</span></a>
            <a class="collapse-item <?php if($this->uri->segment(1)=='dosen' && $this->uri->segment(2)=='') echo $active; ?>" href="<?php echo base_url(); ?>dosen">
          <i class="fas fa-fw fa-graduation-cap"></i>
          <span>Dosen</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='reviewer') echo $active; ?>" href="<?php echo base_url(); ?>reviewer">
          <i class="fas fa-fw fa-search"></i>
          <span>Reviewer</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='kuesioner') echo $active; ?>" href="<?php echo base_url(); ?>kuesioner/data">
          <i class="fas fa-fw fa-columns"></i>
          <span>Kuesioner</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='dokumen') echo $active; ?>" href="<?php echo base_url(); ?>dokumen">
          <i class="fas fa-fw fa-download"></i>
          <span>Dokumen</span></a>
          </div>
        </div>
      </li>
	  <?php 
			}
		if($this->session->userdata('sesi_status')==1 || $this->session->userdata('sesi_status')==2 || $this->session->userdata('sesi_wadek')==1) {
	  ?>
	  <li class="nav-item">
		<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRekap" aria-expanded="true" aria-controls="collapseRekap">
          <i class="fas fa-fw fa-folder"></i>
          <span>Rekap Kinerja</span>
        </a>
        <div id="collapseRekap" class="collapse <?php if(($this->uri->segment(1)=='rekap' || $this->uri->segment(1)=='award') && ($this->uri->segment(2)=='reviewer' || $this->uri->segment(2)=='' || $this->uri->segment(2)=='jurnal' || $this->uri->segment(2)=='penelitian' || $this->uri->segment(2)=='pengabdian' || $this->uri->segment(2)=='jurnal' || $this->uri->segment(2)=='hki' || $this->uri->segment(2)=='prosiding' || $this->uri->segment(2)=='buku' || $this->uri->segment(2)=='karya' || $this->uri->segment(2)=='naskah' || $this->uri->segment(2)=='detail' || $this->uri->segment(2)=='detailrevriset' || $this->uri->segment(2)=='detailrevpkm')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php if($this->session->userdata('sesi_status')==1) { ?>
                <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='reviewer' || $this->uri->segment(2)=='detailrevriset' || $this->uri->segment(2)=='detailrevpkm')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/reviewer">
          <i class="fas fa-fw fa-folder"></i>
          <span>Reviewer</span></a>
            <?php } ?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='penelitian')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/penelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Penelitian</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='pengabdian')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/pengabdian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pengabdian</span></a>
			<a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='jurnal')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/jurnal">
          <i class="fas fa-fw fa-folder"></i>
          <span>Jurnal</span></a>
			<a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='hki')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/hki">
          <i class="fas fa-fw fa-folder"></i>
          <span>HKI</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='prosiding')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/prosiding">
          <i class="fas fa-fw fa-folder"></i>
          <span>Prosiding</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='buku')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/buku">
          <i class="fas fa-fw fa-folder"></i>
          <span>Buku</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='karya')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/karya">
          <i class="fas fa-fw fa-folder"></i>
          <span>Karya Monumental</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='naskah')) echo $active; ?>" href="<?php echo base_url(); ?>rekap/naskah">
          <i class="fas fa-fw fa-folder"></i>
          <span>Naskah Akademik</span></a>
		  <?php if($this->session->userdata('sesi_status')==1) { ?>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='award') echo $active; ?>" href="<?php echo base_url(); ?>award">
          <i class="fas fa-fw fa-folder"></i>
          <span>LPPM Award</span></a>
		  <?php } ?>
      </li>
		<?php 
    } 
    if($this->session->userdata('sesi_status')==1) {
    ?>
    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseValidasi" aria-expanded="true" aria-controls="collapseRekap">
          <i class="fas fa-fw fa-folder"></i>
          <span>Validasi</span>
        </a>
        <div id="collapseValidasi" class="collapse <?php if(($this->uri->segment(1)=='validasi') && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='jurnal' || $this->uri->segment(2)=='penelitian' || $this->uri->segment(2)=='detailpenelitian' || $this->uri->segment(2)=='pengabdian' || $this->uri->segment(2)=='detailpengabdian' || $this->uri->segment(2)=='hki' || $this->uri->segment(2)=='detailhki' || $this->uri->segment(2)=='prosiding' || $this->uri->segment(2)=='detailprosiding' || $this->uri->segment(2)=='buku' || $this->uri->segment(2)=='detailbuku' || $this->uri->segment(2)=='karya' || $this->uri->segment(2)=='detailkarya' || $this->uri->segment(2)=='naskah' || $this->uri->segment(2)=='detailnaskah')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='penelitian' || $this->uri->segment(2)=='detailpenelitian')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/penelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Penelitian</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='pengabdian' || $this->uri->segment(2)=='detailpengabdian')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/pengabdian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pengabdian</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='jurnal' || $this->uri->segment(2)=='detailjurnal')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/jurnal">
          <i class="fas fa-fw fa-folder"></i>
          <span>Jurnal</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='hki' || $this->uri->segment(2)=='detailhki')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/hki">
          <i class="fas fa-fw fa-folder"></i>
          <span>HKI</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='prosiding' || $this->uri->segment(2)=='detailprosiding')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/prosiding">
          <i class="fas fa-fw fa-folder"></i>
          <span>Prosiding</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='buku' || $this->uri->segment(2)=='detailbuku')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/buku">
          <i class="fas fa-fw fa-folder"></i>
          <span>Buku</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='karya' || $this->uri->segment(2)=='detailkarya')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/karya">
          <i class="fas fa-fw fa-folder"></i>
          <span>Karya Monumental</span></a>
      <a class="collapse-item <?php if($this->uri->segment(1)=='validasi' && ($this->uri->segment(2)=='naskah' || $this->uri->segment(2)=='detailnaskah')) echo $active; ?>" href="<?php echo base_url(); ?>validasi/naskah">
          <i class="fas fa-fw fa-folder"></i>
          <span>Naskah Akademik</span></a>
      </li>
      <?php } ?>
      <!-- Heading -->
	  <?php if(($this->session->userdata('sesi_nama')<>'' && $this->session->userdata('sesi_verified')==1) || ($this->session->userdata('sesi_status')==1)) { ?>
      
      <!-- Nav Item - Penelitian -->
	  <?php if($this->session->userdata('sesi_status')<>1) { ?>
	  <li class="nav-item <?php if($this->uri->segment(1)=='dokumen') echo $active; ?>">
        <a class="nav-link" href="<?php echo base_url(); ?>dokumen">
          <i class="fas fa-fw fa-folder"></i>
          <span>Dokumen</span></a>
      </li>
	  <?php } ?>
	  <!--<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSurat" aria-expanded="true" aria-controls="collapsePenelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Surat</span>
        </a>
        <div id="collapseSurat" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="">
          <i class="fas fa-fw fa-folder"></i>
          <span>Surat Tugas</span></a>
			<a class="collapse-item" href="">
          <i class="fas fa-fw fa-folder"></i>
          <span>Surat Kontrak</span></a>
      </li>
	  -->
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKlinik" aria-expanded="true" aria-controls="collapseKlinik">
          <i class="fas fa-fw fa-folder"></i>
          <span>Klinik Proposal</span>
        </a>
        <div id="collapseKlinik" class="collapse <?php if($this->uri->segment(1)=='klinik' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='prodi' || $this->uri->segment(2)=='penelitian' || $this->uri->segment(2)=='pengabdian' || $this->uri->segment(2)=='uploadpenelitian' ||  $this->uri->segment(2)=='uploadpengabdian' || $this->uri->segment(2)=='editpenelitian' || $this->uri->segment(2)=='editpengabdian')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='klinik' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='penelitian' || $this->uri->segment(2)=='editpenelitian' || $this->uri->segment(2)=='uploadpenelitian' || $this->uri->segment(4)=='penelitian')) echo $active; ?>" href="<?php echo base_url(); ?>klinik/penelitian">
			<i class="fas fa-fw fa-folder"></i>
			<span>Penelitian</span></a>
			<a class="collapse-item <?php if($this->uri->segment(1)=='klinik' && ($this->uri->segment(2)=='pengabdian' || $this->uri->segment(2)=='editpengabdian' || $this->uri->segment(2)=='uploadpengabdian' || $this->uri->segment(4)=='pkm')) echo $active; ?>" href="<?php echo base_url(); ?>klinik/pengabdian">
			<i class="fas fa-fw fa-folder"></i>
			<span>Pengabdian</span></a>
          </div>
        </div>
      </li>
	  <li class="nav-item <?php if($this->uri->segment(1)=='roadmap') echo $active; ?>">
        <a class="nav-link" href="<?php echo base_url();?>roadmap">
          <i class="fas fa-fw fa-folder"></i>
          <span>Roadmap</span></a>
      </li>
	  <?php if(in_array($this->session->userdata('sesi_id'),array(109,38,95)) || $this->session->userdata('sesi_status')==1 || $this->session->userdata('sesi_status')==2) { ?>
	  <li class="nav-item <?php if($this->uri->segment(1)=='rekap' && ($this->uri->segment(2)=='stat' || $this->uri->segment(2)=='statprodi' || $this->uri->segment(2)=='detailrisetdosen' || $this->uri->segment(2)=='detailpkmdosen')) echo $active; ?>">
        <a class="nav-link" href="<?php echo base_url();?>rekap/stat">
          <i class="fas fa-fw fa-folder"></i>
          <span>Statistik</span></a>
      </li>
	  <?php } ?>
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSurat" aria-expanded="true" aria-controls="collapseSurat">
          <i class="fas fa-fw fa-folder"></i>
          <span>Surat Menyurat</span>
        </a>
        <div id="collapseSurat" class="collapse <?php if($this->uri->segment(1)=='surat' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='nomor' || $this->uri->segment(2)=='nomorpengabdian' || $this->uri->segment(2)=='nomorpenelitian' || $this->uri->segment(2)=='penelitian' || $this->uri->segment(2)=='pengabdian' || $this->uri->segment(2)=='edit' || $this->uri->segment(2)=='dasar' || $this->uri->segment(2)=='editdasar' || $this->uri->segment(2)=='tambahdasar' || $this->uri->segment(2)=='izin')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='surat' && ($this->uri->segment(2)=='izin')) echo $active; ?>" href="<?php echo base_url(); ?>surat/izin">
          <i class="fas fa-fw fa-folder"></i>
          <span>Form Surat Izin</span></a>
		  <?php if($this->session->userdata('sesi_status')==1) { ?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='surat' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='nomorpenelitian')) echo $active; ?>" href="<?php echo base_url(); ?>surat/nomorpenelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Surat Penelitian</span></a>
          <a class="collapse-item <?php if($this->uri->segment(1)=='surat' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='nomorpengabdian')) echo $active; ?>" href="<?php echo base_url(); ?>surat/nomorpengabdian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Surat Pengabdian</span></a>
          <a class="collapse-item <?php if($this->uri->segment(1)=='surat' && ($this->uri->segment(2)=='dasar' || $this->uri->segment(2)=='tambahdasar' || $this->uri->segment(2)=='editdasar')) echo $active; ?>" href="<?php echo base_url(); ?>surat/dasar">
          <i class="fas fa-fw fa-folder"></i>
          <span>Dasar Surat</span></a>
		  <?php 
		  } if($this->session->userdata('sesi_status')<>1) {
			?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='surat' && $this->uri->segment(2)=='penelitian') echo $active; ?>" href="<?php echo base_url(); ?>surat/penelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Penelitian</span></a>
			<a class="collapse-item <?php if($this->uri->segment(1)=='surat' && $this->uri->segment(2)=='pengabdian') echo $active; ?>" href="<?php echo base_url(); ?>surat/pengabdian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pengabdian</span></a>
			<?php } ?>
          </div>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenelitian" aria-expanded="true" aria-controls="collapsePenelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Penelitian</span>
        </a>
        <div id="collapsePenelitian" class="collapse <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='kaprodi' || $this->uri->segment(2)=='kaprodicek' || $this->uri->segment(2)=='rab' || $this->uri->segment(2)=='detail' || $this->uri->segment(2)=='dasar' || $this->uri->segment(2)=='progress' ||  $this->uri->segment(2)=='terapan' || $this->uri->segment(2)=='kejuangan' || $this->uri->segment(2)=='pengembangan' || $this->uri->segment(2)=='edit' || $this->uri->segment(2)=='plotreviewer' || $this->uri->segment(2)=='kemajuan' || $this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='detaillaporan' || $this->uri->segment(2)=='riwayat')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='rab' || $this->uri->segment(2)=='detail' || $this->uri->segment(2)=='dasar' || $this->uri->segment(2)=='terapan' || $this->uri->segment(2)=='kejuangan' || $this->uri->segment(2)=='pengembangan' || $this->uri->segment(2)=='edit')) echo $active; ?>" href="<?php
			$hitque = $this->mdosen->sudahisibelum();
			if($this->session->userdata('sesi_status')<>1 && $hitque==0)
				echo base_url().'kuesioner'; 
			else
				echo base_url().'submit'; 
			?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Usulan Baru</span></a>
		  <?php 
				if($this->session->userdata('sesi_status')==2) {
			?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='kaprodi' || $this->uri->segment(2)=='kaprodicek')) echo $active; ?>" href="<?php echo base_url(); ?>submit/kaprodi">
          <i class="fas fa-fw fa-folder"></i>
          <span>Kaprodi Setuju</span></a>
			<?php 
				} 
				if($this->session->userdata('sesi_status')==1) {
			?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && $this->uri->segment(2)=='plotreviewer') echo $active; ?>" href="<?php echo base_url(); ?>submit/plotreviewer">
          <i class="fas fa-fw fa-folder"></i>
          <span>Plot Reviewer</span></a>

            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && $this->uri->segment(2)=='rekapreview') echo $active; ?>" href="<?php echo base_url(); ?>submit/rekapreview">
          <i class="fas fa-fw fa-folder"></i>
          <span>Rekap Review</span></a>

		  <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && $this->uri->segment(2)=='progress') echo $active; ?>" href="<?php echo base_url(); ?>submit/progress">
          <i class="fas fa-fw fa-folder"></i>
          <span>Progress Usulan</span></a>
			<?php } ?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && $this->uri->segment(2)=='kemajuan') echo $active; ?>" href="<?php echo base_url(); ?>submit/kemajuan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Kemajuan</span></a>
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='detaillaporan')) echo $active; ?>" href="<?php echo base_url(); ?>submit/laporan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Akhir</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && $this->uri->segment(2)=='riwayat') echo $active; ?>" href="<?php echo base_url(); ?>submit/riwayat">
          <i class="fas fa-fw fa-inbox"></i>
          <span>Riwayat Usulan</span></a>
          </div>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengabdian" aria-expanded="true" aria-controls="collapsePengabdian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pengabdian</span>
        </a>
        <div id="collapsePengabdian" class="collapse <?php if($this->uri->segment(1)=='pengabdian' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='kaprodi' || $this->uri->segment(2)=='kaprodicek' || $this->uri->segment(2)=='tambahusulan' || $this->uri->segment(2)=='rab' || $this->uri->segment(2)=='detail' || $this->uri->segment(2)=='insidental' || $this->uri->segment(2)=='noninsidental' || $this->uri->segment(2)=='kejuangan' || $this->uri->segment(2)=='pengembangan' || $this->uri->segment(2)=='edit' || $this->uri->segment(2)=='plotreviewer' || $this->uri->segment(2)=='kemajuan' || $this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='detaillaporan' || $this->uri->segment(2)=='riwayat')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='tambahusulan' || $this->uri->segment(2)=='rab' || $this->uri->segment(2)=='detail' || $this->uri->segment(2)=='insidental' || $this->uri->segment(2)=='noninsidental' || $this->uri->segment(2)=='kejuangan' || $this->uri->segment(2)=='pengembangan' || $this->uri->segment(2)=='edit')) echo $active; ?>" href="<?php
			$hitque = $this->mdosen->sudahisibelum();
			// if($this->session->userdata('sesi_status')<>1 && $hitque==0)
				// echo base_url().'kuesioner'; 
			// else
				echo base_url().'pengabdian'; 
			?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Usulan Baru</span></a>
		  <?php 
				if($this->session->userdata('sesi_status')==2) {
			?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && ($this->uri->segment(2)=='kaprodi' || $this->uri->segment(2)=='kaprodicek')) echo $active; ?>" href="<?php echo base_url(); ?>pengabdian/kaprodi">
          <i class="fas fa-fw fa-folder"></i>
          <span>Persetujuan Prodi</span></a>
			<?php 
				} 
			
				if($this->session->userdata('sesi_status')==1) {
			?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && $this->uri->segment(2)=='plotreviewer') echo $active; ?>" href="<?php echo base_url(); ?>pengabdian/plotreviewer">
          <i class="fas fa-fw fa-folder"></i>
          <span>Plot Reviewer</span></a>

            <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && $this->uri->segment(2)=='rekapreview') echo $active; ?>" href="<?php echo base_url(); ?>pengabdian/rekapreview">
          <i class="fas fa-fw fa-folder"></i>
          <span>Rekap Review</span></a>
          
			<?php } ?>
            <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && $this->uri->segment(2)=='kemajuan') echo $active; ?>" href="<?php echo base_url(); ?>pengabdian/kemajuan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Kemajuan</span></a>
            <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && ($this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='detaillaporan')) echo $active; ?>" href="<?php echo base_url(); ?>pengabdian/laporan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Akhir</span></a>
		  <a class="collapse-item <?php if($this->uri->segment(1)=='pengabdian' && $this->uri->segment(2)=='riwayat') echo $active; ?>" href="<?php echo base_url(); ?>pengabdian/riwayat">
          <i class="fas fa-fw fa-inbox"></i>
          <span>Riwayat Usulan</span></a>
          </div>
        </div>
      </li>
	  <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
	  <?php } ?>

      <!-- Reviewer Luar -->
      <?php
      if($this->session->userdata('sesi_status')==4) {
      ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenelitian" aria-expanded="true" aria-controls="collapsePenelitian">
          <i class="fas fa-fw fa-folder"></i>
          <span>Penelitian</span>
        </a>
        <div id="collapsePenelitian" class="collapse <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='rab' || $this->uri->segment(2)=='kemajuan' || $this->uri->segment(2)=='detail' || $this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='detaillaporan' || $this->uri->segment(2)=='riwayat')) echo $show; ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='' || $this->uri->segment(2)=='rab' || $this->uri->segment(2)=='detail')) echo $active; ?>" href="<?php
              echo base_url().'submit'; 
      ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Usulan Baru</span></a>
      
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && $this->uri->segment(2)=='kemajuan') echo $active; ?>" href="<?php echo base_url(); ?>submit/kemajuan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Kemajuan</span></a>
            <a class="collapse-item <?php if($this->uri->segment(1)=='submit' && ($this->uri->segment(2)=='laporan' || $this->uri->segment(2)=='detaillaporan')) echo $active; ?>" href="<?php echo base_url(); ?>submit/laporan">
          <i class="fas fa-fw fa-folder"></i>
          <span>Laporan Akhir</span></a>
          </div>
        </div>
      </li>
    <?php } ?>
      <!-- Reviewer Luar -->

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
		
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
			<!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php
					$n = 0;
					$m = 0;
					$hitbaru = $this->msubmit->hitbaru();
					$hitpkm = $this->mpengabdian->hitbaru();
					if($this->session->userdata('sesi_status')==2 && $hitbaru>0)
						$n=1;
					else
						$n=0;
					
					if($this->session->userdata('sesi_status')==2 && $hitpkm>0)
						$m=1;
					else
						$m=0;
					
					$out = $m+$n;
					
					if($out==0)
						$out = '';
				?>
				<span class="badge badge-danger badge-counter"><?php echo $out;?></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
				<?php
					if($this->session->userdata('sesi_status')==2 && $hitbaru>0) {
				?>
                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url(); ?>submit/kaprodi">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold">Ada Usulan Penelitian Baru untuk disetujui</span>
                  </div>
                </a>
				<?php } 
				if($this->session->userdata('sesi_status')==2 && $hitpkm>0) {
				?>
                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url(); ?>pengabdian/kaprodi">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold">Ada Usulan Pengabdian Baru untuk disetujui</span>
                  </div>
                </a>
				<?php } ?>
				<br>
              </div>
            </li>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
				<?php 
					if($this->session->userdata('sesi_nama')=='')
						echo $this->session->userdata('sesi_user'); 
					else
						echo $this->session->userdata('sesi_nama'); 
				?>
				</span>
                <img class="img-profile rounded-circle" src="<?php echo base_url(); ?>assets/img/user.jpg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
				<?php if(($this->session->userdata('sesi_status')<>1 && $this->session->userdata('sesi_status')<>4) && $this->session->userdata('sesi_nama')<>'') { ?>
                <a class="dropdown-item" href="<?php echo base_url(); ?>profil">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>
				<?php } ?>
                <a class="dropdown-item" href="" id="gantipass" data-ganti="<?php echo $this->session->userdata('sesi_id');?>" data-toggle="modal" data-target="#ganti-modal">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Ganti Password
                </a>
                <!--<a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>-->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url();?>logout" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        
		<?php $this->load->view($page); ?>
		
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>LPPM Universitas Jenderal Achmad Yani Yogyakarta 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Anda mau keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Logout" jika ingin keluar.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?php echo base_url(); ?>logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="ganti-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'pengguna/gantipassword'; ?>">
          <div id="hitungpass"></div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Password Lama:</label>
            <input type="text" name="passlama" class="form-control" id="passlama" required>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Password Baru:</label>
            <input type="text" name="passbaru" class="form-control" id="passbaru" required>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Ulangi Password:</label>
            <input type="text" name="verpass" class="form-control" id="verpass" required>
          </div>
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		<button type="submit" id="tombolpass" class="btn btn-success">Simpan</button>
	  </div>
	  </form>
    </div>
  </div>
</div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url();?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url();?>assets/js/sb-admin-2.min.js"></script>
  <!-- Page level plugins -->
  <!--<script src="<?php //echo base_url();?>assets/vendor/chart.js/Chart.min.js"></script>-->
  <script src="<?php echo base_url();?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- datepicker -->
  <script src="<?php echo base_url();?>assets/js/moment.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap-datepicker.js"></script>
  <script src="<?php echo base_url();?>assets/js/datetimepicker.min.js"></script>
  <!-- Page level custom scripts --> 
  <!--<script src="<?php //echo base_url();?>assets/js/demo/chart-area-demo.js"></script>-->
  <!--<script src="<?php //echo base_url();?>assets/js/demo/chart-pie-demo.js"></script>-->
  <!-- Page level custom scripts -->
  <script src="<?php echo base_url();?>assets/js/demo/datatables-demo.js"></script>

</body>

</html>

<script>
	$(document).ready(function() {
        // Untuk sunting
        $('#ganti-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#iduser').attr("value",div.data('ganti'));
        });
    });

  //cek password 1
  $(document).ready(function() {
      $("#passbaru").on("input", function(e) {
        $('#hitungpass').hide();
        regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^$!%*?&])[A-Za-z\d@#^$!%*?&]{8,20}$/;
        if ($('#passbaru').val() == null || $('#passbaru').val() == "" || $('#passbaru').val().length < 8) {
          $('#hitungpass').show();
          $("#hitungpass").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("tombolpass").disabled = true;
        }
        else if (regex.exec($('#passbaru').val()) == null) {
          $('#hitungpass').show();
          $("#hitungpass").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("tombolpass").disabled = true;
        }
        else
        {
          $('#hitungpass').hide();
          document.getElementById("tombolpass").disabled = false;
        }
      });
    });

  //cek password 2
  $(document).ready(function() {
      $("#verpass").on("input", function(e) {
        $('#hitungpass').hide();
        regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^$!%*?&])[A-Za-z\d@#^$!%*?&]{8,20}$/;
        if ($('#verpass').val() == null || $('#verpass').val() == "" || $('#verpass').val().length < 8) {
          $('#hitungpass').show();
          $("#hitungpass").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("tombolpass").disabled = true;
        }
        else if (regex.exec($('#verpass').val()) == null) {
          $('#hitungpass').show();
          $("#hitungpass").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("tombolpass").disabled = true;
        }
        else if (regex.exec($('#verpass').val()) != null && $('#verpass').val() != $('#passbaru').val()) 
        {
          $('#hitungpass').show();
          $("#hitungpass").html("Verifikasi Password tidak cocok").css("color", "red");
          document.getElementById("tombolpass").disabled = true;
        }
        else
        {
          $('#hitungpass').hide();
          document.getElementById("tombolpass").disabled = false;
        }
      });
    });
</script>
