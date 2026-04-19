<?php
session_start();
include "db.php";
/*  <-- Made by: Mathing | ID: 1163 -->  */
$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if($result->num_rows == 0){
        $error = "User not found";
    } else {

        $user = $result->fetch_assoc();

        if($user['password'] == $pass){

            $_SESSION['user'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == "admin"){
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit;

        } else {
            $error = "Wrong password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>

<style>
body {
    margin:0;
    font-family:Arial, sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg, #74ebd5, #3498db);
}

.box {
    background:white;
    width:380px;
    padding:35px;
    border-radius:18px;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
    text-align:center;
}

.box h2 {
    margin-bottom:5px;
    font-size:26px;
    color:#2c3e50;
}

.box p {
    margin-top:0;
    margin-bottom:20px;
    font-size:13px;
    color:#777;
}

input {
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ddd;
    border-radius:10px;
    outline:none;
    font-size:14px;
}

input:focus {
    border-color:#3498db;
    box-shadow:0 0 5px rgba(52,152,219,0.3);
}

button {
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:10px;
    background: linear-gradient(90deg, #3498db, #2e86c1);
    color:white;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
}

a {
    display:block;
    margin-top:15px;
    font-size:13px;
    color:#3498db;
    text-decoration:none;
}

.tag {
    display:inline-block;
    background:#eaf6ff;
    color:#3498db;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    margin-bottom:15px;
}

.error {
    color:red;
    font-size:13px;
    margin-top:10px;
}
</style>
</head>

<body>

<div class="box">

<div class="tag">🐾 Welcome Back</div>

<h2>Login</h2>
<p>Access your pet shop account</p>

<form method="POST">

<input name="email" placeholder="Email Address">
<input name="password" type="password" placeholder="Password">

<button type="submit" name="login">Login</button>

</form>

<?php if($error != ""): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<a href="reg.php">Create new account</a>

</div>

</body>
</html>