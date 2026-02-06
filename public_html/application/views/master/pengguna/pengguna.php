<?php
	if($this->session->userdata('sesi_status')<>1)
		header('location:'.base_url());
?>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
			<?php if($this->session->userdata('sesi_status')==1) { ?>
            <a href="<?php echo base_url(); ?>pengguna/tambah" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Pengguna</a>
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
              <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna 
			  <?php
				if($this->session->userdata('sesi_status')==2)
					echo 'Belum Verifikasi';
			  ?>
			  </h6>
			  <div class="col-md-1 float-right">
						<form class="user" action="<?php echo base_url(); ?>pengguna" method="post">
							<select name="tampil" style="margin-top:-20px"  class="form-control" onchange="this.form.submit()" style="margin-top:-7px">
							<?php
								$tampil = array('25','50','100','250','500');
								$n = count($tampil);
								
								if($this->input->post('tampil')=='')
									$pilih = 25;
								else
									$pilih = $this->input->post('tampil');
								
								for($i=0;$i<$n;$i++)
								{
									if($pilih==$tampil[$i])
										echo '<option value="'.$tampil[$n].'" selected>'.$tampil[$i].'</option>';
									else
										echo '<option value="'.$tampil[$i].'">'.$tampil[$i].'</option>';
								}
							?>
						</select>
						</form>
					</div>
			  <form method="post" action="<?php echo base_url();?>dashboard/verifikasi">
			  <input type="submit" value="verifikasi" class="btn btn-success" style="margin-top:-20px;float:right">
            </div>
            <div class="card-body">
              <div class="table-responsive">
				<table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Email</th>
                      <th>Jenis User</th>
                      <th>Nama Lengkap</th>
                      <th><input type="checkbox" id="select_all"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						foreach($pengguna as $p)
						{
							$datetime1 = new DateTime($p->created);//start time
							$datetime2 = new DateTime(date('Y-m-d h:i:s'));//end time
							$durasi = $datetime1->diff($datetime2);
							
							// if($p->namalengkap<>'' && )
							// {	
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
									  <td>".$p->namalengkap."</td>
									  <td>";
									//if($this->session->userdata('sesi_status')==2)
										//echo '<input type="checkbox" name="check[]" value="'.$p->id_user.'" class="checkbox">';
									//else
									//{	
										if($this->session->userdata('sesi_status')==1 && $p->verified==0)
										echo '<input type="checkbox" name="check[]" value="'.$p->id_user.'" class="checkbox">&nbsp;&nbsp;';
										
										if($p->verified==1)
											echo "<a href='".base_url()."pengguna/blok/".$p->id_user."' class='shadow-sm' title='Blok Pengguna'><i class='fas fa-ban fa-sm' style='color:red'></i></a>";
										echo "&nbsp;&nbsp;<a href='".base_url()."pengguna/edit/".$p->id_user."' class='shadow-sm' title='Edit Pengguna'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
										<a href='#' data-id='".$p->id_user."' rel='tooltip' data-placement='top' title='Hapus Pengguna' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a>";
									//}
									echo "</td>
									</tr>";
							$no++;
							// }
						}
					?>	
                  </tbody>
                </table>
				</form>
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
	
	//checkbox
	var select_all = document.getElementById("select_all"); //select all checkbox
	var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

	//select all checkboxes
	select_all.addEventListener("change", function(e){
		for (i = 0; i < checkboxes.length; i++) { 
			checkboxes[i].checked = select_all.checked;
		}
	});


	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){
				select_all.checked = false;
			}
			//check "select all" if all checkbox items are checked
			if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
				select_all.checked = true;
			}
		});
	}
</script>