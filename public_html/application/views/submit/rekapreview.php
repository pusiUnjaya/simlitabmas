<?php
	if($this->session->userdata('sesi_status')<>1)
		header('location:'.base_url());
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

<style>
	.ui-autocomplete {
		position: absolute;
		z-index: 2150000000 !important;
		cursor: default;
		border: 2px solid #ccc;
		padding: 5px 0;
		border-radius: 2px;
	}
</style>
<div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekap Hasil Review</h1>
          </div>
		  <?php
				if($this->session->flashdata('result')<>'')
				{
					echo '<div class="alert alert-success" role="alert">'.
						$this->session->flashdata('result').'
						</div>';
				}
				$tahun = 2018;
				$aktif = date('Y');

			?>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="row">
						<div class="col-md-9">
						  <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan Penelitian</h6>
						</div>
						<div class="col-md-3 float-right">
						<?php if($this->session->userdata('sesi_status')==1) { ?>
						  <a href="<?php echo base_url().'submit/eksporhasilreview'; ?>" class="btn btn-sm btn-success shadow-sm" title="Ekspor Rekap" style="margin-left: 1em;color:white"><i class="fas fa-file-excel fa-sm text-white-50"></i> Ekspor Rekap</a>
						<?php } ?>
						<!--	<form class="user col-md-5 float-right" action="<?php echo base_url(); ?>submit" method="post">
								<select name="periode" class="form-control" onchange="this.form.submit()">
						-->			<?php
									$tahun = 2018;
									$aktif = date('Y');
									$selisih = $aktif - $tahun;

									if ($this->input->post('periode') == '')
										$pilih = date('Y');
									else
										$pilih = $this->input->post('periode');
								/*	for ($i = 0; $i <= $selisih; $i++) {
										if ($pilih == ($aktif - $i))
											echo '<option value="' . ($aktif - $i) . '" selected>' . ($aktif - $i) . '</option>';
										else
											echo '<option value="' . ($aktif - $i) . '">' . ($aktif - $i) . '</option>';
									} */
									?>
						<!--		</select>
							</form> 
					--></div>
				</div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="30%">Judul Penelitian</th>
                      <th width="10%">Tim Peneliti</th>
                      <th width="30%">Hasil Review</th>
                      <th width="15%">Rekomendasi</th>
					  <th width="15%">Nilai</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th width="30%">Judul Penelitian</th>
                      <th width="10%">Tim Peneliti</th>
                      <th width="30%">Hasil Review</th>
                      <th width="15%">Rekomendasi</th>
					  <th width="15%">Nilai</th>
                     </tr>
                  </tfoot>
                  <tbody>
                    <?php
						foreach($usulan as $p)
						{
							echo "<tr><td>$p->judul</td><td>Ketua :".$p->namapengusul."
									<br>Anggota :<br>";
									$anggotadosen = $this->msubmit->perananggota($p->id_usulan,'Penelitian');
									$hitangg = count($anggotadosen);
									if($hitangg>0)
									{
										echo '<ol>';
										for($i=0;$i<$hitangg;$i++)
										{
											$revnya = $anggotadosen[$i]->namalengkap;
											echo '<li>'.$revnya.'</li>';
										}
										echo '</ol>';			
									}
							$dosenluar = $this->msubmit->perananggotadosenluar($p->id_usulan,'Penelitian');
							$hitangg = count($dosenluar);
							if($hitangg>0)
							{
								echo '<ol>';
								for($i=0;$i<$hitangg;$i++)
								{
									$revnya = $dosenluar[$i]->namalengkap;
									echo '<li>'.$revnya.'</li>';
								}
								echo '</ol>';			
							}
							else {
								echo '-';
							}

							echo "</td><td>";
							$hasilreview = $this->msubmit->rekaphasilreview($p->id_usulan);
							$hitangg = count($hasilreview);
							echo '<ol>';
							for($i=0;$i<$hitangg;$i++)
							{
								$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
								echo '<li>'.$revnya.'<br>'.$hasilreview[$i]->hasilreview.'</li>';
							}
							echo '</ol></td><td><ol>';			

							for($i=0;$i<$hitangg;$i++)
							{
								$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
								echo '<li>'.$revnya.'<br>'.$hasilreview[$i]->rekomendasi.'</li>';
							}
							echo '</ol></td><td><ol>';			

							for($i=0;$i<$hitangg;$i++)
							{
								$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
								if ($hasilreview[$i]->skor<>''){

									$skor = explode(',',$hasilreview[$i]->skor);
									echo '<li>'.$revnya.'<br>';

									$poin1 = (float) $skor[0];
									$poin2 = (float) $skor[1];
									$poin3 = (float) $skor[2];
									$poin4 = (float) $skor[3];
									$poin5 = (float) $skor[4];
									$poin6 = (float) $skor[5];
									$poin7 = (float) $skor[6];
									$poin8 = (float) $skor[7];
									$poin9 = (float) $skor[8];
									$poin10 = (float) $skor[9];
									$tahun = date('Y',strtotime($hasilreview[$i]->modified));
									$bulan = date('m',strtotime($hasilreview[$i]->modified));
									if ($tahun>=2023 && ($tahun<=2024 && $bulan<5)){
										$final = (($poin1*20)+($poin2*15)+($poin3*20)+($poin4*15)+($poin5*10)+($poin6*20))/4;
										$poin1 = 20*(float) $skor[0];
										$poin2 = 15*(float) $skor[1];
										$poin3 = 20*(float) $skor[2];
										$poin4 = 15*(float) $skor[3];
										$poin5 = 10*(float) $skor[4];
										$poin6 = 20*(float) $skor[5];
										
									    echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6;
									}else if($tahun>=2024 && $bulan>=5){
										$final = (($poin1*10)+($poin2*10)+($poin3*10)+($poin4*10)+($poin5*10)+($poin6*10)+($poin7*10)+($poin8*10)+($poin9*10)+($poin10*10))/4;
										$poin1 = 10*(float) $skor[0];
										$poin2 = 10*(float) $skor[1];
										$poin3 = 10*(float) $skor[2];
										$poin4 = 10*(float) $skor[3];
										$poin5 = 10*(float) $skor[4];
										$poin6 = 10*(float) $skor[5];
										$poin7 = 10*(float) $skor[6];
										$poin8 = 10*(float) $skor[7];
										$poin9 = 10*(float) $skor[8];
										$poin10 = 10*(float) $skor[9];
									    echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6.','.$poin7.','.$poin8.','.$poin9.','.$poin10;
									}else if ($tahun==2025){
										$final = (($poin1*20)+($poin2*15)+($poin3*20)+($poin4*15)+($spoin5*10)+($poin6*20))/7;
										$poin1 = 20*(float) $skor[0];
										$poin2 = 15*(float) $skor[1];
										$poin3 = 20*(float) $skor[2];
										$poin4 = 15*(float) $skor[3];
										$poin5 = 10*(float) $skor[4];
										$poin6 = 20*(float) $skor[5];
									    echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6;
									}else {
										$final = (($poin1*10)+($poin2*10)+($poin3*10)+($poin4*10)+($poin5*10)+($poin6*10)+($poin7*10)+($poin8*10)+($poin9*10)+($poin10*10))/4;
										$poin1 = 10*(float) $skor[0];
										$poin2 = 10*(float) $skor[1];
										$poin3 = 10*(float) $skor[2];
										$poin4 = 10*(float) $skor[3];
										$poin5 = 10*(float) $skor[4];
										$poin6 = 10*(float) $skor[5];
										$poin7 = 10*(float) $skor[6];
										$poin8 = 10*(float) $skor[7];
										$poin9 = 10*(float) $skor[8];
										$poin10 = 10*(float) $skor[9];
										echo 'Poin item : '.$poin1.','.$poin2.','.$poin3.','.$poin4.','.$poin5.','.$poin6.','.$poin7.','.$poin8.','.$poin9.','.$poin10;
									}
									
									echo '<br>Skor : '.$final.'</li>';
								}else{
									$revnya = 'Reviewer :'.$hasilreview[$i]->namareviewer;
									echo '<li>'.$revnya.'<br>-</li>';
								}
							}
							echo '</ol></td>';			

							echo "</tr>";
						}
					?>	
                  </tbody>
                </table>
				
				<?php 
				  
				// Store the file name into variable 
				// $file = base_url().'assets/uploadbox/inii.doc'; 
				// $filename = 'iniitu.doc'; 
				  
				// // Header content type 
				// header('Content-type: application/pdf'); 
				  
				// header('Content-Disposition: inline; filename="' . $filename . '"'); 
				  
				// header('Content-Transfer-Encoding: binary'); 
				  
				// header('Accept-Ranges: bytes'); 
				  
				// // Read the file 
				// @readfile($file); 
				  
				?> 

              </div>
            </div>
          </div>
        </div>

<!-- modal -->
<div class="modal fade" id="plot-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Plot Reviewer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo base_url().'submit/plotdosen/'.$this->uri->segment(3); ?>">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Dosen Reviewer:</label>
			<?php	
					// $idosen = explode(',',$cek);
					// $hid = count($idosen);
					// $dosen = '';
					// for($i=0;$i<$hid;$i++)
					// {
						// $namanya = $this->mdosen->namadosen($idosen[$i]);
						// $dosen .= $namanya['namalengkap'];
							// if($i<($hid-1))
								// $dosen .= ', ';
					// }
					// if($dosen<>'')
						// $warn = 'Silakan isi Untuk Mengubah Reviewer';
					// else
						// $warn = 'Silakan Plot Reviewernya';
			?>	
			<input type="hidden" name="id" class="form-control" id="idusulanya">
            <input type="text" name="dosen" class="form-control" id="plotreviewer" placeholder="" required><br>
			<p id="revnya"></p>
			<input type="hidden" id="labels">
			<input type="hidden" name="iddosen" id="values">
          </div>
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
		<button type="submit" class="btn btn-success">Simpan</button>
	  </div>
	  </form>
    </div>
  </div>
</div>

	<?php
		$dosen = $this->mdosen->pilihanreviewer();
		$datanama = array();
		foreach($dosen as $d)
		{
			$datanama[] = array(
			  'value' => $d->id_dosen,
			  'label' => $d->namalengkap); 
		}
		$reviewer = json_encode($datanama);
	?>


<script>

	$(document).ready(function() {
        $('#plot-modal').on('show.bs.modal', function (event) {
            var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
            var modal = $(this)
 
            // Isi nilai pada field
            modal.find('#idusulanya').attr("value",div.data('usulan'));
            modal.find('#plotreviewer').attr("placeholder",div.data('warn'));
            modal.find('#revnya').html(div.data('dosen'));
        });

    });
	
	$(".hapus").click(function(){
    var id = $(this).data('id');
    bootbox.confirm({
	    title: "Hapus Data?",
		message: "Anda Yakin Ingin Menghapus Data Sekarang? Setelah Hapus, Data Tidak Dapat Diperbaiki.",
		closeButton: false,
		buttons: {
			cancel: {
				label: '<i class="fa fa-times"></i> Batal'
			},
			confirm: {
				label: '<i class="fa fa-check"></i> Hapus'
			}
		},
		callback: function (result)
		{
			if(result)
			window.location = "<?php echo base_url();?>submit/hapus/" + id ;
		}
	})
	});
	
	//autocomplete dosen
	$(function() {
		function split( val ) {
		return val.split( /,\s*/ );
		}
		function extractLast( term ) {
		return split( term ).pop();
		}
		
		var projects = <?php echo $reviewer; ?>;
			 
		$( "#plotreviewer" )
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
</script>