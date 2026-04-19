<?php
session_start();
include "db.php";
/*  <-- Made by: Ekushey| ID: 1253 -->  */
/* LOGIN CHECK */
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];

/* GET USER */
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    session_destroy();
    header("Location: login.php");
    exit;
}

$user_id = $user['id'];

/* PROFILE UPDATE */
if(isset($_POST['update_profile'])){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];

    $stmt = $conn->prepare("
        UPDATE users SET name=?, address=?, mobile=? WHERE id=?
    ");
    $stmt->bind_param("sssi", $name, $address, $mobile, $user_id);
    $stmt->execute();

    header("Location: user_dashboard.php");
    exit;
}

/* PENDING ORDERS (status = 1) */
$pending = $conn->query("
SELECT c.*, p.name, p.price, p.img
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = $user_id AND c.status = 1
ORDER BY c.id DESC
");

/* ACCEPTED ORDERS (status = 2) */
$accepted = $conn->query("
SELECT c.*, p.name, p.price
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = $user_id AND c.status = 2
ORDER BY c.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>

<style>
body{
 margin:0;
 font-family:Arial;
 background: linear-gradient(135deg, #74ebd5, #f0f8ff);
}

/* NAVBAR (OLD DESIGN RESTORED) */
.navbar{
 background:#3498db;
 padding:15px 30px;
 color:white;
 display:flex;
 justify-content:space-between;
 align-items:center;
 box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

.navbar h1{
 margin:0;
 font-size:28px;
 cursor:pointer;
}

.navbar .menu a{
 color:white;
 margin-left:20px;
 text-decoration:none;
 font-weight:bold;
}

/* CONTAINER */
.container{
 width:90%;
 margin:30px auto;
}

/* SECTIONS (OLD PREMIUM STYLE) */
section{
 background:white;
 padding:25px;
 margin:18px 0;
 border-radius:16px;
 box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

h2{
 margin-top:0;
 color:#2c3e50;
}

/* INPUT */
input{
 width:100%;
 padding:10px;
 margin:6px 0;
 border-radius:10px;
 border:1px solid #ddd;
 outline:none;
}

/* BUTTON */
button{
 padding:10px 15px;
 border:none;
 background:#3498db;
 color:white;
 border-radius:10px;
 cursor:pointer;
 font-weight:bold;
}

/* CART ITEM (OLD STYLE RESTORED) */
.cart-item{
 background: linear-gradient(135deg, #e3f2fd, #ffffff);
 padding:12px;
 margin:8px 0;
 border-radius:10px;
 box-shadow:0 4px 10px rgba(0,0,0,0.05);
 display:flex;
 gap:12px;
 align-items:center;
}

.cart-item img{
 width:70px;
 height:70px;
 object-fit:cover;
 border-radius:8px;
}

/* ORDER LIST */
ul{
 list-style:none;
 padding:0;
}

ul li{
 padding:10px;
 border-bottom:1px solid #eee;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
<h1 onclick="location.href='home.php'">Pet Shop</h1>

<div class="menu">
<a href="home.php">Home</a>
<a href="product_list.php">Products</a>
<a href="cart.php">Cart</a>
<a href="blog.php">Blog</a>
        <a href="about.php">About Us</a>
<a href="logout.php">Logout</a>
</div>
</div>

<div class="container">

<!-- PROFILE -->
<section>
<h2>Profile</h2>

<form method="POST">
<label>Name:</label>
<input type="text" name="name" value="<?= $user['name'] ?>">

<label>Address:</label>
<input type="text" name="address" value="<?= $user['address'] ?? '' ?>">

<label>Mobile:</label>
<input type="text" name="mobile" value="<?= $user['mobile'] ?? '' ?>">

<button type="submit" name="update_profile">Update Profile</button>
</form>
</section>

<!-- PENDING -->
<section>
<h2>Your Cart (Pending)</h2>

<?php if($pending->num_rows == 0): ?>
<p>Cart is empty</p>
<?php endif; ?>

<?php while($p = $pending->fetch_assoc()): ?>
<div class="cart-item">
    <img src="<?= $p['img'] ?>">
    <div>
        <b><?= $p['name'] ?></b><br>
        <?= $p['price'] ?>BDT<br>
        <span style="color:orange;">Pending Approval</span>
    </div>
</div>
<?php endwhile; ?>
</section>

<!-- ACCEPTED -->
<section>
<h2>Your Previous Orders (Accepted)</h2>

<?php if($accepted->num_rows == 0): ?>
<p>No accepted orders yet</p>
<?php endif; ?>

<ul>
<?php while($a = $accepted->fetch_assoc()): ?>
<li>
    <b><?= $a['name'] ?></b> - BDT<?= $a['price'] ?>
    <span style="color:green;"> ✔ Accepted</span>
</li>
<?php endwhile; ?>
</ul>

</section>

</div>

</body>
</html>