<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dosen</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user-plus fa-sm text-white-50"></i> Tambah Dosen</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Dosen</h6>
            </div>
            <div class="card-body">
              <form class="user" action="<?php echo base_url(); ?>dosen/update" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
				    <input type="hidden" name="id_dosen" value="<?php echo $dosen['id_dosen']; ?>">
				    <input type="hidden" name="id_user" value="<?php echo $dosen['user']; ?>">
					<label>Nama Lengkap</label>
                    <input type="text" name="namalengkap" class="form-control" placeholder="Nama Lengkap" value="<?php echo $dosen['namalengkap']; ?>" required>
                  </div>
                  <div class="col-sm-6">
					<label>Jenis Kelamin</label><br>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="jk" id="inlineCheckbox1" value="L" checked>
					  <label class="form-check-label" for="inlineCheckbox1">Laki-Laki</label>
					</div>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="jk" id="inlineCheckbox2" value="P">
					  <label class="form-check-label" for="inlineCheckbox2">Perempuan</label>
					</div>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Tempat Lahir</label>
					<input type="text" name="tmplahir" class="form-control" placeholder="Tempat Lahir" value="<?php echo $dosen['tmplahir']; ?>" required>
                  </div>
                  <div class="col-sm-6">
                    <label>Tanggal Lahir</label>
					<input type="text" name="tglahir" id="tglahir" class="form-control" placeholder="Tanggal Lahir" value="<?php echo $dosen['tglahir']; ?>" required>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>KTP</label>
					<input type="text" name="ktp" class="form-control" placeholder="Nomor KTP" value="<?php echo $dosen['ktp']; ?>" required>
                  </div>
                  <div class="col-sm-6">
                    <label>NPP/NIDN</label>
					<input type="text" name="nidn" class="form-control" placeholder="NPP/NIDN" value="<?php echo $dosen['nidn']; ?>" required>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Fakultas</label>
					<select name="fakultas" id="fakultas" class="form-control">
						<option>-- Pilih Fakultas --</option>
						<?php
							foreach($fakultas as $p)
							{
								if($dosen['fakultas'] == $p->id_fak)
									echo '<option value="'.$p->id_fak.'" selected>'.$p->fakultas.'</option>';
								else
									echo '<option value="'.$p->id_fak.'">'.$p->fakultas.'</option>';
							}
 						?>
					</select>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Program Studi</label>
					<select name="prodi" id="prodi" class="form-control">
						<?php
							$namaprodi = $this->mdosen->namaprodi($dosen['prodi']);
							echo '<option value="'.$dosen['prodi'].'">'.$namaprodi['prodi'].'</option>';
						?>
					</select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label>Alamat Rumah</label>
					<input type="text" name="alamat" class="form-control" id="exampleAlamat" placeholder="Alamat Rumah" value="<?php echo $dosen['alamat']; ?>" required>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Jenjang Pendidikan</label>
					<select name="jenjangpendidikan" class="form-control">
						<?php
							$jenis = array('S1','S2','S3');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Website Pribadi</label>
					<input type="text" name="web" class="form-control" id="exampleAlamat" placeholder="Website Pribadi" value="<?php echo $dosen['website']; ?>">
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Jabatan Akademik</label>
					<select name="jabatanakademik" class="form-control">
						<?php
							$jenis = array('Tenaga Pengajar','Asisten Ahli','Lektor','Lektor Kepala','Profesor');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								if($jenis[$i] == $dosen['jabatanakademik'])
									echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
								else
									echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>ID Google Scholar</label>
					<input type="text" name="google" class="form-control" placeholder="ID Google Scholar" value="<?php echo $dosen['id_googlescholar']; ?>">
                  </div>
                  <div class="col-sm-6">
                    <label>ID Scopus</label>
					<input type="text" name="scopus" class="form-control" placeholder="ID Scopus" value="<?php echo $dosen['id_scopus']; ?>">
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>ID Sinta</label>
					<input type="text" name="sinta" class="form-control" placeholder="ID Sinta" value="<?php echo $dosen['id_sinta']; ?>">
                  </div>
                </div>
                <div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" value="Simpan" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>
            
              </form>
            </div>
          </div>
        </div>

<script>
	$(function () {
		//Date picker
		$('#tglahir').datepicker({
		  changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0',
			autoclose: true
		});
	});
	
	$(document).ready(function(){
	$("#fakultas").change(function (){
		var url = "<?php echo site_url('dosen/load_prodi');?>/"+$(this).val();
		$('#prodi').load(url);
		return false;
	});
	});
</script>
