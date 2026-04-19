
<?php
session_start();
include "db.php";
/*  <-- Made by: Mathing | ID: 1163 -->  */
/* USER SESSION */
$user = null;

if(isset($_SESSION['user'])){
    $email = $_SESSION['user'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}

/* FEATURED PRODUCTS FROM DATABASE  */
$featured = $conn->query("
    SELECT id, name, price, img, breed
    FROM products
    WHERE type='pet'
    ORDER BY id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Shop Home</title>

<style>
body {
    margin:0;
    font-family:Arial, sans-serif;
    background:#f4f7fb;
    color:#1f2d3d;
}

/* NAVBAR */
.navbar {
    background:#3498db;
    padding:15px 30px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.15);
}

.navbar h1 {
    margin:0;
    font-size:28px;
    cursor:pointer;
}

.navbar .menu a,
.navbar .menu button {
    color:white;
    margin-left:20px;
    text-decoration:none;
    font-weight:bold;
    background:none;
    border:none;
    cursor:pointer;
    font-size:16px;
}

/* HERO */
.hero {
    text-align:center;
    color:white;
    padding:90px 20px;
    background:url('https://picsum.photos/1200/400') no-repeat center;
    background-size:cover;
    box-shadow: inset 0 0 0 2000px rgba(0,0,0,0.45);
}

.hero h1 { font-size:52px; }
.hero h3 { font-size:18px; opacity:0.9; }

/* PRODUCTS */
.section-title {
    text-align:center;
    font-size:20px;
    margin:40px 0 20px;
    font-weight:700;
}

.container {
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:22px;
    width:92%;
    margin:0 auto 50px;
}

.card {
    width:220px;
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    cursor:pointer;
    transition:0.25s;
    text-align:center;
}

.card:hover {
    transform: translateY(-6px);
}

.card img {
    width:100%;
    height:150px;
    object-fit:cover;
}

/* INFO */
.info-section {
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:22px;
    width:92%;
    margin:30px auto 50px;
}

.info-card {
    width:220px;
    background:white;
    border-radius:16px;
    padding:22px;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.info-icon { font-size:38px; }

/* CONTACT */
.contact {
    width:92%;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.contact input,
.contact textarea {
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:8px;
}

.contact button {
    padding:12px 16px;
    background:#3498db;
    color:white;
    border:none;
    border-radius:8px;
}

/* FOOTER */
footer {
    background:#3498db;
    color:white;
    padding:20px;
    text-align:center;
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
<!-- HERO -->
<div class="hero">
    <h1>Welcome to Pet Shop 🐾</h1>
    <h3>
        <?php if($user): ?>
            Hello <?= htmlspecialchars($user['name']) ?>
        <?php endif; ?>
    </h3>
</div>

<!-- FEATURED -->
<div class="section-title">Featured Pets</div>

<div class="container">

<?php while($p = $featured->fetch_assoc()): ?>

    <div class="card" onclick="location.href='product_details.php?id=<?= $p['id'] ?>'">
        <img src="<?= $p['img'] ?>">
        <h3><?= $p['breed'] ? $p['breed'] : $p['name'] ?></h3>
        <p><?= $p['price'] ?> BDT</p>
    </div>

<?php endwhile; ?>

</div>

<!-- INFO SECTION  -->
<div class="info-section">

    <div class="info-card">
        <div class="info-icon">🐶</div>
        <h3>Outstanding Customer Care</h3>
        <p>Our team of dedicated pet lovers are here to help with your query!</p>
    </div>

    <div class="info-card">
        <div class="info-icon">🚪</div>
        <h3>Find the Right Pet Door</h3>
        <p>Compare options and choose the best fit for your pet’s comfort.</p>
    </div>

    <div class="info-card">
        <div class="info-icon">🛡️</div>
        <h3>Warranty</h3>
        <p>Register your warranty for peace of mind and long-term support.</p>
    </div>

</div>

<!-- CONTACT -->
<div class="contact">
    <h2>Contact Us</h2>
    <input type="text" placeholder="Your Name">
    <input type="email" placeholder="Email">
    <textarea rows="4" placeholder="Message"></textarea>
    <button>Send</button>
</div>

<footer>
    &copy; 2026 Pet Shop
</footer>

</body>
</html>