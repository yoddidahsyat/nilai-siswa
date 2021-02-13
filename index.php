<?php 
require_once 'config.php';

// query soal
$result_soal = mysqli_query($conn, "SELECT * FROM tbl_soal");
while($row = mysqli_fetch_assoc($result_siswa)) {
    $siswa[] = $row;
}

// query siswa
$result_siswa = mysqli_query($conn, "SELECT * FROM tbl_siswa");
while($row = mysqli_fetch_assoc($result_soal)) {
    $soal[] = $row;
}

function getJawabanBySoal($id_soal) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM `tbl_jawaban_siswa` WHERE id_soal = $id_soal");
    while($row = mysqli_fetch_assoc($result)) {
        $jawaban[] = $row;
    }
    return $jawaban;
}

function getJawabanBySiswa($id_siswa) {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM `tbl_jawaban_siswa` WHERE id_siswa = $id_siswa");
    while($row = mysqli_fetch_assoc($result)) {
        $jawaban[] = $row;
    }
    return $jawaban;
}

// menentukan jumlah siswa
$jumlah_siswa = count($siswa);


// menentukan bobot soal
foreach ($soal as $s) {
    $total_salah = 0;
    $jawaban_soal = getJawabanBySoal($s['id_soal']);
    foreach ($jawaban_soal as $jawaban) {
        if ($jawaban['jawaban_siswa'] !== $s['Kunci_jawaban']) {
            $total_salah += 1;
        }
    }
    $s['bobot_soal'] = $total_salah / $jumlah_siswa * 100;
    $new_soal[] = $s;
    $soal = $new_soal;
}


// menentukan nilai siswa
foreach ($siswa as $si) {
    $nilai = 0;
    $jawaban_siswa = getJawabanBySiswa($si['id_siswa']);
    foreach ($jawaban_siswa as $jawaban) {
        foreach ($soal as $so) {
            if ($jawaban['id_soal'] === $so['id_soal'] && $jawaban['jawaban_siswa'] === $so['Kunci_jawaban']) {
                $nilai += $so['bobot_soal'];
            }
        }
    }
    $si['nilai'] = $nilai;
    $new_siswa[] = $si;
    $siswa = $new_siswa;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Educate</title>
</head>
<body>
    <h1>Daftar Nilai Siswa</h1>
    <table>
        <thead>
            <th>No</th>
            <th>Nama</th>
            <th>Nilai</th>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach($siswa as $s) : ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $s['nama'] ?></td>
                    <td><?= number_format($s['nilai'], 2, ',', '.') ?></td>
                </tr>
                <?php $i += 1 ?>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>