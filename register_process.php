<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $jurusan = $_POST["jurusan"];
    $email = $_POST["email"];
    $nim = $_POST["nim"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $lokasi = isset($_POST["lokasi"]) ? implode(", ", $_POST["lokasi"]) : "";
    $kategori = $_POST["kategori"];
    $subkategori = $_POST["subkategori"];
    $skill = isset($_POST["skill"]) ? implode(", ", $_POST["skill"]) : "";

    // Simpan ke file atau database (ini versi file .txt sederhana)
    $data = "$nama|$jurusan|$email|$nim|$tanggal_lahir|$password|$lokasi|$kategori|$subkategori|$skill\n";
    file_put_contents("data_user.txt", $data, FILE_APPEND);

    // Redirect ke login.html
    header("Location: login.php");
    exit();
}
?>
