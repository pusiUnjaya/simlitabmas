<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Submit Artikel Jurnal</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Form Submit Artikel Jurnal</h6>
            </div>
            <div class="card-body">
              <form id="tambahjurnal" method="post" action="<?php echo base_url().'dashboard/simpanjurnal'; ?>" enctype="multipart/form-data">
		<div class="row">
          <div class="form-group col-md-6">
				<input type="hidden" id="id_jurnal" name="id">
				<label>Judul Artikel</label><span id="judul_status"></span>
				<textarea onkeyup="cekjudul();" name="judul" id="juduljurnal" class="form-control jurnal1" placeholder="Judul Artikel" required></textarea>
				<label>Nama Jurnal</label>
				<input type="text" name="namajurnal" class="form-control jurnal2" placeholder="Nama Jurnal" required>
				<label for="recipient-name" class="col-form-label">Jenis Publikasi :</label>
				<select name="jenispublikasi" id="selectjenis" class="form-control jurnal3">
					<?php
						$jenis = array('Jurnal Nasional BerISSN','Jurnal Nasional Terakreditasi 6','Jurnal Nasional Terakreditasi 5','Jurnal Nasional Terakreditasi 4','Jurnal Nasional Terakreditasi 3','Jurnal Nasional Terakreditasi 2','Jurnal Nasional Terakreditasi 1','Jurnal Internasional','Jurnal Internasional Bereputasi');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
				<label for="recipient-name" class="col-form-label">Status Jurnal :</label>
				<select name="statusjurnal" id="selectstatus" class="form-control jurnal4">
					<?php
						$statusjurnal = array('Drafted', 'Submitted', 'Accepted', 'Published');
						$n = count($statusjurnal);
						for($i=0;$i<$n;$i++)
						{
							echo '<option value="'.$statusjurnal[$i].'">'.$statusjurnal[$i].'</option>';
						}
					?>
				</select>
				<label for="recipient-name" class="col-form-label">Sebagai Luaran :</label>
				<select name="sebagai" id="selectsebagai" class="form-control jurnal14">
					<?php
						$sebagai = array('Luaran Penelitian', 'Luaran PkM', 'Luaran Pengajaran');
						$n = count($sebagai);
						for($i=0;$i<$n;$i++)
						{
							echo '<option value="'.$sebagai[$i].'">'.$sebagai[$i].'</option>';
						}
					?>
				</select>
				<label for="recipient-name" class="col-form-label">Peran Penulis :</label>
				<select name="peranpenulis" id="selectperan" class="form-control jurnal5">
					<?php
						$peran = array('First Author','Co-Author','Corresponding Author');
						$n = count($peran);
						for($i=0;$i<$n;$i++)
						{
							echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
						}
					?>
				</select>
				<label>Tahun Publikasi</label>
				<input type="text" name="tahun" class="form-control jurnal6" placeholder="Tahun Publikasi" required>
				<label>Jumlah Anggota</label>
				<input type="number" name="jmlanggota" class="form-control teliti8" placeholder="Jumlah Anggota (Angka)" required>
			</div>
			<div class='form-group col-md-5'>
				<label>Author Lain</label>
				<input type="text" name="authorlain" id="authorlain" class="form-control" placeholder="Author Lain">
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" id="values">
				<label>Volume</label>
				<input type="text" name="volume" class="form-control jurnal7" placeholder="Volume" required>
				<label>Nomor</label>
				<input type="text" name="nomor" class="form-control jurnal8" placeholder="Nomor" required>
				<label>Nomor Halaman Awal</label>
				<input type="text" name="awal" class="form-control jurnal9" placeholder="Nomor Halaman Awal" required>
				<label>Nomor Halaman Akhir</label>
				<input type="text" name="akhir" class="form-control jurnal10" placeholder="Nomor Halaman Akhir" required>
				<label>URL Artikel</label>
				<input type="text" name="url" class="form-control jurnal11" placeholder="http://" required>
				<label>E-ISSN/P-ISSN</label>
				<input type="text" name="issn" class="form-control jurnal12" placeholder="ISSN" required>
				<label>File Jurnal (PDF) maksimal 20MB</label>
				<input type="file" name="fileupload" class="form-control unggah" placeholder="File Jurnal (PDF)" required>
				<label for="recipient-name" class="col-form-label">File Luaran Jurnal : 
			<b class="jurnal13"></b></label>
				
		  </div>
      </div>
      </div>
	  <div class="modal-footer">
		<a href="<?php echo base_url().'dashboard/index/jurnal'; ?>" type="button" class="btn btn-secondary">Batal</a>
		<button type="submit" id="idem" class="btn btn-success">Simpan</button>
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
	$('.unggah').bind('change', function() {
		var ukuran = this.files[0].size/1024/1024;
		fileName = this.files[0].name;
		regex = new RegExp('[^.]+$');
		extension = fileName.match(regex);
		if(ukuran>20)
		{
			alert('Ukuran File Lebih dari batas maksimal 20MB: ' + ukuran.toFixed(2) + "MB");
			document.getElementById("idem").disabled = true;
		}
		else
		{
			document.getElementById("idem").disabled = false;
		}
		if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			document.getElementById("idem").disabled = true;
			return false;
		}
		else
		{
			document.getElementById("idem").disabled = false;
		}
	});
	
	function cekjudul()
	{
		var judul=document.getElementById( "juduljurnal" ).value;
			
		if(judul)
		{
			$.ajax({
				type: 'post',
				url: "<?php echo base_url('dashboard/cekjuduljurnal');?>",
				data: {
					judul_jurnal:judul,
				},
			success: function (response) {
			$( '#judul_status' ).html(response);
			if(response=="Judul Belum Ada yang Memakai")	
			{
				$('#judul_status').css('color', 'green');
				$('#judul_status').css('float', 'right');
			  document.getElementById("idem").disabled = false;
			}
			else
			{
				document.getElementById("idem").disabled = true;
				$('#judul_status').css('color', 'red');
				$('#judul_status').css('float', 'right');
				return false;	
			}
			}
			});
		}
		else
		{
			$( '#judul_status' ).html("");
			return false;
		}
	}
	
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
			 
		$( "#authorlain" )
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
	var tanpa_rupiah = document.getElementById('jmldana');
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
