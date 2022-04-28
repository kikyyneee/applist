<?php 
require 'functions.php';

//ambil data dari url
// if( isset($_GET["id"]) ) {
$id = $_GET["id"];
// }

//query data mahasiswa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];
// var_dump($mhs["nama"]);

//cek tombol submit sudah ditekan atau belum
if ( isset($_POST["submit"]) ) {

    //cek apakah data berhasil diubah atau tidak
    if ( ubah($_POST) > 0 ) {
        echo "
            <script>
                alert('Data Berhasil Diubah !');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah !');
                document.location.href = 'index.php';
            </script>
        ";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppList | Ubah Data</title>
</head>
<body>
    
    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $mhs["id"]; ?>">
        <ul>
            <li>
                <label for="nrp">NRP :</label>
                <input type="text" name="nrp" id="nrp" required
                value="<?php echo $mhs["nrp"]; ?>"
                >
            </li>
            <br>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required
                value="<?php echo $mhs["nama"]; ?>">
            </li>
            <br>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required
                value="<?php echo $mhs["email"]; ?>">
            </li>
            <br>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required
                value="<?php echo $mhs["jurusan"]; ?>">
            </li>
            <br>
            <li>
                <label for="gambar">Gambar :</label>
                <input type="text" name="gambar" id="gambar"
                value="<?php echo $mhs["gambar"]; ?>">
            </li>
            <br>
            <li>
                <button type="submit" name="submit">Ubah Data !</button>
            </li>
        </ul>
    </form>

</body>
</html>