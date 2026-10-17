<?php
session_start();
include("db.php");

// ✅ Get place from URL or form
$place = $_POST['place'] ?? $_GET['place'] ?? '';
$error = "";

if(isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {

            // ✅ Login success
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            // ✅ Redirect WITH place
            header("Location: book.php?place=" . urlencode($place));
            exit();

        } else {
            $error = "❌ Wrong password!";
        }

    } else {
        $error = "❌ Username not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Login</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="f1.css"/>
<style>
* {margin:0; padding:0; box-sizing:border-box; font-family:'Roboto', sans-serif;}
body {
    height:100vh;
    background: url('images/mountain.jpg') no-repeat center center/cover;
}
.container {
    background: rgba(255, 255, 255, 0.15); /* transparent */
    backdrop-filter: blur(15px); /* 🔥 blur effect */
    -webkit-backdrop-filter: blur(15px);

    padding:40px;
    border-radius:20px;
    width:400px;
    text-align:center;

    box-shadow:0 8px 32px rgba(0,0,0,0.3);
    border:1px solid rgba(255,255,255,0.3);
}
h2 {
    margin-bottom:20px; 
    font-size:28px;
}
.input-box {
    margin-bottom:15px;
    text-align:left;
}
.input-box input {
    width:100%; 
    padding:12px; 
    border:1px solid #ccc; 
    border-radius:8px; 
    font-size:16px;
}
button {
    width:100%; 
    padding:12px; 
    background-color:#007bff; 
    border:none; 
    color:#fff; 
    font-size:18px;
    border-radius:8px;
    cursor:pointer; 
    transition:0.3s;
}
button:hover {background-color:#0069d9;
}
.error {color:red; 
margin-bottom:15px; 
font-weight:bold;
}
.success {color:green; 
    margin-bottom:15px; 
    font-weight:bold;
}
/* CENTER FORM PROPERLY */
.form-center{
    display:flex;
    justify-content:center;
    align-items:flex-start; /* slightly above center */
    height:100vh;
    padding-top:120px;
}
.links {margin-top:20px;}
.links a {text-decoration:none; color:#28a745;}
.links a:hover {text-decoration:underline;}
@media (max-width:450px) { .container {width:90%; padding:30px;} }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="form-center">
<div class="container">

    <h2>User Login</h2>

    <?php if($error != "") echo "<p class='error'>$error</p>"; ?>

    <form method="POST">

        <!-- ✅ IMPORTANT: place preserve -->
        <input type="hidden" name="place" value="<?php echo htmlspecialchars($place); ?>">

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login">Login</button>

    </form>

    <div class="links">
        <!-- ✅ IMPORTANT FIX: place pass to register -->
        <a href="registration_form.php?place=<?php echo urlencode($place); ?>">
            Don't have an account? Register
        </a>
    </div>

</div>
</div>

</body>
</html>