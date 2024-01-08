<?php
session_start();
include("connection.php");
include("functions.php");

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Ambil data produk dari database berdasarkan $product_id
    $sql = "SELECT * FROM produk WHERE id = $product_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $product_data = $result->fetch_assoc();

        // Tambahkan produk ke dalam sesi keranjang
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Contoh cara menyimpan produk ke dalam sesi
        $_SESSION['cart'][] = array(
            'id' => $product_data['id'],
            'nama_produk' => $product_data['nama_produk'],
            'harga_diskon' => $product_data['harga_diskon'],
            // ... tambahkan informasi lainnya sesuai kebutuhan
        );

        // Tambahkan pesan ke dalam sesi
        $_SESSION['cart_message'] = "Produk telah ditambahkan ke keranjang";
        header("Location: index.php#products");

        // Tidak perlu redirect

        exit();
    }
}
?>
