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
              <form class="user" method="post" action="<?php echo base_url().'pengabdian/updatereview/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
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
								if(array_key_exists("6",$skor))
									$poin7 = $skor[6];
								else
									$poin7 = 0;
								$final = (($poin1*20)+($poin2*15)+($poin3*20)+($poin4*15)+($poin5*10)+($poin6*10)+($poin7*10))/4;
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
								$final = 0;
							}
					  ?>
					  <tbody>
						<tr>
						  <td>1</td>
						  <td>
								Analisis Situasi (masalah yang diangkat sebagai latar belakang)
						  </td>
						  <td><b id="skor1">20</b></td>
						  <td><input type="text" name="poinsatu" data-poin="20" onkeyup="satu(value)" value="<?php echo $poin1; ?>" class="form-control rev" required></td>
						  <td><b id="nilai1"><?php echo $poin1*20; ?></b></td>
						</tr>
						<tr>
						  <td>2</td>
						  <td>
								Kecocokan permasalahan dengan program serta kompetensi tim
						  </td>
						  <td><b id="skor2">15</b></td>
						  <td><input type="text" name="poindua" data-poin="15" onkeyup="dua(value)" class="form-control rev" value="<?php echo $poin2; ?>" required></td>
						  <td><b id="nilai2"><?php echo $poin2*15; ?></b></td>
						</tr>
						<tr>
						  <td>3</td>
						  <td>
								Solusi yang ditawarkan (Ketepatan Metode pendekatan untuk mengatasi permasalahan, Rencana kegiatan, kontribusi partisipasi tim)
						  </td>
						  <td><b id="skor3">20</b></td>
						  <td><input type="text" name="pointiga" data-poin="20" onkeyup="tiga(value)" value="<?php echo $poin3; ?>" class="form-control rev" required></td>
						  <td><b id="nilai3"><?php echo $poin3*20; ?></b></td>
						</tr>				
						<tr>
						  <td>4</td>
						  <td>
								Target Luaran (Jenis luaran dan spesifikasinya sesuai kegiatan yang diusulkan)
						  </td>
						  <td><b id="skor4">15</b></td>
						  <td><input type="text" name="poinempat" data-poin="15" onkeyup="empat(value)" value="<?php echo $poin4; ?>" class="form-control rev" required></td>
						  <td><b id="nilai4"><?php echo $poin4*15; ?></b></td>
						</tr>
						<tr>
						  <td>5</td>
						  <td>
								Kesesuaian dengan fokus unggulan road map unggulan program studi 
						  </td>
						  <td><b id="skor5">10</b></td>
						  <td><input type="text" value="<?php echo $poin1; ?>" name="poinlima" data-poin="10" onkeyup="lima(value)" class="form-control rev" required></td>
						  <td><b id="nilai5"><?php echo $poin5*10; ?></b></td>
						</tr>
						<tr>
						  <td>6</td>
						  <td>
								Pengabdian merupakan tindak lanjut dari hasil penelitian
						  </td>
						  <td><b id="skor6">10</b></td>
						  <td><input type="text" value="<?php echo $poin6; ?>" name="poinenam" data-poin="10" onkeyup="enam(value)" class="form-control rev" required></td>
						  <td><b id="nilai6"><?php echo $poin6*10; ?></b></td>
						</tr>
						<tr>
						  <td>7</td>
						  <td>
								Keterkaitan dengan proses pembelajaran
						  </td>
						  <td><b id="skor6">10</b></td>
						  <td><input type="text" value="<?php echo $poin7; ?>" name="pointujuh" data-poin="10" onkeyup="tujuh(value)" class="form-control rev" required></td>
						  <td><b id="nilai7"><?php echo $poin7*10; ?></b></td>
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
		document.getElementById("nilai1").innerHTML = 20*ish;
	}
	
	function dua(ish){
		document.getElementById("nilai2").innerHTML = 15*ish;
	}
	
	function tiga(ish){
		document.getElementById("nilai3").innerHTML = 20*ish;
	}
	
	function empat(ish){
		document.getElementById("nilai4").innerHTML = 15*ish;
	}
	
	function lima(ish){
		document.getElementById("nilai5").innerHTML = 10*ish;
	}
	
	function enam(ish){
		document.getElementById("nilai6").innerHTML = 10*ish;
		var six = document.getElementById("nilai6").innerHTML = 10*ish;
	}
	
	function tujuh(ish){
		document.getElementById("nilai7").innerHTML = 10*ish;
		var seven = document.getElementById("nilai7").innerHTML = 10*ish;
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
