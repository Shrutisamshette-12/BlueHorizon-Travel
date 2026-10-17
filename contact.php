<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

$success = "";
$error = "";

if(isset($_POST['send'])){

    $name = htmlspecialchars(ucwords($_POST['name']));

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?: '';

    $subject = htmlspecialchars(ucwords($_POST['subject']));

    $message = nl2br(htmlspecialchars(ucfirst($_POST['message'])));

    $mail = new PHPMailer(true);

    try{

        // SMTP SETTINGS

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = MAIL_USER;

        $mail->Password = MAIL_PASS;

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        // EMAIL SETTINGS

        $mail->setFrom(MAIL_USER, 'BlueHorizon Contact Form');

        $mail->addReplyTo($email, $name);

        $mail->addAddress(MAIL_USER);

        $mail->isHTML(true);

        $mail->Subject = $subject;

        $mail->Body = "

        <div style='
        font-family:Poppins,sans-serif;
        padding:20px;
        border-radius:15px;
        background:#f8f8f8;'>

            <h2 style='color:#ff5722;'>
                📩 New Contact Message
            </h2>

            <p>
                <b>Name:</b> $name
            </p>

            <p>
                <b>Email:</b> $email
            </p>

            <p>
                <b>Subject:</b> $subject
            </p>

            <p>
                <b>Message:</b><br>
                $message
            </p>

        </div>
        ";

        $mail->send();

        $success = "✅ Message Sent Successfully!";

    }catch(Exception $e){

        $error = "❌ Message Failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Contact - BlueHorizon</title>

<link rel="stylesheet" href="f1.css"/>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
html{
    scroll-behavior:smooth;
    overflow-x:hidden;
}

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:url('images/beach.jpg');
    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    overflow-x:hidden;
    position:relative;
}

.contact-wrapper{
    width:100%;
    display:flex;
    justify-content:center;
    padding-top:140px;
    padding-bottom:40px;
    padding-left:20px;
    padding-right:20px;
}

.container{
    width:420px;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(18px);
    padding:35px;
    border-radius:24px;
    box-shadow:0 10px 40px rgba(0,0,0,0.35);
    border:1px solid rgba(255,255,255,0.18);
    transform:none !important;
}

.container h2{
    text-align:center;
    color:white;
    margin-bottom:25px;
    font-size:32px;
    letter-spacing:1px;
}

.input-group{
    margin-bottom:18px;
}

input,
textarea{
    width:100%;
    padding:14px;
    border-radius:14px;
    border:1px solid rgba(255,255,255,0.25);
    background:rgba(255,255,255,0.18);
    color:white;
    font-size:15px;
    outline:none;
    transition:0.3s;
    backdrop-filter:blur(8px);
}

input::placeholder,
textarea::placeholder{
    color:rgba(255,255,255,0.7);
}

input:focus,
textarea:focus{
    border-color:#ffb347;
    box-shadow:0 0 15px rgba(255,179,71,0.35);
    background:rgba(255,255,255,0.22);
}

textarea{
    resize:none;
}

.btn{
    width:100%;
    margin-top:10px;
    padding:14px;
    background:linear-gradient(135deg,#ff8c00,#ff5722);
    border:none;
    color:white;
    font-size:16px;
    font-weight:600;
    border-radius:14px;
    cursor:pointer;
    transition:0.35s;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(255,140,0,0.4);
}

.success{
    color:#7dffb3;
    text-align:center;
    margin-bottom:15px;
    font-weight:600;
}

.error{
    color:#ff8b8b;
    text-align:center;
    margin-bottom:15px;
    font-weight:600;
}

@media(max-width:500px){

    .container{
        width:100%;
        padding:28px;
    }

    .container h2{
        font-size:28px;
    }
}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="contact-wrapper">

    <div class="container">

        <h2>Contact Us ✈️</h2>

        <?php
        if($success != ""){
            echo "<p class='success'>$success</p>";
        }

        if($error != ""){
            echo "<p class='error'>$error</p>";
        }
        ?>

        <form method="POST">

            <div class="input-group">

                <input type="text"
                       name="name"
                       placeholder="Full Name"
                       required>

            </div>

            <div class="input-group">

                <input type="email"
                       name="email"
                       placeholder="Email Address"
                       required>

            </div>

            <div class="input-group">

                <input type="text"
                       name="subject"
                       placeholder="Subject"
                       required>

            </div>

            <div class="input-group">

                <textarea name="message"
                          rows="5"
                          placeholder="Your Message"
                          required></textarea>

            </div>

            <button type="submit"
                    name="send"
                    class="btn">

                Send Message 🚀

            </button>

        </form>

    </div>

</div>

</body>
</html>