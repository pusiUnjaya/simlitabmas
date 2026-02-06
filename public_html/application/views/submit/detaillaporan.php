<?php
	// if($this->session->userdata('sesi_status')<>1) {
	// $ceksul = $this->msubmit->cekpengusul($this->uri->segment(3),$this->session->userdata('sesi_id'));
	// $cekrevi = $this->msubmit->cekrevinya($this->uri->segment(3),$this->session->userdata('sesi_id'));
	// // echo $this->db->last_query();exit;
	// if($ceksul==0 && $cekrevi==0)
	// {
	// redirect("submit/laporan");
	// }
	// }
	
?>
<style>
	pre { font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
	font-size: 1rem;
	font-weight: 400;
	line-height: 1.5;
	color: #858796;
	}
</style>
<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Laporan Akhir Penelitian</h1>
	</div>
	<?php
		if($this->session->flashdata('result')<>'')
		{
			echo '<div class="alert alert-success" role="alert">'.
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
					<h6 class="m-0 font-weight-bold text-primary">Unggah Laporan</h6>
				</div>
                <!-- Card Body -->
                <div class="card-body">
					<div class="pt-2 pb-2">
						<div class="row">
							<div class="col-md-12">
								<label>Reviewer</label>
								<?php 
									if($laporan['reviewer']<>'')
									{
										$pisah = explode(',',$laporan['reviewer']);
										$hitpisah = count($pisah);
										echo '<ol>';
										for($i=0;$i<$hitpisah;$i++)
										{
											$revnya = $this->mdosen->namadosen($pisah[$i]);
											echo '<li>'.$revnya['namalengkap'].'</li>';
										}
										echo '</ol>';
									}
									else
									echo '-';
									
									$uploadlaporan = $this->msubmit->sudahlaporan($this->uri->segment(3));
									
									if($uploadlaporan > 0)
									{
										$ceklaporan = $this->msubmit->liatfilelaporan($this->uri->segment(3));
										$filelaporan = $ceklaporan['file_laporan'];
										$upload = $filelaporan;
										$sumber = base_url()."assets/uploadbox/".$upload;
										$link = '<a href="" data-toggle="modal" data-filenya="'.$upload.'" data-jenisfile="File Laporan Akhir" data-target="#liatfile">Lihat Laporan</a>';
									}
									else
									{
										$upload = 'Belum Upload';
										$sumber = '';
										$link = $upload;
									}
									
									$revisilaporan = $this->msubmit->sudahkirimrevisi($this->uri->segment(3));
									
									if($revisilaporan > 0)
									{
										$cekrev = $this->msubmit->liatfilerevisilap($this->uri->segment(3));
										$filerev = $cekrev['file_revisi'];
										$uploadrev = $filerev;
										$sumberrev = base_url()."assets/uploadbox/".$uploadrev;
										$linkrev = '<a href="" data-filenya="'.$uploadrev.'" data-toggle="modal" data-jenisfile="File Revisi Laporan Akhir" data-target="#liatfile">Lihat Revisi Laporan</a>';
									}
									else
									{
										$uploadrev = 'Belum Upload';
										$sumberrev = '';
										$linkrev = $uploadrev;
									}
									
									$laporansah = $this->msubmit->laporansah($this->uri->segment(3));
									
									if($laporansah > 0)
									{
										$cekakhir = $this->msubmit->liatfilelapakhir($this->uri->segment(3));
										$fileakhir = $cekakhir['file_laporan_akhir'];
										$uploadakhir = $fileakhir;
										$sumberakhir = base_url()."assets/uploadbox/".$uploadakhir;
										$linkakhir = '<a href="" data-filenya="'.$uploadakhir.'" data-toggle="modal" data-jenisfile="File Laporan Lengkap" data-target="#liatfile">Lihat Laporan Akhir</a>';
									}
									else
									{
										$uploadakhir = 'Belum Upload';
										$sumberakhir = '';
										$linkakhir = $uploadakhir;
									}
									
									//cek buka submit
									$bukaan = $this->msubmit->cekbuka($this->session->userdata('sesi_id'));
									$cekmaju = $this->msubmit->sudahlaporan($this->uri->segment(3));
									$getRev = explode(',',$laporan['reviewer']);
									if($this->session->userdata('sesi_status')<>1 && !in_array($this->session->userdata('sesi_dosen'),$getRev)) { 
										$hitlapreview = $this->msubmit->hitlapreview($this->uri->segment(3));
										$hitlapakhir = $this->msubmit->hitlapakhir($this->uri->segment(3));
										$revsetuju = $this->msubmit->revsetuju($this->uri->segment(3));
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Proposal</label>
								</div>
								<div class="col-md-8">
									<p><?php echo '<a href="" data-toggle="modal" data-filenya="'.$laporan['filerevisi'].'" data-jenisfile="File Proposal Penelitian" data-target="#liatfile">Lihat Proposal</a>'; ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Kemajuan</label>
								</div>
								<div class="col-md-8">
									<p><?php 
										$maju = $this->msubmit->lihatkemajuan($this->uri->segment(3));
										$filma = '';
										$hitma = count($maju);
										if($hitma>0)
											$filma = $maju['lap_kemajuan'];
										echo '<a href="" data-toggle="modal" ;data-filenya="'.($hitma>0?$maju['lap_kemajuan']:"").'" data-jenisfile="File Laporan Kemajuan" data-target="#liatfile">'.($hitma>0?"Lihat Kemajuan":"Belum Upload").'</a>'; 
									?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Laporan</label>
								</div>
								<div class="col-md-8">
									<p><?php 
										echo $link; 
										echo '&nbsp;&nbsp;';
											if($hitlapreview==0 && ($this->session->userdata('sesi_id')==$laporan['pengusul'] or $this->session->userdata('sesi_status')=="1")) { ?>
											<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-usulan="<?php echo $this->uri->segment(3);?>" data-filelaporan="<?php echo $upload;?>" data-target="#kirim-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload</a>
											<?php } 
											else {
												echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload</a>';
											}
									?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Revisi</label>
								</div>
								<div class="col-md-8">
									<p><?php 
										echo $linkrev; 
										echo '&nbsp;&nbsp;';
										// if($bukaan['status']==1) {
											if($hitlapreview>0) { ?>
											<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-usulan="<?php echo $this->uri->segment(3);?>" data-filerevisi="<?php echo $uploadrev;?>" data-target="#revisi-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Revisi</a>
											<?php } 
											else {
												echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Revisi</a>';
											}
										// } 
									?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>Kirim Laporan Lengkap (Pengesahan dan Semua Lampiran)</label>
								</div>
								<div class="col-md-8">
									<p><?php 
										echo $linkakhir; 
										echo '</p><p>';
										// if($bukaan['status']==1) {
											//if($revsetuju>0) { 
										if($hitlapreview>0 && $sah>0 && ($this->session->userdata('sesi_id')==$laporan['pengusul'] or $this->session->userdata('sesi_status')=="1")) {
										?>
											<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-usulan="<?php echo $this->uri->segment(3);?>" data-filelapakhir="<?php echo $uploadakhir;?>" data-target="#akhir-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload</a>
											<?php } 
											else {
												echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Upload</a>';
											}
										// } 
									?>
									</p>
								</div>
							</div>
							<?php 
							}
							else
							{
							?>
							<div class="row">
								<div class="col-md-4">
									<label>File Proposal</label>
								</div>
								<div class="col-md-8">
									<p><?php echo '<a href="" data-toggle="modal" data-filenya="'.$laporan['filerevisi'].'" data-jenisfile="File Proposal Penelitian" data-target="#liatfile">Lihat Proposal</a>'; ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Kemajuan</label>
								</div>
								<div class="col-md-8">
									<p><?php 
										$maju = $this->msubmit->lihatkemajuan($this->uri->segment(3));
										$filma = '';
										$hitma = count($maju);
										
										echo '<a href="" data-toggle="modal" ;data-filenya="'.($hitma>0?$maju['lap_kemajuan']:"").'" data-jenisfile="File Laporan Kemajuan" '.($hitma>0?'data-target="#liatfile"':'style="  pointer-events: none;color:grey"').'">'.($hitma>0?"Lihat Kemajuan":"Belum Upload").'</a>';  
									?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Laporan</label>
								</div>
								<div class="col-md-8">
									<p><?php 
										echo $link; 
									?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>File Revisi</label>
								</div>
								<div class="col-md-8">
									<p>
										<?php echo $linkrev; ?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label>Kirim Laporan Lengkap (Pengesahan dan Semua Lampiran)</label>
								</div>
								<div class="col-md-8">
									<p><?php echo $linkakhir; ?>
									</p>
								</div>
							</div>
							<?php
							}
							if($this->session->userdata('sesi_status')<>1)
							{
								$id_dosen = $this->mdosen->ambildosen($this->session->userdata('sesi_id'));
								$cekcek = $this->mdosen->isreviewer($id_dosen['id_dosen']);
								
								$reviewernya = $this->mdosen->reviewernya($this->session->userdata('sesi_id'));
								if($cekcek>0 && $reviewernya==0 && $this->session->userdata('sesi_id')<>$laporan['pengusul']) { 
									$hitrevlap = $this->msubmit->hitrevlap($this->uri->segment(3),$this->session->userdata('sesi_id'));
									if($hitrevlap>0)
									{
										$isianreview = $this->msubmit->lihatreviewlaporan($this->uri->segment(3),$this->session->userdata('sesi_id'));
										if($isianreview['skor']==''){
										echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="'.$this->uri->segment(3).'" data-toggle="modal" data-catatan="'.str_replace('"','',$isianreview['hasilreview_laporan']).'" data-skor="'.$isianreview['skor'].'" data-file="'.$isianreview['filereview_laporan'].'" data-target="#reviewer-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <?php echo $nomor; ?></a>';
										}
										else
										{
											echo '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="'.$this->uri->segment(3).'" data-toggle="modal" data-catatan="'.str_replace('"','',$isianreview['hasilreview_laporan']).'" data-skor="'.$isianreview['skor'].'" data-file="'.$isianreview['filereview_laporan'].'" data-target="#perbaikan-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <?php echo $nomor; ?></a>';
										}
									}
									else{
										$cekrevisi = $this->msubmit->sudahrevisi($this->uri->segment(3));
										$akurev = $this->mdosen->cekrevnya($this->session->userdata('sesi_dosen'),$this->uri->segment(3));
										if($akurev>0) {
									?>
									<div class="row" style="margin-top:40px">
										<div class="col-md-6">
											<a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" <?php echo $cekrevisi>0?'data-target="#reviewer-modal"':'data-target="#mintarevisi-modal"'; ?>><i class="fas fa-sticky-note fa-sm text-white-50"></i> Review Laporan</a>
										</div>
									</div>
									<?php 
									} } }
							}
							
						?>
						<!-- Tutup Dulu -->
						<!--
							<div class="row" style="margin-top:40px">
							<div class="col-md-6">
							<?php //if($bukaan['status']==1) {
							//if($hitlapreview==0) { ?>
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-usulan="<?php //echo $this->uri->segment(3);?>" data-filelaporan="<?php //echo $upload;?>" data-target="#kirim-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Kirim Laporan</a>
							<?php 
								// }
								// elseif($hitlapakhir>0 && $usulan['status']<>'Laporan Disetujui Reviewer 2')
								// {
							?>
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-usulan="<?php //echo $this->uri->segment(3);?>" data-filerevisi="<?php //echo $uploadrev;?>" data-target="#revisi-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Revisi Laporan</a>
							<?php
								// }
								// else {
							?>
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-usulan="<?php //echo $this->uri->segment(3);?>" data-filelapakhir="<?php //echo $uploadakhir;?>" data-target="#akhir-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Kirim Laporan Lengkap (Pengesahan dan Semua Lampiran)</a>
							<?php //}} ?>
							</div>
							</div> -->
						<!-- Tutup Dulu -->
						<?php 
							//}
							if(($this->session->userdata('sesi_status')<>1 && $this->session->userdata('sesi_id')==$laporan['pengusul']) || $this->session->userdata('sesi_status')==1) {
								$counthasil = count($usulan);
								if($counthasil>0)
								{
								$hasilreview = $this->msubmit->lihathasilreviewlaporan($usulan['id_usulan']);
								$nomor = 1;
								echo '<div class="row" style="margin-top:40px">';
								foreach($hasilreview as $h) {
									$namarev = $this->mdosen->dosennya($h->reviewer);
								?>
								
								<div class="col-md-6">
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pencet" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-catatan="<?php echo str_replace('"','',$h->hasilreview_laporan); ?>" data-skor="<?php echo $h->skor; ?>" data-file="<?php echo $h->filereview_laporan; ?>" data-reviewer="<?php echo $namarev['namalengkap']; ?>" data-target="#perbaikan-modal"><i class="fas fa-sticky-note fa-sm text-white-50"></i> Hasil Reviewer <br><?php echo $namarev['namalengkap']; ?></a>
								</div>
								
								<?php 
									$nomor++;
								}}
								else
								{
									echo '<div class="row" style="margin-top:40px"><div class="col-md-6"></div>';
								}
								echo '</div>';
							}
							
							$hitlaporanakhir = $this->msubmit->hitlaporanakhir($this->uri->segment(3));
							$hitrevisi = $this->msubmit->hitrevisi($this->uri->segment(3));
							if($hitrevisi>0){
								if($usulan['status']=='Laporan Disetujui Reviewer 1')
								$statrev = '<p>Reviewer 1 Telah Menyetujui Laporan Akhir</p>';
								elseif($usulan['status']=='Laporan Disetujui Reviewer 2')
								$statrev = '<p>Kedua Reviewer Telah Menyetujui Laporan Akhir</p>';
								elseif($usulan['status']=='laporan Tidak Disetujui Reviewer 1')
								$statrev = '<p>Reviewer 1 Tidak Menyetujui Laporan Akhir</p>';
								else
								$statrev = '<p>Belum ada Persetujuan Reviewer</p>';
								
								$cekrev = $this->msubmit->lihatreviewlaporan($usulan['id_usulan'],$this->session->userdata('sesi_id'));
								if($cekrev)
								$namarev = $cekrev['reviewer'];
								else
								$namarev = '';
								// echo $this->db->last_query();
								$sudahcek = $this->msubmit->ceksetuju($usulan['id_usulan']);
								// echo $this->db->last_query();
								if(($setuju>0 || $usulan['status']=='Laporan Disetujui Reviewer 1' || $usulan['status']=='Laporan Tidak Disetujui Reviewer 1') && $this->session->userdata('sesi_id') ==$namarev) {
								?>
								<div class="row" style="margin-top:40px">
									<div class="col-md-12">
										<?php echo $statrev; ?>
										<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#setuju-modal"><i class="fas fa-sticky-note fa-sm text-white"></i> Laporan Akhir Disetujui/Ditolak</a>
									</div>
								</div>
								<?php } 
								if($usulan['file_laporan_akhir']<>'Laporan Disetujui Reviewer 2' && $this->session->userdata('sesi_status')==1) {
								?>
								
								<div class="row" style="margin-top:40px">
									<div class="col-md-12">
										<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#setuju-modal"><i class="fas fa-sticky-note fa-sm text-white"></i> Laporan Disetujui/Ditolak</a>
									</div>
								</div>
							<?php } }?>
					</div>
				</div>
			</div>
            <?php 
            	$merev = '';
            	$lisrev = explode(',',$laporan['reviewer']);
            	if(in_array($this->session->userdata('sesi_dosen'),$lisrev))
            		$merev = 1;
            	else
            		$merev = 0;
            	if($this->session->userdata('sesi_status')==1 || $merev==1) { echo '</div></div>';}
            ?>
		</div>
		
		<!-- Project Card Example -->
		<div class="col-xl-8 col-lg-7">
			<div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Detail Penelitian</h6>
				</div>
                <div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<?php
								if($hitreview>0)
								{
									echo '<div class="alert alert-danger" role="alert"><ul>';
									foreach($hasilreviewnya as $h)
									{
										echo '<li>'.$h->namalengkap.' : <br>'.
											$h->hasilreview_laporan.'</li>';
									}
									if($laporan['valdanamandiri']==0 && $laporan['valdanainternal']==0 && $laporan['valdanaeksternal']==0)
										echo "<li>Silakan Perbaiki Realisasi Dana!!!</li>";
									echo '</ul></div>';
								}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Judul Penelitian</label>
						</div>
						<div class="col-md-8">
							<p><?php echo ucwords(strtolower($laporan['judul'])); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Skema</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $laporan['skema']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Ketua</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php 
									$ketua = $this->mdosen->dosennya($laporan['pengusul']);
									echo $ketua['namalengkap']; 
								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Nomor MoU/MoA</label>
						</div>
						<div class="col-md-8">
							<p>
							<?php 
								echo $laporan['nomorkerjasama'];
							?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Realisasi Dana</label>
							<?php if($this->session->userdata('sesi_id')==$laporan['pengusul']) { ?> 
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-valint="<?php echo ribuankoma($laporan['valdanainternal']);?>" data-vamand="<?php echo ribuankoma($laporan['valdanamandiri']);?>" data-vameks="<?php echo ribuankoma($laporan['valdanaeksternal']);?>" data-vamo="<?php echo $laporan['nomorkerjasama'];?>" data-target="#realisasidana-modal">Edit</a>
						<?php } ?>
						</div>
						<div class="col-md-8">
							<p>
							<?php 
								echo '<ol style="margin-left:-23px;margin-top:-17px">';
								echo '<li>Dana Internal : '.rupiah($laporan['valdanainternal']).'</li>';
								echo '<li>Dana Mandiri : '.rupiah($laporan['valdanamandiri']).'</li>';
								echo '<li>Dana Eksternal : '.rupiah($laporan['valdanaeksternal']).'</li>';
								echo '</ol>';
							?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Anggota Dosen</label>
						</div>
						<div class="col-md-8">
							<p>
							<?php 
								$ambil = explode(',',$laporan['anggotadosen']);
								$hit = count($ambil);
								
								if($laporan['anggotadosen']<>'') 
								{
									if($hit>1)
										echo '<ol style="margin-left:-23px;margin-top:-17px">';
									for($i=0;$i<$hit;$i++)
									{
										$dosen = $this->mdosen->namadosen($ambil[$i]);
										if($hit>1)
											echo '<li>'.$dosen['namalengkap'].'</li>';
										else
											echo $dosen['namalengkap'];
									}
									if($hit>1)
										echo '</ol>';
								}
								else
									echo 'Tidak Ada Anggota Dosen'; 
								
							?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Anggota Mahasiswa</label>
						</div>
						<div class="col-md-8">
							<?php 
								$jumsplit = 0;
								if($laporan['anggotamhs']<>''){
								$split = explode(',',$laporan['anggotamhs']);
								$jumsplit = count($split);
								if($jumsplit>1)
									echo '<ol style="margin-left:-23px">';
								for($i=0;$i<$jumsplit;$i++)
								{
										$namamhs = $this->msubmit->namamhs($split[$i]);
										$prodi = $this->mdosen->namaprodi($namamhs['prodi']);
										if($jumsplit>1)
											echo '<li>'.$namamhs['namamhs'].' ( '.$prodi['prodi'].' )</li>';
										else
											echo $namamhs['namamhs'].' ( '.$prodi['prodi'].' )';
								}}
								if($jumsplit>1)
									echo '</ol>';

							?>		
						</div>
					</div>
					<div class="row">
						<table class="table table-bordered" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th></th>
									<th>Luaran</th>
									<th>Nama Jurnal</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>Target</th>
									<td>
										<?php 
											$pisah = explode(',',$laporan['luaran']);
											$n = count($pisah);
											echo '<ol style="margin-left:-23px;margin-top:-2dc px">';
											for($i=0;$i<$n;$i++)
											{
												echo '<li>'.$pisah[$i].'</li>'; 
											}
											echo '</ol>';
										?>
									</td>
									<td><?php echo $laporan['namajurnal']; ?></td>
								</tr>
								<tr>
									<th>Realisasi</th>
									<td>
										<?php 
											$realjurnal = $this->msubmit->realjurnal($this->uri->segment(3));
											$hitrealjurnal = $this->msubmit->hitrealjurnal($this->uri->segment(3));
											$realhki = $this->msubmit->realhki($this->uri->segment(3));
											$hitrealhki = $this->msubmit->hitrealhki($this->uri->segment(3));
											
											$jenispub = '';
											$jenishaki = '';
											$namajur = '';
											$statushaki = '';
											$tomboljurnal = '';
											$tombolhki = '';
											if($hitrealjurnal>0)
											{
												$jenispub = $realjurnal['jenis_publikasi'];
												$namajur = $realjurnal['nama_jurnal'];
												$tomboljurnal = '<br>Status : '.$realjurnal['status_jurnal'].' <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-filenya="'.$realjurnal['file_jurnal'].'" data-toggle="modal" data-jenisfile="File Luaran Jurnal" data-target="#liatfile"> <i class="fas fa-sticky-note fa-sm text-white-50"></i> Lihat</a>';
											}
											else
											{
												$jenispub = 'Belum Ada';
												$namajur = 'Belum Ada';
												$tomboljurnal = '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"> <i class="fas fa-sticky-note fa-sm text-white-50"></i> Lihat</a>';
											}
											
											if($hitrealhki>0)
											{
												$jenishaki = 'HKI - '.$realhki['jenis_hki'];
												$statushaki = $realhki['status'];
												$tombolhki = '<br>Status : '.$realhki['status'].'<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-hkinya="'.$realhki['file_hki'].'" data-toggle="modal" data-jenishki="File Luaran HKI" data-target="#liathkinya"> <i class="fas fa-sticky-note fa-sm text-white-50"></i>  Lihat</a>';
											}
											else
											{
												$jenishaki = 'Belum Ada';
												$statushaki = 'Belum Ada';
												$tombolhki = '<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"> <i class="fas fa-sticky-note fa-sm text-white-50"></i>  Lihat</a>';
											}
											
											echo '<ol style="margin-left:-23px;margin-top:-2dc px">';
											echo '<li>'.$jenispub.'</li><br>';
											echo '<li>'.$jenishaki.'</li>';
											echo '</ol>';
										?>
									</td>
									<td>
										<?php echo '<ol style="margin-left:-23px;margin-top:-2dc px">'; ?>
										<?php echo '<li>'.$namajur.'&nbsp;&nbsp; '.$tomboljurnal.'</li><br>'; ?>
										<?php echo '<li>'.$statushaki.'&nbsp;&nbsp; '.$tombolhki.'</li>'; ?>
										<?php echo '</ol>'; ?>
									</td>
								</tr>
								<?php
									$rel = $this->msubmit->liatrelevansi();
									$hitrel = count($rel);
								?>
							</tbody>
						</table>
						<table class="table table-bordered" width="100%" cellspacing="0">
							<tr>
								<th></th>
								<th>Mata Kuliah</th>
								<th>Bentuk Integrasi</th>
							</tr>
							<tr>
								<th>Relevansi</th>
								<td><?php if($hitrel>0) echo $rel['matakuliah']; ?></td>
								<td><?php if($hitrel>0)  echo $rel['bentuk_integrasi']; ?></td>
							</tr>
						</table>
						&nbsp;&nbsp;
						<?php if($this->session->userdata('sesi_status')<>1){if($hitrel>0) { ?>
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-relevansi="<?php echo $rel['id_relevansi'].",".$rel['matakuliah'].",".$rel['bentuk_integrasi']; ?>" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#relevansi"><i class="fas fa-sticky-note fa-sm text-white"></i> Relevansi</a>&nbsp;
							<?php } else { ?>
							<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-relevansi="" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#relevansi"><i class="fas fa-sticky-note fa-sm text-white"></i> Relevansi</a>&nbsp;
							<?php
							}}
							if($this->session->userdata('sesi_status')<>1 && !in_array($this->session->userdata('sesi_dosen'),$getRev)) { 
							?>
							<div class="col-md-8">
								<?php //if($bukaan['status']==1){
									if($hitrealjurnal>0){  ?>
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-isianjurnal="<?php echo ucwords(strtolower($realjurnal['judul'])).','.$realjurnal['nama_jurnal'].','.$realjurnal['jenis_publikasi'].','.$realjurnal['peran_penulis'].','.$realjurnal['tahun_publikasi'].','.$realjurnal['volume'].','.$realjurnal['nomor'].','.$realjurnal['hal_awal'].','.$realjurnal['hal_akhir'].','.$realjurnal['url'].','.$realjurnal['issn'].','.$realjurnal['file_jurnal'].','.$realjurnal['status_jurnal']; ?>" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#jurnal"><i class="fas fa-sticky-note fa-sm text-white"></i> Realisasi Jurnal</a>&nbsp;&nbsp;
									<?php } else {  ?>
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-isianjurnal="" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#jurnal"><i class="fas fa-sticky-note fa-sm text-white"></i> Realisasi Jurnal</a>&nbsp;&nbsp;
									<?php } 
									if($hitrealhki>0){ ?>
								<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-isianhki="<?php echo ucwords(strtolower($realhki['judul'])).','.$realhki['jenis_hki'].','.$realhki['tahun_pelaksanaan'].','.$realhki['nomor_pendaftaran'].','.$realhki['status'].','.$realhki['nomor_hki'].','.$realhki['url_dokumen'].','.$realhki['file_hki']; ?>" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#hki"><i class="fas fa-sticky-note fa-sm text-white"></i> Realisasi HKI</a></div>
								<?php } 
								else {
								?>
								<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-isianhki="" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#hki"><i class="fas fa-sticky-note fa-sm text-white"></i> Realisasi HKI</a>
								<?php } 
								}
								 else {
									if($hitrealjurnal>0){
									?>
									<div class="col-md-8"><a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-isianjurnal="<?php echo ucwords(strtolower($realjurnal['judul'])).','.$realjurnal['nama_jurnal'].','.$realjurnal['jenis_publikasi'].','.$realjurnal['peran_penulis'].','.$realjurnal['tahun_publikasi'].','.$realjurnal['volume'].','.$realjurnal['nomor'].','.$realjurnal['hal_awal'].','.$realjurnal['hal_akhir'].','.$realjurnal['url'].','.$realjurnal['issn'].','.$realjurnal['file_jurnal'].','.$realjurnal['status_jurnal']; ?>" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#cekjurnal"><i class="fas fa-sticky-note fa-sm text-white"></i> Cek Realisasi Jurnal</a>&nbsp;&nbsp;
										 <?php }
										if($hitrealhki>0){
										?>
									<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-isianhki="<?php echo ucwords(strtolower($realhki['judul'])).','.$realhki['jenis_hki'].','.$realhki['tahun_pelaksanaan'].','.$realhki['nomor_pendaftaran'].','.$realhki['status'].','.$realhki['nomor_hki'].','.$realhki['url_dokumen'].','.$realhki['file_hki']; ?>" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#cekhki"><i class="fas fa-sticky-note fa-sm text-white"></i> Cek Realisasi HKI</a>
								<?php 
									} 
									} 
								?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="liathkinya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="jenishki">File Laporan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<embed id="hkinya" src="" frameborder="0" width="100%" height="400px"/>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
			
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="liatfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="jenisfile">File Laporan</h5>
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

<!-- Modal -->
<div class="modal fade" id="liatfilerevisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">File Revisi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<embed src="" frameborder="0" width="100%" height="400px"/>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
			
		</div>
	</div>
</div>

<!-- Modal Jurnal -->
<div class="modal fade" id="jurnal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Luaran Penelitian - Jurnal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'submit/simpanjurnal/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="row">
						<div class="form-group col-md-6">
							<input type="hidden" id="idusulan_jurnal" name="id">
							<label>Judul Artikel</label>
							<textarea name="judul" id="juduljurnal" class="form-control jurnal1" placeholder="Judul Artikel" required></textarea>
							<label>Nama Jurnal</label>
							<input type="text" name="namajurnal" class="form-control jurnal2" placeholder="Nama Jurnal" required>
							<label for="recipient-name" class="col-form-label">Jenis Publikasi :</label>
							<select name="jenispublikasi" id="selectjenis" class="form-control jurnal3">
								<?php
									$jenis = array('Jurnal Nasional BerISSN','Jurnal Nasional Terakreditasi 6','Jurnal Nasional Terakreditasi 5','Jurnal Nasional Terakreditasi 4','Jurnal Nasional Terakreditasi 3','Jurnal Nasional Terakreditasi 2','Jurnal Nasional Terakreditasi 1','Jurnal Internasional','Jurnal Internasional Bereputasi');
									$n = count($jenis);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
									}
								?>
							</select>
							<label for="recipient-name" class="col-form-label">Status Jurnal :</label>
							<select name="statusjurnal" id="selectstatus" class="form-control jurnal13">
								<?php
									$statusjurnal = array('Drafted', 'Submitted', 'Accepted', 'Published');
									$n = count($statusjurnal);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$statusjurnal[$i].'">'.$statusjurnal[$i].'</option>';
									}
								?>
							</select>
							<label for="recipient-name" class="col-form-label">Peran Penulis :</label>
							<select name="peranpenulis" id="selectperan" class="form-control jurnal4">
								<?php
									$peran = array('First Author','Co-Author','Corresponding Author');
									$n = count($peran);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
									}
								?>
							</select>
							<label>Tahun Publikasi</label>
							<input type="text" name="tahun" class="form-control jurnal5" placeholder="Tahun Publikasi" required>
						</div>
						<div class='form-group col-md-5'>
							<label>Volume</label>
							<input type="text" name="volume" class="form-control jurnal6" placeholder="Volume" required>
							<label>Nomor</label>
							<input type="text" name="nomor" class="form-control jurnal7" placeholder="Nomor" required>
							<label>Nomor Halaman Awal</label>
							<input type="text" name="awal" class="form-control jurnal8" placeholder="Nomor Halaman Awal" required>
							<label>Nomor Halaman Akhir</label>
							<input type="text" name="akhir" class="form-control jurnal9" placeholder="Nomor Halaman Akhir" required>
							<label>URL Artikel</label>
							<input type="text" name="url" class="form-control jurnal10" placeholder="http://" required>
							<label>E-ISSN/P-ISSN</label>
							<input type="text" name="issn" class="form-control jurnal11" placeholder="ISSN" required>
							<label>File Jurnal (PDF) maksimal 20MB</label>
							<input type="file" name="fileupload" class="form-control unggah" placeholder="File Jurnal (PDF)">
							<label for="recipient-name" class="col-form-label">File Luaran Jurnal : 
							<b class="jurnal12"></b></label>
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-success tmbsimpan">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div> 

<!-- Modal HKI -->
<div class="modal fade" id="hki" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Luaran Penelitian - HKI</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'submit/simpanhki/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="row">
						<div class="form-group col-md-6">
							<input type="hidden" id="idusulan_hki" name="id">
							<label>Judul HKI</label>
							<textarea name="judul" class="form-control hki1" placeholder="Judul HKI" required></textarea>
							<label for="recipient-name" class="col-form-label">Jenis HKI :</label>
							<select name="jenishki" id="selecthki2" class="form-control hki2">
								<?php
									$jenis = array('Paten','Paten Sederhana','Hak Cipta','Merek Dagang','Rahasia Dagang', 'Desain Produk Industri', 'Indikasi Geografis', 'Perlindungan Varietas Tanaman', 'Perlindungan Topografi Sirkuit Terpadu');
									$n = count($jenis);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
									}
								?>
							</select>
							<label for="recipient-name" class="col-form-label">Tahun Pelaksanaan :</label>
							<select name="tahunpelaksanaan" id="selecttahunhki" class="form-control hki3">
								<?php
									$tahun = date('Y');
									for($i=0;$i<=15;$i++)
									{
										echo '<option value="'.($tahun-$i).'">'.($tahun-$i).'</option>';
									}
								?>
							</select>
							<label>Nomor Pendaftaran</label>
							<input type="text" name="nomordaftar" class="form-control hki4" placeholder="Nomor Pendaftaran" required>
						</div>
						<div class="form-group col-md-6">
							<label for="recipient-name" class="col-form-label">Status :</label>
							<select name="status" id="selectstatushki" class="form-control hki5">
								<?php
									$jenis = array('Terdaftar', 'Granted');
									$n = count($jenis);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
									}
								?>
							</select>
							<label>Nomor HKI</label>
							<input type="text" name="nomorhki" class="form-control hki6" placeholder="Nomor HKI" required>
							<label>URL HKI</label>
							<input type="text" name="url" class="form-control hki7" placeholder="http://" required>
							<label>File HKI (PDF) maksimal 20MB</label>
							<input type="file" name="fileupload" class="form-control unggah" placeholder="File HKI (PDF)">
							<label for="recipient-name" class="col-form-label">File Luaran HKI : 
							<b class="hki8"></b></label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-success tmbsimpan">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div> 

<!-- Modal Relevansi -->
<div class="modal fade" id="relevansi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Relevansi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'submit/simpanrelevansi/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
					<div class="row">
						<div class="form-group col-md-12">
							<input type="hidden" id="idrelevansi" name="id">
							<label>Mata Kuliah</label>
							<textarea name="matakuliah" class="form-control matakuliah" placeholder="Mata Kuliah" required></textarea>
							<label class="col-form-label">Bentuk Integrasi :</label>
							<textarea name="integrasi" class="form-control integrasi" placeholder="Bentuk Integrasi" required></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div> 

<!-- Modal Cek Jurnal -->
<div class="modal fade" id="cekjurnal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Luaran Penelitian - Jurnal</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td>Judul Artikel</td>
							<td>
								<b class="cekjurnal1"></b>
							</td>
						</tr>
						<tr>
							<td>Nama Jurnal</td>
							<td>
								<b class="cekjurnal2"></b>
							</td>
						</tr>
						<tr>
							<td>Jenis Publikasi</td>
							<td>
								<b class="cekjurnal3"></b>
							</td>				
						</tr>				
						<tr>
							<td>Peran Penulis</td>
							<td>
								<b class="cekjurnal4"></b>
							</td>
						</tr>
						<tr>
							<td>Tahun Publikasi</td>
							<td>
								<b class="cekjurnal5"></b>
							</td>
						</tr>
						<tr>
							<td>Volume</td>
							<td>
								<b class="cekjurnal6"></b>
							</td>
						</tr>
						<tr>
							<td>Nomor</td>
							<td>
								<b class="cekjurnal7"></b>
							</td>
						</tr>
						<tr>
							<td>Halaman Awal</td>
							<td>
								<b class="cekjurnal8"></b>
							</td>
						</tr>
						<tr>
							<td>Halaman Akhir</td>
							<td>
								<b class="cekjurnal9"></b>
							</td>
						</tr>
						<tr>
							<td>URL</td>
							<td>
								<a href="" id="cekjurnal10" target="_blank"><b class="linkcekjurnal10"></b></a>
							</td>
						</tr>
						<tr>
							<td>ISSN</td>
							<td>
								<b class="cekjurnal11"></b>
							</td>
						</tr>
					</tbody>
				</table>
				<embed id="cekjurnal12" src="" frameborder="0" width="100%" height="400px"/>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div> 

<!-- Modal Cek HKI -->
<div class="modal fade" id="cekhki" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Luaran Penelitian - HKI</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td>Judul</td>
							<td>
								<b class="cekhki1"></b>
							</td>
						</tr>
						<tr>
							<td>Jenis HKI</td>
							<td>
								<b class="cekhki2"></b>
							</td>				
						</tr>				
						<tr>
							<td>Tahun Pelaksanaan</td>
							<td>
								<b class="cekhki3"></b>
							</td>
						</tr>
						<tr>
							<td>Nomor Pendaftaran</td>
							<td>
								<b class="cekhki4"></b>
							</td>
						</tr>
						<tr>
							<td>Status</td>
							<td>
								<b class="cekhki5"></b>
							</td>
						</tr>
						<tr>
							<td>Nomor HKI</td>
							<td>
								<b class="cekhki6"></b>
							</td>
						</tr>
						<tr>
							<td>URL</td>
							<td>
								<a href="" id="cekhki7" target="_blank"><b class="linkcekhki7"></b></a>
							</td>
						</tr>
					</tbody>
				</table>
				<embed id="cekhki8" src="" frameborder="0" width="100%" height="400px"/>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div> 

<!-- Modal Perbaikan -->
<div class="modal fade" id="perbaikan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Hasil Review Laporan Akhir</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Kriteria Penilaian</th>
							<th scope="col">Bobot</th>
							<th scope="col"  width="14%">Skor (1-4)</th>
							<th scope="col">Nilai</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>
								Ketepatan sistematika penulisan dan kesesuaian dengan pedoman laporan akhir penelitian
								<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
									<tr><td>1</td><td>Tidak tepat dalam menuliskan sistematika penulisan dan tidak sesuai dengan pedoman laporan akhir</td></tr>
									<tr><td>2</td><td>Tidak tepat dalam menuliskan sistematika penulisan tetapi sesuai dengan pedoman laporan akhir penelitian</td></tr>
									<tr><td>3</td><td>Tepat dalam menuliskan sistematika penulisan tetapi tidak sesuai dengan pedoman laporan akhir penelitian.</td></tr>
									<tr><td>4</td><td>Tepat dalam menuliskan sistematika penulisan dan sesuai dengan pedoman laporan akhir penelitian.</td></tr>
							</table>
							</td>
							<td><b>10</b></td>
							<td><b class="revskor1"></b></td>
							<td><b class="revnilai1"></b></td>
						</tr>
						<tr>
							<td>2</td>
							<td>
								Ketercapaian Tujuan Penelitian
								<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
									<tr><td>1</td><td>Hasil pembahasan penelitian tidak menjawab tujuan penelitian</td></tr>
									<tr><td>2</td><td>Hasil pembahasan penelitian kurang menjawab tujuan penelitian</td></tr>
									<tr><td>3</td><td>Hasil pembahasan penelitian cukup menjawab tujuan penelitian.</td></tr>
									<tr><td>4</td><td>Hasil pembahasan penelitian menjawab tujuan penelitian.</td></tr>
							</table>
							</td>
							<td><b>20</b></td>
							<td><b class="revskor2"></b></td>
							<td><b class="revnilai2"></b></td>
						</tr>
						<tr>
							<td>3</td>
							<td>
								Kedalaman Pembahasan Penelitian
								<table class="table table-bordered">
									<tr><th>Skor</th><th>Keterangan</th></tr>
										<tr><td>1</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian tidak mendalam</td></tr>
										<tr><td>2</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian kurang mendalam</td></tr>
										<tr><td>3</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian cukup mendalam.</td></tr>
										<tr><td>4</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian mendalam.</td></tr>
								</table>
							</td>
							<td><b>20</b></td>
							<td><b class="revskor3"></b></td>
							<td><b class="revnilai3"></b></td>
						</tr>				
						<tr>
							<td>4</td>
							<td>
								Potensi keberlanjutan hasil penelitian :<br>
								<ol type="a">
									<li>Pendukung Pembelajaran</li>
									<li>Pengembangan Penelitian</li>
									<li>Pengabdian kepada Masyarakat</li>
								</ol>
								<table class="table table-bordered">
									<tr><th>Skor</th><th>Keterangan</th></tr>
										<tr><td>1</td><td>Hasil penelitian tidak berpotensi dalam mendukung pembelajaran, pengembangan penelitian, dan Pengabdian kepada Masyarakat</td></tr>
										<tr><td>2</td><td>Hasil penelitian mampu mendukung pembelajaran atau Pengabdian kepada Masyarakat tetapi tidak mendukung pengembangan penelitian</td></tr>
										<tr><td>3</td><td>Hasil penelitian mampu mengembangkan penelitian tetapi tidak mendukung untuk pembelajaran dan Pengabdian kepada Masyarakat</td></tr>
										<tr><td>4</td><td>Hasil penelitian berlanjut untuk pengembangan penelitian, Pengabdian kepada Masyarakat, dan berlanjut untuk pendukung pembelajaran.</td></tr>
								</table>
							</td>
							<td><b>20</b></td>
							<td><b class="revskor4"></b></td>
							<td><b class="revnilai4"></b></td>
						</tr>
						<tr>
							<td>5</td>
							<td>
								Kesesuaian Luaran penelitian dengan rencana di proposal
								<table class="table table-bordered">
									<tr><th>Skor</th><th>Keterangan</th></tr>
										<tr><td>1</td><td>Luaran penelitian tidak sesuai dengan rencana di proposal penelitian</td></tr>
										<tr><td>2</td><td>Luaran penelitian kurang sesuai (akreditasi jurnal yang disubmit, dibawah dari akreditasi jurnal yang diusulkan)</td></tr>
										<tr><td>3</td><td>Luaran penelitian cukup sesuai (nama jurnal yang disubmit tidak sesuai dengan yang diusulkan tetapi memiliki akreditasi jurnal yang sama)</td></tr>
										<tr><td>4</td><td>Luaran penelitian sesuai dengan rencana di proposal penelitian.</td></tr>
								</table>
							</td>
							<td><b>30</b></td>
							<td><b class="revskor5"></b></td>
							<td><b class="revnilai5"></b></td>
						</tr>
						<tr>
							<td colspan="2">Jumlah Nilai (Batas Nilai Lulus 70)</td>
							<td><b>100</b></td>
							<td></td>
							<td><b class="revtotalnilai"></b></td>
						</tr>
					</tbody>
				</table>
				<?php 
					//if($this->session->userdata('sesi_status')==1) {
					echo '<b>Nama Reviewer :</b><p class="reviewer"></p>';
					//}
				?>
				<b>Catatan dari Reviewer :</b><pre><p class="catatan"></p></pre>
				<?php if($hitlaporanakhir>0) { ?>
					<b>Silakan Download File Hasil Review</b><p id="tautanfile"></p>
					<form name="kirimrevisi" method="post" action="<?php echo base_url().'submit/simpanperbaikanlap/'.$usulan['id_usulan']; ?>" enctype="multipart/form-data">
						<?php if($this->session->userdata('sesi_id')==$laporan['pengusul'] && ($laporan['filerevisi']=='' || $laporan['status']=='Reviewed')) { ?>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">File Revisi *: <b style="color:red" id="rednotis"></b></label>
								<input type="file" name="revisi" id="inputrevisi" class="form-control unggah" required>
							</div>
						<?php } }?>
				</div>
				<div class="modal-footer">
					<?php if($this->session->userdata('sesi_id')==$laporan['pengusul'] && ($laporan['filerevisi']=='' || $laporan['status']=='Reviewed')) { ?>
						<button type="button" id="tombolrevisi" onclick="cekup()" class="btn btn-primary" style="color:white">Kirim Revisi</button>
						<?php 
						}
						echo '</form>';
						if($hitlaporanakhir>0){
							$lihat = $this->msubmit->lihatisianreview($usulan['id_usulan'],$this->session->userdata('sesi_id'));
							$hitlihat = count($lihat);
							if($hitlihat > 0 && $this->session->userdata('sesi_id')==$lihat['reviewer'] && ($usulan['status']<>'Usulan Disetujui' || $usulan['status']<>'Usulan Tidak Disetujui')) { ?>
							<a href="<?php echo base_url().'submit/editreviewlaporan/'.$this->uri->segment(3); ?>" type="button" class="btn btn-warning" style="color:white">Edit Review</a>
						<?php } }?>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div> 

<!-- Modal Minta Revisi -->
<div class="modal fade" id="mintarevisi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Hasil Review Laporan Akhir</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php 
					//if($this->session->userdata('sesi_status')==1) {
					//echo '<b>Nama Reviewer :</b><p class="reviewer"></p>';
					//}
				?>
				<form method="post" action="<?php echo base_url().'submit/mintarevisilaporan/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
				<input type="hidden" id="mintarevisi" name="id">
					<div class="form-group">
							<label for="recipient-name" class="col-form-label">Hasil Review:</label>
							<textarea rows="5" name="review" class="form-control" id="review" required></textarea>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Review:</label>
							<input type="file" name="hasilreview" class="form-control unggah">
						</div>
				</div>
				<div class="modal-footer">
						<input type="submit" class="btn btn-success" style="color:white" value="Simpan Review">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<?php echo '</form>';?>
				</div>
			</div>
		</div>
	</div> 
	
	<!-- Modal Persetujuan -->
	<div class="modal fade" id="setuju-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Laporan Disetujui/Tidak</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php echo base_url().'submit/simpansetujulaporan/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Laporan Disetujui/Tidak :</label>
							<select name="setuju" class="form-control">
								<?php
									if($hitlaporanakhir>0){
										if($this->session->userdata('sesi_status')==1 && $usulan['status']=='Laporan Disetujui Reviewer 2')
										$jenis = array('Laporan Disetujui','Laporan Tidak Disetujui');
										elseif($this->session->userdata('sesi_status')<>1 && $usulan['status']=='Laporan Disetujui Reviewer 1')
										$jenis = array('Laporan Disetujui Reviewer 2','Laporan Tidak Disetujui Reviewer 2');
										else
										$jenis = array('Laporan Disetujui Reviewer 1','Laporan Tidak Disetujui Reviewer 1');
									}	
									$n = count($jenis);
									for($i=0;$i<$n;$i++)
									{
										echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-success">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div> 
	
	<!-- Modal Reviewer -->
	<div class="modal fade" id="reviewer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tuliskan Penilaian Laporan Akhir Penelitian</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php echo base_url().'submit/simpanreviewlaporan/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Kriteria Penilaian</th>
									<th scope="col">Bobot</th>
									<th scope="col"  width="14%">Skor (1-4)</th>
									<th scope="col">Nilai</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>
										Ketepatan sistematika penulisan dan kesesuaian dengan pedoman laporan akhir penelitian
										<table class="table table-bordered">
										<tr><th>Skor</th><th>Keterangan</th></tr>
											<tr><td>1</td><td>Tidak tepat dalam menuliskan sistematika penulisan dan tidak sesuai dengan pedoman laporan akhir</td></tr>
											<tr><td>2</td><td>Tidak tepat dalam menuliskan sistematika penulisan tetapi sesuai dengan pedoman laporan akhir penelitian</td></tr>
											<tr><td>3</td><td>Tepat dalam menuliskan sistematika penulisan tetapi tidak sesuai dengan pedoman laporan akhir penelitian.</td></tr>
											<tr><td>4</td><td>Tepat dalam menuliskan sistematika penulisan dan sesuai dengan pedoman laporan akhir penelitian.</td></tr>
									</table>
									</td>
									<td><b id="skor1">10</b></td>
									<td>
										<input type="hidden" id="reviewidusulanya" name="id">
										<input type="text" name="poinsatu" data-poin="10" onkeyup="satu(value)" class="form-control rev" required>
									</td>
									<td><b id="nilai1">0</b></td>
								</tr>
								<tr>
									<td>2</td>
									<td>
										Ketercapaian Tujuan Penelitian
										<table class="table table-bordered">
											<tr><th>Skor</th><th>Keterangan</th></tr>
												<tr><td>1</td><td>Hasil pembahasan penelitian tidak menjawab tujuan penelitian</td></tr>
												<tr><td>2</td><td>Hasil pembahasan penelitian kurang menjawab tujuan penelitian</td></tr>
												<tr><td>3</td><td>Hasil pembahasan penelitian cukup menjawab tujuan penelitian.</td></tr>
												<tr><td>4</td><td>Hasil pembahasan penelitian menjawab tujuan penelitian.</td></tr>
										</table>
									</td>
									<td><b id="skor2">20</b></td>
									<td><input type="text" name="poindua" data-poin="20" onkeyup="dua(value)" class="form-control rev" required></td>
									<td><b id="nilai2">0</b></td>
								</tr>
								<tr>
									<td>3</td>
									<td>
										Kedalaman Pembahasan Penelitian
										<table class="table table-bordered">
											<tr><th>Skor</th><th>Keterangan</th></tr>
												<tr><td>1</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian tidak mendalam</td></tr>
												<tr><td>2</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian kurang mendalam</td></tr>
												<tr><td>3</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian cukup mendalam.</td></tr>
												<tr><td>4</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian mendalam.</td></tr>
										</table>
									</td>
									<td><b id="skor3">20</b></td>
									<td><input type="text" name="pointiga" data-poin="20" onkeyup="tiga(value)" class="form-control rev" required></td>
									<td><b id="nilai3">0</b></td>
								</tr>				
								<tr>
									<td>4</td>
									<td>
										Potensi keberlanjutan hasil penelitian :<br>
										<ol type="a">
											<li>Pendukung Pembelajaran</li>
											<li>Pengembangan Penelitian</li>
											<li>Pengabdian kepada Masyarakat</li>
										</ol>
										<table class="table table-bordered">
										<tr><th>Skor</th><th>Keterangan</th></tr>
											<tr><td>1</td><td>Hasil penelitian tidak berpotensi dalam mendukung pembelajaran, pengembangan penelitian, dan Pengabdian kepada Masyarakat</td></tr>
											<tr><td>2</td><td>Hasil penelitian mampu mendukung pembelajaran atau Pengabdian kepada Masyarakat tetapi tidak mendukung pengembangan penelitian</td></tr>
											<tr><td>3</td><td>Hasil penelitian mampu mengembangkan penelitian tetapi tidak mendukung untuk pembelajaran dan Pengabdian kepada Masyarakat</td></tr>
											<tr><td>4</td><td>Hasil penelitian berlanjut untuk pengembangan penelitian, Pengabdian kepada Masyarakat, dan berlanjut untuk pendukung pembelajaran.</td></tr>
									</table>
									</td>
									<td><b id="skor4">20</b></td>
									<td><input type="text" name="poinempat" data-poin="20" onkeyup="empat(value)" class="form-control rev" required></td>
									<td><b id="nilai4">0</b></td>
								</tr>
								<tr>
									<td>5</td>
									<td>
										Kesesuaian Luaran penelitian dengan rencana di proposal
										<table class="table table-bordered">
											<tr><th>Skor</th><th>Keterangan</th></tr>
												<tr><td>1</td><td>Luaran penelitian tidak sesuai dengan rencana di proposal penelitian</td></tr>
												<tr><td>2</td><td>Luaran penelitian kurang sesuai (akreditasi jurnal yang disubmit, dibawah dari akreditasi jurnal yang diusulkan)</td></tr>
												<tr><td>3</td><td>Luaran penelitian cukup sesuai (nama jurnal yang disubmit tidak sesuai dengan yang diusulkan tetapi memiliki akreditasi jurnal yang sama)</td></tr>
												<tr><td>4</td><td>Luaran penelitian sesuai dengan rencana di proposal penelitian.</td></tr>
										</table>
									</td>
									<td><b id="skor5">30</b></td>
									<td><input type="text" name="poinlima" data-poin="30" onkeyup="lima(value)" class="form-control rev" required></td>
									<td><b id="nilai5">0</b></td>
								</tr>
								<tr>
									<td colspan="2">Jumlah Nilai (Batas Nilai Lulus 70)</td>
									<td><b>100</b></td>
									<td></td>
									<td><b id="jmlnilai">0</b></td>
								</tr>
							</tbody>
						</table>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Hasil Review:</label>
							<input type="hidden" name="id" class="form-control" id="idusulanya">
							<textarea rows="5" name="review" class="form-control" id="review" required></textarea>
						</div>
						<!--<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Review:</label>
							<input type="file" name="hasilreview" class="form-control unggah" id="hasilreview">
						</div>-->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" id="tmbsimpan" class="btn btn-success tmbsimpan">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div> 
	
	<!-- Modal Kirim Laporan -->
	<div class="modal fade" id="kirim-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Upload Laporan Akhir</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php echo base_url().'submit/simpanlaporan/'; ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Validasi Dana Internal :</label>
							<input type="hidden" id="identitas" name="idus" class="form-control" value="<?=$laporan['id_usulan']; ?>">
							<input type="text" id="danainternal" name="danaint" class="form-control number-input" placeholder="Jumlah Dana Internal" required>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Validasi Dana Mandiri :</label>
							<input type="text" id="danamandiri" name="danaman" class="form-control number-input" placeholder="Jumlah Dana Mandiri" required>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Validasi Dana Eksternal :</label>
							<input type="text" id="danaeksternal" name="danaeks" class="form-control number-input" placeholder="Jumlah Dana Eksternal" required>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Nomor MoU/MoA :</label>
							<input type="text" id="kerjasama" name="kerjasama" class="form-control" placeholder="Nomor MoU/MoA">
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Laporan Akhir (PDF) maksimal 40Mb :</label>
							<input type="hidden" id="kirimidusulanya" name="id">
							<input type="file" id="fileakhir" name="fileupload" class="form-control" placeholder="File Usulan (PDF)">
							<label for="recipient-name" class="col-form-label">File Laporan Akhir : 
							<b id="cekupload"></b></label>
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" id="tmblap" class="btn btn-success">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div> 

	<!-- Modal Edit Realisasi Dana -->
	<div class="modal fade" id="realisasidana-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Realisasi Dana</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php echo base_url().'submit/simpanrealisasidana/'; ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Validasi Dana Internal :</label>
							<input type="hidden" name="idus" class="form-control" value="<?=$laporan['id_usulan']; ?>">
							<input type="text" id="valint" name="danaint" class="form-control number-input" placeholder="Jumlah Dana Internal" required>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Validasi Dana Mandiri :</label>
							<input type="text" id="vamand" name="danaman" class="form-control number-input" placeholder="Jumlah Dana Mandiri" required>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Validasi Dana Eksternal :</label>
							<input type="text" id="vameks" name="danaeks" class="form-control number-input" placeholder="Jumlah Dana Eksternal" required>
						</div>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Nomor MoU/MoA :</label>
							<input type="text" id="vamo" name="kerjasama" class="form-control" placeholder="Nomor MoU/MoA">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" id="tmblap" class="btn btn-success">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Modal Kirim Laporan Akhir dengan Pengesahan -->
	<div class="modal fade" id="akhir-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Upload Laporan Akhir dengan Pengesahan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php echo base_url().'submit/simpanlaporanakhir/'; ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Laporan Akhir (PDF) maksimal 40Mb :</label>
							<input type="hidden" id="akhiridusulanya" name="id">
							<input type="file" id="laporanakhir" name="fileupload" class="form-control" placeholder="File Usulan (PDF)">
							<label for="recipient-name" class="col-form-label">File Laporan Akhir : 
							<b id="cekupload"></b></label>
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" id="tmbakhir" class="btn btn-success">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div> 
	
	<!-- Modal Kirim Revisi Laporan -->
	<div class="modal fade" id="revisi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Upload Revisi Laporan Akhir</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" action="<?php echo base_url().'submit/simpanrevisilaporan/'; ?>" enctype="multipart/form-data">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">File Revisi Laporan Akhir (PDF) maksimal 40Mb :</label>
							<input type="hidden" id="revisiidusulanya" name="id">
							<input type="file" id="revfileakhir" name="fileupload" class="form-control" placeholder="File Usulan (PDF)">
							<label for="recipient-name" class="col-form-label">File Revisi Laporan Akhir : 
							<b id="cekupload"></b></label>
							
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" id="tmbrevisi" class="btn btn-success">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div> 
	
	<script>
		function formatNumberInput(input) {
	        input.addEventListener("input", function(event) {
	            let value = event.target.value.replace(/,/g, ''); // Remove existing commas
	            if (!isNaN(value) && value !== "") {
	                event.target.value = parseInt(value).toLocaleString(); // Format with thousand separator
	            } else {
	                event.target.value = ""; // Clear if not a number
	            }
	        });

	        input.addEventListener("keypress", function(event) {
	            if (!/[0-9]/.test(event.key)) {
	                event.preventDefault();
	            }
	        });
	    }

	    // Apply the function to all inputs with the class "number-input"
	    document.querySelectorAll('.number-input').forEach(function(input) {
	        formatNumberInput(input);
	    });

		function satu(ish){
			document.getElementById("nilai1").innerHTML = 10*ish;
		}
		
		function dua(ish){
			document.getElementById("nilai2").innerHTML = 10*ish;
		}
		
		function tiga(ish){
			document.getElementById("nilai3").innerHTML = 10*ish;
		}
		
		function empat(ish){
			document.getElementById("nilai4").innerHTML = 20*ish;
		}
		
		function lima(ish){
			document.getElementById("nilai5").innerHTML = 30*ish;
		}
		
		function cekup()
		{
			var notif = document.getElementById('rednotis');
			var file = document.getElementById("inputrevisi");
			
			if(file.files.length == 0 ){
				document.getElementById("tombolrevisi").type = 'button';
				notif.innerHTML = "No files selected";
				} else {
				notif.innerHTML = "";
				document.getElementById("tombolrevisi").type = 'submit';
			}
		}
		
		$('.modal-body').on('input',function() {
			var totalSum = 0;
			
			$('.modal-body .rev').each(function() {
				var inputVal = $(this).val();
				var inputSkor = $(this).data('poin');
				var year = <?php echo date('Y', strtotime($laporan['modified'])); ?>;
				if($.isNumeric(inputVal) && year>=2023){
					totalSum += parseFloat((inputVal*inputSkor)/4);
				}
				else
				{
					totalSum += parseFloat((inputVal*inputSkor)/7);	
				}
			});
			document.getElementById("jmlnilai").innerHTML = totalSum.toFixed(4);
		});
		
		$(document).on("click", ".pencet", function () {
			var catatan = $(this).data('catatan');
			var reviewer = $(this).data('reviewer');
			var file = $(this).data('file');
			var skor = $(this).data('skor');
			var skorarray = skor.split(',');
			var year = <?php echo date('Y', strtotime($laporan['modified'])); ?>;
			var month = <?php echo date('m', strtotime($usulan['modified'])); ?>;

		 	if(year>=2023 && (year<=2024 && month<5))
				var total = ((skorarray[0]*10)+(skorarray[1]*20)+(skorarray[2]*20)+(skorarray[3]*20)+(skorarray[4]*30))/4;
			else if(year<=2024 && month<5)
				var total = ((skorarray[0]*10)+(skorarray[1]*10)+(skorarray[2]*10)+(skorarray[3]*10)+(skorarray[4]*10)+(skorarray[5]*10)+(skorarray[6]*10)+(skorarray[7]*10)+(skorarray[8]*10)+(skorarray[9]*30))/4;
			else
				var total = ((skorarray[0]*10)+(skorarray[1]*20)+(skorarray[2]*20)+(skorarray[3]*20)+(skorarray[4]*30))/4;
			
			$(".modal-body .revskor1").text( skorarray[0] );
			$(".modal-body .revnilai1").text( 10*skorarray[0] );
			$(".modal-body .revskor2").text( skorarray[1] );
			$(".modal-body .revnilai2").text( 10*skorarray[1] );
			$(".modal-body .revskor3").text( skorarray[2] );
			$(".modal-body .revnilai3").text( 10*skorarray[2] );
			$(".modal-body .revskor4").text( skorarray[3] );
			$(".modal-body .revnilai4").text( 10*skorarray[3] );
			$(".modal-body .revskor5").text( skorarray[4] );
			$(".modal-body .revnilai5").text( 10*skorarray[4] );
			$(".modal-body .revskor6").text( skorarray[5] );
			$(".modal-body .revnilai6").text( 10*skorarray[5] );
			$(".modal-body .revskor7").text( skorarray[6] );
			$(".modal-body .revnilai7").text( 10*skorarray[6] );
			$(".modal-body .revskor8").text( skorarray[7] );
			$(".modal-body .revnilai8").text( 10*skorarray[7] );
			$(".modal-body .revskor9").text( skorarray[8] );
			$(".modal-body .revnilai9").text( 10*skorarray[8] );
			$(".modal-body .revskor10").text( skorarray[9] );
			$(".modal-body .revnilai10").text( 10*skorarray[9] );
			$(".modal-body .revtotalnilai").text( total.toFixed(4) );
			$(".modal-body .reviewer").text( reviewer );
			$(".modal-body .catatan").text( catatan );
			if(file!='')
			{
				var str = "Download File";
				var result = str.link("https://simlitabmas.unjaya.ac.id/assets/uploadbox/"+file);
			}
			else
			{
				var str = "Tidak Ada File";
				var result = str.link('#');
			}
			document.getElementById("tautanfile").innerHTML = result;
		});
		
		$(document).ready(function() {
			$('#reviewer-modal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#reviewidusulanya').attr("value",div.data('usulan'));
				modal.find('#review').val(div.data('catatan'));
			});
		});
		
		$(document).ready(function() {
			$('#jurnal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#idusulan_jurnal').attr("value",div.data('usulan'));
				
				var isianjurnal = div.data('isianjurnal');
				if(isianjurnal!=''){
					var jurnalarray = isianjurnal.split(',');
					
					var jid = document.getElementById('selectjenis');
					for (var i = 0; i < jid.options.length; ++i) {
						if (jid.options[i].text === jurnalarray[2])
						jid.options[i].selected = true;
					}
					
					var pid = document.getElementById('selectperan');
					for (var i = 0; i < pid.options.length; ++i) {
						if (pid.options[i].text === jurnalarray[3])
						pid.options[i].selected = true;
					}
					
					var sid = document.getElementById('selectstatus');
					for (var i = 0; i < sid.options.length; ++i) {
						if (sid.options[i].text === jurnalarray[12])
						sid.options[i].selected = true;
					}
					
					$(".modal-body .jurnal1").text( jurnalarray[0] );
					modal.find('.jurnal2').attr("value", jurnalarray[1]);
					modal.find('.jurnal5').attr("value", jurnalarray[4]);
					modal.find('.jurnal6').attr("value", jurnalarray[5]);
					modal.find('.jurnal7').attr("value", jurnalarray[6]);
					modal.find('.jurnal8').attr("value", jurnalarray[7]);
					modal.find('.jurnal9').attr("value", jurnalarray[8]);
					modal.find('.jurnal10').attr("value", jurnalarray[9]);
					modal.find('.jurnal11').attr("value", jurnalarray[10]);
					modal.find('.jurnal12').html(jurnalarray[11]);
				}
			});
		});
		
		$(document).ready(function() {
			$('#cekjurnal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				var isianjurnal = div.data('isianjurnal');
				var jurnalarray = isianjurnal.split(',');
				
				$(".modal-body .cekjurnal1").text( jurnalarray[0] );
				$(".modal-body .cekjurnal2").text( jurnalarray[1] );
				$(".modal-body .cekjurnal3").text( jurnalarray[2] );
				$(".modal-body .cekjurnal4").text( jurnalarray[3] );
				$(".modal-body .cekjurnal5").text( jurnalarray[4] );
				$(".modal-body .cekjurnal6").text( jurnalarray[5] );
				$(".modal-body .cekjurnal7").text( jurnalarray[6] );
				$(".modal-body .cekjurnal8").text( jurnalarray[7] );
				$(".modal-body .cekjurnal9").text( jurnalarray[8] );
				//$(".modal-body .cekjurnal10").text( jurnalarray[9] );
				$(".modal-body .cekjurnal11").text( jurnalarray[10] );
				
				$(".modal-body .linkcekjurnal10").text( jurnalarray[9] );
				
				var link = document.getElementById("cekjurnal10");
				link.setAttribute("href",jurnalarray[9]);
				
				var sumber = document.getElementById("cekjurnal12");
				sumber.setAttribute("src",'https://simlitabmas.unjaya.ac.id/assets/uploadbox/'+jurnalarray[11]);
			});
		});
		
		$(document).ready(function() {
			$('#cekhki').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				var isianhki = div.data('isianhki');
				if(isianhki!=''){
					var hkiarray = isianhki.split(',');
					
					$(".modal-body .cekhki1").text( hkiarray[0] );
					$(".modal-body .cekhki2").text( hkiarray[1] );
					$(".modal-body .cekhki3").text( hkiarray[2] );
					$(".modal-body .cekhki4").text( hkiarray[3] );
					$(".modal-body .cekhki5").text( hkiarray[4] );
					$(".modal-body .cekhki6").text( hkiarray[5] );
					$(".modal-body .linkcekhki7").text( hkiarray[6] );
					
					var link = document.getElementById("cekhki7");
					link.setAttribute("href",hkiarray[6]);
					
					var sumber = document.getElementById("cekhki8");
					sumber.setAttribute("src",'https://simlitabmas.unjaya.ac.id/assets/uploadbox/'+hkiarray[7]);
				}
			});
		});
		
		$(document).ready(function() {
			$('#liatfile').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				var sumber = document.getElementById("filenya");
				sumber.setAttribute("src","https://simlitabmas.unjaya.ac.id/assets/uploadbox/"+div.data('filenya'));
				
				modal.find('#jenisfile').html(div.data('jenisfile'));
			});
		});
		
		$(document).ready(function() {
			$('#liathkinya').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				var sumber = document.getElementById("hkinya");
				sumber.setAttribute("src","https://simlitabmas.unjaya.ac.id/assets/uploadbox/"+div.data('hkinya'));
				
				modal.find('#jenishki').html(div.data('jenishki'));
			});
		});

		$(document).ready(function() {
			$('#realisasidana-modal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				modal.find('#valid').attr("value",div.data('idusulan'));
				modal.find('#valint').attr("value",div.data('valint'));
				modal.find('#vamand').attr("value",div.data('vamand'));
				modal.find('#vameks').attr("value",div.data('vameks'));
				modal.find('#vamo').attr("value",div.data('vamo'));
			});
		});
		
		$(document).ready(function() {
			$('#hki').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#idusulan_hki').attr("value",div.data('usulan'));
				
				var isianhki = div.data('isianhki');
				if(isianhki!=''){
					var hkiarray = isianhki.split(',');
					
					var eid = document.getElementById('selecthki2');
					for (var i = 0; i < eid.options.length; ++i) {
						if (eid.options[i].text === hkiarray[1])
						eid.options[i].selected = true;
					}
					
					var tid = document.getElementById('selecttahunhki');
					for (var i = 0; i < tid.options.length; ++i) {
						if (tid.options[i].text === hkiarray[2])
						tid.options[i].selected = true;
					}
					
					var sid = document.getElementById('selectstatushki');
					for (var i = 0; i < sid.options.length; ++i) {
						if (sid.options[i].text === hkiarray[4])
						sid.options[i].selected = true;
					}
					
					$(".modal-body .hki1").text( hkiarray[0] );
					modal.find('.hki4').attr("value", hkiarray[3]);
					modal.find('.hki6').attr("value", hkiarray[5]);
					modal.find('.hki7').attr("value", hkiarray[6]);
					modal.find('.hki8').html(hkiarray[7]);
				}
			});
		});
		
		$(document).ready(function() {
			$('#kirim-modal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#kirimidusulanya').attr("value",div.data('usulan'));
				modal.find('#cekupload').html(div.data('filelaporan'));
			});
		});
		
		$(document).ready(function() {
			$('#relevansi').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this);
				
				// Isi nilai pada field
				var relevansi = div.data('relevansi');
				if(relevansi!='')
				{
					var relarray = relevansi.split(',');
					
					modal.find('#idrelevansi').attr("value", relarray[0]);
					$(".modal-body .matakuliah").text( relarray[1] );
					$(".modal-body .integrasi").text( relarray[2] );
				}
			});
		});
		
		$(document).ready(function() {
			$('#akhir-modal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#akhiridusulanya').attr("value",div.data('usulan'));
				modal.find('#cekupload').html(div.data('filelapakhir'));
			});
		});
		
		$(document).ready(function() {
			$('#revisi-modal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#revisiidusulanya').attr("value",div.data('usulan'));
				modal.find('#cekupload').html(div.data('filerevisi'));
			});
		});

		$(document).ready(function() {
			$('#mintarevisi-modal').on('show.bs.modal', function (event) {
				var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
				var modal = $(this)
				
				// Isi nilai pada field
				modal.find('#mintarevisi').attr("value",div.data('usulan'));
			});
		});
		
		$('#hki').on('hidden.bs.modal', function () {
			$('#hki form')[0].reset();
		});
		
		$('#jurnal').on('hidden.bs.modal', function () {
			$('#jurnal form')[0].reset();
		});
		
		$('.unggah').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$(".tmbsimpan").attr('disabled', true);
		}
		else if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			$(".tmbsimpan").attr('disabled', true);
			return false;
		}
		else if(extension=='pdf' && ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$(".tmbsimpan").attr('disabled', true);
		}
		else
		{
			$(".tmbsimpan").attr('disabled', false);
		}
	});
	
	$('#fileakhir').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmblap").attr('disabled', true);
		}
		else if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			$("#tmblap").attr('disabled', true);
			return false;
		}
		else if(extension=='pdf' && ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmblap").attr('disabled', true);
		}
		else
		{
			$("#tmblap").attr('disabled', false);
		}
	});
	
	$('#revfileakhir').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmbrevisi").attr('disabled', true);
		}
		else if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			$("#tmbrevisi").attr('disabled', true);
			return false;
		}
		else if(extension=='pdf' && ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmbrevisi").attr('disabled', true);
		}
		else
		{
			$("#tmbrevisi").attr('disabled', false);
		}
	});
	
	$('#laporanakhir').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmbakhir").attr('disabled', true);
		}
		else if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			$("#tmbakhir").attr('disabled', true);
			return false;
		}
		else if(extension=='pdf' && ukuran>40)
		{
			alert('Ukuran File Lebih dari batas maksimal 40MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmbakhir").attr('disabled', true);
		}
		else
		{
			$("#tmbakhir").attr('disabled', false);
		}
	});

	var danaint = document.getElementById('danainternal');
	danaint.addEventListener('keyup', function(e)
	{
		danaint.value = formatRupiah(this.value);
	});
	
	danaint.addEventListener('keydown', function(event)
	{
		limitCharacter(event);
	});

	var danaman = document.getElementById('danamandiri');
	danaman.addEventListener('keyup', function(e)
	{
		danaman.value = formatRupiah(this.value);
	});
	
	danaman.addEventListener('keydown', function(event)
	{
		limitCharacter(event);
	});

	var danaeks = document.getElementById('danaeksternal');
	danaeks.addEventListener('keyup', function(e)
	{
		danaeks.value = formatRupiah(this.value);
	});
	
	danaeks.addEventListener('keydown', function(event)
	{
		limitCharacter(event);
	});
		
	</script>
