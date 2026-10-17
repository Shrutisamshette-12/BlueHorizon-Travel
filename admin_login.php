<?php
session_start();
include("db.php"); // Make sure this connects to your database

$error = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement for security
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            // Login success
            $_SESSION['admin'] = $admin['username'];
            header("Location: admin_dashboard.php"); // redirect to dashboard
            exit();
        } else {
            $error = "❌ Wrong password!";
        }
    } else {
        $error = "❌ Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login - Travel Agency</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="f1.css"/>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins', sans-serif;}
body{
    height:100vh;
    justify-content:center;
    align-items:center;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e');
    background-size:cover;
    background-position:center;
}
.login-box{
    background: rgba(255,255,255,0.1);
    padding:40px;
    border-radius:15px;
    backdrop-filter: blur(10px);
    width:320px;
    text-align:center;
    box-shadow:0 8px 32px rgba(0,0,0,0.3);
}
.login-box h2{
    color:white;
    margin-bottom:20px;
}
.input-box{
    margin:15px 0;
}
.input-box input{
    width:100%;
    padding:10px;
    border:none;
    outline:none;
    border-radius:5px;
}
button{
    width:100%;
    padding:10px;
    border:none;
    background:orange;
    color:white;
    font-size:16px;
    border-radius:5px;
    cursor:pointer;
    transition:0.3s;
}
button:hover{background:#ff6600;}
/* CENTER ONLY FORM */
.form-center{
    display:flex;
    justify-content:center;
    align-items:flex-start;
    height:100vh;
    padding-top:120px; 
    
}
.note{margin-top:10px;color:#ddd;font-size:12px;}
.error{color:red;margin-bottom:10px;font-weight:bold;}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="form-center">
<div class="login-box">
    <h2>Admin Login</h2>

    <?php if($error != "") echo "<p class='error'>$error</p>"; ?>

    <form method="POST" action="">
        <div class="input-box">
            <input type="text" name="username" placeholder="Enter Username" required>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Enter Password" required>
        </div>

        <button type="submit" name="login">Login</button>
    </form>

    <p class="note">Only authorized admins can access</p>
</div>
</div>
</body>
</html>