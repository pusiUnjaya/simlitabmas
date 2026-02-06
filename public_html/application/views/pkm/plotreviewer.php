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
            <h1 class="h3 mb-0 text-gray-800">Plot Reviewer</h1>
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
              <h6 class="m-0 font-weight-bold text-primary">Daftar Usulan PkM</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="33%">Judul PkM</th>
					  <th width="4%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$cek = '';
						foreach($usulan as $p)
						{
							$total = $this->mpengabdian->totalrab($p->id_usulan);
							$fakultas = $this->mdosen->namafakultas($p->fakultas);
							$prodi = $this->mdosen->namaprodi($p->prodi);
							$namadosen = $this->mdosen->dosennya($p->pengusul);
							$cek = $p->cek;
							$sudah = '';
							$dosen = '';
							$warn = '';
							$set = '';
							
							if($p->cek<>'')
							{
								$sudah = "class='table-info'";
								$idosen = explode(',',$p->cek);
								$hid = count($idosen);
								
								for($i=0;$i<$hid;$i++)
								{
									$namanya = $this->mdosen->namadosen($idosen[$i]);
									$dosen .= $namanya['namalengkap'];
										if($i<($hid-1))
											$dosen .= ', ';
								}
								
								$warn = 'Silakan isi Untuk Mengubah Reviewer';
								$set = 'Reviewer Sudah Diplot';
							}
							else
							{
								$warn = 'Silakan Plot Reviewernya';
								$set = 'Belum ada Reviewer';
							}
							
							$ketua = $this->mdosen->dosennya($p->pengusul);
								
								echo "<tr ".$sudah.">
										  <td>".$p->judul." (".date('Y',strtotime($p->tglmulai)).")";
								echo "<br><b>Status : ".$set."</b>
										  <br>Ketua : ".$ketua['namalengkap']." | Prodi : ".$prodi['prodi']." | Skema : ".$p->skema."
										  <br>Anggota : ";
								$pisah = explode(',',$p->anggotadosen);
								$hitpisah = count($pisah);
								if($p->anggotadosen<>'')
								{
									echo '<ol>';
									for($i=0;$i<$hitpisah;$i++)
									{
										$revnya = $this->mdosen->namadosen($pisah[$i]);
										echo '<li>'.$revnya['namalengkap'].'</li>';
									}
									echo '</ol>';
								}
								else
								{
									echo 'Tidak Ada<br>';
								}
								echo "RAB : ";
										  $prodinya = $this->mdosen->dosennya($p->pengusul);
									if($p->sumberdana=='Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0 && $prodinya['prodi']==2)
									{
										echo rupiah($p->totaldana);
									}
									elseif($p->sumberdana=='Mandiri+Internal' && $p->totaldana<>0)
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah($p->totaldana);
									}
									else
									{
										$total = $this->mpengabdian->totalrab($p->id_usulan);
										echo rupiah($total['bahan']+$total['kumpul']+$total['sewa']+$total['analis']+$total['lapor']);
									}
										 
								echo "<br></td>
									  <td><a href='".base_url()."submit/detail/".$p->id_usulan."' class='shadow-sm' title='Plot Reviewer' data-usulan='".$p->id_usulan."' data-dosen='".$dosen."' data-warn='".$warn."' data-toggle='modal' data-target='#plot-modal'><i class='fas fa-user-plus fa-sm'></i></a>
									  </td>
									</tr>";
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
        <form method="post" action="<?php echo base_url().'pengabdian/plotdosen/'.$this->uri->segment(3); ?>">
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