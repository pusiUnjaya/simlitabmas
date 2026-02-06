<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengelolaan Surat Izin Penelitian atau PkM</h1>
    </div>

    <?php if (!empty($this->session->flashdata('result'))): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('result') ?></div>
    <?php endif ?>

    <?php if (!empty($this->session->flashdata('error'))): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error') ?></div>
    <?php endif ?>

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
                            <th width="30%">Judul</th>
                            <th>Pemohon</th>
                            <th>Jenis</th>
                            <th>Kepada</th>
                            <th>Waktu Pengajuan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th width="30%">Judul</th>
                            <th>Pemohon</th>
                            <th>Jenis</th>
                            <th>Kepada</th>
                            <th>Waktu Pengajuan</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($surat as $no => $s): ?>
                            <tr>
                                <td><?php echo $no + 1 ?></td>
                                <td><?php echo $s->judul ?></td>
                                <td><?php echo $this->mdosen->namadosenprodi($s->id_dosen)['namalengkap'] ?></td>
                                <td><?php echo $s->jenis == 'lit' ? 'Penelitian' : 'Pengabdian kepada Masyarakat' ?></td>
                                <td><?php echo nl2br($s->tertuju) ?></td>
                                <td><?php echo nl2br(date("d/m/Y\nh:i:s", strtotime($s->waktu_pengajuan))) ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url("surat/izin/{$s->id}") ?>" class="btn btn-sm btn-link">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (empty($s->nomor)): ?>
                                        <a href="<?php echo site_url("surat/izin/{$s->id}/delete") ?>" class="u-hapus btn btn-sm btn-link text-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo site_url("surat/izin/{$s->id}/download") ?>" class="btn btn-sm btn-link">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$('.u-hapus').on('click', ev => {
    if (!confirm('Anda benar-benar mau menghapus data ini?')) {
        return false;
    }
});

$(document).ready(function() {
    setTimeout(() => $('.alert').hide(), 3000);
});
</script>