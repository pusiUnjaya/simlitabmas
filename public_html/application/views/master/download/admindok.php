<?php
	if($this->session->userdata('sesi_status')<>1)
	header('location:'.base_url());
?>

<style>

.treeview-animated {

  font-size: 16px;
  font-weight: 400;

  background: rgba(222, 229, 227, 0.1);
}

.treeview-animated hr {
  border-color: #6372f7;
}

.treeview-animated.w-20 {
  width: 20rem;
}

.treeview-animated h6 {
  font-size: 1.4em;
  font-weight: 500;
  color: blue;
}

.treeview-animated ul {
  position: relative;
  list-style: none;
  padding-left: 0;
}

.treeview-animated-list ul {
  padding-left: 1em;
  margin-top: 0.1em;
  background: rgba(222, 229, 227, 0.1);
}

.treeview-animated-element {
  padding: 0.2em 0.2em 0.2em 1em;
  cursor: pointer;
  transition: all .1s linear;
  border: 2px solid transparent;
  border-right: 0px solid transparent;
}

.treeview-animated-element:hover {
  background-color: #b1e3f2;
}

.treeview-animated-element.opened {
  color: #6372f7;
  border: 2px solid #6372f7;
  border-right: 0px solid transparent;
  background-color: #b1e3f2;
}

.treeview-animated-element.opened:hover {
  color: #6372f7;
  background-color: #b1e3f2;
}

.treeview-animated-items-header {
  display: block;
  padding: 0.4em;
  margin-right: 0;
  border-bottom: 2px solid transparent;
}


.treeview-animated-items-header:hover {
  background-color: #b1e3f2
}

.treeview-animated-items-header.open {
  transition: all .1s linear;
  background-color: #b1e3f2;

  border-bottom: 2px solid #6372f7;
}

.treeview-animated-items-header.open span {
  color: #6372f7;
}

.treeview-animated-items-header.open:hover {

  color: #6372f7;
  background-color: #b1e3f2;
}

.treeview-animated-items-header.open div:hover {
  background-color: #b1e3f2;
}

.treeview-animated-items-header .fa-angle-right {
  transition: all .1s linear;
  font-size: .8rem;
}

.treeview-animated-items-header .fas {
  position: relative;
  transition: all .2s linear;
  transform: rotate(90deg);

  color: #6372f7;
}

.treeview-animated-items-header .fa-minus-circle {
  position: relative;
  color: #6372f7;
  transform: rotate(180deg);
}
</style>
<div class="container-fluid">
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Upload Dokumen</h1>
		<a href="#" data-toggle="modal" data-target="#upload-modal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file fa-sm text-white-50"></i> Tambah Dokumen</a>
	</div>
	<?php
		if($this->session->flashdata('result')<>'')
		{
			echo '<div class="alert alert-success" role="alert">'.
			$this->session->flashdata('result').'
			</div>';
		}
	?>
	
	<!-- Content Row -->
	
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Daftar Dokumen</h6>
		</div>
		<div class="card-body">
			<div class="row">
            	<div class="col-md-4">
            		<div class="treeview-animated w-12 border border-secondary mx-4 my-4">
					    <h6 class="pt-3 pl-3">Folders</h6>
					    <hr>
					    <ul class="treeview-animated-list mb-3">
					      <li class="treeview-animated-items">
					        <a class="treeview-animated-items-header">
					          <i class="fas fa-plus-circle"></i>
					          <span><i class="far fa-folder-open ic-w mx-1"></i>Penelitian</span>
					        </a>
					        <ul class="nested">
					          <li>
					            <div class="treeview-animated-element" id="risetugas"><i class="far fa-folder-open ic-w mr-1"></i>Surat Tugas
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="risetkontrak"><i class="far fa-folder-open ic-w mr-1"></i>Surat Kontrak
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="risetserti"><i class="far fa-folder-open ic-w mr-1"></i>Sertifikat
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="risetijin"><i class="far fa-folder-open ic-w mr-1"></i>Surat Ijin Penelitian
					          </li>
					          <li class="treeview-animated-items">
					            <a class="treeview-animated-items-header">
					              <i class="fas fa-plus-circle"></i>
					              <span><i class="far fa-folder-open ic-w mx-1"></i>Template</span></a>
					            <ul class="nested">
					              <li>
					                <div class="treeview-animated-element" id="risetusulan"><i class="far fa-folder-open ic-w mr-1" id="risetusulan"></i>Usulan
					              </li>
					              <li>
					                <div class="treeview-animated-element" id="risetkemajuan"><i class="far fa-folder-open ic-w mr-1"></i>Laporan Kemajuan
					              </li>
					              <li>
					                <div class="treeview-animated-element" id="risetakhir"><i class="far fa-folder-open ic-w mr-1"></i>Laporan Akhir
					              </li>
					            </ul>
					          </li>
					        </ul>
					      </li>
					      <li class="treeview-animated-items">
					        <a class="treeview-animated-items-header">
					          <i class="fas fa-plus-circle"></i>
					          <span><i class="far fa-folder-open ic-w mx-1"></i>Pengabdian</span>
					        </a>
					        <ul class="nested">
					          <li>
					            <div class="treeview-animated-element" id="pkmtugas"><i class="far fa-folder-open ic-w mr-1"></i>Surat Tugas
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="pkmkontrak"><i class="far fa-folder-open ic-w mr-1"></i>Surat Kontrak
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="pkmserti"><i class="far fa-folder-open ic-w mr-1"></i>Sertifikat
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="pkmijin"><i class="far fa-folder-open ic-w mr-1"></i>Surat Ijin Pengabdian
					          </li>
					          <li class="treeview-animated-items">
					            <a class="treeview-animated-items-header">
					              <i class="fas fa-plus-circle"></i>
					              <span><i class="far fa-folder-open ic-w mx-1"></i>Template</span></a>
					            <ul class="nested">
					              <li>
					                <div class="treeview-animated-element" id="pkmusulan"><i class="far fa-folder-open ic-w mr-1"></i>Usulan
					              </li>
					              <li>
					                <div class="treeview-animated-element" id="pkmkemajuan"><i class="far fa-folder-open ic-w mr-1"></i>Laporan Kemajuan
					              </li>
					              <li>
					                <div class="treeview-animated-element" id="pkmakhir"><i class="far fa-folder-open ic-w mr-1"></i>Laporan Akhir
					              </li>
					            </ul>
					          </li>
					        </ul>
					      </li>
					      <li class="treeview-animated-items">
					        <a class="treeview-animated-items-header">
					          <i class="fas fa-plus-circle"></i>
					          <span><i class="far fa-folder-open mx-1"></i>Dokumen LPPM</span>
					        </a>
					        <ul class="nested">
					          <li>
					            <div class="treeview-animated-element" id="pedoman"><i class="far fa-folder-open ic-w mr-1"></i>Pedoman
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="sop"><i class="far fa-folder-open ic-w mr-1"></i>SOP
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="kebijakan"><i class="far fa-folder-open ic-w mr-1"></i>Kebijakan
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="sentrahki"><i class="far fa-folder-open ic-w mr-1"></i>Sentra HKI
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="unjayapress"><i class="far fa-folder-open ic-w mr-1"></i>Unjaya Press
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="etik"><i class="far fa-folder-open ic-w mr-1"></i>Etik Penelitian
					          </li>
					          <li>
					            <div class="treeview-animated-element" id="lain"><i class="far fa-folder-open ic-w mr-1"></i>Lain - Lain
					          </li>
					        </ul>
					      </li>
					    </ul>
					  </div>
            	</div>
            	<div class="col-md-8">
            		<div class="table-responsive" id="dokumen"> 
            				<h6 class="pt-1" style="color: blue;">Surat Tugas Penelitian</h6>
		                <table class="table table-bordered dataTable" width="100%" cellspacing="0">
											<thead>
												<tr>
													<th width="85%">Judul</th>
													<th>File Dokumen</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php
													foreach($download as $p)
													{
														echo "<tr>
														<td style='color:green'>".$p->judul."
														<br><span style='color:gray'>Update Terakhir ".tgl_indo($p->modified,1)."
														</span></td>
														<td><a target='_blank' href='".base_url().'assets/uploadbox/'.$p->file."'>Download</a></td>
														<td width='10%'>
														<a href='#' data-toggle='modal' data-target='#edit-modal' data-dok='".$p->id_file.",".$p->judul.",".$p->keterangan.",".$p->file.",".$p->jenisdok.",".$p->katedok."' class='shadow-sm' title='Edit File'><i class='fas fa-edit fa-sm'></i></a>&nbsp;&nbsp;
														<a href='#' data-id='".$p->id_file."' rel='tooltip' data-placement='top' title='Hapus Pengguna' class='shadow-sm hapus'><i class='fas fa-trash fa-sm'></i></a>
														</td>
														</tr>";
													}
												?>	
											</tbody>
										</table>
								</div>
            	</div>
            </div>
		</div>
	</div>
</div>

<!-- modal tambah dokumen -->
<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Upload Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'dokumen/simpan'; ?>" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Judul</label>
						<div class="col-sm-10">
							<textarea name="judul" cols="10" class="form-control" placeholder="Judul File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis Dokumen</label>
						<div class="col-sm-10">
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio1" value="Penelitian" onClick="toggleKate();" />
							  <label class="form-check-label" for="inlineRadio1">Penelitian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio2" value="Pengabdian" onClick="toggleKate();" />
							  <label class="form-check-label" for="inlineRadio2">Pengabdian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="inlineRadio3" value="Dokumen LPPM" onClick="toggleLppm();" />
							  <label class="form-check-label" for="inlineRadio3">Dokumen LPPM</label>
							</div>
						</div>
					</div>
					<div class="form-group row" id="katedok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="katedok" cols="10" class="form-control">
								<option value="Surat Tugas">Surat Tugas</option>
								<option value="Surat Kontrak">Surat Kontrak</option>
								<option value="Sertifikat">Sertifikat</option>
								<option value="Ijin Penelitian">Ijin Penelitian</option>
								<option value="Template - Usulan">Template - Usulan</option>
								<option value="Template - Kemajuan">Template - Laporan Kemajuan</option>
								<option value="Template - Akhir">Template - Laporan Akhir</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="lppmdok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="lppmdok" cols="10" class="form-control">
								<option value="Pedoman">Pedoman</option>
								<option value="SOP">SOP</option>
								<option value="Kebijakan">Kebijakan</option>
								<option value="Sentra HKI">Sentra HKI</option>
								<option value="Unjaya Press">Unjaya Press</option>
								<option value="Etik Penelitian">Etik Penelitian</option>
								<option value="Lain - Lain">Lain - Lain</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<textarea name="keterangan" cols="10" class="form-control" placeholder="Keterangan File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">File</label>
						<div class="col-sm-10">
						<input type="file" name="dokumen" class="form-control" placeholder="Upload Dokumen"></textarea>
					</div>
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

<!-- modal edit dokumen -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo base_url().'dokumen/update'; ?>" enctype="multipart/form-data">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Judul</label>
						<div class="col-sm-10">
							<input type="hidden" name="id" id="id_file">
							<textarea name="judul" id="judul" cols="10" class="form-control" placeholder="Judul File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Jenis Dokumen</label>
						<div class="col-sm-10">
							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="pilriset" value="Penelitian" onClick="toggleKate();" />
							  <label class="form-check-label" for="inlineRadio4">Penelitian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="pilpkm" value="Pengabdian" onClick="etoggleKate();" />
							  <label class="form-check-label" for="inlineRadio5">Pengabdian</label>
							</div>

							<div class="form-check form-check-inline">
							  <input class="form-check-input" type="radio" name="jenisdok" id="pildok" value="Dokumen LPPM" onClick="etoggleLppm();" />
							  <label class="form-check-label" for="inlineRadio6">Dokumen LPPM</label>
							</div>
						</div>
					</div>
					<div class="form-group row" id="ekatedok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="katedok" cols="10" class="form-control getkate">
								<option value="Surat Tugas">Surat Tugas</option>
								<option value="Surat Kontrak">Surat Kontrak</option>
								<option value="Ijin Penelitian">Ijin Penelitian/PkM</option>
								<option value="Sertifikat">Sertifikat</option>
								<option value="Template - Usulan">Template - Usulan</option>
								<option value="Template - Kemajuan">Template - Laporan Kemajuan</option>
								<option value="Template - Akhir">Template - Laporan Akhir</option>
							</select>
						</div>
					</div>
					<div class="form-group row" id="elppmdok" style="display:none;">
						<label class="col-sm-2 col-form-label">Kategori Dokumen</label>
						<div class="col-sm-10">
							<select name="lppmdok" cols="10" class="form-control getkate">
								<option value="Pedoman">Pedoman</option>
								<option value="SOP">SOP</option>
								<option value="Kebijakan">Kebijakan</option>
								<option value="Sentra HKI">Sentra HKI</option>
								<option value="Unjaya Press">Unjaya Press</option>
								<option value="Etik Penelitian">Etik Penelitian</option>
								<option value="Lain - Lain">Lain - Lain</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Keterangan</label>
						<div class="col-sm-10">
							<textarea name="keterangan" id="keterangan" cols="10" class="form-control" placeholder="Keterangan File"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">File</label>
						<div class="col-sm-10">
						<input type="file" name="dokumen" class="form-control" placeholder="Upload Dokumen"></textarea>
						<br><p id="filenya"></p>
					</div>
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

<script type="text/javascript">
	
    (function ($) {

      let $allPanels = $('.nested').hide();
      let $elements = $('.treeview-animated-element');

      $('.treeview-animated-items-header').click(function () {
        $this = $(this);
        $target = $this.siblings('.nested');
        $pointerPlus = $this.children('.fa-plus-circle');
        $pointerMinus = $this.children('.fa-minus-circle');

        $pointerPlus.removeClass('fa-plus-circle');
        $pointerPlus.addClass('fa-minus-circle');
        $pointerMinus.removeClass('fa-minus-circle');
        $pointerMinus.addClass('fa-plus-circle');
        $this.toggleClass('open')
        if (!$target.hasClass('active')) {
          $target.addClass('active').slideDown();
        } else {
          $target.removeClass('active').slideUp();
        }

        return false;
      });
      $elements.click(function () {
        $this = $(this);

        if ($this.hasClass('opened')) {

          $elements.removeClass('opened');
        } else {

          $elements.removeClass('opened');
          $this.addClass('opened');
        }
      })
    })(jQuery);

</script>

<script>
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
				window.location = "<?php echo base_url();?>dokumen/hapus/" + id ;
			}
		})
	});

	$(document).ready(function () {
		$('.dataTable').DataTable({
			"ordering": false // false to disable sorting (or any other option)
		});
		$('.dataTables_length').addClass('bs-select');


		$(document).on('click','.hapus',function(){
			alert('tes hapus');
		});
	});

	$(document).ready(function(){
		$("#risetugas").click(function (){
			var url = "<?php echo site_url('dokumen/risetugas');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#risetkontrak").click(function (){
			var url = "<?php echo site_url('dokumen/risetkontrak');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#risetserti").click(function (){
			var url = "<?php echo site_url('dokumen/risetserti');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#risetijin").click(function (){
			var url = "<?php echo site_url('dokumen/risetijin');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#risetusulan").click(function (){
			var url = "<?php echo site_url('dokumen/risetusulan');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#risetkemajuan").click(function (){
			var url = "<?php echo site_url('dokumen/risetkemajuan');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#risetakhir").click(function (){
			var url = "<?php echo site_url('dokumen/risetakhir');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmtugas").click(function (){
			var url = "<?php echo site_url('dokumen/pkmtugas');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmkontrak").click(function (){
			var url = "<?php echo site_url('dokumen/pkmkontrak');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmserti").click(function (){
			var url = "<?php echo site_url('dokumen/pkmserti');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmijin").click(function (){
			var url = "<?php echo site_url('dokumen/pkmijin');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmusulan").click(function (){
			var url = "<?php echo site_url('dokumen/pkmusulan');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmkemajuan").click(function (){
			var url = "<?php echo site_url('dokumen/pkmkemajuan');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pkmakhir").click(function (){
			var url = "<?php echo site_url('dokumen/pkmakhir');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#pedoman").click(function (){
			var url = "<?php echo site_url('dokumen/pedoman');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#sop").click(function (){
			var url = "<?php echo site_url('dokumen/sop');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#kebijakan").click(function (){
			var url = "<?php echo site_url('dokumen/kebijakan');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#sentrahki").click(function (){
			var url = "<?php echo site_url('dokumen/sentrahki');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#unjayapress").click(function (){
			var url = "<?php echo site_url('dokumen/unjayapress');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#etik").click(function (){
			var url = "<?php echo site_url('dokumen/etik');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(document).ready(function(){
		$("#lain").click(function (){
			var url = "<?php echo site_url('dokumen/lain');?>";
			$('#dokumen').load(url);
			return false;
		});
	});

	$(function () {
		$('#edit-modal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal
			var company = button.data('dok'); // Extract info from data-* attributes
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			var modal = $(this);
			var pisah = company.split(',');
			if(pisah[4]=='Penelitian')
			{
					modal.find('#pilriset').prop("checked", true);
					etoggleKate();
			}
			else if(pisah[4]=='Pengabdian')
			{
					modal.find('#pilpkm').prop("checked", true);
					etoggleKate();
			}
			else
			{
					modal.find('#pildok').prop("checked", true);
					etoggleLppm();
			}

			document.getElementById("id_file").value = pisah[0];
			modal.find('#judul').text(pisah[1]);
			modal.find('#keterangan').text(pisah[2]);
			modal.find('#filenya').text(pisah[3]);
			modal.find('.getkate').val(pisah[5]);
		});
	});

	var s = document.getElementById("katedok");               // Show katedok
	var h = document.getElementById("lppmdok");               // Hide lppmdok

	function toggleKate() {
	    h.style.display = 'none';
	    s.style.display = '';
	}

	function toggleLppm() {
	    s.style.display = 'none';
	    h.style.display = '';
	}

	var es = document.getElementById("ekatedok");               // Show katedok
	var eh = document.getElementById("elppmdok");               // Hide lppmdok

	function etoggleKate() {
	    eh.style.display = 'none';
	    es.style.display = '';
	}

	function etoggleLppm() {
	    es.style.display = 'none';
	    eh.style.display = '';
	}

</script>
