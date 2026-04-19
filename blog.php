<?php
session_start();
include "db.php";
/*  <-- Made by: Rajashree| ID: 1165 -->  */
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
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Care Blog</title>

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
}

.navbar h1{
 margin:0;
 cursor:pointer;
}

.navbar .menu a{
 color:white;
 margin-left:20px;
 text-decoration:none;
 font-weight:bold;
}

/* HEADER */
.header{
 text-align:center;
 padding:60px 20px;
 color:#2c3e50;
}

.header h1{
 font-size:40px;
 margin-bottom:10px;
}

.header p{
 color:#555;
}

/* BLOG GRID */
.container{
 width:90%;
 margin:auto;
 display:grid;
 grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
 gap:25px;
 padding-bottom:50px;
}

/* BLOG CARD */
.card{
 background:white;
 border-radius:16px;
 overflow:hidden;
 box-shadow:0 8px 20px rgba(0,0,0,0.1);
 transition:0.3s;
}

.card:hover{
 transform:translateY(-6px);
}

.card img{
 width:100%;
 height:180px;
 object-fit:cover;
}

.content{
 padding:18px;
}

.content h3{
 margin:0 0 10px;
 color:#2c3e50;
}

.content p{
 font-size:14px;
 color:#555;
 line-height:1.6;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h1 onclick="location.href='home.php'">🐾 Pet Shop</h1>

    <div class="menu">
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

<!-- HEADER -->
<div class="header">
    <h1>Pet Care Tips & Guides</h1>
    <p>Everything you need to keep your pets healthy, happy, and loved</p>
</div>

<!-- BLOG POSTS -->
<div class="container">

<div class="card">
<img src="https://images.unsplash.com/photo-1558788353-f76d92427f16">
<div class="content">
<h3>1. Daily Care for Dogs</h3>
<p>Dogs need regular exercise, proper meals, and attention. Take them for walks daily, maintain a feeding schedule, and ensure they feel emotionally connected.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1518791841217-8f162f1e1131">
<div class="content">
<h3>2. Cat Care Basics</h3>
<p>Cats are independent but still need care. Keep their litter box clean, provide fresh water, and ensure regular vet visits.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1552728089-57bdde30beb3">
<div class="content">
<h3>3. Bird Care Guide</h3>
<p>Birds need a clean cage, balanced diet, and stimulation. Interaction and toys help keep them happy.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1548767797-d8c844163c4c">
<div class="content">
<h3>4. Small Pets (Hamsters)</h3>
<p>Provide a clean cage, proper food, and exercise wheel. Keep them stress-free in a calm environment.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1">
<div class="content">
<h3>5. Choosing the Right Food</h3>
<p>Each pet has different needs. Dogs need protein, cats need taurine, and birds need seeds and fruits.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1601758124510-52d02ddb7cbd">
<div class="content">
<h3>6. Training Your Dog</h3>
<p>Use positive reinforcement and consistency. Basic commands improve behavior and safety.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1533743983669-94fa5c4338ec">
<div class="content">
<h3>7. Grooming Tips</h3>
<p>Brush fur, trim nails, and bathe regularly. Grooming prevents health issues and keeps pets clean.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1583511655857-d19b40a7a54e">
<div class="content">
<h3>8. Exercise Importance</h3>
<p>Daily activity is essential. Lack of exercise can lead to obesity and behavioral problems.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba">
<div class="content">
<h3>9. Pet Health & Vet Visits</h3>
<p>Routine checkups, vaccinations, and parasite control are necessary for long-term health.</p>
</div>
</div>

<div class="card">
<img src="https://images.unsplash.com/photo-1573865526739-10659fec78a5">
<div class="content">
<h3>10. Creating a Safe Home</h3>
<p>Remove harmful items, secure spaces, and ensure pets are safe from toxic foods and hazards.</p>
</div>
</div>

</div>

</body>
</html>