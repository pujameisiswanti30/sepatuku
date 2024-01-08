<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);
    if (isset($_SESSION['cart_message'])) {
        echo "<script>alert('{$_SESSION['cart_message']}');</script>";
        unset($_SESSION['cart_message']); // Hapus pesan dari sesi
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- header section starts  -->

    <header>

        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>

        <a href="#" class="logo">MYShoes</a>

        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#products">Products</a>
            <a href="#review">review</a>
            <a href="#contact">contact</a>
        </nav>

        <div class="icons">
            <a href="#" class="fas fa-heart"></a>
            <a href="cart.php" class="fas fa-shopping-cart"></a>
            <a href="#" class="fas fa-user"></a>
            <a href="logout.php"><button type="button" class="fas btn">Logout</button></a>
            <i class=""></i>
        </div>

    </header>

    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="content">
            <h1> Welcome, <?php echo $user_data['user_name']; ?> </h1>
            <h3> Choose Your Style </h3>
            <span> Choose Your Shoes </span>
            <p>Rahasia Gaya yang Terungkap - Mulai Petualangan Belanja Anda di Sini</p>
            <a href="#" class="btn">Buy Now</a>
        </div>

    </section>

    <!-- home section ends -->

    <!-- about section starts  -->

    <section class="about" id="about">

        <h1 class="heading"> About Us </h1>

        <div class="row">

            <div class="video-container">
                <video src="images/about-vid.mp4" loop autoplay muted></video>
                <h3>HIGH QUALITY</h3>
            </div>

            <div class="content">
                <h3>why choose us?</h3>
                <p>Selamat datang di MYShoes, destinasi terbaik untuk kebutuhan belanja online Anda. Kami adalah pilihan
                    utama pelanggan yang mencari pengalaman berbelanja yang unggul dan layanan yang dapat diandalkan.
                    Berikut adalah alasan mengapa Anda harus memilih kami:</p>
                <p>1. Produk Berkualitas Tinggi</p>
                <p>2. Harga Kompetitif</p>
                <p>3. Diskon dan Penawaran Khusus</p>
                <p>4. Pengiriman Cepat dan Aman</p>
                <a href="#" class="btn">Detail</a>
            </div>

        </div>

    </section>

    <!-- about section ends -->

    <!-- icons section starts  -->

    <section class="icons-container">

        <div class="icons">
            <img src="images/icon-1.png" alt="">
            <div class="info">
                <h3>free delivery</h3>
                <span>on all orders</span>
            </div>
        </div>

        <div class="icons">
            <img src="images/icon-2.png" alt="">
            <div class="info">
                <h3>10 days returns</h3>
                <span>moneyback guarantee</span>
            </div>
        </div>

        <div class="icons">
            <img src="images/icon-3.png" alt="">
            <div class="info">
                <h3>offer & gifts</h3>
                <span>on all orders</span>
            </div>
        </div>

        <div class="icons">
            <img src="images/icon-4.png" alt="">
            <div class="info">
                <h3>secure paymens</h3>
                <span>protected by paypal</span>
            </div>
        </div>

    </section>

    <!-- icons section ends -->

    <!-- prodcuts section starts  -->

    <section class="products" id="products">

        <h1 class="heading"> latest <span>products</span> </h1>

        <div class="box-container" style="margin-bottom: 10px;">
            <input type="text" id="searchInput" placeholder="Search for products">
            <button id="searchButton">Search</button>
        </div>

        <div class="box-container">
            <?php
            $servername = "localhost"; // Ganti dengan nama server database Anda
            $username = "root"; // Ganti dengan username database Anda
            $password = ""; // Ganti dengan password database Anda
            $dbname = "ecommerce"; // Ganti dengan nama database yang sudah Anda buat

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM produk";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Output data dari setiap baris
                while($row = $result->fetch_assoc()) {
                    echo "<div class='box'>";
                    echo "<span class='discount'>-" . $row['diskon'] . "%</span>";
                    echo "<div class='image'>";
                    echo "<img src='images/" . $row['gambar'] . "' alt=''>";
                    echo "<div class='icons'>";
                    echo "<a href='#' class='fas fa-heart'></a>";
                    // echo "<button class='cart-btn' onclick='addToCart({$row['id']})'>Add to Cart</button>";
                    echo "<a href='add_to_cart.php?id={$row['id']}' class='cart-btn' >add to cart</a>";

                    echo "<a href='#' class='fas fa-share'></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='content'>";
                    echo "<h3>" . $row['nama_produk'] . "</h3>";
                    $harga_diskon_real = $row['harga_diskon'];
                    $harga_diskon_terformat = number_format($harga_diskon_real, 0, ',', '.');
                    $harga_asli_real = $row['harga_asli'];
                    $harga_asli_terformat = number_format($harga_asli_real, 0, ',', '.');
                    echo "<div class='price'>Rp." . $harga_diskon_terformat . "<span>Rp." . $harga_asli_terformat . "</span> </div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>

        </div>

    </section>

    <!-- prodcuts section ends -->

    <!-- review section starts  -->

    <section class="review" id="review">

        <h1 class="heading"> customer's <span>review</span> </h1>

        <div class="box-container">

            <div class="box">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p id="ulasan"></p>
                <div class="user">
                    <img src="images/pic-1.png" alt="">
                    <div class="user-info">
                        <h3>Billy Def</h3>
                        <span>happy customer</span>
                    </div>
                </div>
                <span class="fas fa-quote-right"></span>
            </div>

            <div class="box">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p id="ulasan1"></p>
                <div class="user">
                    <img src="images/pic-2.png" alt="">
                    <div class="user-info">
                        <h3>Marsella</h3>
                        <span>happy customer</span>
                    </div>
                </div>
                <span class="fas fa-quote-right"></span>
            </div>

            <div class="box">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p id="ulasan2"></p>
                <div class="user">
                    <img src="images/pic-3.png" alt="">
                    <div class="user-info">
                        <h3>john deo</h3>
                        <span>happy customer</span>
                    </div>
                </div>
                <span class="fas fa-quote-right"></span>
            </div>

        </div>

    </section>

    <script>
        // penerapan ajax pada review
        const xhr = new XMLHttpRequest();

        xhr.open("GET", "data.txt", true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById("ulasan").textContent = xhr.responseText;
                document.getElementById("ulasan1").textContent = xhr.responseText;
                document.getElementById("ulasan2").textContent = xhr.responseText;
            } else {
                document.getElementById("ulasan").textContent = "Gagal mengambil data.";
            }
        };

        xhr.onerror = function () {
            document.getElementById("ulasan").textContent = "Terjadi kesalahan saat mengambil data.";
        };

        xhr.send();
    </script>


    <!-- review section ends -->

    <!-- contact section starts  -->

    <section class="contact" id="contact">

        <h1 class="heading"> <span> contact </span> us </h1>

        <div class="row">

            <form action="">
                <input type="text" placeholder="name" class="box">
                <input type="email" placeholder="email" class="box">
                <input type="number" placeholder="number" class="box">
                <textarea name="" class="box" placeholder="message" id="" cols="30" rows="10"></textarea>
                <input type="submit" value="send message" class="btn">
            </form>

            <div class="image">
                <img src="images/contact-img.JPG" alt="">
            </div>

        </div>

    </section>

    <!-- contact section ends -->

    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>quick links</h3>
                <a href="#home">home</a>
                <a href="#about">about</a>
                <a href="#products">products</a>
                <a href="#review">review</a>
                <a href="#contact">contact</a>
            </div>

            <div class="box">
                <h3>extra links</h3>
                <a href="#">my account</a>
                <a href="#">my order</a>
                <a href="#">my favorite</a>
            </div>

            <div class="box">
                <h3>locations</h3>
                <a href="#">Sleman, DIY Yogyakarta</a>
                <a href="#">Jakarta</a>
                <a href="#">Surabaya</a>
                <a href="#">Medan</a>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="#">0812-8133-2124</a>
                <a href="#">myshoesyourshoes@gmail.com</a>
                <img src="images/payment.png" alt="">
            </div>

        </div>

        <div class="credit"> created by <span> Puja Mei Siswanti </span> | all rights reserved </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/search.js"></script>
    <script src="js/validation.js"></script>
    <script>
        function addToCart(productId) {
            // Lakukan aksi tambahan yang diperlukan, misalnya, tambahkan ke sesi keranjang di sisi klien.
            // Tampilkan notifikasi
            alert("Produk ditambahkan ke keranjang!");
        }
    </script>


</body>

</html>