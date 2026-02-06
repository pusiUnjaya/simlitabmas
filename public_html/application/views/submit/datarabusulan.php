<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rab Usulan</h1>
            <a type="button" href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="nambah" data-usulan="<?php echo $this->uri->segment(3);?>" data-toggle="modal" data-target="#rab-modal"><i class="fas fa-user-plus fa-sm text-white-50"></i> Masukkan RAB</a>
          </div>
          <!-- DataTales Example -->
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Total RAB</h6>
			  <?php
				$cekdana = $this->msubmit->cekdana($this->uri->segment(3));
				if($total=='')
					$rabnya = 0;
				else
					$rabnya = $total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor'];
				$hitung = ($cekdana['jmldana']+$cekdana['danaeks'])-$rabnya;
				if($rabnya < ($cekdana['jmldana']+$cekdana['danaeks']))
				{		
					echo '<h6 class="font-weight-bold text-danger" style="float:right;margin-top:-20px">RAB tidak sesuai Jumlah Dana, Kurang '.rupiah($hitung).'</h6>';
				}
				if($rabnya == ($cekdana['jmldana']+$cekdana['danaeks']))
				{		
					echo '<h6 class="font-weight-bold text-success" style="float:right;margin-top:-20px">RAB sudah sesuai Jumlah Dana, Kurang '.rupiah($hitung).'</h6>';
				}
			  ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Bahan</th>
                      <th>Pengumpulan Data</th>
                      <th>Sewa Peralatan</th>
                      <th>Analisis Data</th>
                      <th>Pelaporan dan Luaran</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						echo "<tr>
							  <td>".rupiah($total==''?0:$total['bahan'])."</td>
							  <td>".rupiah($total==''?0:$total['kumpul'])."</td>
							  <td>".rupiah($total==''?0:$total['sewa'])."</td>
							  <td>".rupiah($total==''?0:$total['analis'])."</td>
							  <td>".rupiah($total==''?0:$total['lapor'])."</td>
							  <td>".rupiah(($total==''?0:$total['bahan'])+($total==''?0:$total['kumpul'])+($total==''?0:$total['sewa'])+($total==''?0:$total['analis'])+($total==''?0:$total['lapor']))."</td>
							</tr>";
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Bahan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
					  <th>Item</th>
                      <th>Satuan</th>
                      <th>Volume</th>
                      <th>Harga Satuan</th>
                      <th>Total</th>
                      <th width="3%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						foreach($bahan as $p)
						{
							echo "<tr>
									  <td>".$no."</td>
									  <td>".$p->item."</td>
									  <td>".$p->satuan."</td>
									  <td>".$p->volume."</td>
									  <td>".rupiah($p->hargasatuan)."</td>
									  <td>".rupiah($p->hargasatuan*$p->volume)."</td>
									  <td><a href='#' data-id='".$p->id_rab."' data-usulan='".$p->usulan."' rel='tooltip' data-placement='top' title='Hapus Biaya' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a></td>
									</tr>";
							$no++;
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pengumpulan Data</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
					  <th>Item</th>
                      <th>Satuan</th>
                      <th>Volume</th>
                      <th>Harga Satuan</th>
                      <th>Total</th>
					  <th width="3%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						foreach($kumpul as $p)
						{
							echo "<tr>
									  <td>".$no."</td>
									  <td>".$p->item."</td>
									  <td>".$p->satuan."</td>
									  <td>".$p->volume."</td>
									  <td>".rupiah($p->hargasatuan)."</td>
									  <td>".rupiah($p->hargasatuan*$p->volume)."</td>
									  <td><a href='#' data-id='".$p->id_rab."' data-usulan='".$p->usulan."' rel='tooltip' data-placement='top' title='Hapus Biaya' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a></td>
									</tr>";
							$no++;
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Sewa Peralatan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
					  <th>Item</th>
                      <th>Satuan</th>
                      <th>Volume</th>
                      <th>Harga Satuan</th>
                      <th>Total</th>
					  <th width="3%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						foreach($sewa as $p)
						{
							echo "<tr>
									  <td>".$no."</td>
									  <td>".$p->item."</td>
									  <td>".$p->satuan."</td>
									  <td>".$p->volume."</td>
									  <td>".rupiah($p->hargasatuan)."</td>
									  <td>".rupiah($p->hargasatuan*$p->volume)."</td>
									  <td><a href='#' data-id='".$p->id_rab."' data-usulan='".$p->usulan."' rel='tooltip' data-placement='top' title='Hapus Biaya' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a></td>
									</tr>";
							$no++;
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Analisis Data</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
					  <th>Item</th>
                      <th>Satuan</th>
                      <th>Volume</th>
                      <th>Harga Satuan</th>
                      <th>Total</th>
					  <th width="3%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						foreach($analis as $p)
						{
							echo "<tr>
									  <td>".$no."</td>
									  <td>".$p->item."</td>
									  <td>".$p->satuan."</td>
									  <td>".$p->volume."</td>
									  <td>".rupiah($p->hargasatuan)."</td>
									  <td>".rupiah($p->hargasatuan*$p->volume)."</td>
									  <td><a href='#' data-id='".$p->id_rab."' data-usulan='".$p->usulan."' rel='tooltip' data-placement='top' title='Hapus Biaya' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a></td>
									</tr>";
							$no++;
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
		  <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pelaporan dan Luaran</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
					  <th>Item</th>
                      <th>Satuan</th>
                      <th>Volume</th>
                      <th>Harga Satuan</th>
                      <th>Total</th>
					  <th width="3%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$no = 1;
						foreach($lapor as $p)
						{
							echo "<tr>
									  <td>".$no."</td>
									  <td>".$p->item."</td>
									  <td>".$p->satuan."</td>
									  <td>".$p->volume."</td>
									  <td>".rupiah($p->hargasatuan)."</td>
									  <td>".rupiah($p->hargasatuan*$p->volume)."</td>
									  <td><a href='#' data-id='".$p->id_rab."' data-usulan='".$p->usulan."' rel='tooltip' data-placement='top' title='Hapus Biaya' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a></td>
									</tr>";
							$no++;
						}
					?>	
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

<div class="modal fade" id="rab-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Masukkan RAB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'submit/simpanrab/'.$this->uri->segment(3); ?>">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Item:</label>
            <input type="hidden" name="id" class="form-control" id="idusulanya">
            <input type="text" name="item" class="form-control" id="item" required>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Jenis:</label>
			<select name="jenis" class="form-control">
				<?php
					$jenis = array('Bahan','Pengumpulan Data','Sewa Peralatan','Analisis Data','Pelaporan dan Luaran');
					$n = count($jenis);
					for($i=0;$i<$n;$i++)
					{
						echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
					}
				?>
			</select>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Satuan:</label>
            <select name="satuan" class="form-control">
				<?php
					$jenis = array('Unit','Paket','OJ(Orang/Jam)','OH(Orang/Hari)','OB(Orang/Bulan)','OT(Orang/Tahun)','OP(Orang/Paket)','OK(Orang/Kegiatan)','OR(Orang/Responden)','Oter(Orang/Terbitan)','OJP(Orang/Jam Pelajaran)');
					$n = count($jenis);
					for($i=0;$i<$n;$i++)
					{
						echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
					}
				?>
			</select>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Volume:</label>
            <input type="text" name="volume" class="form-control" id="volume" required>
          </div>
		  <div class="form-group">
            <label for="recipient-name" class="col-form-label">Harga Satuan:</label>
            <input type="text" name="hargasatuan" class="form-control" id="hargasatuan" required>
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
    $(document).ready(function() {
        // Untuk sunting
        $('#rab-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#idusulanya').attr("value",div.data('usulan'));
        });
    });
	
	$(".hapus").click(function(){
    var id = $(this).data('id');
    var usulan = $(this).data('usulan');
    bootbox.confirm({
	    title: "Hapus Data?",
		message: "Anda Yakin Ingin Menghapus Data Sekarang? Setelah Hapus, Data Tidak Dapat Diperbaiki.",
		closeButton: false,
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Batal'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Hapus'
			}
		},
		callback: function (result)
		{
			if(result)
			window.location = "<?php echo base_url();?>submit/hapusrab/" + id + "/" + usulan;
		}
	})
	});
	
	/* Tanpa Rupiah */
	var tanpa_rupiah = document.getElementById('hargasatuan');
	tanpa_rupiah.addEventListener('keyup', function(e)
	{
		tanpa_rupiah.value = formatRupiah(this.value);
	});
	
	tanpa_rupiah.addEventListener('keydown', function(event)
	{
		limitCharacter(event);
	});
	
	function formatRupiah(bilangan, prefix)
	{
		var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
			split	= number_string.split(','),
			sisa 	= split[0].length % 3,
			rupiah 	= split[0].substr(0, sisa),
			ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
	
	function limitCharacter(event)
	{
		key = event.which || event.keyCode;
		if ( key != 188 // Comma
			 && key != 8 // Backspace
			 && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
			 && (key < 48 || key > 57) // Non digit
			 // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
			) 
		{
			event.preventDefault();
			return false;
		}
	}
</script>