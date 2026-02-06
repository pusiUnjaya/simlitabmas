<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Naskah Akademik/Urgensi</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Naskah Akademik/Urgensi</h6>
            </div>
            <div class="card-body">
              <form id="tambahjurnal" method="post" action="<?php echo base_url().'dashboard/simpannaskah'; ?>" enctype="multipart/form-data">
		<div class="row">
          <div class="form-group col-md-6">
				<input type="hidden" id="id_naskah" value="<?php echo $tambahan['id_naskah'];?>" name="id">
				<label>Tahun Naskah</label>
				<select name="tahun" id="selecttahunnaskah" class="form-control naskah1">
					<?php
						$tahun = date('Y');
						for($i=0;$i<=15;$i++)
						{
							if($tambahan['tahun_naskah']==($tahun-$i))
								echo '<option value="'.($tahun-$i).'" selected>'.($tahun-$i).'</option>';
							else
								echo '<option value="'.($tahun-$i).'">'.($tahun-$i).'</option>';
						}
					?>
				</select>
				<label>Jenis Naskah</label>
				<select name="jenis" id="selectjenis" class="form-control naskah2">
					<?php
						$peran = array('Naskah Akademik','Naskah Urgensi');
						$n = count($peran);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['jenis_naskah']==$peran[$i])
								echo '<option value="'.$peran[$i].'" selected>'.$peran[$i].'</option>';
							else
								echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
						}
					?>
				</select>
				<label>Judul Naskah</label>
				<textarea name="judul" class="form-control naskah3" placeholder="Judul Naskah" required><?php echo ucwords(strtolower($tambahan['judul'])); ?></textarea>
				<label>Peruntukan Naskah</label>
				<select name="untuk" id="selectuntuk" class="form-control naskah4">
					<?php
						$peran = array('Undang-Undang', 'Peraturan Daerah','Peraturan Pemerintah','Peraturan Presiden');
						$n = count($peran);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['peruntukan_naskah']==$peran[$i])
								echo '<option value="'.$peran[$i].'" selected>'.$peran[$i].'</option>';
							else
								echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
						}
					?>
				</select>
				<label for="recipient-name" class="col-form-label">Sebagai Luaran :</label>
				<select name="sebagai" id="selectsebagai" class="form-control naskah10">
					<?php
						$sebagai = array('Luaran Penelitian', 'Luaran PkM', 'Luaran Pengajaran');
						$n = count($sebagai);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['sbgluaran']==$sebagai[$i])
								echo '<option value="'.$sebagai[$i].'" selected>'.$sebagai[$i].'</option>';
							else
								echo '<option value="'.$sebagai[$i].'">'.$sebagai[$i].'</option>';
						}
					?>
				</select>
				<label>Peran Penyusun Naskah</label>
				<select name="peran" id="selectperan" class="form-control naskah5">
					<?php
						$peran = array('Ketua', 'Anggota');
						$n = count($peran);
						for($i=0;$i<$n;$i++)
						{
							if($tambahan['peran_penyusun']==$peran[$i])
								echo '<option value="'.$peran[$i].'" selected>'.$peran[$i].'</option>';
							else
								echo '<option value="'.$peran[$i].'">'.$peran[$i].'</option>';
						}
					?>
				</select>
			</div>
			<div class='form-group col-md-5'>
				<label>Jumlah Anggota</label>
				<input type="number" name="jmlanggota" value="<?php echo $tambahan['jmlanggota']; ?>" class="form-control teliti8" placeholder="Jumlah Anggota (Angka)" required>
				<label>Author Lain</label>
				<?php 
					$namauthor = '';
					$ambil = explode(',',$tambahan['authorlain']);
					$hit = count($ambil);
					
					if($tambahan['authorlain']<>'') 
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
				echo "<br>".$namauthor; ?>
				<input type="text" name="authorlain" id="authorlain" class="form-control" placeholder="Author Lain Biarkan Kosong jika Tidak Ada Perubahan">
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" value="<?php echo $tambahan['authorlain']; ?>" id="values">
				<label>Tanggal Penyerahan</label>
				<input type="text" name="tgl" id="tglserah" value="<?php echo $tambahan['tgl_serah']; ?>" class="form-control naskah6" placeholder="Tanggal Penyerahan" required>
				<label>Pejabat Penerima Naskah</label>
				<input type="text" name="pejabat" value="<?php echo $tambahan['pejabat_penerima']; ?>" class="form-control naskah7" placeholder="Pejabat Penerima Naskah" required>
				<label>URL</label>
				<input type="text" value="<?php echo $tambahan['url']; ?>" name="url" class="form-control naskah8" placeholder="http:// (bila ada)">
				<label>File Naskah (PDF) maksimal 20MB</label>
				<input type="file" name="fileupload" class="form-control unggah" placeholder="File Naskah (PDF)">
				<label for="recipient-name" class="col-form-label">File Naskah : 
			<b class="naskah9"><?php echo $tambahan['dokumen']; ?></b></label>
		  </div>
      </div>
      </div>
	  <div class="modal-footer">
		<a href="<?php echo base_url().'dashboard/index/naskah'; ?>" type="button" class="btn btn-secondary">Batal</a>
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
		$('#tglserah').datepicker({
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
