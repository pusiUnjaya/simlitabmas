<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Submit Usulan Baru</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Form Edit Usulan Penelitian</h6>
            </div>
            <div class="card-body">
              <form class="user" action="<?php echo base_url(); ?>submit/update" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $usulan['id_usulan']; ?>">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Judul Penelitian</label>
					<input type="text" name="judul" value="<?php echo ucwords(strtolower($usulan['judul'])); ?>" class="form-control" placeholder="Judul Penelitian" required>
                  </div>
                  <div class="col-sm-6">
					<label>Skema Penelitian</label>
					<select name="skema" class="form-control">
						<?php
							// $jenis = array('Dasar','Terapan','Pengembangan','Kejuangan');
							if($this->session->userdata('sesi_status')==1)
							{
								$jenis = array('Riset Pemula (RisLa)','Riset Fundamental (RisFun)','Riset Kejuangan (RisJuang)','Riset Kerjasama (RisKer)','Riset Terapan Hilirisasi (Risterasi)','Riset Mandatory (RisMa)','Riset Pengembangan (Risbang)');
							}
							else
								$jenis = $this->session->userdata('sesi_skema');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								if($usulan['skema']==$jenis[$i])
									echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
								else
									echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
							
						?>
					</select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Kategori Indikator TKT</label>
          <select name="kategoritkt" class="form-control">
						<?php
							$jenistkt = $this->mtkt->jenistkt();
							foreach($jenistkt as $j)
							{
								if($this->session->userdata('tkt')['jenis']==$j->id || $usulan['id_jenis_tkt']==$j->id || $usulan['kategoritkt']==$j->id)
									echo '<option value="'.$j->id.'" selected>'.$j->nama.'</option>';
								else
									echo '<option value="'.$j->id.'">'.$j->nama.'</option>';
							}
						?>
					</select>
                  </div>
                  <div class="col-sm-6">
                  	<div class="form-group row">
                  		<div class="col-sm-9">
					<label>Capaian TKT</label>
					<select name="capaiantkt" class="form-control">
						<?php
							$jenis = array('1','2','3','4','5','6','7','8','9');
							$n = count($jenis);
							$hasiltkt = $this->mtkt->ukur_tkt($this->session->userdata('tkt')['capaian']);
							for($i=0;$i<$n;$i++)
							{
								if($hasiltkt==$jenis[$i] || $usulan['capaiantkt']==$jenis[$i])
									echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
								else
									echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
						?>
					</select>
				</div>
					<div class="col-sm-3">
						<label> </label>
					<input type="button" onclick="location.href='<?php echo base_url();?>submit/tkt/<?php echo $this->uri->segment(3);?>'" value="Ukur TKT" style="margin-top: 10px;" class="btn-sm btn-primary btn-block">
                  </div>
                  </div>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-12">
                    <label>Luaran</label><br>
					<div class="col-sm-12 row">
					<?php
						$out = explode(',',$usulan['luaran']);
						$hitn = count($out);
												
						$issn = in_array('Jurnal Nasional BerISSN',$out) ? 'Checked' : '';
						$enam = in_array('Jurnal Nasional Terakreditasi 6',$out) ? 'Checked' : '';
						$lima = in_array('Jurnal Nasional Terakreditasi 5',$out) ? 'Checked' : '';
						$empat = in_array('Jurnal Nasional Terakreditasi 4',$out) ? 'Checked' : '';
						$tiga = in_array('Jurnal Nasional Terakreditasi 3',$out) ? 'Checked' : '';
						$dua = in_array('Jurnal Nasional Terakreditasi 2',$out) ? 'Checked' : '';
						$satu = in_array('Jurnal Nasional Terakreditasi 1',$out) ? 'Checked' : '';
						$inter = in_array('Jurnal Internasional',$out) ? 'Checked' : '';
						$interep = in_array('Jurnal Internasional Bereputasi',$out) ? 'Checked' : '';
						$paten = in_array('Paten',$out) ? 'Checked' : '';
						$hki = in_array('HKI',$out) ? 'Checked' : '';
						$bahanajar = in_array('Bahan Ajar',$out) ? 'Checked' : '';
						$prosiding = in_array('Prosiding',$out) ? 'Checked' : '';			
						
					?>
					<div class="col-sm-12 row">
					<div class="col-sm-4">
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $issn;?> value="Jurnal Nasional BerISSN">Jurnal Nasional BerISSN</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $enam;?> value="Jurnal Nasional Terakreditasi 6">Jurnal Nasional Terakreditasi 6</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $lima;?> value="Jurnal Nasional Terakreditasi 5">Jurnal Nasional Terakreditasi 5</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $empat;?> value="Jurnal Nasional Terakreditasi 4">Jurnal Nasional Terakreditasi 4</label>
					</div>
					</div>
					<div class="col-sm-4">
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $tiga;?> value="Jurnal Nasional Terakreditasi 3">Jurnal Nasional Terakreditasi 3</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $dua;?> value="Jurnal Nasional Terakreditasi 2">Jurnal Nasional Terakreditasi 2</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $satu;?> value="Jurnal Nasional Terakreditasi 1">Jurnal Nasional Terakreditasi 1</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $inter;?> value="Jurnal Internasional">Jurnal Internasional</label>
					</div>
					</div>
					<div class="col-sm-4">
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $interep;?> value="Jurnal Internasional Bereputasi">Jurnal Internasional Bereputasi</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $paten;?> value="Paten">Paten</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $hki;?> value="HKI">HKI</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $bahanajar;?> value="Bahan Ajar">Bahan Ajar</label>
					</div>
					<div class="form-check form-check-inline">
					  <label class="form-check-label"><input class="form-check-input" type="checkbox" name="luaran[]" <?php echo $prosiding;?> value="Prosiding">Prosiding</label>
					</div>
					</div>
					</div>
					</div>
					</div>
					
                </div>
				<div class="form-group row">
                  <div class="col-sm-12">
                    <label>Nama Jurnal</label>
					<input type="text" name="namajurnal" class="form-control" value="<?php echo $usulan['namajurnal']; ?>" placeholder="Nama Jurnal" required>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Sumber Dana</label>
					<select name="sumberdana" class="form-control">
						<?php
							$jenis = array('Mandiri','Internal','Mandiri+Internal','Kerjasama','Dikti','Kopertis');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								if($usulan['sumberdana']==$jenis[$i])
									echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
								else
									echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
                  </div>
                  <div class="form-group row">
					  <div class="col-sm-6">
						<label>Jumlah Dana Internal</label>
						<input type="text" id="jmldana" name="jmldana" class="form-control" value="<?php echo $usulan['jmldana'];?>" placeholder="Dana Internal" required>
					  </div>
					  <div class="col-sm-6">
						<label>Jumlah Dana Eksternal</label>
						<input type="text" id="danaeks" name="danaeks" value="<?php echo $usulan['danaeks'];?>" class="form-control" placeholder="Dana Eksternal" required>
					  </div>
				  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
				  <?php	
					if($usulan['anggotadosen']<>'')
					{	
						$idosen = explode(',',$usulan['anggotadosen']);
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

					if($usulan['anggotamhs']<>'')
					{	
						$idmhs = explode(',',$usulan['anggotamhs']);
						$his = count($idmhs);
						$mhs = '';
						for($i=0;$i<$his;$i++)
						{
							if($idmhs[$i]<>' ')
							{
								$namanya = $this->mpengabdian->namamhs($idmhs[$i]);
								$mhs .= $namanya['namamhs'];
								if($i<($his-1))
									$mhs .= ', ';
							}
						}
						$mhs = '<p style="margin-top:5px">'.$mhs.'</p>';
					}
					else
						$mhs = '';
				  ?>	
                    <label>Anggota Dosen</label>
					<input type="text" name="anggotadosen" id="anggotadosen" class="form-control" value="" placeholder="Biarkan Kosong Jika tidak ada Perubahan">
					<?php echo $dosen; ?>
					<input type="hidden" id="labels">
					<input type="hidden" name="iddosen" id="values" value="<?php echo $usulan['anggotadosen']; ?>">
					<span id="warnings"></span>
                  </div>
				  <div class="col-sm-2 mb-3 mb-sm-0">
                    <label>Jumlah Mahasiswa</label>
					<input name="jumlahmhs" id="jumlahmhs" type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" value="<?php echo $usulan['jumlahmhs'];?>" placeholder="Jml Mahasiswa" required>
                  </div>
				  <div class="col-sm-4 mb-3 mb-sm-0">
                    <label>Anggota Mahasiswa &nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#modal_mhs" type="button" class="btn-xs btn-primary">+ mhs</a></label>
					<!-- <textarea name="anggotamhs_" rows="3" class="form-control" placeholder="1. NIM/Mahasiswa" required></textarea> -->
					
					<input type="text" name="anggotamhs" id="anggotamhs" class="form-control" placeholder="Biarkan Kosong Jika tidak ada Perubahan">
					<input type="hidden" id="labelmhs">
					<input type="hidden" name="idmhs" value="<?php echo $usulan['anggotamhs']; ?>" id="valuemhs">
					<?php echo $mhs; ?>
					<span id="warningmhs"></span>
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Ringkasan</label>
					<textarea rows="5" name="ringkasan" class="form-control"><?php echo $usulan['ringkasan']; ?></textarea>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Kata Kunci</label>
					<textarea name="katakunci" class="form-control"><?php echo $usulan['katakunci']; ?></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <label>Tanggal Mulai</label>
					<input type="text" name="tglmulai" class="form-control" id="tglmulai" placeholder="Tanggal Mulai" required value="<?php echo $usulan['tglmulai']; ?>">
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Tanggal Akhir</label>
					<input type="text" name="tglakhir" class="form-control" id="tglakhir" placeholder="Tanggal Akhir" required value="<?php echo $usulan['tglakhir']; ?>">
                  </div>
                </div>
				<div class="form-group row">
                  <div class="col-sm-6">
                    <label>File Usulan (PDF) maksimal 20Mb - Biarkan Kosong Jika tidak ada Perubahan</label>
					<input type="file" name="fileupload" class="form-control unggah" placeholder="File Usulan (PDF)">
					<p><?php echo $usulan['fileusulan']; ?></p>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
				  <?php 
				    if($this->session->userdata('sesi_status')==1) {
				  ?>
                    <label>Status Usulan</label>
					<select name="statususulan" class="form-control">
						<?php
							$jenis = array('Usulan Baru','Usulan Dikirim','Reviewed','Usulan Disetujui Reviewer 1','Usulan Tidak Disetujui Reviewer 1','Usulan Disetujui Reviewer 2','Usulan Tidak Disetujui Reviewer 2','Usulan Disetujui','Usulan Tidak Disetujui');
							$n = count($jenis);
							for($i=0;$i<$n;$i++)
							{
								if($usulan['status']==$jenis[$i])
									echo '<option value="'.$jenis[$i].'" selected>'.$jenis[$i].'</option>';
								else
									echo '<option value="'.$jenis[$i].'">'.$jenis[$i].'</option>';
							}
 						?>
					</select>
					<?php } ?>	
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

   <!-- Modal Tambah Mahasiswa -->
	<div class="modal fade" id="modal_mhs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Mahasiswa</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="post" id="addmhs" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">NPM :</label>
							<input type="text" id="npm" name="npm" class="form-control" placeholder="NPM" required>
							<label for="recipient-name" class="col-form-label">Nama Mahasiswa :</label>
							<input type="text" id="namamhs" name="namamhs" class="form-control" placeholder="Nama Lengkap Mahasiswa" required>
						</div>
						<div class="form-group row">
                  <div class="col-sm-6">
                    <label>Fakultas</label>
					<select name="fakultas" id="fakultas" class="form-control">
						<option>-- Pilih Fakultas --</option>
						<?php
							foreach($fakultas as $p)
							{
								if($dosen['fakultas'] == $p->id_fak)
									echo '<option value="'.$p->id_fak.'" selected>'.$p->fakultas.'</option>';
								else
									echo '<option value="'.$p->id_fak.'">'.$p->fakultas.'</option>';
							}
 						?>
					</select>
                  </div>
				  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Program Studi</label>
					<select name="prodi" id="prodi" class="form-control">
						<?php
							$namaprodi = $this->mdosen->namaprodi($dosen['prodi']);
							echo '<option value="'.$dosen['prodi'].'">'.$namaprodi['prodi'].'</option>';
						?>
					</select>
                  </div>
                </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="button" id="btnSavemhs" disabled onclick="save()" class="btn btn-success">Simpan</button>
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
			if($d->user<>'')
				$max = $this->msubmit->hitambilmax($d->user,$d->id_dosen);
			else
				$max = 0;
			if($max<2)
			{
				$datanama[] = array(
			  'value' => $d->id_dosen,
			  'label' => $d->namalengkap); 
			} 
		}
		$anggota = json_encode($datanama);


		//anggota mhs
		$mhs = $this->mpengabdian->anggotamhs();
		$datamhs = array();
		foreach($mhs as $d)
		{
			$datamhs[] = array(
			  'value' => $d->idmhs,
			  'label' => $d->namamhs); 
		}
		$anggotamhs = json_encode($datamhs);
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
		if(terms.length <= 5) { 
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
			else
			{
				var last = terms.pop();
        $(this).val(this.value.substr(0, this.value.length - last.length - 1)); // removes text from input
        $(this).effect("highlight", {}, 1000);
        $(this).addClass("red");
        $("#warnings").html("<span style='color:red;'>Maks Jumlah Anggota 2</span>");
        return false;
			}
		}
		});

	});     

	//autocomplete mhs
	$(function() {
		function split( val ) {
		return val.split( /,\s*/ );
		}
		function extractLast( term ) {
		return split( term ).pop();
		}
		
		var projects = <?php echo $anggotamhs; ?>;
			 
		$( "#anggotamhs" )
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
		if(terms.length <= $('#jumlahmhs').val()) { 
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push( ui.item.label );
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
					
					var selected_label = ui.item.label;
					var selected_value = ui.item.value;
					
					var labels = $('#labelmhs').val();
					var values = $('#valuemhs').val();
					
					if(labels == "")
					{
						$('#labelmhs').val(selected_label);
						$('#valuemhs').val(selected_value);
					}
					else    
					{
						$('#labelmhs').val(labels+","+selected_label);
						$('#valuemhs').val(values+","+selected_value);
					}   
					
				return false;
			}
			else
			{
				var last = terms.pop();
        $(this).val(this.value.substr(0, this.value.length - last.length - 1)); // removes text from input
        $(this).effect("highlight", {}, 1000);
        $(this).addClass("red");
        $("#warningmhs").html("<span style='color:red;'>Maks Jumlah Anggota Mahasiswa "+$('#jumlahmhs').val()+"</span>");
        return false;
			}
		}
		});

	});   
	
	/* Tanpa Rupiah */
	var nominal = document.getElementById('danaeks');
	var nominal_tanpa = document.getElementById('danaeks');
	
	if(nominal.value != "")
		nominal_tanpa.value = formatRupiah(nominal.value);
	
	nominal.addEventListener('keyup', function(e)
	{
		nominal.value = formatRupiah(this.value);
	});
	
	nominal.addEventListener('keydown', function(event)
	{
		limitCharacter(event);
	});	
	
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

	$(document).ready(function() {
      $("#npm").on("input", function(e) {
        if ($('#npm').val() == null || $('#npm').val() == "") {
          // $('#hitung').show();
          // $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
          document.getElementById("btnSavemhs").disabled = true;
        }
        else
        {
          // $('#hitung').hide();
          $("#namamhs").on("input", function(e) {
		        if ($('#namamhs').val() == null || $('#namamhs').val() == "") {
		          // $('#hitung').show();
		          // $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
		          document.getElementById("btnSavemhs").disabled = true;
		        }
		        else
		        {
		          // $('#hitung').hide();
		          $("#prodi").on("input", function(e) {
				        if ($('#prodi').val() == null || $('#prodi').val() == "") {
				          // $('#hitung').show();
				          // $("#hitung").html("Password minimal 8 karakter dengan angka, simbol, huruf kapital dan huruf kecil.").css("color", "red");
				          document.getElementById("btnSavemhs").disabled = true;
				        }
				        else
				        {
				          // $('#hitung').hide();
				          document.getElementById("btnSavemhs").disabled = false;
				        }
				      });
		        }
		      });
        }
      });
    });

	function save()
	{
	    $('#btnSavemhs').text('saving...'); //change button text
	    $('#btnSavemhs').attr('disabled',true); //set button disable 
	    var url;
	 
	    url = "<?php echo site_url('submit/mhs_add')?>";

	    // ajax adding data to database
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: $('#addmhs').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {
	 
	            if(data.status) //if success close modal and reload ajax table
	            {
	                $('#modal_mhs').modal('hide');
	                location.reload();
	            }
	            
	            $('#btnSavemhs').text('save'); //change button text
	            $('#btnSavemhs').attr('disabled',false); //set button enable 
	 
	 
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	            $('#btnSavemhs').text('save'); //change button text
	            $('#btnSavemhs').attr('disabled',false); //set button enable 
	 
	        }
	    });
	}
</script>
