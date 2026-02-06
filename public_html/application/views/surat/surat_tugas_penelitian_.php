<html>
	<head>
		<title>Surat Tugas Penelitian</title>
		<style>
			page[size="F4"][layout="portrait"] {
			  width: 33cm;
			  height: 21cm;  
			  margin: 50px 110px !important;
			}

			body {
			  font-family: "Times New Roman";
			  font-size: 15px;
			}
			#halaman {
	           /* width: auto; 
	            height: auto; 
	            position: absolute; */
/*	            border: 1px solid; */
	            padding-left: 50px; 
	            padding-right: 50px; 
	            padding-bottom: 50px;
	            text-align: justify-all;
	        }

		</style>
	</head>
	<body>
		<img style="margin-top:-20" width="100%" src="<?php echo 'http://localhost/lppm/assets/img/kop.png';?>">
		<div id="halaman">
		<h2 align="center"><u>S&nbsp;U&nbsp;R&nbsp;A&nbsp;T&nbsp;&nbsp;T&nbsp;U&nbsp;G&nbsp;A&nbsp;S</u></h2>
		<p align="center" style="margin-top:-10"><?php echo $tugas['nomortugas'];?></p>
		<table style="margin-top:10">
			<tr>
				<td width="60px" valign="top">Dasar</td>
				<td valign="top">:</td>
				<td valign="top">
					<ol>
						<?php
							foreach($dasartugas as $d)
							{
								echo '<li>'.$d->teks.'</li>';
							}
						?>
					</ol>
				</td>
			</tr>
		</table>
		<h2 align="center">D&nbsp;I&nbsp;T&nbsp;U&nbsp;G&nbsp;A&nbsp;S&nbsp;K&nbsp;A&nbsp;N</h2>
		<table style="margin-top:10">
			<tr>
				<td width="60px" valign="top">Kepada</td>
				<td valign="top">:</td>
				<td valign="top">
					<ol>
						<?php
							$ketua = $this->mdosen->dosennya($tugas['pengusul']);
						?>
						<li><?php echo $ketua['namalengkap'].'/'.$ketua['nidn']; ?></li>
						<?php
							$ambil = explode(',',$tugas['anggotadosen']);
							$hit = count($ambil);
							
							if($tugas['anggotadosen']<>'') 
							{
								for($i=0;$i<$hit;$i++)
								{
									$dosen = $this->mdosen->namadosen($ambil[$i]);
									echo '<li>'.$dosen['namalengkap'].'/'.$dosen['nidn'].'</li>';
								}
							}
							$split = explode(',',$tugas['anggotamhs']);
							$n = count($split);
							for($i=0;$i<$n;$i++)
							{
								$mhs = $this->msubmit->namamhs($split[$i]);
								echo '<li>'.$mhs['namamhs'].'/'.$mhs['npm'].'</li>';
							}
						?>
					</ol>
				</td>
			</tr>
			<tr>
				<td width="60px" valign="top">Untuk</td>
				<td valign="top">:</td>
				<td valign="top">
					<p style="margin-left:20">Melaksanakan Penelitian dengan judul :</p>
					<p style="margin-left:20"><?php echo ucwords(strtolower($tugas['judul']));?></p>
				</td>
			</tr>
			<tr>
				<td width="60px" valign="top"></td>
				<td valign="top"></td>
				<td>
					<u style="margin-left:20">Catatan</u> :             
					<ol>
						<li>Sesudah melaksanakan tugas, lapor kepada Ketua LPPM dengan melampirkan laporan hasil Penelitian.</li>
						<li>Laksanakan tugas dengan penuh rasa tanggung jawab.</li>
					</ol>
				</td>
			</tr>
			<tr>
				<tr><td></td></tr>
			</tr>
			<tr>
				<td valign="top">Selesai</td>
				<td valign="top"></td>
				<td></td>
			</tr>
		</table>
		<p>&nbsp;</p>
		<table style="margin-top:30;">
			<tr>
				<td></td>
				<?php
					$th = date('Y', strtotime($tugas['tglmulai']));
					$getdate = $this->msubmit->tglterbit($th);
					// $tanggal = tgl_indo($th.'-04-02',1);					
					$tanggal = tgl_indo($getdate['surat_tugas'],1);					
				?>
				<td style="float:right">Dikeluarkan di Yogyakarta <br>pada tanggal <?php echo $tanggal; ?>
				<p style="margin-top:1;">Ka. LPPM</p>
				</td>
			</tr>
			<tr>
				<td width="370px"></td>
				<td>
					<img style="margin-top:-10;margin-left:-60;z-index:99" width="130" src="<?php echo base_url().'assets/img/stempel.png'; ?>">
					<img style="position:absolute;margin-left:-50;z-index:-1" width="110" src="<?php echo base_url().'assets/img/ttd.jpg'; ?>">
					<p style="margin-top:-40;">Dr. Tri Sunarsih, SST., M.Kes. </p>
				</td>
			</tr>
		</table>
		</div>
	</body>
</html>