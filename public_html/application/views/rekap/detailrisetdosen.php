<div class="container-fluid">
	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Rekap Judul Penelitian Dosen</h1>
		
	</div>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Rekap Judul Penelitian Dosen</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered display" id="dataTable" class="display" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th width="5%">No</th>
							<th>Penelitian</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th width="5%">No</th>
							<th>Penelitian</th>
						</tr>
					</tfoot>
					<tbody>
						<?php
							$no = 1;
							$peranku = '';
							if($hitreview>0)
							{
								foreach($review as $p)
								{
									$pisah = explode(',',$p->anggotadosen);
									$dosen = $this->mdosen->dosennya($p->pengusul);
									// $prodi = $this->mdosen->namaprodi($p->prodi);
									$splityear = explode('-',$p->tglmulai);
									$ketua = $this->mdosen->dosennya($p->pengusul);
									$ambil = explode(',',$p->anggotadosen);
									$hit = count($ambil);
									$anggota = '';
									
									if($p->anggotadosen<>'') 
									{
										for($i=0;$i<$hit;$i++)
										{
											$dosen = $this->mdosen->namadosen($ambil[$i]);
											$anggota.=$dosen['namalengkap'];
											if($i<($hit-1))
											$anggota .=', ';
										}
									}
									else
									$anggota = 'Tidak Ada Anggota Dosen';
									echo "<tr>
									<td>".$no."</td>
									<td>".ucwords(strtolower($p->judul))."
									<br><b>Tahun : </b>".$splityear[0]." | <b>Ketua : </b>".$ketua['namalengkap']." | <b>Sumber Dana :</b> 
									".$p->sumberdana."
									<br><b>Anggota : </b>".$anggota."
									<br><b>Mahasiswa : </b>".$p->jumlahmhs."
									<br><b>Skema : ".$p->skema."</b>";
									// if($this->session->userdata('fasenya')=='Laporan')
									// {
									// 	echo "<br><b>File Laporan :</b><a href='".base_url()."assets/uploadbox/".$p->file_laporan."' target='_blank'>".$p->file_laporan."</a>
									// 		<br><b>File Pengesahan :</b><a href='".base_url()."assets/uploadbox/".$p->file_laporan_akhir."' target='_blank'>".$p->file_laporan_akhir."</a></td>
									// 		</tr>";
									// }
									// else
									// {
									// 	if($p->filerevisi=='')
									// 		$getfile = $p->fileusulan;
									// 	else
									// 		$getfile = $p->filerevisi;
									// 	echo "<br><b>File Usulan : </b><a href='".base_url()."assets/uploadbox/".$getfile."' target='_blank'>unduh di sini</a>
									// 		</td>
									// 		</tr>";
									// }
									$no++;
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--</div> -->
	
	<script>
		$(document).ready(function(){
			$("#fakultas").change(function (){
				var url = "<?php echo site_url('rekap/load_prodi');?>/"+$(this).val();
				$('#prodi').load(url);
				return false;
			});	
		});
	</script>
