<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Pengabdian Tambahan</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengabdian Tambahan</h6>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url().'dashboard/updatepengabdian'; ?>" enctype="multipart/form-data">
		<div class="row">
          <div class="form-group col-md-6">
				<input type="hidden" id="id_pengabdian" value="<?php echo $tambahan['id_pengabdian'];?>" name="id">
				<label for="recipient-name" class="col-form-label">Jenis Kegiatan :</label>
				<select name="jenis" id="selectjenis" class="form-control teliti3">
					<?php
						$jenis = array('Kegiatan Non Insidental (1 - 6 Bulan)','Kegiatan Insidental (Kurang dari 1 Bulan)','PkM Lembaga');
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
				<label for="recipient-name" class="col-form-label">Tingkat Penyelenggaraan :</label>
				<select name="tingkat" id="selecttingkat" class="form-control teliti3">
					<?php
						$jenis = array('Lokal','Nasional','Internasional');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['tingkat']==$jenis[$i])
								echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
							else
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
				<label>Judul Kegiatan (PkM)</label>
				<textarea name="judul" id="judulpengabdian" class="form-control teliti1" placeholder="Judul Pengabdian" required><?php echo ucwords(strtolower($tambahan['judul']));?></textarea>
				<label>Tahun</label>
				<input type="text" value="<?php echo $tambahan['tahun'];?>" name="tahun" class="form-control teliti2" placeholder="Tahun" required>
				<label>Jumlah Dana</label>
				<input type="text" name="dana" id="jmldana" value="<?php echo $tambahan['dana'];?>" class="form-control teliti8" placeholder="Jumlah Dana" required>
				<label for="recipient-name" class="col-form-label">Sumber Dana</label>
				<select name="sumberdana" id="selectdana" class="form-control teliti7">
					<?php
						$peran = array('Internal PT','DIKTI','Pemda','CSR','Mandiri','Lainnya Dalam Negeri','Lainnya Luar Negeri');
						$n = count($peran);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['sumberdana']==$peran[$i])
								echo '<option value="'.$peran[$i].'" selected>'.$peran[$i].'</option>';
							else
								echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
						}
					?>
				</select>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Tanggal Mulai</label>
					<input type="text" name="tglmulai" class="form-control" id="tglmulai" placeholder="Tanggal Mulai" value="<?php echo $tambahan['tglmulai'];?>" required>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Tanggal Akhir</label>
					<input type="text" name="tglakhir" class="form-control" id="tglakhir" placeholder="Tanggal Akhir" value="<?php echo $tambahan['tglakhir'];?>" required>
                  </div>
                </div>
				<label for="recipient-name" class="col-form-label">Sumber Daya Iptek :</label>
				<select name="iptek" id="selectiptek" class="form-control teliti3">
					<?php
						$jenis = array('TIDAK ADA','Paten','Paten Sederhana','Perlindungan Varietas Tanaman','Hak Cipta','Merk Dagang','Rahasia Dagang','Desain Produk Industri','Indikasi Geografis','Perlindungan Desain Tata Letak Sirkuit Terpadu','Teknologi Tepat Guna','Model','Purwarupa (Prototype)','Karya Desain / Seni / Kriya / Bangunan dan Arsitektur','Rekayasa Sosial');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['iptek']==$jenis[$i])
								echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
							else
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
				<?php	
					if($tambahan['ketua']<>'')
					{	
						$idosen = explode(',',$tambahan['ketua']);
						$hid = count($idosen);
						$dosen = '';
						for($i=0;$i<$hid;$i++)
						{
							$namanya = $this->mdosen->namadosen($idosen[$i]);
							$dosen .= $namanya['namalengkap'];
								if($i<($hid-1))
									$dosen .= ', ';
						}
						$dosen = '<p>'.$dosen.'</p>';
					}
					else
						$dosen = '';
				  ?>	
				<label>Ketua PkM</label>
				<?php echo $dosen; ?>
				<input type="text" name="ketua" id="ketua" class="form-control teliti9" placeholder="Ketua Peneliti Biarkan Kosong jika Tidak Ada Perubahan">
					<input type="hidden" id="labelketua">
					<input type="hidden" name="idketua" value="<?php echo $tambahan['ketua'];?>" id="valuesketua">
				<label>Jumlah Anggota</label>
				<input type="number" name="jmlanggota" value="<?php echo $tambahan['jmlanggota']; ?>" class="form-control teliti8" placeholder="Jumlah Anggota (Angka)" required>
				<?php	
					if($tambahan['anggota']<>'')
					{	
						$idosen = explode(',',$tambahan['anggota']);
						$hid = count($idosen);
						$dosen = '';
						for($i=0;$i<$hid;$i++)
						{
							$namanya = $this->mdosen->namadosen($idosen[$i]);
							$dosen .= $namanya['namalengkap'];
								if($i<($hid-1))
									$dosen .= ', ';
						}
						$dosen = '<p>'.$dosen.'</p>';
					}
					else
						$dosen = '';
				  ?>	
				<label>Anggota Peneliti</label>
				<?php echo $dosen; ?>
				<input type="text" name="anggotadosen" id="anggotadosen" class="form-control" placeholder="Anggota Peneliti Biarkan Kosong jika Tidak Ada Perubahan">
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" value="<?php echo $tambahan['anggota'];?>" id="values">
			</div>
			<div class='form-group col-md-5'>
				<label>Jumlah Mahasiswa</label>
				<input type="text" name="mhs" value="<?php echo $tambahan['mhs'];?>" class="form-control teliti4" placeholder="Jumlah Mahasiswa (Boleh Kosong)">
				<label>Jumlah Alumni</label>
				<input type="text" name="alumni" value="<?php echo $tambahan['alumni'];?>" class="form-control teliti4" placeholder="Jumlah Alumni (Boleh Kosong)">
				<label>Jumlah Staff Pendukung</label>
				<input type="text" name="staff" value="<?php echo $tambahan['staff'];?>" class="form-control teliti4" placeholder="Jumlah Staff Pendukung (Boleh Kosong)">
				<label for="recipient-name" class="col-form-label">Jenis Mitra :</label>
				<select name="jenismitra" id="selectmitra" class="form-control teliti3">
					<?php
						$jenis = array('Mitra yang Non Produktif','Mitra yang produktif (IRT/UMKM)','Mitra CSR','Mitra Pemda (instansi)','Mitra Industri (UKM)','Mitra yang produktivitasnya meningkat','Mitra yang kualitas produknya meningkat','Mitra yang berhasil melakukan ekspor/ pemasaran antar pulau','Mitra yang menghasilkan usahawan muda','Mitra yang omzetnya meningkat','Mitra yang tenaga kerjanya meningkat','Mitra yang kemampuan manajemennya meningkat');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['jenis_mitra']==$jenis[$i])
								echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
							else
								echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
				<label>Nama Mitra/CSR/Instansi/UKM</label>
				<input type="text" name="mitra" value="<?php echo $tambahan['mitra'];?>" class="form-control teliti4" placeholder="Nama Mitra/CSR/Instansi/UKM" required>
				<label>Bidang Usaha</label>
				<input type="text" name="bidang" value="<?php echo $tambahan['bidang'];?>" class="form-control teliti4" placeholder="Bidang Usaha" required>
				<label>Peningkatan Omzet</label>
				<input type="text" name="omzet" value="<?php echo $tambahan['omzet'];?>" class="form-control teliti4" placeholder="Peningkatan Omzet">	
				<label>Dana Pendamping</label>
				<input type="text" name="pendamping" value="<?php echo $tambahan['dana_pendamping'];?>" class="form-control teliti4" placeholder="Dana Pendamping">
				<label>Dokumen Pendukung | Halaman Judul, Pengesahan, Surat Ijin Jalan (PDF) maksimal 20MB</label>
				<input type="file" name="filependukung" class="form-control unggah" placeholder="File Pendukung | Halaman Judul, Pengesahan, Surat Ijin Jalan (PDF)">
				<label for="recipient-name" class="col-form-label">File Pendukung : 
			<b class="teliti11"><?php echo $tambahan['filependukung'];?></b></label>
				<label>File Laporan PkM Akhir (PDF) maksimal 20MB</label>
				<input type="file" name="fileupload" class="form-control unggah" placeholder="File Laporan PkM Akhir (PDF)">
				<label for="recipient-name" class="col-form-label">File Laporan PkM Akhir : 
			<b class="teliti11"><?php echo $tambahan['filelaporan'];?></b></label>
				
		  </div>
      </div>
      </div>
	  <div class="modal-footer">
		<a href="<?php echo base_url().'dashboard/index/pengabdian'; ?>" type="button" class="btn btn-secondary">Batal</a>
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
