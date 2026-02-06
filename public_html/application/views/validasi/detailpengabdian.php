<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pengabdian Tambahan</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Detail Pengabdian Tambahan</h6>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo base_url().'validasi/updatepkm/'.$this->uri->segment(3); ?>" enctype="multipart/form-data">
		<div class="row">
          <div class="form-group col-md-6">
						<input type="hidden" id="id_pengabdian" value="<?php echo $tambahan['id_pengabdian'];?>" name="id">
						<label for="recipient-name" class="col-form-label">Jenis Kegiatan :</label>
						<label style="color:black"><?php echo $tambahan['jenis']; ?></label>
						<label for="recipient-name" class="col-form-label">Tingkat Penyelenggaraan :</label>
						<label style="color:black"><?php echo $tambahan['tingkat']; ?></label>
						<br><label>Judul Kegiatan (PkM) : </label>
						<label style="color:black"><?php echo ucwords(strtolower($tambahan['judul']));?></label>
						<label>Tahun : </label>
						<label style="color:black"><?php echo $tambahan['tahun'];?></label>
						<br><label>Jumlah Dana : </label>
						<label style="color:black"><?php echo rupiah($tambahan['dana'],2);?></label>
						<br><label for="recipient-name" class="col-form-label">Sumber Dana : </label>
						<label style="color:black"><?php echo $tambahan['sumberdana'];?></label>
						<br><label>Pelaksanaan : </label>
						<label style="color:black"><?php echo tgl_indo($tambahan['tglmulai'],2).' s/d '.tgl_indo($tambahan['tglakhir'],2);?></label>
          	<br><label for="recipient-name" class="col-form-label">Sumber Daya Iptek : </label>
				<label style="color:black"><?php echo $tambahan['iptek']; ?></label>
				<br><label>Jumlah Anggota : </label>
				<label style="color:black"><?php echo $tambahan['jmlanggota']; ?></label>
				<br><label>Jumlah Mahasiswa : </label>
				<label style="color:black"><?php echo $tambahan['mhs'];?></label>
				<br><label>Jumlah Alumni : </label>
				<label style="color:black"><?php echo $tambahan['alumni']==''?'Tidak Ada':$tambahan['alumni'];?></label>
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
						$dosen = $dosen;
					}
					else
						$dosen = '';
			  ?>	
			</div>
			<div class='form-group col-md-6'>
				<label>Ketua PkM : </label>
				<label style="color:black"><?php echo $dosen; ?></label>
				<?php
					$namauthor = '';
					$ambil = explode(',',$tambahan['anggota']);
					$hit = count($ambil);
					
					if($tambahan['anggota']<>'') 
					{
						if($hit>1)
								$namauthor = '<ol style="color:black">';
						for($i=0;$i<$hit;$i++)
						{
							$dosen = $this->mdosen->namadosen($ambil[$i]);
							if($hit>1)
									$namauthor .= '<li>'.$dosen['namalengkap'].'</li>';
							else
									$namauthor = $dosen['namalengkap'];
						}
						if($hit>1)
								$namauthor .= '</ol>';
					}
					else
						$namauthor = 'Tidak Ada Author Lain';
				?>
				<br><label>Anggota Peneliti : </label>
				<label style="color:black"><?php echo $namauthor; ?></label>
				<br><label>Jumlah Staff Pendukung : </label>
				<label style="color:black"><?php echo $tambahan['staff']==''?'Tidak Ada':$tambahan['staff'];?></label>
				<br><label for="recipient-name" class="col-form-label">Jenis Mitra :</label>
				<label style="color:black"><?php echo $tambahan['jenis_mitra']; ?></label>
				<label>Nama Mitra/CSR/Instansi/UKM : </label>
				<label style="color:black"><?php echo $tambahan['mitra'];?></label>
				<br><label>Bidang Usaha : </label>
				<label style="color:black"><?php echo $tambahan['bidang'];?></label>
				<br><label>Peningkatan Omzet : </label>
				<label style="color:black"><?php echo $tambahan['omzet']==''?'Tidak Ada':$tambahan['omzet'];?></label>
				<br><label>Dana Pendamping : </label>
				<label style="color:black"><?php echo rupiah($tambahan['dana_pendamping'],2);?></label>
				<br><label>File Pendukung : </label>
				<label style="color:black"><a href="<?php echo $tambahan['filependukung'];?>">download di sini</a></label>
				<br><label>File Laporan PkM Akhir : </label>
				<label style="color:black"><a href="<?php echo $tambahan['filelaporan'];?>">download di sini</a></label>
				<br><label style="color:black;">Status Validasi</label>
				<select name="valid" class="form-control">
					<?php
						$jenis = array('DiTolak','DiTerima');
						$n = count($jenis);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['validasi']==$i)
								echo '<option value="'.$i.'" selected>'.$jenis[$i].'</option>';
							else
								echo '<option value="'.$i.'">'.$jenis[$i].'</option>';
						}
					?>
				</select>
				<br><label style="color:black;">Catatan : </label>
				<textarea name="catatan" class="form-control teliti1" placeholder="Catatan Penelitian Tambahan" required><?php echo ucwords(strtolower($tambahan['catatan'])); ?></textarea>				
		  </div>
      </div>
      </div>
	  <div class="modal-footer">
		<a href="<?php echo base_url().'dashboard/index/pengabdian'; ?>" type="button" class="btn btn-secondary">Batal</a>
		<button type="submit" class="btn btn-success">Simpan</button>
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
