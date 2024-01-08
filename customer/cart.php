<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .d-flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px; /* Sesuaikan nilai sesuai dengan jarak yang diinginkan */
        }

        .product-info {
            width: 60%; /* Sesuaikan lebar sesuai kebutuhan */
        }

        .quantity-container {
            width: 50%; /* Sesuaikan lebar sesuai kebutuhan */
            text-align: right;
            margin-left: 50px;
        }

        .quantity {
            font-size: 16px; /* Sesuaikan nilai sesuai dengan ukuran yang diinginkan */
        }

        .total-harga {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <section class="products" id="products">

        <h1 class="heading"> Keranjang </h1>

        <div class="box-container" style="margin-bottom: 10px;">
            <a href="index.php"><button type="button" class="fas btn">Home</button></a>
            <a href="clear_cart.php"><button type="button" class="fas btn">Clear Cart</button></a>
        </div>

        <div class="box-container">
            <?php
            session_start();
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                echo "<ul>";
                $totalHarga = 0; // Inisialisasi total harga
                foreach ($_SESSION['cart'] as $key => $item) {
                    echo "<li>";
                    $item['quantity'] = 1;

                    echo "<div class='d-flex'>";
                    echo "<div class='product-info'>";
                    echo "<h3>" . $item['nama_produk'] . "</h3>";
                    echo "<h4>Harga: Rp.<span class='harga-diskon' data-key='{$key}'>" . $item['harga_diskon'] . "</span></h4>";
                    echo "</div>";

                    // Tambahkan input jumlah pesanan dan tombol + dan -
                    echo "<div class='quantity-container'>";
                    echo "<input type='number' class='quantity' value='{$item['quantity']}' data-key='{$key}' min='1' onchange='updateQuantity($key)'>";
                    echo "</div>";
                    echo "</div>";

                    // Hitung total harga untuk produk ini dan tambahkan ke totalHarga
                    $subtotal = $item['harga_diskon'] * $item['quantity'];
                    $totalHarga += $subtotal;

                    echo "</li>";
                }
                echo "</ul><br>";

                // Tampilkan total harga di bawah daftar produk
                echo "<div class='total-harga'>Total Harga: Rp.<span id='totalHarga'>" . $totalHarga . "</span></div>";
            } else {
                echo "<h3>Keranjang kosong.</h3>";
            }
            ?>
        </div>
        <a href="#"><button type="button" class="fas btn">Check Out</button></a>


    </section>

    <script>
        function updateQuantity(key) {
            var quantityInput = document.querySelector(`.quantity[data-key="${key}"]`);
            var newQuantity = parseInt(quantityInput.value);

            // Ensure the new quantity is at least 1
            newQuantity = Math.max(newQuantity, 1);

            // Update the input value
            quantityInput.value = newQuantity;

            // You may want to send the updated quantity to the server using AJAX
            updateTotalHarga();
        }

        function updateTotalHarga() {
            var totalHarga = 0;
            var quantityInputs = document.querySelectorAll('.quantity');

            quantityInputs.forEach(function (input) {
                var key = input.getAttribute('data-key');
                var hargaDiskonElement = document.querySelector(`.harga-diskon[data-key="${key}"]`);
                var hargaDiskon = parseFloat(hargaDiskonElement.textContent);

                totalHarga += input.value * hargaDiskon;
            });

            // Tampilkan total harga di bawah daftar produk
            document.getElementById('totalHarga').textContent = totalHarga.toFixed(2);
        }
    </script>

</body>

</html>
