<?php
	if($this->session->userdata('sesi_status')<>1)
		header('location:'.base_url());
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ketua Program Studi</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Daftar Ketua Program Studi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Fakultas</th>
                      <th>Program Studi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Fakultas</th>
                      <th>Program Studi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
						foreach($dosen as $p)
						{
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							echo "<tr>
									  <td>".$p->namalengkap."</td>
									  <td>".$fakultas['fakultas']."</td>
									  <td>".$prodi['prodi']."</td>
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