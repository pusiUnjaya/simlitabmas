<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LPPM - Register</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/img/favicon.ico" type="image/x-icon" rel="icon"/>

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">
	
    <div class="card o-hidden border-0 shadow-lg my-4">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-4 d-none d-lg-block bg-register-image" style="background-size:350px !important;"></div>
          <div class="col-lg-8">
            <div class="p-4">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">
				<?php
					if($this->session->flashdata('result') != '') 
						echo '<p class="login-box-msg">'.$this->session->flashdata('result').'</p>';
					else
						echo '<p class="login-box-msg">Silakan Daftar</p>';
				?>
				</h1>
        <div id="hitung"></div><br>
              </div>
              <form class="user" action="<?php echo base_url(); ?>register/simpan" method="post" autocomplete="off">
                <div class="form-group row">
				<div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="email" name="email" class="form-control" id="username" placeholder="Alamat Email" required>
                </div>
				<div class="col-sm-6 mb-3 mb-sm-0">
					<select name="jenis" class="form-control">
						<option value="3">Dosen</option>
						<option value="2">Dosen+Kaprodi</option>
					</select>
                </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select name="fakultas" id="fakultas" class="form-control">
						<option value="">-- Pilih Fakultas --</option>
						<?php
							foreach($fakultas as $p)
							{
								echo '<option value="'.$p->id_fak.'">'.$p->fakultas.'</option>';
							}
 						?>
					</select>
                  </div>
                  <div class="col-sm-6">
                    <select name="prodi" id="prodi" class="form-control">
						<option value="">-- Pilih Prodi --</option>
					</select>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-group row">
                          <div class="col-sm-11">
                            <input type="password" name="password" id="pass" class="select2-single-placeholder form-control mb-3" placeholder="Masukkan Password" required>
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
                  <div class="col-sm-6">
                    <!-- <input type="password" name="repass" class="form-control" id="repass" placeholder="Repeat Password" required> -->
                    <label style="color:orange">Password min 8 Karakter dengan huruf kapital, huruf kecil, angka, dan simbol</label>
                  </div>
                </div>
          <?php
                          $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                          function generate_string($input, $strength = 16) {

                              $input_length = strlen($input);

                              $random_string = '';

                              for($i = 0; $i < $strength; $i++) {

                                  $random_character = $input[mt_rand(0, $input_length - 1)];

                                  $random_string .= $random_character;

                              }

                              return $random_string;

                          }

                          $setrandom = generate_string($permitted_chars, 5);
                          
                          $this->session->set_userdata('setlog', $setrandom);
                        ?>
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Captcha *</label>
                          <div class="col-sm-3">
                            <input type="text" name="captcha" id="capt" class="select2-single-placeholder form-control mb-3" required>
                          </div>
                          <div class="col-sm-5">
                            <input type="text" class="select2-single-placeholder form-control mb-3" placeholder="<?php echo $setrandom; ?>" readonly>
                            <div id="hitcap"></div>
                          </div>
                        </div>
                <input type="submit" value="Register Account" id="tombol" class="btn btn-primary btn-user btn-block">
                
                <!--<a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>-->
              </form>
              <hr>
              <!--<div class="text-center">
                <a class="small" href="<?php //echo base_url(); ?>forgot">Lupa Password?</a>
              </div>-->
              <div class="text-center">
                <a class="small" href="<?php echo base_url(); ?>login">Sudah Punya Akun? Silakan Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.min.js"></script>
  
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

</body>

</html>
