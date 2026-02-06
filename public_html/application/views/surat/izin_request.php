<div id="u-modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Penelitian/PkM-nya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="u-id" class="form-label">Judul</label>
                    <select id="u-id" class="form-control">
                        <option value="">-- Pilih salah satu --</option>
                        <?php foreach ($penelitian as $p): ?>
                            <option value="lit-<?php echo $p->id_usulan ?>"><?php echo $p->judul ?></option>
                        <?php endforeach ?>
                        <?php foreach ($pengabdian as $p): ?>
                            <option value="pkm-<?php echo $p->id_usulan ?>"><?php echo $p->judul ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="u-pilih">Pilih</button>
            </div>
        </div>
    </div>
</div>

<div id="m-modal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Anggota Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="m-id" class="form-label">Nama Dosen</label>
                    <select id="m-id" class="form-control">
                        <option value="">-- Pilih salah satu --</option>
                        <?php foreach ($dosen as $d): ?>
                            <option value="<?php echo $d->id_dosen ?>">
                                <?php echo $d->namalengkap ?> (<?php echo $d->nidn ?>)
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="m-simpan">Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permohonan Surat Izin Penelitian atau PkM</h1>
    </div>

    <?php if (!empty($this->session->flashdata('result'))): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('result') ?></div>
    <?php endif ?>

    <?php if (count($surat)): ?>
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Izin</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th width="40%">Judul</th>
                                <th>Jenis</th>
                                <th>Kepada</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th width="1">No</th>
                                <th>Nomor Surat</th>
                                <th width="40%">Judul</th>
                                <th>Jenis</th>
                                <th>Kepada</th>
                                <th width="1"></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($surat as $no => $s): ?>
                                <tr>
                                    <td><?php echo $no + 1 ?></td>
                                    <td><?php echo $s->nomor ?></td>
                                    <td><?php echo $s->judul ?></td>
                                    <td><?php echo $s->jenis == 'lit' ? 'Penelitian' : 'Pengabdian kepada Masyarakat' ?></td>
                                    <td><?php echo nl2br($s->tertuju) ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url("surat/izin/{$s->id}") ?>" class="btn btn-sm btn-link">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo site_url("surat/izin/{$s->id}/download") ?>" class="btn btn-sm btn-link text-success" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (count($permohonan)): ?>
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Permohonan Surat Izin</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered display" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th width="40%">Judul</th>
                                <th>Jenis</th>
                                <th>Kepada</th>
                                <th>Waktu Pengajuan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th width="1">No</th>
                                <th width="40%">Judul</th>
                                <th>Jenis</th>
                                <th>Kepada</th>
                                <th>Waktu Pengajuan</th>
                                <th width="1"></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($permohonan as $no => $s): ?>
                                <tr>
                                    <td><?php echo $no + 1 ?></td>
                                    <td><?php echo $s->judul ?></td>
                                    <td><?php echo $s->jenis == 'lit' ? 'Penelitian' : 'Pengabdian kepada Masyarakat' ?></td>
                                    <td><?php echo nl2br($s->tertuju) ?></td>
                                    <td><?php echo nl2br(date("d/m/Y\nh:i:s", strtotime($s->waktu_pengajuan))) ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo site_url("surat/izin/{$s->id}") ?>" class="btn btn-sm btn-link">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo site_url("surat/izin/{$s->id}/delete") ?>" class="u-hapus btn btn-sm btn-link text-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif ?>

    <a id="baru"></a>

    <?php if (!empty($this->session->flashdata('error'))): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
    <?php endif ?>

    <form method="post">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Buat Permohonan Baru</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="judul" class="col-md-2 col-form-label">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <input class="form-control" name="judul" id="judul">
                            <div class="input-group-append">
                                <button type="button" id="u-tampil" class="btn btn-outline-secondary"
                                    data-toggle="modal" data-target="#u-modal">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis" class="col-md-2 col-form-label">Jenis</label>
                    <div class="col-md-10">
                        <select class="form-control" name="jenis" id="jenis">
                            <option value="">-- Pilih Salah Satu --</option>
                            <option value="lit">Penelitian</option>
                            <option value="pkm">Pengabdian kepada Masyarakat</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Anggota Dosen</label>
                    <div class="col-md-10">
                        <p class="form-control-plaintext">
                            Kelola anggota (<b class="text-danger">bukan ketua</b>) yang ingin dimasukkan namanya di surat izin.
                        </p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIDN/NPP</th>
                                    <th>Nama</th>
                                    <th class="text-right">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#m-modal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="m-data">
                                <tr class="m-no-data">
                                    <td colspan="4">Belum ada anggota dosen yang didata</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tertuju" class="col-md-2 col-form-label">Kepada</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="tertuju" id="tertuju"></textarea>
                        <small class="form-text text-muted">
                            <u><b>Contoh:</b></u>
                            <div class="ml-3">
                                Kepala Dinas Kesehatan<br>
                                Kota Yogyakarta
                            </div>
                        </small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tempat" class="col-md-2 col-form-label">di</label>
                    <div class="col-md-10">
                        <input class="form-control" name="tempat" id="tempat">
                        <small class="form-text text-muted">
                            <u><b>Contoh:</b></u>
                            <div class="ml-3">
                                Yogyakarta
                            </div>
                        </small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lokasi" class="col-md-2 col-form-label">Lokasi Kegiatan</label>
                    <div class="col-md-10">
                        <input class="form-control" name="lokasi" id="lokasi">
                        <small class="form-text text-muted">
                            <u><b>Contoh:</b></u>
                            <div class="ml-3">
                                Puskesmas Tegalrejo 2
                            </div>
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-user" style="width:200px">
                    <i class="far fa-paper-plane mr-2"></i> Kirimkan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function bersihkanAnggota() {
    $('#m-data tr.m-item').remove();
    $('.m-no-data').show();
}

function hapusAnggota(el) {
    if (!confirm('Data ini benar-benar akan dihapus?')) return;

    $(el).parent().parent().remove();
    if ($('#m-data tr').length == 1) {
        $('.m-no-data').show();
    } else {
        $('#m-data tr.m-item td:first-child').each(function(i) {
            $(this).text(i + 1);
        });
    }
}

function tambahAnggota(id, nidn, nama) {
    $('.m-no-data').hide();

    let no = $('#m-data tr').length;
    $('#m-data').append(`<tr class="m-item">
        <td>${no}</td>
        <td>${nidn}<input type="hidden" name="m_nidn[]" value="${nidn}"></td>
        <td>${nama}<input type="hidden" name="m_nama[]" value="${nama}"></td>
        <td class="text-right">
            <input type="hidden" name="m_id[]" value="${id}">
            <button type="button" class="btn btn-sm" onclick="hapusAnggota(this)">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>`);
}

$('#u-pilih').on('click', async ev => {
    let idVal = $('#u-id').val();
    if (idVal == '') {
        alert('Mohon dipilih salah satu');
        return;
    }
    let judul = $('#u-id :selected').text().trim();
    let jenis = idVal.substr(0, 3);
    let id = idVal.substr(4);

    $('#u-modal').modal('hide');

    $('#judul').val(judul);
    $('#jenis').val(jenis);

    bersihkanAnggota();
    let tipe = jenis == 'lit' ? 'submit' : 'pengabdian';
    let anggota = await (await fetch(`/${tipe}/anggotadosen/${id}`)).json();
    for (const a of anggota) {
        tambahAnggota(a['id'], a['nidn'], a['namalengkap']);
    }
});

$('.u-hapus').on('click', ev => {
    if (!confirm('Anda benar-benar mau menghapus data ini?')) {
        return false;
    }
});

$('#m-simpan').on('click', ev => {
    let id = $('#m-id').val();
    if (id == '') {
        alert('Mohon dipilih salah satu');
        return;
    }
    let namaID = $('#m-id :selected').text().trim();
    let nama = namaID.substr(0, namaID.indexOf(' ('));
    let nidn = namaID.substring(namaID.indexOf(' (') + 2, namaID.length - 1);

    $('#m-modal').modal('hide');
    tambahAnggota(id, nidn, nama);
});

$(document).ready(function() {
    $('#m-modal').on('shown.bs.modal', function() {
        $('#m-id').trigger('focus');
    });
    setTimeout(() => $('.alert').hide(), 3000);
    <?php if (!empty($prev_input = $this->session->flashdata('input'))): ?>
        let prevInput = <?php echo json_encode($prev_input) ?>;
        $('#judul').val(prevInput.judul);
        $('#jenis').val(prevInput.jenis);
        $('#tertuju').val(prevInput.tertuju);
        $('#tempat').val(prevInput.tempat);
        $('#lokasi').val(prevInput.lokasi);
        for (const i in prevInput.m_id) {
            tambahAnggota(prevInput.m_id[i], prevInput.m_nidn[i], prevInput.m_nama[i]);
        }
    <?php endif ?>
});
</script>
