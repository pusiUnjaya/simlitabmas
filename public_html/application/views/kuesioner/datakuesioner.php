<?php
	if($this->session->userdata('sesi_user')==false)
	{
		header('location:'.base_url().'login');
	}
?>
<div class="container-fluid">

          <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Data Kuesioner</h1>
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
  <ul class="nav nav-tabs" id="myTab" role="tablist">
	  <li class="nav-item">
		<a class="nav-link active" id="lppm-tab" data-toggle="tab" href="#lppm" role="tab" aria-controls="lppm" aria-selected="true">LPPM - Lembaga Penelitian dan Pengabdian kepada Masyarakat</a>
	  </li>
	  <li class="nav-item">
		<a class="nav-link" id="pppm-tab" data-toggle="tab" href="#pppm" role="tab" aria-controls="pppm" aria-selected="false">PPPM - Pusat Penelitian dan Pengabdian kepada Masyarakat</a>
	  </li>
	</ul>
	<div class="tab-content" id="myTabContent">
	  <div class="tab-pane fade show active" id="lppm" role="tabpanel" aria-labelledby="lppm-tab">
	  <div class="card shadow mb-4">
		<div class="card-header py-3">
		  <h6 class="m-0 font-weight-bold text-primary">Daftar Kuesioner LPPM</h6>
		  <div class="col-sm-12 col-md-2 float-right" style="margin-top:-25px">
			  <a href="<?php echo base_url(); ?>kuesioner/ekspor/lppm" type="button" class="btn btn-primary"><i class="fas fa-file-excel fa-sm text-white-50"></i>
 Ekspor Excel</a>
		 </div>
		</div>
		<div class="card-body">
			<div class="row">
			  <div class="col-sm-12">
				<div id="container">
					<p align="left">Tahun <?php echo date('Y');?> : Jumlah Dosen (D) : <?php echo $dosen; ?>, Sudah Isi (S) : <?php echo $sudahlppm; ?>, Belum Isi (B) : <?php echo $belum=$dosen-$sudahlppm; ?></p>
					<div class="row">
					<?php
						foreach($tahun as $t) {
							$lppmpertahun = $this->mkuesioner->sudahlppmpertahun($t->tahun);
					?>
						<div class="col-xl-3 col-md-6 mb-3">
						  <div class="card border-left-primary shadow h-100 py-2">
							<div class="card-body">
							  <div class="row no-gutters align-items-center">
								<div class="col mr-2">
								  <div class="text-xs font-weight-bold text-primary mb-1">D : <?php echo $dosen; ?>, S : <?php echo $lppmpertahun; ?>, B : <?php echo $belum=$dosen-$lppmpertahun; ?></div>
								  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $t->tahun; ?></div>
								</div>
								<div class="col-auto">
								  <a title='Ekspor Kuesioner' href="<?php echo base_url(); ?>kuesioner/ekspor/lppm/<?php echo $t->tahun; ?>"><i class="fas fa-calendar fa-2x"></i></a>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					<?php 
						}
					?>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	  </div>
	  <div class="tab-pane fade" id="pppm" role="tabpanel" aria-labelledby="pppm-tab">
	  <div class="card shadow mb-3">
		<div class="card-header py-3">
		  <h6 class="m-0 font-weight-bold text-primary">Data Kuesioner PPPM</h6>
		  <div class="col-md-2 float-right" style="margin-top:-25px">
			  <a href="<?php echo base_url(); ?>kuesioner/ekspor/pppm" type="button" class="btn btn-primary"><i class="fas fa-file-excel fa-sm text-white-50"></i>
 Ekspor Excel</a>
		 </div>
		</div>
		<div class="card-body">
			<div class="row">
			  <div class="col-sm-12">
				<div id="container">
					<p align="left">Tahun <?php echo date('Y');?> : Jumlah Dosen (D) : <?php echo $dosen; ?>, Sudah Isi (S) : <?php echo $sudahpppm; ?>, Belum Isi (B) : <?php echo $belum=$dosen-$sudahpppm; ?></p>
					<div class="row">
					<?php
						foreach($tahun as $t) {
							$pppmpertahun = $this->mkuesioner->sudahpppmpertahun($t->tahun);
					?>
						<div class="col-xl-3 col-md-6 mb-3">
						  <div class="card border-left-primary shadow h-100 py-2">
							<div class="card-body">
							  <div class="row no-gutters align-items-center">
								<div class="col mr-2">
								  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">D : <?php echo $dosen; ?>, S : <?php echo $pppmpertahun; ?>, B : <?php echo $belum=$dosen-$pppmpertahun; ?></div>
								  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $t->tahun; ?></div>
								</div>
								<div class="col-auto">
								  <a title='Ekspor Kuesioner' href="<?php echo base_url(); ?>kuesioner/ekspor/pppm/<?php echo $t->tahun; ?>"><i class="fas fa-calendar fa-2x"></i></a>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					<?php 
						}
					?>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	  </div>
	</div>
</div>

<script>
		//bar lppm
		var MONTHS = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'],
			datasets: [{
				label: 'LPPM',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
				<?php
					$nomor1 = 0;
					$nomor2 = 0;
					$nomor3 = 0;
					$nomor4 = 0;
					$nomor5 = 0;
					$nomor6 = 0;
					$nomor7 = 0;
					$nomor8 = 0;
					$nomor9 = 0;
					$nomor10 = 0;
					$nomor11 = 0;
					$no = 1;
					foreach($lppm as $l)
					{
						$nomor1 += $l->ans1;
						$nomor2 += $l->ans2;
						$nomor3 += $l->ans3;
						$nomor4 += $l->ans4;
						$nomor5 += $l->ans5;
						$nomor6 += $l->ans6;
						$nomor7 += $l->ans7;
						$nomor8 += $l->ans8;
						$nomor9 += $l->ans9;
						$nomor10 += $l->ans10;
						$nomor11 += $l->ans11;
						$no++;
					}
					$rerata1 = $nomor1/$no;
					$hasilnya1 = $rerata1 * 25;
					$rerata2 = $nomor2/$no;
					$hasilnya2 = $rerata2 * 25;
					$rerata3 = $nomor3/$no;
					$hasilnya3 = $rerata3 * 25;
					$rerata4 = $nomor4/$no;
					$hasilnya4 = $rerata4 * 25;
					$rerata5 = $nomor5/$no;
					$hasilnya5 = $rerata5 * 25;
					$rerata6 = $nomor6/$no;
					$hasilnya6 = $rerata6 * 25;
					$rerata7 = $nomor7/$no;
					$hasilnya7 = $rerata7 * 25;
					$rerata8 = $nomor8/$no;
					$hasilnya8 = $rerata8 * 25;
					$rerata9 = $nomor9/$no;
					$hasilnya9 = $rerata9 * 25;
					$rerata10 = $nomor10/$no;
					$hasilnya10 = $rerata10 * 25;
					$rerata11 = $nomor11/$no;
					$hasilnya11 = $rerata11 * 25;
					
					echo number_format($hasilnya1, 2, '.', '').','.number_format($hasilnya2, 2, '.', '').','.number_format($hasilnya3, 2, '.', '').','.number_format($hasilnya4, 2, '.', '').','.number_format($hasilnya5, 2, '.', '').','.number_format($hasilnya6, 2, '.', '').','.number_format($hasilnya7, 2, '.', '').','.number_format($hasilnya8, 2, '.', '').','.number_format($hasilnya9, 2, '.', '').','.number_format($hasilnya10, 2, '.', '').','.number_format($hasilnya11, 2, '.', '');
				?>
				]
			},]

		};

		
	//pie lppm
	var config = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
					<?php 
						echo $belum.','.$sudahlppm;
					?>
				],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.green
				],
				label: 'LPPM'
			}],
			labels: [
				'Belum Isi Kuesioner',
				'Sudah Isi Kuesioner'
			]
		},
		options: {
			responsive: true
		}
	};
	
	//bar pppm
		var MONTHS = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'];
		var color = Chart.helpers.color;
		var barChartData2 = {
			labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11'],
			datasets: [{
				label: 'PPPM',
				backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
				borderColor: window.chartColors.blue,
				borderWidth: 1,
				data: [
				<?php
					$nomor1 = 0;
					$nomor2 = 0;
					$nomor3 = 0;
					$nomor4 = 0;
					$nomor5 = 0;
					$nomor6 = 0;
					$nomor7 = 0;
					$nomor8 = 0;
					$nomor9 = 0;
					$nomor10 = 0;
					$nomor11 = 0;
					$no = 1;
					foreach($pppm as $l)
					{
						$nomor1 += $l->ans1;
						$nomor2 += $l->ans2;
						$nomor3 += $l->ans3;
						$nomor4 += $l->ans4;
						$nomor5 += $l->ans5;
						$nomor6 += $l->ans6;
						$nomor7 += $l->ans7;
						$nomor8 += $l->ans8;
						$nomor9 += $l->ans9;
						$nomor10 += $l->ans10;
						$nomor11 += $l->ans11;
						$no++;
					}
					$rerata1 = $nomor1/$no;
					$hasilnya1 = $rerata1 * 25;
					$rerata2 = $nomor2/$no;
					$hasilnya2 = $rerata2 * 25;
					$rerata3 = $nomor3/$no;
					$hasilnya3 = $rerata3 * 25;
					$rerata4 = $nomor4/$no;
					$hasilnya4 = $rerata4 * 25;
					$rerata5 = $nomor5/$no;
					$hasilnya5 = $rerata5 * 25;
					$rerata6 = $nomor6/$no;
					$hasilnya6 = $rerata6 * 25;
					$rerata7 = $nomor7/$no;
					$hasilnya7 = $rerata7 * 25;
					$rerata8 = $nomor8/$no;
					$hasilnya8 = $rerata8 * 25;
					$rerata9 = $nomor9/$no;
					$hasilnya9 = $rerata9 * 25;
					$rerata10 = $nomor10/$no;
					$hasilnya10 = $rerata10 * 25;
					$rerata11 = $nomor11/$no;
					$hasilnya11 = $rerata11 * 25;
					
					echo number_format($hasilnya1, 2, '.', '').','.number_format($hasilnya2, 2, '.', '').','.number_format($hasilnya3, 2, '.', '').','.number_format($hasilnya4, 2, '.', '').','.number_format($hasilnya5, 2, '.', '').','.number_format($hasilnya6, 2, '.', '').','.number_format($hasilnya7, 2, '.', '').','.number_format($hasilnya8, 2, '.', '').','.number_format($hasilnya9, 2, '.', '').','.number_format($hasilnya10, 2, '.', '').','.number_format($hasilnya11, 2, '.', '');
				?>
				]
			},]

		};

		
	//pie pppm
	var config2 = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
					<?php 
						echo $belum.','.$sudahlppm;
					?>
				],
				backgroundColor: [
					window.chartColors.red,
					window.chartColors.green
				],
				label: 'Kuesioner PPPM'
			}],
			labels: [
				'Belum Isi Kuesioner',
				'Sudah Isi Kuesioner'
			]
		},
		options: {
			responsive: true
		}
	};

	window.onload = function() {
		var atx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(atx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'bottom',
					},
					title: {
						display: true,
						text: 'Kuesioner LPPM'
					}
				}
			});
			
		var atx = document.getElementById('chart-area').getContext('2d');
		window.myPie = new Chart(atx, config);
		
		var ctx = document.getElementById('canvas2').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData2,
				options: {
					responsive: true,
					legend: {
						position: 'bottom',
					},
					title: {
						display: true,
						text: 'Kuesioner PPPM'
					}
				}
			});
			
		var ctx = document.getElementById('chart-area2').getContext('2d');
		window.myPie = new Chart(ctx, config2);
	};
</script>