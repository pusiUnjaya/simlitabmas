<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dokumen Klinik Proposal Pengabdian</h1>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Proposal Pengabdian</h6>
            </div>
            <div class="card-body">
              <form class="user" action="<?php echo base_url(); ?>klinik/updatepkm" method="post" enctype="multipart/form-data">
                <div class="form-group">
				<input type="hidden" name="idklinik" class="form-control" value="<?php echo $klinik['idklinik'] ?>">
				<input type="hidden" name="jenis" class="form-control" value="Penelitian">
				  <label>Judul Pengabdian</label>
                  <input type="text" name="judul" value="<?php echo $klinik['judul'] ?>" class="form-control" placeholder="Masukkan Judul Pengabdian" required>
                </div>
				<div class="form-group row">
				<?php	
					if($klinik['anggota']<>'')
					{	
						$idosen = explode(',',$klinik['anggota']);
						$hid = count($idosen);
						$dosen = '';
						for($i=0;$i<$hid;$i++)
						{
							$namanya = $this->mdosen->namadosen($idosen[$i]);
							$dosen .= $namanya['namalengkap'];
								if($i<($hid-1))
									$dosen .= ', ';
						}
						$dosen = '<p style="color:blue">'.$dosen.'</p>';
					}
					else
						$dosen = '';
				?>	
                  <div class="col-sm-6">
                    <label>Anggota Pengabdi(Maks 2 Anggota)</label>
					<?php echo $dosen; ?>
                    <input type="text" name="anggotadosen" id="anggotadosen" class="form-control" placeholder="Biarkan Kosong Jika tidak ada Perubahan">
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" id="values" value="<?php echo $klinik['anggota']; ?>">
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Skema Proposal</label>
					<select name="skema" id="skema" class="form-control">
						<option value="">-- Pilih Skema Proposal --</option>
						<?php
							$skempengabdian = array('Program Kemitraan Masyarakat (PKM)','Program Kemitraan Masyarakat Stimulus (PKMS)','Program Kuliah Kerja Nyata Pembelajaran dan Pemberdayaan Masyarakat (KKN-PPM)','Program Pengembangan Iptek Masyarakat (PPIM)','Program Pengembangan Desa Mitra (PPDM)','Program Pemberdayaan Masyarakat Unggulan Perguruan Tinggi (PPMUPT)','Program Kemitraan Wilayah (PKW)','Program Kemitraan Pengembangan Kewilayahan (PKPK)','Program Pengembangan Kewirausahaan (PPK)','Program Pengembangan Produk Unggulan Daerah (PPPUD)','Program Pengembangan Usaha Produk Intelektual Kampus (PPUPIK)');
							$sp = count($skempengabdian);
							for($i=0;$i<$sp;$i++)
							{
								if($klinik['skema']==$skempengabdian[$i])
									echo '<option value="'.$skempengabdian[$i].'" selected>'.$skempengabdian[$i].'</option>';
								else
									echo '<option value="'.$skempengabdian[$i].'">'.$skempengabdian[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
					<label>Total RAB</label>
                    <input type="text" name="rab" id="jmldana" class="form-control" placeholder="Masukkan Total RAB" value="<?php echo $klinik['rab']; ?>" required>
                  </div>
                  <div class="col-sm-6">
					<label>File Proposal</label>
					<input type="file" name="proposal" class="form-control unggah" placeholder="Masukkan File Proposal">
					<?php echo $klinik['dokumen']; ?>
                  </div>
                </div>
				<div class="col-sm-12 d-sm-flex align-items-center justify-content-between mb-4">
					<input type="button" onclick="history.back()" value="Cancel" class="d-sm-inline-block col-sm-5 btn btn-danger btn-user btn-block">
					<input type="submit" id="tmbsimpan" value="Simpan" class="d-sm-inline-block col-sm-5 btn btn-primary btn-user btn-block">
				</div>
            
              </form>
            </div>
          </div>
        </div>
		
		<?php
			$dosen = $this->mdosen->anggotadosen();
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
		if(ukuran>10)
		{
			alert('Ukuran File Lebih dari batas maksimal 10MB: ' + ukuran.toFixed(2) + "MB");
			$("#tmbsimpan").attr('disabled', true);
		}
		else
		{
			$("#tmbsimpan").attr('disabled', false);
		}
		if(extension!='pdf'){
			alert('Silakan upload file yang memiliki ekstensi .pdf ');
			$("#tmbsimpan").attr('disabled', true);
			return false;
		}
		else
		{
			$("#tmbsimpan").attr('disabled', false);
		}
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