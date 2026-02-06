<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Review Laporan Akhir Penelitian</h1>
          </div>
		  
			<?php
				if($this->session->flashdata('result')<>'')
				{
					echo '<div class="alert alert-success" role="alert">'.
						$this->session->flashdata('result').'
						</div>';
				}
			?>
			
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Review Laporan Akhir Penelitian</h6>
            </div>
            <div class="card-body">
              <form class="user" method="post" action="<?php echo base_url().'submit/updatereviewlaporan/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
				  <input type="hidden" name="idlaporan" value="<?php echo $review['id_reviewlaporan']; ?>">
				  <table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Kriteria Penilaian</th>
									<th scope="col">Bobot</th>
									<th scope="col"  width="14%">Skor (1-4)</th>
									<th scope="col">Nilai</th>
								</tr>
							</thead>
					  <?php 
							$skor = explode(',',$review['skor']);
							$hitskor = count($skor);
							if($review['skor']<>'' && $skor[0]<>'' && $hitskor>0)
							{
								$poin1 = $skor[0];
								$poin2 = $skor[1];
								$poin3 = $skor[2];
								$poin4 = $skor[3];
								$poin5 = $skor[4];
								$final = (($skor[0]*10)+($skor[1]*20)+($skor[2]*20)+($skor[3]*20)+($skor[4]*30))/4;
							}
							else
							{
								$poin1 = 0;
								$poin2 = 0;
								$poin3 = 0;
								$poin4 = 0;
								$poin5 = 0;
								$final = 0;
							}
					  ?>
					  <tbody>
								<tr>
									<td>1</td>
									<td>
										Ketepatan sistematika penulisan dan kesesuaian dengan pedoman laporan akhir penelitian
										<table class="table table-bordered">
										<tr><th>Skor</th><th>Keterangan</th></tr>
											<tr><td>1</td><td>Tidak tepat dalam menuliskan sistematika penulisan dan tidak sesuai dengan pedoman laporan akhir</td></tr>
											<tr><td>2</td><td>Tidak tepat dalam menuliskan sistematika penulisan tetapi sesuai dengan pedoman laporan akhir penelitian</td></tr>
											<tr><td>3</td><td>Tepat dalam menuliskan sistematika penulisan tetapi tidak sesuai dengan pedoman laporan akhir penelitian.</td></tr>
											<tr><td>4</td><td>Tepat dalam menuliskan sistematika penulisan dan sesuai dengan pedoman laporan akhir penelitian.</td></tr>
									</table>
									</td>
									<td><b id="skor1">10</b></td>
									<td>
										<input type="hidden" id="reviewidusulanya" name="id">
										<input type="text" name="poinsatu" value="<?=$poin1?>" data-poin="10" onkeyup="satu(value)" class="form-control rev" required>
									</td>
									<td><b id="nilai1"><?=$poin1*10?></b></td>
								</tr>
								<tr>
									<td>2</td>
									<td>
										Ketercapaian Tujuan Penelitian
										<table class="table table-bordered">
											<tr><th>Skor</th><th>Keterangan</th></tr>
												<tr><td>1</td><td>Hasil pembahasan penelitian tidak menjawab tujuan penelitian</td></tr>
												<tr><td>2</td><td>Hasil pembahasan penelitian kurang menjawab tujuan penelitian</td></tr>
												<tr><td>3</td><td>Hasil pembahasan penelitian cukup menjawab tujuan penelitian.</td></tr>
												<tr><td>4</td><td>Hasil pembahasan penelitian menjawab tujuan penelitian.</td></tr>
										</table>
									</td>
									<td><b id="skor2">20</b></td>
									<td><input type="text" name="poindua" data-poin="20" onkeyup="dua(value)" value="<?=$poin2?>" class="form-control rev" required></td>
									<td><b id="nilai2"><?=$poin2*20?></b></td>
								</tr>
								<tr>
									<td>3</td>
									<td>
										Kedalaman Pembahasan Penelitian
										<table class="table table-bordered">
											<tr><th>Skor</th><th>Keterangan</th></tr>
												<tr><td>1</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian tidak mendalam</td></tr>
												<tr><td>2</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian kurang mendalam</td></tr>
												<tr><td>3</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian cukup mendalam.</td></tr>
												<tr><td>4</td><td>Uraian data yang digunakan dalam penelitian, cara analisis, pembahasan hasil penelitian mendalam.</td></tr>
										</table>
									</td>
									<td><b id="skor3">20</b></td>
									<td><input type="text" name="pointiga" data-poin="20" onkeyup="tiga(value)" value="<?=$poin3?>" class="form-control rev" required></td>
									<td><b id="nilai3"><?=$poin3*20?></b></td>
								</tr>				
								<tr>
									<td>4</td>
									<td>
										Potensi keberlanjutan hasil penelitian :<br>
										<ol type="a">
											<li>Pendukung Pembelajaran</li>
											<li>Pengembangan Penelitian</li>
											<li>Pengabdian kepada Masyarakat</li>
										</ol>
										<table class="table table-bordered">
										<tr><th>Skor</th><th>Keterangan</th></tr>
											<tr><td>1</td><td>Hasil penelitian tidak berpotensi dalam mendukung pembelajaran, pengembangan penelitian, dan Pengabdian kepada Masyarakat</td></tr>
											<tr><td>2</td><td>Hasil penelitian mampu mendukung pembelajaran atau Pengabdian kepada Masyarakat tetapi tidak mendukung pengembangan penelitian</td></tr>
											<tr><td>3</td><td>Hasil penelitian mampu mengembangkan penelitian tetapi tidak mendukung untuk pembelajaran dan Pengabdian kepada Masyarakat</td></tr>
											<tr><td>4</td><td>Hasil penelitian berlanjut untuk pengembangan penelitian, Pengabdian kepada Masyarakat, dan berlanjut untuk pendukung pembelajaran.</td></tr>
									</table>
									</td>
									<td><b id="skor4">20</b></td>
									<td><input type="text" name="poinempat" data-poin="20" onkeyup="empat(value)" value="<?=$poin4?>" class="form-control rev" required></td>
									<td><b id="nilai4"><?=$poin4*20?></b></td>
								</tr>
								<tr>
									<td>5</td>
									<td>
										Kesesuaian Luaran penelitian dengan rencana di proposal
										<table class="table table-bordered">
											<tr><th>Skor</th><th>Keterangan</th></tr>
												<tr><td>1</td><td>Luaran penelitian tidak sesuai dengan rencana di proposal penelitian</td></tr>
												<tr><td>2</td><td>Luaran penelitian kurang sesuai (akreditasi jurnal yang disubmit, dibawah dari akreditasi jurnal yang diusulkan)</td></tr>
												<tr><td>3</td><td>Luaran penelitian cukup sesuai (nama jurnal yang disubmit tidak sesuai dengan yang diusulkan tetapi memiliki akreditasi jurnal yang sama)</td></tr>
												<tr><td>4</td><td>Luaran penelitian sesuai dengan rencana di proposal penelitian.</td></tr>
										</table>
									</td>
									<td><b id="skor5">30</b></td>
									<td><input type="text" name="poinlima" data-poin="30" onkeyup="lima(value)" value="<?=$poin5?>" class="form-control rev" required></td>
									<td><b id="nilai5"><?=$poin5*30?></b></td>
								</tr>
								<tr>
									<td colspan="2">Jumlah Nilai (Batas Nilai Lulus 70)</td>
									<td><b>100</b></td>
									<td></td>
									<td><b id="jmlnilai"><?=$final?></b></td>
								</tr>
							</tbody>
						</table>
				  <div class="form-group">
					<label for="recipient-name" class="col-form-label">Hasil Review:</label>
					<input type="hidden" name="id" class="form-control" id="idusulanya">
					<textarea rows="5" name="review" class="form-control" id="review" required><?php echo $review['hasilreview_laporan']; ?></textarea>
				  </div>
				  <div class="form-group">
					<label for="recipient-name" class="col-form-label">File Review (Biarkan kosong jika tidak ada perubahan ) :</label>
					<input type="file" name="hasilreview" class="form-control unggah" id="hasilreview">
					<p><?php echo $review['filereview_laporan']; ?></p>
				  </div>
			  </div>
			  <div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" value="Simpan" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>
              </form>
          </div>
        </div>
	<?php
		$dosen = $this->mdosen->select();
		$datanama = array();
		foreach($dosen as $d)
		{
			$datanama[] = array(
			  'value' => $d->id_dosen,
			  'label' => $d->namalengkap); 
		}
		$anggota = json_encode($datanama);
	?>

<script>
	function satu(ish){
		document.getElementById("nilai1").innerHTML = 10*ish;
	}
	
	function dua(ish){
		document.getElementById("nilai2").innerHTML = 20*ish;
	}
	
	function tiga(ish){
		document.getElementById("nilai3").innerHTML = 20*ish;
	}
	
	function empat(ish){
		document.getElementById("nilai4").innerHTML = 20*ish;
	}
	
	function lima(ish){
		document.getElementById("nilai5").innerHTML = 30*ish;
	}
	
	$('.user').on('input',function() {
		var totalSum = 0;
		
		$('.user .rev').each(function() {
			var inputVal = $(this).val();
			var inputSkor = $(this).data('poin');
			if($.isNumeric(inputVal)){
				totalSum += parseFloat((inputVal*inputSkor)/4);
			}
		});
		document.getElementById("jmlnilai").innerHTML = totalSum.toFixed(4);
	});
	
	$('.unggah').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>20)
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
		if(extension!='pdf')
			alert('Silakan upload file dengan ekstensi PDF!');
	});
	
	$(function () {
		//Date picker
		$('#tglmulai').datepicker({
		  changeMonth: true,
            changeYear: true,
            yearRange: '-100:+0',
			autoclose: true
		});
	});
	
	$(function () {
		//Date picker
		$('#tglakhir').datepicker({
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
	
	//autocomplete dosen
	$(function() {
		function split( val ) {
		return val.split( /,\s*/ );
		}
		function extractLast( term ) {
		return split( term ).pop();
		}
		
		var projects = <?php echo $anggota; ?>;
			 
		$( "#anggotadosen" )
		 // don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
		if ( event.keyCode === $.ui.keyCode.TAB &&
		$( this ).autocomplete( "instance" ).menu.active ) {
		event.preventDefault();
		}
		})
		.autocomplete({
		minLength: 0,
		source: function( request, response ) {
		// delegate back to autocomplete, but extract the last term
		response( $.ui.autocomplete.filter(
		projects, extractLast( request.term ) ) );
		},

		//    source:projects,    
		focus: function() {
		// prevent value inserted on focus
		return false;
		},
		select: function( event, ui ) {
		var terms = split( this.value );
		// remove the current input
		terms.pop();
		// add the selected item
		terms.push( ui.item.label );
		// add placeholder to get the comma-and-space at the end
		terms.push( "" );
		this.value = terms.join( ", " );
			
			var selected_label = ui.item.label;
			var selected_value = ui.item.value;
			
			var labels = $('#labels').val();
			var values = $('#values').val();
			
			if(labels == "")
			{
				$('#labels').val(selected_label);
				$('#values').val(selected_value);
			}
			else    
			{
				$('#labels').val(labels+","+selected_label);
				$('#values').val(values+","+selected_value);
			}   
			
		return false;
		}
		});

	});     
	
	/* Tanpa Rupiah */
	var nilai = document.getElementById('jmldana');
	var tanpa_rupiah = document.getElementById('jmldana');
	
	if(nilai.value != "")
		tanpa_rupiah.value = formatRupiah(nilai.value);
	
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
