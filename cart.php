<?php
session_start();
include "db.php";
/*  <-- Made by: Ekushey| ID: 1253 -->  */
/* SESSION CHECK */
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

/* CART ITEMS */
$stmt = $conn->prepare("
SELECT c.id AS cart_id, p.*
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = ? AND c.status = 1
ORDER BY c.id DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Cart</title>

<style>
body{
 margin:0;
 font-family:Arial;
 background:#f4f7fb;
}

/* NAVBAR */
.navbar{
 background:linear-gradient(90deg,#3498db,#2e86c1);
 padding:15px 30px;
 color:white;
 display:flex;
 justify-content:space-between;
 align-items:center;
 box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

.navbar h1{
 margin:0;
 font-size:24px;
 cursor:pointer;
}

.navbar a{
 color:white;
 margin-left:15px;
 text-decoration:none;
 font-weight:bold;
}

/* CONTAINER */
.container{
 width:85%;
 margin:30px auto;
}

h2{
 color:#2c3e50;
}

/* CART LIST */
.cart-list{
 display:flex;
 flex-direction:column;
 gap:12px;
}

/* CARD */
.card{
 background:white;
 border-radius:12px;
 box-shadow:0 6px 18px rgba(0,0,0,0.06);
 display:flex;
 align-items:center;
 padding:12px;
 gap:15px;
 transition:0.2s;
}

.card:hover{
 transform:translateY(-2px);
}

.card img{
 width:90px;
 height:90px;
 object-fit:cover;
 border-radius:10px;
}

.details{
 flex:1;
}

.name{
 font-weight:bold;
 font-size:16px;
 margin-bottom:5px;
}

.price{
 color:#2c3e50;
 font-weight:bold;
}

.status{
 font-size:12px;
 color:orange;
 margin-top:5px;
}

/* BUTTON */
button{
 padding:7px 12px;
 border:none;
 border-radius:8px;
 background:#e74c3c;
 color:white;
 cursor:pointer;
}

button:hover{
 background:#c0392b;
}

/* EMPTY */
.empty{
 text-align:center;
 padding:40px;
 background:white;
 border-radius:12px;
 box-shadow:0 6px 18px rgba(0,0,0,0.06);
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h1 onclick="location.href='home.php'">Pet Shop</h1>

    <div>
        <a href="home.php">Home</a>
        <a href="product_list.php">Products</a>
        <a href="cart.php">Cart</a>
		<a href="blog.php">Blog</a>
        <a href="about.php">About Us</a>

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

<!-- CONTENT -->
<div class="container">
<h2>My Cart</h2>

<div class="cart-list">

<?php if($result->num_rows == 0): ?>
    <div class="empty">Your cart is empty</div>
<?php endif; ?>

<?php while($item = $result->fetch_assoc()): ?>

<div class="card">

    <img src="<?= $item['img'] ?>">

    <div class="details">
        <div class="name"><?= $item['name'] ?></div>

        <!-- ✅ BDT FIX -->
        <div class="price"><?= $item['price'] ?> BDT</div>

        <?php if(!empty($item['type'])): ?>
            <div>Type: <?= $item['type'] ?></div>
        <?php endif; ?>

        <?php if(!empty($item['breed'])): ?>
            <div>Breed: <?= $item['breed'] ?></div>
        <?php endif; ?>

        <div class="status">Status: Pending Approval</div>
    </div>

    <a href="remove_from_cart.php?id=<?= $item['cart_id'] ?>">
        <button>Remove</button>
    </a>

</div>

<?php endwhile; ?>

</div>
</div>

</body>
</html>