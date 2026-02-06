<script>
let indikator = <?php echo json_encode($indikator) ?>;
let capaian = <?php echo json_encode($capaian) ?>;
let jenis = '<?php echo $jenis ?>';
let tingkat = '<?php echo $tingkat ?>';
</script>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Perhitungan TKT</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Indikator dan Capaiannya</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="user" action="<?php echo base_url(); ?>submit/simpan_tkt" method="post">
                <input type="hidden" name="id_usulan" value="<?php echo $id_usulan ?: '' ?>">
                <div class="form-group row">
                    <div class="col-sm-12 mb-3 mb-sm-0">
                        <label>Jenis/Kategori TKT</label>
                        <select name="jenis_tkt" class="form-control">
                            <?php foreach ($indikator as $id_jenis => $jenis_tkt): ?>
                                <option value="<?php echo $id_jenis ?>"<?php if ($id_jenis == $jenis): ?> selected<?php endif ?>>
                                    Jenis <?php echo $jenis_tkt->jenis ?> 
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <nav>
                    <div class="nav nav-pills mb-1 d-flex justify-content-start" id="nav-tkt-tab" role="tablist">
                        <?php foreach ($indikator[$jenis]->tkt as $id_tingkat => $tkt): ?>
                            <button type="button" role="tab" class="nav-link btn-sm
                                <?php if ($id_tingkat == $tingkat): ?> active<?php endif ?>
                                <?php if ($id_tingkat > $tingkat): ?> disabled<?php endif ?>
                                px-2 py-1 mr-2 mb-2" id="nav-tkt-<?php echo $id_tingkat ?>-tab"
                                data-toggle="pill" data-target="#nav-tkt-<?php echo $id_tingkat ?>"
                                aria-selected="true" aria-controls="nav-tkt-<?php echo $id_tingkat ?>">
                                TKT <?php echo $id_tingkat ?> 
                            </button>
                        <?php endforeach ?>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tkt-tabContent">
                    <?php foreach ($indikator[$jenis]->tkt as $id_tingkat => $tkt): ?>
                        <div id="nav-tkt-<?php echo $id_tingkat ?>" role="tabpanel"
                            class="tab-pane fade<?php if ($id_tingkat == $tingkat): ?> show active<?php endif ?>"
                            aria-labelledby="nav-tkt-<?php echo $id_tingkat ?>-tab">
                            <p><?php echo $tkt->definisi ?></p>
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-right">No.</th>
                                    <th>Butir-Butir Indikator</th>
                                    <th class="text-right">% Capaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tkt->indikator as $nomor => $itkt): ?>
                                    <tr>
                                        <td class="text-right"><?php echo $nomor ?>.</td>
                                        <td><?php echo $itkt->indikator ?></td>
                                        <td class="text-right">
                                            <select name="capaian<?php echo "[$jenis][$id_tingkat][$nomor]" ?>"
                                                style="text-align-last: right;">
                                                <?php $cp = $capaian[$jenis][$id_tingkat][$nomor] ?>
                                                <?php for ($i = 0; $i <= 100; $i += 20): ?>
                                                    <option value="<?php echo $i ?>"<?php
                                                        if ($i == $cp): ?> selected<?php endif
                                                    ?> style="direction: rtl;"><?php echo $i ?></option>
                                                <?php endfor ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="2" class="text-right">Rata-Rata:</td>
                                    <td class="text-right pr-4" id="average-<?php echo "$jenis-$id_tingkat" ?>">0</td>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    <?php endforeach ?>
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
$('[name="jenis_tkt"]').on('change', function() {
    let id_jenis = $(this).find(':selected').val();
    let suffix = '/' + id_jenis;
    // let suffix = (+id_jenis > 1) ? ('/' + id_jenis) : '';
    window.location.replace("<?php echo base_url('submit/tkt/'.($id_usulan ?: 'new')) ?>" + suffix);
});

let capaianChange = function() {
    let prefix = 'capaian[' + jenis + '][' + tingkat + '][';
    let elements = $('[name^="' + prefix + '"]');
    let count = elements.length;
    if (count == 0) return;
    let total = elements.toArray().reduce((acc, cur) => acc + 1*$(cur).find(':selected').val(), 0);
    let mean = total != 0 ? total/count : 0;
    $('#average-' + jenis + '-' + tingkat).text((mean).toFixed(2));
    let nextTab = $('#nav-tkt-' + (+tingkat + 1) + '-tab');
    nextTab[mean > 80 ? 'removeClass' : 'addClass']('disabled');
};

$('button[id^="nav-tkt-"][id$="-tab"]').on('click', function() {
    tingkat = $(this).attr('id').split('-')[2];
    capaianChange();
});

$('[name^="capaian"]').on('change', capaianChange);

capaianChange();
</script>