<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Profil</h1>
          </div>

          <!-- Content Row -->

          <div class="row">

            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="pt-2 pb-2">
                    <img width="300" class="rounded-circle" alt="<?php echo $profil['namalengkap']; ?>" src="
					<?php 
						echo base_url(); 
						if($profil['fotoprofil'] <> '')
							echo 'assets/profilebox/'.$profil['fotoprofil'];
						elseif($profil['fotoprofil'] == '' && $profil['jk'] == 'L')
							echo 'assets/profilebox/man.png';
						else
							echo 'assets/profilebox/woman.png';
					?>">
					<a href="" class="shadow-sm" title="Ganti Foto Profil" style="float:right;top:-80px" data-toggle="modal" data-target="#gantipic-modal"><i class="fas fa-edit fa-sm"></i> Ganti Foto Profil</a>
                  </div>
                </div>
              </div>
            </div>
			<!-- Project Card Example -->
			<div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Detail Dosen</h6>
				  <div class="col-md-2 float-right">
					<a class="btn-sm btn-info" href="<?php echo base_url().'profil/edit/'.$profil['id_dosen']; ?>">Edit Profil</a>
				  </div>
                  
                </div>
                <div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<label>Nama Lengkap</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['namalengkap']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>NIDN/NPP</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['nidn']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Nomor KTP</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['ktp']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Tempat/Tanggal Lahir</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['tmplahir'].'/'.tgl_indo($profil['tglahir'],1); ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jenis Kelamin</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php 
									if($profil['jk']=='L')
										echo 'Laki-Laki';
									else
										echo 'Perempuan'; 
								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Fakultas/Program Studi</label>
						</div>
						<div class="col-md-8">
							<p>
								<?php 
									$fakultas = $this->mdosen->namafakultas($profil['fakultas']);
									$prodi = $this->mdosen->namaprodi($profil['prodi']);
									echo $fakultas['fakultas'].'/'.$prodi['prodi']; 
								?>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jenjang Pendidikan</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['jenjangpendidikan']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Jabatan Akademik</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['jabatanakademik']; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>Alamat Rumah</label>
						</div>
						<div class="col-md-8">
							<p><?php echo $profil['alamat']; ?></p>
						</div>
					</div>
                </div>
              </div>
            </div>
          </div>
        </div>

<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
</style>
<!-- modal -->
<div class="modal fade" id="gantipic-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ganti Foto Profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'profil/gantipic'; ?>" enctype="multipart/form-data">
			<div class="form-group">
				<label>Upload Foto Profil</label>
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							Browse… <input type="file" name="gantipic" id="imgInp">
						</span>
					</span>
					<input type="text" class="form-control" readonly>
				</div>
				<img id='img-upload'/>
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

<script>
$(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		}); 	
	});
</script>
