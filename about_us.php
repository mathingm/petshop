<?php
session_start();
include "db.php";
/*  <-- Made by: Maroa| ID: 1254 -->  */
/* GET USER IF LOGGED IN */
$user = null;

if(isset($_SESSION['user'])){
    $email = $_SESSION['user'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>About Us</title>

<style>
body{margin:0;font-family:Arial;background:#f4f7fb;}

.navbar{
background:#3498db;
padding:15px 30px;
color:white;
display:flex;
justify-content:space-between;
align-items:center;
}

.navbar a{color:white;margin-left:20px;text-decoration:none;font-weight:bold;}

.section{
width:85%;
margin:30px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

h2{color:#2c3e50;}
p{color:#555;line-height:1.7;}

footer{
background:#3498db;
color:white;
text-align:center;
padding:15px;
margin-top:40px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2 onclick="location.href='home.php'" style="cursor:pointer;">🐾 Pet Shop</h2>

    <div>
        <a href="home.php">Home</a>
        <a href="product_list.php">Products</a>
        <a href="cart.php">Cart</a>
		<a href="blog.php">Blog</a>
        <a href="about_us.php">About Us</a>

        <?php if($user): ?>

            <?php if($user['role'] === 'admin'): ?>
                <a href="admin_dashboard.php">
                    <?= htmlspecialchars($user['name']) ?>
                </a>
            <?php else: ?>
                <a href="user_dashboard.php">
                    <?= htmlspecialchars($user['name']) ?>
                </a>
            <?php endif; ?>

            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.php">Login</a>

        <?php endif; ?>
    </div>
</div>

<div class="section">
<h2>Who We Are</h2>
<p>
Pet Shop is built by passionate animal lovers who believe every pet deserves a safe,
happy, and loving home.
</p>
</div>

<div class="section">
<h2>Our Mission</h2>
<p>
We aim to connect pets with caring owners while providing high-quality pet products,
expert advice, and reliable support.
</p>
</div>

<div class="section">
<h2>What We Offer</h2>
<p>
✔ Pet adoption guidance<br>
✔ Quality pet food and accessories<br>
✔ Educational blog content<br>
✔ Customer support
</p>
</div>

<div class="section">
<h2>Why Choose Us</h2>
<p>
We focus on trust, quality, and care. Our platform is simple, reliable, and designed
for pet lovers.
</p>
</div>

<footer>© 2026 Pet Shop</footer>

</body>
</html>