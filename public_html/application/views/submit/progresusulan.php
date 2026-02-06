<?php
	if($this->session->userdata('sesi_user')=='')
	{
		header('location:'.base_url().'login');
	}
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Progress Usulan Penelitian</h1>
          </div>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Progress Usulan Penelitian 
			  <?php
				if($this->session->userdata('sesi_status')==2)
					echo 'Belum Verifikasi';
			  ?>
			  </h6>
			  <form class="user col-md-2 float-right" style="margin-top:-20px;float:right;width:10%" action="<?php echo base_url(); ?>submit/progress" method="post">
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
			  <!--<form method="post" action="<?php echo base_url();?>dashboard/verifikasi">
			  <input type="submit" value="verifikasi" class="btn btn-success" style="margin-top:-20px;float:right">-->
            </div>
		  <div class="card-body">
				  <div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>No</th>
						  <th>Data Usulan</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							$no = 1;
							foreach($usulan as $p)
							{
								$sudah = '';
								$total = $this->msubmit->totalrab($p->id_usulan);
								$fakultas = $this->mdosen->namafakultas($p->fakultas);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								$sudah = $this->msubmit->direviewoleh($p->id_usulan);
								// echo $this->db->last_query();exit;	
								$n = count($sudah);
							if($p->status=='Reviewed' && $n==1)
							{
								$sudah = "class='table-warning'";
								$set = 'Reviewed';
							}
							elseif($p->status=='Reviewed' && $n==2)
							{
								$sudah = "class='table-info'";
								$set = 'Reviewed';
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
								$sudah = "class='table-danger'";
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
										  <td>".$no."</td>
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
							echo "RAB : ".rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
								//echo "<br><b>Reviewer : </b>".$dosen;
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
								echo "</td></tr>";
								$no++;
							}
						?>	
					  </tbody>
					</table>
				  </div>
				</div>
				</div>
        </div>

<!-- Modal Kirim -->
<div class="modal fade" id="kirim-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'submit/kirim'; ?>" enctype="multipart/form-data">
		<input type="hidden" name="idusul" class="idusul">
        <p>Usulan tidak dapat diedit setelah terkirim, lanjutkan???</p>  
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-success">Kirim</button>
	  </div>
	  </form>
    </div>
  </div>
</div> 

<script>
	$(document).ready(function() {
        // Untuk sunting
        $('#kirim-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('.idusul').attr("value",div.data('idusul'));
        });
    });
	
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