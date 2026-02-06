<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Submit</h1>
            
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Submit PkM</h6>
            </div>
            <div class="card-body">
              <form class="user" action="<?php echo base_url(); ?>pengabdian/simpan" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Judul PkM</label>
					<input type="text" name="judul" class="form-control" placeholder="Judul Penelitian/PkM" required>
                  </div>
                  <div class="col-sm-6">
					<label>Skema PkM</label>
					<select name="skema" class="form-control">
						<?php
							$jenis = array('Dasar','Terapan','Pengembangan');
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
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Luaran</label>
					<select name="luaran" class="form-control">
						<?php
							$jenis = array('Jurnal Nasinal BerISSN','Jurnal Nasional Terakreditasi 4-6','Jurnal Nasional Terakreditasi 1-2','Jurnal Internasional','Jurnal Internasional Bereputasi','Paten','HKI','Bahan Ajar','Prosiding');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                  <div class="col-sm-6">
                    <label>Nama Jurnal</label>
					<input type="text" name="namajurnal" class="form-control" placeholder="Nama Jurnal" required>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Sumber Dana</label>
					<select name="sumberdana" class="form-control">
						<?php
							$jenis = array('Mandiri','Internal','Dikti','Kopertis');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                  <div class="col-sm-6">
                    <label>Jumlah Dana</label>
					<input type="text" name="jmldana" class="form-control" placeholder="Jumlah Dana" required>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Anggota Dosen</label>
					<textarea name="anggotadosen" class="form-control"></textarea>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Anggota Mahasiswa</label>
					<textarea name="anggotamhs" class="form-control"></textarea>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Ringkasan</label>
					<textarea name="ringkasan" class="form-control"></textarea>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Kata Kunci</label>
					<textarea name="katakunci" class="form-control"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label>Tanggal Mulai</label>
					<input type="text" name="tglmulai" class="form-control" id="tglmulai" placeholder="Tanggal Mulai" required>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Tanggal Akhir</label>
					<input type="text" name="tglakhir" class="form-control" id="tglakhir" placeholder="Tanggal Akhir" required>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>File Usulan</label>
					<input type="file" name="file" class="form-control" placeholder="File" required>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    
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
	$('#tglmulai').datepicker({
		uiLibrary: 'bootstrap4'
	});
	
	$('#tglakhir').datepicker({
		uiLibrary: 'bootstrap4'
	});
	
	$(document).ready(function(){
	$("#fakultas").change(function (){
		var url = "<?php echo site_url('dosen/load_prodi');?>/"+$(this).val();
		$('#prodi').load(url);
		return false;
	});
	});
</script>
