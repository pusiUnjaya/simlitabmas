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
		<h1 class="h3 mb-0 text-gray-800">Dokumen</h1>
	</div>
	
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
												<th>Unduh</th>
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
													<td><a href='".base_url().'assets/uploadbox/'.$p->file."' target='_blank'>Unduh</a></td>
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
	$(document).ready(function () {
		$('.dataTable').DataTable({
			"ordering": false // false to disable sorting (or any other option)
		});
		$('.dataTables_length').addClass('bs-select');
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

</script>