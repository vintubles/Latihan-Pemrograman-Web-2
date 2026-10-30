<?php
session_start();

// ====== KONEKSI DATABASE ======
$host = "localhost";
$user = "root";
$pass = "";               // default XAMPP kosong
$db   = "db_pendaftaran";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = new mysqli($host, $user, $pass, $db);
    $koneksi->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Koneksi database gagal: " . htmlspecialchars($e->getMessage()));
}

// ====== PROSES SIMPAN ======
if (isset($_POST['simpan'])) {

    $kode = strtoupper(trim($_POST['kode']));
    $mat  = (int) $_POST['mat'];
    $bing = (int) $_POST['bing'];
    $umum = (int) $_POST['umum'];

    $rata = ($mat + $bing + $umum) / 3;

    if ($rata >= 70) {
        $keterangan = "Lulus";
    } elseif ($rata >= 60) {
        $keterangan = "Cadangan";
    } else {
        $keterangan = "Tidak Lulus";
    }

    $kode_awal = substr($kode, 0, 1);

    if ($kode_awal == "A") {
        $tempat_tes = "Gedung A";
    } elseif ($kode_awal == "B") {
        $tempat_tes = "Gedung B";
    } elseif ($kode_awal == "V") {
        $tempat_tes = "Viktor";
    } else {
        $tempat_tes = "Tidak Diketahui";
    }

    $stmt = $koneksi->prepare(
        "INSERT INTO pendaftar
        (tgl_input, kode, nama, jk, asal_sekolah, pekerjaan_ortu, tempat_lahir, tgl_lahir, mat, bing, umum, rata, keterangan, tempat_tes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssssssssiiidss",
        $_POST['tgl_input'],
        $kode,
        $_POST['nama'],
        $_POST['jk'],
        $_POST['asal_sekolah'],
        $_POST['pekerjaan_ortu'],
        $_POST['tempat_lahir'],
        $_POST['tgl_lahir'],
        $mat,
        $bing,
        $umum,
        $rata,
        $keterangan,
        $tempat_tes
    );
    $stmt->execute();
    $stmt->close();

    $_SESSION['pesan']  = "Data berhasil disimpan ke database. Klik <b>TAMPILKAN DATA</b> untuk melihat hasilnya.";
    $_SESSION['tampil'] = false;

    // Redirect supaya data tidak terkirim ulang saat halaman di-refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// ====== TAMPILKAN / TUTUP ======
if (isset($_POST['tampilkan'])) {
    $_SESSION['tampil'] = true;
}
if (isset($_POST['tutup'])) {
    $_SESSION['tampil'] = false;
}

$tampil = isset($_SESSION['tampil']) && $_SESSION['tampil'] === true;

// Ambil pesan sekali saja (flash message)
$pesan = "";
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
}

// Cek apakah sudah ada data di database
$cek = $koneksi->query("SELECT COUNT(*) AS total FROM pendaftar")->fetch_assoc();
$ada_data = $cek['total'] > 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS PHP - Pendaftaran Mahasiswa</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 15px;
            background: #f4f4f4;
            box-sizing: border-box;
        }

        .container{
            width: 100%;
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            box-sizing: border-box;
        }

        h2{
            text-align: center;
        }

        /* Pembungkus tabel: bisa digeser ke samping kalau kelebihan lebar */
        .tabel-responsif{
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 20px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        table, th, td{
            border: 1px solid black;
        }

        th, td{
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        input[type=text],
        input[type=number],
        input[type=date]{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .btn{
            background: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn:hover{
            background: darkblue;
        }

        .btn-hijau{
            background: green;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-hijau:hover{
            background: darkgreen;
        }

        .btn-merah{
            background: crimson;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .btn-merah:hover{
            background: darkred;
        }

        .info{
            margin-top: 20px;
            padding: 10px;
            background: #eef;
        }

        .sukses{
            margin-top: 20px;
            padding: 10px;
            background: #dfd;
            border: 1px solid green;
        }

        /* Layar kecil (HP) */
        @media (max-width: 600px){
            .container{
                padding: 15px;
            }
            h2{
                font-size: 18px;
            }
            .btn, .btn-hijau, .btn-merah{
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <h2>FORM PENDAFTARAN MAHASISWA BARU</h2>

    <form method="POST">

        <label>Tanggal Input</label>
        <input type="date" name="tgl_input" required>

        <label>Kode Pendaftaran</label>
        <input type="text" name="kode" placeholder="Contoh : A2" maxlength="10" required>

        <label>Nama Pendaftar</label>
        <input type="text" name="nama" required>

        <label>Jenis Kelamin</label><br>
        <input type="radio" name="jk" value="Laki-Laki" required> Laki-Laki
        <input type="radio" name="jk" value="Perempuan"> Perempuan
        <br><br>

        <label>Asal Sekolah</label>
        <input type="text" name="asal_sekolah" required>

        <label>Pekerjaan Orang Tua</label>
        <input type="text" name="pekerjaan_ortu" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" required>

        <label>Matematika</label>
        <input type="number" name="mat" min="0" max="100" required>

        <label>Bahasa Inggris</label>
        <input type="number" name="bing" min="0" max="100" required>

        <label>Umum</label>
        <input type="number" name="umum" min="0" max="100" required>

        <button type="submit" name="simpan" class="btn">SIMPAN</button>

    </form>

    <?php if ($pesan != "") { ?>
        <div class="sukses"><?php echo $pesan; ?></div>
    <?php } ?>

    <!-- Tombol Tampilkan / Tutup Data -->
    <?php if ($ada_data) { ?>
        <form method="POST" style="margin-top:20px;">
            <?php if ($tampil) { ?>
                <button type="submit" name="tutup" class="btn-merah">TUTUP DATA</button>
            <?php } else { ?>
                <button type="submit" name="tampilkan" class="btn-hijau">TAMPILKAN DATA</button>
            <?php } ?>
        </form>
    <?php } ?>

    <?php if ($tampil && $ada_data) {

        $hasil = $koneksi->query("SELECT * FROM pendaftar ORDER BY id ASC");

        // Rekap dari database
        $rekap = $koneksi->query(
            "SELECT
                COUNT(*) AS total,
                SUM(keterangan = 'Lulus') AS lulus,
                SUM(keterangan = 'Cadangan') AS cadangan,
                SUM(keterangan = 'Tidak Lulus') AS tidak_lulus
             FROM pendaftar"
        )->fetch_assoc();
    ?>

        <div class="tabel-responsif">
            <table>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Tgl Lahir</th>
                    <th>Asal Sekolah</th>
                    <th>Pekerjaan Ortu</th>
                    <th>Tempat Tes</th>
                    <th>MAT</th>
                    <th>B. Inggris</th>
                    <th>Umum</th>
                    <th>Rata-rata</th>
                    <th>Keterangan</th>
                </tr>

                <?php $no = 1; while ($d = $hasil->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($d['kode']); ?></td>
                    <td><?php echo htmlspecialchars($d['nama']); ?></td>
                    <td><?php echo htmlspecialchars($d['jk']); ?></td>
                    <td><?php echo htmlspecialchars($d['tempat_lahir']) . ", " . $d['tgl_lahir']; ?></td>
                    <td><?php echo htmlspecialchars($d['asal_sekolah']); ?></td>
                    <td><?php echo htmlspecialchars($d['pekerjaan_ortu']); ?></td>
                    <td><?php echo htmlspecialchars($d['tempat_tes']); ?></td>
                    <td><?php echo $d['mat']; ?></td>
                    <td><?php echo $d['bing']; ?></td>
                    <td><?php echo $d['umum']; ?></td>
                    <td><?php echo number_format($d['rata'], 2); ?></td>
                    <td><?php echo htmlspecialchars($d['keterangan']); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="info">
            <h3>Rekap Data:</h3>
            <p>Jumlah Pendaftar : <b><?php echo $rekap['total']; ?></b></p>
            <p>Jumlah Peserta Lulus : <b><?php echo $rekap['lulus']; ?></b></p>
            <p>Jumlah Cadangan : <b><?php echo $rekap['cadangan']; ?></b></p>
            <p>Jumlah Tidak Lulus : <b><?php echo $rekap['tidak_lulus']; ?></b></p>
        </div>

        <div class="info">
            <h3>Keterangan:</h3>
            <p><b>Kode Tempat Tes:</b></p>
            <ul>
                <li>A = Gedung A</li>
                <li>B = Gedung B</li>
                <li>V = Viktor</li>
            </ul>

            <p><b>Hasil Seleksi:</b></p>
            <ul>
                <li>Rata-rata ≥ 70 = Lulus</li>
                <li>Rata-rata 60 - 69 = Cadangan</li>
                <li>Rata-rata &lt; 60 = Tidak Lulus</li>
            </ul>
        </div>

    <?php } ?>

</div>

</body>
</html>