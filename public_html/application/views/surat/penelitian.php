<div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Usulan Baru</h1>
			</div>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="row">
						<div class="col-md-8">
						  <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan Penelitian</h6>
						</div>
						<div class="col-md-4 float-right">
						<form class="user col-md-4 float-right" action="<?php echo base_url(); ?>surat/penelitian" method="post">
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
						</div>
				</div>
				</div>
				<div class="card-body">
				  <div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>Data Usulan</th>
						  <th width="20%">Surat Tugas</th>
						  <th width="20%">Surat Kontrak</th>
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
								echo "<br><b>Nomor Surat Tugas : ".$p->nomortugas." | Nomor Surat Kontrak : ".$p->nomorkontrak."</b>
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
								$revo = 'Anonim';
								echo '<b style="color:green">'.$revo.'</b>';
								if($p->nomortugas<>'')
								{
									$warna = 'btn-success';
									$surat_tugas = base_url()."surat/tugaspenelitian/".$p->id_usulan;
									$tutupjob = '';
								}
								else	
								{
									$surat_tugas = '';
									$warna = 'btn-secondary';
									$tutupjob = "onclick='return false;'";
								}
								
								if($p->nomorkontrak<>'' && $p->suratkontrak=='')
								{
									$warnak = 'btn-info';
									$tutup = '';
									$teks = 'Unduh Surat Kontrak';
									$target = "data-target='#kontrak-modal'";
									$surat_kontrak = base_url()."surat/kontrakpenelitian/".$p->id_usulan;

									$warnasetujui = 'btn-success';
									$tutupsetujui = '';
									$urlsetujui = base_url()."surat/setujuipenelitian/".$p->id_usulan;
								}
								elseif($p->nomorkontrak<>'' && $p->suratkontrak<>'')
								{
									$warnak = 'btn-success';
									$tutup = '';
									$target = "data-target='#kontrak-modal'";
									$teks = 'Unduh Final Surat Kontrak';
									//$surat_kontrak = base_url()."assets/uploadbox/".$p->suratkontrak;
									$surat_kontrak = base_url()."surat/kontrakpenelitian/".$p->id_usulan;

									$warnasetujui = 'btn-secondary';
									$tutupsetujui = "onclick='return false;'";
									$urlsetujui = '#';

								}
								else	
								{
									$surat_kontrak = '#';
									$tutup = "onclick='return false;'";
									$teks = 'Unduh Surat Kontrak';
									$target = "";
									$warnak = 'btn-secondary';

									$warnasetujui = 'btn-secondary';
									$tutupsetujui = "onclick='return false;'";
									$urlsetujui = '#';
								}
								
								echo "<td><a href='".$surat_tugas."' class='btn ".$warna."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='Unduh Surat Tugas' ".$tutupjob."><i class='fas fa-download fa-sm'></i> Unduh Surat Tugas</a></td>
									  <td><a href='".$surat_kontrak."' class='btn ".$warnak."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='".$teks."' ".$tutup."><i class='fas fa-download fa-sm'></i> ".$teks."</a><br><br>";
								if($p->pengusul==$this->session->userdata('sesi_id'))
								{
									//echo "<a href='' class='btn btn-info' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' data-toggle='modal' ".$target." title='Unggah Surat Kontrak' ".$tutup."><i class='fas fa-upload fa-sm'></i> Unggah Surat Kontrak</a>";
									echo "<a href='".$urlsetujui."' class='btn ".$warnasetujui."' data-usulan='".$p->id_usulan."' data-tugas='".$p->nomortugas."' data-kontrak='".$p->nomorkontrak."' target='_blank' title='Setujui Kontrak' ".$tutupsetujui."><i class='fas fa-check fa-sm'></i> Setujui</a>";
								}
								echo "</td></tr>";
							}
						?>	
					  </tbody>
					</table>
				  </div>
				</div>
				</div>
</div>

<!-- Modal Surat Tugas -->
<div class="modal fade" id="tugas-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Unggah Surat Tugas Penelitian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'surat/simpantugas'; ?>" enctype="multipart/form-data">
			<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Surat Tugas :</label>
			<div class="col-sm-7">
			  <input type="hidden" name="usulan" id="usulan">
			  <input type="file" name="tugas" class="form-control" id="tugas">
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

<!-- Modal Surat Kontrak -->
<div class="modal fade" id="kontrak-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Unggah Surat Kontrak Penelitian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'surat/simpankontrakpenelitian'; ?>" enctype="multipart/form-data">
			<div class="form-group row">
			<label for="inputEmail3" class="col-sm-5 col-form-label">Surat Kontrak :</label>
			<div class="col-sm-7">
			  <input type="hidden" name="usulan" id="idusulan">
			  <input type="file" name="kontrak" class="form-control" id="tugas">
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
      $('#kontrak-modal').on('show.bs.modal', function (event) {
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      var modal = $(this)
			
			// Isi nilai pada field
      modal.find('#idusulan').attr("value",div.data('usulan'));
      
        });
    });
</script>