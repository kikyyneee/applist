<?php 
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

//query
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;
    $nrp = htmlspecialchars( $data["nrp"]);
    $nama = htmlspecialchars( $data["nama"]);
    $email = htmlspecialchars( $data["email"]);
    $jurusan = htmlspecialchars( $data["jurusan"]);

    //upload gambar
    $gambar = upload();
    if ( !$gambar ) {
        return false;
    }

    $query = "INSERT INTO mahasiswa
                VALUES
              ('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')
              ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek gambar di upload atau tidak
    if ( $error === 4 ) {
        echo "<script>
                alert('Pilih Gambar Terlebih Dahulu');
            </script>";
    return false;
    }

    //yang di upload apakah gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower( end($ekstensiGambar) );
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
                alert('Yang Anda Upload Bukan Gambar');
            </script>";
        return false;
    }

    //cek jika ukuran terlalu besar
    if ( $ukuranFile > 1000000 ) {
        echo "<script>
                alert('Ukuran Gambar Terlalu Besar');
            </script>";
    return false;
    }

    //lolos pengecekan
    //generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    $id = $data(["id"]);
    $nrp = htmlspecialchars( $data["nrp"]);
    $nama = htmlspecialchars( $data["nama"]);
    $email = htmlspecialchars( $data["email"]);
    $jurusan = htmlspecialchars( $data["jurusan"]);
    $gambar = htmlspecialchars( $data["gambar"]);

    $query = "UPDATE mahasiswa SET
                nrp = '$nrp',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
            WHERE id = $id
            ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    // global $conn;
    $query = "SELECT * FROM mahasiswa 
                WHERE
              nrp LIKE '%$keyword%' OR
              nama LIKE '%$keyword%' OR
              email LIKE '%$keyword%' OR
              jurusan LIKE '%$keyword%'
              ";
    return query($query);
}
?>