<?php
session_start();
include("db.php");

$place = $_GET['place'] ?? '';
$error = "";

if(isset($_POST['register'])){

    // ✅ Proper username formatting
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // 🔴 Validation
    if($password !== $confirm){
        $error = "❌ Password and Confirm Password do not match!";
    }
    elseif(strlen($password) < 8){
        $error = "❌ Password must be at least 8 characters long!";
    }
    elseif(!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)){
        $error = "❌ Password must contain at least one special character!";
    }
    else{

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Case-insensitive duplicate check
        $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(username)=LOWER(?) OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $error = "❌ Username or Email already exists!";
        } 
        else {

            // ✅ Insert formatted username
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed);

            if($stmt->execute()){
                $_SESSION['user'] = $username;
                header("Location: login.php");
                exit();
            } else {
                $error = "❌ Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Registration</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="f1.css"/>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}

body {
    height: 100vh;
    background: url('images/city.jpg') no-repeat center center/cover;
}

/* CENTER FORM */
.form-center{
    display:flex;
    justify-content:center;
    align-items:flex-start;
    height:100vh;
    padding-top:120px;
}

/* GLASS FORM */
.reg-box {
    background: rgba(255, 255, 255, 0.6);
    padding: 40px;
    backdrop-filter: blur(10px);
    border-radius: 12px;
    width: 400px;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.reg-box h2 {
    margin-bottom: 30px;
    font-size: 26px;
    font-weight: 600;
    letter-spacing: 1px;
}

/* INPUTS */
.input-box {
    margin-bottom: 20px;
    text-align: left;
}

.input-box input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    background-color: #ff5722;
    border: none;
    color: #fff;
    font-size: 18px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #e64a19;
}

/* ERROR */
.error{
    color:red;
    margin-bottom:15px;
    font-weight:bold;
}

/* LINKS */
.links{
    margin-top:15px;
}

.links a{
    text-decoration:none;
    color:#ff5722;
}

.links a:hover{
    text-decoration:underline;
}
</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="form-center">
<div class="reg-box">

<h2>User Registration</h2>

<?php 
if($error != ""){
    echo "<p class='error'>$error</p>";
}
?>

<form method="POST">
    <input type="hidden" name="place" value="<?php echo $place; ?>">

    <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
    </div>

    <div class="input-box">
        <input type="email" name="email" placeholder="Email" required>
    </div>

    <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
    </div>

    <div class="input-box">
        <input type="password" name="confirm" placeholder="Confirm Password" required>
    </div>

    <button type="submit" name="register">Register</button>
</form>

<div class="links">
    <a href="login.php">Already have an account? Login</a>
</div>

<p style="margin-top:15px; font-size:14px; color:#555;">
Password must be at least 8 characters and include at least one special character.
</p>

</div>
</div>

</body>
</html>