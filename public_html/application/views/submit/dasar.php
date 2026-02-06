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
			<a href="<?php 
				$hitque = $this->msubmit->sudahisibelum();
				if($this->session->userdata('sesi_status')<>1 && $hitque==0)
					echo base_url().'kuesioner'; 
				else
					echo base_url().'submit/tambahusulan'; 
				?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Usulan</a>
			
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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan Penelitian 
			  <?php
				if($this->uri->segment(2)=='dasar')
					echo 'Dasar';
				elseif($this->uri->segment(2)=='terapan')
					echo 'Terapan';
				elseif($this->uri->segment(2)=='pengembangan')	
					echo 'Pengembangan';
				else
					echo 'Kejuangan';
			  ?>
			  </h6>
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
							$sudah = '';
							foreach($usulan as $p)
							{
								$total = $this->msubmit->totalrab($p->id_usulan);
								$fakultas = $this->mdosen->namafakultas($p->fakultas);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								if($p->status=='Reviewed')
									$sudah = "class='table-info'";
								
								$ketua = $this->mdosen->dosennya($p->pengusul);
							
								echo "<tr ".$sudah.">
										  <td>".$p->judul."
										  <br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
										  <br>RAB : ".rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'])."</td>
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