
<?php

	$berkas = "data/data.json";
	$dataJson = file_get_contents($berkas);
	$tiketKonserAll = json_decode($dataJson, true);

	//Array Kategori Tiket
	$kategoriTiket = array ("CAT 1A", "CAT 1B", "CAT 2A","CAT 2B", "CAT 3", "CAT 4A", "CAT 4B", "CAT 5A", "CAT 5B");
				//Array katergori tiket
	$jumlahTiket = array ("1", "2", "3", "4"); 
				//Array jumlah tiket
	$hargaTiket = array ("CAT 1A"=>2600000, "CAT 1B"=>2600000, "CAT 2A"=>2450000,"CAT 2B"=>2450000, "CAT 3"=>1950000, "CAT 4A"=>1500000, "CAT 4B"=>1500000, "CAT 5A"=>900000, "CAT 5B"=>900000);
				//Array harga tiket									
	$jumlahTiketnya = array ("1"=>1, "2"=>2, "3"=>3, "4"=>4); 											
				//Aray jumlah tiket

	//Fungsi Menghitung Total Pembayaran

	function totalPembayaran($kategori, $jumlah){
		global $hargaTiket, $jumlahTiketnya;											//Variabel Global

		foreach ($hargaTiket as $harga =>$harga_value) {								//Mengambil harga tiket
			if($kategori == $harga){
				$hargatix = $harga_value;
			}
		}

		foreach ($jumlahTiketnya as $jumlahtix =>$jumlahtix_value) {					//Mengambil jumlah tiket
			if($jumlah == $jumlahtix){
				$jumlahtixnya = $jumlahtix_value;
			}
		}
		return $hargatix * $jumlahtixnya ;
	}
?>
	

<!DOCTYPE html>
<html>
<head>
	<title>Tiket Konser</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<img src="gambar/satu.jpg">
	<img src="gambar/dua.jpg">
	<h1>Detail Pemesanan</h1>

	<!-- Form Booking Studio Dance -->
	<form action="index.php" method="post">
		<table width="700px">
			<tr>
				<td width="20%"><label>Nama Lengkap</label></td>
				<td>:</td>
				<td width="80%"><input type="text" name="nama" class="inputtext" placeholder="Tuliskan Nama" required=""></td>
				<!-- Input Nama -->
			</tr>
			<tr>
				<td width="20%"><label>Nomor Ponsel</label></td>
				<td>:</td>
				<td width="80%"><input type="text" name="nohp" class="inputtext" placeholder="Tuliskan Nomor Ponsel" required=""></td> <!-- Input nomor ponsel -->
			</tr>
			<tr>
				<td width="20%"><label>Email</label></td>
				<td>:</td>
				<td width="80%"><input type="text" name="email" class="inputtext" placeholder="Tuliskan Email" required=""></td> <!-- Input Email -->
			</tr>
			<tr>
				<td width="20%"><label>NIK</label></td>
				<td>:</td>
				<td width="80%"><input type="text" name="nik" class="inputtext" placeholder="Tuliskan NIK" required=""></td> <!-- Input NIK -->
			</tr>
			<tr>
				<td><label>Tanggal Lahir</label></td>
				<td>:</td>
				<td><input type="date" name="tanggal" class="inputtext" required=""></td> 				
				<!-- Input Tanggal Lahir -->
			</tr>
			<tr>
				<td><label>Kategori</label></td> 																			
				<td>:</td>
				<td>
					<select name="kategori">
						<?php
							foreach ($kategoriTiket as $kt) {
								echo "<option value='".$kt."'>".$kt."</option>";
							}
						?>
					</select>
				</td>
			</tr>
				<td><label>Jumlah Tiket</label></td> 																			
				<td>:</td>
				<td>
					<select name="jumlah">
						<?php
							foreach ($jumlahTiket as $jt) {
								echo "<option value='".$jt."'>".$jt."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center;"><input type="submit" value="Beli Tiket" name="submit"></td>					
				<!-- Submit Form -->
			</tr>
		</table>		
	</form> <br>

	<!-- Menampung seluruh hasil inputan User -->
	<?php
		if(isset($_POST['submit'])){
			$Nama = $_POST['nama'];
			$nohp = $_POST['nohp'];
			$email = $_POST['email'];
			$NIK = $_POST['nik'];
			$tanggalLahir = $_POST['tanggal'];
			$kategoriTiketnya = $_POST['kategori'];
			$totalJumlahTiket = $_POST['jumlah'];
			$totalHargaPembayaran = totalPembayaran($kategoriTiketnya, $totalJumlahTiket);

			
			$dataPemesan = [$Nama, $nohp, $email, $NIK, $tanggalLahir, $kategoriTiketnya, $totalJumlahTiket, $totalHargaPembayaran];		//Menampung inputan User kedalam Array sementara
			array_push($tiketKonserAll, $dataPemesan);																										//Memasukan Array baru kedalam Array Data dan Jadwal Booking
			array_multisort($tiketKonserAll, SORT_ASC);																												//Mengurutkan Data dan Jadwal Booking sesuai Abjad dari yang terkecil
			$dataJson = json_encode($tiketKonserAll, JSON_PRETTY_PRINT);
			file_put_contents($berkas, $dataJson);
		}

	?>

	<!-- Menampilkan Data dan Jadwal Booking -->
	<h1>Data Pemesan Tiket</h1>
	<table border="1px" width="800px">
		<thead>
			<tr>
				<th>Nama</th>
				<th>Nomor Ponsel</th>
				<th>Emai</th>
				<th>NIK</th>
				<th>Tanggal Lahir</th>
				<th>Kategori Tiket</th>
				<th>Jumlah Tiket</th>
				<th>Total Pembayaran</th>
			</tr>
		</thead>
		<tbody>
			<!-- Perulangan untuk menampilkan isi Array Data dan Jadwal Booking -->
			<?php
				for($i=0; $i<count($tiketKonserAll); $i++){
					echo "<tr>";
					echo "<td>".$tiketKonserAll[$i][0]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][1]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][2]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][3]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][4]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][5]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][6]."</td>";
					echo "<td style='text-align: center;'>".$tiketKonserAll[$i][7]."</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
	

</body>
</html>