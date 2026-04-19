<?php
include "db.php";
session_start();

/* LOGIN CHECK */
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];

/* ADMIN CHECK */
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

if(!$admin || $admin['role'] !== 'admin'){
    die("Access denied");
}

/* USERS */
$users = $conn->query("SELECT id, name, email, role FROM users");

/* PRODUCTS */
$products = $conn->query("SELECT id, name, price FROM products");

/* PENDING ORDERS (status = 1) */
$orders = $conn->query("
SELECT 
c.id,
c.status,
u.name AS user_name,
u.email AS user_email,
p.name AS product_name,
p.price
FROM cart c
JOIN users u ON c.user_id = u.id
JOIN products p ON c.product_id = p.id
WHERE c.status = 1
ORDER BY c.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>

<style>
body{
 margin:0;
 font-family:Arial;
 background: linear-gradient(135deg, #fff3e0, #f0f8ff);
}

/* NAVBAR (OLD DESIGN) */
.navbar{
 background: linear-gradient(90deg, #ff7e5f, #ff512f);
 padding:15px 30px;
 color:white;
 display:flex;
 justify-content:space-between;
 align-items:center;
 position:sticky;
 top:0;
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

.container{
 width:90%;
 margin:30px auto;
}

/* OLD SECTION STYLE */
section{
 background:white;
 padding:25px;
 margin:20px 0;
 border-radius:18px;
 box-shadow:0 12px 30px rgba(0,0,0,0.08);
}

h2{
 margin-top:0;
 color:#2c3e50;
}

/* BUTTON */
button{
 padding:10px 14px;
 border:none;
 background: linear-gradient(90deg, #ff7e5f, #ff512f);
 color:white;
 border-radius:10px;
 cursor:pointer;
}

/* TABLE */
table{
 width:100%;
 border-collapse:collapse;
}

th{
 background:#ff7e5f;
 color:white;
 padding:10px;
}

td{
 padding:10px;
 border-bottom:1px solid #eee;
}

/* ORDER BOX */
.order-box{
 background: linear-gradient(135deg, #fff5f0, #ffffff);
 padding:15px;
 margin:10px 0;
 border-radius:12px;
 display:flex;
 justify-content:space-between;
 align-items:center;
}
</style>
</head>

<body>

<div class="navbar">
<h1 onclick="location.href='home.php'">Pet Shop Admin</h1>
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

<!-- ADD PRODUCT -->
<section>
<h2>Add Product</h2>

<form method="POST" action="add_product.php">
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="description" placeholder="Description">
    <input type="text" name="price" placeholder="Price" required>
    <input type="text" name="img" placeholder="Image URL">
    <button type="submit">Add Product</button>
</form>
</section>

<!-- USERS -->
<section>
<h2>All Users</h2>

<table>
<tr>
<th>Name</th><th>Email</th><th>Role</th>
</tr>

<?php while($u = $users->fetch_assoc()): ?>
<tr>
<td><?= $u['name'] ?></td>
<td><?= $u['email'] ?></td>
<td><?= $u['role'] ?></td>
</tr>
<?php endwhile; ?>
</table>

</section>

<!-- PRODUCTS -->
<section>
<h2>Products</h2>

<table>
<tr>
<th>Name</th><th>Price</th>
</tr>

<?php while($p = $products->fetch_assoc()): ?>
<tr>
<td><?= $p['name'] ?></td>
<td>£<?= $p['price'] ?></td>
</tr>
<?php endwhile; ?>
</table>

</section>

<!-- ORDERS -->
<section>
<h2>Pending Orders</h2>

<?php if($orders->num_rows == 0): ?>
<p>No pending orders</p>
<?php endif; ?>

<?php while($o = $orders->fetch_assoc()): ?>
<div class="order-box">
    <div>
        <b><?= $o['product_name'] ?></b><br>
        <?= $o['user_name'] ?><br>
        BDT<?= $o['price'] ?>
    </div>

    <a href="accept_order.php?id=<?= $o['id'] ?>">
        <button>Accept</button>
    </a>
</div>
<?php endwhile; ?>

</section>

</div>

</body>
</html>