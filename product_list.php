<?php
include "db.php";
session_start();

$result = $conn->query("SELECT * FROM products");

/* USER CHECK */
$email = $_SESSION['user'] ?? null;
$user = null;

if($email){
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Products</title>

<style>
body {
    margin:0;
    font-family:Arial, sans-serif;
    background:linear-gradient(135deg,#f0f8ff,#e6f3ff);
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
.navbar .menu span {
    color:white;
    margin-left:20px;
    text-decoration:none;
    font-weight:bold;
    cursor:pointer;
}

/* FILTER */
.controls {
    display:flex;
    justify-content:center;
    gap:15px;
    margin:25px;
}

.controls input,
.controls select {
    padding:12px;
    width:220px;
    border-radius:10px;
    border:1px solid #ccc;
}

/* GRID */
.container {
    display:grid;
    grid-template-columns: repeat(auto-fill, 220px);
    justify-content:center;
    gap:25px;
    padding:10px 20px 50px;
}

/* CARD */
.card {
    width:220px;
    height:340px;
    background:white;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
    display:flex;
    flex-direction:column;
    cursor:pointer;
}

.card:hover {
    transform:translateY(-6px);
}

.card img {
    width:100%;
    height:160px;
    object-fit:cover;
}

.card h3 {
    margin:10px;
    font-size:16px;
    color:#2c3e50;
}

.card p {
    margin:0 10px;
    font-size:13px;
    color:#666;
    flex:1;
}

.price {
    padding:10px;
    font-weight:bold;
    color:#2c3e50;
    border-top:1px solid #eee;
    text-align:center;
}

.card-link {
    text-decoration:none;
    color:inherit;
}
</style>
</head>

<body>

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

<!-- FILTER -->
<div class="controls">
    <input type="text" id="search" placeholder="Search..." onkeyup="filter()">

    <select id="filter" onchange="filter()">
        <option value="all">All</option>
        <option value="pet">Pets</option>
        <option value="dog">Dogs</option>
        <option value="cat">Cats</option>
        <option value="accessory">Accessories</option>
    </select>
</div>

<!-- PRODUCTS -->
<div class="container">

<?php while($row = $result->fetch_assoc()): ?>

    <a class="card-link" href="product_details.php?id=<?php echo $row['id']; ?>">

        <div class="card"
             data-name="<?php echo strtolower(($row['name'] ?? '') . ' ' . ($row['breed'] ?? '')); ?>"
             data-type="<?php echo strtolower($row['type'] ?? ''); ?>">

            <img src="<?php echo $row['img']; ?>">

            <h3>
                <?php echo $row['breed'] ? $row['breed'] : $row['name']; ?>
            </h3>

            <p><?php echo substr($row['description'], 0, 70); ?>...</p>

            <div class="price">
                <?php echo $row['price']; ?> BDT
            </div>

        </div>
    </a>

<?php endwhile; ?>

</div>

<script>
function filter(){

    let search = document.getElementById("search").value.toLowerCase().trim();
    let type = document.getElementById("filter").value;

    let cards = document.querySelectorAll(".card");

    cards.forEach(card => {

        let name = (card.dataset.name || "").toLowerCase();
        let cardType = (card.dataset.type || "").toLowerCase();

        let matchSearch = name.includes(search);

        let matchType = false;

        if(type === "all"){
            matchType = true;
        }
        else if(type === "pet"){
            matchType = cardType.includes("pet") || cardType.includes("dog") || cardType.includes("cat");
        }
        else if(type === "dog"){
            matchType = name.includes("dog") || name.includes("retriever") || name.includes("bulldog") || cardType.includes("dog");
        }
        else if(type === "cat"){
            matchType = name.includes("cat") || name.includes("persian") || name.includes("siamese") || cardType.includes("cat");
        }
        else if(type === "accessory"){
            matchType = cardType.includes("accessory");
        }

        let parent = card.parentElement;

        if(matchSearch && matchType){
            parent.style.display = "block";
        } else {
            parent.style.display = "none";
        }
    });
}
</script>

</body>
</html>