<?php
// Sends a "please give feedback" email for trips whose date has passed.
// Only a logged-in admin can run this page (log in via admin_login.php first).

// Sends a "please give feedback" email for trips whose date has passed.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';
include 'db.php';

if (!isset($_SESSION['admin'])) {
    die("Only admins can run this page. Please log in from admin_login.php first.");
}

date_default_timezone_set("Asia/Kolkata");
$today = date("Y-m-d");

// Base address of the site, taken from the current page (works for any folder name)
$siteUrl = "http://" . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// Finished trips that have not been emailed yet. The email comes from the users table.
$stmt = $conn->prepare(
    "SELECT b.id, b.username, b.place, u.email
     FROM bookings b
     JOIN users u ON LOWER(u.username) = LOWER(b.username)
     WHERE b.date < ? AND b.feedback_sent = 0"
);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

$sent = 0;
$failed = 0;

while ($row = $result->fetch_assoc()) {

    $name  = htmlspecialchars($row['username']);
    $place = htmlspecialchars($row['place']);
    $link  = $siteUrl . "/feedback.php?booking=" . (int)$row['id'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USER;
        $mail->Password   = MAIL_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom(MAIL_USER, 'BlueHorizon Travel');
        $mail->addAddress($row['email'], $row['username']);

        $mail->isHTML(true);
        $mail->Subject = "How was your trip to " . $row['place'] . "?";
        $mail->Body = "
            <div style='font-family:Poppins,sans-serif;padding:20px;border-radius:15px;background:#f8f8f8;'>
                <h2 style='color:#ff5722;'>Hello $name,</h2>
                <p>We hope you enjoyed your trip to <b>$place</b>!</p>
                <p>Please take a minute to give us your feedback:</p>
                <p><a href='$link' style='background:#ff8c00;color:#fff;padding:10px 18px;border-radius:8px;text-decoration:none;'>Give Feedback</a></p>
                <p style='color:#777;font-size:12px;'>You need to be logged in to your BlueHorizon account to submit it.</p>
            </div>";

        $mail->send();

        // Mark as sent so the same customer is never emailed twice
        $upd = $conn->prepare("UPDATE bookings SET feedback_sent = 1 WHERE id = ?");
        $upd->bind_param("i", $row['id']);
        $upd->execute();

        $sent++;

    } catch (Exception $e) {
        $failed++;
    }
}

echo "Done. Emails sent: $sent. Failed: $failed.";