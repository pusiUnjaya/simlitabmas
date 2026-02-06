<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Pengguna</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Pengguna</h6>
            </div>
            <div class="card-body">
            	<div id="hitung"></div>
              <form class="user" action="<?php echo base_url(); ?>pengguna/simpan" method="post">
                <div class="form-group">
				  <label>Alamat Email</label>
                  <input type="email" name="email" class="form-control" id="username" placeholder="Alamat Email" required>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Fakultas</label>
					<select name="fakultas" id="fakultas" class="form-control">
						<option value="">-- Pilih --</option>
						<?php
							foreach($fakultas as $p)
							{
								echo '<option value="'.$p->id_fak.'">'.$p->fakultas.'</option>';
							}
 						?>
					</select>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Program Studi</label>
					<select name="prodi" id="prodi" class="form-control">
						<option value="">-- Pilih --</option>
					</select>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
					<label>Level Pengguna</label>
                    <select name="jenis" class="form-control">
						<?php
							$jenis = array('Dosen','Dosen+Kaprodi','SuperAdmin');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								echo '<option value="'.($n-$i).'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                  <div class="col-sm-6">
					<label>Password</label>
                    <div class="form-group row">
                          <div class="col-sm-11">
                            <input type="password" name="password" id="pass" class="select2-single-placeholder form-control mb-3" placeholder="Minimal 8 karakter (huruf kapital,huruf kecil,angka,simbol)" required>
                          </div>
                          <div class="col-sm-1" id="buka" style="margin-left:-21px;margin-top: 2px;">
                              <btn href="" class="btn" id="showpass">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                              </btn>
                          </div>
                          <div style="display:none;" id="tutup" class="col-sm-1" style="margin-left:-45px;margin-top: 2px;">
                              <btn href="" class="btn" id="closepass">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i>
                              </btn>
                          </div>
                        </div>
                  </div>
                </div>
                <div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" value="Simpan" id="tombol" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>
            
              </form>
            </div>
          </div>
        </div>

<script>
	$(document).ready(function(){
	$("#fakultas").change(function (){
		var url = "<?php echo site_url('dosen/load_prodi');?>/"+$(this).val();
		$('#prodi').load(url);
		return false;
	});
	});

	//cek email
  $(document).ready(function(){
            $('#username').on('input', function(e) {
            var email = $('#username').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url()?>register/cekemail",
                dataType: "json",
                data: "email="+email,                     
                success: function(data){
                    if(data.valid){
                        $('#hitung').html(data.msg).css("color", "green");
                        document.getElementById("tombol").disabled = false;
                    }else{
                        $('#hitung').html(data.msg).css("color", "red");
                        document.getElementById("tombol").disabled = true;
                    }
                }
            });
        });
    });

  //cek password
  $(document).ready(function() {
      $("#pass").on("input", function(e) {
        $('#hitung').hide();
        regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#^$!%*?&])[A-Za-z\d@#^$!%*?&]{8,20}$/;
        if ($('#pass').val() == null || $('#pass').val() == "" || $('#pass').val().length < 8) {
          $('#hitung').show();
          $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("tombol").disabled = true;
        }
        else if (regex.exec($('#pass').val()) == null) {
          $('#hitung').show();
          $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("tombol").disabled = true;
        }
        else
        {
          $('#hitung').hide();
          document.getElementById("tombol").disabled = false;
        }
      });
    });

    $(document).ready(function() {
      $('#showpass').click(function() {
          if ($(this).data('clicked', true)) {
              $('#pass').attr('type', 'text');
              document.getElementById('tutup').style.display = 'block';
              document.getElementById('buka').style.display = 'none';
              document.getElementById('tutup').style.marginLeft = '-21px';
              document.getElementById('tutup').style.marginTop = '2px';
          } 
      })
  });

    $(document).ready(function() {
      $('#closepass').click(function() {
          if ($(this).data('clicked', true)) {
              $('#pass').attr('type', 'password');
              document.getElementById('tutup').style.display = 'none';
              document.getElementById('buka').style.display = 'block';
          }
      })
  });
</script>