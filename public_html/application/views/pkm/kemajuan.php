<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Laporan Kemajuan</h1>
            
          </div>
          <!-- DataTales Example -->
		  <?php 
			if($hitrevkemajuan>0) {
		  ?>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Laporan Kemajuan PkM di Review</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Data PkM</th>
					  <th width="6%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$warna = '';
						$filelaporan = '';
						$sumber = '';
						$proposal = '';
						foreach($revkemajuan as $p)
						{
							$namadosen = $this->mdosen->namadosen($p->pengusul);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$sudahmaju = $this->mpengabdian->sudahkemajuan($p->id_usulan);
							$proposal = base_url()."assets/uploadbox/".$p->filerevisi;
							
							if($sudahmaju > 0)
							{
								$warna = "class='table-success'";
								$ceklaporan = $this->mpengabdian->liatfilekemajuan($p->id_usulan);
								$filelaporan = $ceklaporan['lap_kemajuan'];
								$upload = $filelaporan;
								$sumber = base_url()."assets/uploadbox/".$upload;
							}
							else
							{
								$warna = '';
								$filelaporan = '';
								$upload = 'Belum Pernah Upload File';
								$sumber = '';
							}
							
							$ketua = $this->mdosen->dosennya($p->pengusul);
												
							echo "<tr ".$warna.">
									  <td>".ucwords(strtolower($p->judul))." (".date('Y',strtotime($p->tglmulai)).")";
							echo "<br><b>Status Kemajuan : ".$upload."</b>
										<br><b>Semester Pelaksanaan : ".$p->semester."</b>
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
								elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana==0)
								{
									echo rupiah($p->jmldana);
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
							echo "</td><td>";
							if($this->session->userdata('sesi_status')==1 || ($this->session->userdata('sesi_status')==1 && $filelaporan<>''))
							{
								echo "<a href='#' class='shadow-sm' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-proposal='".$proposal."' data-target='#liatproposal-modal' title='Lihat Proposal'><i class='fas fa-book-open fa-sm'></i></a>&nbsp;&nbsp;";
								
								echo "<a href='#' class='shadow-sm' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-sumber='".$sumber."' data-target='#liatfile-modal' title='Lihat Kemajuan'><i class='fas far fa-bookmark fa-sm'></i></a>&nbsp;&nbsp;";
							}
							elseif(($this->session->userdata('sesi_status')==3 || $this->session->userdata('sesi_status')==2) && $filelaporan<>'')
							{
								echo "<a href='#' class='shadow-sm btn btn-info' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-sumber='".$sumber."' data-target='#liatfile-modal' title='Lihat Kemajuan'><i class='fas far fa-bookmark fa-sm'></i></a>&nbsp;&nbsp;";
								
								if($p->pengusul==$this->session->userdata('sesi_id'))
								{
								echo "<a href='#' class='shadow-sm btn btn-info' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-file='".$upload."' data-target='#maju-modal' title='Upload Kemajuan'><i class='fas fa-upload fa-sm'></i></a>";
								}
							}
							else
							{
								echo "<a href='#' class='shadow-sm btn btn-secondary' data-toggle='modal' data-refresh='true' title='Lihat Kemajuan' disabled><i class='fas far fa-bookmark fa-sm'></i></a>&nbsp;&nbsp;";
									if($p->pengusul==$this->session->userdata('sesi_id'))
									{
									echo "<a href='#' class='shadow-sm btn btn-info' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-file='".$upload."' data-target='#maju-modal' title='Upload Kemajuan'><i class='fas fa-upload fa-sm'></i></a>";
									}
							}
							echo "</td></tr>";
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  <?php } ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Laporan Kemajuan PkM</h6>
			  <form class="user col-md-4 float-right" style="margin-top:-20px;float:right;width:10%" action="<?php echo base_url(); ?>pengabdian/kemajuan" method="post">
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
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Data PkM</th>
                      <th width="6%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$warna = '';
						$filelaporan = '';
						$sumber = '';
						$proposal = '';
						foreach($kemajuan as $p)
						{
							$namadosen = $this->mdosen->namadosen($p->pengusul);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$sudahmaju = $this->mpengabdian->sudahkemajuan($p->id_usulan);
							$proposal = base_url()."assets/uploadbox/".$p->filerevisi;
							
							if($sudahmaju > 0)
							{
								$warna = "class='table-success'";
								$ceklaporan = $this->mpengabdian->liatfilekemajuan($p->id_usulan);
								$filelaporan = $ceklaporan['lap_kemajuan'];
								$upload = $filelaporan;
								$sumber = base_url()."assets/uploadbox/".$upload;
							}
							else
							{
								$warna = '';
								$filelaporan = '';
								$upload = 'Belum Pernah Upload File';
								$sumber = '';
							}
							
							$ketua = $this->mdosen->dosennya($p->pengusul);
												
							echo "<tr ".$warna.">
									  <td>".$p->judul." (".date('Y',strtotime($p->tglmulai)).")";
							echo "<br><b>Status Kemajuan : ".$upload."</b>
										<br><b>Semester Pelaksanaan : ".$p->semester."</b>
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
								elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana==0)
								{
									echo rupiah($p->jmldana);
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
							echo "</td><td>";
							if($this->session->userdata('sesi_status')==1 || ($this->session->userdata('sesi_status')==1 && $filelaporan<>''))
							{
								echo "<a href='#' class='shadow-sm' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-proposal='".$proposal."' data-target='#liatproposal-modal' title='Lihat Proposal'><i class='fas fa-book-open fa-sm'></i></a>&nbsp;&nbsp;";
								
								echo "<a href='#' class='shadow-sm' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-sumber='".$sumber."' data-target='#liatfile-modal' title='Lihat Kemajuan'><i class='fas far fa-bookmark fa-sm'></i></a>&nbsp;&nbsp;";
							}
							elseif(($this->session->userdata('sesi_status')==3 || $this->session->userdata('sesi_status')==2) && $filelaporan<>'')
							{
								echo "<a href='#' class='shadow-sm btn btn-info' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-sumber='".$sumber."' data-target='#liatfile-modal' title='Lihat Kemajuan'><i class='fas far fa-bookmark fa-sm'></i></a>&nbsp;&nbsp;";
								
								if($p->pengusul==$this->session->userdata('sesi_id'))
								{
								echo "<a href='#' class='shadow-sm btn btn-info' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-file='".$upload."' data-target='#maju-modal' title='Upload Kemajuan'><i class='fas fa-upload fa-sm'></i></a>";
								}
							}
							else
							{
								echo "<a href='#' class='shadow-sm btn btn-secondary' data-toggle='modal' data-refresh='true' title='Lihat Kemajuan' disabled><i class='fas far fa-bookmark fa-sm'></i></a>&nbsp;&nbsp;";
									if($p->pengusul==$this->session->userdata('sesi_id'))
									{
									echo "<a href='#' class='shadow-sm btn btn-info' data-toggle='modal' data-refresh='true' data-usulan='".$p->id_usulan."' data-file='".$upload."' data-target='#maju-modal' title='Upload Kemajuan'><i class='fas fa-upload fa-sm'></i></a>";
									}
							}
								
							echo "</td></tr>";
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <!--</div> -->


<!-- Modal Persetujuan -->
<div class="modal fade" id="maju-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Laporan Kemajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'pengabdian/simpankemajuan/'; ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">File Laporan Kemajuan (PDF) maksimal 10Mb :</label>
			<input type="hidden" id="idusulanya" name="id">
			<input type="file" name="fileupload" class="form-control unggah" placeholder="File Usulan (PDF)">
			<label for="recipient-name" class="col-form-label">File Laporan Kemajuan : 
			<b id="cekupload"></b></label>
            
          </div>
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		<button type="submit" id="tmbsimpan" class="btn btn-success">Simpan</button>
	  </div>
	  </form>
    </div>
  </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="liatfile-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">File Laporan Kemajuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">

				<embed id="filekemajuan" src="" frameborder="0" width="100%" height="400px">

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			  </div>
			</div>

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="liatproposal-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">File Proposal Usulan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">

				<embed id="fileproposal" src="" frameborder="0" width="100%" height="400px">

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			  </div>
			</div>

		</div>
	</div>
</div>

<script>
	$('.unggah').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>10)
		{
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			document.getElementById("tmbsimpan").disabled = true;
		}
		else if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			document.getElementById("tmbsimpan").disabled = true;
			return false;
		}
		else
		{
			document.getElementById("tmbsimpan").disabled = false;
		}
	});
	
	$(document).ready(function() {
        $('#maju-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#idusulanya').attr("value",div.data('usulan'));
            modal.find('#cekupload').html(div.data('file'));
        });
    });
	
	//liat laporan kemajuan
	$(document).ready(function() {
        $('#liatfile-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#filekemajuan').attr("src",div.data('sumber'));
        });
    });
		
	$(document).ready(function() {
        $('#liatfile-modal').on('hidden.bs.modal', function (event) {
			//location.reload();
			//Reload the modal content
			var modalHtml = $("#liatfile-modal").html();
			$("#liatfile-modal").html("");
			$("#liatfile-modal").html(modalHtml);

		});
    });
	
	//liat proposal
	$(document).ready(function() {
        $('#liatproposal-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#fileproposal').attr("src",div.data('proposal'));
        });
    });
	
	$(document).ready(function() {
        $('#liatproposal-modal').on('hidden.bs.modal', function (event) {
			//location.reload();
			//Reload the modal content
			var modalHtml = $("#liatproposal-modal").html();
			$("#liatproposal-modal").html("");
			$("#liatproposal-modal").html(modalHtml);

		});
    });
	
	
</script>
