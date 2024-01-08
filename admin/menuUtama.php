<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "ecommerce";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
  die("Tidak bisa terkoneksi ke database!");
}

$product_id = "";
$id = "";
$nama_produk = "";
$diskon = "";
$harga_asli = "";
$harga_diskon = "";
$image = "";
$sukses = "";
$error = "";
$success = "";

// op
$filename = "";
$tempname = "";  
$folder = ""; 

session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}


if (isset($_POST['simpan'])) {
  $id = $_POST['id'];
  $nama_produk = $_POST['nama_produk'];
  $diskon = $_POST['diskon'];
  $harga_asli = $_POST['harga_asli'];
  $harga_diskon = $_POST['harga_diskon'];
  
  $filename = $_FILES["gambar"]["name"];
  $tempname = $_FILES["gambar"]["tmp_name"];  
  $folder = "../customer/images/".$filename;   



  
  if ($id && $nama_produk && $diskon && $harga_asli && $filename && $tempname) {
    $id_check_query = "SELECT * FROM produk WHERE id='$id'";
    $id_check_result = mysqli_query($koneksi, $id_check_query);

    if (mysqli_num_rows($id_check_result) > 0) {
      $error = "ID produk '$id' sudah ada di database!";
    } else {
      // Insert data ke database
      $sql1 = "INSERT INTO produk(id, nama_produk, diskon, gambar,  harga_asli, harga_diskon) VALUES ('$id', '$nama_produk', '$diskon', '$filename', '$harga_asli','$harga_diskon')";
      $q1 = mysqli_query($koneksi, $sql1);
      move_uploaded_file($tempname, $folder);

      if ($q1) {
        $sukses = "Berhasil Memasukkan data baru";
        $id = '';
        $nama_produk = '';
        $diskon = '';
        $harga_asli = '';
        $harga_diskon = '';
        $filename = '';
      } else {
        $error = "Gagal memasukkan data";
      }
    }
  } else {
    $error = "Pastikan semua data telah terisi!";
  }
}


if ($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "DELETE FROM produk where id = '$id'";
  $q1 = mysqli_query($koneksi, $sql1);
  if ($q1) {
      // $sukses = "Berhasil Hapus Data";
      $success = "Berhasil Hapus Data";
  } else {
      $error = "Gagal Delete Data";
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px;
    }

    body {
      font-family: 'Roboto', sans-serif;
      font-weight: 400;
    }
  </style>
  <title>Pengelolaan Product</title>
</head>

<body>
  <div class="">
    <h1 class="text-center text-lg" style="font-weight: 600;">Selamat Datang, <?php echo $user_data['user_name']; ?>
    </h1>
  </div>
  <div class="container">
    <div class="mx-auto">
      <!-- masukkan data -->

      <div class="card">
        <div class="card-header text-center text-white  fs-4 bg-success">
          Input Data Product
        </div>
        <div class="card-body">
          <?php
          if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          }
          ?>
          <?php
          if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          }
          ?>
          <form action="menuUtama.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="id" class="form-label">ID Produk</label>
              <input type="text" class="form-control" id="id" name="id"
                placeholder="Masukkan Nama Product Anda" value="<?php echo $id ?>" />
            </div>
            <div class="mb-3">
              <label for="nama_produk" class="form-label">Nama Product</label>
              <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                placeholder="Masukkan Nama Product Anda" value="<?php echo $nama_produk ?>" />
            </div>
            <div class="mb-3">
              <label for="diskon" class="form-label">Diskon (%)</label>
              <input type="text" class="form-control" id="diskon" name="diskon"
                placeholder="Masukkan Persentase Diskon" value="<?php echo $diskon ?>" />
            </div>
            <div class="mb-3">
              <label for="harga_asli" class="form-label">Harga Asli</label>
              <input type="text" class="form-control" id="harga_asli" name="harga_asli"
                placeholder="Masukkan Harga Asli Product" value="<?php echo $harga_asli ?>" />
            </div>
            <div class="mb-3">
              <label for="harga_diskon" class="form-label">Harga Diskon</label>
              <input type="text" class="form-control" id="harga_diskon" name="harga_diskon"
                placeholder="Masukkan Harga Diskon Product" value="<?php echo $harga_diskon ?>" />
            </div>
            <div class="mb-3">
              <label for="gambar">Gambar:</label>
              <input type="file" name="gambar" id="gambar">
            </div>
            <div class="d-flex justify-content-center grid gap-3">
              <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
              <a href="menuUtama.php"><button type="button" class="btn btn-success">Refresh</button></a>
              <a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="mx-auto">
      <div class="card">
        <div class="card-header text-center text-white fs-4 bg-success">
          Proses Data Product
        </div>
        <div class="card-body">
          <?php
          if ($success) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $success ?>
          </div>
          <?php
          }
          ?>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Gambar</th>
                <th scope="col">ID Product</th>
                <th scope="col">Nama Product</th>
                <th scope="col">Diskon (%)</th>
                <th scope="col">Harga Asli</th>
                <th scope="col">Harga Diskon</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql2 = "SELECT * FROM produk order by id asc";
              $q2 = mysqli_query($koneksi, $sql2);
              $urut = 1;
              while ($r2 = mysqli_fetch_array($q2)) {
                $image = $r2['gambar'];
                $product_id = $r2['id'];
                $nama_produk = $r2['nama_produk'];
                $diskon = $r2['diskon'];
                $harga_asli = $r2['harga_asli'];
                $harga_diskon = $r2['harga_diskon'];
              ?>
                <tr>
                  <td>
                    <!-- Menampilkan gambar dengan tag img -->
                    <img src="../customer/images/<?php echo $image ?>" alt='<?php echo $image; ?>' style="max-width: 100px;">
                  </td>

                  <td scope="row"><?php echo $product_id ?></td>
                  <td scope="row"><?php echo $nama_produk ?></td>
                  <td scope="row"><?php echo $diskon ?></td>
                  <td scope="row"><?php echo $harga_asli ?></td>
                  <td scope="row"><?php echo $harga_diskon ?></td>
                  <td scope="row" class="d-flex grid gap-2">
                    <a href="update.php?op=update&id=<?php echo $product_id ?>"><button type="button"
                        data-toggle="tooltip" title="Update Data" class="btn btn-warning btn-sm">update</button></a>
                    <a href="menuUtama.php?op=delete&id=<?php echo $product_id ?> " data-toggle="tooltip"
                      title="Hapus Data" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button"
                        class="btn btn-danger btn-sm">delete</button></a>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <script src="https://kit.fontawesome.com/3d5280bb81.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
  <script>
  // Fungsi untuk menghitung harga setelah diskon
  function hitungHargaDiskon() {
    var diskon = parseFloat(document.getElementById('diskon').value);
    var hargaAsli = parseFloat(document.getElementById('harga_asli').value);

    // Memastikan kedua nilai telah diisi dan merupakan angka
    if (!isNaN(diskon) && !isNaN(hargaAsli)) {
      // Menghitung harga setelah diskon
      var hargaDiskon = hargaAsli - (hargaAsli * (diskon / 100));

      // Menampilkan hasil di input harga_diskon
      document.getElementById('harga_diskon').value = hargaDiskon.toFixed(2);
    }
  }

  // Menambahkan event listener untuk memanggil fungsi saat nilai diskon atau harga asli berubah
  document.getElementById('diskon').addEventListener('input', hitungHargaDiskon);
  document.getElementById('harga_asli').addEventListener('input', hitungHargaDiskon);
</script>

</body>

</html>
