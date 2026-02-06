<?php $approved = !empty($surat->nomor) ?>

<?php if (!$approved): ?>
    <div id="a-modal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="post" action="<?php echo site_url("surat/izin/{$surat->id}/approve") ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Masukkan Nomor dan Tanggal Suratnya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="a-nomor" class="form-label">Nomor Surat</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">B/</span>
                            </div>
                            <input type="number" id="a-nomor" name="nomor" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    /LPPMUNJAYA/<span id="a-bulan">X</span>/<span id="a-tahun"><?php echo date('Y') ?></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="a-tanggal" class="form-label">Tanggal Surat</label>
                        <input type="date" id="a-tanggal" name="tanggal" class="form-control">
                    </div>
                    <input type="hidden" id="ah-bulan" name="bulan" value="X">
                    <input type="hidden" id="ah-tahun" name="tahun" value="<?php echo date('Y') ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="a-setujui">Setujui</button>
                </div>
            </form>
        </div>
    </div>
<?php endif ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Detail <?php echo $approved ? '' : 'Permohonan ' ?>
            Surat Izin <?php echo $surat->jenis == 'lit' ? 'Penelitian' : 'PkM' ?>
        </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if ($approved): ?>
                <div class="form-group row border-bottom">
                    <label class="col-md-2 col-form-label font-weight-bold">Nomor Surat</label>
                    <div class="col-md-10">
                        <span class="form-control-plaintext"><?php echo $surat->nomor ?></span>
                    </div>
                </div>
                <div class="form-group row border-bottom">
                    <label class="col-md-2 col-form-label font-weight-bold">Tanggal Surat</label>
                    <div class="col-md-10">
                        <span class="form-control-plaintext"><?php echo date('d/m/Y', strtotime($surat->tanggal)) ?></span>
                    </div>
                </div>
            <?php endif ?>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">Judul</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo $surat->judul ?></span>
                </div>
            </div>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">Waktu Pengajuan</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo date('d/m/Y h:i:s', strtotime($surat->waktu_pengajuan)) ?></span>
                </div>
            </div>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">Program Studi</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo $prodi ?></span>
                </div>
            </div>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">Daftar Dosen</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo join(', ', $dosen) ?></span>
                </div>
            </div>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">Kepada</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo $surat->tertuju ?></span>
                </div>
            </div>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">di</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo $surat->tempat ?></span>
                </div>
            </div>
            <div class="form-group row border-bottom">
                <label class="col-md-2 col-form-label font-weight-bold">Lokasi Kegiatan</label>
                <div class="col-md-10">
                    <span class="form-control-plaintext"><?php echo $surat->lokasi ?></span>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="<?php echo site_url('surat/izin') ?>" class="btn btn-secondary btn-user mr-2" style="width:200px">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <?php if ($approved): ?>
                <?php if ($admin): ?>
                    <a href="<?php echo site_url("surat/izin/{$surat->id}/undo") ?>" class="btn btn-warning btn-user mr-2" style="width:300px">
                        <i class="fas fa-backspace mr-2"></i> Batalkan Persetujuan
                    </a>
                <?php endif ?>
                <a href="<?php echo site_url("surat/izin/{$surat->id}/download") ?>" class="btn btn-success btn-user mr-2" style="width:200px" target="_blank">
                    <i class="fas fa-download mr-2"></i> Unduh
                </a>
            <?php else: ?>
                <?php if ($admin): ?>
                    <button type="button" class="btn btn-primary btn-user mr-2" style="width:200px" data-toggle="modal" data-target="#a-modal">
                        <i class="fas fa-check mr-2"></i> Setujui
                    </button>
                <?php endif ?>
				<a id="s-hapus" href="<?php echo site_url("surat/izin/{$surat->id}/delete") ?>" class="btn btn-danger btn-user" style="width:200px">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </a>
            <?php endif ?>
        </div>
    </div>
</div>

<script>
function roman(num) {
    if (num < 1) return ""
    if (num >= 40) return "XL" + roman(num - 40)
    if (num >= 10) return "X" + roman(num - 10)
    if (num >= 9) return "IX" + roman(num - 9)
    if (num >= 5) return "V" + roman(num - 5)
    if (num >= 4) return "IV" + roman(num - 4)
    if (num >= 1) return "I" + roman(num - 1)
}

$('#s-hapus').on('click', ev => {
    if (!confirm('Anda benar-benar mau menghapus data permohonan ini?')) {
        return false;
    }
});

$('#a-setujui').on('click', ev => {
    if (!$('#a-nomor').val()) {
        alert('Nomor surat harus diisi!');
        return false;
    }
    if (!$('#a-tanggal').val()) {
        alert('Tanggal surat harus diisi!');
        return false;
    }
});

function setBulanTahun(bln, thn) {
    $('#a-bulan').text(roman(+bln));
    $('#a-tahun').text(thn);
    $('#ah-bulan').val($('#a-bulan').text());
    $('#ah-tahun').val($('#a-tahun').text());
}

function setHariIni() {
    let today = new Date();
    $('#a-tanggal').val(today.toLocaleDateString('en-CA', {timeZone: "Asia/Jakarta"}));
    setBulanTahun(today.getMonth() + 1, today.getFullYear());
}

$('#a-tanggal').on('change', function() {
    let tgl = $(this).val();
    setBulanTahun(tgl.substr(5, 2), tgl.substr(0, 4));
});

$(document).ready(function() {
    $('#a-modal').on('shown.bs.modal', function() {
        $('#a-nomor').trigger('focus');
        setHariIni();
    });
});
</script>