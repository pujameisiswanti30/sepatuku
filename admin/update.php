<?php
// Include your database connection and functions file
include("connection.php");
include("functions.php");

$koneksi = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database!");
}

// Check if the user is logged in
session_start();
$user_data = check_login($con);

// Initialize variables
$id = "";
$nama_produk = "";
$diskon = "";
$harga_asli = "";
$harga_diskon = "";
$current_image = "";

// Get the product data to be updated
if (isset($_GET['op']) && $_GET['op'] == 'update' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM produk WHERE id = '$id'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_image = $row['gambar'];
        $nama_produk = $row['nama_produk'];
        $diskon = $row['diskon'];
        $harga_asli = $row['harga_asli'];
        $harga_diskon = $row['harga_diskon'];
    } else {
        echo "Produk tidak ditemukan!";
        exit();
    }
}

// Update product data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $diskon = $_POST['diskon'];
    $harga_asli = $_POST['harga_asli'];
    $harga_diskon = $_POST['harga_diskon'];

    $filename = $_FILES["new_gambar"]["name"];
    $tempname = $_FILES["new_gambar"]["tmp_name"];
    $folder = "../customer/images/" . $filename;

    if ($id && $nama_produk && $diskon && $harga_asli) {
        $sql = "UPDATE produk SET nama_produk='$nama_produk', diskon='$diskon', harga_asli='$harga_asli', harga_diskon='$harga_diskon'";

        // If there is an uploaded image, include the image update in the query
        if ($filename !== "") {
            $sql .= ", gambar='$filename'";
        }

        $sql .= " WHERE id='$id'";

        $result = mysqli_query($koneksi, $sql);

        if ($result) {
            if ($filename !== "") {
                move_uploaded_file($tempname, $folder);
            }
            header("Location: menuUtama.php");
            exit();
        } else {
            $error = "Gagal memperbarui data";
        }
    } else {
        $error = "Pastikan semua data telah terisi!";
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
</head>

<body>
    <!-- Update product form -->
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary">
                <h2 class='text-center text-white'>Update Data</h2>
            </div>
            <div class="card-body">
                <form action="update.php" method="POST" enctype="multipart/form-data">
                    <!-- Display the current image -->
                    <div class="mb-3">
                        <label for="current_gambar" class="form-label">Gambar Saat Ini:</label>
                        <img src="../customer/images/<?php echo $current_image ?>" alt="Current Product Image"
                            style="max-width: 100px;">
                    </div>
                    <!-- Input to choose a new image -->
                    <div class="mb-3">
                        <label for="new_gambar" class="form-label">Ganti Gambar:</label>
                        <input type="file" name="new_gambar" id="new_gambar">
                    </div>
                    <!-- Input fields for updating data -->
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                            value="<?php echo $nama_produk ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="diskon" class="form-label">Diskon (%)</label>
                        <input type="text" class="form-control" id="diskon" name="diskon"
                            value="<?php echo $diskon ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="harga_asli" class="form-label">Harga Asli</label>
                        <input type="text" class="form-control" id="harga_asli" name="harga_asli"
                            value="<?php echo $harga_asli ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="harga_diskon" class="form-label">Harga Diskon</label>
                        <input type="text" class="form-control" id="harga_diskon" name="harga_diskon"
                            value="<?php echo $harga_diskon ?>" />
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="menuUtama.php"><button type="button" class="btn btn-secondary">Kembali</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to calculate discounted price
        function calculateDiscountedPrice() {
            var discount = parseFloat(document.getElementById('diskon').value);
            var originalPrice = parseFloat(document.getElementById('harga_asli').value);

            // Ensure both values are filled and are numbers
            if (!isNaN(discount) && !isNaN(originalPrice)) {
                // Calculate discounted price
                var discountedPrice = originalPrice - (originalPrice * (discount / 100));

                // Display the result in the discounted price input
                document.getElementById('harga_diskon').value = discountedPrice.toFixed(2);
            }
        }

        // Add event listener to call the function when discount or original price changes
        document.getElementById('diskon').addEventListener('input', calculateDiscountedPrice);
        document.getElementById('harga_asli').addEventListener('input', calculateDiscountedPrice);
    </script>
</body>

</html>
