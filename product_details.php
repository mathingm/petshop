<?php
include "db.php";
session_start();
/*  <-- Made by: Maroa| ID: 1254 -->  */
/* LOGIN CHECK */
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];

/* USER */
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$user_id = $user['id'];

/* PRODUCT ID */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* GET PRODUCT */
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if(!$product){
    die("Product not found");
}

/* ===================== ADD TO CART ===================== */
if(isset($_POST['add_to_cart'])){

    // avoid duplicate cart spam
    $check = $conn->prepare("
        SELECT id FROM cart 
        WHERE user_id=? AND product_id=? AND status=1
    ");
    $check->bind_param("ii", $user_id, $id);
    $check->execute();
    $exists = $check->get_result()->fetch_assoc();

    if(!$exists){
        $stmt = $conn->prepare("
            INSERT INTO cart (user_id, product_id, status)
            VALUES (?, ?, 1)
        ");
        $stmt->bind_param("ii", $user_id, $id);
        $stmt->execute();
    }

    header("Location: cart.php");
    exit;
}

/* ===================== RATING SUBMIT ===================== */
if(isset($_POST['rating'])){
    $rating = (int)$_POST['rating'];

    if($rating < 1 || $rating > 5){
        die("Invalid rating");
    }

    $stmt = $conn->prepare("
        INSERT INTO product_ratings (product_id, user_id, rating)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE rating = VALUES(rating)
    ");
    $stmt->bind_param("iii", $id, $user_id, $rating);
    $stmt->execute();

    header("Location: product_details.php?id=".$id);
    exit;
}

/* ===================== GET RATING ===================== */
$avgQ = $conn->query("
    SELECT 
        IFNULL(AVG(rating),0) as avg_rating,
        COUNT(*) as total
    FROM product_ratings
    WHERE product_id = $id
")->fetch_assoc();

$avg = round($avgQ['avg_rating'], 1);
$total = $avgQ['total'];

/* USER RATING */
$userRatingQ = $conn->query("
    SELECT rating FROM product_ratings
    WHERE product_id=$id AND user_id=$user_id
")->fetch_assoc();

$userRating = $userRatingQ['rating'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Product Details</title>

<style>
body{
 margin:0;
 font-family:Arial;
 background:linear-gradient(135deg,#f0f8ff,#e6f3ff);
}

/* NAVBAR */
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
 cursor:pointer;
}

.navbar .menu a,
.navbar .menu span{
 color:white;
 margin-left:20px;
 text-decoration:none;
 font-weight:bold;
}

/* LAYOUT */
.container{
 display:flex;
 justify-content:center;
 padding:40px;
}

/* CARD */
.card{
 width:500px;
 background:white;
 border-radius:18px;
 overflow:hidden;
 box-shadow:0 12px 30px rgba(0,0,0,0.15);
}

.card img{
 width:100%;
 height:280px;
 object-fit:cover;
}

.content{
 padding:20px;
}

.tag{
 display:inline-block;
 padding:5px 12px;
 border-radius:20px;
 font-size:12px;
 background:#eaf2ff;
 color:#3498db;
 margin-bottom:10px;
}

h2{
 margin:5px 0 10px;
}

.info-grid{
 display:grid;
 grid-template-columns:1fr 1fr;
 gap:10px;
}

.info-box{
 background:#f7fbff;
 padding:10px;
 border-radius:10px;
 font-size:13px;
}

.price{
 margin-top:15px;
 font-size:22px;
 font-weight:bold;
 color:#3498db;
}

/* BUTTON */
button{
 width:100%;
 padding:12px;
 margin-top:15px;
 background:#3498db;
 border:none;
 color:white;
 border-radius:12px;
 cursor:pointer;
}

button:hover{
 background:#2e86c1;
}

/* RATING */
.rating{
 margin-top:15px;
}

.stars{
 display:flex;
 gap:5px;
 font-size:26px;
}

.stars button{
 background:none;
 border:none;
 cursor:pointer;
 font-size:26px;
 color:#ccc;
}

.stars button.active{
 color:#f1c40f;
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

        <?php if($user): ?>

            <?php if($user['role'] === 'admin'): ?>
                <a href="admin_dashboard.php"><?= htmlspecialchars($user['name']) ?></a>
            <?php else: ?>
                <a href="user_dashboard.php"><?= htmlspecialchars($user['name']) ?></a>
            <?php endif; ?>

            <a href="logout.php">Logout</a>

        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>

    </div>
</div>
<div class="container">

<div class="card">

    <img src="<?= $product['img'] ?>">

    <div class="content">

        <span class="tag"><?= $product['type'] ?? 'item' ?></span>

        <h2><?= $product['name'] ?></h2>

        <div class="info-grid">
            <div class="info-box"><b>Description</b><br><?= $product['description'] ?></div>
            <div class="info-box"><b>Breed</b><br><?= $product['breed'] ?? 'N/A' ?></div>
            <div class="info-box"><b>Food</b><br><?= $product['food'] ?? 'N/A' ?></div>
            <div class="info-box"><b>Trained</b><br><?= !empty($product['trained']) ? 'Yes' : 'No' ?></div>
        </div>

        <div class="price"><?= $product['price'] ?> BDT</div>

        <!-- ⭐ ADD TO CART BUTTON (FIXED) -->
        <form method="POST">
            <button type="submit" name="add_to_cart">
                Buy / Adopt
            </button>
        </form>

        <!-- RATING SYSTEM -->
        <div class="rating">
            <form method="POST">
                <div class="stars">
                    <?php for($i=1;$i<=5;$i++): ?>
                        <button name="rating" value="<?= $i ?>"
                        class="<?= ($i <= $userRating) ? 'active' : '' ?>">
                            ★
                        </button>
                    <?php endfor; ?>
                </div>
            </form>

            <p style="font-size:13px;color:#555;">
                Avg Rating: <?= $avg ?> ⭐ | <?= $total ?> reviews
            </p>
        </div>

    </div>
</div>

</div>

</body>
</html>