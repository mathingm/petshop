<?php
include "db.php";
/*  <-- Made by: Mathing | ID: 1163 -->  */
$message = "";

if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $mobile = trim($_POST['mobile']);

    if($name == "" || $email == "" || $password == ""){
        $message = "Please fill required fields";
    } else {

        // check if user exists
        $check = $conn->query("SELECT * FROM users WHERE email='$email'");
        
        if($check->num_rows > 0){
            $message = "Email already registered";
        } else {

            $sql = "INSERT INTO users (name,email,password,address,mobile,role)
                    VALUES ('$name','$email','$password','$address','$mobile','user')";

            if($conn->query($sql)){
                $message = "Registration successful!";
            } else {
                $message = "Error occurred";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Pet Shop</title>

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

.reg-container {
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
    width:380px;
    text-align:center;
}

.reg-container h2 {
    margin-bottom:5px;
    color:#2c3e50;
    font-size:26px;
}

.reg-container p {
    margin-top:0;
    margin-bottom:20px;
    font-size:13px;
    color:#777;
}

.reg-container input {
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:10px;
    border:1px solid #ddd;
    outline:none;
    font-size:14px;
}

.reg-container input:focus {
    border-color:#3498db;
    box-shadow:0 0 5px rgba(52,152,219,0.3);
}

.reg-container button {
    width:100%;
    padding:12px;
    border:none;
    background: linear-gradient(90deg, #3498db, #2e86c1);
    color:white;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
    margin-top:10px;
}

.reg-container a {
    display:block;
    margin-top:15px;
    color:#3498db;
    text-decoration:none;
    font-size:13px;
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

.msg {
    margin-top:10px;
    font-size:13px;
    color:green;
}
</style>
</head>

<body>

<div class="reg-container">

<div class="tag">🐾 Join Pet Family</div>

<h2>Register</h2>
<p>Create your account</p>

<form method="POST">

<input type="text" name="name" placeholder="Full Name">
<input type="email" name="email" placeholder="Email">
<input type="password" name="password" placeholder="Password">
<input type="text" name="address" placeholder="Address">
<input type="text" name="mobile" placeholder="Mobile Number">

<button type="submit" name="register">Register</button>

</form>

<?php if($message != ""): ?>
    <div class="msg"><?php echo $message; ?></div>
<?php endif; ?>

<a href="login.php">Already registered? Login here</a>

</div>

</body>
</html>