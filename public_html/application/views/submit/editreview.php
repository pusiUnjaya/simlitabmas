<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Review</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Review Penelitian</h6>
            </div>
            <div class="card-body">
              <form class="user" method="post" action="<?php echo base_url().'submit/updatereview/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
				  <input type="hidden" name="idreview" value="<?php echo $review['id_review']; ?>">
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
								$poin6 = $skor[5];
								$poin7 = $skor[6];
								$poin8 = $skor[7];
								$poin9 = $skor[8];
								$poin10 = $skor[9];
								$tahun = date('Y',strtotime($review['modified']));
								$bulan = date('m',strtotime($review['modified']));
								if($tahun>=2023 && ($tahun<=2024 && $bulan<5))
									$final = (($skor[0]*20)+($skor[1]*15)+($skor[2]*20)+($skor[3]*15)+($skor[4]*10)+($skor[5]*20))/4;
								else if($tahun>=2024 && $bulan>=5)
									$final = (($skor[0]*10)+($skor[1]*10)+($skor[2]*10)+($skor[3]*10)+($skor[4]*10)+($skor[5]*10)+($skor[6]*10)+($skor[7]*10)+($skor[8]*10)+($skor[9]*10))/4;
								else
									$final = (($skor[0]*20)+($skor[1]*15)+($skor[2]*20)+($skor[3]*15)+($skor[4]*10)+($skor[5]*20))/7;
							}
							else
							{
								$poin1 = 0;
								$poin2 = 0;
								$poin3 = 0;
								$poin4 = 0;
								$poin5 = 0;
								$poin6 = 0;
								$poin7 = 0;
								$poin8 = 0;
								$poin9 = 0;
								$poin10 = 0;
								$final = 0;
							}
					  ?>
					  <tbody>
						<tr>
				  <td>1</td>
				  <td>
						Latar Belakang dan Perumusan Masalah :<br>
						<ol type="a">
							<li>Ketajaman Perumusan Masalah</li>
							<li>Tujuan Penelitian</li>
							<li>Spesifikasi keterkaitan topik penelitian dengan keunggulan PT (ketahanan nasional)</li>
						</ol>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Rumusan masalah tidak tajam dan tujuan penelitian tidak jelas</td></tr>
								<tr><td>2</td><td>Rumusan masalah kurang jelas dan kurang tajam, tujuan penelitian jelas</td></tr>
								<tr><td>3</td><td>Rumusan masalah jelas dan tajam akan tetapi tujuan jelas tetapi tidak terdapat uraian spesifikasi keterkaitan skema dengan bidang fokus atau renstra penelitian perguruan tinggi.</td></tr>
								<tr><td>4</td><td>Rumusan masalah jelas dan tajam akan tetapi tujuan jelas, serta terdapat uraian spesifikasi keterkaitan skema dengan bidang fokus atau renstra penelitian perguruan tinggi.</td></tr>
						</table>
				  </td>
				  <td><b id="skor1">10</b></td>
				  <td><input type="text" name="poinsatu" value="<?php echo $poin1; ?>" data-poin="10" onkeyup="satu(value)" class="form-control rev" required></td>
				  <td><b id="nilai1"><?php echo $poin1*10; ?></b></td>
				</tr>
				<tr>
					<td>2</td>
					<td>
						State of the art dan kebaruan :<br>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Tidak ada kebaruan dan tidak ada state of the art</td></tr>
								<tr><td>2</td><td>Kebaruan kurang signifikan namun ada state of the art</td></tr>
								<tr><td>3</td><td>Kebaruan cukup signifikan dan ada state of the art</td></tr>
								<tr><td>4</td><td>Kebaruan sangat signifikan dan ada state of the art</td></tr>
						</table>
				  </td>
				  <td><b id="skor2">10</b></td>
				  <td><input type="text" name="poindua" value="<?php echo $poin2; ?>" data-poin="10" onkeyup="dua(value)" class="form-control rev" required></td>
				  <td><b id="nilai2"><?php echo $poin2*10; ?></b></td>
				</tr>
				<tr>
				  <td>3</td>
				  <td>
						Kesesuaian dengan Roadmap Penelitian Program Studi dan Universitas
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Tidak ada roadmap</td></tr>
								<tr><td>2</td><td>Ada roadmap namun tidak jelas. Roadmap penelitian dosen tidak sesuai dengan roadmap program studi tetapi masih bisa dipayungi oleh roadmap universitas</td></tr>
								<tr><td>3</td><td>Roadmap jelas namun tidak ada penelitian sebelumnya yang mendasari, dan tidak ada keterkaitan antara milestone dengan usulan penelitian. Roadmap penelitian dosen tidak sesuai dengan roadmap program studi tetapi sesuai dengan keilmuan program studi</td></tr>
								<tr><td>4</td><td>Roadmap jelas, ada penelitian sebelumnya yang mendasari, dan ada keterkaitan antara milestone dengan usulan penelitian. Roadmap penelitian dosen sesuai dengan roadmap program studi dan universitas</td></tr>
						</table>
				  </td>
				  <td><b id="skor3">10</b></td>
				  <td><input type="text" name="pointiga" data-poin="10" value="<?php echo $poin3; ?>" onkeyup="tiga(value)" class="form-control rev" required></td>
				  <td><b id="nilai3"><?php echo $poin3*10; ?></b></td>
				</tr>
				<tr>
				  <td>4</td>
				  <td>
						Ketepatan dan kesesuaian metode yang digunakan
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Metode tidak tepat dan tidak sesuai dengan tujuan penelitian. Tidak terdapat diagram alir penelitian.</td></tr>
								<tr><td>2</td><td>Metode kurang tepat untuk menjawab tujuan penelitian. Diagram alir penelitian belum sesuai dengan tahapan penelitian.</td></tr>
								<tr><td>3</td><td>Metode tepat, diagram alir penelitian sesuai tahapan penelitian, tetapi belum mencantumkan tugas masing-masing anggota pengusul</td></tr>
								<tr><td>4</td><td>Metode tepat, diagram alir penelitian sesuai tahapan penelitian, dan mencantumkan tugas masing-masing anggota pengusul.</td></tr>
						</table>
				  </td>
				  <td><b id="skor4">10</b></td>
				  <td><input type="text" name="poinempat" value="<?php echo $poin4; ?>" data-poin="10" onkeyup="empat(value)" class="form-control rev" required></td>
				  <td><b id="nilai4"><?php echo $poin4*10; ?></b></td>
				</tr>				
				<tr>
				  <td>5</td>
				  <td>
						Kejelasan pembagian tugas tim peneliti dan keterlibatan mahasiswa MBKM<br>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Tidak ada pembagian tim</td></tr>
								<tr><td>2</td><td>Ada pembagian tim tapi tidak jelas</td></tr>
								<tr><td>3</td><td>Pembagian tim jelas tapi ada yang tidak sesuai dengan kepakaran.</td></tr>
								<tr><td>4</td><td>Pembagian tim jelas dan sesuai dengan kepakaran.</td></tr>
						</table>
				  </td>
				  <td><b id="skor5">10</b></td>
				  <td><input type="text" name="poinlima" value="<?php echo $poin5; ?>" data-poin="10" onkeyup="lima(value)" class="form-control rev" required></td>
				  <td><b id="nilai5"><?php echo $poin5*10; ?></b></td>
				</tr>
				<tr>
				  <td>6</td>
				  <td>
						Kesesuaian metode dengan waktu, luaran dan anggaran<br>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Metode tidak sinkron dengan waktu, luaran, dan fasilitas</td></tr>
								<tr><td>2</td><td>Metode ada yang sinkron dengan 1 kondisi diantara waktu, luaran, dan fasilitas</td></tr>
								<tr><td>3</td><td>Metode ada yang sinkron dengan 2 kondisi diantara waktu, luaran, dan fasilitas</td></tr>
								<tr><td>4</td><td>Secara keseluruhan metode sinkron dengan waktu, luaran, dan fasilitas</td></tr>
						</table>
				  </td>
				  <td><b id="skor6">10</b></td>
				  <td><input type="text" name="poinenam" value="<?php echo $poin6; ?>" data-poin="10" onkeyup="enam(value)" class="form-control rev" required></td>
				  <td><b id="nilai6"><?php echo $poin6*10; ?></b></td>
				</tr>
				<tr>
				  <td>7</td>
				  <td>
						Kesesuaian target TKT<br>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Penjelasan TKT tidak ada</td></tr>
								<tr><td>2</td><td>TKT tidak sesuai</td></tr>
								<tr><td>3</td><td>TKT kurang sesuai</td></tr>
								<tr><td>4</td><td>TKT sesuai.</td></tr>
						</table>
				  </td>
				  <td><b id="skor7">10</b></td>
				  <td><input type="text" name="pointujuh" value="<?php echo $poin7; ?>" data-poin="10" onkeyup="tujuh(value)" class="form-control rev" required></td>
				  <td><b id="nilai7"><?php echo $poin7*10; ?></b></td>
				</tr>
				<tr>
				  <td>8</td>
				  <td>
						Kebaruan referensi<br>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Tidak ada pustaka primer</td></tr>
								<tr><td>2</td><td>Pustaka tergolong primer dan mutakhir kurang dari 50%</td></tr>
								<tr><td>3</td><td>Pustaka tergolong primer dan mutakhir sejumlah 51-80%</td></tr>
								<tr><td>4</td><td>Pustaka tergolong primer dan mutakhir lebih besar 80%</td></tr>
						</table>
				  </td>
				  <td><b id="skor8">10</b></td>
				  <td><input type="text" name="poinlapan" value="<?php echo $poin8; ?>" data-poin="10" onkeyup="lapan(value)" class="form-control rev" required></td>
				  <td><b id="nilai8"><?php echo $poin8*10; ?></b></td>
				</tr>
				<tr>
				  <td>9</td>
				  <td>
						Relevansi dan kualitas referensi<br>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Referensi tidak relevan dan ada yang tidak disitasi dalam proposal</td></tr>
								<tr><td>2</td><td>Sebagian referensi tidak relevan</td></tr>
								<tr><td>3</td><td>Referensi relevan namun sebagian jurnal tidak bereputasi dan berdampak</td></tr>
								<tr><td>4</td><td>Referensi relevan dan dari jurnal bereputasi dan berdampak</td></tr>
						</table>
				  </td>
				  <td><b id="skor9">10</b></td>
				  <td><input type="text" name="poinsembilan" value="<?php echo $poin9; ?>" data-poin="10" onkeyup="sembilan(value)" class="form-control rev" required></td>
				  <td><b id="nilai9"><?php echo $poin9*10; ?></b></td>
				</tr>
				<tr>
				  <td>10</td>
				  <td>
						Peluang luaran penelitian<br>
						<ol type="a">
							<li>Publikasi Ilmiah</li>
							<li>Pengembangan iptek Sosial Budaya</li>
							<li>Pengayaan Bahan Ajar</li>
							<li>HKI</li>
						</ol>
						<table class="table table-bordered">
								<tr><th>Skor</th><th>Keterangan</th></tr>
								<tr><td>1</td><td>Tidak terdapat rencana publikasi ilmiah, tidak terdapat pengembangan iptek sosial budaya, tidak terdapat pengayaan bahan ajar, dan HAKI</td></tr>
								<tr><td>2</td><td>Terdapat perencanaan publikasi ilmiah, tapi tidak terdapat perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan tidak terdapat HAKI</td></tr>
								<tr><td>3</td><td>Terdapat perencanaan publikasi ilmiah, perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan tidak terdapat perencanaan HAKI</td></tr>
								<tr><td>4</td><td>Terdapat perencanaan publikasi ilmiah, perencanaan pengembangan iptek sosial budaya pengayaan bahan ajar dan HAKI.</td></tr>
						</table>
				  </td>
				  <td><b id="skor10">10</b></td>
				  <td><input type="text" name="poinsepuluh" value="<?php echo $poin10; ?>" data-poin="10" onkeyup="sepuluh(value)" class="form-control rev" required></td>
				  <td><b id="nilai10"><?php echo $poin10*10; ?></b></td>
				</tr>
				<tr>
				  <td colspan="2">Jumlah Nilai</td>
				  <td><b>100</b></td>
				  <td></td>
				  <td><b id="jmlnilai"><?php echo number_format($final,4); ?></b></td>
				</tr>
					  </tbody>
				  </table>
				  <div class="form-group">
					<label for="recipient-name" class="col-form-label">Hasil Review:</label>
					<input type="hidden" name="id" class="form-control" id="idusulanya">
					<textarea rows="5" name="review" class="form-control" id="review" required><?php echo $review['hasilreview']; ?></textarea>
				  </div>
				  <div class="form-group">
					<label for="recipient-name" class="col-form-label">File Review (Biarkan kosong jika tidak ada perubahan ) :</label>
					<input type="file" name="hasilreview" class="form-control unggah" id="hasilreview">
					<p><?php echo $review['filereview']; ?></p>
				  </div>
				  <div class="form-group">
					<label for="rekomendasi" class="col-form-label">Rekomendasi:</label>
					<select id="rekomendasi" name="rekomendasi" class="form-control rekomendasi">
						<?php
							if ($review['rekomendasi']=='Direkomendasikan') {
								echo '<option value="Direkomendasikan" selected>Direkomendasikan</option>';
								echo '<option value="Direkomendasikan Turun skema">Direkomendasikan Turun skema</option>';
								echo '<option value="Tidak direkomendasikan">Tidak direkomendasikan</option>';
							}else if ($review['rekomendasi']=='Direkomendasikan Turun skema'){
								echo '<option value="Direkomendasikan">Direkomendasikan</option>';
								echo '<option value="Direkomendasikan Turun skema" selected>Direkomendasikan Turun skema</option>';
								echo '<option value="Tidak direkomendasikan">Tidak direkomendasikan</option>';
							}else {
								echo '<option value="Direkomendasikan">Direkomendasikan</option>';
								echo '<option value="Direkomendasikan Turun skema">Direkomendasikan Turun skema</option>';
								echo '<option value="Tidak direkomendasikan" selected>Tidak direkomendasikan</option>';
							}
						?>
					</select>
				  </div>
			  </div>
			  <div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" value="Simpan" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block kirim">
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
		document.getElementById("nilai2").innerHTML = 10*ish;
	}
	
	function tiga(ish){
		document.getElementById("nilai3").innerHTML = 10*ish;
	}
	
	function empat(ish){
		document.getElementById("nilai4").innerHTML = 10*ish;
	}
	
	function lima(ish){
		document.getElementById("nilai5").innerHTML = 10*ish;
	}
	
	function enam(ish){
		document.getElementById("nilai6").innerHTML = 10*ish;
	}

	function tujuh(ish){
		document.getElementById("nilai7").innerHTML = 10*ish;
	}

	function lapan(ish){
		document.getElementById("nilai8").innerHTML = 10*ish;
	}

	function sembilan(ish){
		document.getElementById("nilai9").innerHTML = 10*ish;
	}

	function sepuluh(ish){
		document.getElementById("nilai10").innerHTML = 10*ish;
	}
	
	$('.user').on('input',function() {
		var totalSum = 0;
		
		$('.user .rev').each(function() {
			var inputVal = $(this).val();
			var inputSkor = $(this).data('poin');
			var year = <?php echo date('Y', strtotime($review['modified'])); ?>;
		  var month = <?php echo date('m', strtotime($review['modified'])); ?>;

			if(year>=2023 && (year<=2024 && month<5))
		 		totalSum += parseFloat((inputVal*inputSkor)/4);
		 	else if(year>=2024 && month>=5)
		 		totalSum += parseFloat((inputVal*inputSkor)/4);
			else
			{
				totalSum += parseFloat((inputVal*inputSkor)/7);	
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
		{
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			$(".kirim").attr('disabled', true);
		}
		else if(extension!='pdf')
		{
			alert('Silakan upload file dengan ekstensi PDF!');
			$(".kirim").attr('disabled', true);
		}
		else if(extension=='pdf' && ukuran>20)
		{
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			$(".kirim").attr('disabled', true);
		}
		else
		{
			$(".kirim").attr('disabled', false);
		}
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
