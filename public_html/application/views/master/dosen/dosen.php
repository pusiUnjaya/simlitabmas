<?php
	if($this->session->userdata('sesi_status')<>1)
		header('location:'.base_url());
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dosen</h1>
            <a href="<?php echo base_url(); ?>dosen/tambah" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Dosen</a>
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
              <h6 class="m-0 font-weight-bold text-primary">Daftar Dosen</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Jabatan Akademik</th>
                      <th>Fakultas/Prodi</th>
                      <th width="7%"></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Jabatan Akademik</th>
                      <th>Fakultas/Prodi</th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
						foreach($dosen as $p)
						{
							$posisi = '';
							if($p->fakultas<>'')
							{
								$fakultas = $this->mdosen->namafakultas($p->fakultas);
								$prodi = $this->mdosen->namaprodi($p->prodi);
								$posisi = $fakultas['fakultas']."/".$prodi['prodi'];
							}
							else
							{
								$posisi = 'Dosen Luar';
							}
							echo "<tr>
									  <td>".$p->namalengkap."</td>
									  <td>".$p->jabatanakademik."</td>
									  <td>".$posisi."</td>
									  <td>
											<a href='".base_url()."dosen/edit/".$p->id_dosen."' class='shadow-sm' title='Edit Dosen'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
											<a href='#' data-id='".$p->id_dosen."' class='shadow-sm hapus' title='Hapus Dosen'><i class='fas fa-trash fa-sm'></i></a>
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
				window.location = "<?php echo base_url();?>dosen/hapus/" + id ;
			}
		})
	});
</script>