<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Penelitian Tambahan</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Penelitian Tambahan</h6>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url().'dashboard/updatepenelitian'; ?>" enctype="multipart/form-data">
		<div class="row">
          <div class="form-group col-md-6">
				<input type="hidden" id="id_penelitian" name="id" value="<?php echo $tambahan['id_penelitian']; ?>">
				<label>Judul Penelitian</label>
				<textarea name="judul" id="judulpenelitian" class="form-control teliti1" placeholder="Judul Penelitian" required><?php echo ucwords(strtolower($tambahan['judul'])); ?></textarea>
				<label>Tahun Penelitian</label>
				<input type="text" name="tahun" value="<?php echo $tambahan['tahun']; ?>" class="form-control teliti2" placeholder="Tahun Penelitian" required>
				<label for="recipient-name" class="col-form-label">Jenis Penelitian :</label>
				<select name="jenis" id="selectjenis" class="form-control teliti3">
					<?php
						$jenis = array('Penelitian Dasar','Penelitian Terapan','Penelitian Dosen Pemula','Pengembangan Experimental','Penelitian Kejuangan');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['jenis']==$jenis[$i])
								echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
							else
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
				<label>Bidang Penelitian</label>
				<input type="text" name="bidang" value="<?php echo $tambahan['bidang']; ?>" class="form-control teliti4" placeholder="Bidang Penelitian" required>
				<label>Tujuan Sosial Ekonomi</label>
				<textarea name="tujuan" class="form-control teliti5" placeholder="Tujuan Sosial Ekonomi" required><?php echo $tambahan['tujuan']; ?></textarea>
				<label for="recipient-name" class="col-form-label">Sumber Dana</label><br>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="sumber" value="Dalam Negeri" <?php echo $tambahan['sumberdana'] == 'Dalam Negeri' ? 'Checked' : '';?>>
				  <label class="form-check-label">Dalam Negeri</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="sumber" value="Luar Negeri/Asing" <?php echo $tambahan['sumberdana'] == 'Luar Negeri/Asing' ? 'Checked' : '';?>>
				  <label class="form-check-label">Luar Negeri/Asing</label>
				</div>
			</div>
			<div class='form-group col-md-5'>
				<label for="recipient-name" class="col-form-label">Institusi Sumber Dana</label>
				<select name="institusi" id="selectinstitusi" class="form-control teliti7">
					<?php
						$peran = array('Swasta/Industri','DIKTI','Lembaga Multilateral','Lembaga Nirlaba','Internal Perguruan Tinggi','Pribadi Peneliti','Mandiri','Sumber Dana Lain');
						$n = count($peran);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['institusi'])
								echo '<option value="'.$peran[$i].'" selected>'.$peran[$i].'</option>';
							else
								echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
						}
					?>
				</select>
				<label>Jumlah Dana</label>
				<input type="text" name="dana" id="jmldana" value="<?php echo $tambahan['dana']; ?>" class="form-control teliti8" placeholder="Jumlah Dana" required>
				<label>Ketua Peneliti</label>
				<?php
					$namauthor = '';
					$ambil = explode(',',$tambahan['ketua']);
					$hit = count($ambil);
					
					if($tambahan['ketua']<>'') 
					{
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							$namauthor .= $dosen['namalengkap'];
						}
					}
					else
						$namauthor = 'Tidak Ada Ketua';
				?>
				<?php echo '<br>'.$namauthor; ?>
				<input type="text" name="ketua" id="ketua" class="form-control teliti9" placeholder="Ketua Peneliti Biarkan Kosong Jika tidak ada Perubahan">
					<input type="hidden" id="labelketua">
					<input type="hidden" name="idketua" value="<?php echo $tambahan['ketua']; ?>" id="valuesketua">
				<label>Jumlah Anggota</label>
				<input type="number" name="jmlanggota" value="<?php echo $tambahan['jmlanggota']; ?>" class="form-control teliti8" placeholder="Jumlah Anggota (Angka)" required>
				<label>Anggota Peneliti</label>
				<?php
					$namauthor = '';
					$ambil = explode(',',$tambahan['anggota']);
					$hit = count($ambil);
					
					if($tambahan['anggota']<>'') 
					{
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							$namauthor .= $dosen['namalengkap'];
							if($i<($hit-1))
								$namauthor .= ' , ';
						}
					}
					else
						$namauthor = 'Tidak Ada Author Lain';
				
				echo '<br>'.$namauthor; ?>
				<input type="text" name="anggotadosen" id="anggotadosen" class="form-control" placeholder="Anggota Peneliti Biarkan Kosong Jika tidak ada Perubahan">
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" value="<?php echo $tambahan['anggota']; ?>" id="values">
				<label>File Laporan Penelitian Akhir (PDF) maksimal 20MB</label>
				<input type="file" name="fileupload" class="form-control unggah" placeholder="File Jurnal (PDF)">
				<label for="recipient-name" class="col-form-label">File Laporan Penelitian Akhir : 
			<b class="teliti11"><?php echo $tambahan['file_laporan_akhir']; ?></b></label>
				
		  </div>
      </div>
      </div>
	  <div class="modal-footer">
		<a href="<?php echo base_url().'dashboard/index/penelitian'; ?>" type="button" class="btn btn-secondary">Batal</a>
		<button type="submit" id="tmbsimpan" class="btn btn-success">Simpan</button>
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
			document.getElementById("tmbsimpan").disabled = true;
		}
		else
		{
			document.getElementById("tmbsimpan").disabled = false;
		}
		if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			document.getElementById("tmbsimpan").disabled = true;
			return false;
		}
		else
		{
			document.getElementById("tmbsimpan").disabled = false;
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
	
	//autocomplete ketua
	$(function() {
		function split( val ) {
		return val.split( /,\s*/ );
		}
		function extractLast( term ) {
		return split( term ).pop();
		}
		
		var projects = <?php echo $anggota; ?>;
			 
		$( "#ketua" )
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
		this.value = terms.join( "" );
			
			var selected_label = ui.item.label;
			var selected_value = ui.item.value;
			
			var labels = $('#labelketua').val();
			var values = $('#valuesketua').val();
			
			if(labels == "")
			{
				$('#labelketua').val(selected_label);
				$('#valuesketua').val(selected_value);
			}
			
		return false;
		}
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
