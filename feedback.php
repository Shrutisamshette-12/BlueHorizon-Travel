<?php

session_start();
include("db.php");
session_start();
include("db.php");

// The customer must be logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username   = $_SESSION['user'];
$booking_id = (int)($_GET['booking'] ?? $_POST['booking'] ?? 0);

$error = "";
$success = false;

// The booking must exist AND belong to the logged-in user
$stmt = $conn->prepare("SELECT id, place, date FROM bookings WHERE id = ? AND username = ?");
$stmt->bind_param("is", $booking_id, $username);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    die("Booking not found for your account.");
}

// Already submitted?
$chk = $conn->prepare("SELECT id FROM feedback WHERE booking_id = ?");
$chk->bind_param("i", $booking_id);
$chk->execute();
$already = $chk->get_result()->num_rows > 0;

if (!$already && isset($_POST['submit_feedback'])) {

    $rating  = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $error = "Please choose a rating from 1 to 5.";
    } else {
        $ins = $conn->prepare(
            "INSERT INTO feedback (booking_id, username, place, rating, comment) VALUES (?, ?, ?, ?, ?)"
        );
        $ins->bind_param("issis", $booking_id, $username, $booking['place'], $rating, $comment);

        if ($ins->execute()) {
            $success = true;
            $already = true;
        } else {
            $error = "Could not save your feedback. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback - BlueHorizon</title>
<link rel="stylesheet" href="f1.css"/>
<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),
               url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e');
    background-size:cover;
    background-position:center;
    min-height:100vh;
}
.wrap{display:flex;justify-content:center;padding:140px 20px 40px;}
.box{
    width:420px;max-width:100%;
    background:rgba(255,255,255,0.12);
    backdrop-filter:blur(18px);
    padding:35px;border-radius:24px;color:white;
    box-shadow:0 10px 40px rgba(0,0,0,0.35);
    border:1px solid rgba(255,255,255,0.18);
}
.box h2{text-align:center;margin-bottom:6px;}
.sub{text-align:center;margin-bottom:22px;color:#ddd;font-size:14px;}
select,textarea{
    width:100%;padding:12px;margin-bottom:16px;border-radius:12px;
    border:1px solid rgba(255,255,255,0.25);
    background:rgba(255,255,255,0.18);color:white;font-size:15px;outline:none;
}
select option{color:#111;}
textarea{resize:none;}
.btn{
    width:100%;padding:14px;border:none;border-radius:14px;cursor:pointer;
    background:linear-gradient(135deg,#ff8c00,#ff5722);color:white;font-size:16px;font-weight:600;
}
.msg-ok{color:#7dffb3;text-align:center;font-weight:600;}
.msg-err{color:#ff8b8b;text-align:center;margin-bottom:12px;font-weight:600;}
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="wrap">
  <div class="box">
    <h2>Trip Feedback ✈️</h2>
    <p class="sub">Your trip to <?php echo htmlspecialchars($booking['place']); ?></p>

    <?php if ($success): ?>
        <p class="msg-ok">✅ Thank you! Your feedback was saved.</p>

    <?php elseif ($already): ?>
        <p class="msg-ok">You have already given feedback for this trip. Thank you!</p>

    <?php else: ?>
        <?php if ($error != "") echo "<p class='msg-err'>" . htmlspecialchars($error) . "</p>"; ?>

        <form method="POST">
            <input type="hidden" name="booking" value="<?php echo (int)$booking_id; ?>">

            <select name="rating" required>
                <option value="">Select rating</option>
                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                <option value="4">⭐⭐⭐⭐ Very good</option>
                <option value="3">⭐⭐⭐ Good</option>
                <option value="2">⭐⭐ Fair</option>
                <option value="1">⭐ Poor</option>
            </select>

            <textarea name="comment" rows="4" placeholder="Tell us about your trip (optional)"></textarea>

            <button type="submit" name="submit_feedback" class="btn">Submit Feedback</button>
        </form>
    <?php endif; ?>
  </div>
</div>

</body>
</html>