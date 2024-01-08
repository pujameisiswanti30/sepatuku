<?php
session_start();

// Hapus semua item dari sesi keranjang
unset($_SESSION['cart']);

// Redirect kembali ke halaman keranjang
header("Location: cart.php");
exit();
?>
