<html>
	<head>
		<title>Surat Kontrak Penelitian</title>
		<style>
			page[size="F4"][layout="portrait"] {
			  width: 33cm;
			  height: 21cm;  
			  margin: 50px 110px !important;
			}
			/* margin on left page */
	        @page :left {
	            margin: 50px;
	        }
	 
	        /* margin on right page */
	        @page :right {
	            margin: 50px;
	        }
			body {
			  font-family: "Times New Roman";
			  font-size: 16px;
			  text-align: justify;
  			  text-justify: inter-word;
			}
		.no-break {
			break-inside: avoid;
			page-break-inside: avoid;
		}
		.no-break-after {
			break-after: avoid;
			page-break-after: avoid;
		}
		</style>
	</head>
	<body>
		<img style="margin-top:-20" width="100%" src="<?php echo FCPATH.'assets/img/kop.png' ?>">
		<h3 align="center">KONTRAK PENELITIAN<br>
ANTARA<br>
LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT <br>
UNIVERSITAS JENDERAL ACHMAD YANI YOGYAKARTA <br>
DENGAN<br>
DOSEN PENERIMA HIBAH INTERNAL <br>
SKEMA PENELITIAN<br><br>

NOMOR: <?php echo $tugas['nomorkontrak'];?>
</h3>
<div id="isian" style="margin-left: 30px;margin-right: 30px; text-align: justify-all;">
		<p>&nbsp;</p>
		<?php
			$th = date('Y', strtotime($tugas['tglmulai']));
			$getdate = $this->msubmit->tglterbit($th);
			// $tanggal = tgl_indo($th.'-04-02',1);					
			// $tanggal = tgl_indo($getdate['surat_tugas'],1);
			$textgetdate=tgl_indo($getdate['akhirkontrak'],1);
			$tanggal = tanggal_ke_kalimat($getdate['surat_kontrak']);					
		?>
		<p>Pada hari ini, <?php echo $tanggal; ?>, kami yang bertanda tangan di bawah ini:</p>
		<table style="margin-top:10">
			<tr>
				<td valign="top">1.</td>
				<td width="120" valign="top"><b>Dr. Bdn. Tri Sunarsih, SST., M.Kes.</b></td>
				<td valign="top">:</td>
				<td valign="top" style="text-align: justify !important;">
					dalam hal ini bertindak untuk dan atas nama <b>Lembaga Penelitian dan Pengabdian Kepada Masyarakat Universitas Jenderal Achmad Yani Yogyakarta</b> berdasarkan Surat  Keputusan (SK) Ketua Pengurus YKEP Nomor: Skep/007/UNJAYA/I/2023 tanggal 24 Januari 2023 yang selanjutnya dalam Surat Perjanjian ini disebut sebagai <b>PIHAK PERTAMA</b>.
				</td>
			</tr>
			<?php
				$user = $this->mpengguna->detail($tugas['pengusul']);
				$ketua = $this->mdosen->dosennya($tugas['pengusul']);
				$prodi = $this->mdosen->namaprodi($user['prodi']);
				$fak = $this->mdosen->namafakultas($user['fakultas']);
				$ambil = explode(',',$tugas['anggotadosen']);
				$hit = count($ambil);
				$anggotadosen = '';
				$anggotamhs = '';
				
				if($tugas['anggotadosen']<>'') 
				{
					for($i=0;$i<$hit;$i++)
					{
						$dosen = $this->mdosen->namadosen($ambil[$i]);
						$anggotadosen .= $dosen['namalengkap'];
							if($i<($hit-1))
								$anggotadosen .= ', ';
					}
				}
				else
				{
					$angg = $this->msubmit->perananggota($tugas['id_usulan'],'Penelitian');
					$hits = count($angg);
					$n = 0;
					
					foreach($angg as $a)
					{
						$anggotadosen .= $a->namalengkap.'/'.$a->nidn;
							if($n<($hits-1))
								$anggotadosen .= ', ';
						$n++;
					}
				}
				$split = explode(',',$tugas['anggotamhs']);
				$n = count($split);
				if($tugas['anggotamhs']<>'')
				{
					for($i=0;$i<$n;$i++)
					{
						$mhs = $this->msubmit->namamhs($split[$i]);
						$anggotamhs .= $mhs['namamhs'].'/'.$mhs['npm'];
						if($i<($n-1))
							$anggotamhs .= ', ';
					}
				}
				else
				{
					$angg = $this->msubmit->peranmhs($tugas['id_usulan'],'Penelitian');
					$hits = count($angg);
					$m = 0;
					foreach($angg as $a)
					{
						$anggotamhs .= $a->namamhs.'/'.$a->npm;
						if($m<($hits-1))
							$anggotamhs .= ', ';
					}
					$m++;
				}
			?>
			<tr>
				<td valign="top">2.</td>
				<td width="120" valign="top"><b><?php echo $ketua['namalengkap'];?></b></td>
				<td valign="top">:</td>
				<td valign="top" style="text-align: justify !important;">
					Dosen Prodi <?php echo $prodi['prodi'].', '.$fak['fakultas']; ?>, Universitas Jenderal Achmad Yani Yogyakarta selaku penerima tugas (Ketua Pengusul) program penelitian dosen penerima hibah internal Universitas Jenderal Achmad Yani Yogyakarta skema <?php echo $tugas['skema'] ?> Tahun Anggaran <?php echo $th; ?> dengan judul "<?php echo ucwords(strtolower($tugas['judul'])); ?>" dengan anggota dosen <?php echo $anggotadosen; ?>, anggota mahasiswa <?php echo $anggotamhs;?> yang selanjutnya disebut <b>PIHAK KEDUA</b>
				</td>
			</tr>
		</table>
		<p><b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> secara bersama-sama bersepakat mengikatkan diri dalam suatu Perjanjian Kontrak dalam Pelaksanaan Penelitian dengan  ketentuan  dan   syarat-syarat yang diatur sebagai berikut:</p><br>
		<h3 align="center" class="no-break-after">Pasal 1<br>DASAR HUKUM</h3>
		<ol type="1">
			<li>Surat Perjanjian Kontrak Penelitian ini berdasarkan kepada:
			</li>
			<ol type="a">
				<?php
					foreach($dasartugas as $d)
					{
						echo '<li>'.$d->teks.'</li>';
					}
				?>
			</ol>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 2<br>RUANG LINGKUP</h3>
		<p>Ruang lingkup Kontrak Penelitian ini meliputi Pelaksanaan Penelitian  di perguruan tinggi <b>Universitas Jenderal Achmad Yani Yogyakarta</b> yang dibebankan pada Program Kerja dan Rancangan Anggaran (PKRA) tahun <?php echo $th; ?>.</p>
		
		<h3 align="center" class="no-break-after">Pasal 3<br>JANGKA WAKTU</h3>
		<p>Kontrak Penelitian ini dilaksanakan dalam jangka 6 (enam) bulan dalam tahun berjalan setelah penandatangan kontrak;</p>

		<h3 align="center" class="no-break-after">Pasal 4<br>HAK DAN KEWAJIBAN</h3>
		<ol type="1">
			<li class="no-break-after"><b>PIHAK PERTAMA</b> mempunyai kewajiban:</li>
			<ol type="a">
				<li>memberikan pendanaan Penelitian kepada <b>PIHAK KEDUA</b>; </li>
				<li>melakukan pemantauan dan evaluasi; </li>
				<li>melakukan penilaian luaran Penelitian untuk skema yang diajukan.</li>
			</ol>
			<li><b>PIHAK KEDUA</b> mempunyai kewajiban atas terunggahnya dokumen pertanggungjawaban pelaksanaan Penelitian ke laman <b>simlitabmas.unjaya.ac.id</b> dokumen sebagai berikut: revisi proposal, laporan kemajuan pelaksanaan Penelitian, SPTB, laporan akhir Penelitian, luaran Penelitian paling lambat tanggal <b><?php echo $textgetdate; ?></b>.</li>
			<li><b>PIHAK PERTAMA</b> mempunyai hak menerima dokumen hasil unggahan di laman <b>simlitabmas.unjaya.ac.id</b> sebagaimana tersebut pada ayat (2), <b>paling lambat 3 hari terhitung sejak batas akhir pengunggahan di laman simlitabmas.unjaya.ac.id.</b></li>
			<li><b>PIHAK KEDUA</b> mempunyai hak mendapatkan dana Penelitian dari <b>PIHAK PERTAMA</b></li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 5<br>CARA PEMBAYARAN</h3>
		<ol type="1">
			<li><b>PIHAK PERTAMA</b> memberikan pendanaan penelitian sebagaimana dimaksud dalam Pasal 2 ayat (1) dengan besaran sesuai Pengumuman Penelitian Internal Unjaya Tahun 2026 Nomor: Skep/034/UNJAYA/III/2026 tanggal 30 Maret 2026 dibebankan pada Program Kerja dan Rancangan Anggaran (PKRA) LPPM UNJAYA tahun  <?php echo $th; ?>.</li>
			<li>Pendanaan Pelaksanaan Penelitian sebagaimana dimaksud pada ayat (1) dibayarkan oleh <b>PIHAK PERTAMA</b> kepada <b>PIHAK KEDUA</b> secara bertahap melalui rekening <b>PIHAK KEDUA</b>.</li>
			<li><b>PIHAK PERTAMA</b> mempunyai hak menerima dokumen hasil unggahan di laman <b>simlitabmas.unjaya.ac.id</b> sebagaimana tersebut pada ayat (2), <b>paling lambat 3 hari terhitung sejak batas akhir pengunggahan di laman <b>simlitabmas.unjaya.ac.id.</b></li>
			<li><b>PIHAK KEDUA</b> mempunyai hak mendapatkan dana Penelitian dari <b>PIHAK PERTAMA</b></li>
			<li class="no-break-after">Pendanaan Penelitian sebagaimana dimaksud pada ayat (2), dapat dibayarkan setelah <b>PIHAK KEDUA</b> mengunggah ke laman <b>simlitabmas.unjaya.ac.id</b> selambat-lambatnya bulan <b>Desember <?php echo $th;?></b> dokumen sebagai berikut:</li>
			<ol type="a">
				<li>Laporan kemajuan pelaksanaan Penelitian</li>
				<li>Surat pernyataan tanggungjawab belanja (SPTB) atas dana Penelitian yang telah ditetapkan</li>
				<li>Laporan akhir Penelitian.</li>
				<li>Luaran Penelitian</li>
			</ol>
			<li>Pendanaan Kontrak Penelitian sebagaimana dimaksud dalam ayat (2) dibayarkan kepada <b>PIHAK KEDUA</b>.</li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 6<br>PERGANTIAN KEANGGOTAAN</h3>
		<ol type="1">
			<li>Perubahan terhadap susunan tim pelaksana dan substansi Penelitian dapat dibenarkan apabila telah mendapat persetujuan dari Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM).</li>
			<li>Apabila Ketua tim pelaksana Penelitian tidak dapat menyelesaikan Penelitian atau mengundurkan diri, maka <b>PIHAK KEDUA</b> wajib menunjuk pengganti Ketua Tim Pelaksana Penelitian yang merupakan salah satu anggota tim setelah mendapat persetujuan tertulis dari Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM).</li>
			<li>Dalam hal tidak adanya pengganti ketua tim pelaksana Penelitian sesuai dengan syarat ketentuan yang ada, maka Penelitian dibatalkan dan dana dikembalikan ke Program Kerja dan Rancangan Anggaran (PKRA).</li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 7<br>PAJAK</h3>
		<b>PIHAK KEDUA</b> berkewajiban memungut dan menyetor pajak ke kantor pelayanan pajak setempat yang berkenaan dengan kewajiban pajak berupa :
		<ol type="a">
			<li>Pembelian barang dan jasa dikenai PPN sebesar 10 % dan PPh 22 sebesar 1,5 % dengan menggunakan akun pajak mandiri;</li>
			<li>Pajak-pajak lain sesuai ketentuan yang berlaku.</li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 8<br>KEKAYAAN INTELEKTUAL</h3>
		<ol type="1">
			<li>Hak atas kekayaan Intelektual yang dihasilkan dari pelaksanaan Penelitian diatur dan dikelola sesuai dengan peraturan dan perundang-undangan yang berlaku;</li>
			<li>Setiap publikasi, makalah dan/atau ekspos dalam bentuk apapun yang berkaitan dengan hasil Penelitian ini wajib mencantumkan <b>Universitas Jenderal Achmad Yani Yogyakarta</b> sebagai pemberi dana;</li>
			<li>Hasil Penelitian berupa peralatan dan/atau alat yang dibeli dari kegiatan Penelitian ini adalah milik negara dan dapat dihibahkan kepada Program Studi melalui Berita Acara Serah Terima (BAST);</li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 9<br>KEADAAN KAHAR</h3>
		<ol type="1">
			<li><b>PARA PIHAK</b> dibebaskan dari tanggung jawab atas keterlambatan atau kegagalan dalam memenuhi kewajiban yang dimaksud dalam Kontrak Penelitian disebabkan atau diakibatkan oleh peristiwa atau kejadian diluar kekuasaan <b>PARA PIHAK</b> yang dapat digolongkan sebagai keadaan memaksa (force majeure) ;</li>
			<li>Peristiwa atau kejadian yang dapat digolongkan keadaan memaksa (force majeure) dalam Kontrak Penelitian ini adalah bencana alam, wabah penyakit, kebakaran, perang, blokade, peledakan, sabotase, revolusi, pembrontakan, huru hara, serta adanya tindakan pemerintah dalam bidang ekonomi dan moneter yang secara nyata berpengaruh terhadap pelaksanaan Kontrak Penelitian ini;</li>
			<li>Apabila terjadi keadaan memaksa (force majeure) maka pihak yang mengalami wajib memberitahukan kepada pihak lainnya secara tertulis , selambat-lambatnya dalam waktu 7 (tujuh) hari kerja sejak terjadinya keadaan memaksa (force majeure), disertai dengan bukti-bukti yang sah dari pihak yang berwajib, dan <b>PARA PIHAK</b> dengan itikad baik akan segera membicarakan penyelesaiannya.</li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 10<br>PENYELESAIAN PERSELISIHAN</h3>
		<ol type="1">
			<li>Apabila terjadi perselisihan antara <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> dalam pelaksanaan Kontrak Penelitian ini akan dilakukan penyelesaian secara musyawarah dan mufakat;</li>
			<li>Dalam hal tidak tercapainya penyelesaian secara musyawarah dan mufakat sebagaimana dimaksud ayat (1), maka penyelesaian dilakukan melalui proses Hukum yang berlaku dengan memilih domisili Hukum di Pengadilan Negeri Yogyakarta.</li>
		</ol>

		<h3 align="center" class="no-break-after">Pasal 11<br>AMANDEMEN KONTRAK</h3>
		<p>Apabila terdapat hal-hal lain yang belum diatur dalam Kontrak Penelitian ini dan memerlukan perubahan, maka akan diatur kemudian oleh <b>PARA PIHAK</b> melalui amandemen Kontrak Penelitian dan/atau melalui Pembuatan perjanjian tersendiri yang merupakan bagian tidak terpisahkan dari Kontrak Penelitian ini.</p>

		<h3 align="center" class="no-break-after">Pasal 12<br>SANKSI</h3>
		<ol type="1">
			<li>Apabila sampai batas waktu yang telah ditetapkan untuk melaksanakan kontrak Penelitian telah berakhir, <b>PIHAK KEDUA</b> tidak melaksanakan kewajiban sebagaimana dimaksud dalam pasal 4 ayat (2), maka <b>PIHAK KEDUA</b> dikenakan sanksi administratif.</li>
			<li>Sanksi administratif sebagaimana dimaksud pada ayat (1) adalah berupa pemotongan anggaran pada Tahap Kedua yaitu hanya akan dicairkan sebesar 15% dari sisa dana yang belum dicairkan serta tidak dapat mengajukan proposal Penelitian sampai terselesaikannya kewajiban yang telah ditetapkan baik ketua maupun anggota.</li>
		</ol>
		<h3 align="center" class="no-break-after">Pasal 13<br>LAIN-LAIN</h3>
		<p>Dalam hal <b>PIHAK KEDUA</b> berhenti atau menggundurkan dari sebagai ketua pelaksana sebelum Kontrak Penelitian ini selesai, maka <b>PIHAK KEDUA</b> wajib melakukan serah terima tanggungjawabnya kepda anggota Penelitian yang menggantikannya.</p>
		<h3 align="center" class="no-break-after">Pasal 14<br>PENUTUP</h3>
		<p>Surat Perjanjian Kontrak Penelitian ini dibuat rangkap 2 (dua), dan bermaterai cukup sesuai dengan ketentuan yang berlaku dan biaya materainya dibebankan kepada <b>PIHAK KEDUA</b>.</p>

		<div class="no-break">
			<table style="margin-top:60">
			<tr>
				<td width="350px"><b>PIHAK PERTAMA</b><br>Ka. LPPM Unjaya</td>
				<td width="350px"><b>PIHAK KEDUA</b><br>Ketua Pengusul</td>
			</tr>
			<tr>
				<?php if($tugas['suratkontrak']<>'') {
				echo '<td width="350px"><img style="margin-top:0" width="60%" src="'.FCPATH.'assets/img/disetujui.png'.'"</td>
				      <td width="350px"><img style="margin-top:0" width="60%" src="'.FCPATH.'assets/img/disetujui.png'.'"</td>';
				}
				?>
			</tr>
			<tr>
				<td width="350px"><p style="margin-top:10px">Dr. Bdn. Tri Sunarsih, SST., M.Kes.</p></td>
				<td width="350px">
					<p style="margin-top:10px"><?php echo $ketua['namalengkap']; ?></p>
				</td>
			</tr>
			</table>
		</div>
	</div>
	</body>
</html>