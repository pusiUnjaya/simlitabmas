<div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Usulan</h1>
			</div>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-md-8">
						  <h6 id="daftarpenelitian" class="m-0 font-weight-bold text-primary">Daftar Usulan Pengabdian</h6>
						</div>
						<div class="col-md-4 float-right">
						<?php if($this->session->userdata('sesi_status')==1) { ?>
						<a href="<?php echo site_url().'surat/eksporkontrakpkm/'.date('Y').'/semua'; ?>" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-file-excel fa-sm text-white-50"></i> Rekap Surat Kontrak</a>
						<form class="user col-md-4 float-right" action="<?php echo base_url(); ?>surat/nomorpengabdian" method="post">
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
					<table class="table display table-bordered" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Data Usulan</th>
						  <th width="18%"></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							foreach($usulanpkm as $p)
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
							
							$tugas = '';
							$kontrak = '';
							if($p->nomortugas<>'')
								$tugas = $p->nomortugas;
							else
								$tugas = ' - ';
							
							if($p->nomorkontrak<>'')
								$kontrak = $p->nomorkontrak;
							else
								$kontrak = ' - ';
							
								$ketua = $this->mdosen->dosennya($p->pengusul);
								
								echo "<tr ".$sudah.">
										  <td>".ucwords(strtolower($p->judul))." (".date('Y',strtotime($p->tglmulai)).")";
								echo "<br><b>Nomor Surat Tugas : ".$tugas." | Nomor Surat Kontrak : ".$kontrak."</b>
										  <br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
										  <br><b>Pelaksanaan : Semester ".$p->semester."</b>
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
									if($p->sumberdana=='Internal' && $p->totaldana<>0)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0)
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
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
									}
								$revo = '';		 
								echo "<br><b>Reviewer : </b>";
								if($p->cek<>'')
								{
									$pisah = explode(',',$p->cek);
									$hitpisah = count($pisah);
									for($i=0;$i<$hitpisah;$i++)
									{
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										$revo .= $revnya['namalengkap'];
										if($i<($hitpisah-1))
											$revo .= ' dan ';
									}
								}
								else
									$revo = '<b style="color:red">-</b>';
/*
								$suratkontrak = $p->suratkontrak;
								if($suratkontrak<>'')
								{
									$getKontrak = "<a href='#' data-target='#liatfile' data-toggle='modal' data-kontrak='".site_url().'assets/uploadbox/'.$p->suratkontrak."' class='btn btn-info' title='Unduh Surat Kontrak'><i class='fas fa-download fa-sm'></i> Unduh Surat Kontrak</a>";
								}
								else
								{
									$getKontrak = "<a href='javascript:void(0)' class='btn btn-secondary' title='Unduh Surat Kontrak'><i class='fas fa-download fa-sm'></i> Unduh Surat Kontrak</a>";
								}

								echo '<b style="color:green">'.$revo.'</b>';
								echo "</td>
										  <td><a href='' class='btn btn-success' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' data-toggle='modal' data-target='#nomorpkm-modal' title='Nomor Surat'><i class='fas fa-edit fa-sm'></i> Nomor Surat</a><br><br>";
								if($p->nomortugas<>'')
								{
									$warna = 'btn-success';
									$surat_tugas = base_url()."surat/tugaspkm/".$p->id_usulan;
									$tutupjob = '';
								}
								else	
								{
									$surat_tugas = '';
									$warna = 'btn-secondary';
									$tutupjob = "onclick='return false;'";
								}

								echo "<a href='".$surat_tugas."' class='btn ".$warna."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='Unduh Surat Tugas' ".$tutupjob."><i class='fas fa-download fa-sm'></i> Unduh Surat Tugas</a><br><br>";
								
								echo $getKontrak;
								echo "</td>
										</tr>";
							}*/
								$suratkontrak = $p->suratkontrak;
								if($p->nomorkontrak<>'' && $suratkontrak<>'')
								{
									//$getKontrak = "<a href='#' data-target='#liatfile' data-toggle='modal' data-kontrak='".site_url().'assets/uploadbox/'.$p->suratkontrak."' class='btn btn-info' title='Unduh Surat Kontrak'><i class='fas fa-download fa-sm'></i> Unduh Surat Kontrak</a>";
									$warnak = 'btn-success';
									$tutup = '';
									$target = "data-target='#kontrak-modal'";
									$teks = 'Unduh Final Surat Kontrak';
									//$surat_kontrak = FCPATH()."assets/uploadbox/".$p->suratkontrak;
									$surat_kontrak = base_url()."surat/kontrakpkm/".$p->id_usulan;
									$getKontrak = "<a href='".$surat_kontrak."' class='btn ".$warnak."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='".$teks."' ".$tutup."><i class='fas fa-download fa-sm'></i> ".$teks."</a><br><br>";
								}
								elseif($p->nomorkontrak<>'' && $p->suratkontrak=='') 
								{
									$warnak = 'btn-info';
									$tutup = '';
									$teks = 'Unduh Draft Surat Kontrak';
									$target = "data-target='#kontrak-modal'";
									$surat_kontrak = base_url()."surat/kontrakpkm/".$p->id_usulan;
									//$getKontrak = "<a href='javascript:void(0)' class='btn btn-secondary' title='Unduh Surat Kontrak'><i class='fas fa-download fa-sm'></i> Unduh Surat Kontrak</a>";
									$getKontrak = "<a href='".$surat_kontrak."' class='btn ".$warnak."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='".$teks."' ".$tutup."><i class='fas fa-download fa-sm'></i> ".$teks."</a><br><br>";
								}else{
									$getKontrak = "<a href='javascript:void(0)' class='btn btn-secondary' title='Unduh Surat Kontrak'><i class='fas fa-download fa-sm'></i> Unduh Surat Kontrak</a>";
								}
								echo '<b style="color:green">'.$revo.'</b>';
								echo "</td>
										  <td><a href='' class='btn btn-success' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' data-toggle='modal' data-target='#nomor-modal' title='Nomor Surat'><i class='fas fa-edit fa-sm'></i> Nomor Surat</a><br><br>";
								if($p->nomortugas<>'')
								{
									$warna = 'btn-success';
									$surat_tugas = base_url()."surat/tugaspkm/".$p->id_usulan;
									$tutupjob = '';
								}
								else	
								{
									$surat_tugas = '';
									$warna = 'btn-secondary';
									$tutupjob = "onclick='return false;'";
								}

								echo "<a href='".$surat_tugas."' class='btn ".$warna."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='Unduh Surat Tugas' ".$tutupjob."><i class='fas fa-download fa-sm'></i> Unduh Surat Tugas</a><br><br>";
								echo $getKontrak;
								
								echo "</td>
										</tr>";
							}

						?>	
					  </tbody>
					</table>
				  </div>
				</div>
	</div>
</div>

<!-- Modal Lihat File -->
<div class="modal fade" id="liatfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">File Surat Kontrak</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">

				<embed id="kontraknya" src="" frameborder="0" width="100%" height="400px">

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			  </div>
			</div>

		</div>
	</div>
</div>

<!-- Modal Nomor PkM -->
<div class="modal fade" id="nomorpkm-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Penomoran Surat Tugas dan Surat Kontrak Pengabdian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'surat/simpanpkm'; ?>" enctype="multipart/form-data">
			<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Nomor Surat Tugas :</label>
			<div class="col-sm-7">
			  <input type="hidden" name="usulan" id="usulan">
			  <input type="text" name="tugas" class="form-control" id="tugas">
            </div>
		  </div>
		  <div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Nomor Surat Kontrak :</label>
			<div class="col-sm-7">
			<input type="text" name="kontrak" class="form-control" id="kontrak">
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
<?php
	$array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
	$bln = $array_bln[date('n')];
?>
<script>
	$(document).ready(function () { 
		$('table.display').DataTable();
	});

	$(document).ready(function() {
        $('#liatfile').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#kontraknya').attr("src",div.data('kontrak'));
        });
    });
	
	$(document).ready(function() {
        $('#nomor-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
			
			//format nomor
			var tugas = '<?php echo 'ST/___/LPPMUNJAYA/'.$bln.'/'.date('Y');?>';
			var kontrak = '<?php echo 'SPK/___/LPPMUNJAYA/'.$bln.'/'.date('Y');?>';
 
      // Isi nilai pada field
      modal.find('#usulan').attr("value",div.data('usulan'));
      if(div.data('tugas')=='')
				modal.find('#tugas').attr("value",tugas);
			else
				modal.find('#tugas').attr("value",div.data('tugas'));
      
      if(div.data('kontrak')=='')
				modal.find('#kontrak').attr("value",kontrak);
			else
				modal.find('#kontrak').attr("value",div.data('kontrak'));
        });
    });
	
	$(document).ready(function() {
        $('#nomorpkm-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
			
			//format nomor
			var tugas = '<?php echo 'ST/___/LPPMUNJAYA/'.$bln.'/'.date('Y');?>';
			var kontrak = '<?php echo 'SPK/___/LPPMUNJAYA/'.$bln.'/'.date('Y');?>';
 
            // Isi nilai pada field
            modal.find('#usulan').attr("value",div.data('usulan'));
            if(div.data('tugas')=='')
				modal.find('#tugas').attr("value",tugas);
			else
				modal.find('#tugas').attr("value",div.data('tugas'));
            if(div.data('kontrak')=='')
				modal.find('#kontrak').attr("value",kontrak);
			else
				modal.find('#kontrak').attr("value",div.data('kontrak'));
        });
    });
</script>