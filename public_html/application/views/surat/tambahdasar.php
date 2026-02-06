<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dasar Hukum Surat</h1>
  </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Dasar Hukum Surat</h6>
    </div>
    <div class="card-body">
      <form class="user" action="<?php echo base_url(); ?>surat/simpandasar" method="post">
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label>Teks Dasar</label>
						<textarea name="teks" rows="4" class="form-control" placeholder="Teks Dasar Hukum" required></textarea>
          </div>
          <div class="col-sm-6">
					<label>Peruntukan</label><br>
					<select name="jenis" id="jenis" class="form-control" required>
						<option value="Surat Tugas Penelitian">Surat Tugas Penelitian</option>
						<option value="Surat Kontrak Penelitian">Surat Kontrak Penelitian</option>
						<option value="Surat Tugas Pengabdian">Surat Tugas Pengabdian</option>
						<option value="Surat Kontrak Pengabdian">Surat Kontrak Pengabdian</option>
					</select>
          </div>
        </div>
<div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label>Tahun</label>
	<input type="text" name="tahun" class="form-control" placeholder="Tahun Mulai Berlaku" required>
          </div>
          <div class="col-sm-6">
            <label>Urutan</label>
	<input type="number" value="1" name="urutan" id="urutan" class="form-control" placeholder="Urutan Tampil" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            
          </div>
          <div class="col-sm-6">
            <button type="button" class="btn btn-secondary">Batal</button>
						<button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>