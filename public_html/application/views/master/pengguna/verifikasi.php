<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
            
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
              <h6 class="m-0 font-weight-bold text-primary">Verifikasi Pengguna 
			  <?php
				if($this->session->userdata('sesi_status')==2)
					echo 'Belum Verifikasi';
			  ?>
			  </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Email</th>
                      <th>Jenis User</th>
                      <th width="25%">Update Terakhir</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Email</th>
                      <th>Jenis User</th>
					  <th>Update Terakhir</th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
						$no = 1;
						foreach($ver as $p)
						{
							if($p->jenis==1)
								$user = 'SuperAdmin';
							elseif($p->jenis==2)
								$user = 'Dosen+Kaprodi';
							else
								$user = 'Dosen';
							echo "<tr>
									  <td>".$no."</td>
									  <td>".$p->email."</td>
									  <td>".$user."</td>
									  <td>".tgl_indo($p->modified,1)."</td>
									  <td>";
									echo "<a href='".base_url()."pengguna/verifikasi/".$p->id_user."' class='shadow-sm' title='Verifikasi'><i class='fas fa-check fa-sm'></i></a>&nbsp;&nbsp;";
									echo "</td>
									</tr>";
							$no++;
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
			window.location = "<?php echo base_url();?>pengguna/hapus/" + id ;
		}
	})
	});
</script>